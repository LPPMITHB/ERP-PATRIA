<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\GoodsIssue;
use App\Models\GoodsReturn;
use App\Models\GoodsReturnDetail;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptDetail;
use App\Models\Project;
use App\Models\GoodsIssueDetail;
use App\Models\PurchaseRequisition;
use App\Models\MaterialRequisition;
use App\Models\MaterialRequisitionDetail;
use App\Models\StorageLocation;
use App\Models\Stock;
use App\Models\StorageLocationDetail;
use App\Models\Branch;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use DB;
use Auth;
// use App\Http\Controllers\Controller;

class GoodsReturnController extends Controller
{
    public function indexGoodsReturn(Request $request){
        $menu = $request->route()->getPrefix() == "/goods_return" ? "building" : "repair";    
        if($menu == "repair"){
            $business_unit = 2;
        }else{
            $business_unit = 1;
        }

        $modelGIs = GoodsReturn::where('business_unit_id',$business_unit)->get();

        return view ('goods_return.index', compact('modelGIs','menu'));
    }

    public function indexApprove(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_return" ? "building" : "repair";    
        if($menu == "repair"){
            $business_unit_id = 2;
        }elseif($menu == "building"){
            $business_unit_id = 1;
        }
        $modelGoodsReturns = GoodsIssue::whereIn('status',[1,4])->where('business_unit_id',$business_unit_id)->where('type',4)->get();

        return view('goods_return.indexApprove', compact('modelGoodsReturns','menu'));
    }
    
    public function showApprove($id, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_return" ? "building" : "repair";    

        $modelGI = GoodsIssue::findOrFail($id);
        if($modelGI->status == 1){
            $status = 'OPEN';
        }
        elseif($modelGI->status == 2){
            $status = 'APPROVED';
        }
        elseif($modelGI->status == 3){
            $status = 'NEEDS REVISION';
        }
        elseif($modelGI->status == 4){
            $status = 'REVISED';
        }
        elseif($modelGI->status == 5){
            $status = 'REJECTED';
        }
        elseif($modelGI->status == 0 || $modelGI->status == 7){
            $status = 'ORDERED';
        }
        elseif($modelGI->status == 6){
            $status = 'CONSOLIDATED';
        }

        return view('goods_return.showApprove', compact('modelGI','menu','status'));
    }

    public function approval(Request $request)
    {
        $datas = json_decode($request->datas);
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try{
            $modelGI = GoodsIssue::findOrFail($datas->gi_id);
            if($datas->status == "approve"){
                $modelGI->status = 2;
                $modelGI->approved_by = Auth::user()->id;
                $modelGI->update();
                DB::commit();
                if($route == "/goods_return"){
                    return redirect()->route('goods_return.show',$datas->gi_id)->with('success', 'Goods Return Approved');
                }elseif($route == "/goods_return_repair"){
                    return redirect()->route('goods_return_repair.show',$datas->gi_id)->with('success', 'Goods Return Approved');
                }
            }elseif($datas->status == "need-revision"){
                $modelGI->status = 3;
                $modelGI->approved_by = Auth::user()->id;
                $modelGI->update();
                DB::commit();
                if($route == "/goods_return"){
                    return redirect()->route('goods_return.show',$datas->gi_id)->with('success', 'Goods Return Need Revision');
                }elseif($route == "/goods_return_repair"){
                    return redirect()->route('goods_return_repair.show',$datas->gi_id)->with('success', 'Goods Return Need Revision');
                }
            }elseif($datas->status == "reject"){
                $modelGI->status = 5;
                $modelGI->approved_by = Auth::user()->id;
                $modelGI->update();
                DB::commit();
                if($route == "/goods_return"){
                    return redirect()->route('goods_return.show',$datas->gi_id)->with('success', 'Goods Return Rejected');
                }elseif($route == "/goods_return_repair"){
                    return redirect()->route('goods_return_repair.show',$datas->gi_id)->with('success', 'Goods Return Rejected');
                }
            }
        } catch (\Exception $e){
            DB::rollback();
            return redirect()->route('goods_return.show',$datas->gi_id)->with('error', $e->getMessage());
        }
    }

    public function createGoodsReturnGR($id,Request $request){

        $route = $request->route()->getPrefix();    
        $modelGR = GoodsReceipt::find($id);
        $vendor = $modelGR->purchaseOrder->vendor;
        $modelGRD = GoodsReceiptDetail::whereRaw('quantity - returned != 0')->where('goods_receipt_id',$modelGR->id)->with('material','material.uom')->get();
        foreach($modelGRD as $MRD){
            $MRD['returned_temp'] = 0;
        }

        return view('goods_return.createGoodsReturnGR', compact('modelGR','modelGRD','route','vendor'));
    }

    public function createGoodsReturnPO($id,Request $request){

        $route = $request->route()->getPrefix();    
        $modelPO = PurchaseOrder::find($id);
        $vendor = $modelPO->vendor;
        $modelPOD = PurchaseOrderDetail::whereRaw('quantity - received - returned != 0')->where('purchase_order_id',$modelPO->id)->with('material','material.uom')->get();
        foreach($modelPOD as $POD){
            $POD['returned_temp'] = 0;
        }

        return view('goods_return.createGoodsReturnPO', compact('modelPO','modelPOD','route','vendor'));
    }

    public function storeGoodsReturnGR(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_return" ? "building" : "repair";    
        $datas = json_decode($request->datas);
        $gi_number = $this->generateGINumber();

        DB::beginTransaction();
        try {
            $GI = new GoodsIssue;
            $GI->number = $gi_number;
            $GI->goods_receipt_id = $datas->goods_receipt_id;
            $GI->description = $datas->description;
            if($menu ==  "building"){
                $GI->business_unit_id = 1;
            }elseif($menu == "repair"){
                $GI->business_unit_id = 2;
            }
            $GI->type = 4;
            $GI->branch_id = Auth::user()->branch->id;
            $GI->user_id = Auth::user()->id;
            $GI->save();
            foreach($datas->GRD as $GRD){
                if($GRD->returned_temp > 0){
                    $GRD_returned = GoodsReceiptDetail::find($GRD->id);
                    $GRD_returned->returned += $GRD->returned_temp;
                    $GRD_returned->update();

                    $GID = new GoodsIssueDetail;
                    $GID->goods_issue_id = $GI->id;
                    $GID->quantity = $GRD->returned_temp;
                    $GID->material_id = $GRD->material_id;
                    $GID->storage_location_id = $GRD->storage_location_id;
                    $GID->save();

                    $this->updateStock($GRD->material_id, $GRD->returned_temp);
                    $this->updateSlocDetail($GRD->material_id, $GRD->storage_location_id,$GRD->returned_temp);
                    $this->checkStatusGR($datas->goods_receipt_id);
                }
            }
            DB::commit();
            if($menu == "building"){
                return redirect()->route('goods_return.show',$GI->id)->with('success', 'Goods Return Created');
            }else{
                return redirect()->route('goods_return_repair.show',$GI->id)->with('success', 'Goods Return Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('goods_return.selectGR')->with('error', $e->getMessage());
            }else{
                // return redirect()->route('goods_issue_repair.selectMR',$datas->mr_id)->with('error', $e->getMessage());
            }
        }
    }

    public function storeGoodsReturnPO(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_return" ? "building" : "repair";    
        $datas = json_decode($request->datas);
        $gr_number = $this->generateGRNumber();

        DB::beginTransaction();
        try {
            $GR = new GoodsReturn;
            $GR->number = $gr_number;
            if($menu ==  "building"){
                $GR->business_unit_id = 1;
            }elseif($menu == "repair"){
                $GR->business_unit_id = 2;
            }
            $GR->purchase_order_id = $datas->purchase_order_id;
            $GR->description = $datas->description;
            $GR->branch_id = Auth::user()->branch->id;
            $GR->user_id = Auth::user()->id;
            $GR->save();

            foreach($datas->POD as $POD){
                if($POD->returned_temp > 0){
                    $GRD = new GoodsReturnDetail;
                    $GRD->goods_return_id = $GR->id;
                    $GRD->quantity = $POD->returned_temp;
                    $GRD->material_id = $POD->material_id;
                    $GRD->save();

                    $this->checkStatusPO($datas->purchase_order_id);
                }
            }
            // $GI = new GoodsIssue;
            // $GI->number = $gi_number;
            // $GI->purchase_order_id = $datas->purchase_order_id;
            // $GI->description = $datas->description;
            // if($menu ==  "building"){
            //     $GI->business_unit_id = 1;
            // }elseif($menu == "repair"){
            //     $GI->business_unit_id = 2;
            // }
            // $GI->type = 4;
            // $GI->status = 1;
            // $GI->branch_id = Auth::user()->branch->id;
            // $GI->user_id = Auth::user()->id;
            // $GI->save();
            // foreach($datas->POD as $POD){
            //     if($POD->returned_temp > 0){
            //         $POD_returned = PurchaseOrderDetail::find($POD->id);
            //         $POD_returned->returned += $POD->returned_temp;
            //         $POD_returned->update();

            //         $GID = new GoodsIssueDetail;
            //         $GID->goods_issue_id = $GI->id;
            //         $GID->quantity = $POD->returned_temp;
            //         $GID->material_id = $POD->material_id;
            //         $GID->save();

            //         $this->checkStatusPO($datas->purchase_order_id);
            //     }
            // }
            DB::commit();
            if($menu == "building"){
                return redirect()->route('goods_return.show',$GR->id)->with('success', 'Goods Return Created');
            }else{
                return redirect()->route('goods_return_repair.show',$GR->id)->with('success', 'Goods Return Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('goods_return.selectPO')->with('error', $e->getMessage());
            }else{
                // return redirect()->route('goods_issue_repair.selectMR',$datas->mr_id)->with('error', $e->getMessage());
            }
        }
    }

    public function selectPO(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_return" ? "building" : "repair";    
        // if($menu == "repair"){
        //     $modelProject = Project::where('status',1)->where('business_unit_id',2)->pluck('id')->toArray();
        // }else{
        //     $modelProject = Project::where('status',1)->where('business_unit_id',1)->pluck('id')->toArray();
        // }

        if($menu == "building"){
            $modelPR = PurchaseRequisition::where('business_unit_id',1)->pluck('id')->toArray();
            $modelPOs = PurchaseOrder::whereIn('purchase_requisition_id',$modelPR)->where('status',2)->get();
            
        }elseif($menu == "repair"){
            $modelPR = PurchaseRequisition::where('business_unit_id',2)->pluck('id')->toArray();
            $modelPOs = PurchaseOrder::whereIn('purchase_requisition_id',$modelPR)->where('status',2)->get();

        }

        // $modelPRs = PurchaseRequisition::where('type',1)->pluck('id')->toArray();
        // $modelPOs = PurchaseOrder::whereIn('purchase_requisition_id',$modelPRs)->whereIn('project_id', $modelProject)->where('status',2)->get();

        return view('goods_return.selectPO', compact('modelPOs','menu'));
    }

    public function selectGR(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_return" ? "building" : "repair";    
        if($menu == "building"){
            $business_unit = 1;
        }elseif($menu == "repair"){
            $business_unit = 2;
        }
        $modelPRs = PurchaseRequisition::where('type',1)->pluck('id')->toArray();
        $modelPOs = PurchaseOrder::whereIn('purchase_requisition_id',$modelPRs)->pluck('id')->toArray();
        $modelGRs = GoodsReceipt::whereIn('purchase_order_id',$modelPOs)->where('business_unit_id', $business_unit)->where('status',1)->get();

        return view('goods_return.selectGR', compact('modelGRs','menu'));
    }

    public function show(Request $request,$id)
    {
        $route = $request->route()->getPrefix();    
        $modelGR = GoodsReturn::findOrFail($id);
        $modelGRD = $modelGR->GoodsReturnDetails;
        $approve = FALSE;

        return view('goods_return.show', compact('modelGR','modelGRD','approve','route'));
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
        $modelGR = GoodsReturn::orderBy('created_at','desc')->first();
        $yearNow = date('y');
        
		$number = 1;
        if(isset($modelGR)){
            $yearDoc = substr($modelGR->number, 4,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelGR->number, -5));
            }
        }

        $year = date($yearNow.'000000');
        $year = intval($year);

		$gr_number = $year+$number;
        $gr_number = 'GRT-'.$gr_number;

        return $gr_number;
    }

    public function checkStatusPO($po_id){
        $modelPO = PurchaseOrder::findOrFail($po_id);
        $status = 0;
        foreach($modelPO->purchaseOrderDetails as $POD){
            if($POD->returned + $POD->received < $POD->quantity){
                $status = 2;
            }
        }
        if($status == 0){
            $modelPO->status = 0;
            $modelPO->save();
        }
    }

    public function checkStatusGR($gr_id){
        $modelGR = GoodsReceipt::findOrFail($gr_id);
        $status = 0;
        foreach($modelGR->goodsReceiptDetails as $GRD){
            if($GRD->returned < $GRD->quantity){
                $status = 1;
            }
        }
        if($status == 0){
            $modelGR->status = 0;
            $modelGR->save();
        }
    }

    public function updateStock($material_id,$issued){
        $modelStock = Stock::where('material_id',$material_id)->first();
        
        if($modelStock){
            $modelStock->quantity = $modelStock->quantity - $issued;
            $modelStock->reserved = $modelStock->reserved - $issued;
            $modelStock->save();
        }else{

        }
    }

    public function updateSlocDetail($material_id,$sloc_id,$issued){
        $modelSlocDetail = StorageLocationDetail::where('material_id',$material_id)->where('storage_location_id',$sloc_id)->first();
        
        if($modelSlocDetail){
            $modelSlocDetail->quantity = $modelSlocDetail->quantity - $issued;
            $modelSlocDetail->save();
        }else{

        }
    }
}
