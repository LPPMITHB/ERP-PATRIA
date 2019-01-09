<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\WorkRequest;
use App\Models\WorkRequestDetail;
use App\Models\Branch;
use App\Models\Material;
use App\Models\Stock;
use App\Models\WBS;
use App\Models\Project;
use Auth;
use DB;

class WorkRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelWRs = WorkRequest::all();

        return view('work_request.index', compact('modelWRs'));
    }

    public function indexApprove()
    {
        $modelPRs = PurchaseRequisition::whereIn('status',[1,4])->get();

        return view('purchase_requisition.indexApprove', compact('modelPRs'));
    }

    public function indexConsolidation()
    {
        $modelPRs = PurchaseRequisition::whereIn('status',[1,4])->with('project')->get();

        return view('purchase_requisition.indexConsolidation', compact('modelPRs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modelMaterial = Stock::with('material')->get()->jsonSerialize();
        $modelProject = Project::where('status',1)->get();

        return view('work_request.create', compact('modelMaterial','modelProject'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas = json_decode($request->datas);

        $wr_number = $this->generateWRNumber();
        $current_date = today();
        $valid_to = $current_date->addDays(7);
        $valid_to = $valid_to->toDateString();

        DB::beginTransaction();
        try {

            $WR = new WorkRequest;
            $WR->number = $wr_number;
            $WR->valid_date = $valid_to;
            $WR->description = $datas->description;
            if($datas->project_id != null){
                $WR->project_id = $datas->project_id;
            }
            $WR->status = 1;
            $WR->user_id = Auth::user()->id;
            $WR->branch_id = Auth::user()->branch->id;
            $WR->save();


            foreach($datas->materials as $data){
                $WRD = new WorkRequestDetail;
                $WRD->work_request_id = $WR->id;
                $WRD->quantity = $data->quantity;
                $WRD->description = $data->description;
                $WRD->material_id = $data->material_id;
                if($data->wbs_id != null){
                    $WRD->wbs_id = $data->wbs_id;
                }
                $WRD->save();
            }
            
            DB::commit();
            return redirect()->route('work_request.show',$WR->id)->with('success', 'Work Request Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('work_request.create')->with('error', $e->getMessage());
        }
    }

    public function storePRD(Request $request)
    {
        $datas = $request->json()->all();

        $modelPR = PurchaseRequisition::findOrFail($datas['pr_id']);
        DB::beginTransaction();
        try {
            $PRD = new PurchaseRequisitionDetail;
            $PRD->purchase_requisition_id = $datas['pr_id'];
            $PRD->quantity = $datas['quantity'];
            $PRD->material_id = $datas['material_id'];
            $PRD->wbs_id = $datas['wbs_id'];
            if(!$PRD->save()){
                return back()->with('error','Failed to save, please try again !');
            }
            DB::commit();
            return response(json_encode($PRD),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('purchase_requisition.edit',$datas['pr_id'])->with('error', $e->getMessage());
        }
    }

    public function updatePRD(Request $request)
    {
        $datas = $request->json()->all();
        $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id',$datas['pr_id'])->where('material_id',$datas['material_id'])->where('wbs_id',$datas['wbs_id'])->first();
        DB::beginTransaction();
        try {
            $modelPRD->quantity += $datas['quantity'];
            $modelPRD->save();
            
            DB::commit();
            return response(json_encode($modelPRD),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('purchase_requisition.edit',$datas['pr_id'])->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelWR = WorkRequest::findOrFail($id);

        return view('work_request.show', compact('modelWR'));
    }

    public function showApprove($id)
    {
        $modelPR = PurchaseRequisition::findOrFail($id);

        return view('purchase_requisition.showApprove', compact('modelPR'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modelWR = WorkRequest::findOrFail($id);
        $project = Project::where('id',$modelWR->project_id)->with('customer','ship')->first();
        $modelWRD = WorkRequestDetail::where('work_request_id',$modelWR->id)->with('material','wbs')->get()->jsonSerialize();
        $materials = Stock::with('material')->get()->jsonSerialize();
        $wbss = [];
        if($project){
            $wbss = WBS::where('project_id',$project->id)->get()->jsonSerialize();
        }

        return view('work_request.edit', compact('modelWR','project','modelWRD','materials','wbss'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $datas = json_decode($request->datas);
        print_r($datas);exit();
        DB::beginTransaction();
        try {
            $wrd_id = [];
            $WR = WorkRequest::find($id);
            $WR->description = $datas->description;
            if($WR->status == 3){
                $WR->status = 4;
            }
            $WR->update();
            foreach($datas->materials as $data){
                if($data->wrd_id != null){
                    $status = 0;
                    foreach($WR->workRequestDetails as $WorkRD){
                        if($WorkRD->material_id == $data->material_id && $WorkRD->wbs_id == $data->wbs_id && $WorkRD->available == $data->available && $WorkRD->id != $data->id){
                            $quantity = $WorkRD->quantity + $data->quantity;

                            $WRD = new WorkRequestDetail;
                            $WRD->work_request_id = $WR->id;
                            $WRD->quantity = $quantity;
                            $WRD->material_id = $data->material_id;
                            $WRD->available = $data->available;
                            if($WR->project_id != ""){
                                $WRD->wbs_id = $data->wbs_id;
                            }
                            $WRD->save();
                            array_push($wrd_id,$WorkRD->id,$data->id);
 
                            $status = 1;
                        }
                    }

                    if($status == 0){
                        $PRD = WorkRequestDetail::find($data->id);

                        $PRD->quantity = $data->quantity;
                        $PRD->alocation = $data->alocation;
                        if($PR->project_id != ""){
                            $PRD->wbs_id = $data->wbs_id;
                        }
                        $PRD->update();
                    }
                }else{
                    $status = 0;
                    foreach($PR->purchaseRequisitionDetails as $PurchaseRD){
                        if($PurchaseRD->material_id == $data->material_id && $PurchaseRD->wbs_id == $data->wbs_id && $PurchaseRD->alocation == $data->alocation){
                            $PurchaseRD->quantity +=$data->quantity;
                            $PurchaseRD->update();

                            $status = 1;
                        }
                    }
                    if($status == 0){
                        $PRD = new PurchaseRequisitionDetail;
                        $PRD->purchase_requisition_id = $PR->id;
                        $PRD->quantity = $data->quantity;
                        $PRD->material_id = $data->material_id;
                        $PRD->alocation = $data->alocation;
                        if($PR->project_id != ""){
                            $PRD->wbs_id = $data->wbs_id;
                        }
                        $PRD->save();
                    }
                }
            }

            $this->destroy(json_encode($wrd_id));
            DB::commit();
            return redirect()->route('purchase_requisition.show',$PR->id)->with('success', 'Purchase Requisition Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('purchase_requisition.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPRD(Request $request)
    {
        $data = $request->json()->all();
        $modelPRD = PurchaseRequisitionDetail::findOrFail($data[0]);
        DB::beginTransaction();
        try {
            $modelPRD->delete();
            DB::commit();
            return response('ok',Response::HTTP_OK);
        } catch(\Illuminate\Database\QueryException $e){
            DB::rollback();
            return redirect()->route('bom.edit',$bom->id)->with('error', 'Can\'t Delete The Material Because It Is Still Being Used');
        }  
    }

    public function destroy($id){
        $prd_id = json_decode($id);

        DB::beginTransaction();
        try {
            foreach($prd_id as $id){
                $modelPRD = PurchaseRequisitionDetail::findOrFail($id);
                $modelPRD->delete();
            }
            DB::commit();
            return true;
        } catch(\Illuminate\Database\QueryException $e){
            DB::rollback();
            return redirect()->route('purchase_requisition.create')->with('error', 'Can\'t Delete The Material Because It Is Still Being Used');
        }  
    }
    public function approval($pr_id,$status)
    {
        DB::beginTransaction();
        try{
            $modelPR = PurchaseRequisition::findOrFail($pr_id);
            if($status == "approve"){
                $modelPR->status = 2;
                $modelPR->update();
                DB::commit();
                return redirect()->route('purchase_requisition.showApprove',$pr_id)->with('success', 'Purchase Requisition Approved');
            }elseif($status == "need-revision"){
                $modelPR->status = 3;
                $modelPR->update();
                DB::commit();
                return redirect()->route('purchase_requisition.showApprove',$pr_id)->with('success', 'Purchase Requisition Need Revision');
            }elseif($status == "reject"){
                $modelPR->status = 5;
                $modelPR->update();
                DB::commit();
                return redirect()->route('purchase_requisition.showApprove',$pr_id)->with('success', 'Purchase Requisition Rejected');
            }
        } catch (\Exception $e){
            DB::rollback();
            return redirect()->route('purchase_requisition.show',$pr_id);
        }

        
    }

    // function
    public function generateWRNumber(){
        $modelWR = WorkRequest::orderBy('created_at','desc')->first();
        $yearNow = date('y');
        
		$number = 1;
        if(isset($modelWR)){
            $yearDoc = substr($modelWR->number, 3,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelWR->number, -5));
            }
        }

        $year = date($yearNow.'00000');
        $year = intval($year);

		$wr_number = $year+$number;
        $wr_number = 'WR-'.$wr_number;

		return $wr_number;
    }

    public function getQuantityReservedApi($id){
        $materials = Stock::where('material_id',$id)->get();
        
        return response($materials, Response::HTTP_OK);
    }

    public function getProjectApi($id){
        $project = Project::where('id',$id)->with('ship','customer','wbss')->first()->jsonSerialize();

        return response($project, Response::HTTP_OK);
    }

    public function getMaterialWrAPI($id){
        
        return response(Material::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getWbsWrAPI($id){

        return response(WBS::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getResourceAPI($id){
        
        return response(Resource::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getMaterialsAPI($ids){
        $ids = json_decode($ids);

        return response(Material::whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }


    public function getPRDAPI($id){

        return response(PurchaseRequisitionDetail::where('purchase_requisition_id',$id)->with('material','wbs')->get()->jsonSerialize(), Response::HTTP_OK);
    }
}
