<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\GoodsIssue;
use App\Models\Project;
use App\Models\GoodsIssueDetail;
use App\Models\MaterialRequisition;
use App\Models\MaterialRequisitionDetail;
use App\Models\StorageLocation;
use App\Models\Stock;
use App\Models\StorageLocationDetail;
use App\Models\Branch;
use DB;
use Auth;

class GoodsIssueController extends Controller
{

    public function index(Request $request){
        $menu = $request->route()->getPrefix() == "/goods_issue" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->pluck('id')->toArray();
        }else{
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->pluck('id')->toArray();
        }

        $modelMRs = MaterialRequisition::whereIn('project_id',$modelProject)->pluck('id')->toArray();
        $modelGIs = GoodsIssue::whereIn('material_requisition_id',$modelMRs)->get();

        return view ('goods_issue.index', compact('modelGIs','menu'));
    }
    
    public function createGiWithRef($id,Request $request)
    {
        $menu = $request->route()->getPrefix() == "/goods_issue" ? "building" : "repair";    
        $modelMR = MaterialRequisition::findOrFail($id);
        $modelProject = $modelMR->project->with('ship', 'customer')->first();
        $modelSloc = StorageLocation::all();
        $modelMRDs = MaterialRequisitionDetail::where('material_requisition_id',$modelMR->id)->whereColumn('issued','!=','quantity')->with('material')->get();
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

    public function approval($gi_id,$status){
        $modelGI = GoodsIssue::findOrFail($gi_id);
        
        if($status == "approve"){
            $modelGI->status = 2;
            foreach($modelGI->goodsIssueDetails as $data){
                $this->updateSlocDetailApproved($data);
                $this->updateStockApproved($data);
            }
            $modelGI->update();
        }elseif($status == "need-revision"){
            $modelGI->status = 3;
            $modelGI->update();
        }elseif($status == "reject"){
            $modelGI->status = 4;
            $modelGI->update();
        }
        return redirect()->route('goods_issue.show',$gi_id);
    }

    public function store(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        $datas = json_decode($request->datas);
        $gi_number = $this->generateGINumber();

        DB::beginTransaction();
        try {
            $GI = new GoodsIssue;
            $GI->number = $gi_number;
            $GI->material_requisition_id = $datas->mr_id;
            $GI->description = $datas->description;
            $GI->branch_id = Auth::user()->branch->id;
            $GI->user_id = Auth::user()->id;
            $GI->save();
            foreach($datas->MRD as $MRD){
                foreach($MRD->modelGI as $data){
                    if($data->issued > 0){
                        $GID = new GoodsIssueDetail;
                        $GID->goods_issue_id = $GI->id;
                        $GID->quantity = $data->issued;
                        $GID->material_id = $data->material_id;
                        $GID->storage_location_id = $data->storage_location_id;
                        $GID->save();
    
                        $this->updateStock($data->material_id, $data->issued);
                        $this->updateSlocDetail($data->material_id, $data->storage_location_id,$data->issued);
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
    
    public function show($id)
    {
        $modelGI = GoodsIssue::findOrFail($id);
        $modelGID = $modelGI->GoodsIssueDetails;
        $approve = FALSE;

        return view('goods_issue.show', compact('modelGI','modelGID','approve'));
    }

    public function showApprove($id)
    {
        $modelGI = GoodsIssue::where('id', $id)->first();
        $modelGID = $modelGI->GoodsIssueDetails;
        $approve = TRUE;

        return view('goods_issue.show', compact('modelGI','modelGID','approve'));
    }
    
    // function
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

    public function updateStockApproved($data){
        $modelStock = Stock::where('material_id',$data->material_id)->first();
        $modelStock->quantity -= $data->quantity;
        $modelStock->save();
    }

    public function updateSlocDetailApproved($data){
        $modelSlocDetail = StorageLocationDetail::where('material_id',$data->material_id)->where('storage_location_id',$data->storage_location_id)->first();
        $modelSlocDetail->quantity -= $data->quantity;
        $modelSlocDetail->save();
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
        $modelGI = StorageLocationDetail::where('material_id',$id)->with('storageLocation')->get();
        foreach($modelGI as $GI){
            $GI['issued'] = "";
        }
        
        return response($modelGI->jsonSerialize(), Response::HTTP_OK);
    }
}
