<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Ship;
use App\Models\ProjectStandard;
use App\Models\WbsStandard;
use App\Models\ActivityStandard;
use App\Models\Material;
use App\Models\MaterialStandard;
use App\Models\Resource;
use App\Models\ResourceStandard;
use App\Models\Configuration;
use App\Models\Uom;
use App\Models\PartDetailStandard;
use DB;
use Auth;
use Illuminate\Support\Collection;

class ProjectStandardController extends Controller
{
    //Project
    public function createProjectStandard(Request $request)
    {
        $ships = Ship::all();
        return view('project_standard.createProjectStandard', compact('ships'));
    }

    public function storeProjectStandard(Request $request)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $projectStandard = new ProjectStandard;
            $projectStandard->ship_id = $data['shipType'];
            $projectStandard->name = $data['name'];
            $projectStandard->description = $data['description'];

            $projectStandard->user_id = Auth::user()->id;
            $projectStandard->branch_id = Auth::user()->branch->id;

            if(!$projectStandard->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to create new Project Standard"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function updateProjectStandard(Request $request, $id)
    {
        $data = $request->json()->all();
        $project_standard_ref = ProjectStandard::find($id);
        DB::beginTransaction();
        try {
            $project_standard_ref->ship_id = $data['shipType'];
            $project_standard_ref->name = $data['name'];
            $project_standard_ref->description = $data['description'];

            if(!$project_standard_ref->update()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update Project Standard ".$project_standard_ref->name],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function destroyProjectStandard(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $projectStandard = ProjectStandard::find($id);
            $error = [];
            if(count($projectStandard->wbss)>0){
                array_push($error, ["Failed to delete, this Project Standard have WBS"]);
            }

            if(count($projectStandard->projects)>0){
                array_push($error, ["Failed to delete, this Project Standard already been used by a project"]);
            }
            
            if(count($error)>0){
                return response(["error"=> $error],Response::HTTP_OK);
            }
            if(!$projectStandard->delete()){
                array_push($error, ["Failed to delete, please try again!"]);
                return response(["error"=> $error],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to delete Project Standard"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    //WBS
    public function createWbsStandard(Request $request,$id)
    {
        $project_standard = ProjectStandard::find($id);

        return view('project_standard.createWbsStandard', compact('project_standard'));
    }

    public function createSubWbsStandard($wbs_id, Request $request)
    {
        $wbs = WbsStandard::find($wbs_id);
        $project_standard = $wbs->projectStandard;
        $array = [
            'Dashboard' => route('index'),
            'Project Standard |'.$project_standard->name => route('project_standard.createProjectStandard'),
            'Create WBS Standard' => route('project_standard.createWbsStandard',$project_standard->id),
        ];
        $iteration = 0;
        $array_reverse = [];
        $array_reverse = array_reverse(self::getParentsWbsStandard($wbs,$array_reverse, $iteration));
        foreach ($array_reverse as $key => $value) {
            $array[$key] = $value;
        }

        $array["WBS ".$wbs->number] = "";
        return view('project_standard.createSubWbsStandard', compact('wbs','array','project_standard'));
    }

    public function selectProject(Request $request)
    {
        $action = null;
        if($request->is('project_standard/selectProject/resource')){
            $action = "resource";
            $route = "selectWBSResource";
        }elseif($request->is('project_standard/selectProject/material')){
            $action = "material";
            $route = "selectWBSMaterial";
        }
        $projects = ProjectStandard::all();

        return view('project_standard.selectProject', compact('projects','action','route'));
    }

    public function selectWBS(Request $request, $action,$id)
    {
        $route = $request->route()->getPrefix();
        $project = ProjectStandard::find($id);
        $wbss = $project->wbss;
        $data = Collection::make();

        $data->push([
            "id" => "PRO".$project->id, 
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);

        $route = "";
        $item_text = "";
        if($action == "resource"){
            $route = "project_standard.manageResource";
            $item_text = "Resource";
        }elseif($action == "material"){
            $route = "project_standard.manageMaterial";
            $item_text = "Material";
        }

        
        foreach($wbss as $wbs){
            $exist = "";
            if($action == "resource"){
                $item_standard = ResourceStandard::where('wbs_standard_id',$wbs->id)->first();
            }elseif($action == "material"){
                $item_standard = MaterialStandard::where('wbs_standard_id',$wbs->id)->first();
            }            
            if($item_standard){
                $exist = " - this WBS Standard has ".$item_text." Standard Click to Edit";
                if($wbs->wbs){
                    $data->push([
                        "id" => "WBS".$wbs->id, 
                        "parent" => "WBS".$wbs->wbs->id,
                        "text" => $wbs->number.' - '.$wbs->description.'<b>'.$exist.'</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route($route,$wbs->id)],
                    ]);
                }else{
                    $data->push([
                        "id" => "WBS".$wbs->id , 
                        "parent" => "PRO".$project->id,
                        "text" => $wbs->number.' - '.$wbs->description.'<b>'.$exist.'</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route($route,$wbs->id)],
                    ]);
                } 
            }else{
                if($wbs->wbs){
                    $data->push([
                        "id" => "WBS".$wbs->id , 
                        "parent" => "WBS".$wbs->wbs->id,
                        "text" => $wbs->number.' - '.$wbs->description.'<b>'.$exist.'</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route($route,$wbs->id)],
                    ]);
                }else{
                    $data->push([
                        "id" => "WBS".$wbs->id , 
                        "parent" => "PRO".$project->id,
                        "text" => $wbs->number.' - '.$wbs->description.'<b>'.$exist.'</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route($route,$wbs->id)],
                    ]);
                } 
            } 
        }
        return view('project_standard.selectWBS', compact('project','data','route','action'));
    }

    public function manageMaterial($wbs_id, Request $request)
    {
        $wbs = WbsStandard::find($wbs_id);
        $project = ProjectStandard::where('id',$wbs->project_standard_id)->with('ship')->first();
        $materials = Material::orderBy('code')->get()->jsonSerialize();
        $densities = Configuration::get('density');
        $existing_data = [];

        $material_ids = [];
        $edit = false;
        if(count($wbs->materialStandards)>0){
            $edit = true;
            $existing_data = MaterialStandard::where('wbs_standard_id', $wbs->id)->with('material.uom','material.weightUom','partDetails')->get();
            foreach ($existing_data as $material) {
                array_push($material_ids,$material->material_id);
                $material->material_code = $material->material->code;
                $material->material_name = $material->material->description;
                $material->unit = $material->material->uom->unit;

                if($material->material->dimensions_value != null){
                    $dimensions = json_decode($material->material->dimensions_value);
                    foreach ($dimensions as $dimension) {
                        $uom = Uom::find($dimension->uom_id);
                        $dimension->uom = $uom;
                    }
                    $material->material->dimensions_value_obj = $dimensions;
                    $material->material->dimensions_value = json_encode($dimensions);
                }

                $material->selected_material = $material->material;

                foreach ($densities as $density) {
                    if($density->id == $material->material->density_id){
                        $material->material->density = $density;
                    }
                }

                foreach ($material->partDetails as $part) {
                    $part->edit = false;
                    $part->dimensions_value_obj = json_decode($part->dimensions_value);
                    foreach ($part->dimensions_value_obj as $dimension) {
                        $dimension->uom = Uom::find($dimension->uom_id);
                    }
                }
            }
        }
        
        return view('project_standard.manageMaterial', compact('project','materials','wbs','edit','existing_data','material_ids'));
    }

    public function manageResource($wbs_id, Request $request)
    {
        $wbs = WbsStandard::find($wbs_id);
        $project = ProjectStandard::where('id',$wbs->project_standard_id)->with('ship')->first();
        $resources = Resource::orderBy('code')->get()->jsonSerialize();
        $existing_data = [];

        $resource_ids = [];
        $edit = false;
        if(count($wbs->resourceStandards)>0){
            $edit = true;
            $existing_data = ResourceStandard::where('wbs_standard_id', $wbs->id)->with('resource')->get();
            foreach ($existing_data as $resource) {
                array_push($resource_ids,$resource->resource_id);
                $resource->resource_code = $resource->resource->code;
                $resource->resource_name = $resource->resource->description;
            }
        }
        
        return view('project_standard.manageResource', compact('project','resources','wbs','edit','existing_data','resource_ids'));
    }

    public function storeMaterialStandard(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            foreach($datas->materials as $material){
                $materialStandard = new MaterialStandard;
                $materialStandard->project_standard_id = $datas->project_id;
                $materialStandard->wbs_standard_id = $datas->wbs_id;
                $materialStandard->material_id = $material->material_id;
                $materialStandard->quantity = $material->quantity;
                $materialStandard->save();

                if(isset($material->part_details)){
                    if(count($material->part_details) > 0){
                        foreach ($material->part_details as $part_detail) {
                            foreach ($part_detail->dimensions_value_obj as $dimension) {
                                unset($dimension->value);
                                unset($dimension->uom);
                            }
                            $temp_dimensions_value = json_encode($part_detail->dimensions_value_obj);

                            $new_part = new PartDetailStandard;
                            $new_part->description = $part_detail->description;
                            $new_part->material_standard_id = $materialStandard->id;
                            $new_part->dimensions_value = $temp_dimensions_value;
                            $new_part->weight = $part_detail->weight;
                            $new_part->quantity = $part_detail->quantity;
                            $new_part->save();
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->route('project_standard.showMaterialStandard', ['id' => $datas->wbs_id])->with('success', 'Material Standard Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project_standard.selectProjectMaterial')->with('error', $e->getMessage());
        }
    }

    public function storeResourceStandard(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            foreach($datas->resources as $resource){
                $resourceStandard = new ResourceStandard;
                $resourceStandard->project_standard_id = $datas->project_id;
                $resourceStandard->wbs_standard_id = $datas->wbs_id;
                $resourceStandard->resource_id = $resource->resource_id;
                $resourceStandard->quantity = $resource->quantity;
                $resourceStandard->save();
            }
            DB::commit();
            return redirect()->route('project_standard.showResourceStandard', ['id' => $datas->wbs_id])->with('success', 'Resource Standard Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project_standard.selectProjectResource')->with('error', $e->getMessage());
        }
    }

    public function updateMaterialStandard(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            foreach ($datas->deleted_id as $id) {
                $materialStandard = MaterialStandard::find($id);
                $materialStandard->partDetails()->delete();
                $materialStandard->delete();
            }
            foreach ($datas->deleted_part_id as $id) {
                $partDetail = PartDetailStandard::find($id);
                $partDetail->delete();
            }
            foreach($datas->materials as $material){
                if(isset($material->id)){
                    $materialStandard = MaterialStandard::find($material->id);
                    $materialStandard->material_id = $material->material_id;
                    $materialStandard->quantity = $material->quantity;
                    $materialStandard->update();
                }else{
                    $materialStandard = new MaterialStandard;
                    $materialStandard->project_standard_id = $datas->project_id;
                    $materialStandard->wbs_standard_id = $datas->wbs_id;
                    $materialStandard->material_id = $material->material_id;
                    $materialStandard->quantity = $material->quantity;
                    $materialStandard->save();
                }
                if(isset($material->part_details)){
                    if(count($material->part_details) > 0){
                        foreach ($material->part_details as $part_detail) {

                            if(isset($part_detail->id)){
                                $part = PartDetailStandard::find($part_detail->id);
                            }else{
                                $part = new PartDetailStandard;
                            }
                            foreach ($part_detail->dimensions_value_obj as $dimension) {
                                unset($dimension->value);
                                unset($dimension->uom);
                            }
                            $temp_dimensions_value = json_encode($part_detail->dimensions_value_obj);

                            $part->description = $part_detail->description;
                            $part->material_standard_id = $materialStandard->id;
                            $part->dimensions_value = $temp_dimensions_value;
                            $part->weight = $part_detail->weight;
                            $part->quantity = $part_detail->quantity;

                            if(isset($part_detail->id)){
                                $part->update();
                            }else{
                                $part->save();
                            }
                        }
                    }
                }
            }
            DB::commit();
            if($datas->edit){
                return redirect()->route('project_standard.showMaterialStandard', ['id' => $datas->wbs_id])->with('success', 'Material Standard Updated');
            }else{
                return redirect()->route('project_standard.showMaterialStandard', ['id' => $datas->wbs_id])->with('success', 'Material Standard Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project_standard.selectProjectMaterial')->with('error', $e->getMessage());
        }
    }

    public function updateResourceStandard(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            foreach ($datas->deleted_id as $id) {
                $resourceStandard = ResourceStandard::find($id);
                $resourceStandard->delete();
            }
            foreach($datas->resources as $resource){
                if(isset($resource->id)){
                    $resourceStandard = ResourceStandard::find($resource->id);
                    $resourceStandard->resource_id = $resource->resource_id;
                    $resourceStandard->quantity = $resource->quantity;
                    $resourceStandard->update();
                }else{
                    $resourceStandard = new ResourceStandard;
                    $resourceStandard->project_standard_id = $datas->project_id;
                    $resourceStandard->wbs_standard_id = $datas->wbs_id;
                    $resourceStandard->resource_id = $resource->resource_id;
                    $resourceStandard->quantity = $resource->quantity;
                    $resourceStandard->save();
                }
            }
            DB::commit();
            if($datas->edit){
                return redirect()->route('project_standard.showResourceStandard', ['id' => $datas->wbs_id])->with('success', 'Resource Standard Updated');
            }else{
                return redirect()->route('project_standard.showResourceStandard', ['id' => $datas->wbs_id])->with('success', 'Resource Standard Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project_standard.selectProjectResource')->with('error', $e->getMessage());
        }
    }

    public function showMaterialStandard(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $materialStandards = MaterialStandard::where('wbs_standard_id',$id)->with('material.uom')->get();
        $wbs = WbsStandard::find($id); 
        $project = ProjectStandard::where('id', $wbs->project_standard_id)->with('ship')->first();

        return view('project_standard.showMaterialStandard', compact('materialStandards','wbs','project','route'));
    }

    public function showResourceStandard(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $resourceStandards = ResourceStandard::where('wbs_standard_id',$id)->with('resource')->get();
        $wbs = WbsStandard::find($id); 
        $project = ProjectStandard::where('id', $wbs->project_standard_id)->with('ship')->first();

        return view('project_standard.showResourceStandard', compact('resourceStandards','wbs','project','route'));
    }

    public function storeWbsStandard(Request $request)
    {
        $data = $request->json()->all();
        $modelWbsStandard = WbsStandard::where('number',$data['number'])->first();
        if($modelWbsStandard != null){
            return response(["error"=> "WBS Number must be UNIQUE"],Response::HTTP_OK);
        }
        DB::beginTransaction();
        try {
            $wbsStandard = new WbsStandard;
            $wbsStandard->number = $data['number'];
            $wbsStandard->project_standard_id = $data['project_standard_id'];
            $wbsStandard->description = $data['description'];
            $wbsStandard->deliverables = $data['deliverables'];
            $wbsStandard->duration = $data['duration'];

            if(isset($data['wbs_configuration_id'])){
                $wbsStandard->wbs_id = $data['wbs_configuration_id'];
            }

            $wbsStandard->user_id = Auth::user()->id;
            $wbsStandard->branch_id = Auth::user()->branch->id;

            if(!$wbsStandard->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to create new WBS Standard"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function updateWbsStandard(Request $request, $id)
    {
        $data = $request->json()->all();
        $wbs_ref = WbsStandard::find($id);
        $modelWbsStandard = WbsStandard::where('number',$data['number'])->where('id','!=',$id)->first();
        if($modelWbsStandard != null){
            return response(["error"=> "WBS Number must be UNIQUE"],Response::HTTP_OK);
        }
        DB::beginTransaction();
        try {
            $wbs_ref->number = $data['number'];
            $wbs_ref->description = $data['description'];
            $wbs_ref->deliverables = $data['deliverables'];
            $wbs_ref->duration = $data['duration'];
    
            if(!$wbs_ref->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update WBS ".$wbs_ref->number],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function destroyWbsStandard(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $wbsStandard = WbsStandard::find($id);
            $error = [];
            if(count($wbsStandard->wbss)>0){
                array_push($error, ["Failed to delete, this WBS have child WBS"]);
            }

            if(count($wbsStandard->activities)>0){
                array_push($error, ["Failed to delete, this WBS have activities"]);
            }

            if(count($wbsStandard->wbssProject)>0){
                array_push($error, ["Failed to delete, this WBS already been used by a project"]);
            }
            
            if(count($error)>0){
                return response(["error"=> $error],Response::HTTP_OK);
            }
            if(!$wbsStandard->delete()){
                array_push($error, ["Failed to delete, please try again!"]);
                return response(["error"=> $error],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to delete WBS"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    //Activity
    public function createActivityStandard($id, Request $request)
    {
        $wbs = WbsStandard::find($id);
        $project_standard = $wbs->projectStandard;

        return view('project_standard.createActivityStandard', compact('wbs', 'project_standard'));
    }

    public function storeActivityStandard(Request $request)
    {
        $data = $request->json()->all();
        $modelActConfig = ActivityStandard::where('wbs_id',$data['wbs_id'])->where('name',$data['name'])->first();
        if($modelActConfig != null){
            return response(["error"=> "Activity name on This WBS must be UNIQUE"],Response::HTTP_OK);
        }
        DB::beginTransaction();
        try {
            $activity = new ActivityStandard;
            $activity->name = $data['name'];
            $activity->description = $data['description'];
            $activity->wbs_id = $data['wbs_id'];            
            $activity->duration = $data['duration'];
            $activity->user_id = Auth::user()->id;
            $activity->branch_id = Auth::user()->branch->id;

            if(!$activity->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to create new activity configuration"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function updateActivityStandard(Request $request, $id)
    {
        $data = $request->json()->all();
        $activity = ActivityStandard::find($id);
        $modelActConfig = ActivityStandard::where('wbs_id',$activity->wbs_id)->where('name',$data['name'])->where('id','!=',$id)->first();
        if($modelActConfig != null){
            return response(["error"=> "Activity name on This WBS must be UNIQUE"],Response::HTTP_OK);
        }
        DB::beginTransaction();
        try {
            $activity->name = $data['name'];
            $activity->description = $data['description'];         
            $activity->duration = $data['duration'];

            if(!$activity->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to update activity configuration ".$activity->name],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function destroyActivityStandard(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try {
            $activityStandard = ActivityStandard::find($id);
            if(count($activityStandard->activitiesProject)>0){
                return response(["error"=> "Failed to delete, this Activity already been used by a project"],Response::HTTP_OK);
            }
            
            if(!$activityStandard->delete()){
                return response(["error"=> "Failed to delete, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to delete Activity"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    //Methods
    function getParentsWbsStandard($wbs, $array_reverse, $iteration) {
        if ($wbs) {
            if($wbs->wbs){
                $array_reverse["WBS ".$wbs->number] = route('project_standard.createSubWbsStandard',[$wbs->wbs->id]);
                return self::getParentsWbsStandard($wbs->wbs,$array_reverse, $iteration);
            }else{
                $array_reverse["WBS ".$wbs->number] = route('project_standard.createSubWbsStandard',[$wbs->id]);
                return $array_reverse;
            }
        }
    }

    //API
    public function getProjectStandardAPI(){
        $project_standards = ProjectStandard::with('ship')->get()->jsonSerialize();
        return response($project_standards, Response::HTTP_OK);
    }

    public function getWbsStandardAPI($project_standard_id){
        $wbs_standards = WbsStandard::where('project_standard_id',$project_standard_id)->where('wbs_id',null)->get()->jsonSerialize();
        return response($wbs_standards, Response::HTTP_OK);
    }
    
    public function getSubWbsStandardAPI($wbs_id){
        $wbss = WbsStandard::where('wbs_id', $wbs_id)->get()->jsonSerialize();
        return response($wbss, Response::HTTP_OK);
    }

    public function getActivityStandardAPI($wbs_id){
        $activities = ActivityStandard::where('wbs_id', $wbs_id)->get()->jsonSerialize();
        return response($activities, Response::HTTP_OK);
    }

    public function getResourcesAPI($ids){
        $ids = json_decode($ids);

        return response(Resource::orderBy('code')->whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getResourceAPI($id){

        return response(Resource::where('id',$id)->first()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getMaterialAPI($id){
        $material = Material::where('id',$id)->with('uom','weightUom')->first();
        $densities = Configuration::get('density');
        foreach ($densities as $density) {
            if($density->id == $material->density_id){
                $material->density = $density;
            }
        }
        if($material->dimensions_value != null){
            $dimensions = json_decode($material->dimensions_value);
            foreach ($dimensions as $dimension) {
                $uom = Uom::find($dimension->uom_id);
                $dimension->uom = $uom;
            }
            $material->dimensions_value = json_encode($dimensions);
        }
        return response($material->jsonSerialize(), Response::HTTP_OK);
    }

    public function getMaterialPartsPSAPI($id){
        $material_standard = MaterialStandard::where('id',$id)->with('material.uom','material.weightUom','partDetails')->first();
        $densities = Configuration::get('density');
        foreach ($densities as $density) {
            if($density->id == $material_standard->material->density_id){
                $material_standard->material->density = $density;
            }
        }
        if($material_standard->material->dimensions_value != null){
            $dimensions = json_decode($material_standard->material->dimensions_value);
            foreach ($dimensions as $dimension) {
                $uom = Uom::find($dimension->uom_id);
                $dimension->uom = $uom;
            }
            $material_standard->material->dimensions_value_obj = $dimensions;
            $material_standard->material->dimensions_value = json_encode($dimensions);
        }
        foreach ($material_standard->partDetails as $part) {
            $part->dimensions_value_obj = json_decode($part->dimensions_value);
            foreach ($part->dimensions_value_obj as $dimension) {
                $dimension->uom = Uom::find($dimension->uom_id);
            }
        }
        return response($material_standard->jsonSerialize(), Response::HTTP_OK);
    }
}
