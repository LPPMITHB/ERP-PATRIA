<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Models\WBS;
use App\Models\Project;
use App\Models\Activity;
use DB;
use DateTime;
use Auth;

class ActivityController extends Controller
{
    public function listWBS($id, $menu){
        $project = Project::find($id);
        $wbss = $project->wbss;
        $dataWbs = Collection::make();

        $totalWeightProject = $project->wbss->where('wbs_id',null)->sum('weight');
        $dataWbs->push([
            "id" => $project->number, 
            "parent" => "#",
            "text" => $project->name. " | Weight : (".$totalWeightProject."% / 100%)",
            "icon" => "fa fa-ship"
        ]);
        
        if($menu == "addAct"){
            $route = "/activity/create/";
            $menuTitle = "Add Activities » Select WBS";
        }elseif($menu == "mngNet"){
            $route = "/activity/manageNetwork/";
            $menuTitle = "Manage Network » Select WBS";
        }elseif($menu == "viewAct"){
            $route = "/activity/index/";
            $menuTitle = "View Activities » Select WBS";
        }elseif($menu == "confirmAct"){
            $route = "/activity/confirmActivity/";
            $menuTitle = "Confirm Activity » Select WBS";
        }elseif($menu == "viewWbs"){
            $route = "/wbs/show/";
            $menuTitle = "View WBS » Select WBS";
        }else{
            $route = "";
            $menuTitle = "Select WBS";
        }
    
        foreach($wbss as $wbs){
            if($wbs->wbs){
                if(count($wbs->activities)>0){
                    $totalWeight = $wbs->wbss->sum('weight') + $wbs->activities->sum('weight');
                    $dataWbs->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->name. " | Weight : (".$totalWeight."% / ".$wbs->weight."%)",
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => $route.$wbs->id],
                    ]);
                }else{
                    $dataWbs->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->name. " | Weight : ".$wbs->weight."%",
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => $route.$wbs->id],
                    ]);
                }
            }else{
                $totalWeight = $wbs->wbss->sum('weight') + $wbs->activities->sum('weight');

                $dataWbs->push([
                    "id" => $wbs->code , 
                    "parent" => $project->number,
                    "text" => $wbs->name. " | Weight : (".$totalWeight."% / ".$wbs->weight."%)",
                    "icon" => "fa fa-suitcase",
                    "a_attr" =>  ["href" => $route.$wbs->id],
                ]);
            } 
        } 
        
        return view('activity.listWBS', compact('dataWbs','project','menu','menuTitle'));
    }

    public function create($id)
    {
        $wbs = WBS::find($id);
        $project = $wbs->project;

        return view('activity.create', compact('project', 'wbs'));
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();
        $stringPredecessor = '['.implode(',', $data['predecessor']).']';

        DB::beginTransaction();
        try {
            $activity = new Activity;
            $activity->code = self::generateActivityCode($data['wbs_id']);
            $activity->name = $data['name'];
            $activity->description = $data['description'];
            $activity->wbs_id = $data['wbs_id'];            
            $activity->planned_duration = $data['planned_duration'];

            if($data['planned_start_date'] != ""){
                $planStartDate = DateTime::createFromFormat('m/j/Y', $data['planned_start_date']);
                $activity->planned_start_date = $planStartDate->format('Y-m-d');
            }

            if($data['planned_end_date'] != ""){
                $planEndDate = DateTime::createFromFormat('m/j/Y', $data['planned_end_date']);
                $activity->planned_end_date = $planEndDate->format('Y-m-d');
            }

            if(count($data['predecessor']) >0){
                $activity->predecessor = $stringPredecessor;
                $refActivity = Activity::whereIn('id', json_decode($activity->predecessor))->orderBy('planned_end_date', 'desc')->first();
            }
            $activity->weight = $data['weight']; 
            $activity->user_id = Auth::user()->id;
            $activity->branch_id = Auth::user()->branch->id;

            if(!$activity->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to create new activity"],Response::HTTP_OK);
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

            $planStartDate = DateTime::createFromFormat('m/j/Y', $data['planned_start_date']);
            $planEndDate = DateTime::createFromFormat('m/j/Y', $data['planned_end_date']);

            $activity->planned_start_date = $planStartDate->format('Y-m-d');
            $activity->planned_end_date = $planEndDate->format('Y-m-d');
            $activity->weight = $data['weight']; 
            if($data['predecessor'] != null){
                $stringPredecessor = '['.implode(',', $data['predecessor']).']';
                $activity->predecessor = $stringPredecessor;
            }else{
                $activity->predecessor = null;
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
    
    public function index($id)
    {
        $wbs = WBS::find($id);
        $project = $wbs->project;

        return view('activity.index', compact('project','wbs'));
    }

    public function show($id)
    {
        $activity = Activity::find($id);
        $activityPredecessor = Collection::make();
        
        if($activity->predecessor != null){
            $predecessor = json_decode($activity->predecessor);
            foreach($predecessor as $activity_id){
                $refActivity = Activity::find($activity_id);
                $activityPredecessor->push($refActivity);
            }
        }
        return view('activity.show', compact('activity','activityPredecessor'));
    }    
    
    public function manageNetwork($id)
    {
        $wbs = WBS::find($id);
        $project = $wbs->project;

        return view('activity.indexNetwork', compact('project','wbs'));
    }

    public function updatePredecessor(Request $request, $id)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $activity = Activity::find($id);
            if($data['predecessor'] != "[]"){
                $activity->predecessor = $data['predecessor'];
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

    public function indexConfirm()
    {
        $projects = Project::all();

        return view('activity.indexConfirm', compact('projects'));
    }
    
    public function confirmActivity($id)
    {
        $wbs = WBS::find($id);
        $project = $wbs->project;

        return view('activity.confirmActivity', compact('project','wbs'));
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
                $actualEndDate = DateTime::createFromFormat('m/j/Y', $data['actual_end_date']);
                $activity->actual_end_date = $actualEndDate->format('Y-m-d');
                $activity->actual_duration = $data['actual_duration'];
            }
            $actualStartDate = DateTime::createFromFormat('m/j/Y', $data['actual_start_date']);
            $activity->actual_start_date = $actualStartDate->format('Y-m-d');
            $activity->save();

            $wbs = $activity->wbs;

            self::changeWorkProgress($wbs);

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

    function changeWorkProgress($wbs){
        if($wbs){
            if($wbs->wbs){
                $progress = 0;
                if($wbs->activities){
                    foreach($wbs->activities as $activity){
                        if($activity->status == 0){
                            $progress += $activity->progress * ($activity->weight/100);
                        }
                    }
                }

                if($wbs->wbss){
                    foreach($wbs->wbss as $child_wbs){
                        $progress += $child_wbs->progress * ($child_wbs->weight/100);
                    }
                }
                $wbs->progress = ($progress /$wbs->weight) *100;
                $wbs->save();
                self::changeWorkProgress($wbs->wbs);
            }else{
                $progress = 0;
                if($wbs->activities){
                    foreach($wbs->activities as $activity){
                        if($activity->status == 0){
                            $progress += $activity->progress * ($activity->weight/100);
                        }
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
        $activities = Activity::orderBy('planned_start_date', 'asc')->where('wbs_id', $wbs_id)->get()->jsonSerialize();
        return response($activities, Response::HTTP_OK);
    }

    public function getActivitiesNetworkAPI($wbs_id){
        $activities = Activity::orderBy('planned_start_date', 'asc')->where('wbs_id', $wbs_id)->get();
        $project = WBS::find($wbs_id)->project;

        $allActivities = Collection::make();
        foreach ($project->wbss as $wbsData) {
            foreach($wbsData->activities as $activity){
                $allActivities->push($activity);
            }
        }

        foreach($activities as $activity){
            $predecessorObj = json_decode($activity->predecessor);
            $activity['predecessorText'] = "-";
            if($predecessorObj != null){
                foreach($predecessorObj as $predecessorTo){
                    foreach($allActivities as $refAct){
                        if($predecessorTo==$refAct->id){
                            if($activity->predecessorText == "-"){
                                $activity->predecessorText = $refAct->code;
                            }else{
                                $activity->predecessorText =  $activity->predecessorText.", ".$refAct->code;
                            }
                        }
                    }
                }
            }
        }
        return response($activities->jsonSerialize(), Response::HTTP_OK);
    }

    public function getAllActivitiesAPI($project_id){
        $project = Project::find($project_id);

        $allActivities = Collection::make();
        foreach ($project->wbss as $wbsData) {
            foreach($wbsData->activities as $activity){
                $activity->push('wbs_name', $activity->wbs->name);
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
                    $activity->push('wbs_name', $activity->wbs->name);
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
        $predecessor = json_decode($id);
        $latestActivity = Activity::orderBy('planned_end_date', 'desc')->whereIn('id', $predecessor)->first()->jsonSerialize();

        return response($latestActivity, Response::HTTP_OK);

    }
}
