<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use App\Models\Branch;
use App\Models\Material;
use App\Models\Work;
use App\Models\Project;
use Auth;
use DB;

class PurchaseRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelPRs = PurchaseRequisition::all();

        return view('purchase_requisition.index', compact('modelPRs'));
    }

    public function indexApprove()
    {
        $modelPRs = PurchaseRequisition::where('status',1)->get();

        return view('purchase_requisition.indexApprove', compact('modelPRs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modelMaterial = Material::all()->jsonSerialize();
        $modelProject = Project::where('status',1)->get();

        return view('purchase_requisition.create', compact('modelMaterial','modelProject'));
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

        $pr_number = $this->generatePRNumber();
        $current_date = today();
        $valid_to = $current_date->addDays(7);
        $valid_to = $valid_to->toDateString();

        DB::beginTransaction();
        try {
            $PR = new PurchaseRequisition;
            $PR->number = $pr_number;
            $PR->valid_date = $valid_to;
            $PR->project_id = $datas->project_id;
            $PR->status = 1;
            $PR->user_id = Auth::user()->id;
            $PR->branch_id = Auth::user()->branch->id;
            $PR->save();

            foreach($datas->materials as $data){
                $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id',$PR->id)->get();
                if(count($modelPRD)>0){
                    $status = 0;
                    foreach($modelPRD as $PurchaseRD){
                        if($PurchaseRD->material_id == $data->material_id && $PurchaseRD->wbs_id == $data->wbs_id){
                            $PurchaseRD->quantity +=$data->quantityInt;
                            $PurchaseRD->save();

                            $status = 1;
                        }
                    }
                    if($status == 0){
                        $PRD = new PurchaseRequisitionDetail;
                        $PRD->purchase_requisition_id = $PR->id;
                        $PRD->quantity = $data->quantityInt;
                        $PRD->material_id = $data->material_id;
                        $PRD->wbs_id = $data->wbs_id;
                        $PRD->save();
                    }
                }else{
                    $PRD = new PurchaseRequisitionDetail;
                    $PRD->purchase_requisition_id = $PR->id;
                    $PRD->quantity = $data->quantityInt;
                    $PRD->material_id = $data->material_id;
                    $PRD->wbs_id = $data->wbs_id;
                    $PRD->save();
                }
            }
            DB::commit();
            return redirect()->route('purchase_requisition.show',$PR->id)->with('success', 'Purchase Requisition Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('purchase_requisition.create')->with('error', $e->getMessage());
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
        $modelPR = PurchaseRequisition::findOrFail($id);

        return view('purchase_requisition.show', compact('modelPR'));
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
        $modelPR = PurchaseRequisition::findOrFail($id);
        $project = Project::findOrFail($modelPR->project_id)->with('customer','ship')->first();
        $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id',$modelPR->id)->with('material','work')->get()->jsonSerialize();
        $materials = Material::where('status',1)->get()->jsonSerialize();
        $works = Work::where('project_id',$project->id)->get()->jsonSerialize();

        return view('purchase_requisition.edit', compact('modelPR','project','modelPRD','materials','works'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $datas = $request->json()->all();
        $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id',$datas['pr_id'])->where('material_id',$datas['material_id'])->where('wbs_id',$datas['wbs_id'])->first();
        DB::beginTransaction();
        try {
            $modelPRD->quantity = $datas['quantity'];
            $modelPRD->save();
            
            DB::commit();
            return response(json_encode($modelPRD),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('purchase_requisition.edit',$datas['pr_id'])->with('error', $e->getMessage());
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

    // function
    public function generatePRNumber(){
        $modelPR = PurchaseRequisition::orderBy('created_at','desc')->where('branch_id',Auth::user()->branch_id)->first();
        $modelBranch = Branch::where('id', Auth::user()->branch_id)->first();

        $branch_code = substr($modelBranch->code,4,2);
		$number = 1;
		if(isset($modelPR)){
            $number += intval(substr($modelPR->number, -6));
		}
        $year = date('y'.$branch_code.'000000');
        $year = intval($year);

		$pr_number = $year+$number;
        $pr_number = 'PR-'.$pr_number;
		return $pr_number;
        
    }

    public function getProjectApi($id){
        $project = Project::where('id',$id)->with('ship','customer','works')->first()->jsonSerialize();

        return response($project, Response::HTTP_OK);
    }

    public function getMaterialAPI($id){
        
        return response(Material::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getMaterialsAPI($ids){
        $ids = json_decode($ids);

        return response(Material::whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getWorkAPI($id){

        return response(Work::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getPRDAPI($id){

        return response(PurchaseRequisitionDetail::where('purchase_requisition_id',$id)->with('material','work')->get()->jsonSerialize(), Response::HTTP_OK);
    }
}
