<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
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
use App\Models\PurchaseRequisition;
use App\Models\Branch;
use App\Models\Stock;
use App\Models\Uom;
use App\Models\Project;
use App\Models\StorageLocationDetail;
use App\Models\Configuration;
use DateTime;
use DB;
use Auth;

class GoodsReceiptController extends Controller
{
    public function createGrWithRef(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $modelPO = PurchaseOrder::where('id',$id)->with('vendor')->first();
        $modelPODs = PurchaseOrderDetail::where('purchase_order_id',$modelPO->id)->whereColumn('received','!=','quantity')->with('material')->get();
        if($modelPO->purchaseRequisition->type == 1){
        // foreach($modelPODs as $POD){
            //     $POD['already_received'] = $POD->received;
            // }
            $modelSloc = StorageLocation::all();
            $datas = Collection::make();
            
            foreach($modelPODs as $POD){
                $datas->push([
                    "id" => $POD->id,
                    "purchase_order_id" => $modelPO->id,
                    "purchase_requisition_detail_id" => $POD->purchase_requisition_detail_id,
                    "quantity" => $POD->quantity,
                    "received" => $POD->received,
                    "material_id" => $POD->material_id,
                    "material_code" => $POD->material->code,
                    "material_name" => $POD->material->description,
                    "unit" => $POD->material->uom->unit,
                    "resource_id" => $POD->resource_id,
                    "wbs_id" => $POD->wbs_id,
                    "total_price" => $POD->total_price,
                    "sloc_id" => "",
                    "received_date" => "",
                    "item_OK" => 0,
                    "is_decimal" => $POD->material->uom->is_decimal == 1 ? true:false,
                    ]);
                }
            
            return view('goods_receipt.createGrWithRef', compact('modelPO','modelPODs','modelSloc','route','datas'));
        
        }elseif($modelPO->purchaseRequisition->type == 2){
            // $modelPODs = PurchaseOrderDetail::where('purchase_order_id',$modelPO->id)->whereColumn('received','!=','quantity')->get();
            // $resource_categories = Configuration::get('resource_category');
            // $depreciation_methods = Configuration::get('depreciation_methods');
            // $uom = Uom::all();
            // $datas = Collection::make();

            // foreach($modelPODs as $POD){
            //     $quantity = $POD->quantity - $POD->received;
            //     for ($i=0; $i < $quantity; $i++) { 
            //         $datas->push([
            //             "resource_id" => $POD->resource->id, 
            //             "resource_code" => $POD->resource->code,
            //             "resource_name" => $POD->resource->name,
            //             "quantity" => 1,
            //             "status" => "Detail Not Complete",
            //         ]);
            //     }
            // }
            // return view('goods_receipt.createGrWithRefResource', compact('modelPO','datas','resource_categories','uom','depreciation_methods','route'));
        }
    }

    public function createGrFromWo(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $modelWO = WorkOrder::where('id',$id)->with('vendor')->first();
        $modelWODs = WorkOrderDetail::where('work_order_id',$modelWO->id)->with('material','material.uom')->get();
        $modelSloc = StorageLocation::all();
        
        
        return view('goods_receipt.createGrFromWo', compact('modelWO','modelWODs','route','modelSloc'));
    }

    public function selectPO(Request $request)
    {
        $route = $request->route()->getPrefix();
        if($route == "/goods_receipt"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->pluck('id')->toArray();
        }elseif($route == "/goods_receipt_repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->pluck('id')->toArray();
        }

        if($route == "/goods_receipt"){
            $modelPR = PurchaseRequisition::where('business_unit_id',1)->pluck('id')->toArray();
            $modelPOs = PurchaseOrder::whereIn('purchase_requisition_id',$modelPR)->where('status',2)->get();
            
            $modelWOs = WorkOrder::where('status',2)->whereIn('project_id',$modelProject)->get();


        }elseif($route == "/goods_receipt_repair"){
            $modelPR = PurchaseRequisition::where('business_unit_id',2)->pluck('id')->toArray();
            $modelPOs = PurchaseOrder::whereIn('purchase_requisition_id',$modelPR)->where('status',2)->get();

            $modelWOs = WorkOrder::where('status',2)->whereIn('project_id',$modelProject)->get();
        }

        foreach($modelPOs as $key => $PO){
            if($PO->purchaseRequisition->type != 1){
                $modelPOs->forget($key);
            }
        }
        
        return view('goods_receipt.selectPO', compact('modelPOs','modelWOs','route','modelProject'));
    }

    public function show(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelGR = GoodsReceipt::findOrFail($id);
        $modelGRD = $modelGR->GoodsReceiptDetails;
        if($modelGRD[0]->material_id != ''){
            return view('goods_receipt.show', compact('modelGR','modelGRD','route'));
        }elseif($modelGRD[0]->resource_detail_id != ''){
            // return view('goods_receipt.showResource', compact('modelGR','modelGRD','route'));
        }
    }

    public function createGrWithoutRef(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelMaterial = Material::with('uom')->get()->jsonSerialize();
        $modelSloc = StorageLocation::all();

        return view('goods_receipt.createGrWithoutRef', compact('modelMaterial','modelSloc','route'));
    }

    public function index(Request $request){
        $route = $request->route()->getPrefix();
        if($route == "/goods_receipt"){
            $modelGRs = GoodsReceipt::whereIn('type',[1,2,3,5])->where('status',1)->where('business_unit_id',1)->orderBy('created_at', 'desc')->get(); 
        }elseif($route == "/goods_receipt_repair"){
            $modelGRs = GoodsReceipt::whereIn('type',[1,2,3,5])->where('status',1)->where('business_unit_id',2)->orderBy('created_at', 'desc')->get();
        }
        
        return view ('goods_receipt.index', compact('route','modelGRs'));
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
            if($route == "/goods_receipt"){
                $GR->business_unit_id = 1;                
            }elseif($route == "/goods_receipt_repair"){
                $GR->business_unit_id = 2;
            }
            $GR->purchase_order_id = $datas->purchase_order_id;
            $GR->type = 1;
            $GR->description = $datas->description;
            if($datas->ship_date != ""){
                $ship_date = DateTime::createFromFormat('d-m-Y', $datas->ship_date);
                $GR->ship_date = $ship_date->format('Y-m-d');
            }
            $GR->branch_id = Auth::user()->branch->id;
            $GR->user_id = Auth::user()->id;
            $GR->save();
            foreach($datas->POD as $data){
                if($data->received >0 && $data->sloc_id != ""){
                    $GRD = new GoodsReceiptDetail;
                    $GRD->goods_receipt_id = $GR->id;
                    $GRD->quantity = $data->received; 
                    $GRD->material_id = $data->material_id;
                    $GRD->storage_location_id = $data->sloc_id;
                    if($data->received_date != ""){
                        $received_date = DateTime::createFromFormat('d-m-Y', $data->received_date);
                        $GRD->received_date = $received_date->format('Y-m-d');
                    }
                    $GRD->item_OK = $data->item_OK;
                    $GRD->save();
                    
                    $this->updatePOD($data->id,$data->received);
                    $this->updateStock($data->material_id, $data->quantity);
                    $this->updateSlocDetail($data->material_id, $data->sloc_id,$data->quantity);
                }
            }
            $this->checkStatusPO($datas->purchase_order_id);
            DB::commit();
            if($route == "/goods_receipt"){
                return redirect()->route('goods_receipt.show',$GR->id)->with('success', 'Goods Receipt Created');
            }elseif($route == "/goods_receipt_repair"){
                return redirect()->route('goods_receipt_repair.show',$GR->id)->with('success', 'Goods Receipt Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/goods_receipt"){
                return redirect()->route('goods_receipt.selectPO')->with('error', $e->getMessage());
            }elseif($route == "/goods_receipt_repair"){
                return redirect()->route('goods_receipt_repair.selectPO')->with('error', $e->getMessage());
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
            if($route == "/goods_receipt"){
                $GR->business_unit_id = 1;                
            }elseif($route == "/goods_receipt_repair"){
                $GR->business_unit_id = 2;
            }
            $GR->type = 3;
            $GR->work_order_id = $datas->wo_id;
            if($datas->ship_date != ""){
                $ship_date = DateTime::createFromFormat('d-m-Y', $datas->ship_date);
                $GR->ship_date = $ship_date->format('Y-m-d');
            }
            $GR->type = 3;
            $GR->description = $datas->description;
            $GR->branch_id = Auth::user()->branch->id;
            $GR->user_id = Auth::user()->id;
            $GR->save();
            foreach($datas->POD as $data){
                $GRD = new GoodsReceiptDetail;
                $GRD->goods_receipt_id = $GR->id;
                $GRD->quantity = $data->received;
                $GRD->material_id = $data->material_id;
                if($data->received_date != ""){
                    $received_date = DateTime::createFromFormat('d-m-Y', $data->received_date);
                    $GRD->received_date = $received_date->format('Y-m-d');
                }
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
            if($route == "/goods_receipt"){
                $GR->business_unit_id = 1;                
            }elseif($route == "/goods_receipt_repair"){
                $GR->business_unit_id = 2;
            }
            $GR->type = 2;
            $GR->description = $datas->description;
            $GR->type = 2;
            if($datas->ship_date != ""){
                $ship_date = DateTime::createFromFormat('d-m-Y', $datas->ship_date);
                $GR->ship_date = $ship_date->format('Y-m-d');
            }
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
                    if($data->received_date != ""){
                        $received_date = DateTime::createFromFormat('d-m-Y', $data->received_date);
                        $GRD->received_date = $received_date->format('Y-m-d');
                    }
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

    public function printPdf($id, Request $request)
    { 
        $branch = Auth::user()->branch; 
        $modelGR = GoodsReceipt::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $route = $request->route()->getPrefix();
        $pdf->loadView('goods_receipt.pdf',['modelGR' => $modelGR,'branch'=>$branch, 'route'=> $route]);
        $now = date("Y_m_d_H_i_s");
        return $pdf->stream('Goods_Receipt_'.$now.'.pdf');
    }

    public function updatePOD($purchase_order_id,$received){
        $modelPOD = PurchaseOrderDetail::findOrFail($purchase_order_id);
        if($modelPOD){
            $modelPOD->received = $modelPOD->received + $received;
            $modelPOD->update();
        }else{

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
    public function checkStatusPO($purchase_order_id){
        $modelPO = PurchaseOrder::findOrFail($purchase_order_id);
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
        $modelGR = GoodsReceipt::orderBy('id','desc')->where('branch_id',Auth::user()->branch_id)->first();
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
        
        return response(Material::where('id',$id)->with('uom')->first()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getMaterialsAPI($ids){
        $ids = json_decode($ids);

        return response(Material::whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getGRDAPI($id){

        return response(GoodsReceiptDetail::where('goods_recipt_id',$id), Response::HTTP_OK);
    }
}

