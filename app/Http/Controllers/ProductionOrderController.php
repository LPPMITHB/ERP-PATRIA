<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Models\Branch;
use App\Models\Project;
use App\Models\WBS;
use App\Models\ProductionOrder;
use App\Models\ProductionOrderDetail;
use App\Models\Bom;
use App\Models\Material;
use App\Models\Resource;
use App\Models\Service;
use App\Models\ResourceTrx;
use App\Models\Stock;
use App\Models\ProjectInventory;
use App\Models\ResourceDetail;
use App\Models\MaterialRequisition;
use App\Models\MaterialRequisitionDetail;
use Auth;
use DB;

class ProductionOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectProject(Request $request){
        $route = $request->route()->getPrefix();
        if($route == "/production_order"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == "/production_order_repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get();
        }
        $menu = "create_pro";

        return view('production_order.selectProject', compact('modelProject','menu','route'));
    }

    public function selectProjectRelease (Request $request){
        $route = $request->route()->getPrefix();
        if($route == "/production_order"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == "/production_order_repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get();
        }
        $menu = "release_pro";

        return view('production_order.selectProject', compact('modelProject','menu','route'));
    }

    public function selectProjectConfirm (Request $request){
        $route = $request->route()->getPrefix();
        if($route == "/production_order"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == "/production_order_repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get();
        }
        $menu = "confirm_pro";

        return view('production_order.selectProject', compact('modelProject','menu','route'));
    }

    public function selectProjectReport (Request $request){
        $route = $request->route()->getPrefix();
        if($route == "/production_order"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == "/production_order_repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get();
        }
        $menu = "report_pro";

        return view('production_order.selectProject', compact('modelProject','menu','route'));
    }
    
    public function selectWBS(Request $request,$id){
        $route = $request->route()->getPrefix();

        $modelProject = Project::findOrFail($id);
        $wbss = $modelProject->wbss;
        $dataWbs = Collection::make();

        $totalWeightProject = $modelProject->wbss->where('wbs_id',null)->sum('weight');
        $dataWbs->push([
            "id" => $modelProject->number, 
            "parent" => "#",
            "text" => $modelProject->name. " | Weight : (".$totalWeightProject."% / 100%)",
            "icon" => "fa fa-ship"
        ]);
        if($route == "/production_order"){
            $routes = '/production_order/create/';
        }elseif($route == "/production_order_repair"){
            $routes = '/production_order_repair/create/';
        }
    
        foreach($wbss as $wbs){
            if($wbs->wbs){
                if(count($wbs->activities)>0){
                    $totalWeight = $wbs->wbss->sum('weight') + $wbs->activities->sum('weight');
                    if($wbs->productionOrder==null){
                        $dataWbs->push([
                            "id" => $wbs->code , 
                            "parent" => $wbs->wbs->code,
                            "text" => $wbs->name. " | Weight : (".$totalWeight."% / ".$wbs->weight."%)",
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => $routes.$wbs->id],
                        ]);
                    }else{
                        if($route == "/production_order"){
                            $show = '/production_order/';
                        }elseif($route == "/production_order_repair"){
                            $show = '/production_order_repair/';
                        }
                        $dataWbs->push([
                            "id" => $wbs->code , 
                            "parent" => $wbs->wbs->code,
                            "text" => $wbs->name. " | Weight : (".$totalWeight."% / ".$wbs->weight."%)",
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => $show.$wbs->productionOrder->id],
                        ]);
                    }
                }else{
                    if($wbs->productionOrder==null){
                        $dataWbs->push([
                            "id" => $wbs->code , 
                            "parent" => $wbs->wbs->code,
                            "text" => $wbs->name. " | Weight : ".$wbs->weight."%",
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => $routes.$wbs->id],
                        ]);
                    }else{
                        if($route == "/production_order"){
                            $show = '/production_order/';
                        }elseif($route == "/production_order_repair"){
                            $show = '/production_order_repair/';
                        }
                        $dataWbs->push([
                            "id" => $wbs->code , 
                            "parent" => $wbs->wbs->code,
                            "text" => $wbs->name. " | Weight : ".$wbs->weight."%",
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => $show.$wbs->productionOrder->id],
                        ]);  
                    }
                    
                }
            }else{
                $totalWeight = $wbs->wbss->sum('weight') + $wbs->activities->sum('weight');
                if($wbs->productionOrder==null){
                    $dataWbs->push([
                        "id" => $wbs->code , 
                        "parent" => $modelProject->number,
                        "text" => $wbs->name. " | Weight : (".$totalWeight."% / ".$wbs->weight."%)",
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => $routes.$wbs->id],
                    ]);
                }else{
                    if($route == "/production_order"){
                        $show = '/production_order/';
                    }elseif($route == "/production_order_repair"){
                        $show = '/production_order_repair/';
                    }
                    $dataWbs->push([
                        "id" => $wbs->code , 
                        "parent" => $modelProject->number,
                        "text" => $wbs->name. " | Weight : (".$totalWeight."% / ".$wbs->weight."%)",
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => $show.$wbs->productionOrder->id],
                    ]);
                }
            } 
        }

        return view('production_order.selectWBS', compact('dataWbs','modelProject','route'));
    }

    public function selectPrO(Request $request, $id){
        $route = $request->route()->getPrefix();
        $modelProject = Project::findOrFail($id);
        $modelPrO = ProductionOrder::where('project_id',$id)->where('status',1)->get();

        return view('production_order.selectPrO', compact('modelPrO','modelProject','route'));
    }

    public function confirmPrO(Request $request,$id){
        $route = $request->route()->getPrefix();
        $modelProject = Project::findOrFail($id);
        $modelPrO = ProductionOrder::where('project_id',$id)->where('status',2)->get();

        return view('production_order.confirmPrO', compact('modelPrO','modelProject','route'));
    }

    public function index(Request $request)
    {
        $route = $request->route()->getPrefix();
        if($route == "/production_order"){
            $project_ids = Project::where('business_unit_id',1)->pluck('id')->toArray();
        }elseif($route == "/production_order_repair"){
            $project_ids = Project::where('business_unit_id',2)->pluck('id')->toArray();
        }
        $modelPOs = ProductionOrder::whereIn('project_id',$project_ids)->get();

        return view('production_order.index',compact('modelPOs','route'));
    }

    public function selectPrOReport($id){
        $modelProject = Project::findOrFail($id);
        $modelPrO = ProductionOrder::where('project_id',$id)->where('status',1)->get();

        return view('production_order.selectPrOReport', compact('modelPrO','modelProject'));
    }

    public function report($id){
        $modelPrO = ProductionOrder::findOrFail($id);
        $modelProject = Project::findOrFail($modelPrO->project_id);
        $totalPrice = 0;
        foreach($modelPrO->ProductionOrderDetails as $PrO){
            if($PrO->material_id != ""){
                $totalPrice += $PrO->actual * $PrO->material->cost_standard_price;
            }
        }
        return view('production_order.report', compact('modelPrO','modelProject','totalPrice'));
    }

    public function release(Request $request, $id){
        $route = $request->route()->getPrefix();
        $modelPrO = ProductionOrder::where('id',$id)->first();
        $modelPrOD = ProductionOrderDetail::where('production_order_id',$modelPrO->id)->get();
        $project = Project::where('id',$modelPrO->project_id)->with('customer','ship')->first();
        $wbs = WBS::findOrFail($modelPrO->wbs_id);

        $activities = $wbs->activities;
        $materials = Collection::make();
        $services = Collection::make();
        $resources = Collection::make();
        if($route == '/production_order'){
            foreach($modelPrOD as $prOD){
                if($prOD->material_id != ""){
                    $materials->push([
                        "id" => $prOD->id , 
                        "material" => [
                            "code" => $prOD->material->code,
                            "name" => $prOD->material->name,
                            "description" => $prOD->material->description,
                            "unit" => $prOD->material->uom->unit,
                            "source" => $prOD->source,
                        ],
                        "quantity" => $prOD->quantity,
                        "material_id" => $prOD->material_id,
                    ]);
                }elseif($prOD->resource_id != ""){
                    $qty =  $prOD->quantity;
                    for ($x = 0; $x < $qty; $x++) {
                        $resources->push([
                            "id" => $prOD->id , 
                            "resource" => [
                                "code" => $prOD->resource->code,
                                "name" => $prOD->resource->name,
                                "description" => $prOD->resource->description,
                            ],
                            "quantity" => $prOD->quantity,
                            "resource_id" => $prOD->resource_id,
                            "trx_resource_id" => null,
                            "trx_resource_code" => null,
                        ]);
                    } 
                }
            }
        }elseif($route == '/production_order_repair'){
            foreach($modelPrOD as $prOD){
                if($prOD->material_id != ""){
                    $materials->push([
                        "id" => $prOD->id , 
                        "material" => [
                            "code" => $prOD->material->code,
                            "name" => $prOD->material->name,
                            "description" => $prOD->material->description,
                            "unit" => $prOD->material->uom->unit,
                            "source" => $prOD->source,
                        ],
                        "quantity" => $prOD->quantity,
                        "material_id" => $prOD->material_id,
                    ]);
                }elseif($prOD->resource_id != ""){
                    $qty =  $prOD->quantity;
                    for ($x = 0; $x < $qty; $x++) {
                        $resources->push([
                            "id" => $prOD->id , 
                            "resource" => [
                                "code" => $prOD->resource->code,
                                "name" => $prOD->resource->name,
                                "description" => $prOD->resource->description,
                            ],
                            "quantity" => $prOD->quantity,
                            "resource_id" => $prOD->resource_id,
                            "trx_resource_id" => null,
                            "trx_resource_code" => null,
                        ]);
                    } 
                }elseif($prOD->service_id != ""){
                    $services->push([
                        "id" => $prOD->id , 
                        "service" => [
                            "code" => $prOD->service->code,
                            "name" => $prOD->service->name,
                            "description" => $prOD->service->description,
                        ],
                        "quantity" => $prOD->quantity,
                        "service_id" => $prOD->service_id,
                    ]);
                }
            }
        }

        return view('production_order.release', compact('modelPrO','project','modelPrOD','materials','services','resources','route','wbs','activities'));
    }

    public function confirm(Request $request,$id){
        $route = $request->route()->getPrefix();
        $modelPrO = ProductionOrder::where('id',$id)->with('project')->first();
        $modelPrOD = ProductionOrderDetail::where('production_order_id',$modelPrO->id)->with('material','resource','service','productionOrder')->get()->jsonSerialize();
        $project = Project::where('id',$modelPrO->project_id)->with('customer','ship')->first();

        return view('production_order.confirm', compact('modelPrO','project','modelPrOD','route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $wbs = WBS::findOrFail($id);
        $project = Project::findOrFail($wbs->project_id);
        $materials = Material::all()->jsonSerialize();
        $resources = Resource::all()->jsonSerialize();
        $services = Service::all()->jsonSerialize();
        $modelActivities = $wbs->activities;
        
        $modelBOM = Bom::where('wbs_id',$wbs->id)->first();
        $modelRD = ResourceTrx::where('wbs_id',$wbs->id)->get();
        if($modelBOM != null){
            return view('production_order.create', compact('wbs','project','materials','resources','services','modelBOM','modelRD','route','modelActivities'));
        }else{
            if($route == "/production_order"){
                return redirect()->route('production_order.selectWBS',$wbs->project_id)->with('error', "This WBS doesn't have BOM");
            }elseif($route == "/production_order_repair"){
                return redirect()->route('production_order_repair.selectWBS',$wbs->project_id)->with('error', "This WBS doesn't have BOM");
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $arrData = $datas->datas;
        $po_number = $this->generatePrONumber();

        DB::beginTransaction();
        try {
            $PrO = new ProductionOrder;
            $PrO->number = $po_number;
            $PrO->project_id = $datas->project_id;
            $PrO->wbs_id = $datas->wbs_id;
            $PrO->status = 1;
            $PrO->user_id = Auth::user()->id;
            $PrO->branch_id = Auth::user()->branch->id;
            $PrO->save();

            $status = 0;

            if(count($datas->materials) > 0){
                foreach($datas->materials as $material){
                    if($material->material_id != ""){
                        $PrOD = new ProductionOrderDetail;
                        $PrOD->production_order_id = $PrO->id;
                        $PrOD->material_id = $material->material_id;
                        $PrOD->quantity = $material->quantity;
                        $PrOD->source = $material->source;
                        $PrOD->save();
                    }elseif($material->service_id != ""){
                        $PrOD = new ProductionOrderDetail;
                        $PrOD->production_order_id = $PrO->id;
                        $PrOD->service_id = $material->service_id;
                        $PrOD->quantity = $material->quantity;
                        $PrOD->save();
                    }
                }
            }

            if(count($datas->resources) > 0){
                foreach($datas->resources as $resource){
                    $PrOD = new ProductionOrderDetail;
                    $PrOD->production_order_id = $PrO->id;
                    $PrOD->resource_id = $resource->resource_id;
                    $PrOD->save();
                }
            }

            foreach($arrData as $data){
                if($data->type == "Material"){
                    $existing = ProductionOrderDetail::where('production_order_id',$PrO->id)->where('material_id' , $data->id)->first();
                    if($existing != null){
                        $existing->quantity += $data->quantity;
                        $existing->update();
                    }else{
                        $PrOD = new ProductionOrderDetail;
                        $PrOD->production_order_id = $PrO->id;
                        $PrOD->material_id = $data->id;
                        $PrOD->quantity = $data->quantity;
                        $PrOD->source = 'Stock';
                        $PrOD->save();
                    }
                }elseif($data->type == "Resource"){
                    $existing = ProductionOrderDetail::where('production_order_id',$PrO->id)->where('resource_id' , $data->id)->first();
                    if($existing != null){
                        $existing->quantity += $data->quantity;
                        $existing->update();
                    }else{
                        $PrOD = new ProductionOrderDetail;
                        $PrOD->production_order_id = $PrO->id;
                        $PrOD->resource_id = $data->id;
                        $PrOD->quantity = $data->quantity;
                        $PrOD->save();
                    }
                }elseif($data->type == "Service"){
                    $existing = ProductionOrderDetail::where('production_order_id',$PrO->id)->where('service_id' , $data->id)->first();
                    if($existing != null){
                        $existing->quantity += $data->quantity;
                        $existing->update();
                    }else{
                        $PrOD = new ProductionOrderDetail;
                        $PrOD->production_order_id = $PrO->id;
                        $PrOD->service_id = $data->id;
                        $PrOD->quantity = $data->quantity;
                        $PrOD->save();
                    }
                }
            }
            DB::commit();
            if($route == "/production_order"){
                return redirect()->route('production_order.show',$PrO->id)->with('success', 'Production Order Created');
            }elseif($route == "/production_order_repair"){
                return redirect()->route('production_order_repair.show',$PrO->id)->with('success', 'Production Order Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/production_order"){
                return redirect()->route('production_order.create',$datas->project_id)->with('error', $e->getMessage());
            }elseif($route == "/production_order_repair"){
                return redirect()->route('production_order_repair.create',$datas->project_id)->with('error', $e->getMessage());
            }
        }
    }

    public function storeRelease(Request $request){
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $pro_id = $datas->modelPrOD[0]->production_order_id;
        $modelPrO = ProductionOrder::findOrFail($pro_id);

        DB::beginTransaction();
        try {
            $modelPrO->status = 2;
            $modelPrO->save();

            $this->createMR($datas->modelPrOD);
            DB::commit();
            if($route == "/production_order"){
                return redirect()->route('production_order.showRelease',$modelPrO->id)->with('success', 'Production Order Released');
            }elseif($route == "/production_order_repair"){
                return redirect()->route('production_order_repair.showRelease',$modelPrO->id)->with('success', 'Production Order Released');
            }
        }catch (\Exception $e) {
            DB::rollback();
            if($route == "/production_order"){
                return redirect()->route('production_order.selectProjectRelease')->with('error', $e->getMessage());
            }elseif($route == "/production_order_repair"){
                return redirect()->route('production_order_repair.selectProjectRelease')->with('error', $e->getMessage());
            }
        }
    }

    public function storeConfirm(Request $request){
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $pro_id = $datas->modelPrOD[0]->production_order_id;
        $modelPrO = ProductionOrder::findOrFail($pro_id);

        DB::beginTransaction();
        try {
            $statusAll = $modelPrO->wbs->activities->groupBy('status');
            $notDone = true;
            foreach($statusAll as $key => $status){
                if($key == 1){
                    $notDone = false;
                }
            }
            if($notDone){
                $modelPrO->status = 0;
                $modelPrO->save();
            }else{
                $modelPrO->status = 2;
                $modelPrO->save();
            }
            foreach ($datas->materials as  $material) {
                $prod = ProductionOrderDetail::find($material->id);
                $prod->actual = $material->used;
                $prod->update();
            }

            foreach ($datas->services as  $service) {
                    $prod = ProductionOrderDetail::find($service->id);
                    $prod->actual = $service->used;
                    $prod->update();
            }
            
            DB::commit();
            if($route == "/production_order"){
                return redirect()->route('production_order.showConfirm',$modelPrO->id)->with('success', 'Production Order Confirmed');
            }elseif($route == "/production_order_repair"){
                return redirect()->route('production_order_repair.showConfirm',$modelPrO->id)->with('success', 'Production Order Confirmed');
            }
        }catch (\Exception $e) {
            DB::rollback();
            if($route == "/production_order"){
                return redirect()->route('production_order.selectProjectConfirm')->with('error', $e->getMessage());
            }elseif($route == "/production_order_repair"){
                return redirect()->route('production_order_repair.selectProjectConfirm')->with('error', $e->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPrO = ProductionOrder::findOrFail($id);
        $modelActivities = $modelPrO->wbs->activities;

        return view('production_order.show', compact('modelPrO','route','modelActivities'));
    }

    public function createMR($modelPrOD){
        $mr_number = $this->generateMRNumber();

        $MR = new MaterialRequisition;
        $MR->number = $mr_number;
        $MR->project_id = $modelPrOD[0]->production_order->project_id;
        $MR->description = "AUTO CREATE MR FROM PRODUCTION ORDER";
        $MR->type = 1;
        $MR->user_id = Auth::user()->id;
        $MR->branch_id = Auth::user()->branch->id;
        $MR->save();

        foreach($modelPrOD as $PrOD){
            if($PrOD->material_id != "" || $PrOD->material_id != null){
                $MRD = new MaterialRequisitionDetail;
                $MRD->material_requisition_id = $MR->id;
                $MRD->quantity = $PrOD->sugQuantity;
                $MRD->issued = 0;
                $MRD->material_id = $PrOD->material_id;
                $MRD->save();
            }
        }
    }

    public function generatePrONumber(){
        $modelPrO = ProductionOrder::orderBy('created_at','desc')->where('branch_id',Auth::user()->branch_id)->first();
        $modelBranch = Branch::where('id', Auth::user()->branch_id)->first();

        $branch_code = substr($modelBranch->code,4,2);
        $number = 1;
        if(isset($modelPrO)){
            $number += intval(substr($modelPrO->number, -6));
        }
        $year = date('y'.$branch_code.'000000');
        $year = intval($year);

        $po_number = $year+$number;
        $po_number = 'PrO-'.$po_number;
        return $po_number;
    }

    public function getMaterialAPI($id){

        return response(Material::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getResourceAPI($id){

        return response(Resource::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getServiceAPI($id){

        return response(Service::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getStockAPI($id){
        $stock = Stock::where('material_id',$id)->first();
        if($stock){
            $stock = json_encode($stock);
        }else{
            $stock = [];
        }

        return response($stock, Response::HTTP_OK);
    }

    public function getProjectInvAPI($id){
        $stock = ProjectInventory::where('material_id',$id)->first();
        if($stock){
            $stock = json_encode($stock);
        }else{
            $stock = [];
        }

        return response($stock, Response::HTTP_OK);
    }

    public function generateMRNumber(){
        $modelMR = MaterialRequisition::orderBy('created_at','desc')->where('branch_id',Auth::user()->branch_id)->first();
        $modelBranch = Branch::where('id', Auth::user()->branch_id)->first();

        $branch_code = substr($modelBranch->code,4,2);
		$number = 1;
		if(isset($modelMR)){
            $number += intval(substr($modelMR->number, -6));
		}
        $year = date('y'.$branch_code.'000000');
        $year = intval($year);

		$mr_number = $year+$number;
        $mr_number = 'MR-'.$mr_number;
		return $mr_number;
    }
}
