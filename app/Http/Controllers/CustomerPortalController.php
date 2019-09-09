<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Project;
use App\Models\WBS;
use App\Models\Activity;
use App\Models\Customer;
use App\Models\Post;
use App\Models\PostComment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Auth;
use DB;

class CustomerPortalController extends Controller
{
    public function selectProject(){
        if(Auth::user()->role_id != 3){
            $modelProject = Project::whereIn('business_unit_id', json_decode(Auth::user()->business_unit_id))->get();
        }else{
            $customer_id = Customer::where('user_id', Auth::user()->id)->first()->id;
            $modelProject = Project::where('status',1)->where('customer_id',$customer_id)->get();
        }

        return view('customer_portal.selectProject', compact('modelProject'));
    }

    public function selectProjectPost(){
        $customer_id = Customer::where('user_id', Auth::user()->id)->first()->id;
        $modelProject = Project::where('status',1)->where('customer_id',$customer_id)->get();

        foreach ($modelProject as $project) {
            $posts = $project->posts;
            foreach ($posts as $post) {
                $comments = $post->comments->where('status',1)->where('user_id','!=',Auth::user()->id);
                $project->new_comment = count($comments) > 0 ? true : false;
                $project->new_comment_qty = count($comments);
            }
        }

        return view('customer_portal.selectProjectPost', compact('modelProject'));
    }

    public function selectProjectReply(){
        $modelProject = Project::whereIn('business_unit_id', json_decode(Auth::user()->business_unit_id))->get();

        foreach ($modelProject as $project) {
            $posts = $project->posts->where('status',1);
            $project->new_post = count($posts) > 0 ? true : false;
            $project->new_post_qty = count($posts);
            $posts_all = $project->posts;

            foreach ($posts_all as $post) {
                $comments = $post->comments->where('status',1)->where('user_id','!=',Auth::user()->id);
                $project->new_comment = count($comments) > 0 ? true : false;
                $project->new_comment_qty = count($comments);
            }
        }

        return view('customer_portal.selectProjectReply', compact('modelProject'));
    }

    public function selectPost($id){
        $posts = Post::where('project_id',$id)->get();
        foreach ($posts as $post) {
            $comments = $post->comments->where('status',1)->where('user_id','!=',Auth::user()->id);
            $post->new_comment = count($comments) > 0 ? true : false;
            $post->new_comment_qty = count($comments);
        }
        $project = Project::find($id);

        return view('customer_portal.selectPost',compact('posts','project'));
    }

    public function createPost($id){
        $posts = Post::where('project_id',$id)->get();
        foreach ($posts as $post) {
            $comments = $post->comments->where('status',1)->where('user_id','!=',Auth::user()->id);
            $post->new_comment = count($comments) > 0 ? true : false;
            $post->new_comment_qty = count($comments);
        }
        $project = Project::find($id);

        return view('customer_portal.createPost',compact('posts','project'));
    }

    public function showPost($id){
        $post = Post::find($id);
        $post->status = 0;
        $post->update();
        $user_id = Auth::user()->id;
        $comments = $post->comments->where('status',1)->where('user_id','!=',Auth::user()->id);
        foreach ($comments as $comment) {
            $comment->status = 0;
            $comment->update();
        }

        return view('customer_portal.showPost',compact('post','user_id'));
    }

    public function showProject(Request $request, $id)
    {
        $project = Project::find($id);
        $menu = $project->business_unit_id == "1" ? "building" : "repair";
        $wbss = $project->wbss;
        $today = date("Y-m-d");
        $is_pami = false;
        $business_ids = Auth::user()->business_unit_id;
        if (in_array("2", json_decode($business_ids))) {
            $is_pami = true;
        }

        //Progress
        $dataPlannedProgress = Collection::make();
        $dataPlannedProgress->push([
            "t" => $project->planned_start_date,
            "y" => "0",
        ]);
        $dataActualProgress = Collection::make();
        if($project->actual_start_date != null){
            $dataActualProgress->push([
                "t" => $project->actual_start_date,
                "y" => "0",
            ]);
        }
        self::getDataChart($project, $dataActualProgress, $dataPlannedProgress, $menu);
        $ganttData = Collection::make();
        $links = Collection::make();
        $outstanding_item = Collection::make();

        $progressStatus = Collection::make();
        self::getDataStatusProgress($project,$progressStatus);

        $outstanding_item->push([
            "id" => $project->number ,
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);

        self::getOutstandingItem($wbss,$outstanding_item, $project,$today);
        self::getDataForGantt($project, $ganttData, $links, $today);

        $wbss = $project->wbss->pluck('id')->toArray();
        $activities = Activity::whereIn('wbs_id',$wbss)->get();
        $predecessors =$activities->pluck('predecessor','id')->toArray();
        $predecessor_collection = Collection::make();
        $predecessor_array = [];
        $temp_starting_point = [];
        $starting_point = [];
        foreach($predecessors as $act_id => $predecessor){
            if($predecessor != null){
                $temp = json_decode($predecessor);
                foreach($temp as $act){
                    $predecessor_collection->push([
                        'act_id' => $act_id,
                        'predecessor' => $act[0],
                    ]);
                    array_push($predecessor_array, $act[0]);
                }
            }else{
                array_push($temp_starting_point, $act_id);
            }
        }

        foreach($temp_starting_point as $key => $act_id){
            if(array_search($act_id,$predecessor_array) > -1){
                array_push($starting_point, $act_id);
            }
        }

        $cpm_model = Collection::make();
        foreach($starting_point as $act_id){
            $act_ref = Activity::find($act_id);
            $cpm_collection = Collection::make();
            $level = 0;
            $cpm_collection->push([
                'level'=>$level,
                'act_id'=>$act_id,
                'duration'=> $act_ref->planned_duration,
                'parent'=> null,
            ]);
            $cpm_model->put($act_id,$cpm_collection);
            self::makeCpm($act_id,$act_id, $cpm_model, $predecessor_collection, $level);
        }

        $separated_model = [];
        foreach ($cpm_model as $key => $data) {
            $dataPerLvl = $data->groupBy('level');
            $separated_model[$key] = [];
            foreach ($dataPerLvl as $perLvl) {

                if($perLvl[0]['parent'] == null){
                    $parent = $perLvl[0]['parent'];
                    $separated_model[$key][$perLvl[0]['act_id']] = [$perLvl[0]];
                }else{
                    $temp_parent_coll = $separated_model[$key];
                    foreach ($perLvl as $dataPerLvl) {
                        if(isset($temp_parent_coll[$dataPerLvl['parent']])){
                            $temp_array_data = $temp_parent_coll;
                            array_push($temp_array_data[$dataPerLvl['parent']],$dataPerLvl);
                            $separated_model[$key][$dataPerLvl['act_id']] = $temp_array_data[$dataPerLvl['parent']];
                        }
                    }
                }
            }
        }

        $longest_duration = 0;
        $longest_model = [];
        foreach ($separated_model as $model) {
            foreach ($model as $sub_model) {
                $temp_duration = 0;
                foreach ($sub_model as $singular) {
                    $temp_duration += $singular['duration'];
                }
                if($longest_duration == $temp_duration){
                    array_push($longest_model, $sub_model);
                } else if($longest_duration < $temp_duration){
                    $longest_duration = $temp_duration;
                    $longest_model = [$sub_model];
                }
            }
        }
        $cpm_act_code = [];
        foreach ($longest_model as $model) {
            foreach ($model as $singular) {
                $activity_code = Activity::find($singular['act_id'])->code;
                array_push($cpm_act_code,$activity_code);
            }
        }

        $cpm_act_code = array_unique($cpm_act_code);
        foreach ($ganttData as $key => $data) {
            if(array_search($data["id"], $cpm_act_code) > -1){
                $data['is_cpm'] = true;
                $data['text'] = $data['text']." CPM!";
                $ganttData[$key] = $data;
            }
        }

        $ganttData->jsonSerialize();
        $links->jsonSerialize();
        $dataActualProgress->jsonSerialize();
        $dataPlannedProgress->jsonSerialize();

        // ngitung expected end date
        $modelWBS = WBS::where('project_id',$project->id)->get();
        $WbsAll = WBS::where('project_id',$project->id)->get();
        if(count($modelWBS)> 0){

            foreach($modelWBS as $key => $wbs){
                foreach($WbsAll as $dataWbs){
                    if($dataWbs->wbs_id == $wbs->id){
                        $modelWBS->forget($key);
                    }
                }
            }
            $dateGlobal = date("Y-m-d");
            $date = date_create($dateGlobal);
            $late_days = 0;
            foreach($modelWBS as $wbs){
                if($wbs->progress >= 100){
                    $planned_end_date = date_create($wbs->planned_end_date);
                    $actual_end_date = date_create($wbs->actual_end_date);
                    $diff=date_diff($actual_end_date,$planned_end_date);
                    if($diff->invert == 0){
                        $late_days += $diff->d * -1;
                    }else{
                        $late_days += $diff->d;
                    }
                }else{
                    if($wbs->planned_end_date < $dateGlobal){
                        $planned_end_date = date_create($wbs->planned_end_date);
                        $diff=date_diff($date,$planned_end_date);
                        $late_days += $diff->d;
                    }
                }
            }
            $latestDate = WBS::orderBy('planned_end_date','desc')->where('project_id',$project->id)->first()->planned_end_date;
            $expectedDate = date($latestDate);
            $expectedDate = strtotime($expectedDate);
            $expectedDate = date("Y-m-d",strtotime("$late_days day", $expectedDate));

            $project_end_date = date_create($project->planned_end_date);
            $expected_end_date = date_create($expectedDate);
            $diff=date_diff($expected_end_date,$project_end_date);

            if($expectedDate == $project->planned_end_date){
                $expectedDate = date("d-m-Y", strtotime($expectedDate));
                $expectedStatus = 0;
                $str_expected_date = "$expectedDate, On Time";
            }elseif($expectedDate < $project->planned_end_date){
                $expectedDate = date("d-m-Y", strtotime($expectedDate));
                $expectedStatus = 1;
                $str_expected_date = "$expectedDate, $diff->d day(s) early than project's planned end date";
            }elseif($expectedDate > $project->planned_end_date){
                $expectedDate = date("d-m-Y", strtotime($expectedDate));
                $expectedStatus = 2;
                $str_expected_date = "$expectedDate, $diff->d day(s) late than project's planned end date";
            }
        }else{
            $str_expected_date = null;
            $expectedStatus = null;
        }

        $project_done = $project->progress == 100 ? true:false;
        return view('customer_portal.showProject', compact('activities','wbss','project','today','ganttData','links','is_pami',
        'outstanding_item','menu','project_done',
        'dataActualProgress','dataPlannedProgress', 'progressStatus','str_expected_date','expectedStatus'));
    }

    public function storePost(Request $request){
        DB::beginTransaction();
        try {
            $post = new Post;
            $post->project_id = $request->project_id;
            $post->subject = $request->subject;
            $post->body = $request->body;
            $post->user_id = Auth::user()->id;
            $post->status = 1;
            $post->save();

            $fileNameToStoreArr = [];
            if($request->file('files') != null){
                foreach ($request->file('files') as $file) {
                    // Get filename with the extension
                    $fileNameWithExt = $file->getClientOriginalName();
                    // Get just file name
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    // Get just ext
                    $extension = $file->getClientOriginalExtension();
                    // File name to store
                    $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                    // Upload document
                    $path = $file->storeAs('documents/posts/'.$post->id,$fileNameToStore);
                    array_push($fileNameToStoreArr, $fileNameToStore);
                }
                $post->file_name = json_encode($fileNameToStoreArr);
                $post->save();
            }

            if(!$post->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to add new Post"],Response::HTTP_OK);
            }
        }catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeComment(Request $request){
        DB::beginTransaction();
        try {
            $comment = new PostComment;
            $comment->post_id = $request->post_id;
            $comment->text = $request->text;
            $comment->user_id = Auth::user()->id;
            $comment->status = 1;
            $comment->save();

            $fileNameToStoreArr = [];
            if($request->file('files') != null){
                foreach ($request->file('files') as $file) {
                    // Get filename with the extension
                    $fileNameWithExt = $file->getClientOriginalName();
                    // Get just file name
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    // Get just ext
                    $extension = $file->getClientOriginalExtension();
                    // File name to store
                    $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                    // Upload document
                    $path = $file->storeAs('documents/comments/'.$comment->id,$fileNameToStore);
                    array_push($fileNameToStoreArr, $fileNameToStore);
                }
                $comment->file_name = json_encode($fileNameToStoreArr);
                $comment->save();
            }

            if(!$comment->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Comment Added"],Response::HTTP_OK);
            }
        }catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    //Method
    public function getDataChart($project, $dataActualProgress,$dataPlannedProgress, $menu)
    {
        $actualProgress = 0;
        $plannedProgress = 0;
        $wbss = WBS::where('project_id', $project->id)->pluck('id')->toArray();
        $activities = Activity::whereIn('wbs_id',$wbss)->get();
        $actualActivities =$activities->filter(function ($data) {
            return $data->progress > 0 || $data->actual_end_date !== null;
        });
        $actualActivities = $actualActivities->groupBy('actual_end_date');
        // where('progress','>',0)->orWhere('actual_end_date', "!=", "")->groupBy('actual_end_date');
        $plannnedActivities = $activities->groupBy('planned_end_date');
        $actualSorted = $actualActivities;
        foreach($actualSorted as $date =>$group){
            if($date == null){
                $actualSorted->put(date('Y-m-d'), $group);
                $actualSorted->forget($date);
            }
        }
        $actualSorted = $actualActivities->all();
        $plannedSorted = $plannnedActivities->all();
        ksort($actualSorted);
        ksort($plannedSorted);
        foreach($actualSorted as $date => $group){
            foreach($group as $activity){
                $actualProgress += $activity->progress * ($activity->weight/100);
            }
            if($date != null){
                $dataActualProgress->push([
                    "t" => $date,
                    "y" => $actualProgress."",
                ]);
                $dataEvm->push([
                    "t" => $date,
                    "y" => number_format(($actualProgress/100) * $plannedCost,2),
                ]);
            }else{
                $project =$activity->wbs->project->actual_start_date;
                if($project != null){
                    if(date('Y-m-d')>$activity->wbs->project->actual_start_date){
                        $dataActualProgress->push([
                            "t" => date('Y-m-d'),
                            "y" => $actualProgress."",
                        ]);
                        $dataEvm->push([
                            "t" => date('Y-m-d'),
                            "y" => number_format(($actualProgress/100) * $plannedCost,2),
                        ]);
                    }
                }
            }
        }
        foreach($plannedSorted as $date => $group){
            foreach($group as $activity){
                $plannedProgress += 100 * ($activity->weight/100);
            }
            $dataPlannedProgress->push([
                "t" => $date,
                "y" => $plannedProgress."",
            ]);
        }
    }

    function getOutstandingItem($wbss,$outstanding_item,$project,$today){
        foreach($wbss as $wbs){
            if($wbs->wbs){
                if($wbs->progress == 100){
                    $outstanding_item->push([
                        "id" => $wbs->code ,
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->number.' - '.$wbs->description.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#0b710b; font-weight:bold; color:white;"],
                    ]);
                }elseif($today>$wbs->planned_end_date && $wbs->progress != 100){
                    $outstanding_item->push([
                        "id" => $wbs->code ,
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->number.' - '.$wbs->description.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:red; font-weight:bold; color:white;"],
                    ]);
                }elseif($today==$wbs->planned_end_date && $wbs->progress != 100){
                    $outstanding_item->push([
                        "id" => $wbs->code ,
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->number.' - '.$wbs->description.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#f39c12; font-weight:bold; color:white;"],
                    ]);
                }else{
                    $outstanding_item->push([
                        "id" => $wbs->code ,
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->number.' - '.$wbs->description.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#3db9d3; font-weight:bold; color:white;"],
                    ]);
                }
            }else{
                if($wbs->progress == 100){
                    $outstanding_item->push([
                        "id" => $wbs->code ,
                        "parent" => $project->number,
                        "text" => $wbs->number.' - '.$wbs->description.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#0b710b; font-weight:bold; color:white;"],
                    ]);
                }elseif($today>$wbs->planned_end_date && $wbs->progress != 100){
                    $outstanding_item->push([
                        "id" => $wbs->code ,
                        "parent" => $project->number,
                        "text" => $wbs->number.' - '.$wbs->description.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:red; font-weight:bold; color:white;"],
                    ]);
                }elseif($today==$wbs->planned_end_date && $wbs->progress != 100){
                    $outstanding_item->push([
                        "id" => $wbs->code ,
                        "parent" => $project->number,
                        "text" => $wbs->number.' - '.$wbs->description.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#f39c12; font-weight:bold; color:white;"],
                    ]);
                }else{
                    $outstanding_item->push([
                        "id" => $wbs->code ,
                        "parent" => $project->number,
                        "text" => $wbs->number.' - '.$wbs->description.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#3db9d3; font-weight:bold; color:white;"],
                    ]);
                }
            }
        }
    }

    function getDataForGantt($project, $data, $links, $today){
        $index = 0;
        $wbss_id = $project->wbss->pluck('id')->toArray();
        $activities = Activity::whereIn('wbs_id',$wbss_id)->orderBy('planned_start_date','asc')->get();
        $wbss = $project->wbss;
        foreach($activities as $activity){
            if($activity->predecessor != null){
                $predecessors = json_decode($activity->predecessor);
                foreach($predecessors as $predecessor){
                    $activityPredecessor = Activity::find($predecessor[0]);
                    $links->push([
                        "id" => $index,
                        "source"=>$activityPredecessor->code,
                        "target"=>$activity->code,
                        "type"=>"0"
                    ]);
                    $index++;
                }
            }
            $start_date_activity = date_create($activity->actual_start_date != null ? $activity->actual_start_date : $activity->planned_start_date );
            if($today>$activity->planned_end_date){
                if($activity->status == 0){
                    $data->push([
                        "id" => $activity->code ,
                        "text" => $activity->actual_duration != null ? "[Actual] ".$activity->name." | Weight : ".$activity->weight."%" : $activity->name." | Weight : ".$activity->weight."%",
                        "progress" => 1,
                        "status" => 0,
                        "start_date" =>  date_format($start_date_activity,"d-m-Y"),
                        "duration" => $activity->actual_duration != null ? $activity->actual_duration : $activity->planned_duration  ,
                        "parent" => $activity->wbs->code,
                        "color" => "green"
                    ]);
                }else{
                    $data->push([
                        "id" => $activity->code ,
                        "text" => $activity->actual_duration != null ? "[Actual] ".$activity->name." | Weight : ".$activity->weight."%" : $activity->name." | Weight : ".$activity->weight."%",
                        "progress" => 0,
                        "status" => 1,
                        "start_date" =>  date_format($start_date_activity,"d-m-Y"),
                        "duration" => $activity->actual_duration != null ? $activity->actual_duration : $activity->planned_duration  ,
                        "parent" => $activity->wbs->code,
                        "color" => "red",
                        "progressColor" => "red",
                    ]);
                }
            }else if($today==$activity->planned_end_date){
                if($activity->status == 0){
                    $data->push([
                        "id" => $activity->code ,
                        "text" => $activity->actual_duration != null ? "[Actual] ".$activity->name." | Weight : ".$activity->weight."%" : $activity->name." | Weight : ".$activity->weight."%",
                        "progress" => 1,
                        "status" => 0,
                        "start_date" =>  date_format($start_date_activity,"d-m-Y"),
                        "duration" => $activity->actual_duration != null ? $activity->actual_duration : $activity->planned_duration  ,
                        "parent" => $activity->wbs->code,
                        "color" => "green",
                        "progressColor" => "green",
                    ]);
                }else{
                    $data->push([
                        "id" => $activity->code ,
                        "text" => $activity->actual_duration != null ? "[Actual] ".$activity->name." | Weight : ".$activity->weight."%" : $activity->name." | Weight : ".$activity->weight."%",
                        "progress" => 0,
                        "status" => 1,
                        "start_date" =>  date_format($start_date_activity,"d-m-Y"),
                        "duration" => $activity->actual_duration != null ? $activity->actual_duration : $activity->planned_duration  ,
                        "parent" => $activity->wbs->code,
                        "color" => "yellow",
                        "progressColor" => "yellow",
                    ]);
                }
            }else{
                if($activity->status == 0){
                    $data->push([
                        "id" => $activity->code ,
                        "text" => $activity->actual_duration != null ? "[Actual] ".$activity->name." | Weight : ".$activity->weight."%" : $activity->name." | Weight : ".$activity->weight."%",
                        "progress" => 1,
                        "status" => 0,
                        "start_date" =>  date_format($start_date_activity,"d-m-Y"),
                        "duration" => $activity->actual_duration != null ? $activity->actual_duration : $activity->planned_duration  ,
                        "parent" => $activity->wbs->code,
                        "color" => "green",
                        "progressColor" => "green",
                    ]);
                }else{
                    $data->push([
                        "id" => $activity->code ,
                        "text" => $activity->actual_duration != null ? "[Actual] ".$activity->name." | Weight : ".$activity->weight."%" : $activity->name." | Weight : ".$activity->weight."%",
                        "progress" => 0,
                        "status" => 1,
                        "start_date" =>  date_format($start_date_activity,"d-m-Y"),
                        "duration" => $activity->actual_duration != null ? $activity->actual_duration : $activity->planned_duration  ,
                        "parent" => $activity->wbs->code,
                        "progressColor" => "#3db9d3",
                    ]);
                }
            }
        }

        foreach ($wbss as $wbs) {
            $start_date_wbs = date_create($wbs->actual_start_date != null ? $wbs->actual_start_date : $wbs->planned_start_date );
            if($wbs->wbs){
                if($today>$wbs->planned_end_date){
                    if($wbs->progress != 100){
                        $data->push([
                            "id" => $wbs->code ,
                            "text" => $wbs->actual_duration != null ? "[Actual] ".$wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%" : $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"),
                            "duration" => $wbs->actual_duration != null ? $wbs->actual_duration : $wbs->planned_duration,
                            "parent" => $wbs->wbs->code,
                            "color" => "red",
                            "progressColor" => $wbs->progress == 0 ? "red" : "green",
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code ,
                            "text" => $wbs->actual_duration != null ? "[Actual] ".$wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%" : $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"),
                            "duration" => $wbs->actual_duration != null ? $wbs->actual_duration : $wbs->planned_duration,
                            "parent" => $wbs->wbs->code,
                            "color" => "green",
                            "progressColor" => $wbs->progress == 0 ? "green" : "green",
                        ]);
                    }
                }else if($today==$wbs->planned_end_date){
                    if($wbs->progress != 100){
                        $data->push([
                            "id" => $wbs->code ,
                            "text" => $wbs->actual_duration != null ? "[Actual] ".$wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%" : $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"),
                            "duration" => $wbs->actual_duration != null ? $wbs->actual_duration : $wbs->planned_duration,
                            "parent" => $wbs->wbs->code,
                            "color" => "yellow",
                            "progressColor" => $wbs->progress == 0 ? "yellow" : "green",
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code ,
                            "text" => $wbs->actual_duration != null ? "[Actual] ".$wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%" : $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"),
                            "duration" => $wbs->actual_duration != null ? $wbs->actual_duration : $wbs->planned_duration,
                            "parent" => $wbs->wbs->code,
                            "color" => "green",
                            "progressColor" => $wbs->progress == 0 ? "green" : "green",
                        ]);
                    }
                }else{
                    if($wbs->progress == 100){
                        $data->push([
                            "id" => $wbs->code ,
                            "text" => $wbs->actual_duration != null ? "[Actual] ".$wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%" : $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"),
                            "duration" => $wbs->actual_duration != null ? $wbs->actual_duration : $wbs->planned_duration,
                            "parent" => $wbs->wbs->code,
                            "color" => "green",
                            "progressColor" => $wbs->progress == 0 ? "green" : "green",
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code ,
                            "text" => $wbs->actual_duration != null ? "[Actual] ".$wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%" : $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"),
                            "duration" => $wbs->actual_duration != null ? $wbs->actual_duration : $wbs->planned_duration,
                            "parent" => $wbs->wbs->code,
                            "progressColor" => $wbs->progress == 0 ? "#3db9d3" : "green",
                        ]);
                    }
                }
            }else{
                if($today>$wbs->planned_end_date){
                    if($wbs->progress != 100){
                        $data->push([
                            "id" => $wbs->code ,
                            "text" => $wbs->actual_duration != null ? "[Actual] ".$wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%" : $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"),
                            "duration" => $wbs->actual_duration != null ? $wbs->actual_duration : $wbs->planned_duration,
                            "color" => "red",
                            "progressColor" => $wbs->progress == 0 ? "red" : "green",
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code ,
                            "text" => $wbs->actual_duration != null ? "[Actual] ".$wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%" : $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"),
                            "duration" => $wbs->actual_duration != null ? $wbs->actual_duration : $wbs->planned_duration,
                            "color" => "green",
                            "progressColor" => $wbs->progress == 0 ? "green" : "green",
                        ]);
                    }
                }else if($today==$wbs->planned_end_date){
                    if($wbs->progress != 100){
                        $data->push([
                            "id" => $wbs->code ,
                            "text" => $wbs->actual_duration != null ? "[Actual] ".$wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%" : $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"),
                            "duration" => $wbs->actual_duration != null ? $wbs->actual_duration : $wbs->planned_duration,
                            "color" => "yellow",
                            "progressColor" => $wbs->progress == 0 ? "yellow" : "green",
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code ,
                            "text" => $wbs->actual_duration != null ? "[Actual] ".$wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%" : $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"),
                            "duration" => $wbs->actual_duration != null ? $wbs->actual_duration : $wbs->planned_duration,
                            "color" => "green",
                            "progressColor" => $wbs->progress == 0 ? "green" : "green",
                        ]);
                    }
                }else{
                    if($wbs->progress == 100){
                        $data->push([
                            "id" => $wbs->code ,
                            "text" => $wbs->actual_duration != null ? "[Actual] ".$wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%" : $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"),
                            "duration" => $wbs->actual_duration != null ? $wbs->actual_duration : $wbs->planned_duration,
                            "color" => "green",
                            "progressColor" => "green",
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code ,
                            "text" => $wbs->actual_duration != null ? "[Actual] ".$wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%" : $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"),
                            "duration" => $wbs->actual_duration != null ? $wbs->actual_duration : $wbs->planned_duration,
                            "progressColor" => $wbs->progress == 0 ? "#3db9d3" : "green",
                        ]);
                    }
                }
            }
        }
    }

    public function makeCpm($earliest_act, $current_act, $cpm_model, $predecessor_collection, $level)
    {
        $level++;
        foreach ($predecessor_collection as $activity) {
            if($current_act == $activity['predecessor']){
                $act_ref = Activity::find($activity['act_id']);
                $cpm_model[$earliest_act]->push([
                    'level'=>$level,
                    'act_id'=>$activity['act_id'],
                    'duration'=> $act_ref->planned_duration,
                    'parent'=> $current_act,
                ]);
                self::makeCpm($earliest_act, $activity['act_id'], $cpm_model, $predecessor_collection, $level);
            }
        }
    }

    public function getDataStatusProgress($project, $progressStatus){
        $previous_week = strtotime("-1 week +1 day");

        $last_start_week = strtotime("last sunday midnight",$previous_week);
        $last_end_week = strtotime("next saturday",$last_start_week);

        $last_end_week = date("Y-m-d",$last_end_week);

        $now_end_week = date( 'Y-m-d', strtotime( 'saturday this week' ) );

        $actualProgress = 0;
        $plannedProgress = 0;
        $wbss = WBS::where('project_id', $project->id)->pluck('id')->toArray();
        $activities = Activity::whereIn('wbs_id',$wbss)->get();

        $lastPlannedActivities = $activities->where('planned_end_date','<',$last_end_week);
        $nowPlannedActivities = $activities->where('planned_end_date','<',$now_end_week);

        $actualActivities =$activities->filter(function ($data) {
            return $data->progress > 0 || $data->actual_end_date !== null;
        });
        $lastActualActivities = $actualActivities->where('planned_end_date','<',$last_end_week);
        $nowActualActivities = $actualActivities->where('planned_end_date','<',$now_end_week);

        $tempLastPlanned = 0;
        foreach($lastPlannedActivities as $activity){
            $tempLastPlanned +=  100 * ($activity->weight/100);
        }

        $tempNowPlanned = 0;
        foreach($nowPlannedActivities as $activity){
            $tempNowPlanned +=  100 * ($activity->weight/100);
        }

        $tempNowActual = 0;
        foreach($lastActualActivities as $activity){
            $tempNowActual +=  100 * ($activity->weight/100);
        }

        $tempNowActual = 0;
        foreach($nowActualActivities as $activity){
            $tempNowActual +=  100 * ($activity->weight/100);
        }

        $progressStatus->put("last_week_planned", $tempLastPlanned);
        $progressStatus->put("this_week_planned", $tempNowPlanned);
        $progressStatus->put("last_week_actual", $tempNowActual);
        $progressStatus->put("this_week_actual", $tempNowActual);
    }

    //API
    public function getPostsAPI($project_id){
        $posts = Post::where('project_id', $project_id)->get();
        foreach ($posts as $post) {
            $comments = $post->comments->where('status',1)->where('user_id','!=',Auth::user()->id);
            $post->new_comment = count($comments) > 0 ? true : false;
            $post->new_comment_qty = count($comments);
        }
        $posts = $posts->jsonSerialize();
        return response($posts, Response::HTTP_OK);
    }

    public function getCommentsAPI($post_id){
        $comments = PostComment::where('post_id', $post_id)->with('user')->get()->jsonSerialize();
        return response($comments, Response::HTTP_OK);
    }
}
