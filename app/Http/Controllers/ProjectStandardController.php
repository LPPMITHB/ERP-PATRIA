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
        $projects = ProjectStandard::all();

        return view('project_standard.selectProject', compact('projects'));
    }

    public function selectWBS(Request $request, $id)
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

        
        foreach($wbss as $wbs){
            $bom_code = "";
            $bom = MaterialStandard::where('wbs_standard_id',$wbs->id)->first();
            if($bom){
                $bom_code = " - this WBS Standard has Material Standard Click to Edit";
                if($wbs->wbs){
                    $data->push([
                        "id" => "WBS".$wbs->id, 
                        "parent" => "WBS".$wbs->wbs->id,
                        "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('project_standard.manageMaterial',$wbs->id)],
                    ]);
                }else{
                    $data->push([
                        "id" => "WBS".$wbs->id , 
                        "parent" => "PRO".$project->id,
                        "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('project_standard.manageMaterial',$wbs->id)],
                    ]);
                } 
            }else{
                if($wbs->wbs){
                    $data->push([
                        "id" => "WBS".$wbs->id , 
                        "parent" => "WBS".$wbs->wbs->id,
                        "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('project_standard.manageMaterial',$wbs->id)],
                    ]);
                }else{
                    $data->push([
                        "id" => "WBS".$wbs->id , 
                        "parent" => "PRO".$project->id,
                        "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('project_standard.manageMaterial',$wbs->id)],
                    ]);
                } 
            } 
        }
        return view('project_standard.selectWBS', compact('project','data','route'));
    }

    public function manageMaterial($wbs_id, Request $request)
    {
        $wbs = WbsStandard::find($wbs_id);
        $project = ProjectStandard::where('id',$wbs->project_standard_id)->with('ship')->first();
        $materials = Material::orderBy('code')->get()->jsonSerialize();
        $existing_data = null;

        $material_ids = [];
        $edit = false;
        if(count($wbs->materialStandards)>0){
            $edit = true;
            $existing_data = MaterialStandard::where('wbs_standard_id', $wbs->id)->with('material.uom')->get();
            foreach ($existing_data as $material) {
                array_push($material_ids,$material->material_id);
                $material->material_code = $material->material->code;
                $material->material_name = $material->material->description;
                $material->unit = $material->material->uom->unit;
            }
        }
        
        return view('project_standard.manageMaterial', compact('project','materials','wbs','edit','existing_data','material_ids'));
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
                $materialStandard->source = $material->source;
                $materialStandard->save();
            }
            DB::commit();
            return redirect()->route('project_standard.showMaterialStandard', ['id' => $datas->wbs_id])->with('success', 'Bill Of Material Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project_standard.selectProject')->with('error', $e->getMessage());
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
                $materialStandard->delete();
            }
            foreach($datas->materials as $material){
                if(isset($material->id)){
                    $materialStandard = MaterialStandard::find($material->id);
                    $materialStandard->material_id = $material->material_id;
                    $materialStandard->quantity = $material->quantity;
                    $materialStandard->source = $material->source;
                    $materialStandard->update();
                }else{
                    $materialStandard = new MaterialStandard;
                    $materialStandard->project_standard_id = $datas->project_id;
                    $materialStandard->wbs_standard_id = $datas->wbs_id;
                    $materialStandard->material_id = $material->material_id;
                    $materialStandard->quantity = $material->quantity;
                    $materialStandard->source = $material->source;
                    $materialStandard->save();
                }
            }
            DB::commit();
            if($datas->edit){
                return redirect()->route('project_standard.showMaterialStandard', ['id' => $datas->wbs_id])->with('success', 'Bill Of Material Updated');
            }else{
                return redirect()->route('project_standard.showMaterialStandard', ['id' => $datas->wbs_id])->with('success', 'Bill Of Material Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project_standard.selectProject')->with('error', $e->getMessage());
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
}
