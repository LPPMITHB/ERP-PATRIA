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
use App\Models\MaterialRequisition;
use App\Models\MaterialRequisitionDetail;
use App\Models\Stock;
use App\Models\StorageLocationDetail;
use App\Models\Branch;
use Illuminate\Support\Collection;
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
            }elseif($data->type == 2){
                $data->type_string = "Goods Issue";
                $data->referenceDocument = GoodsIssue::find($data->old_reference_document);
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
        $route_string = $menu == "repair" ? "_repair":"";
        if($documentType == 1){
            $modelData = GoodsReceipt::where('id',$id)->with('purchaseOrder.project','purchaseOrder.vendor')->first();
            $modelData->url_type = "goods_receipt".$route_string;
            $modelData->purchaseOrder->url_type = "purchase_order".$route_string;

            $modelDataDetails = GoodsReceiptDetail::where('goods_receipt_id',$id)->with('material.uom', 'storageLocation')->get();
            $po_id= $modelData->purchaseOrder->id;

            foreach ($modelDataDetails as $dataDetail) {
                $dataDetail->po_detail = PurchaseOrderDetail::where('purchase_order_id',$po_id)->where('material_id', $dataDetail->material_id)->first();
                $dataDetail->new_qty = "";
            }  
        }elseif($documentType == 2){
            $modelData = GoodsIssue::where('id',$id)->with('materialRequisition.project')->first();
            $modelData->url_type = "goods_issue".$route_string;
            $modelData->materialRequisition->url_type = "material_requisition".$route_string;

            $temp_gid = GoodsIssueDetail::where('goods_issue_id',$id)->with('material.uom', 'storageLocation')->get()->groupBy('material_id');
            $mr_id= $modelData->materialRequisition->id;

            $modelDataDetails = Collection::make();
            foreach ($temp_gid as $material_id => $data) {
                $temp_data = null;
                foreach ($data as $gid) {
                    if($temp_data == null){
                        $temp_data = $gid;
                    }else{
                        $temp_data->quantity += $gid->quantity;
                    }
                }
                $modelDataDetails->push($temp_data);
            }

            foreach ($modelDataDetails as $dataDetail) {
                $dataDetail->mr_detail = MaterialRequisitionDetail::where('material_requisition_id',$mr_id)->where('material_id', $dataDetail->material_id)->first();
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
        }elseif($modelRT->type == 2){
            $type = "Goods Issue";
            $modelRT->url_type = $menu == "building" ? "goods_issue" : "goods_issue_repair";
            $modelRT->oldReferenceDocument = GoodsIssue::find($modelRT->old_reference_document);
            if($modelRT->new_reference_document != null){
                $modelRT->newReferenceDocument = GoodsIssue::find($modelRT->new_reference_document);
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
            }elseif($data->type == 2){
                $data->type_string = "Goods Issue";
                $data->referenceDocument = GoodsIssue::find($data->old_reference_document);
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
        }elseif($modelRT->type == 2){
            $type = "Goods Issue";
            $modelRT->url_type = $menu == "building" ? "goods_issue" : "goods_issue_repair";
            $modelRT->referenceDocument = GoodsIssue::find($modelRT->old_reference_document);
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
                }elseif($modelRT->type==2){
                    $this->reverseGoodsIssue($modelRT->old_reference_document,$modelRT->reverseTransactionDetails,$menu, $modelRT);
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
            return redirect()->route('reverse_transaction.showApprove',$datas->rt_id)->with('error', $e->getMessage());
        }
    }

    public function edit($id, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/reverse_transaction" ? "building" : "repair";    
        $modelRT = [];
        $modelRTDetails = [];
        $modelRT = ReverseTransaction::find($id);
        $route_string = $menu == "repair" ? "_repair":"";
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
            $old_data = GoodsReceipt::where('id',$modelRT->old_reference_document)->with('purchaseOrder.project','purchaseOrder.vendor')->first();
            $old_data->url_type = "goods_receipt".$route_string;
            $old_data->purchaseOrder->url_type = "purchase_order".$route_string;

            $modelRTDetails = ReverseTransactionDetail::where('reverse_transaction_id',$modelRT->id)->with('material.uom')->get();
            $po_id= $old_data->purchaseOrder->id;
            
            foreach ($modelRTDetails as $dataDetail) {
                $dataDetail->po_detail = PurchaseOrderDetail::where('purchase_order_id',$po_id)->where('material_id', $dataDetail->material_id)->first();
                $dataDetail->grd = GoodsReceiptDetail::where('id',$dataDetail->old_reference_document_detail)->with('material.uom', 'storageLocation')->first();
            }
            
        }elseif($modelRT->type == 2){
            $old_data = GoodsIssue::where('id',$modelRT->old_reference_document)->with('materialRequisition.project')->first();
            $old_data->url_type = "goods_issue".$route_string;
            $old_data->materialRequisition->url_type = "material_requisition".$route_string;

            $modelRTDetails = ReverseTransactionDetail::where('reverse_transaction_id',$modelRT->id)->with('material.uom')->get();
            $mr_id= $old_data->materialRequisition->id;

            foreach ($modelRTDetails as $dataDetail) {
                $dataDetail->mr_detail = MaterialRequisitionDetail::where('material_requisition_id',$mr_id)->where('material_id', $dataDetail->material_id)->first();
                $dataDetail->gid = GoodsIssueDetail::where('id',$dataDetail->old_reference_document_detail)->with('material.uom', 'storageLocation')->first();
            }  
        }
        
        return view('reverse_transaction.edit', compact('menu', 'modelRT','modelRTDetails','old_data','status'));
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
            if($RT->status == 3){
                $RT->status = 4;
            }
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
            $old_grd_ref = GoodsReceiptDetail::find($data->old_reference_document_detail);
            //GID
            $GID = new GoodsIssueDetail;
            $GID->goods_issue_id = $GI->id;
            $GID->quantity = $data->old_quantity;
            $GID->material_id = $data->material_id;
            $GID->storage_location_id = $old_grd_ref->storage_location_id;
            $GID->goods_receipt_detail_id_sloc_detail = $data->old_reference_document_detail;
            
            $this->updateStockForGI($data->material_id, $data->old_quantity);
            $this->updateSlocDetailGIForReverseGR($data->material_id, $old_grd_ref->storage_location_id,$data->old_quantity,$data->old_reference_document_detail,$GID);
            $GID->save();
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
                $this->updateSlocDetailGRForReverseGR($data,$GRD->id, $old_grd_ref);
                
                $data->new_reference_document_detail = $GRD->id;
                $data->update();
            }
            $diff_qty = $data->new_quantity - $data->old_quantity;
            $po_detail_id = PurchaseOrderDetail::where('purchase_order_id',$old_gr_ref->purchase_order_id)->where('material_id', $data->material_id)->first()->id;
            $this->updatePOD($po_detail_id, $diff_qty);
           
        }
        $this->checkStatusPO($old_gr_ref->purchase_order_id);
    }

    public function reverseGoodsIssue($old_gr_id,$datas, $menu, $modelRT){
        if($menu == 'building'){
            $business_unit = 1;
        }elseif($menu == 'repair'){
            $business_unit = 2;
        }
        $old_gi_ref = GoodsIssue::find($old_gr_id);
        $old_gi_ref->status = 2;
        $old_gi_ref->update();
        
        //GR
        $GR = new GoodsReceipt;
        $GR->number = $this->generateGRNumber();
        $GR->business_unit_id = $business_unit;
        $GR->description = "AUTO CREATE GR FROM REVERSE TRANSACTION";
        $GR->type = 6;
        $GR->branch_id = Auth::user()->branch->id;
        $GR->user_id = Auth::user()->id;
        $GR->save();
        foreach ($old_gi_ref->goodsIssueDetails as $gid) {
            $GRD = new GoodsReceiptDetail;
            $GRD->goods_receipt_id = $GR->id;
            $GRD->quantity = $gid->quantity;
            $GRD->material_id = $gid->material_id;
            $GRD->storage_location_id = $gid->storage_location_id;
            $GRD->save();
            $this->updateStockForGR($gid->material_id, $gid->new_quantity);
            $this->updateSlocDetailGRForReverseGI($gid,$GRD->id);
        }

        //GI
        $GI = new GoodsIssue;
        $GI->number = $this->generateGINumber();
        $GI->business_unit_id = $business_unit;
        $GI->material_requisition_id = $old_gi_ref->material_requisition_id;
        $GI->type = 6;
        $GI->description = "AUTO CREATE GI FROM REVERSE TRANSACTION";
        if($old_gi_ref->issue_date != null){
            $GI->issue_date = $old_gi_ref->issue_date;
        }
        $GI->branch_id = Auth::user()->branch->id;
        $GI->user_id = Auth::user()->id;
        $GI->save();

        $modelRT->new_reference_document = $GI->id;
        $modelRT->update();     

        foreach($datas as $data){
            $old_gid_ref = GoodsIssueDetail::find($data->old_reference_document_detail);
            if($data->new_quantity != 0){
                $temp_sloc_detail = StorageLocationDetail::join('trx_goods_receipt_detail', 'mst_storage_location_detail.goods_receipt_detail_id', '=', 'trx_goods_receipt_detail.id')
                ->orderBy('trx_goods_receipt_detail.received_date', 'asc')->where('mst_storage_location_detail.material_id', $data->material_id)->select('mst_storage_location_detail.*','trx_goods_receipt_detail.received_date')->get();

                $temp_issued = $data->new_quantity;
                foreach ($temp_sloc_detail as $sloc_detail) {
                    if($temp_issued > 0){
                        if($sloc_detail->quantity < $temp_issued){
                            $GID = new GoodsIssueDetail;
                            $GID->goods_issue_id = $GI->id;
                            $GID->quantity = $sloc_detail->quantity;
                            $GID->material_id = $data->material_id;
                            $GID->storage_location_id = $sloc_detail->storage_location_id;
                            $GID->value_sloc_detail = $sloc_detail->value;
                            $GID->goods_receipt_detail_id_sloc_detail = $sloc_detail->goods_receipt_detail_id;
                            $GID->save();

                            $temp_issued -= $sloc_detail->quantity;
                            $this->updateSlocDetailGIForReverseGI($data->material_id, $sloc_detail, $sloc_detail->quantity);
                        }else{
                            $GID = new GoodsIssueDetail;
                            $GID->goods_issue_id = $GI->id;
                            $GID->quantity = $temp_issued;
                            $GID->material_id = $data->material_id;
                            $GID->storage_location_id = $sloc_detail->storage_location_id;
                            $GID->value_sloc_detail = $sloc_detail->value;
                            $GID->goods_receipt_detail_id_sloc_detail = $sloc_detail->goods_receipt_detail_id;
                            $GID->save();

                            $this->updateSlocDetailGIForReverseGI($data->material_id, $sloc_detail,$temp_issued);
                            $temp_issued -= $sloc_detail->quantity;
                        }
                    }
                }
                
                $this->updateStockForGI($data->material_id, $data->new_quantity);
            }
            $diff_qty = $data->new_quantity - $data->old_quantity;
            $mr_detail_id = MaterialRequisitionDetail::where('material_requisition_id',$old_gi_ref->material_requisition_id)->where('material_id', $data->material_id)->first()->id;
            $this->updateMRD($mr_detail_id, $diff_qty);
           
        }
        $this->checkStatusMR($old_gi_ref->material_requisition_id);
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

    public function checkStatusMR($mr_id){
        $modelMR = MaterialRequisition::findOrFail($mr_id);
        $status = 0;
        foreach($modelMR->MaterialRequisitionDetails as $MRD){
            if($MRD->issued < $MRD->quantity){
                $status = 1;
            }
        }
        if($status == 0){
            $modelMR->status = 0;
            $modelMR->save();
        }else{
            $modelMR->status = 2;
            $modelMR->update();
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

    public function updateMRD($mrd_id, $diff_qty){
        $modelMRD = MaterialRequisitionDetail::findOrFail($mrd_id);
        if($modelMRD){
            if($diff_qty == 0){
                $modelMRD->issued = 0;
                $modelMRD->update();
            }else{
                $modelMRD->issued = $modelMRD->issued + $diff_qty;
                $modelMRD->update();
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

    public function updateSlocDetailGRForReverseGR($data,$new_grd_id, $old_grd){
        $modelSlocDetail = new StorageLocationDetail;
        $modelSlocDetail->quantity = $data->new_quantity;
        $modelSlocDetail->value = $old_grd->storageLocationDetail->value;
        $modelSlocDetail->goods_receipt_detail_id = $new_grd_id;
        $modelSlocDetail->material_id = $data->material_id;
        $modelSlocDetail->storage_location_id = $old_grd->storage_location_id;
        $modelSlocDetail->save();

        $sloc_detail = $old_grd->storageLocationDetail;
        if($sloc_detail->quantity == 0){
            $sloc_detail->delete();
        }
    }

    public function updateSlocDetailGRForReverseGI($data,$new_grd_id){
        $modelSlocDetail = new StorageLocationDetail;
        $modelSlocDetail->quantity = $data->quantity;
        $modelSlocDetail->value = $data->value_sloc_detail;
        $modelSlocDetail->goods_receipt_detail_id = $new_grd_id;
        $modelSlocDetail->material_id = $data->material_id;
        $modelSlocDetail->storage_location_id = $data->storage_location_id;
        $modelSlocDetail->save();
    }

    public function updateStockForGI($material_id,$issued){
        $modelStock = Stock::where('material_id',$material_id)->first();
        
        if($modelStock){
            $modelStock->quantity = $modelStock->quantity - $issued;
            $modelStock->save();
        }
    }

    public function updateSlocDetailGIForReverseGR($material_id,$sloc_id,$issued, $GRD_id, $GID){
        $modelSlocDetail = StorageLocationDetail::where('material_id',$material_id)->where('storage_location_id',$sloc_id)->where('goods_receipt_detail_id', $GRD_id)->first();
        $GID->value_sloc_detail = $modelSlocDetail->value;
        if($modelSlocDetail){
            $modelSlocDetail->quantity = $modelSlocDetail->quantity - $issued;
            $modelSlocDetail->update();
        }
    }

    public function updateSlocDetailGIForReverseGI($material_id,$sloc_detail,$issued){
        $modelSlocDetail = StorageLocationDetail::find($sloc_detail->id);
        
        if($modelSlocDetail){
            $modelSlocDetail->quantity = $modelSlocDetail->quantity - $issued;
            $modelSlocDetail->update();

            if($modelSlocDetail->quantity == 0){
                $modelSlocDetail->delete();
            }
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
            $modelData = GoodsIssue::where('business_unit_id', $business_unit_id)->where('status','!=',2)->where('type','!=',6)->get();
        }

        foreach ($modelData as $data) {
            $temp_date = $data->created_at->format('d-m-Y');
            $data->created_at_date = $temp_date;
        }
        return response($modelData, Response::HTTP_OK);
    }
}
