<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ProjectActivity;
use App\Http\Controllers\Controller;
use App\Models\WBS;
use App\Models\Project;
use App\Models\Activity;
use App\Models\ActivityDetail;
use App\Models\Material;
use App\Models\Service;
use App\Models\UOM;
use App\Models\WbsProfile;
use App\Models\WbsConfiguration;
use App\Models\ActivityProfile;
use App\Models\ActivityConfiguration;
use App\Models\User;
use DB;
use DateTime;
use Auth;

class ActivityController extends Controller
{

    public function create($id, Request $request)
    {
        $wbs = WBS::find($id);
        $project = $wbs->project;
        $menu = $project->business_unit_id == "1" ? "building" : "repair";
        return view('activity.create', compact('project', 'wbs','menu'));
    }
    
    public function createActivityRepair($id, Request $request)
    {
        $wbs = WBS::find($id);
        $activity_config = $wbs->wbsConfig->activities;

        $materials = Material::all();
        $services = Service::all();
        $uoms = UOM::all();
        $project = $wbs->project;
        $menu = "repair";

        return view('activity.createActivityRepair', compact('uoms','materials','services','project', 'wbs','menu','activity_config'));
    }

    public function createActivityProfile($id, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/activity" ? "building" : "repair";
        $wbs = WbsProfile::find($id);

        return view('activity.createActivityProfile', compact('wbs','menu'));
    }

    public function createActivityConfiguration($id, Request $request)
    {
        $wbs = WbsConfiguration::find($id);

        return view('activity.createActivityConfiguration', compact('wbs'));
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();
        $predecessorArray = [];
        foreach($data['allPredecessor'] as $predecessor){
            $temp = [];
            array_push($temp, $predecessor[0]);
            array_push($temp, $predecessor[1]);
            array_push($predecessorArray, $temp);
            
        }
        DB::beginTransaction();
        try {
            $activity = new Activity;
            $activity->code = self::generateActivityCode($data['wbs_id']);
            $activity->name = $data['name'];
            $activity->description = $data['description'];
            $activity->wbs_id = $data['wbs_id'];            
            $activity->planned_duration = $data['planned_duration'];

            if($data['planned_start_date'] != ""){
                $planStartDate = DateTime::createFromFormat('d-m-Y', $data['planned_start_date']);
                $activity->planned_start_date = $planStartDate->format('Y-m-d');
            }

            if($data['planned_end_date'] != ""){
                $planEndDate = DateTime::createFromFormat('d-m-Y', $data['planned_end_date']);
                $activity->planned_end_date = $planEndDate->format('Y-m-d');
            }

            if(count($predecessorArray) >0){
                $activity->predecessor = json_encode($predecessorArray);
            }

            if(isset($data['activity_configuration_id'])){
                $activity->activity_configuration_id = $data['activity_configuration_id'];

            }

            $activity->weight = $data['weight']; 
            $activity->user_id = Auth::user()->id;
            $activity->branch_id = Auth::user()->branch->id;

            $users = User::whereIn('role_id',[1])->get();
            // Notification::send($users, new ProjectActivity($activity));
            $activity->save();
            if($activity->wbs->project->business_unit_id == 2){
                $activityDetail = new ActivityDetail;
                $activityDetail->activity_id = $activity->id;
                if($data['material_id'] != null || $data['service_id'] != null){
                    if($data['material_id'] != null){
                        $activityDetail->material_id = $data['material_id'];
                        $activityDetail->quantity_material = $data['quantity_material'];
                        if($data['length_uom_id'] != ""){
                            $activityDetail->length_uom_id = $data['length_uom_id'];
                            $activityDetail->length = $data['lengths'];
                        }
                        
                        if($data['width_uom_id'] != ""){
                            $activityDetail->width_uom_id = $data['width_uom_id'];
                            $activityDetail->width = $data['width'];
                        }
    
                        if($data['height_uom_id'] != ""){
                            $activityDetail->height_uom_id = $data['height_uom_id'];
                            $activityDetail->height = $data['height'];
                        }
                    }
    
                    if($data['service_id'] != null){
                        $activityDetail->activity_id = $activity->id;
                        $activityDetail->service_id = $data['service_id'];
                        $activityDetail->quantity_service = $data['quantity_service'];
                    }
                }
                $activityDetail->save();
            }
            DB::commit();
            return response(["response"=>"Success to create new activity"],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeActivityProfile(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $activity = new ActivityProfile;
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
                return response(["response"=>"Success to create new activity profile"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeActivityConfiguration(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $activity = new ActivityConfiguration;
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

    public function update(Request $request, $id)
    {
        $data = $request->json()->all();
        
        DB::beginTransaction();
        try {
            $activity = Activity::find($id);
            $activity->name = $data['name'];
            $activity->description = $data['description'];         
            $activity->planned_duration = $data['planned_duration'];

            $planStartDate = DateTime::createFromFormat('d-m-Y', $data['planned_start_date']);
            $planEndDate = DateTime::createFromFormat('d-m-Y', $data['planned_end_date']);

            $activity->planned_start_date = $planStartDate->format('Y-m-d');
            $activity->planned_end_date = $planEndDate->format('Y-m-d');
            $activity->weight = $data['weight']; 
            if(count($data['allPredecessor']) > 0){
                $predecessorArray = [];
                foreach($data['allPredecessor'] as $predecessor){
                    $temp = [];
                    array_push($temp, $predecessor[0]);
                    array_push($temp, $predecessor[1]);
                    array_push($predecessorArray, $temp);
                    
                }
                $activity->predecessor = json_encode($predecessorArray);
            }else{
                $activity->predecessor = null;
            }
            
            if($activity->wbs->project->business_unit_id == 2){
                $activityDetail = $activity->activityDetail;
                if($data['material_id'] != null || $data['service_id'] != null){
                    if($data['material_id'] != null){
                        $activityDetail->material_id = $data['material_id'];
                        $activityDetail->quantity_material = $data['quantity_material'];
                        if($data['length_uom_id'] != ""){
                            $activityDetail->length_uom_id = $data['length_uom_id'];
                            $activityDetail->length = $data['lengths'];
                        }
                        
                        if($data['width_uom_id'] != ""){
                            $activityDetail->width_uom_id = $data['width_uom_id'];
                            $activityDetail->width = $data['width'];
                        }
    
                        if($data['height_uom_id'] != ""){
                            $activityDetail->height_uom_id = $data['height_uom_id'];
                            $activityDetail->height = $data['height'];
                        }
                    }
    
                    if($data['service_id'] != null){
                        $activityDetail->activity_id = $activity->id;
                        $activityDetail->service_id = $data['service_id'];
                        $activityDetail->quantity_service = $data['quantity_service'];
                    }
                }
                $activityDetail->update();
            }
            if(!$activity->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to update activity ".$activity->code],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function updateActivityProfile(Request $request, $id)
    {
        $data = $request->json()->all();
        
        DB::beginTransaction();
        try {
            $activity = ActivityProfile::find($id);
            $activity->name = $data['name'];
            $activity->description = $data['description'];         
            $activity->duration = $data['duration'];

            if(!$activity->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to update activity profile ".$activity->name],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function updateActivityConfiguration(Request $request, $id)
    {
        $data = $request->json()->all();
        
        DB::beginTransaction();
        try {
            $activity = ActivityConfiguration::find($id);
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
    
    public function index($id, Request $request)
    {
        $wbs = WBS::find($id);
        $project = $wbs->project;
        $menu = $project->business_unit_id == "1" ? "building" : "repair";

        return view('activity.index', compact('project','wbs','menu'));
    }

    public function show($id,Request $request)
    {
        $activity = Activity::find($id);
        $project = $activity->wbs->project;
        $menu = $project->business_unit_id == "1" ? "building" : "repair";
        $activityPredecessor = Collection::make();
        
        if($activity->predecessor != null){
            $predecessor = json_decode($activity->predecessor);
            foreach($predecessor as $activity_id){
                $refActivity = Activity::find($activity_id);
                $activityPredecessor->push($refActivity);
            }
        }
        return view('activity.show', compact('activity','activityPredecessor','menu'));
    }    
    
    public function manageNetwork($id,Request $request)
    {
        $project = Project::find($id);
        $menu = $project->business_unit_id == "1" ? "building" : "repair";
        // $wbss = $project->wbss->pluck('id')->toArray();
        // $activities = Activity::whereIn('wbs_id',$wbss)->get();
        // $predecessors =$activities->pluck('predecessor','id')->toArray();
        // $predecessor_array = [];
        // $temp_starting_point = [];
        // $starting_point = [];

        // foreach($predecessors as $act_id => $predecessor){
        //     if($predecessor != null){
        //         $temp = json_decode($predecessor);
        //         array_push($predecessor_array, $temp[0][0]);
        //     }else{
        //         array_push($temp_starting_point, $act_id);
        //     }
        // }

        // foreach($temp_starting_point as $key => $act_id){
        //     array_search($act_id,$predecessor_array);
        //     if(array_search($act_id,$predecessor_array) != false){
        //         array_push($starting_point, $act_id);
        //     }
        // }
        
        return view('activity.indexNetwork', compact('project','menu'));
    }

    public function updatePredecessor(Request $request, $id)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $activity = Activity::find($id);
            if(count($data['allPredecessor']) > 0){
                $predecessorArray = [];
                foreach($data['allPredecessor'] as $predecessor){
                    $temp = [];
                    array_push($temp, $predecessor[0]);
                    array_push($temp, $predecessor[1]);
                    array_push($predecessorArray, $temp);
                    
                }
                $activity->predecessor = json_encode($predecessorArray);
            }else{
                $activity->predecessor = null;
            }

            if(!$activity->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update Predecessor for Activity ".$activity->code],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function indexConfirm(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/activity" ? "building" : "repair";
        if($menu == "building"){
            $projects = Project::where('business_unit_id',1)->get();
        }else{
            $projects = Project::where('business_unit_id',2)->get();
        }

        return view('activity.indexConfirm', compact('projects','menu'));
    }

    public function confirmActivity($id, Request $request)
    {
        $wbs = WBS::find($id);
        $project = $wbs->project;
        $menu = $project->business_unit_id == "1" ? "building" : "repair";
        return view('activity.confirmActivity', compact('project','wbs','menu'));
    }

    public function updateActualActivity(Request $request, $id)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $activity = Activity::find($id); 
            if($data['actual_end_date'] == ""){
                $activity->status = 1;
                $activity->progress = $data['current_progress'];
                $activity->actual_end_date = null;
                $activity->actual_duration = null;
            }else{
                $activity->status = 0;
                $activity->progress = 100;
                $actualEndDate = DateTime::createFromFormat('d-m-Y', $data['actual_end_date']);
                $activity->actual_end_date = $actualEndDate->format('Y-m-d');
                $activity->actual_duration = $data['actual_duration'];
            }
            $actualStartDate = DateTime::createFromFormat('d-m-Y', $data['actual_start_date']);
            $activity->actual_start_date = $actualStartDate->format('Y-m-d');
            $activity->save();

            $project = $activity->wbs->project;
            $wbss = $project->wbss->where('wbs_id',null);
            $earliest_date = null;
            foreach($wbss as $wbs){
                $temp = self::getEarliestActivity($wbs,$earliest_date);
                if($earliest_date == null){
                    $earliest_date = $temp;
                }else{
                    if($earliest_date > $temp){
                        $earliest_date = $temp;
                    }
                }
            }
            $project->actual_start_date = $earliest_date;

            $wbs = $activity->wbs;
            self::changeWbsProgress($wbs);

            $project = $wbs->project;
            $oldestWorks= $project->wbss->where('wbs_id', null);
            $progress = 0;
            foreach($oldestWorks as $wbs){
                $progress += $wbs->progress* ($wbs->weight /100); 
            }            
            $project->progress = $progress;
            $project->save();
            
            DB::commit();
            return response(["response"=>"Success to confirm activity ".$activity->code],Response::HTTP_OK);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function destroyActivityProfile(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try {
            $activityProfile = ActivityProfile::find($id);

            if(!$activityProfile->delete()){
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
    
    public function destroyActivityConfiguration(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try {
            $activityConfiguration = ActivityConfiguration::find($id);

            if(!$activityConfiguration->delete()){
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

    public function destroyActivity(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        $error = [];
        try {
            $activity = Activity::find($id);
            if($activity->progress > 0){
                array_push($error, ["Failed to delete, this activity already have ".$activity->progress." % progress"]);                
                return response(["error"=> $error],Response::HTTP_OK);
            }

            $activity_ref = Activity::whereNotIn('id',[$activity->id])->get();
            foreach($activity_ref as $act){
                if($act->predecessor != null){
                    $predecessor = json_decode($act->predecessor);
                    foreach($predecessor as $act_id){
                        if($activity->id == $act_id[0]){
                            array_push($error, ["Failed to delete, this activity is predecessor to another activity"]);                
                            return response(["error"=> $error],Response::HTTP_OK);
                        }
                    }
                }
            }
            $activity->activityDetail->delete();
            $activity->delete();
            DB::commit();
            return response(["response"=>"Success to delete Activity"],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            array_push($error, [$e->getMessage()]);                
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }
    
    //Method
    public function generateActivityCode($id){
        $code = 'ACT';
        $project = WBS::find($id)->project;
        $projectSequence = $project->project_sequence;
        $year = $project->created_at->year % 100;
        $businessUnit = $project->business_unit_id;

        $modelActivity = Activity::orderBy('code', 'desc')->whereIn('wbs_id', $project->wbss->pluck('id')->toArray())->first();
        
        $number = 1;
		if(isset($modelActivity)){
            $number += intval(substr($modelActivity->code, -4));
		}

        $activity_code = $code.sprintf('%02d', $year).sprintf('%01d', $businessUnit).sprintf('%02d', $projectSequence).sprintf('%04d', $number);
		return $activity_code;
    }

    function getEarliestActivity($wbs, $earliest_date){
        if($wbs){
            if(count($wbs->wbss)>0){
                foreach($wbs->wbss as $wbs_child){
                    if(count($wbs_child->activities)>0){
                        $activityRef = Activity::where('wbs_id',$wbs_child->id)->whereRaw('actual_start_date is not null')->orderBy('actual_start_date','asc')->first();
                        if($activityRef != null){
                            $earliest_date_ref = $activityRef->actual_start_date;
                            if($earliest_date != null){
                                if($earliest_date > $earliest_date_ref){
                                    $earliest_date = $earliest_date_ref;
                                }
                            }else{
                                $earliest_date = $earliest_date_ref;
                            }
                        }else{
                            $earliest_date = $earliest_date;
                        }
                    }
                    return self::getEarliestActivity($wbs_child,$earliest_date);
                }
            }else{
                if(count($wbs->activities)>0){
                    $activityRef = Activity::where('wbs_id',$wbs->id)->whereRaw('actual_start_date is not null')->orderBy('actual_start_date','asc')->first();
                    if($activityRef != null){
                        $earliest_date_ref = $activityRef->actual_start_date;
                        if($earliest_date != null){
                            if($earliest_date > $earliest_date_ref){
                                $earliest_date = $earliest_date_ref;
                            }
                        }else{
                            $earliest_date = $earliest_date_ref;
                        }
                    }else{
                        $earliest_date = $earliest_date;
                    }
                }
                return $earliest_date;
            }
        }
    }

    function changeWbsProgress($wbs){
        if($wbs){
            if($wbs->wbs){
                $progress = 0;
                if($wbs->activities){
                    foreach($wbs->activities as $activity){
                        $progress += $activity->progress * ($activity->weight/100);
                    }
                }

                if($wbs->wbss){
                    foreach($wbs->wbss as $child_wbs){
                        $progress += $child_wbs->progress * ($child_wbs->weight/100);
                    }
                }
                $wbs->progress = ($progress /$wbs->weight) *100;
                $wbs->save();
                self::changeWbsProgress($wbs->wbs);
            }else{
                $progress = 0;
                if($wbs->activities){
                    foreach($wbs->activities as $activity){
                        $progress += $activity->progress * ($activity->weight/100);
                    }
                }

                if($wbs->wbss){
                    foreach($wbs->wbss as $child_wbs){
                        $progress += $child_wbs->progress * ($child_wbs->weight/100);
                    }
                }
                $wbs->progress = ($progress /$wbs->weight) *100;
                $wbs->save();
            }
        }
    }

    //API
    public function getActivitiesAPI($wbs_id){
        $activities = Activity::orderBy('planned_start_date', 'asc')->where('wbs_id', $wbs_id)->with('activityDetail')->get()->jsonSerialize();
        return response($activities, Response::HTTP_OK);
    }

    public function getActivitiesProfileAPI($wbs_id){
        $activities = ActivityProfile::where('wbs_id', $wbs_id)->get()->jsonSerialize();
        return response($activities, Response::HTTP_OK);
    }

    public function getActivitiesConfigurationAPI($wbs_id){
        $activities = ActivityConfiguration::where('wbs_id', $wbs_id)->get()->jsonSerialize();
        return response($activities, Response::HTTP_OK);
    }

    public function getActivitiesNetworkAPI($project_id){
        $project = Project::find($project_id);
        $activities = Activity::whereIn('wbs_id',$project->wbss->pluck('id')->toArray())->orderBy('planned_start_date','asc')->get();

        $allActivities = Collection::make();
        foreach ($project->wbss as $wbsData) {
            foreach($wbsData->activities as $activity){
                $allActivities->push($activity);
            }
        }

        return response($activities->jsonSerialize(), Response::HTTP_OK);
    }

    public function getAllActivitiesAPI($project_id){
        $project = Project::find($project_id);

        $allActivities = Collection::make();
        foreach ($project->wbss as $wbsData) {
            foreach($wbsData->activities as $activity){
                $activity->push('wbs_number', $activity->wbs->number);
                $allActivities->push($activity);
            }
        }
        return response($allActivities->jsonSerialize(), Response::HTTP_OK);
    }

    public function getAllActivitiesEditAPI($project_id, $activity_id){
        $project = Project::find($project_id);

        $allActivities = Collection::make();
        foreach ($project->wbss as $wbsData) {
            foreach($wbsData->activities as $activity){
                if($activity->id != $activity_id){
                    $activity->push('wbs_number', $activity->wbs->number);
                    $allActivities->push($activity);
                }
            }
        }
        return response($allActivities->jsonSerialize(), Response::HTTP_OK);
    }    

    public function getPredecessorAPI($id){
        $activity = Activity::find($id);
        $predecessor = json_decode($activity->predecessor);
        $predecessorActivities = Activity::orderBy('planned_start_date', 'asc')->whereIn('id', $predecessor)->with('wbs')->get()->jsonSerialize();
        return response($predecessorActivities, Response::HTTP_OK);
    }

    public function getProjectAPI($id){
        $project = Project::find($id)->jsonSerialize();
        return response($project, Response::HTTP_OK);
    }

    public function getLatestPredecessorAPI($id)
    {
        $predecessors = json_decode($id);
        $arrayPredecessor = [];
        foreach($predecessors as $predecessor){
            array_push($arrayPredecessor, $predecessor[0]);
        }
        $latestActivity = Activity::orderBy('planned_end_date', 'desc')->whereIn('id', $arrayPredecessor)->first()->jsonSerialize();

        return response($latestActivity, Response::HTTP_OK);

    }
}
