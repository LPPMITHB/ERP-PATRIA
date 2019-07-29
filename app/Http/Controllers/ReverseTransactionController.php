<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptDetail;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\ReverseTransaction;
use App\Models\ReverseTransactionDetail;
use App\Models\GoodsIssue;
use App\Models\GoodsIssueDetail;
use App\Models\Stock;
use App\Models\StorageLocationDetail;
use App\Models\Branch;
use DB;
use Auth;
use DateTime;
use Illuminate\Support\Carbon;

class ReverseTransactionController extends Controller
{
    public function index(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/reverse_transaction" ? "building" : "repair";    
        if($menu == "building"){
            $modelDatas = ReverseTransaction::where('business_unit_id',1)->get();
        }elseif($menu == "repair"){
            $modelDatas = ReverseTransaction::where('business_unit_id',2)->get();
        }
        foreach ($modelDatas as $data) {
            if($data->type == 1){
                $data->type_string = "Goods Receipt";
                $data->referenceDocument = GoodsReceipt::find($data->old_reference_document);
            }

            if($data->status == 0){
                $data->status_string = 'CLOSED';
            }
            elseif($data->status == 1){
                $data->status_string = 'OPEN';
            }
            elseif($data->status == 2){
                $data->status_string = 'APPROVED';
            }
            elseif($data->status == 3){
                $data->status_string = 'NEEDS REVISION';
            }
            elseif($data->status == 4){
                $data->status_string = 'REVISED';
            }
            elseif($data->status == 5){
                $data->status_string = 'REJECTED';
            }
        }

        return view('reverse_transaction.index', compact('modelDatas','menu'));
    }

    public function selectDocument(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/reverse_transaction" ? "building" : "repair";    
        
        return view('reverse_transaction.selectDocument', compact('menu'));
    }

    public function create($documentType, $id, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/reverse_transaction" ? "building" : "repair";    
        $modelData = [];
        $modelDataDetails = [];

        if($documentType == 1){
            $modelData = GoodsReceipt::where('id',$id)->with('purchaseOrder.project','purchaseOrder.vendor')->first();
            $modelDataDetails = GoodsReceiptDetail::where('goods_receipt_id',$id)->with('material.uom', 'storageLocation')->get();
            $po_id= $modelData->purchaseOrder->id;

            foreach ($modelDataDetails as $dataDetail) {
                $dataDetail->po_detail = PurchaseOrderDetail::where('purchase_order_id',$po_id)->where('material_id', $dataDetail->material_id)->first();
                $dataDetail->new_qty = "";
            }
            
        }
        
        return view('reverse_transaction.create', compact('menu', 'modelData','modelDataDetails', 'documentType'));
    }

    public function store(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/reverse_transaction" ? "building" : "repair";    
        $datas = json_decode($request->datas);
        if($menu == 'building'){
            $business_unit = 1;
        }elseif($menu == 'repair'){
            $business_unit = 2;
        }
        DB::beginTransaction();
        try {
            $RT = new ReverseTransaction;
            $RT->type = $datas->documentType;
            $RT->number = $this->generateRTNumber();
            $RT->business_unit_id = $business_unit;
            $RT->old_reference_document = $datas->modelData->id;
            $RT->description = $datas->description;
            $RT->status = 1;
            $RT->user_id = Auth::user()->id;
            $RT->branch_id = Auth::user()->branch->id;
            $RT->save();
            foreach($datas->modelDataDetails as $data){
                //RTD
                $RTD = new ReverseTransactionDetail;
                $RTD->reverse_transaction_id = $RT->id;
                $RTD->material_id = $data->material_id;
                $RTD->old_quantity = $data->quantity;
                $RTD->old_reference_document_detail = $data->id;
                $RTD->new_quantity = $data->new_qty;
                $RTD->save();
            }

            DB::commit();
            if($menu == "building"){
                return redirect()->route('reverse_transaction.show',$RT->id)->with('success', 'Reverse Transaction Created');
            }elseif($menu == "repair"){
                return redirect()->route('reverse_transaction_repair.show',$RT->id)->with('success', 'Reverse Transaction Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('reverse_transaction.create',[$datas->documentType,$datas->modelData->id])->with('error', $e->getMessage());
            }elseif($menu == "repair"){
                return redirect()->route('reverse_transaction_repair.create',[$datas->documentType,$datas->modelData->id])->with('error', $e->getMessage());
            }
        }
    }

    public function show(Request $request, $id)
    {
        $menu = $request->route()->getPrefix() == "/reverse_transaction" ? "building" : "repair";
        $modelRT = ReverseTransaction::find($id);
        $type = "";
        if($modelRT->type == 1){
            $type = "Goods Receipt";
            $modelRT->url_type = $menu == "building" ? "goods_receipt" : "goods_receipt_repair";
            $modelRT->oldReferenceDocument = GoodsReceipt::find($modelRT->old_reference_document);
            if($modelRT->new_reference_document != null){
                $modelRT->newReferenceDocument = GoodsReceipt::find($modelRT->new_reference_document);
            }
        }

        if($modelRT->status == 1){
            $status = 'OPEN';
        }
        elseif($modelRT->status == 2){
            $status = 'APPROVED';
        }
        elseif($modelRT->status == 3){
            $status = 'NEEDS REVISION';
        }
        elseif($modelRT->status == 4){
            $status = 'REVISED';
        }
        elseif($modelRT->status == 5){
            $status = 'REJECTED';
        }

        return view('reverse_transaction.show', compact('modelRT','menu','type', 'status'));
    }

    public function indexApprove(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/reverse_transaction" ? "building" : "repair";    
        if($menu == "building"){
            $modelDatas = ReverseTransaction::whereIn('status',[1,4])->where('business_unit_id',1)->get();
        }elseif($menu == "repair"){
            $modelDatas = ReverseTransaction::whereIn('status',[1,4])->where('business_unit_id',2)->get();
        }
        foreach ($modelDatas as $data) {
            if($data->type == 1){
                $data->type_string = "Goods Receipt";
                $data->referenceDocument = GoodsReceipt::find($data->old_reference_document);
            }
        }

        return view('reverse_transaction.indexApprove', compact('modelDatas','menu'));
    }

    public function showApprove(Request $request, $id)
    {
        $menu = $request->route()->getPrefix() == "/reverse_transaction" ? "building" : "repair";    
        $modelRT = ReverseTransaction::findOrFail($id);
        if($modelRT->type == 1){
            $type = "Goods Receipt";
            $modelRT->url_type = $menu == "building" ? "goods_receipt" : "goods_receipt_repair";
            $modelRT->referenceDocument = GoodsReceipt::find($modelRT->old_reference_document);
        }

        if($modelRT->status == 1){
            $status = 'OPEN';
        }
        elseif($modelRT->status == 2){
            $status = 'APPROVED';
        }
        elseif($modelRT->status == 3){
            $status = 'NEEDS REVISION';
        }
        elseif($modelRT->status == 4){
            $status = 'REVISED';
        }
        elseif($modelRT->status == 5){
            $status = 'REJECTED';
        }

        return view('reverse_transaction.showApprove', compact('modelRT','menu','status','type'));
    }

    public function approval(Request $request)
    {
        $datas = json_decode($request->datas);
        $menu = $request->route()->getPrefix() == "/reverse_transaction" ? "building" : "repair";   
        DB::beginTransaction();
        try{
            $modelRT = ReverseTransaction::findOrFail($datas->rt_id);
            if($datas->status == "approve"){
                if($modelRT->type==1){
                    $this->reverseGoodsReceipt($modelRT->old_reference_document,$modelRT->reverseTransactionDetails,$menu, $modelRT);
                }
                
                $modelRT->status = 2;
                $modelRT->revision_description = $datas->desc;
                $modelRT->approved_by = Auth::user()->id;
                $modelRT->approval_date = Carbon::now();
                $modelRT->update();
                DB::commit();
                if($menu == "building"){
                    return redirect()->route('reverse_transaction.show',$datas->rt_id)->with('success', 'Reverse Transaction Approved');
                }elseif($menu == "repair"){
                    // return redirect()->route('reverse_transaction_repair.show',$datas->rt_id)->with('success', 'Material Requisition Need Revision');
                }
            }elseif($datas->status == "need-revision"){
                $modelRT->status = 3;
                $modelRT->revision_description = $datas->desc;
                $modelRT->approved_by = Auth::user()->id;
                $modelRT->approval_date = Carbon::now();
                $modelRT->update();
                DB::commit();
                if($menu == "building"){
                    return redirect()->route('reverse_transaction.show',$datas->rt_id)->with('success', 'Reverse Transaction Need Revision');
                }elseif($menu == "repair"){
                    // return redirect()->route('reverse_transaction_repair.show',$datas->rt_id)->with('success', 'Material Requisition Need Revision');
                }
            }elseif($datas->status == "reject"){
                $modelRT->status = 5;
                $modelRT->revision_description = $datas->desc;
                $modelRT->approved_by = Auth::user()->id;
                $modelRT->approval_date = Carbon::now();
                $modelRT->update();
                DB::commit();
                if($menu == "building"){
                    return redirect()->route('reverse_transaction.show',$datas->rt_id)->with('success', 'Reverse Transaction Rejected');
                }elseif($menu == "repair"){
                    // return redirect()->route('reverse_transaction_repair.show',$datas->rt_id)->with('success', 'Material Requisition Rejected');
                }
            }
        } catch (\Exception $e){
            DB::rollback();
            return redirect()->route('reverse_transaction.show',$datas->rt_id)->with('error', $e->getMessage());
        }
    }

    public function edit($id, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/reverse_transaction" ? "building" : "repair";    
        $modelRT = [];
        $modelRTDetails = [];
        $modelRT = ReverseTransaction::find($id);
        if($modelRT->status == 1){
            $status = 'OPEN';
        }
        elseif($modelRT->status == 2){
            $status = 'APPROVED';
        }
        elseif($modelRT->status == 3){
            $status = 'NEEDS REVISION';
        }
        elseif($modelRT->status == 4){
            $status = 'REVISED';
        }
        elseif($modelRT->status == 5){
            $status = 'REJECTED';
        }
        if($modelRT->type == 1){
            $old_gr_ref = GoodsReceipt::where('id',$modelRT->old_reference_document)->with('purchaseOrder.project','purchaseOrder.vendor')->first();
            $modelRTDetails = ReverseTransactionDetail::where('reverse_transaction_id',$modelRT->id)->with('material.uom')->get();
            $po_id= $old_gr_ref->purchaseOrder->id;
            
            foreach ($modelRTDetails as $dataDetail) {
                $dataDetail->po_detail = PurchaseOrderDetail::where('purchase_order_id',$po_id)->where('material_id', $dataDetail->material_id)->first();
                $dataDetail->grd = GoodsReceiptDetail::where('id',$dataDetail->old_reference_document_detail)->with('material.uom', 'storageLocation')->first();
            }
            
        }
        
        return view('reverse_transaction.edit', compact('menu', 'modelRT','modelRTDetails','old_gr_ref','status'));
    }

    public function update(Request $request, $id)
    {
        $menu = $request->route()->getPrefix() == "/reverse_transaction" ? "building" : "repair";    
        $datas = json_decode($request->datas);
        if($menu == 'building'){
            $business_unit = 1;
        }elseif($menu == 'repair'){
            $business_unit = 2;
        }
        DB::beginTransaction();
        try {
            $RT = ReverseTransaction::find($id);
            $RT->description = $datas->description;
            $RT->update();
            foreach($datas->modelRTDetails as $data){
                //RTD
                $RTD = ReverseTransactionDetail::find($data->id);
                $RTD->new_quantity = $data->new_quantity;
                $RTD->update();
            }

            DB::commit();
            if($menu == "building"){
                return redirect()->route('reverse_transaction.show',$RT->id)->with('success', 'Reverse Transaction Updated');
            }elseif($menu == "repair"){
                return redirect()->route('reverse_transaction_repair.show',$RT->id)->with('success', 'Reverse Transaction Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('reverse_transaction.edit',[$RT->id])->with('error', $e->getMessage());
            }elseif($menu == "repair"){
                return redirect()->route('reverse_transaction_repair.edit',[$RT->id])->with('error', $e->getMessage());
            }
        }
    }



    //Function
    public function generateRTNumber(){
        $modelRT = ReverseTransaction::orderBy('created_at','desc')->first();
        $yearNow = date('y');
        
		$number = 1;
        if(isset($modelRT)){
            $yearDoc = substr($modelRT->number, 3,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelRT->number, -5));
            }
        }

        $year = date($yearNow.'000000');
        $year = intval($year);

		$rt_number = $year+$number;
        $rt_number = 'RT-'.$rt_number;
        
        return $rt_number;
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

    public function reverseGoodsReceipt($old_gr_id,$datas, $menu, $modelRT){
        if($menu == 'building'){
            $business_unit = 1;
        }elseif($menu == 'repair'){
            $business_unit = 2;
        }
        $old_gr_ref = GoodsReceipt::find($old_gr_id);
        $old_gr_ref->status = 2;
        $old_gr_ref->update();

        //GI
        $GI = new GoodsIssue;
        $GI->number = $this->generateGINumber();
        $GI->business_unit_id = $business_unit;
        $GI->description = "AUTO CREATE GI FROM REVERSE TRANSACTION";
        $GI->type = 6;
        $GI->branch_id = Auth::user()->branch->id;
        $GI->user_id = Auth::user()->id;
        $GI->save();
        
        //GR
        $GR = new GoodsReceipt;
        $GR->number = $this->generateGRNumber();
        $GR->business_unit_id = $business_unit;
        $GR->purchase_order_id = $old_gr_ref->purchase_order_id;
        $GR->type = 6;
        $GR->description = "AUTO CREATE GR FROM REVERSE TRANSACTION";
        if($old_gr_ref->ship_date != null){
            $GR->ship_date = $old_gr_ref->ship_date;
        }
        $GR->branch_id = Auth::user()->branch->id;
        $GR->user_id = Auth::user()->id;
        $GR->save();

        $modelRT->new_reference_document = $GR->id;
        $modelRT->update();

        foreach($datas as $data){
            //GID
            $old_grd_ref = GoodsReceiptDetail::find($data->old_reference_document_detail);
            $GID = new GoodsIssueDetail;
            $GID->goods_issue_id = $GI->id;
            $GID->quantity = $data->old_quantity;
            $GID->material_id = $data->material_id;
            $GID->storage_location_id = $old_grd_ref->storage_location_id;
            $GID->save();

            $this->updateStockForGI($data->material_id, $data->old_quantity);
            $this->updateSlocDetailForGI($data->material_id, $old_grd_ref->storage_location_id,$data->old_quantity,$data->old_reference_document_detail);
            if($data->new_quantity != 0){
                //GRD
                $GRD = new GoodsReceiptDetail;
                $GRD->goods_receipt_id = $GR->id;
                $GRD->quantity = $data->new_quantity; 
                $GRD->material_id = $data->material_id;
                $GRD->storage_location_id = $old_grd_ref->storage_location_id;
                if($old_grd_ref->received_date != null){
                    $GRD->received_date = $old_grd_ref->received_date;
                }
                $GRD->item_OK = $old_grd_ref->item_OK;
                $GRD->save();
                
                $this->updateStockForGR($data->material_id, $data->new_quantity);
                $this->updateSlocDetailForGR($data,$GRD->id, $old_grd_ref);
                
                $data->new_reference_document_detail = $GRD->id;
                $data->update();
            }
            $diff_qty = $data->new_quantity - $data->old_quantity;
            $po_detail_id = PurchaseOrderDetail::where('purchase_order_id',$old_gr_ref->purchase_order_id)->where('material_id', $data->material_id)->first()->id;
            $this->updatePOD($po_detail_id, $diff_qty);
           
        }
        $this->checkStatusPO($old_gr_ref->purchase_order_id);
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
            $modelPO->update();
        }else{
            $modelPO->status = 2;
            $modelPO->update();
        }
    }

    public function updatePOD($purchase_order_detail_id, $diff_qty){
        $modelPOD = PurchaseOrderDetail::findOrFail($purchase_order_detail_id);

        if($modelPOD){
            if($diff_qty == 0){
                $modelPOD->received = 0;
                $modelPOD->update();
            }else{
                $modelPOD->received = $modelPOD->received + $diff_qty;
                $modelPOD->update();
            }
        }
    }

    public function updateStockForGR($material_id,$received){
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

    public function updateSlocDetailForGR($data,$new_grd_id, $old_grd){
        $modelSlocDetail = new StorageLocationDetail;
        $modelSlocDetail->quantity = $data->new_quantity;
        $modelSlocDetail->value = $old_grd->storageLocationDetail->value;
        $modelSlocDetail->goods_receipt_detail_id = $new_grd_id;
        $modelSlocDetail->material_id = $data->material_id;
        $modelSlocDetail->storage_location_id = $old_grd->storage_location_id;
        $modelSlocDetail->save();
    }

    public function updateStockForGI($material_id,$issued){
        $modelStock = Stock::where('material_id',$material_id)->first();
        
        if($modelStock){
            $modelStock->quantity = $modelStock->quantity - $issued;
            $modelStock->reserved = $modelStock->reserved - $issued;
            $modelStock->save();
        }
    }

    public function updateSlocDetailForGI($material_id,$sloc_id,$issued, $GRD_id){
        $modelSlocDetail = StorageLocationDetail::where('material_id',$material_id)->where('storage_location_id',$sloc_id)->where('goods_receipt_detail_id', $GRD_id)->first();
        if($modelSlocDetail){
            $modelSlocDetail->quantity = $modelSlocDetail->quantity - $issued;
            $modelSlocDetail->update();
        }
    }

    //API
    public function getDocuments($type, $menu)
    {
        $modelData = [];
        $business_unit_id = $menu == "building" ? 1 : 2;
        if($type == 1){
            $modelData = GoodsReceipt::where('business_unit_id', $business_unit_id)->where('status','!=',2)->get();
        }else if($type == 2){
            $modelData = GoodsIssue::where('business_unit_id', $business_unit_id)->where('status','!=',2)->get();
        }

        foreach ($modelData as $data) {
            $temp_date = $data->created_at->format('d-m-Y');
            $data->created_at_date = $temp_date;
        }
        return response($modelData, Response::HTTP_OK);
    }
}
