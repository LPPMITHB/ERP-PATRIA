<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsReturnController extends Controller
{
    public function indexGoodsReturn(Request $request){
        $menu = $request->route()->getPrefix() == "/goods_return" ? "building" : "repair";    
        if($menu == "repair"){
            $business_unit = 2;
        }else{
            $business_unit = 1;
        }

        $modelGIs = GoodsIssue::where('type',4)->where('business_unit_id',$business_unit)->get();

        return view ('goods_return.index', compact('modelGIs','menu'));
    }

    public function indexApprove(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_return" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->pluck('id')->toArray();
        }elseif($menu == "building"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->pluck('id')->toArray();
        }

        $modelGoodsReturns = GoodsIssue::whereIn('status',[1,4])->whereIn('project_id',$modelProject)->where('type',4)->get();

        return view('goods_return.indexApprove', compact('modelGoodsReturns','menu'));
    }
    
    public function showApprove($id, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_return" ? "building" : "repair";    

        $modelMR = GoodsIssue::findOrFail($id);

        return view('goods_return.showApprove', compact('modelMR','menu'));
    }

    public function createGoodsReturnGR($id,Request $request){

        $route = $request->route()->getPrefix();    
        $modelGR = GoodsReceipt::find($id);
        $vendor = $modelGR->purchaseOrder->vendor;
        $modelGRD = GoodsReceiptDetail::whereRaw('quantity - returned != 0')->where('goods_receipt_id',$modelGR->id)->with('material')->get();
        foreach($modelGRD as $MRD){
            $MRD['returned_temp'] = 0;
        }

        return view('goods_return.createGoodsReturnGR', compact('modelGR','modelGRD','route','vendor'));
    }

    public function createGoodsReturnPO($id,Request $request){

        $route = $request->route()->getPrefix();    
        $modelPO = PurchaseOrder::find($id);
        $vendor = $modelPO->vendor;
        $modelPOD = PurchaseOrderDetail::whereRaw('quantity - received - returned != 0')->where('purchase_order_id',$modelPO->id)->with('material')->get();
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
                return redirect()->route('goods_return.selectGR',$datas->goods_receipt_id)->with('error', $e->getMessage());
            }else{
                // return redirect()->route('goods_issue_repair.selectMR',$datas->mr_id)->with('error', $e->getMessage());
            }
        }
    }

    public function storeGoodsReturnPO(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_return" ? "building" : "repair";    
        $datas = json_decode($request->datas);
        $gi_number = $this->generateGINumber();

        DB::beginTransaction();
        try {
            $GI = new GoodsIssue;
            $GI->number = $gi_number;
            $GI->purchase_order_id = $datas->purchase_order_id;
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
            foreach($datas->POD as $POD){
                if($POD->returned_temp > 0){
                    $POD_returned = PurchaseOrderDetail::find($POD->id);
                    $POD_returned->returned += $POD->returned_temp;
                    $POD_returned->update();

                    $GID = new GoodsIssueDetail;
                    $GID->goods_issue_id = $GI->id;
                    $GID->quantity = $POD->returned_temp;
                    $GID->material_id = $POD->material_id;
                    $GID->save();

                    $this->checkStatusPO($datas->purchase_order_id);
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
                return redirect()->route('goods_return.selectGR',$datas->goods_receipt_id)->with('error', $e->getMessage());
            }else{
                // return redirect()->route('goods_issue_repair.selectMR',$datas->mr_id)->with('error', $e->getMessage());
            }
        }
    }

    public function selectPO(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_return" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->pluck('id')->toArray();
        }else{
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->pluck('id')->toArray();
        }
        $modelPRs = PurchaseRequisition::where('type',1)->pluck('id')->toArray();
        $modelPOs = PurchaseOrder::whereIn('purchase_requisition_id',$modelPRs)->whereIn('project_id', $modelProject)->where('status',2)->get();

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
        $modelGR = GoodsIssue::findOrFail($id);
        $modelGRD = $modelGR->GoodsReturnDetails;
        $approve = FALSE;

        return view('goods_return.show', compact('modelGR','modelGRD','approve','route'));
    }
}
