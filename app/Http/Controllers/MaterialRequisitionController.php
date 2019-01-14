<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MaterialRequisition;
use App\Models\MaterialRequisitionDetail;
use App\Models\Branch;
use App\Models\Material;
use App\Models\WBS;
use App\Models\Project;
use App\Models\Stock;
use Illuminate\Support\Collection;
use Auth;
use DB;

class MaterialRequisitionController extends Controller
{

    public function index(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->pluck('id')->toArray();
        }else{
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->pluck('id')->toArray();
        }

        $modelMRs = MaterialRequisition::whereIn('project_id',$modelProject)->get();

        return view('material_requisition.index', compact('modelMRs','menu'));
    }

    public function indexApprove(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->pluck('id')->toArray();
        }else{
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->pluck('id')->toArray();
        }

        $modelMRs = MaterialRequisition::whereIn('status',[1,4])->whereIn('project_id',$modelProject)->get();

        return view('material_requisition.indexApprove', compact('modelMRs','menu'));
    }
    
    public function create(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get();
        }else{
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get();
        }    

        return view('material_requisition.create', compact('modelProject','menu'));
    }

    public function store(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        $datas = json_decode($request->datas);
        $mr_number = $this->generateMRNumber();

        DB::beginTransaction();
        try {
            $MR = new MaterialRequisition;
            $MR->number = $mr_number;
            $MR->project_id = $datas->project_id;
            $MR->description = $datas->description;
            $MR->status = 1;
            $MR->type = 0;
            $MR->user_id = Auth::user()->id;
            $MR->branch_id = Auth::user()->branch->id;
            $MR->save();

            foreach($datas->materials as $data){
                $modelMRDs = MaterialRequisitionDetail::where('material_requisition_id',$MR->id)->get();
                if(count($modelMRDs)>0){
                    $status = 0;
                    foreach($modelMRDs as $MRD){
                        if($MRD->material_id == $data->material_id && $MRD->wbs_id == $data->wbs_id){
                            $updatedQty = $MRD->quantity + $data->quantityInt;
                            $this->updateReserveStock($data->material_id, $MRD->quantity ,$updatedQty);
                            $MRD->quantity = $updatedQty;
                            $MRD->update();

                            $status = 1;
                        }
                    }
                    if($status == 0){
                        $MRD = new MaterialRequisitionDetail;
                        $MRD->material_requisition_id = $MR->id;
                        $MRD->quantity = $data->quantityInt;
                        $MRD->material_id = $data->material_id;
                        $MRD->wbs_id = $data->wbs_id;
                        $MRD->save();

                        $this->reserveStock($data->material_id, $data->quantityInt);
                    }
                }else{
                    $MRD = new MaterialRequisitionDetail;
                    $MRD->material_requisition_id = $MR->id;
                    $MRD->quantity = $data->quantityInt;
                    $MRD->material_id = $data->material_id;
                    $MRD->wbs_id = $data->wbs_id;
                    $MRD->save();

                    $this->reserveStock($data->material_id, $data->quantityInt);
                }
            }
            
            DB::commit();
            if($menu == "building"){
                return redirect()->route('material_requisition.show',$MR->id)->with('success', 'Material Requisition Created');
            }else{
                return redirect()->route('material_requisition_repair.show',$MR->id)->with('success', 'Material Requisition Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('material_requisition.create')->with('error', $e->getMessage());
            }else{
                return redirect()->route('material_requisition_repair.create')->with('error', $e->getMessage());
            }
        }
    }

    public function show($id)
    {
        $modelMR = MaterialRequisition::findOrFail($id);
       

        return view('material_requisition.show', compact('modelMR'));
    }

    public function showApprove($id, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    

        $modelMR = MaterialRequisition::findOrFail($id);

        return view('material_requisition.showApprove', compact('modelMR','menu'));
    }

    public function edit($id, Request $request)
    {
        $modelMR = MaterialRequisition::findOrFail($id);
        $modelMaterial = Material::all()->jsonSerialize();
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = $modelMR->project->with('ship','customer','wbss')->where('business_unit_id',2)->first()->jsonSerialize();
        }else{
            $modelProject = $modelMR->project->with('ship','customer','wbss')->where('business_unit_id',1)->first()->jsonSerialize();
        }
        $modelWBS = $modelMR->project->wbss; 
        $modelMRD = Collection::make();
        foreach($modelMR->MaterialRequisitionDetails as $mrd){
            $modelMRD->push([
                "mrd_id" => $mrd->id,
                "material_id" => $mrd->material_id,
                "material_code" => $mrd->material->code,
                "material_name" => $mrd->material->name,
                "quantity" => number_format($mrd->quantity),
                "quantityInt" => $mrd->quantity,
                "wbs_id" => $mrd->wbs_id,
                "wbs_name" => $mrd->wbs->name,
            ]);
        }
        return view('material_requisition.edit', compact('menu','modelMR','modelMRD','modelMaterial','modelProject','modelWBS'));
    }

    public function update(Request $request, $id)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            $MR = MaterialRequisition::find($id);
            $MR->description = $datas->description;
            if($MR->status == 3){
                $MR->status = 4;
            }
            $MR->update();

            foreach($datas->materials as $data){
                if($data->mrd_id != null){
                    $MRD = MaterialRequisitionDetail::find($data->mrd_id);
                    $this->updateReserveStock($data->material_id, $MRD->quantity ,$data->quantityInt);
                    
                    $MRD->quantity = $data->quantityInt;
                    $MRD->wbs_id = $data->wbs_id;
                    $MRD->update();
                }else{
                    $modelMRDs = MaterialRequisitionDetail::where('material_requisition_id',$MR->id)->get();
                    if(count($modelMRDs)>0){
                        $status = 0;
                        foreach($modelMRDs as $MRD){
                            if($MRD->material_id == $data->material_id && $MRD->wbs_id == $data->wbs_id){
                                $updatedQty = $MRD->quantity + $data->quantityInt;
                                $this->updateReserveStock($data->material_id, $MRD->quantity ,$updatedQty);
                                $MRD->quantity = $updatedQty;
                                $MRD->update();
    
                                $status = 1;
                            }
                        }
                        if($status == 0){
                            $MRD = new MaterialRequisitionDetail;
                            $MRD->material_requisition_id = $MR->id;
                            $MRD->quantity = $data->quantityInt;
                            $MRD->material_id = $data->material_id;
                            $MRD->wbs_id = $data->wbs_id;
                            $MRD->save();
    
                            $this->reserveStock($data->material_id, $data->quantityInt);
                        }
                    }else{
                        $MRD = new MaterialRequisitionDetail;
                        $MRD->material_requisition_id = $MR->id;
                        $MRD->quantity = $data->quantityInt;
                        $MRD->material_id = $data->material_id;
                        $MRD->wbs_id = $data->wbs_id;
                        $MRD->save();
    
                        $this->reserveStock($data->material_id, $data->quantityInt);
                    }
                }


            }
            DB::commit();
            if($menu == "building"){
                return redirect()->route('material_requisition.show',$MR->id)->with('success', 'Material Requisition Updated');
            }else{
                return redirect()->route('material_requisition_repair.show',$MR->id)->with('success', 'Material Requisition Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('material_requisition.edit',$MR->id)->with('error', $e->getMessage());
            }else{
                return redirect()->route('material_requisition_repair.edit',$MR->id)->with('error', $e->getMessage());
            }
        }
    }


    public function approval($mr_id,$status, Request $request){
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        $modelMR = MaterialRequisition::findOrFail($mr_id);
        if($status == "approve"){
            $modelMR->status = 2;
            $modelMR->update();
        }elseif($status == "need-revision"){
            $modelMR->status = 3;
            $modelMR->update();
        }elseif($status == "reject"){
            $modelMR->status = 5;
            $modelMR->update();
        }
        if($menu == "building"){
            return redirect()->route('material_requisition.show',$mr_id)->with('success', 'Material Requisition Updated');
        }else{
            return redirect()->route('material_requisition_repair.show',$mr_id)->with('success', 'Material Requisition Updated');
        }
    }
    // function
    public function reserveStock($material_id,$quantity){
        $modelStock = Stock::where('material_id',$material_id)->first();
        if($modelStock){
            $modelStock->reserved = $modelStock->reserved + $quantity;
            $modelStock->save();
        }
    }

    public function updateReserveStock($material_id,$oldQty, $newQty){
        $difference = $newQty - $oldQty;
        $modelStock = Stock::where('material_id',$material_id)->first();
        if($modelStock){
            $modelStock->reserved = $modelStock->reserved + $difference;
            $modelStock->save();
        }
    }

    public function generateMRNumber(){
        $modelMR = MaterialRequisition::orderBy('created_at','desc')->first();
        $yearNow = date('y');
        
		$number = 1;
        if(isset($modelMR)){
            $yearDoc = substr($modelMR->number, 3,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelMR->number, -5));
            }
        }

        $year = date($yearNow.'000000');
        $year = intval($year);

		$mr_number = $year+$number;
        $mr_number = 'MR-'.$mr_number;
        
        return $mr_number;
    }

    //API
    public function getWbsAPI($id){
        $data = array();

        $wbs = WBS::findOrFail($id);
        if($wbs->bom != null){
            $material_ids = $wbs->bom->bomDetails->pluck('material_id')->toArray();
            $data['materials'] = Material::whereIn('id',$material_ids)->get();
        }else{
            $data['materials'] = [];
        }

        $data['wbs'] = $wbs->jsonSerialize();

        return response($data, Response::HTTP_OK);
    }

    public function getWbsEditAPI($id, $mr_id){
        $data = array();
        $mrds = MaterialRequisition::find($mr_id)->MaterialRequisitionDetails;
        $exisiting_material = $mrds->where('wbs_id',$id)->pluck('material_id')->toArray();

        $wbs = WBS::findOrFail($id);
        if($wbs->bom != null){
            $material_ids = $wbs->bom->bomDetails->pluck('material_id')->toArray();
            $data['materials'] = Material::whereIn('id',$material_ids)->whereNotIn('id', $exisiting_material)->get();
        }else{
            $data['materials'] = [];
        }

        $data['wbs'] = $wbs->jsonSerialize();

        return response($data, Response::HTTP_OK);
    }

    public function getProjectApi($id){
        $project = Project::where('id',$id)->with('ship','customer','wbss')->first()->jsonSerialize();

        return response($project, Response::HTTP_OK);
    }

    public function getMaterialAPI($id){
        
        return response(Material::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }
}
