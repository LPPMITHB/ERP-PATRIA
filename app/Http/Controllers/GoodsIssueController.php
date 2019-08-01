<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\GoodsIssue;
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
use Illuminate\Support\Collection;
use DateTime;
use DB;
use Auth;

class GoodsIssueController extends Controller
{

    public function index(Request $request){
        $menu = $request->route()->getPrefix() == "/goods_issue" ? "building" : "repair";    
        if($menu == "repair"){
            $modelGIs = GoodsIssue::where('business_unit_id',2)->orderBy('created_at', 'desc')->get();
        }else{
            $modelGIs = GoodsIssue::where('business_unit_id',1)->orderBy('created_at', 'desc')->get();
        }
        return view ('goods_issue.index', compact('modelGIs','menu'));
    }

    public function createGiWithRef($id,Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_issue" ? "building" : "repair";    
        $modelMR = MaterialRequisition::findOrFail($id);
        if($modelMR->project != null){
            $modelProject = $modelMR->project->with('ship', 'customer')->first();
        }else{
            $modelProject = null;
        }
        $modelSloc = StorageLocation::all();
        $modelMRDs = MaterialRequisitionDetail::where('material_requisition_id',$modelMR->id)->whereColumn('issued','!=','quantity')->with('material.uom')->get();
        foreach($modelMRDs as $MRD){
            $MRD['already_issued'] = $MRD->issued;
            $MRD['sloc_id'] = "";
            $MRD['modelGI'] = "";
        }

        return view('goods_issue.createGiWithRef', compact('modelMR','modelMRDs','modelSloc','modelProject','menu'));
    }

    public function selectMR(Request $request)
    {
        $modelMRs = MaterialRequisition::where('status',2)->get();
        $menu = $request->route()->getPrefix() == "/goods_issue" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->pluck('id')->toArray();
        }else{
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->pluck('id')->toArray();
        }

        return view('goods_issue.selectMR', compact('modelMRs','menu'));
    }

    public function store(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_issue" ? "building" : "repair";    
        $datas = json_decode($request->datas);
        $gi_number = $this->generateGINumber();
        DB::beginTransaction();
        try {
            $GI = new GoodsIssue;
            $GI->number = $gi_number;
            if($menu == 'building'){
                $business_unit = 1;
            }elseif($menu == 'repair'){
                $business_unit = 2;
            }
            $GI->business_unit_id = $business_unit;
            $GI->material_requisition_id = $datas->mr_id;
            $GI->description = $datas->description;
            if($datas->issue_date != ""){
                $issue_date = DateTime::createFromFormat('d-m-Y', $datas->issue_date);
                $GI->issue_date = $issue_date->format('Y-m-d');
            }
            $GI->type = 1;
            $GI->branch_id = Auth::user()->branch->id;
            $GI->user_id = Auth::user()->id;
            $GI->save();
            foreach($datas->MRD as $MRD){
                foreach($MRD->modelGI as $data){
                    if($data->issued > 0){
                        $temp_sloc_detail = StorageLocationDetail::join('trx_goods_receipt_detail', 'mst_storage_location_detail.goods_receipt_detail_id', '=', 'trx_goods_receipt_detail.id')
                        ->orderBy('trx_goods_receipt_detail.received_date', 'asc')->where('mst_storage_location_detail.material_id', $data->material_id)->select('mst_storage_location_detail.*','trx_goods_receipt_detail.received_date')->get();
                        
                        $temp_issued = $data->issued;
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
                                    $this->updateSlocDetail($data->material_id, $sloc_detail, $sloc_detail->quantity);
                                }else{
                                    $GID = new GoodsIssueDetail;
                                    $GID->goods_issue_id = $GI->id;
                                    $GID->quantity = $temp_issued;
                                    $GID->material_id = $data->material_id;
                                    $GID->storage_location_id = $sloc_detail->storage_location_id;
                                    $GID->value_sloc_detail = $sloc_detail->value;
                                    $GID->goods_receipt_detail_id_sloc_detail = $sloc_detail->goods_receipt_detail_id;
                                    $GID->save();

                                    $this->updateSlocDetail($data->material_id, $sloc_detail,$temp_issued);
                                }
                            }
                        }
                        $this->updateStock($data->material_id, $data->issued);
                        $this->updateMR($MRD->id,$data->issued);
                    }
                }
            }
            $this->checkStatusMR($datas->mr_id);
            DB::commit();
            if($menu == "building"){
                return redirect()->route('goods_issue.show',$GI->id)->with('success', 'Goods Issue Created');
            }else{
                return redirect()->route('goods_issue_repair.show',$GI->id)->with('success', 'Goods Issue Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('goods_issue.selectMR',$datas->mr_id)->with('error', $e->getMessage());
            }else{
                return redirect()->route('goods_issue_repair.selectMR',$datas->mr_id)->with('error', $e->getMessage());
            }
        }
    }
    
    public function show(Request $request,$id)
    {
        $route = $request->route()->getPrefix();    
        $modelGI = GoodsIssue::findOrFail($id);
        $temp_gid = $modelGI->GoodsIssueDetails->groupBy('material_id');

        $modelGID = Collection::make();
        foreach ($temp_gid as $material_id => $data) {
            $temp_data = null;
            foreach ($data as $gid) {
                if($temp_data == null){
                    $temp_data = $gid;
                }else{
                    $temp_data->quantity += $gid->quantity;
                }
            }
            $modelGID[$material_id] = $temp_data;
        }
        $approve = FALSE;

        return view('goods_issue.show', compact('modelGI','modelGID','approve','route'));
    }

    public function showApprove(Request $request,$id)
    {
        $route = $request->route()->getPrefix();    
        $modelGI = GoodsIssue::where('id', $id)->first();
        $modelGID = $modelGI->GoodsIssueDetails;
        $approve = TRUE;

        return view('goods_issue.show', compact('modelGI','modelGID','approve','route'));
    }
    
    // function
    public function printPdf($id, Request $request)
    { 
        $branch = Auth::user()->branch; 
        $modelGI = GoodsIssue::find($id);
        $route = $request->route()->getPrefix();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('goods_issue.pdf',['modelGI' => $modelGI,'branch'=>$branch,'route'=>$route]);
        $now = date("Y_m_d_H_i_s");
        return $pdf->stream('Goods_Issue_'.$now.'.pdf');
    }

    public function updateMR($mr_id,$issued){
        $modelMRD = MaterialRequisitionDetail::findOrFail($mr_id);
        if($modelMRD){
            $modelMRD->issued = $modelMRD->issued + $issued;
            $modelMRD->update();
        }else{

        }
    }

    public function updateStock($material_id,$issued){
        $modelStock = Stock::where('material_id',$material_id)->first();
        
        if($modelStock){
            $modelStock->quantity = $modelStock->quantity - $issued;
            $modelStock->reserved = $modelStock->reserved - $issued;
            $modelStock->reserved_gi = $modelStock->reserved_gi - $issued;
            $modelStock->save();
        }else{

        }
    }

    public function updateSlocDetail($material_id,$sloc_detail,$issued){
        $modelSlocDetail = StorageLocationDetail::find($sloc_detail->id);
        if($modelSlocDetail){
            $modelSlocDetail->quantity = $modelSlocDetail->quantity - $issued;
            $modelSlocDetail->update();

            if($modelSlocDetail->quantity == 0){
                $modelSlocDetail->delete();
            }
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
    
    //API
    public function getSlocDetailAPI($id){
        $modelGI = StorageLocationDetail::where('material_id',$id)->with('storageLocation','material.uom')->get()->groupBy('storage_location_id');

        $modelGI_new = Collection::make();
        foreach($modelGI as $sloc_id => $GI){
            $temp = null;
            foreach ($GI as $single_data) {
                if($temp == null){
                    $temp = $single_data;
                    $temp->value = null;
                    
                }else{
                    $temp->quantity += $single_data->quantity;
                    $temp->value = null;
                }
            }
            $temp->issued = "";
            $modelGI_new->push($temp);
            $temp = null;
        }
        
        return response($modelGI_new->jsonSerialize(), Response::HTTP_OK);
    }
}
