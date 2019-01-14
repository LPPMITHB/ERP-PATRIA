<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use App\Models\Branch;
use App\Models\Material;
use App\Models\Resource;
use App\Models\WBS;
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
    public function index(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelPRs = PurchaseRequisition::all();

        return view('purchase_requisition.index', compact('modelPRs','route'));
    }

    public function indexApprove(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelPRs = PurchaseRequisition::whereIn('status',[1,4])->get();

        return view('purchase_requisition.indexApprove', compact('modelPRs','route'));
    }

    public function indexConsolidation(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelPRs = PurchaseRequisition::whereIn('status',[1])->with('project')->get();

        return view('purchase_requisition.indexConsolidation', compact('modelPRs','route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelMaterial = Material::all()->jsonSerialize();
        $modelResource = Resource::all()->jsonSerialize();
        $modelProject = Project::where('status',1)->get();

        return view('purchase_requisition.create', compact('modelMaterial','modelProject','modelResource','route'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);

        $pr_number = $this->generatePRNumber();
        $current_date = today();
        $valid_to = $current_date->addDays(7);
        $valid_to = $valid_to->toDateString();

        DB::beginTransaction();
        try {
            if($datas->resource == ""){
                $PR = new PurchaseRequisition;
                $PR->number = $pr_number;
                $PR->valid_date = $valid_to;
                if($datas->project_id != null){
                    $PR->project_id = $datas->project_id;
                }
                $PR->status = 1;
                $PR->type = 1;
                $PR->user_id = Auth::user()->id;
                $PR->branch_id = Auth::user()->branch->id;
                $PR->save();

                foreach($datas->materials as $data){
                    $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id',$PR->id)->get();
                    if(count($modelPRD)>0){
                        $status = 0;
                        foreach($modelPRD as $PurchaseRD){
                            if($PurchaseRD->material_id == $data->material_id && $PurchaseRD->wbs_id == $data->wbs_id && $PurchaseRD->alocation == $data->alocation){
                                $PurchaseRD->quantity +=$data->quantityInt;
                                $PurchaseRD->update();

                                $status = 1;
                            }
                        }
                        if($status == 0){
                            $PRD = new PurchaseRequisitionDetail;
                            $PRD->purchase_requisition_id = $PR->id;
                            $PRD->quantity = $data->quantityInt;
                            $PRD->material_id = $data->material_id;
                            $PRD->alocation = $data->alocation;
                            if($data->wbs_id != null){
                                $PRD->wbs_id = $data->wbs_id;
                            }
                            $PRD->save();
                        }
                    }else{
                        $PRD = new PurchaseRequisitionDetail;
                        $PRD->purchase_requisition_id = $PR->id;
                        $PRD->quantity = $data->quantityInt;
                        $PRD->material_id = $data->material_id;
                        $PRD->alocation = $data->alocation;
                        if($data->wbs_id != null){
                            $PRD->wbs_id = $data->wbs_id;
                        }
                        $PRD->save();
                    }
                }
            }else{
                $PR = new PurchaseRequisition;
                $PR->number = $pr_number;
                $PR->valid_date = $valid_to;
                if($datas->project_id != null){
                    $PR->project_id = $datas->project_id;
                }
                $PR->status = 1;
                $PR->type = 2;
                $PR->user_id = Auth::user()->id;
                $PR->branch_id = Auth::user()->branch->id;
                $PR->save();

                foreach($datas->materials as $data){
                    $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id',$PR->id)->get();
                    if(count($modelPRD)>0){
                        $status = 0;
                        foreach($modelPRD as $PurchaseRD){
                            if($PurchaseRD->resource_id == $data->resource_id && $PurchaseRD->wbs_id == $data->wbs_id){
                                $PurchaseRD->quantity +=$data->quantityInt;
                                $PurchaseRD->update();

                                $status = 1;
                            }
                        }
                        if($status == 0){
                            $PRD = new PurchaseRequisitionDetail;
                            $PRD->purchase_requisition_id = $PR->id;
                            $PRD->quantity = $data->quantityInt;
                            $PRD->resource_id = $data->resource_id;
                            if($data->wbs_id != null){
                                $PRD->wbs_id = $data->wbs_id;
                            }
                            $PRD->save();
                        }
                    }else{
                        $PRD = new PurchaseRequisitionDetail;
                        $PRD->purchase_requisition_id = $PR->id;
                        $PRD->quantity = $data->quantityInt;
                        $PRD->resource_id = $data->resource_id;
                        if($data->wbs_id != null){
                            $PRD->wbs_id = $data->wbs_id;
                        }
                        $PRD->save();
                    }
                }
            }
            DB::commit();
            if($route == "/purchase_requisition"){
                return redirect()->route('purchase_requisition.show',$PR->id)->with('success', 'Purchase Requisition Created');
            }elseif($route == "/purchase_requisition_repair"){
                return redirect()->route('purchase_requisition_repair.show',$PR->id)->with('success', 'Purchase Requisition Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/purchase_requisition"){
                return redirect()->route('purchase_requisition.create')->with('error', $e->getMessage());
            }elseif($route == "/purchase_requisition_repair"){
                return redirect()->route('purchase_requisition_repair.create')->with('error', $e->getMessage());
            }
        }
    }

    public function storeConsolidation(Request $request)
    {
        $route = $request->route()->getPrefix();
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
            $PR->status = 1;
            $PR->type = $datas->type;
            $PR->description = 'PR Consolidation';
            $PR->user_id = Auth::user()->id;
            $PR->branch_id = Auth::user()->branch->id;
            $PR->save();

            foreach($datas->checkedPR as $pr_id){
                $modelPR = PurchaseRequisition::findOrFail($pr_id);
                $modelPR->status = 6;
                $modelPR->purchase_requisition_id = $PR->id;
                $modelPR->update();
                if($datas->type == 1){
                    foreach($modelPR->purchaseRequisitionDetails as $PRD){

                        $status = 0;
                        $modelPRDs = PurchaseRequisitionDetail::where('purchase_requisition_id',$PR->id)->get();
                        if(count($modelPRDs) > 0){
                            foreach($modelPRDs as $modelPRD){
                                if($modelPRD->material_id == $PRD->material_id && $modelPRD->alocation == $PRD->alocation){
                                    $modelPRD->quantity += $PRD->quantity;
                                    $modelPRD->update();

                                    $status = 1;
                                }
                            }
                        }
                        
                        if($status == 0){
                            $modelPRD = new PurchaseRequisitionDetail;
                            $modelPRD->purchase_requisition_id = $PR->id;
                            $modelPRD->material_id = $PRD->material_id;
                            $modelPRD->quantity = $PRD->quantity;
                            $modelPRD->reserved = $PRD->reserved;
                            $modelPRD->wbs_id = $PRD->wbs_id;
                            $modelPRD->alocation = $PRD->alocation;
                            $modelPRD->save();
                        }
                    }
                }else{
                    foreach($modelPR->purchaseRequisitionDetails as $PRD){
                        $status = 0;
                        $modelPRDs = PurchaseRequisitionDetail::where('purchase_requisition_id',$PR->id)->get();
                        if(count($modelPRDs) > 0){
                            foreach($modelPRDs as $modelPRD){
                                if($modelPRD->resource_id == $PRD->resource_id){
                                    $modelPRD->quantity += $PRD->quantity;
                                    $modelPRD->update();

                                    $status = 1;
                                }
                            }
                        }
                        
                        if($status == 0){
                            $modelPRD = new PurchaseRequisitionDetail;
                            $modelPRD->purchase_requisition_id = $PR->id;
                            $modelPRD->resource_id = $PRD->resource_id;
                            $modelPRD->quantity = $PRD->quantity;
                            $modelPRD->reserved = $PRD->reserved;
                            $modelPRD->save();
                        }
                    }
                }
            }
            DB::commit();
            if($route == "/purchase_requisition"){
                return redirect()->route('purchase_requisition.show',$PR->id)->with('success', 'Purchase Requisition Consolidation Created');
            }elseif($route == "/purchase_requisition_repair"){
                return redirect()->route('purchase_requisition_repair.show',$PR->id)->with('success', 'Purchase Requisition Consolidation Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/purchase_requisition"){
                return redirect()->route('purchase_requisition.indexConsolidation')->with('error', $e->getMessage());
            }elseif($route == "/purchase_requisition_repair"){
                return redirect()->route('purchase_requisition_repair.indexConsolidation')->with('error', $e->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPR = PurchaseRequisition::findOrFail($id);

        return view('purchase_requisition.show', compact('modelPR','route'));
    }

    public function showApprove(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPR = PurchaseRequisition::findOrFail($id);

        return view('purchase_requisition.showApprove', compact('modelPR','route'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $modelPR = PurchaseRequisition::findOrFail($id);
        $project = Project::where('id',$modelPR->project_id)->with('customer','ship')->first();
        $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id',$modelPR->id)->with('material','wbs','resource')->get()->jsonSerialize();
        $materials = Material::where('status',1)->get()->jsonSerialize();
        $resources = Resource::all()->jsonSerialize();
        $wbss = [];
        if($project){
            $wbss = WBS::where('project_id',$project->id)->get()->jsonSerialize();
        }

        return view('purchase_requisition.edit', compact('modelPR','project','modelPRD','materials','wbss','resources','route'));
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
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            $prd_id = [];
            $PR = PurchaseRequisition::find($id);
            $PR->description = $datas->description;
            if($PR->status == 3){
                $PR->status = 4;
            }
            $PR->update();
            if($PR->type == 1){
                foreach($datas->materials as $data){
                    if($data->prd_id != null){
                        $status = 0;
                        foreach($PR->purchaseRequisitionDetails as $PurchaseRD){
                            if($PurchaseRD->material_id == $data->material_id && $PurchaseRD->alocation == $data->alocation && $PurchaseRD->wbs_id == $data->wbs_id && $PurchaseRD->id != $data->id){
                                $quantity = $PurchaseRD->quantity + $data->quantity;

                                $PRD = new PurchaseRequisitionDetail;
                                $PRD->purchase_requisition_id = $PR->id;
                                $PRD->quantity = $quantity;
                                $PRD->material_id = $data->material_id;
                                $PRD->alocation = $data->alocation;
                                if($data->wbs_id != null){
                                    $PRD->wbs_id = $data->wbs_id;
                                }
                                $PRD->save();
                                array_push($prd_id,$PurchaseRD->id,$data->id);
    
                                $status = 1;
                            }
                        }
                        // print_r($PR->purchaseRequisitionDetails);exit();
                        if($status == 0){
                            $PRD = PurchaseRequisitionDetail::find($data->id);

                            $PRD->quantity = $data->quantity;
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
                            if($data->wbs_id != null){
                                $PRD->wbs_id = $data->wbs_id;
                            }
                            $PRD->save();
                        }
                    }
                }
                $this->destroy(json_encode($prd_id));
            }else{
                foreach($datas->materials as $data){
                    if($data->prd_id != null){
                        $status = 0;
                        foreach($PR->purchaseRequisitionDetails as $PurchaseRD){
                            if($PurchaseRD->resource_id == $data->resource_id && $PurchaseRD->wbs_id == $data->wbs_id && $PurchaseRD->id != $data->id){
                                $quantity = $PurchaseRD->quantity + $data->quantity;

                                $PRD = new PurchaseRequisitionDetail;
                                $PRD->purchase_requisition_id = $PR->id;
                                $PRD->quantity = $quantity;
                                $PRD->resource_id = $data->resource_id;
                                if($data->wbs_id != null){
                                    $PRD->wbs_id = $data->wbs_id;
                                }
                                $PRD->save();
                                array_push($prd_id,$PurchaseRD->id,$data->id);
    
                                $status = 1;
                            }
                        }
                        if($status == 0){
                            $PRD = PurchaseRequisitionDetail::find($data->id);

                            $PRD->quantity = $data->quantity;
                            $PRD->update();
                        }
                    }else{
                        $status = 0;
                        foreach($PR->purchaseRequisitionDetails as $PurchaseRD){
                            if($PurchaseRD->resource_id == $data->resource_id && $PurchaseRD->wbs_id == $data->wbs_id){
                                $PurchaseRD->quantity +=$data->quantity;
                                $PurchaseRD->update();

                                $status = 1;
                            }
                        }
                        if($status == 0){
                            $PRD = new PurchaseRequisitionDetail;
                            $PRD->purchase_requisition_id = $PR->id;
                            $PRD->quantity = $data->quantity;
                            $PRD->resource_id = $data->resource_id;
                            if($data->wbs_id != null){
                                $PRD->wbs_id = $data->wbs_id;
                            }
                            $PRD->save();
                        }
                    }
                }
                $this->destroy(json_encode($prd_id));
            }
            DB::commit();
            if($route == "/purchase_requisition"){
                return redirect()->route('purchase_requisition.show',$PR->id)->with('success', 'Purchase Requisition Updated');
            }elseif($route == "/purchase_requisition_repair"){
                return redirect()->route('purchase_requisition_repair.show',$PR->id)->with('success', 'Purchase Requisition Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/purchase_requisition"){
                return redirect()->route('purchase_requisition.create')->with('error', $e->getMessage());
            }elseif($route == "/purchase_requisition_repair"){
                return redirect()->route('purchase_requisition_repair.create')->with('error', $e->getMessage());
            }
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
    public function approval(Request $request, $pr_id,$status)
    {
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try{
            $modelPR = PurchaseRequisition::findOrFail($pr_id);
            if($status == "approve"){
                $modelPR->status = 2;
                $modelPR->update();
                DB::commit();
                if($route == "/purchase_requisition"){
                    return redirect()->route('purchase_requisition.showApprove',$pr_id)->with('success', 'Purchase Requisition Approved');
                }elseif($route == "/purchase_requisition_repair"){
                    return redirect()->route('purchase_requisition_repair.showApprove',$pr_id)->with('success', 'Purchase Requisition Approved');
                }
            }elseif($status == "need-revision"){
                $modelPR->status = 3;
                $modelPR->update();
                DB::commit();
                if($route == "/purchase_requisition"){
                    return redirect()->route('purchase_requisition.showApprove',$pr_id)->with('success', 'Purchase Requisition Need Revision');
                }elseif($route == "/purchase_requisition_repair"){
                    return redirect()->route('purchase_requisition_repair.showApprove',$pr_id)->with('success', 'Purchase Requisition Need Revision');
                }
            }elseif($status == "reject"){
                $modelPR->status = 5;
                $modelPR->update();
                DB::commit();
                if($route == "/purchase_requisition"){
                    return redirect()->route('purchase_requisition.showApprove',$pr_id)->with('success', 'Purchase Requisition Rejected');
                }elseif($route == "/purchase_requisition_repair"){
                    return redirect()->route('purchase_requisition_repair.showApprove',$pr_id)->with('success', 'Purchase Requisition Rejected');
                }
            }
        } catch (\Exception $e){
            DB::rollback();
            return redirect()->route('purchase_requisition.show',$pr_id);
        }

        
    }

    // function
    public function generatePRNumber(){
        $modelPR = PurchaseRequisition::orderBy('created_at','desc')->first();
        $yearNow = date('y');
        
		$number = 1;
        if(isset($modelPR)){
            $yearDoc = substr($modelPR->number, 3,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelPR->number, -5));
            }
        }

        $year = date($yearNow.'00000');
        $year = intval($year);

		$pr_number = $year+$number;
        $pr_number = 'PR-'.$pr_number;

		return $pr_number;
    }

    public function getProjectApi($id){
        $project = Project::where('id',$id)->with('ship','customer','wbss')->first()->jsonSerialize();

        return response($project, Response::HTTP_OK);
    }

    public function getMaterialAPI($id){
        
        return response(Material::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getResourceAPI($id){
        
        return response(Resource::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getMaterialsAPI($ids){
        $ids = json_decode($ids);

        return response(Material::whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getWbsAPI($id){

        return response(WBS::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getPRDAPI($id){

        return response(PurchaseRequisitionDetail::where('purchase_requisition_id',$id)->with('material','wbs')->get()->jsonSerialize(), Response::HTTP_OK);
    }
}
