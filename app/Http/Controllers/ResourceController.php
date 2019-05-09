<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Models\Resource;
use App\Models\ResourceDetail;
use App\Models\ResourceTrx;
use App\Models\Project;
use App\Models\WBS;
use App\Models\Uom;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Configuration;
use App\Models\GoodsIssue;
use App\Models\GoodsIssueDetail;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptDetail;
use App\Models\ProductionOrder;
use App\Models\ProductionOrderDetail;
use DateTime;
use Auth;
use DB;

class ResourceController extends Controller
{
    protected $GR;

    public function __construct(GoodsReceiptController $GR)
    {
        $this->GR = $GR;
    }

    public function index(Request $request)
    {
        $route = $request->route()->getPrefix();
        $resources = Resource::all();

        return view('resource.index', compact('resources','route'));
    }

    public function assignResource(Request $request)
    {
        $route = $request->route()->getPrefix();
        if($route == "/resource"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == "/resource_repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get();
        }
        $resources = Resource::all();
        $resource_categories = Configuration::get('resource_category');
        foreach($resource_categories as $key => $rc){
            if($rc->id == 0){
                unset($resource_categories[$key]);
            }
        }
        rsort($resource_categories);
        $operation_hours = Configuration::get('operation_hours');
        $resourceDetails = ResourceDetail::where('status','!=',0)->get()->jsonSerialize();
        
        return view('resource.assignResource', compact('resourceDetails','resource_categories','resources','modelProject','route','operation_hours'));
    }

    public function create(Request $request)
    {
        $route = $request->route()->getPrefix();
        $resource = new Resource;
        $resource_code = self::generateResourceCode();

        return view('resource.create', compact('resource', 'resource_code','route'));
    }

    public function store(Request $request)
    {
        $data = json_decode($request->datas);
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try {
            $resource = new Resource;
            $resource->code = strtoupper($data->code);
            $resource->name = ucwords($data->name);
            $resource->description = $data->description;
            if($data->cost_standard_price != null || $data->cost_standard_price != ""){
                $resource->cost_standard_price = $data->cost_standard_price;
            }else{
                $resource->cost_standard_price = 0;
            }
            $resource->user_id = Auth::user()->id;
            $resource->branch_id = Auth::user()->branch->id;
            $resource->save();


            DB::commit();
            if($route == "/resource"){
                return redirect()->route('resource.show',$resource->id)->with('success', 'Success Created New Resource!');
            }elseif($route == "/resource_repair"){
                return redirect()->route('resource_repair.show',$resource->id)->with('success', 'Success Created New Resource!');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/resource"){
                return redirect()->route('resource.create')->with('error', $e->getMessage());
            }elseif($route == "/resource_repair"){
                return redirect()->route('resource_repair.create')->with('error', $e->getMessage());
            }
        }
    }

    public function selectPO(Request $request)
    {
        $route = $request->route()->getPrefix();
        if($route == "/resource"){
            $modelPR = PurchaseRequisition::where('business_unit_id',1)->pluck('id')->toArray();
        }else if($route == "/resource_repair"){
            $modelPR = PurchaseRequisition::where('business_unit_id',2)->pluck('id')->toArray();
        }
        $modelPOs = PurchaseOrder::where('status',2)->whereIn('purchase_requisition_id',$modelPR)->get();

        foreach($modelPOs as $key => $PO){
            if($PO->purchaseRequisition->type != 2){
                $modelPOs->forget($key);
            }
        }
        
        return view('resource.selectPO', compact('modelPOs','route'));
    }

    public function createGR(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $resource_categories = Configuration::get('resource_category');
        $depreciation_methods = Configuration::get('depreciation_methods');
        $modelPO = PurchaseOrder::where('id',$id)->with('vendor')->first();
        $modelPODs = PurchaseOrderDetail::where('purchase_order_id',$modelPO->id)->whereColumn('received','!=','quantity')->get();
        $uom = Uom::all();
        $datas = Collection::make();
        
        foreach($modelPODs as $POD){
            $quantity = $POD->quantity - $POD->received;
            for ($i=0; $i < $quantity; $i++) { 
                $datas->push([
                    "pod_id" => $POD->id,
                    "resource_id" => $POD->resource->id, 
                    "resource_code" => $POD->resource->code,
                    "resource_name" => $POD->resource->name,
                    "quantity" => 1,
                    "status" => "Detail Not Complete",
                    ]);
                }
            }
        return view('resource.createGR', compact('modelPO','datas','resource_categories','uom','depreciation_methods','route'));
    }

    public function storeGR(Request $request){
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $gr_number = $this->GR->generateGRNumber();
        $vendor_id = PurchaseOrder::find($datas->po_id)->vendor->id;
        DB::beginTransaction();
        try {
            $GR = new GoodsReceipt;
            $GR->number = $gr_number;
            if($route == "/resource"){
                $GR->business_unit_id = 1;                
            }elseif($route == "/resource_repair"){
                $GR->business_unit_id = 2;
            }
            $GR->purchase_order_id = $datas->po_id;
            $GR->vendor_id = $vendor_id;
            $GR->type = 4;
            $GR->description = $datas->description;
            $GR->branch_id = Auth::user()->branch->id;
            $GR->user_id = Auth::user()->id;
            $GR->save();

            foreach($datas->resources as $data){
                $RD = new ResourceDetail;
                $RD->code = $data->code;
                $RD->resource_id = $data->resource_id;
                $RD->vendor_id = $vendor_id;
                $RD->category_id = $data->category_id;
                $RD->description = $data->description;
                $RD->performance = ($data->performance != '') ? $data->performance : null;
                $RD->performance_uom_id = ($data->performance_uom_id != '') ? $data->performance_uom_id : null;
                $RD->lifetime_uom_id = ($data->lifetime_uom_id != '') ? $data->lifetime_uom_id : null;
                if($RD->lifetime_uom_id != null){
                    if($data->lifetime != ''){
                        if($RD->lifetime_uom_id == 1){
                            $RD->lifetime = $data->lifetime * 8;
                        }elseif($RD->lifetime_uom_id == 2){
                            $RD->lifetime = $data->lifetime * 8 * 30;
                        }elseif($RD->lifetime_uom_id == 3){
                            $RD->lifetime = $data->lifetime * 8 * 365;
                        }
                    }
                }

                if($data->category_id == 1){
                    $RD->sub_con_address = $data->sub_con_address;
                    $RD->sub_con_phone = $data->sub_con_phone;
                    $RD->sub_con_competency = $data->sub_con_competency;
                }elseif($data->category_id == 2){
                    $RD->others_name = $data->name;
                }elseif($data->category_id == 3){
                    $RD->brand = $data->brand;
                }elseif($data->category_id == 4){
                    $RD->brand = $data->brand;
                    $RD->depreciation_method = $data->depreciation_method;
                    if($data->manufactured_date != ""){
                        $manufactured_date = DateTime::createFromFormat('m/j/Y', $data->manufactured_date);
                        $RD->manufactured_date = $manufactured_date->format('Y-m-d');
                    }
                    if($data->purchasing_date != ""){
                        $purchasing_date = DateTime::createFromFormat('m/j/Y', $data->purchasing_date);
                        $RD->purchasing_date = $purchasing_date->format('Y-m-d');
                    }
                    $RD->purchasing_price = ($data->purchasing_price != '') ? $data->purchasing_price : null;
                    $RD->cost_per_hour = ($data->cost_per_hour != '') ? $data->cost_per_hour : null;
                }
                $RD->save();

                $GRD = new GoodsReceiptDetail;
                $GRD->goods_receipt_id = $GR->id;
                $GRD->quantity = 1;
                $GRD->resource_detail_id = $RD->id;
                $GRD->item_OK = 1;
                $GRD->save();

                $this->GR->updatePOD($data->pod_id,1);
            }
            $this->GR->checkStatusPO($datas->po_id);
            DB::commit();
            if($route == "/resource"){
                return redirect()->route('resource.showGR',$GR->id)->with('success', 'Goods Receipt Created');
            }elseif($route == "/resource_repair"){
                return redirect()->route('resource_repair.showGR',$GR->id)->with('success', 'Goods Receipt Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/resource"){
                return redirect()->route('resource.selectPO',$datas->po_id)->with('error', $e->getMessage());
            }elseif($route == "/resource_repair"){
                return redirect()->route('resource_repair.selectPO',$datas->po_id)->with('error', $e->getMessage());
            }
        }
    }

    public function showGR(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelGR = GoodsReceipt::findOrFail($id);
        $modelGRD = $modelGR->GoodsReceiptDetails ;

        if($modelGRD[0]->material_id != ''){
            // return view('goods_receipt.show', compact('modelGR','modelGRD','route'));
        }elseif($modelGRD[0]->resource_detail_id != ''){
            return view('resource.showGR', compact('modelGR','modelGRD','route'));
        }
    }

    public function showGI(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelGI = GoodsIssue::findOrFail($id);
        $modelGID = $modelGI->GoodsIssueDetails;

        return view('resource.showGI', compact('modelGI','modelGID','route'));
    }

    public function indexReceived(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelGRs = GoodsReceipt::all();
        foreach($modelGRs as $key => $GR){
            if($GR->purchaseOrder->purchaseRequisition->type != 2){
                $modelGRs->forget($key);
            }
        }

        return view('resource.indexReceived', compact('modelGRs','route'));
    }

    public function indexIssued(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelGIs = GoodsIssue::where('type', 2)->get();

        return view('resource.indexIssued', compact('modelGIs','route'));
    }

    public function issueResource(Request $request)
    {
        $route = $request->route()->getPrefix();
        $resources = Resource::all();
        
        return view('resource.issue', compact('route','resources'));
    }

    public function storeIssue(Request $request){
        $route = $request->route()->getPrefix();
        $data = json_decode($request->datas);
        $gi_number = $this->generateGINumber();

        DB::beginTransaction();
        try {
            $GI = new GoodsIssue;
            $GI->number = $gi_number;
            if($route == '/resource'){
                $business_unit = 1;
            }elseif($route == '/resource_repair'){
                $business_unit = 2;
            }
            $GI->business_unit_id = $business_unit;
            $GI->type = 2;
            $GI->description = $data->description;
            $GI->branch_id = Auth::user()->branch->id;
            $GI->user_id = Auth::user()->id;
            $GI->save();
            foreach($data->resources as $resource_detail){
                $resource_detail_ref = ResourceDetail::find($resource_detail->resource_detail_id);
                $resource_detail_ref->status = 0;
                $resource_detail_ref->update();

                $GID = new GoodsIssueDetail;
                $GID->goods_issue_id = $GI->id;
                $GID->quantity = 1;
                $GID->resource_detail_id = $resource_detail->resource_detail_id;
                $GID->save();
            }
            
            DB::commit();
            if($route == "/resource"){
                return redirect()->route('resource.showGI',$GI->id)->with('success', 'Resource Issued');
            }elseif($route == "/resource_repair"){
                return redirect()->route('resource_repair.showGI',$GI->id)->with('success', 'Resource Issued');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/resource"){
                return redirect()->route('resource.issueResource')->with('error', $e->getMessage());
            }elseif($route == "/resource_repair"){
                return redirect()->route('resource_repair.issueResource')->with('error', $e->getMessage());
            }
        }
    }

    public function storeResourceDetail(Request $request, $wbs_id)
    {
        $route = $request->route()->getPrefix();
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $wbs = WBS::find($wbs_id);
            $resourceDetailWbs = $wbs->resourceDetails;
            if(count($resourceDetailWbs)>0){
                foreach ($resourceDetailWbs as $resourceDetail) {
                    $resourceDetail->delete();
                }
            }

            $categoryFromResource = [];
            foreach($data['dataResources'] as $detail){
                
                $resource = Resource::find($detail['resource_id']);
                array_push($categoryFromResource, $resource->category->id);

                $resourceDetail = new ResourceDetail;
                $resourceDetail->resource_id = $detail['resource_id'];
                $resourceDetail->project_id = $wbs->project->id;
                $resourceDetail->wbs_id = $wbs->id;
                $resourceDetail->category_id = $resource->category->id;
                $resourceDetail->quantity = $detail['quantityInt'];
                $resourceDetail->save();
            }

            array_unique($categoryFromResource);

            foreach($data['selected_resource_category'] as $category){
                if(in_array($category, $categoryFromResource) != true){
                    $resourceDetail = new ResourceDetail;
                    $resourceDetail->project_id = $wbs->project->id;
                    $resourceDetail->wbs_id = $wbs->id;
                    $resourceDetail->category_id = $category;
                    $resourceDetail->save();
                }
            }


            DB::commit();
            return response(["response"=>"Success to assign resource "],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function show(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $resource = Resource::findOrFail($id);
        $modelRD = ResourceDetail::where('resource_id',$id)->with('goodsReceiptDetail.goodsReceipt.purchaseOrder','performanceUom','productionOrderDetails.productionOrder.wbs','productionOrderDetails.performanceUom','productionOrderDetails.resourceDetail')->get()->jsonSerialize();
        $depreciation_methods = Configuration::get('depreciation_methods');
        $resource_categories = Configuration::get('resource_category');
        $uom = Uom::all();
        
        return view('resource.show', compact('resource','modelRD','route','depreciation_methods','resource_categories','uom'));
    }

    public function updateDetail(Request $request)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $modelRD = ResourceDetail::findOrFail($data['resource_detail_id']);
            $modelRD->description = $data['description'];
            $modelRD->performance = ($data['performance'] != '') ? $data['performance'] : null;
            $modelRD->performance_uom_id = ($data['performance_uom_id'] != '') ? $data['performance_uom_id'] : null;
            $modelRD->lifetime_uom_id = ($data['lifetime_uom_id'] != '') ? $data['lifetime_uom_id'] : null;
            if($modelRD->lifetime_uom_id != null){
                if($data['lifetime'] != ''){
                    if($modelRD->lifetime_uom_id == 1){
                        $modelRD->lifetime = $data['lifetime'] * 8;
                    }elseif($modelRD->lifetime_uom_id == 2){
                        $modelRD->lifetime = $data['lifetime'] * 8 * 30;
                    }elseif($modelRD->lifetime_uom_id == 3){
                        $modelRD->lifetime = $data['lifetime'] * 8 * 365;
                    }
                }
            }
            if($data['lifetime_uom_id'] == '' || $data['lifetime'] == ''){
                $modelRD->lifetime = null;
                $modelRD->lifetime_uom_id = null;
            }
            if($data['category_id'] == 1){
                $modelRD->sub_con_address = $data['sub_con_address'];
                $modelRD->sub_con_phone = $data['sub_con_phone'];
                $modelRD->sub_con_competency = $data['sub_con_competency'];
            }else if($data['category_id'] == 2){
                $modelRD->others_name = $data['name'];
            }else if($data['category_id'] == 3){
                $modelRD->brand = $data['brand'];
            }else if($data['category_id'] == 4){
                $modelRD->brand = $data['brand'];
                $modelRD->depreciation_method = $data['depreciation_method'];
                if($data['manufactured_date'] != ""){
                    if($data['manufactured_date'] != $modelRD->manufactured_date){
                        $manufactured_date = DateTime::createFromFormat('m/j/Y', $data['manufactured_date']);
                        $modelRD->manufactured_date = $manufactured_date->format('Y-m-d');
                    }
                }
                if($data['purchasing_date'] != ""){
                    if($data['purchasing_date'] != $modelRD->purchasing_date){
                        $purchasing_date = DateTime::createFromFormat('m/j/Y', $data['purchasing_date']);
                        $modelRD->purchasing_date = $purchasing_date->format('Y-m-d');
                    }
                }
                $modelRD->purchasing_price = ($data['purchasing_price'] != '') ? $data['purchasing_price'] : null;
                $modelRD->cost_per_hour = ($data['cost_per_hour'] != '') ? $data['cost_per_hour'] : null;
                $modelRD->serial_number = ($data['serial_number'] != '') ? $data['serial_number'] : null;
                $modelRD->quantity = ($data['quantity'] != '') ? $data['quantity'] : null;
                $modelRD->kva = ($data['kva'] != '') ? $data['kva'] : null;
                $modelRD->amp = ($data['amp'] != '') ? $data['amp'] : null;
                $modelRD->volt = ($data['volt'] != '') ? $data['volt'] : null;
                $modelRD->phase = ($data['phase'] != '') ? $data['phase'] : null;
                $modelRD->length = ($data['length'] != '') ? $data['length'] : null;
                $modelRD->width = ($data['width'] != '') ? $data['width'] : null;
                $modelRD->height = ($data['height'] != '') ? $data['height'] : null;
                $modelRD->manufactured_in = ($data['manufactured_in'] != '') ? $data['manufactured_in'] : null;
            }

            if(!$modelRD->update()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Resource Detail Updated"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function edit(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $resource = Resource::findOrFail($id);

        return view('resource.edit', compact('resource','route'));
    }

    public function update(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $data = json_decode($request->datas);
        DB::beginTransaction();
        try {
            $resource = Resource::find($id);
            $resource->code = strtoupper($data->code);
            $resource->name = ucwords($data->name);
            $resource->description = $data->description;
            if($data->cost_standard_price != null || $data->cost_standard_price != ""){
                $resource->cost_standard_price = $data->cost_standard_price;
            }else{
                $resource->cost_standard_price = 0;
            }
            $resource->update();

            DB::commit();
            if($route == "/resource"){
                return redirect()->route('resource.show',$resource->id)->with('success', 'Resource Updated Succesfully');
            }elseif($route == "/resource_repair"){
                return redirect()->route('resource_repair.show',$resource->id)->with('success', 'Resource Updated Succesfully');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/resource"){
                return redirect()->route('resource.update',$resource->id)->with('error', $e->getMessage());
            }elseif($route == "/resource_repair"){
                return redirect()->route('resource_repair.update',$resource->id)->with('error', $e->getMessage());
            }
        }
    }

    public function updateAssignResource (Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $data = $request->json()->all();
        $resource_ref = ResourceTrx::findOrFail($id);

        DB::beginTransaction();
        try {
            $resource_ref->resource_id = $data['resource_id'];
            $resource_ref->wbs_id = $data['wbs_id'];
            $resource_ref->quantity = $data['quantity'];
            if($data['category_id'] == 4){
                if($data['resource_detail_id'] != "" && $data['resource_detail_id'] != null){
                    $resource_ref->resource_detail_id = $data['resource_detail_id'];
                    if($data['start_date'] != "" && $data['start_date'] != null && $data['end_date'] != "" && $data['end_date'] != null){
                        $resource_ref->start_date = $data['start_date'];
                        $resource_ref->end_date = $data['end_date'];
                    }else{
                        $resource_ref->start_date = null;
                        $resource_ref->end_date = null;
                    }
                }else{
                    $resource_ref->resource_detail_id = null;
                    $resource_ref->start_date = null;
                    $resource_ref->end_date = null;
                }
            }

            if(!$resource_ref->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update Assign Resource ".$resource_ref->code],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeAssignResource(Request $request)
    {
        $route = $request->route()->getPrefix();
        $data = $request->json()->all();
        
        DB::beginTransaction();
        try {
            $resource = new ResourceTrx;
            $resource->category_id = $data['category_id'];
            $resource->resource_id = $data['resource_id'];
            if($data['resource_detail_id'] != ''){
                $resource->resource_detail_id = $data['resource_detail_id'];
            }
            $resource->project_id = $data['project_id'];
            $resource->wbs_id = $data['wbs_id'];
            $resource->quantity = $data['quantity'];
            if($data['start_date'] != ''){
                $resource->start_date = $data['start_date'];
            }
            if($data['end_date'] != ''){
                $resource->end_date = $data['end_date'];
            }
            $resource->user_id = Auth::user()->id;
            $resource->branch_id = Auth::user()->branch->id;

            $ProdOrder = ProductionOrder::where('wbs_id',$data['wbs_id'])->where('status',1)->first();
            if($ProdOrder){
                $existing = ProductionOrderDetail::where('production_order_id',$ProdOrder->id)->where('resource_id' , $data['resource_id'])->first();
                if($existing != null){
                    $existing->quantity += $data['quantity'];
                    $existing->update();
                }else{
                    $PrOD = new ProductionOrderDetail;
                    $PrOD->production_order_id = $ProdOrder->id;
                    $PrOD->resource_id = $data['resource_id'];
                    $PrOD->category_id = $data['category_id'];
                    $PrOD->quantity = $data['quantity'];
                    $PrOD->save();
                }
            }

            if(!$resource->save()){
                return response($ProdOrder,Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to assign resource"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function resourceSchedule(Request $request){
        $route = $request->route()->getPrefix();
        $resources = Resource::all();
        $resourceDetail = ResourceDetail::where('category_id',4)->get();

        return view('resource.resourceSchedule', compact('route','resources','resourceDetail'));        
    }

    public function createInternal(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $resource = Resource::findOrFail($id);
        $resource_detail_code = self::generateCodeInternal($resource->code);
        $depreciation_methods = Configuration::get('depreciation_methods');
        $uom = Uom::all();
        
        return view('resource.createInternal', compact('resource','resource_detail_code','depreciation_methods','uom','route'));        
    }

    public function storeInternal(Request $request){
        $route = $request->route()->getPrefix();
        $data = json_decode($request->datas);

        DB::beginTransaction();
        try {

                $RD = new ResourceDetail;
                $RD->code = $data->code;
                $RD->resource_id = $data->resource_id;
                $RD->serial_number = $data->serial_number;
                $RD->category_id = 4;
                $RD->quantity = ($data->quantity != '') ? $data->quantity : 1;
                $RD->description = $data->description;
                $RD->kva = ($data->kva != '') ? $data->kva : null;
                $RD->amp = ($data->amp != '') ? $data->amp : null;
                $RD->volt = ($data->volt != '') ? $data->volt : null;
                $RD->phase = ($data->phase != '') ? $data->phase : null;
                $RD->length = ($data->length != '') ? $data->length : null;
                $RD->width = ($data->width != '') ? $data->width : null;
                $RD->height = ($data->height != '') ? $data->height : null;
                $RD->brand = ($data->brand != '') ? $data->brand : null;
                $RD->manufactured_in = $data->manufactured_in;
                if($data->depreciation_method != ""){
                    $RD->depreciation_method = $data->depreciation_method;
                }

                if($data->manufactured_date != ""){
                    $manufactured_date = DateTime::createFromFormat('m/j/Y', $data->manufactured_date);
                    $RD->manufactured_date = $manufactured_date->format('Y-m-d');
                }

                if($data->purchasing_date != ""){
                    $purchasing_date = DateTime::createFromFormat('m/j/Y', $data->purchasing_date);
                    $RD->purchasing_date = $purchasing_date->format('Y-m-d');
                }

                $RD->purchasing_price = ($data->purchasing_price != '') ? $data->purchasing_price : null;
                if($RD->lifetime_uom_id != null){
                    if($data->lifetime != ''){
                        if($RD->lifetime_uom_id == 1){
                            $RD->lifetime = ($data->lifetime != '') ? $data->lifetime * 8 : null;
                        }elseif($RD->lifetime_uom_id == 2){
                            $RD->lifetime = ($data->lifetime != '') ? $data->lifetime * 8 * 30 : null;
                        }elseif($RD->lifetime_uom_id == 3){
                            $RD->lifetime = ($data->lifetime != '') ? $data->lifetime * 8 * 365 : null;
                        }
                    }
                }
                $RD->lifetime = ($data->lifetime != '') ? $data->lifetime : null;
                $RD->lifetime_uom_id = ($data->lifetime_uom_id != '') ? $data->lifetime_uom_id : null;
                $RD->cost_per_hour = ($data->cost_per_hour != '') ? $data->cost_per_hour : null;
                $RD->performance = ($data->performance != '') ? $data->performance : null;
                $RD->performance_uom_id = ($data->performance_uom_id != '') ? $data->performance_uom_id : null;
                $RD->save();

            DB::commit();
            if($route == "/resource"){
                return redirect()->route('resource.show',$data->resource_id)->with('success', 'Internal Resource Created');
            }elseif($route == "/resource_repair"){
                return redirect()->route('resource_repair.show',$data->resource_id)->with('success', 'Internal Resource Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/resource"){
                return redirect()->route('resource.show',$data->resource_id)->with('error', $e->getMessage());
            }elseif($route == "/resource_repair"){
                return redirect()->route('resource_repair.show',$data->resource_id)->with('error', $e->getMessage());
            }
        }
    }

    public function destroyAssignedResource(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try {
            $trxResource = ResourceTrx::find($id);

            if($trxResource->wbs->productionOrder != null){
                $prod_order = $trxResource->wbs->productionOrder;
                if($prod_order->status == 0 || $prod_order->status == 2){
                    return response(["error"=> "Failed to delete, this Resource already been used in production order"],Response::HTTP_OK);
                }else if($prod_order->status == 1){
                    $trxResource->productionOrderDetail->delete();
                    $trxResource->delete();
                    DB::commit();
                    return response(["response"=>"Success to delete Assigned Resource"],Response::HTTP_OK);
                }
            }else{
                $trxResource->delete();
                DB::commit();
                return response(["response"=>"Success to delete Assigned Resource"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    //Function
    public function generateResourceCode(){
        $code = 'RSC';
        $modelResource = Resource::orderBy('code', 'desc')->first();

        $number = 1;
		if(isset($modelResource)){
            $number += intval(substr($modelResource->code, -3));
		}

        $resource_code = $code.''.sprintf('%03d', $number);
		return $resource_code;
    }

    public function generateCodeInternal($data){
        $number = 1;
        $code = $data.'-';

        $modelRD = ResourceDetail::orderBy('code','desc')->where('code','like',$code.'%')->where('code','not like','%-PO%')->first();
        if($modelRD){
            $number += intval(substr($modelRD->code,8));
        }
        $code = $data.'-'.$number;
        return $code;
    }

    public function generateGINumber(){
        $modelGI = GoodsIssue::orderBy('created_at','desc')->first();
        $yearNow = date('y');
        
		$number = 1;
        if(isset($modelGI)){
            $yearDoc = substr($modelGI->number, 3,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelGI->number, -5));
            }
        }

        $year = date($yearNow.'000000');
        $year = intval($year);

		$gi_number = $year+$number;
        $gi_number = 'GI-'.$gi_number;

        return $gi_number;
    }

    public function getResourceAssignApi($id){
        $resource = Resource::where('id',$id)->with('uom')->first()->jsonSerialize();

        return response($resource, Response::HTTP_OK);
    }
    
    
    public function getWbsAssignResourceApi($id){
        $wbs = WBS::where('project_id',$id)->get();
        foreach($wbs as $key => $data){
            $ProdOrder = ProductionOrder::where('wbs_id',$data->id)->where('status','!=',1)->first();
            if($ProdOrder){
                $wbs->forget($key);
            }
        }
        return response($wbs, Response::HTTP_OK);
    }

    public function getWbsNameAssignResourceApi($id){

        return response(WBS::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);

    }

    public function getResourceNameAssignResourceApi($id){

        return response(Resource::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);

    }

    public function getProjectNameAssignResourceApi($id){

        return response(Project::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);

    }
    
    public function getCategoryARApi($id){

        return response(Resource::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);

    }

    public function getResourceTrxApi($id){
        $resourceTrx = ResourceTrx::with('project','resource','wbs','resourceDetail')->where('project_id',$id)->get()->jsonSerialize();

        return response($resourceTrx, Response::HTTP_OK);
    }

    public function getAllResourceTrxApi(){
        $resourceTrx = ResourceTrx::with('project','resource','wbs','resourceDetail')->get()->jsonSerialize();

        return response($resourceTrx, Response::HTTP_OK);
    }

    public function getResourceDetailApi($data){
        $data = json_decode($data);
        $resourceDetail = ResourceDetail::where('resource_id',$data[0])->whereNotIn('id',$data[1])->whereIn('status',[1,2])->get()->jsonSerialize();

        return response($resourceDetail, Response::HTTP_OK);
    }
    
    public function generateCodeAPI($data){
        $data = json_decode($data);
        $number = 1;
        $code = $data[0].'-'.$data[1].'-';

        $modelRD = ResourceDetail::orderBy('code','desc')->where('code','like',$code.'%')->first();
        if($modelRD){
            $number += intval(substr($modelRD->code,19));
        }
        $code = $data[0].'-'.$data[1].'-'.$number;

        return response($code, Response::HTTP_OK);
    }
    
    public function getNewResourceDetailAPI($id){
        $modelRD = ResourceDetail::where('resource_id',$id)->with('goodsReceiptDetail.goodsReceipt.purchaseOrder','performanceUom','productionOrderDetails.productionOrder.wbs','productionOrderDetails.performanceUom','productionOrderDetails.resourceDetail')->get()->jsonSerialize();

        return response($modelRD, Response::HTTP_OK);
    }

    public function getScheduleAPI($id){
        $modelTR = ResourceTrx::where('resource_detail_id',$id)->with('wbs','user','project')->get()->jsonSerialize();

        return response($modelTR, Response::HTTP_OK);
    }

    public function getCodeRSCDAPI(){
        $modelRSCD = ResourceDetail::all()->jsonSerialize();

        return response($modelRSCD, Response::HTTP_OK);
    }
}
