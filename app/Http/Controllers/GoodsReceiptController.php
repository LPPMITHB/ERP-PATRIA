<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptDetail;
use App\Models\PurchaseOrder;
use App\Models\WorkOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\WorkOrderDetail;
use App\Models\ProjectInventory;
use App\Models\StorageLocation;
use App\Models\Material;
use App\Models\Resource;
use App\Models\ResourceDetail;
use App\Models\Branch;
use App\Models\Stock;
use App\Models\Uom;
use App\Models\StorageLocationDetail;
use App\Models\Configuration;
use Illuminate\Support\Collection;
use DB;
use Auth;

class GoodsReceiptController extends Controller
{
    public function createGrWithRef(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $modelPO = PurchaseOrder::where('id',$id)->with('vendor')->first();
        if($modelPO->purchaseRequisition->type == 1){
            $modelPODs = PurchaseOrderDetail::where('purchase_order_id',$modelPO->id)->whereColumn('received','!=','quantity')->with('material')->get();
            $modelSloc = StorageLocation::all();

            return view('goods_receipt.createGrWithRef', compact('modelPO','modelPODs','modelSloc','route'));
        }elseif($modelPO->purchaseRequisition->type == 2){
            $modelPODs = PurchaseOrderDetail::where('purchase_order_id',$modelPO->id)->whereColumn('received','!=','quantity')->get();
            $resource_categories = Configuration::get('resource_category');
            $depreciation_methods = Configuration::get('depreciation_methods');
            $uom = Uom::all();
            $datas = Collection::make();

            foreach($modelPODs as $POD){
                $quantity = $POD->quantity - $POD->received;
                for ($i=0; $i < $quantity; $i++) { 
                    $datas->push([
                        "resource_id" => $POD->resource->id, 
                        "resource_code" => $POD->resource->code,
                        "resource_name" => $POD->resource->name,
                        "quantity" => 1,
                        "status" => "Detail Not Complete",
                    ]);
                }
            }
            return view('goods_receipt.createGrWithRefResource', compact('modelPO','datas','resource_categories','uom','depreciation_methods','route'));
        }
    }

    public function createGrFromWo(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $modelWO = WorkOrder::where('id',$id)->with('vendor')->first();
        $modelWODs = WorkOrderDetail::where('work_order_id',$modelWO->id)->with('material')->get();
        
        return view('goods_receipt.createGrFromWo', compact('modelWO','modelWODs','route'));
    }

    public function selectPO(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelPOs = PurchaseOrder::where('status',2)->get();
        $modelWOs = WorkOrder::where('status',2)->get();
        
        return view('goods_receipt.selectPO', compact('modelPOs','modelWOs','route'));
    }

    public function show(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelGR = GoodsReceipt::findOrFail($id);
        $modelGRD = $modelGR->GoodsReceiptDetails ;
        if($modelGRD[0]->resource_detail_id != ''){
            $type = "Resource";
        }elseif($modelGRD[0]->material_id != ''){
            $type = "Material";
        }
        
        if($type == "Material"){
            return view('goods_receipt.show', compact('modelGR','modelGRD','route'));
        }elseif($type == "Resource"){
            return view('goods_receipt.showResource', compact('modelGR','modelGRD','route'));
        }
    }
    
    public function createGrWithoutRef(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelMaterial = Material::all()->jsonSerialize();
        $modelSloc = StorageLocation::all();

        return view('goods_receipt.createGrWithoutRef', compact('modelMaterial','modelSloc','route'));
    }

    public function index(Request $request){
        $route = $request->route()->getPrefix();
        $modelGRs = GoodsReceipt::all();

        return view ('goods_receipt.index', compact('modelGRs','route'));
    }

    public function storeResource(Request $request){
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $gr_number = $this->generateGRNumber();

        DB::beginTransaction();
        try {
            $GR = new GoodsReceipt;
            $GR->number = $gr_number;
            $GR->purchase_order_id = $datas->po_id;
            $GR->description = $datas->description;
            $GR->branch_id = Auth::user()->branch->id;
            $GR->user_id = Auth::user()->id;
            $GR->save();

            foreach($datas->resources as $data){
                $RD = new ResourceDetail;
                $RD->code = $data->code;
                $RD->resource_id = $data->resource_id;
                $RD->category_id = $data->category_id;
                $RD->description = $data->description;
                if($data->category_id == 0){
                    $RD->sub_con_address = $data->sub_con_address;
                    $RD->sub_con_phone = $data->sub_con_phone;
                    $RD->sub_con_competency = $data->sub_con_competency;
                }elseif($data->category_id == 1){
                    $RD->others_name = $data->name;
                }elseif($data->category_id == 2){
                    $RD->brand = $data->brand;
                    $RD->performance = ($data->performance != '') ? $data->performance : null;
                    $RD->performance_uom_id = ($data->performance_uom_id != '') ? $data->performance_uom_id : null;
                }elseif($data->category_id == 3){
                    $RD->brand = $data->brand;
                    $RD->depreciation_method = $data->depreciation_method;
                    $RD->manufactured_date = ($data->manufactured_date != '') ? $data->manufactured_date : null;
                    $RD->purchasing_date = ($data->purchasing_date != '') ? $data->purchasing_date : null;
                    $RD->purchasing_price = ($data->purchasing_price != '') ? $data->purchasing_price : null;
                    $RD->lifetime = ($data->lifetime != '') ? $data->lifetime : null;
                    $RD->lifetime_uom_id = ($data->lifetime_uom_id != '') ? $data->lifetime_uom_id : null;
                    $RD->cost_per_hour = ($data->cost_per_hour != '') ? $data->cost_per_hour : null;
                    $RD->performance = ($data->performance != '') ? $data->performance : null;
                    $RD->performance_uom_id = ($data->performance_uom_id != '') ? $data->performance_uom_id : null;
                }
                $RD->save();

                $GRD = new GoodsReceiptDetail;
                $GRD->goods_receipt_id = $GR->id;
                $GRD->quantity = 1;
                $GRD->resource_detail_id = $RD->id;
                $GRD->save();
            }
            DB::commit();
            if($route == "/goods_receipt"){
                return redirect()->route('goods_receipt.show',$GR->id)->with('success', 'Goods Receipt Created');
            }elseif($route == "/goods_receipt_repair"){
                return redirect()->route('goods_receipt_repair.show',$GR->id)->with('success', 'Goods Receipt Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/goods_receipt"){
                return redirect()->route('goods_receipt.selectPO',$datas->po_id)->with('error', $e->getMessage());
            }elseif($route == "/goods_receipt_repair"){
                return redirect()->route('goods_receipt_repair.selectPO',$datas->po_id)->with('error', $e->getMessage());
            }
        }
    }

    public function store(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $gr_number = $this->generateGRNumber();

        DB::beginTransaction();
        try {
            $GR = new GoodsReceipt;
            $GR->number = $gr_number;
            $GR->purchase_order_id = $datas->po_id;
            $GR->description = $datas->description;
            $GR->branch_id = Auth::user()->branch->id;
            $GR->user_id = Auth::user()->id;
            $GR->save();
            foreach($datas->POD as $data){
                if($data->received >0){
                    $GRD = new GoodsReceiptDetail;
                    $GRD->goods_receipt_id = $GR->id;
                    $GRD->quantity = $data->received;
                    $GRD->material_id = $data->material_id;
                    $GRD->storage_location_id = $data->sloc_id;
                    $GRD->save();
                
                    $this->updatePOD($data->id,$data->received);
                    $this->updateStock($data->material_id, $data->quantity);
                    $this->updateSlocDetail($data->material_id, $data->sloc_id,$data->quantity);
                }
            }
            $this->checkStatusPO($datas->po_id);
            DB::commit();
            if($route == "/goods_receipt"){
                return redirect()->route('goods_receipt.show',$GR->id)->with('success', 'Goods Receipt Created');
            }elseif($route == "/goods_receipt_repair"){
                return redirect()->route('goods_receipt_repair.show',$GR->id)->with('success', 'Goods Receipt Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/goods_receipt"){
                return redirect()->route('goods_receipt.selectPO',$datas->po_id)->with('error', $e->getMessage());
            }elseif($route == "/goods_receipt_repair"){
                return redirect()->route('goods_receipt_repair.selectPO',$datas->po_id)->with('error', $e->getMessage());
            }
        }
    }

    public function storeWo(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $gr_number = $this->generateGRNumber();
        DB::beginTransaction();
        try {
            $GR = new GoodsReceipt;
            $GR->number = $gr_number;
            $GR->work_order_id = $datas->wo_id;
            $GR->description = $datas->description;
            $GR->branch_id = Auth::user()->branch->id;
            $GR->user_id = Auth::user()->id;
            $GR->save();
            foreach($datas->POD as $data){
                $GRD = new GoodsReceiptDetail;
                $GRD->goods_receipt_id = $GR->id;
                $GRD->quantity = $data->received;
                $GRD->material_id = $data->material_id;
                $GRD->save();

                $PI = new ProjectInventory;
                $PI->project_id = $datas->project_id;
                $PI->material_id = $data->material_id;
                $PI->quantity = $data->received;
                $PI->save();
            }
            DB::commit();
            if($route == "/goods_receipt"){
                return redirect()->route('goods_receipt.show',$GR->id)->with('success', 'Goods Receipt Created');
            }elseif($route == "/goods_receipt_repair"){
                return redirect()->route('goods_receipt_repair.show',$GR->id)->with('success', 'Goods Receipt Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/goods_receipt"){
                return redirect()->route('goods_receipt.selectPO',$datas->wo_id)->with('error', $e->getMessage());
            }elseif($route == "/goods_receipt_repair"){
                return redirect()->route('goods_receipt_repair.selectPO',$datas->wo_id)->with('error', $e->getMessage());
            }
        }
    }

    public function storeWOR(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $gr_number = $this->generateGRNumber();

        DB::beginTransaction();
        try {
            $GR = new GoodsReceipt;
            $GR->number = $gr_number;
            $GR->description = $datas->description;
            $GR->branch_id = Auth::user()->branch->id;
            $GR->user_id = Auth::user()->id;
            $GR->save();
            foreach($datas->materials as $data){
                if($data->quantity >0){
                    $GRD = new GoodsReceiptDetail;
                    $GRD->goods_receipt_id = $GR->id;
                    $GRD->quantity = $data->quantity;
                    $GRD->material_id = $data->material_id;
                    $GRD->storage_location_id = $data->sloc_id;
                    $GRD->save();
                
                    $this->updateStock($data->material_id, $data->quantity);
                    $this->updateSlocDetail($data->material_id, $data->sloc_id,$data->quantity);
                }
            }
            DB::commit();
            if($route == "/goods_receipt"){
                return redirect()->route('goods_receipt.show',$GR->id)->with('success', 'Goods Receipt Created');
            }elseif($route == "/goods_receipt_repair"){
                return redirect()->route('goods_receipt_repair.show',$GR->id)->with('success', 'Goods Receipt Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/goods_receipt"){
                return redirect()->route('goods_receipt.createGrWithoutRef')->with('error', $e->getMessage());
            }elseif($route == "/goods_receipt_repair"){
                return redirect()->route('goods_receipt_repair.createGrWithoutRef')->with('error', $e->getMessage());
            }
        }
    }
    public function updatePOD($pod_id,$received){
        $modelPOD = PurchaseOrderDetail::findOrFail($pod_id);
        
        if($modelPOD){
            $modelPOD->received = $modelPOD->received + $received;
            $modelPOD->update();
        }
    }

    public function updateStock($material_id,$received){
        $modelStock = Stock::where('material_id',$material_id)->first();
       

        if($modelStock){
            $modelStock->quantity += $received;
            $modelStock->update();
        }else{
            $modelStock = new Stock;
            $modelStock->quantity = $received;
            $modelStock->branch_id = Auth::user()->branch->id;;
            $modelStock->material_id = $material_id;
            $modelStock->save();
                
        }
    }

    public function updateSlocDetail($material_id,$sloc_id,$received){
        $modelSlocDetail = StorageLocationDetail::where('material_id',$material_id)->where('storage_location_id',$sloc_id)->first();
        if($modelSlocDetail){
            $modelSlocDetail->quantity += $received;
            $modelSlocDetail->update();
        }else{
            $modelSlocDetail = new StorageLocationDetail;
            $modelSlocDetail->quantity = $received;
            $modelSlocDetail->material_id = $material_id;
            $modelSlocDetail->storage_location_id = $sloc_id;
            $modelSlocDetail->save();
        }
    }
    public function checkStatusPO($po_id){
        $modelPO = PurchaseOrder::findOrFail($po_id);
        $status = 0;
        foreach($modelPO->purchaseOrderDetails as $POD){
            if($POD->received < $POD->quantity){
                $status = 1;
            }
        }
        if($status == 0){
            $modelPO->status = 0;
            $modelPO->save();
        }
    }

    public function generateGRNumber(){
        $modelGR = GoodsReceipt::orderBy('created_at','desc')->where('branch_id',Auth::user()->branch_id)->first();
        $modelBranch = Branch::where('id', Auth::user()->branch_id)->first();

        $branch_code = substr($modelBranch->code,4,2);
		$number = 1;
		if(isset($modelGR)){
            $number += intval(substr($modelGR->number, -6));
		}
        $year = date('y'.$branch_code.'000000');
        $year = intval($year);

		$gr_number = $year+$number;
        $gr_number = 'GR-'.$gr_number;
		return $gr_number;
    }

    public function getSlocApi($id){
        $modelSloc = StorageLocation::find($id)->jsonSerialize();

        return response($modelSloc, Response::HTTP_OK);
    }

    public function getMaterialAPI($id){
        
        return response(Material::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getMaterialsAPI($ids){
        $ids = json_decode($ids);

        return response(Material::whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getGRDAPI($id){

        return response(GoodsReceiptDetail::where('goods_recipt_id',$id), Response::HTTP_OK);
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
}

