<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\GoodsIssue;
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

    public function index(){
        $modelGIs = GoodsIssue::all();

        return view ('goods_issue.index', compact('modelGIs'));
    }

    public function selectMR($id)
    {
        $modelMR = MaterialRequisition::findOrFail($id);
        $modelSloc = StorageLocation::all();
        $modelMRDs = MaterialRequisitionDetail::where('material_requisition_id',$modelMR->id)->whereColumn('issued','!=','quantity')->with('material')->get();
        foreach($modelMRDs as $MRD){
            $MRD['sloc_id'] = "";
            $MRD['modelGI'] = "";
        }
        return view('goods_issue.selectMR', compact('modelMR','modelMRDs','modelSloc'));
    }

    public function createGiWithRef()
    {
        $modelMRs = MaterialRequisition::where('status',1)->get();
        
        return view('goods_issue.createGiWithRef', compact('modelMRs'));
    }

    public function store(Request $request)
    {
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
                    if($data->issued >0){
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
            return redirect()->route('goods_issue.show',$GI->id)->with('success', 'Goods Issue Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('goods_issue.selectMR',$datas->mr_id)->with('error', $e->getMessage());
        }
    }
    
    public function show($id)
    {
        $modelGI = GoodsIssue::findOrFail($id);
        $modelGID = $modelGI->GoodsIssueDetails ;
        
        return view('goods_issue.show', compact('modelGI','modelGID'));
    }
    
    // function
    public function updateMR($mr_id,$issued){
        $modelMRD = MaterialRequisitionDetail::findOrFail($mr_id);
        
        if($modelMRD){
            $modelMRD->quantity = $modelMRD->quantity - $issued;
            $modelMRD->issued = $modelMRD->issued + $issued;
            $modelMRD->save();
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
        $modelGI = GoodsIssue::orderBy('created_at','desc')->where('branch_id',Auth::user()->branch_id)->first();
        $modelBranch = Branch::where('id', Auth::user()->branch_id)->first();

        $branch_code = substr($modelBranch->code,4,2);
        $number = 1;
        if(isset($modelGI)){
            $number += intval(substr($modelGI->number, -6));
        }
        $year = date('y'.$branch_code.'000000');
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
