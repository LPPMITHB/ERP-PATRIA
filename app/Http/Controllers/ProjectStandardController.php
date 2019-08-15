<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Ship;
use App\Models\ProjectStandard;
use App\Models\WbsStandard;
use App\Models\ActivityStandard;
use DB;
use Auth;

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

    //API
    public function getProjectStandardAPI(){
        $project_standards = ProjectStandard::with('ship')->get()->jsonSerialize();
        return response($project_standards, Response::HTTP_OK);
    }

    public function getWbsStandardAPI($project_standard_id){
        $wbs_standards = WbsStandard::where('project_standard_id',$project_standard_id)->get()->jsonSerialize();
        return response($wbs_standards, Response::HTTP_OK);
    }
}
