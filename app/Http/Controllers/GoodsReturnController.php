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
use Illuminate\Support\Collection;
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
        $modelGoodsReturns = GoodsReturn::whereIn('status',[1,4])->where('business_unit_id',$business_unit_id)->get();

        return view('goods_return.indexApprove', compact('modelGoodsReturns','menu'));
    }
    
    public function showApprove($id, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_return" ? "building" : "repair";    

        $modelGRT = GoodsReturn::findOrFail($id);
        if($modelGRT->status == 1){
            $status = 'OPEN';
        }
        elseif($modelGRT->status == 2){
            $status = 'APPROVED';
        }
        elseif($modelGRT->status == 3){
            $status = 'NEEDS REVISION';
        }
        elseif($modelGRT->status == 4){
            $status = 'REVISED';
        }
        elseif($modelGRT->status == 5){
            $status = 'REJECTED';
        }
        elseif($modelGRT->status == 0 || $modelGRT->status == 7){
            $status = 'ORDERED';
        }
        elseif($modelGRT->status == 6){
            $status = 'CONSOLIDATED';
        }

        return view('goods_return.showApprove', compact('modelGRT','menu','status'));
    }

    public function approval(Request $request)
    {
        $datas = json_decode($request->datas);
        $route = $request->route()->getPrefix();
        $gi_number = $this->generateGINumber();

        DB::beginTransaction();
        try{
            $modelGRT = GoodsReturn::findOrFail($datas->grt_id);
            $modelGRTD = GoodsReturnDetail::where('goods_return_id',$modelGRT->id)->get();

            if($datas->status == "approve"){
                $modelGRT->status = 2;
                $modelGRT->approved_by = Auth::user()->id;
                $modelGRT->update();

                if($modelGRT->purchase_order_id != null){
                    $GI = new GoodsIssue;
                    $GI->number = $gi_number;
                    $GI->goods_return_id = $modelGRT->id;
                    $GI->description = $modelGRT->description;
                    if($route ==  "/goods_return"){
                        $GI->business_unit_id = 1;
                    }elseif($route == "/goods_return_repair"){
                        $GI->business_unit_id = 2;
                    }
                    $GI->type = 4;
                    $GI->branch_id = Auth::user()->branch->id;
                    $GI->user_id = Auth::user()->id;
                    $GI->save();

                    foreach($modelGRTD as $GRT){
                        if($GRT->quantity > 0){
                            $POD_returned = PurchaseOrderDetail::where('purchase_order_id',$modelGRT->purchase_order_id)->get();
                            foreach($POD_returned as $data){
                                if($GRT->material_id == $data->material_id){
                                    $data->returned += $GRT->quantity;
                                    $data->update();
                                }
                            }

                            $GID = new GoodsIssueDetail;
                            $GID->goods_issue_id = $GI->id;
                            $GID->quantity = $GRT->quantity;
                            $GID->material_id = $GRT->material_id;
                            $GID->save();

                            $this->checkStatusPO($modelGRT->purchase_order_id);
                        }
                    }

                }elseif($modelGRT->goods_receipt_id != null){
                    $GI = new GoodsIssue;
                    $GI->number = $gi_number;
                    $GI->goods_return_id = $modelGRT->id;
                    $GI->description = $modelGRT->description;
                    if($route ==  "/goods_return"){
                        $GI->business_unit_id = 1;
                    }elseif($route == "/goods_return_repair"){
                        $GI->business_unit_id = 2;
                    }
                    $GI->type = 4;
                    $GI->branch_id = Auth::user()->branch->id;
                    $GI->user_id = Auth::user()->id;
                    $GI->save();

                    foreach($modelGRTD as $GRT){
                        if($GRT->quantity > 0){
                            $GRD_returned = GoodsReceiptDetail::where('goods_receipt_id',$modelGRT->goods_receipt_id)->get();
                            foreach($GRD_returned as $data){
                                if($GRT->material_id == $data->material_id){
                                    $data->returned += $GRT->quantity;
                                    $data->update();
                                }
                            }

                            $GID = new GoodsIssueDetail;
                            $GID->goods_issue_id = $GI->id;
                            $GID->quantity = $GRT->quantity;
                            $GID->material_id = $GRT->material_id;
                            $GID->save();

                            $this->updateStock($GRT->material_id, $GRT->quantity);
                            $this->updateSlocDetail($GRT->material_id, $GRT->storage_location_id,$GRT->quantity);
                            $this->checkStatusGR($modelGRT->goods_receipt_id);
                        }
                    }
                }


                DB::commit();
                if($route == "/goods_return"){
                    return redirect()->route('goods_return.show',$datas->grt_id)->with('success', 'Goods Return Approved');
                }elseif($route == "/goods_return_repair"){
                    return redirect()->route('goods_return_repair.show',$datas->grt_id)->with('success', 'Goods Return Approved');
                }
            }elseif($datas->status == "need-revision"){
                $modelGRT->status = 3;
                $modelGRT->approved_by = Auth::user()->id;
                $modelGRT->update();
                DB::commit();
                if($route == "/goods_return"){
                    return redirect()->route('goods_return.show',$datas->grt_id)->with('success', 'Goods Return Need Revision');
                }elseif($route == "/goods_return_repair"){
                    return redirect()->route('goods_return_repair.show',$datas->grt_id)->with('success', 'Goods Return Need Revision');
                }
            }elseif($datas->status == "reject"){
                $modelGRT->status = 5;
                $modelGRT->approved_by = Auth::user()->id;
                $modelGRT->update();
                DB::commit();
                if($route == "/goods_return"){
                    return redirect()->route('goods_return.show',$datas->grt_id)->with('success', 'Goods Return Rejected');
                }elseif($route == "/goods_return_repair"){
                    return redirect()->route('goods_return_repair.show',$datas->grt_id)->with('success', 'Goods Return Rejected');
                }
            }
        } catch (\Exception $e){
            DB::rollback();
            return redirect()->route('goods_return.show',$datas->grt_id)->with('error', $e->getMessage());
        }
    }

    public function createGoodsReturnGR($id,Request $request){

        $route = $request->route()->getPrefix();    
        $modelGR = GoodsReceipt::find($id);
        if($modelGR->purchase_order_id != null){
            $vendor = $modelGR->purchaseOrder->vendor;
        }elseif($modelGR->work_order_id != null){
            $vendor = $modelGR->workOrder->vendor;
        }
        $modelGRD = GoodsReceiptDetail::whereRaw('quantity - returned != 0')->where('goods_receipt_id',$modelGR->id)->with('material','material.uom')->get();
        foreach($modelGRD as $GRD){
            $GRD['returned_temp'] = 0;
            $GRD['available'] = $GRD->quantity - $GRD->returned;
            $GRD['is_decimal'] = $GRD->material->uom->is_decimal;
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

    public function edit($id,Request $request){

        $route = $request->route()->getPrefix();
        $modelGR = GoodsReturn::where('id',$id)->with('purchaseOrder','purchaseOrder.vendor','goodsReceipt.purchaseOrder.vendor','goodsReceipt.workOrder.vendor')->first();
        $GRD = GoodsReturnDetail::where('goods_return_id',$id)->with('material','material.uom')->get();
        $modelGRD = Collection::make();

        if($modelGR->purchase_order_id != null){
            $pod = PurchaseOrderDetail::where('purchase_order_id',$modelGR->purchase_order_id)->get();
            foreach($GRD as $data){
                foreach($pod as $dataPOD){
                    if($data->material_id == $dataPOD->material_id){
                        $modelGRD->push([
                            "id" => $data->id,
                            "material_id" => $data->material_id, 
                            "material_name" => $data->material->description,
                            "material_code" => $data->material->code,
                            "quantity" => $data->quantity,
                            "unit" => $data->material->uom->unit,
                            "is_decimal" => $data->material->uom->is_decimal,
                            "available" => $dataPOD->quantity - $dataPOD->received - $dataPOD->returned,
                        ]);
                    }
                }
            }

        }elseif($modelGR->goods_receipt_id != null){
            $grd = GoodsReceiptDetail::where('goods_receipt_id',$modelGR->goods_receipt_id)->get();
            foreach($GRD as $data){
                foreach($grd as $dataGRD){
                    if($data->material_id == $dataGRD->material_id){
                        $modelGRD->push([
                            "id" => $data->id,
                            "material_id" => $data->material_id, 
                            "material_name" => $data->material->description,
                            "material_code" => $data->material->code,
                            "quantity" => $data->quantity,
                            "unit" => $data->material->uom->unit,
                            "is_decimal" => $data->material->uom->is_decimal,
                            "available" => $dataGRD->quantity - $dataGRD->received - $dataGRD->returned,
                        ]);
                    }
                }
            }


        }
        return view('goods_return.edit', compact('modelGRD','modelGR','route'));
    }

    public function update($id,Request $request)
    {
        $route = $request->route()->getPrefix();    
        $datas = json_decode($request->datas);
        
        DB::beginTransaction();
        try {
            
            $GR = GoodsReturn::where('id',$datas->goods_return_id)->first();
            if($GR->status == 3){
                $GR->status = 4;
                $GR->update();
            }
            
            foreach($datas->GRD as $data){
                $GRD = GoodsReturnDetail::find($data->id);
                $GRD->quantity = $data->quantity;
                $GRD->update();
            }


            DB::commit();
            if($route == "/goods_return"){
                return redirect()->route('goods_return.show',$datas->goods_return_id)->with('success', 'Goods Return Updated');
            }elseif($route == "/goods_return_repair"){
                return redirect()->route('goods_return_repair.show',$datas->goods_return_id)->with('success', 'Goods Return Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/goods_return"){
                return redirect()->route('goods_return.edit',$datas->goods_return_id)->with('error', $e->getMessage());
            }elseif($route == "/goods_return_repair"){
                return redirect()->route('goods_return_repair.edit',$datas->goods_return_id)->with('error', $e->getMessage());
            }
        }
    }

    public function storeGoodsReturnGR(Request $request)
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
            $GR->goods_receipt_id = $datas->goods_receipt_id;
            $GR->description = $datas->description;
            $GR->branch_id = Auth::user()->branch->id;
            $GR->user_id = Auth::user()->id;
            $GR->save();

            foreach($datas->GRD as $data){
                if($data->returned_temp > 0){
                    $GRD = new GoodsReturnDetail;
                    $GRD->goods_return_id = $GR->id;
                    $GRD->quantity = $data->returned_temp;
                    $GRD->material_id = $data->material_id;
                    $GRD->storage_location_id = $data->storage_location_id;
                    $GRD->save();
                }
            }

            // $GI = new GoodsIssue;
            // $GI->number = $gi_number;
            // $GI->goods_receipt_id = $datas->goods_receipt_id;
            // $GI->description = $datas->description;
            // if($menu ==  "building"){
            //     $GI->business_unit_id = 1;
            // }elseif($menu == "repair"){
            //     $GI->business_unit_id = 2;
            // }
            // $GI->type = 4;
            // $GI->branch_id = Auth::user()->branch->id;
            // $GI->user_id = Auth::user()->id;
            // $GI->save();
            // foreach($datas->GRD as $GRD){
            //     if($GRD->returned_temp > 0){
            //         $GRD_returned = GoodsReceiptDetail::find($GRD->id);
            //         $GRD_returned->returned += $GRD->returned_temp;
            //         $GRD_returned->update();

            //         $GID = new GoodsIssueDetail;
            //         $GID->goods_issue_id = $GI->id;
            //         $GID->quantity = $GRD->returned_temp;
            //         $GID->material_id = $GRD->material_id;
            //         $GID->storage_location_id = $GRD->storage_location_id;
            //         $GID->save();

            //         $this->updateStock($GRD->material_id, $GRD->returned_temp);
            //         $this->updateSlocDetail($GRD->material_id, $GRD->storage_location_id,$GRD->returned_temp);
            //         $this->checkStatusGR($datas->goods_receipt_id);
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
            $modelPR = PurchaseRequisition::where('business_unit_id',1)->where('type', 1)->pluck('id')->toArray();
            $modelPOs = PurchaseOrder::whereIn('purchase_requisition_id',$modelPR)->where('status',2)->get();
            
        }elseif($menu == "repair"){
            $modelPR = PurchaseRequisition::where('business_unit_id',2)->where('type', 1)->pluck('id')->toArray();
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
        $modelGRs = GoodsReceipt::whereIn('purchase_order_id',$modelPOs)->orWhere('type',3)->where('business_unit_id', $business_unit)->where('status',1)->get();

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

    public function printPdf($id, Request $request)
    {
        $modelGRT = GoodsReturn::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $branch = Branch::find(Auth::user()->branch_id);
        $route = $request->route()->getPrefix();
        $pdf->loadView('goods_return.pdf',['modelGRT' => $modelGRT, 'branch' => $branch, 'route' => $route]);
        $now = date("Y_m_d_H_i_s");
        
        return $pdf->download('Goods_Return_'.$now.'.pdf');
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
