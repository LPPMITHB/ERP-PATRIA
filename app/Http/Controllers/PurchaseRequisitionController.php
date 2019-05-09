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
use App\Models\Activity;
use App\Models\Project;
use App\Models\ServiceDetail;
use DateTime;
use Auth;
use DB;
use Illuminate\Support\Collection;

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
        if($route == "/purchase_requisition"){
            $modelPRs = PurchaseRequisition::where('business_unit_id',1)->get();
        }elseif($route == "/purchase_requisition_repair"){
            $modelPRs = PurchaseRequisition::where('business_unit_id',2)->get();
        }

        return view('purchase_requisition.index', compact('modelPRs','route'));
    }

    public function indexApprove(Request $request)
    {
        $route = $request->route()->getPrefix();
        if($route == "/purchase_requisition"){
            $businessUnit = 1;
        }elseif($route == "/purchase_requisition_repair"){
            $businessUnit = 2;
        }
        $modelPRs = PurchaseRequisition::whereIn('status',[1,4])->where('business_unit_id',$businessUnit)->get();

        return view('purchase_requisition.indexApprove', compact('modelPRs','route'));
    }

    public function indexConsolidation(Request $request)
    {
        $route = $request->route()->getPrefix();
        if($route == "/purchase_requisition"){
            $modelPRs = PurchaseRequisition::whereIn('status',[1])->where('business_unit_id',1)->where('type','!=',3)->with('project')->get();
        }elseif($route == "/purchase_requisition_repair"){
            $modelPRs = PurchaseRequisition::whereIn('status',[1])->where('business_unit_id',2)->where('type','!=',3)->with('project')->get();
        }
        
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
        if($route == "/purchase_requisition"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get()->jsonSerialize();
        }elseif($route == "/purchase_requisition_repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get()->jsonSerialize();
        }
        $modelMaterial = Material::orderBy('code')->get()->jsonSerialize();
        $modelResource = Resource::orderBy('code')->get()->jsonSerialize();

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

        DB::beginTransaction();
        try {
            if($datas->pr_type == "Material"){
                $PR = new PurchaseRequisition;
                $PR->description = $datas->description;
                $PR->number = $pr_number;
                if($route == '/purchase_requisition'){
                    $PR->business_unit_id = 1;
                }else if($route == '/purchase_requisition_repair'){
                    $PR->business_unit_id = 2;
                }
                $PR->status = 1;
                $PR->type = 1;
                $PR->user_id = Auth::user()->id;
                $PR->branch_id = Auth::user()->branch->id;
                $PR->save();

                foreach($datas->datas as $data){
                    $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id',$PR->id)->get();
                    $required_date = DateTime::createFromFormat('d-m-Y', $data->required_date);
                    if($required_date){
                        $required_date = $required_date->format('Y-m-d');
                    }else{
                        $required_date = null;
                    }
                    if(count($modelPRD)>0){
                        $status = 0;
                        foreach($modelPRD as $PurchaseRD){
                            if($PurchaseRD->material_id == $data->material_id && $PurchaseRD->project_id == $data->project_id && $PurchaseRD->alocation == $data->alocation && $PurchaseRD->required_date == $required_date){
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
                            $PRD->required_date = $required_date;
                            if($data->project_id != null){
                                $PRD->project_id = $data->project_id;
                            }
                            $PRD->user_id = Auth::user()->id;
                            $PRD->save();
                        }
                    }else{
                        $PRD = new PurchaseRequisitionDetail;
                        $PRD->purchase_requisition_id = $PR->id;
                        $PRD->quantity = $data->quantity;
                        $PRD->material_id = $data->material_id;
                        $PRD->alocation = $data->alocation;
                        $PRD->required_date = $required_date;
                        if($data->project_id != null){
                            $PRD->project_id = $data->project_id;
                        }
                        $PRD->user_id = Auth::user()->id;
                        $PRD->save();
                    }
                }
            }elseif($datas->pr_type == "Resource"){
                $PR = new PurchaseRequisition;
                $PR->description = $datas->description;
                $PR->number = $pr_number;
                if($route == '/purchase_requisition'){
                    $PR->business_unit_id = 1;
                }else if($route == '/purchase_requisition_repair'){
                    $PR->business_unit_id = 2;
                }
                $PR->status = 1;
                $PR->type = 2;
                $PR->user_id = Auth::user()->id;
                $PR->branch_id = Auth::user()->branch->id;
                $PR->save();

                foreach($datas->datas as $data){
                    $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id',$PR->id)->get();
                    $required_date = DateTime::createFromFormat('d-m-Y', $data->required_date);
                    if($required_date){
                        $required_date = $required_date->format('Y-m-d');
                    }else{
                        $required_date = null;
                    }
                    if(count($modelPRD)>0){
                        $status = 0;
                        foreach($modelPRD as $PurchaseRD){
                            if($PurchaseRD->resource_id == $data->resource_id && $PurchaseRD->project_id == $data->project_id && $PurchaseRD->required_date == $required_date){
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
                            $PRD->required_date = $required_date;
                            if($data->project_id != null){
                                $PRD->project_id = $data->project_id;
                            }
                            $PRD->user_id = Auth::user()->id;
                            $PRD->save();
                        }
                    }else{
                        $PRD = new PurchaseRequisitionDetail;
                        $PRD->purchase_requisition_id = $PR->id;
                        $PRD->quantity = $data->quantity;
                        $PRD->resource_id = $data->resource_id;
                        $PRD->required_date = $required_date;
                        if($data->project_id != null){
                            $PRD->project_id = $data->project_id;
                        }
                        $PRD->user_id = Auth::user()->id;
                        $PRD->save();
                    }
                }
            }elseif($datas->pr_type == "Subcon"){
                $PR = new PurchaseRequisition;
                $PR->description = $datas->description;
                $PR->number = $pr_number;
                if($route == '/purchase_requisition'){
                    $PR->business_unit_id = 1;
                }else if($route == '/purchase_requisition_repair'){
                    $PR->business_unit_id = 2;
                }
                $PR->status = 1;
                $PR->type = 3;
                $PR->user_id = Auth::user()->id;
                $PR->branch_id = Auth::user()->branch->id;
                $PR->save();
                foreach($datas->datas as $data){
                    $PRD = new PurchaseRequisitionDetail;
                    $PRD->purchase_requisition_id = $PR->id;
                    $PRD->quantity = 1;
                    $PRD->job_order = $data->job_order;
                    $PRD->project_id = $data->project_id;
                    $PRD->wbs_id = $data->wbs_id;
                    $PRD->vendor_id = $data->vendor_id;
                    $PRD->user_id = Auth::user()->id;
                    $PRD->status = 1;
                    $PRD->save();
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

        DB::beginTransaction();
        try {
            $PR = new PurchaseRequisition;
            $PR->number = $pr_number;
            $PR->status = 1;
            $PR->type = $datas->type;
            $PR->description = 'PR Consolidation';
            if($route == '/purchase_requisition'){
                $PR->business_unit_id = 1;

            }elseif($route == '/purchase_requisition_repair'){
                $PR->business_unit_id = 2;
            }
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
                                if($modelPRD->material_id == $PRD->material_id && $modelPRD->alocation == $PRD->alocation && $modelPRD->required_date == $PRD->required_date && $modelPRD->project_id == $PRD->project_id){
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
                            $modelPRD->alocation = $PRD->alocation;
                            $modelPRD->required_date = $PRD->required_date;
                            if($PRD->user_id == null){
                                $modelPRD->user_id = $PRD->purchaseRequisition->user_id;
                                $modelPRD->project_id = $PRD->project_id;
                            }else{
                                $modelPRD->user_id = $PRD->user_id;
                                $modelPRD->project_id = $PRD->project_id;
                            }
                            $modelPRD->save();                            
                        }
                    }
                }else{
                    foreach($modelPR->purchaseRequisitionDetails as $PRD){
                        $status = 0;
                        $modelPRDs = PurchaseRequisitionDetail::where('purchase_requisition_id',$PR->id)->get();
                        if(count($modelPRDs) > 0){
                            foreach($modelPRDs as $modelPRD){
                                if($modelPRD->resource_id == $PRD->resource_id && $modelPRD->required_date == $PRD->required_date && $modelPRD->project_id == $PRD->project_id){
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
                            $modelPRD->required_date = $PRD->required_date;
                            if($PRD->purchaseRequisition->user_id == null){
                                $modelPRD->user_id = $PRD->purchaseRequisition->user_id;
                                $modelPRD->project_id = $PRD->project_id;
                            }else{
                                $modelPRD->user_id = $PRD->user_id;
                                $modelPRD->project_id = $PRD->project_id;
                            }
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
        if($modelPR->status == 1){
            $status = 'OPEN';
        }
        elseif($modelPR->status == 2){
            $status = 'APPROVED';
        }
        elseif($modelPR->status == 3){
            $status = 'NEEDS REVISION';
        }
        elseif($modelPR->status == 4){
            $status = 'REVISED';
        }
        elseif($modelPR->status == 5){
            $status = 'REJECTED';
        }
        elseif($modelPR->status == 0 || $modelPR->status == 7){
            $status = 'ORDERED';
        }
        elseif($modelPR->status == 6){
            $status = 'CONSOLIDATED';
        }

        return view('purchase_requisition.show', compact('modelPR','route','status'));
    }

    public function showApprove(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPR = PurchaseRequisition::findOrFail($id);
        if($modelPR->status == 1){
            $status = 'OPEN';
        }
        elseif($modelPR->status == 2){
            $status = 'APPROVED';
        }
        elseif($modelPR->status == 3){
            $status = 'NEEDS REVISION';
        }
        elseif($modelPR->status == 4){
            $status = 'REVISED';
        }
        elseif($modelPR->status == 5){
            $status = 'REJECTED';
        }
        elseif($modelPR->status == 0 || $modelPR->status == 7){
            $status = 'ORDERED';
        }
        elseif($modelPR->status == 6){
            $status = 'CONSOLIDATED';
        }

        return view('purchase_requisition.showApprove', compact('modelPR','route','status'));
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

        $PRD = PurchaseRequisitionDetail::where('purchase_requisition_id',$modelPR->id)->with('material','project','resource','material.uom','purchaseRequisition')->get();
        $modelPRD = Collection::make();
        foreach($PRD as $data){
            if($data->purchaseRequisition->type == 1){
                $modelPRD->push([
                    "id" => $data->id, 
                    "material_id" => $data->material_id, 
                    "material_name" => $data->material->description,
                    "material_code" => $data->material->code,
                    "quantity" => $data->quantity,
                    "unit" => $data->material->uom->unit,
                    "project_id" => $data->project_id,
                    "project_number" => ($data->project != null) ? $data->project->number : '',
                    "required_date" => $data->required_date,
                    "alocation" => $data->alocation,
                ]);
            }elseif($data->purchaseRequisition->type == 2){
                $modelPRD->push([
                    "id" => $data->id, 
                    "resource_id" => $data->resource_id, 
                    "resource_name" => $data->resource->description,
                    "resource_code" => $data->resource->code,
                    "quantity" => $data->quantity,
                    "unit" => '-',
                    "project_id" => $data->project->id,
                    "project_number" => ($data->project != null) ? $data->project->number : '',
                    "required_date" => $data->required_date,
                    "alocation" => $data->alocation,
                ]);
            }elseif($data->purchaseRequisition->type == 3){
                $modelPRD->push([
                    "id" => $data->id, 
                    "project_number" => $data->project->number, 
                    "wbs_number" => $data->wbs->number,
                    "wbs_description" => $data->wbs->description,
                    "service" => $data->activityDetail->serviceDetail->service->name,
                    "service_detail" => $data->activityDetail->serviceDetail->name,
                    "vendor_name" => $data->vendor->name,
                    "activity_id" => $data->activity_detail_id,
                ]);
            }
        }
        
        $materials = Material::orderBy('code')->get()->jsonSerialize();
        $resources = Resource::orderBy('code')->get()->jsonSerialize();

        if($route == "/purchase_requisition"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get()->jsonSerialize();
        }elseif($route == "/purchase_requisition_repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get()->jsonSerialize();
        }
        return view('purchase_requisition.edit', compact('modelPR','modelPRD','materials','resources','route','modelProject'));
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
            foreach($datas->deletedId as $id){
                $modelPRD = PurchaseRequisitionDetail::findOrFail($id);
                $modelPRD->delete();
            }
            $PR = PurchaseRequisition::find($datas->pr_id);
            $PR->description = $datas->description;
            if($PR->status == 3){
                $PR->status = 4;
            }
            $PR->update();
            if($PR->type == 1){
                foreach($datas->datas as $data){
                    if($data->required_date != null && $data->required_date != ''){
                        $required_date = DateTime::createFromFormat('d-m-Y', $data->required_date);
                        $required_date = $required_date->format('Y-m-d');
                    }else{
                        $required_date = null;
                    }
                    if($data->prd_id != null){
                        $status = 0;
                        foreach($PR->purchaseRequisitionDetails as $PurchaseRD){
                            if($PurchaseRD->material_id == $data->material_id && $PurchaseRD->alocation == $data->alocation && $PurchaseRD->project_id == $data->project_id && $PurchaseRD->id != $data->id && $PurchaseRD->required_date == $required_date){
                                $quantity = $PurchaseRD->quantity + $data->quantity;

                                $PRD = new PurchaseRequisitionDetail;
                                $PRD->purchase_requisition_id = $PR->id;
                                $PRD->quantity = $quantity;
                                $PRD->material_id = $data->material_id;
                                $PRD->alocation = $data->alocation;
                                $PRD->required_date = $required_date;
                                if($data->project_id != null){
                                    $PRD->project_id = $data->project_id;
                                }
                                $PRD->user_id = Auth::user()->id;
                                $PRD->save();
                                array_push($prd_id,$PurchaseRD->id,$data->id);
    
                                $status = 1;
                            }
                        }
                        // print_r($PR->purchaseRequisitionDetails);exit();
                        if($status == 0){
                            $PRD = PurchaseRequisitionDetail::find($data->id);
                            $PRD->material_id = $data->material_id;
                            $PRD->quantity = $data->quantity;
                            $PRD->alocation = $data->alocation;
                            if($data->project_id != null){
                                $PRD->project_id = $data->project_id;
                            }
                            $PRD->required_date = $required_date;
                            $PRD->update();
                        }
                    }else{
                        $status = 0;
                        foreach($PR->purchaseRequisitionDetails as $PurchaseRD){
                            if($PurchaseRD->material_id == $data->material_id && $PurchaseRD->project_id == $data->project_id && $PurchaseRD->alocation == $data->alocation && $PurchaseRD->required_date == $required_date){
                                $PurchaseRD->quantity +=$data->quantity;
                                $PurchaseRD->alocation = $data->alocation;
                                $PurchaseRD->required_date = $required_date;
                                if($data->project_id != null){
                                    $PurchaseRD->project_id = $data->project_id;
                                }
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
                            $PRD->required_date = $required_date;
                            if($data->project_id != null){
                                $PRD->project_id = $data->project_id;
                            }
                            $PRD->user_id = Auth::user()->id;
                            $PRD->save();
                        }
                    }
                }
                $this->destroy(json_encode($prd_id));
            }elseif($PR->type == 2){
                foreach($datas->datas as $data){
                    if($data->required_date != null && $data->required_date != ''){
                        $required_date = DateTime::createFromFormat('d-m-Y', $data->required_date);
                        $required_date = $required_date->format('Y-m-d');
                    }else{
                        $required_date = null;
                    }
                    if($data->prd_id != null){
                        $status = 0;
                        foreach($PR->purchaseRequisitionDetails as $PurchaseRD){
                            if($PurchaseRD->resource_id == $data->resource_id && $PurchaseRD->project_id == $data->project_id && $PurchaseRD->id != $data->id && $PurchaseRD->required_date == $required_date){
                                $quantity = $PurchaseRD->quantity + $data->quantity;

                                $PRD = new PurchaseRequisitionDetail;
                                $PRD->purchase_requisition_id = $PR->id;
                                $PRD->quantity = $quantity;
                                $PRD->resource_id = $data->resource_id;
                                $PRD->alocation = $data->alocation;
                                $PRD->required_date = $required_date;
                                if($data->project_id != null){
                                    $PRD->project_id = $data->project_id;
                                }
                                $PRD->user_id = Auth::user()->id;
                                $PRD->save();
                                array_push($prd_id,$PurchaseRD->id,$data->id);
    
                                $status = 1;
                            }
                        }
                        if($status == 0){
                            $PRD = PurchaseRequisitionDetail::find($data->id);
                            $PRD->quantity = $data->quantity;
                            $PRD->alocation = $data->alocation;
                            $PRD->required_date = $required_date;
                            if($data->project_id != null){
                                $PRD->project_id = $data->project_id;
                            }
                            $PRD->update();
                        }
                    }else{
                        $status = 0;
                        foreach($PR->purchaseRequisitionDetails as $PurchaseRD){
                            if($PurchaseRD->resource_id == $data->resource_id && $PurchaseRD->project_id == $data->project_id && $PurchaseRD->required_date == $required_date){
                                $PurchaseRD->quantity +=$data->quantity;
                                $PurchaseRD->alocation = $data->alocation;
                                $PurchaseRD->required_date = $required_date;
                                if($data->project_id != null){
                                    $PurchaseRD->project_id = $data->project_id;
                                }
                                $PurchaseRD->update();

                                $status = 1;
                            }
                        }
                        if($status == 0){
                            $PRD = new PurchaseRequisitionDetail;
                            $PRD->purchase_requisition_id = $PR->id;
                            $PRD->quantity = $data->quantity;
                            $PRD->resource_id = $data->resource_id;
                            $PRD->alocation = $data->alocation;
                            $PRD->required_date = $required_date;
                            if($data->project_id != null){
                                $PRD->project_id = $data->project_id;
                            }
                            $PRD->user_id = Auth::user()->id;
                            $PRD->save();
                        }
                    }
                }
                $this->destroy(json_encode($prd_id));
            }elseif($PR->type == 3){
                foreach($datas->datas as $data){
                    if($data->prd_id == null){
                        $PRD = new PurchaseRequisitionDetail;
                        $PRD->purchase_requisition_id = $PR->id;
                        $PRD->quantity = 1;
                        $PRD->activity_detail_id = $data->activity_detail_id;
                        $PRD->project_id = $data->project_id;
                        $PRD->wbs_id = $data->wbs_id;
                        $PRD->vendor_id = $data->vendor_id;
                        $PRD->user_id = Auth::user()->id;
                        $PRD->status = 1;
                        $PRD->save();
                    }
                }
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
    public function approval(Request $request)
    {
        $datas = json_decode($request->datas);
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try{
            $modelPR = PurchaseRequisition::findOrFail($datas->pr_id);
            if($datas->status == "approve"){
                $modelPR->status = 2;
                $modelPR->revision_description = $datas->desc;
                $modelPR->approved_by = Auth::user()->id;
                $modelPR->update();
                DB::commit();
                if($route == "/purchase_requisition"){
                    return redirect()->route('purchase_requisition.show',$datas->pr_id)->with('success', 'Purchase Requisition Approved');
                }elseif($route == "/purchase_requisition_repair"){
                    return redirect()->route('purchase_requisition_repair.show',$datas->pr_id)->with('success', 'Purchase Requisition Approved');
                }
            }elseif($datas->status == "need-revision"){
                $modelPR->status = 3;
                $modelPR->revision_description = $datas->desc;
                $modelPR->approved_by = Auth::user()->id;
                $modelPR->update();
                DB::commit();
                if($route == "/purchase_requisition"){
                    return redirect()->route('purchase_requisition.show',$datas->pr_id)->with('success', 'Purchase Requisition Need Revision');
                }elseif($route == "/purchase_requisition_repair"){
                    return redirect()->route('purchase_requisition_repair.show',$datas->pr_id)->with('success', 'Purchase Requisition Need Revision');
                }
            }elseif($datas->status == "reject"){
                $modelPR->status = 5;
                $modelPR->revision_description = $datas->desc;
                $modelPR->approved_by = Auth::user()->id;
                $modelPR->update();
                if($modelPR->type == 3){
                    foreach($modelPR->purchaseRequisitionDetails as $PRD){
                        $PRD->status = 0;
                        $PRD->update();
                    }
                }
                DB::commit();
                if($route == "/purchase_requisition"){
                    return redirect()->route('purchase_requisition.show',$datas->pr_id)->with('success', 'Purchase Requisition Rejected');
                }elseif($route == "/purchase_requisition_repair"){
                    return redirect()->route('purchase_requisition_repair.show',$datas->pr_id)->with('success', 'Purchase Requisition Rejected');
                }
            }
        } catch (\Exception $e){
            DB::rollback();
            return redirect()->route('purchase_requisition.show',$datas->pr_id)->with('error', $e->getMessage());
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

    public function printPdf($id, Request $request)
    {
        $modelPR = PurchaseRequisition::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $branch = Branch::find(Auth::user()->branch_id);
        $route = $request->route()->getPrefix();
        $pdf->loadView('purchase_requisition.pdf',['modelPR' => $modelPR, 'branch' => $branch, 'route'=> $route]);
        $now = date("Y_m_d_H_i_s");
        
        return $pdf->stream('Purchase_Requisition_'.$now.'.pdf');
    }

    public function getProjectApi($id){

        return response(Project::where('id',$id)->with('ship', 'customer')->first()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getMaterialAPI($id){
        
        return response(Material::where('id',$id)->with('uom')->first()->jsonSerialize(), Response::HTTP_OK);
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

    public function getModelWbsAPI($id){

        return response(WBS::where('project_id',$id)->with('project')->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getModelActivityAPI($id,$ids){
        $ids = json_decode($ids);
        $modelActivity = Activity::where('wbs_id',$id)->with('activityDetails.serviceDetail','activityDetails.serviceDetail.service','activityDetails.vendor')->get();
        $serviceDetails = Collection::make();

        foreach($modelActivity as $activity){
            foreach($activity->activityDetails as $AD){
                if($AD->service_detail_id != null){
                    $status = true;
                    foreach($ids as $id){
                        if($id == $AD->id){
                            $status = false;
                        }
                    }
                    if($status){
                        $serviceDetails->push($AD);
                    }
                }
            }
        }
        return response($serviceDetails->jsonSerialize(), Response::HTTP_OK);
    }

    public function getActivityIdAPI(){
        $activity_id = [];
        $modelPRD = PurchaseRequisitionDetail::where('activity_detail_id','!=',null)->where('status',1)->get();

        foreach($modelPRD as $PRD){
            array_push($activity_id,$PRD->activity_detail_id);
        }

        return response(json_encode($activity_id), Response::HTTP_OK);
    }
}
