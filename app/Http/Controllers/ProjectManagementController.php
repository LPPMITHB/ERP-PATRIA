<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SalesOrder;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Ship;
use App\Models\Work;
use App\Models\ProductionOrder;
use App\Models\Activity;
use App\Models\Structure;
use App\Models\Category;
use App\Models\Resource;
use App\Models\ResourceDetail;
use Illuminate\Support\Collection;
use DB;
use DateTime;
use Auth;


class ProjectManagementController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    //  public function tableRequest(Request $request) {
    //     $data = $request->json()->all();

    //     $columns = $data['columnFilters'];

    //     foreach ($columns as $key => $value) {
    //         $likes[] = [$key,'like',"%$value%"];
    //     }

    //     $sortType = $data['sort']['type'];
    //     $sortField = $data['sort']['field'];

    //     $skip = ($data['page'] - 1) * $data['perPage'];
        
    //     $totalRecords = SalesOrder::where('status', 1)->count();

    //     $take = $data['perPage'] == '-1' ? $totalRecords : $data['perPage'];

    //     $sos = SalesOrder::
    //                     orderBy($sortField, $sortType)
    //                     ->where('status', 1)
    //                     ->where($likes)
    //                     ->skip($skip)
    //                     ->take($take)
    //                     ->get();

    //     $modelSO = array();
        
    //     foreach($sos as $data){
    //         $arr = array(
    //             'number'    => $data->number,
    //             'customer'  => $data->quotation->customer->name,
    //             'product'   => $data->quotation->estimator->ship->type,
    //             'created_at'=> substr($data->created_at, 0, 10),
    //         );

    //         $modelSO[] = $arr;
    //     }      

    //     $rows = [
    //         'modelSO' => $modelSO,
    //         'totalRecords' => $totalRecords
    //     ];

    //     return response($rows ,200);
    // }

     public function index()
    {

        $projects = Project::orderBy('planned_start_date', 'asc')->get();

        return view('project.index', compact('projects'));

        // $sos = SalesOrder::where('status', 1)->get();
        // $modelSO = array();

        // foreach($sos as $data){
        //     $arr = array(
        //         'number'    => $data->number,
        //         'customer'  => $data->quotation->customer->name,
        //         'product'   => $data->quotation->estimator->ship->type,
        //         'created_at'=> $data->created_at,
        //     );

        //     $modelSO[] = $arr;
        // }

        // return view('project.index', compact('modelSO'));
    }

    public function indexConfirm()
    {
        $projects = Project::all();

        return view('project.indexConfirm', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $ships = Ship::all();
        // $project_code = self::generateProjectCode();
        $project = new Project;


        return view('project.create', compact('customers','ships','project'));
    }

    public function createWBS($id)
    {
        $structures = Structure::where('is_substructure', 0)->select('name')->get()->jsonSerialize();
        $project = Project::find($id);

        return view('project.createWBS', compact('project','structures'));
    }

    public function listWBS($id, $menu){
        $works = Work::orderBy('planned_deadline', 'asc')->where('project_id', $id)->with('work')->get();
        $project = Project::find($id);

        if($menu == "addAct"){
            $menuTitle = "Add Activities » Select Work";
        }elseif($menu == "mngNet"){
            $menuTitle = "Manage Network » Select Work";
        }elseif($menu == "viewAct"){
            $menuTitle = "View Activities » Select Work";
        }else{
            $menuTitle = "";
        }
        
        return view('project.listWBS', compact('works','project','menu','menuTitle'));
    }
    
    public function manageNetwork($id)
    {
        $work = Work::find($id);
        $project = $work->project;

        return view('project.indexNetwork', compact('project','work'));
    }

    public function selectWBS($id){
        $works = Work::orderBy('planned_deadline', 'asc')->where('project_id', $id)->with('work')->get();
        $project = Project::find($id);
        
        return view('project.selectWBSConfirm', compact('works','project'));
    }

    public function confirmActivity($id)
    {
        $work = Work::find($id);
        $project = $work->project;

        return view('project.confirmActivity', compact('project','work'));
    }

    public function indexWBS($id)
    {
        $project = Project::find($id);
        $resourceCategories = Category::where('used_for', 'RESOURCE')->get();

        return view('project.indexWBS', compact('project','resourceCategories'));
    }

    public function indexActivities($id)
    {
        $work = Work::find($id);
        $project = $work->project;

        return view('project.indexActivities', compact('project','work'));
    }
    

    public function createActivities($id)
    {
        $work = Work::find($id);
        $project = $work->project;

        return view('project.createActivities', compact('project', 'work'));
    }

    public function createSubWBS($project_id, $work_id)
    {
        $work = Work::find($work_id);
        $project = Project::find($project_id);

        $array = [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$project->number => route('project.show',$project->id),
            'Add WBS' => route('project.createWBS',$project->id),
        ];
        $iteration = 0;
        $array_reverse = [];
        $array_reverse = array_reverse(self::getParents($work,$array_reverse,$project->id, $iteration));
        foreach ($array_reverse as $key => $value) {
            $array[$key] = $value;
        }
        $array[$work->code] = "";
        return view('project.createSubWBS', compact('project', 'work','array','structures','childWorks'));
    }
    
    //BUAT BREADCRUMB DINAMIS
    function getParents($work, $array_reverse, $project_id, $iteration) {
        if ($work) {
            if($work->work){
                $array_reverse[$work->code] = route('project.createSubWBS',[$project_id,$work->work->id]);
                return self::getParents($work->work,$array_reverse, $project_id, $iteration);
            }else{
                $array_reverse[$work->code] = route('project.createSubWBS',[$project_id,$work->id]);
                return $array_reverse;
            }
        }
    }

    public function getWorks($project_id){
        $works = Work::orderBy('planned_deadline', 'asc')->where('project_id', $project_id)->where('work_id', null)->get()->jsonSerialize();
        return response($works, Response::HTTP_OK);
    }

    public function getActivity($activity_code){
        $activity = Activity::where('code',$activity_code)->get()->jsonSerialize();
        return response($activity, Response::HTTP_OK);
    }

    public function getActivities($work_id){
        $activities = Activity::orderBy('planned_start_date', 'asc')->where('work_id', $work_id)->get()->jsonSerialize();
        return response($activities, Response::HTTP_OK);
    }

    public function getAllActivities($project_id){
        $project = Project::find($project_id);

        $allActivities = Collection::make();
        foreach ($project->works as $workData) {
            foreach($workData->activities as $activity){
                $activity->push('work_name', $activity->work->name);
                $allActivities->push($activity);
            }
        }
        return response($allActivities->jsonSerialize(), Response::HTTP_OK);
    }

    public function getSubWBS($work_id){
        $works = Work::orderBy('planned_deadline', 'asc')->where('work_id', $work_id)->get()->jsonSerialize();
        return response($works, Response::HTTP_OK);
    }

    public function getPredecessor($id){
        $activity = Activity::find($id);
        $predecessor = json_decode($activity->predecessor);
        $predecessorActivities = Activity::orderBy('planned_start_date', 'asc')->whereIn('id', $predecessor)->with('work')->get()->jsonSerialize();
        return response($predecessorActivities, Response::HTTP_OK);
    }

    public function getDataGantt($id){
        $project = Project::find($id);
        $works = $project->works;
        $today = date("Y-m-d");

        $data = Collection::make();
        $links = Collection::make();

        self::getDataForGantt($project, $works, $data, $links);

        $links->jsonSerialize();
        $data->jsonSerialize();


        return response(['data' => $data, 'links'=> $links], Response::HTTP_OK);
    }

    public function storeWBS(Request $request)
    {
        $data = $request->json()->all();
        $works = Work::where('project_id',$data['project_id'])->get();
        foreach ($works as $work) {
            if($work->name == $data['name']){
                return response(["error"=>"Work Name must be UNIQUE"],Response::HTTP_OK);
            }
        }
        DB::beginTransaction();
        try {
            $work = new Work;
            $work->code = self::generateWorkCode();
            $work->name = $data['name'];
            $work->description = $data['description'];
            $work->deliverables = $data['deliverables'];
            $work->project_id = $data['project_id'];

            if(isset($data['work_id'])){
                $work->work_id = $data['work_id'];
            }
            $plannedDeadline = DateTime::createFromFormat('m/j/Y', $data['planned_deadline']);
            $work->planned_deadline =  $plannedDeadline->format('Y-m-d');
            $work->user_id = Auth::user()->id;
            $work->branch_id = Auth::user()->branch->id;

            if(!$work->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to create new work"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeActivity(Request $request)
    {
        $data = $request->json()->all();
        $stringPredecessor = '['.implode(',', $data['predecessor']).']';

        DB::beginTransaction();
        try {
            $activity = new Activity;
            $activity->code = self::generateActivityCode();
            $activity->name = $data['name'];
            $activity->description = $data['description'];
            $activity->work_id = $data['work_id'];            
            $activity->planned_duration = $data['planned_duration'];

            $planStartDate = DateTime::createFromFormat('m/j/Y', $data['planned_start_date']);
            $planEndDate = DateTime::createFromFormat('m/j/Y', $data['planned_end_date']);

            $activity->planned_start_date = $planStartDate->format('Y-m-d');
            $activity->planned_end_date = $planEndDate->format('Y-m-d');
            if(count($data['predecessor']) >0){
                $activity->predecessor = $stringPredecessor;
            }
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
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:pro_project|string|max:255',
            'customer' => 'required',
            'ship' => 'required',
            'planned_start_date' => 'required',
            'planned_end_date' => 'required',
            'planned_duration' => 'required',
            'flag' => 'required',
            'class_name' => 'required'
        ]);
        if($request->hasFile('drawing')){
            // Get filename with the extension
            $fileNameWithExt = $request->file('drawing')->getClientOriginalName();
            // Get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('drawing')->getClientOriginalExtension();
            // File name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('drawing')->storeAs('public/documents/project',$fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }
        DB::beginTransaction();
        try {
            $project = new Project;
            $project->number =  $request->number;
            $project->drawing = $fileNameToStore;
            $project->name = $request->name;
            $project->description = $request->description;
            $project->customer_id = $request->customer;
            $project->ship_id = $request->ship;
            $project->flag = $request->flag;
            $project->class_name = $request->class_name;
            $project->class_contact_person_name = $request->class_contact_person_name;
            $project->class_contact_person_phone = $request->class_contact_person_phone;
            $project->class_contact_person_email = $request->class_contact_person_email;

            $planStartDate = DateTime::createFromFormat('m/j/Y', $request->planned_start_date);
            $planEndDate = DateTime::createFromFormat('m/j/Y', $request->planned_end_date);

            $project->planned_start_date = $planStartDate->format('Y-m-d');
            $project->planned_end_date = $planEndDate->format('Y-m-d');
            $project->planned_duration =  $request->planned_duration;
            $project->progress = 0;
            $project->user_id = Auth::user()->id;
            $project->branch_id = Auth::user()->branch->id;
            $project->save();

            
            DB::commit();
            return redirect()->route('project.show', ['id' => $project->id])->with('success', 'Project Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project.create')->with('error', $e->getMessage());
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
        $project = Project::find($id);
        $works = $project->works;
        $today = date("Y-m-d");

        $data = Collection::make();
        $links = Collection::make();
        $outstanding_item = Collection::make();

        $outstanding_item->push([
                "id" => $project->number , 
                "parent" => "#",
                "text" => $project->name,
                "icon" => "fa fa-ship"
            ]);
    
        foreach($works as $work){
            if($work->work){
                if($work->progress == 100){
                    $outstanding_item->push([
                        "id" => $work->code , 
                        "parent" => $work->work->code,
                        "text" => $work->name.' <b>| Progress : '.$work->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#0b710b; font-weight:bold; color:white;"], 
                    ]);
                }elseif($today>$work->planned_deadline && $work->progress != 100){
                    $outstanding_item->push([
                        "id" => $work->code , 
                        "parent" => $work->work->code,
                        "text" => $work->name.' <b>| Progress : '.$work->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:red; font-weight:bold; color:white;"],
                    ]);
                }elseif($today==$work->planned_deadline && $work->progress != 100){
                    $outstanding_item->push([
                        "id" => $work->code , 
                        "parent" => $work->work->code,
                        "text" => $work->name.' <b>| Progress : '.$work->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#f39c12; font-weight:bold; color:white;"],
                    ]);
                }else{
                    $outstanding_item->push([
                        "id" => $work->code , 
                        "parent" => $work->work->code,
                        "text" => $work->name.' <b>| Progress : '.$work->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#3db9d3; font-weight:bold; color:white;"],
                    ]);
                }
            }else{
                if($work->progress == 100){
                    $outstanding_item->push([
                        "id" => $work->code , 
                        "parent" => $project->number,
                        "text" => $work->name.' <b>| Progress : '.$work->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#0b710b; font-weight:bold; color:white;"],
                    ]);
                }elseif($today>$work->planned_deadline && $work->progress != 100){
                    $outstanding_item->push([
                        "id" => $work->code , 
                        "parent" => $project->number,
                        "text" => $work->name.' <b>| Progress : '.$work->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:red; font-weight:bold; color:white;"],
                    ]);
                }elseif($today==$work->planned_deadline && $work->progress != 100){
                    $outstanding_item->push([
                        "id" => $work->code , 
                        "parent" => $project->number,
                        "text" => $work->name.' <b>| Progress : '.$work->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#f39c12; font-weight:bold; color:white;"],
                    ]);
                }else{
                    $outstanding_item->push([
                        "id" => $work->code , 
                        "parent" => $project->number,
                        "text" => $work->name.' <b>| Progress : '.$work->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#3db9d3; font-weight:bold; color:white;"],
                    ]);
                }
            }  
        }

        self::getDataForGantt($project, $works, $data, $links);       

        $links->jsonSerialize();
        $data->jsonSerialize();

        $modelPrO = productionOrder::where('project_id',$project->id)->where('status',0)->get();
        return view('project.show', compact('project','today','data','links','outstanding_item','modelPrO'));
    }

    public function showActivity($id)
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
        return view('project.showActivity', compact('activity','activityPredecessor'));

    }

    public function showWBS($id)
    {
        $work = Work::find($id);

        return view('project.showWBS', compact('work'));

    }

    public function showGanttChart($id)
    {
        $project = Project::find($id);
        $works = $project->works;

        $data = Collection::make();
        $links = Collection::make();


        self::getDataForGantt($project, $works, $data, $links);
        
        $links->jsonSerialize();
        $data->jsonSerialize();
        return view('project.ganttChart', compact('project','data','links'));
    }
    

    function getDataForGantt($project, $works, $data, $links){
        foreach($works as $work){
            $today = date("Y-m-d");
            if(count($work->activities)>0){
                $earliest_date = null;
                $index = 0;
                foreach($work->activities as $activity){
                    $start_date_activity = date_create($activity->planned_start_date);
                    if($today>$activity->planned_end_date && $activity->status != 0){
                        $data->push([
                            "id" => $activity->code , 
                            "text" => $activity->name,
                            "progress" => 0,
                            "status" => 1,
                            "start_date" =>  date_format($start_date_activity,"d-m-Y"), 
                            "duration" => $activity->planned_duration,
                            "parent" => $work->code,
                            "color" => "red"
                        ]);
                    }else if($today<$activity->planned_end_date && $activity->status == 0){
                        $data->push([
                            "id" => $activity->code , 
                            "text" => $activity->name,
                            "progress" => 1,
                            "status" => 0,
                            "start_date" =>  date_format($start_date_activity,"d-m-Y"), 
                            "duration" => $activity->planned_duration, 
                            "parent" => $work->code, 
                            "color" => "green"
                        ]);
                    }else{
                        if($activity->status == 0){
                            $data->push([
                                "id" => $activity->code , 
                                "text" => $activity->name,
                                "progress" => 1,
                                "status" => 0,
                                "start_date" =>  date_format($start_date_activity,"d-m-Y"), 
                                "duration" => $activity->planned_duration, 
                                "parent" => $work->code, 
                                "color" => "green"
                            ]);
                        }else{
                            $data->push([
                                "id" => $activity->code , 
                                "text" => $activity->name,
                                "progress" => 0,
                                "status" => 1,
                                "start_date" =>  date_format($start_date_activity,"d-m-Y"), 
                                "duration" => $activity->planned_duration,
                                "parent" => $work->code,  
                            ]);
                        }
                    }
                    if($earliest_date != null){
                        if($earliest_date > $activity->planned_start_date){
                            $earliest_date = $activity->planned_start_date;
                        }
                    }else{
                        $earliest_date = $activity->planned_start_date;
                    }

                    if($activity->predecessor != null){
                        $predecessor = json_decode($activity->predecessor);
                        foreach($predecessor as $activity_id){
                            $activityPredecessor = Activity::find($activity_id);
                            $links->push([
                                "id" => $index, 
                                "source"=>$activityPredecessor->code,
                                "target"=>$activity->code,
                                "type"=>"0"
                            ]);
                            $index++;
                        }
                    }
                }
                $start_date_work = date_create($earliest_date);

                $earlier = new DateTime($earliest_date);
                $later = new DateTime($work->planned_deadline);

                $duration = $later->diff($earlier)->format("%a");

                if($work->work_id != null){
                    if($today>$work->planned_deadline && $work->progress != 100){
                        $data->push([
                            "id" => $work->code , 
                            "text" => $work->name,
                            "progress" => $work->progress / 100,
                            "start_date" =>  date_format($start_date_work,"d-m-Y"), 
                            "duration" => $duration,
                            "parent" => $work->work->code,
                            "color" => "red"
                        ]);
                    }else if($work->progress == 100){
                        $data->push([
                            "id" => $work->code , 
                            "text" => $work->name,
                            "progress" => $work->progress / 100,
                            "start_date" =>  date_format($start_date_work,"d-m-Y"), 
                            "duration" => $duration, 
                            "parent" => $work->work->code, 
                            "color" => "green"
                        ]);
                    }else{
                        $data->push([
                            "id" => $work->code , 
                            "text" => $work->name,
                            "progress" => $work->progress / 100,
                            "start_date" =>  date_format($start_date_work,"d-m-Y"), 
                            "duration" => $duration,
                            "parent" => $work->work->code,  
                        ]);
                    }   
                }else{
                    if($today>$work->planned_deadline && $work->progress != 100){
                        $data->push([
                            "id" => $work->code , 
                            "text" => $work->name,
                            "progress" => $work->progress / 100,
                            "start_date" =>  date_format($start_date_work,"d-m-Y"), 
                            "duration" => $duration,
                            "color" => "red"
                        ]);
                    }else if($work->progress == 100){
                        $data->push([
                            "id" => $work->code , 
                            "text" => $work->name,
                            "progress" => $work->progress / 100,
                            "start_date" =>  date_format($start_date_work,"d-m-Y"), 
                            "duration" => $duration,  
                            "color" => "green"
                        ]);
                    }else{
                        $data->push([
                            "id" => $work->code , 
                            "text" => $work->name,
                            "progress" => $work->progress / 100,
                            "start_date" =>  date_format($start_date_work,"d-m-Y"), 
                            "duration" => $duration,  
                        ]);
                    }  
                } 
            }else{
                if($work->work){
                    if(count($work->work->activities)>0){
                        $earliest_date = null;
                        foreach($work->work->activities as $activity){
                            if($earliest_date != null){
                                if($earliest_date > $activity->planned_start_date){
                                    $earliest_date = $activity->planned_start_date;
                                }
                            }else{
                                $earliest_date = $activity->planned_start_date;
                            }
                        }
                        $start_date_work = date_create($earliest_date);
                        $earlier = new DateTime($earliest_date);
                        $later = new DateTime($work->planned_deadline);
                        
                    }else{
                        $start_date_work = date_create($project->planned_start_date);
                        $earlier = new DateTime($project->planned_start_date);
                        $later = new DateTime($work->planned_deadline);
                    }
                }else{
                    $start_date_work = date_create($project->planned_start_date);
                    $earlier = new DateTime($project->planned_start_date);
                    $later = new DateTime($work->planned_deadline);
                }

                $duration = $later->diff($earlier)->format("%a");
                if($work->work_id != null){
                    if($today>$work->planned_deadline && $work->progress != 100){
                        $data->push([
                            "id" => $work->code , 
                            "text" => $work->name,
                            "progress" => $work->progress / 100,
                            "start_date" =>  date_format($start_date_work,"d-m-Y"), 
                            "duration" => $duration,
                            "parent" => $work->work->code,
                            "color" => "red"
                        ]);
                    }else if($work->progress == 100){
                        $data->push([
                            "id" => $work->code , 
                            "text" => $work->name,
                            "progress" => $work->progress / 100,
                            "start_date" =>  date_format($start_date_work,"d-m-Y"), 
                            "duration" => $duration, 
                            "parent" => $work->work->code, 
                            "color" => "green"
                        ]);
                    }else{
                        $data->push([
                            "id" => $work->code , 
                            "text" => $work->name,
                            "progress" => $work->progress / 100,
                            "start_date" =>  date_format($start_date_work,"d-m-Y"), 
                            "duration" => $duration,
                            "parent" => $work->work->code,  
                        ]);
                    }   
                }else{
                    if($today>$work->planned_deadline && $work->progress != 100){
                        $data->push([
                            "id" => $work->code , 
                            "text" => $work->name,
                            "progress" => $work->progress / 100,
                            "start_date" =>  date_format($start_date_work,"d-m-Y"), 
                            "duration" => $duration,
                            "color" => "red"
                        ]);
                    }else if($work->progress == 100){
                        $data->push([
                            "id" => $work->code , 
                            "text" => $work->name,
                            "progress" => $work->progress / 100,
                            "start_date" =>  date_format($start_date_work,"d-m-Y"), 
                            "duration" => $duration,  
                            "color" => "green"
                        ]);
                    }else{
                        $data->push([
                            "id" => $work->code , 
                            "text" => $work->name,
                            "progress" => $work->progress / 100,
                            "start_date" =>  date_format($start_date_work,"d-m-Y"), 
                            "duration" => $duration,  
                        ]);
                    }
                } 
            }   
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $customers = Customer::all();
        $ships = Ship::all();

        return view('project.create', compact('project','customers','ships'));
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
        $this->validate($request, [
            'name' => 'required|unique:pro_project,id,'.$id.'|string|max:255',
            'customer' => 'required',
            'ship' => 'required',
            'planned_start_date' => 'required',
            'planned_end_date' => 'required',
            'planned_duration' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $project = Project::findOrFail($id);
            $project->name = $request->name;
            $project->description = $request->description;
            $project->customer_id = $request->customer;
            $project->ship_id = $request->ship;

            $planStartDate = DateTime::createFromFormat('m/j/Y', $request->planned_start_date);
            $planEndDate = DateTime::createFromFormat('m/j/Y', $request->planned_end_date);

            $project->planned_start_date = $planStartDate->format('Y-m-d');
            $project->planned_end_date = $planEndDate->format('Y-m-d');
            $project->planned_duration =  $request->planned_duration;
            $project->save();

            
            DB::commit();
            return redirect()->route('project.show', ['id' => $project->id])->with('success', 'Project Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project.update', ['id' => $project->id])->with('error', $e->getMessage());
        }
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

    public function updateWBS(Request $request, $id)
    {
        $data = $request->json()->all();
        $work_ref = Work::find($id);
        $works = Work::where('project_id',$data['project_id'])->get();
        foreach ($works as $work) {
            if($work->name == $data['name'] && $work_ref->name != $data['name'] ){
                return response(["error"=>"Work Name must be UNIQUE"],Response::HTTP_OK);
            }
        }
        DB::beginTransaction();
        try {
            $work_ref->name = $data['name'];
            $work_ref->description = $data['description'];
            $work_ref->deliverables = $data['deliverables'];

            $plannedDeadline = DateTime::createFromFormat('m/j/Y', $data['planned_deadline']);
            $work_ref->planned_deadline =  $plannedDeadline->format('Y-m-d');

            if(!$work_ref->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update WBS ".$work_ref->code],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function updateActivity(Request $request, $id)
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

            $work = $activity->work;

            self::changeWorkProgress($work);

            $project = $work->project;
            $oldestWorks= $project->works->where('work_id', null);
            $workContribution = 1/(count($oldestWorks));
            $totalWorkPercentage = 0;
            foreach($oldestWorks as $work){
                $totalWorkPercentage = $totalWorkPercentage + ($work->progress*($workContribution));
            }            
            $project->progress = $totalWorkPercentage;
            $project->save();
            
            DB::commit();
            return response(["response"=>"Success to confirm activity ".$activity->code],Response::HTTP_OK);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    function changeWorkProgress($work){
        if($work){
            if($work->work){
                $totalFinishedActivity = 0;
                $totalActivity = count($work->activities);
                if($work->activities){
                    foreach($work->activities as $activity){
                        if($activity->status == 0){
                            $totalFinishedActivity++;
                        }
                    }
                }

                $childWorkPercentage = 0;
                if($work->works){
                    $totalActivity = $totalActivity + count($work->works);
                    $childWorkContribution = 1/$totalActivity;
                    foreach($work->works as $child_work){
                        $childWorkPercentage = $childWorkPercentage + ($child_work->progress*($childWorkContribution));
                    }
                }
                $work->progress = (($totalFinishedActivity/$totalActivity)*100) + $childWorkPercentage;
                $work->save();
                self::changeWorkProgress($work->work);
            }else{
                $totalFinishedActivity = 0;
                $totalActivity = count($work->activities);
                if($work->activities){
                    foreach($work->activities as $activity){
                        if($activity->status == 0){
                            $totalFinishedActivity++;
                        }
                    }
                }

                $childWorkPercentage = 0;
                if($work->works){
                    $totalActivity = $totalActivity + count($work->works);
                    $childWorkContribution = 1/$totalActivity;
                    foreach($work->works as $child_work){
                        $childWorkPercentage = $childWorkPercentage + ($child_work->progress*($childWorkContribution));
                    }
                }
                $work->progress = (($totalFinishedActivity/$totalActivity)*100) + $childWorkPercentage;
                $work->save();
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateWorkCode(){
        $code = 'PRW';
        $modelWork = Work::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelWork)){
            $number += intval(substr($modelWork->code, -4));
		}

        $work_code = $code.''.sprintf('%04d', $number);
		return $work_code;
    }
    
    public function generateActivityCode(){
        $code = 'PRA';
        $modelActivity = Activity::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelActivity)){
            $number += intval(substr($modelActivity->code, -4));
		}

        $activity_code = $code.''.sprintf('%04d', $number);
		return $activity_code;
    }

    public function generateProjectCode(){
        $code = 'PROJECT';
        $modelProject = Project::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelProject)){
            $number += intval(substr($modelProject->code, -2));
		}

        $project_code = $code.'-'.sprintf('%02d', $number);
		return $project_code;
    }
    
    // Project Cost Evaluation
    public function projectCE($id){
        $modelWBS = Work::where('project_id',$id)->where('work_id','!=',null)->get();
        $project = Project::findOrFail($id);

        $planned = Collection::make();

        $actual = Collection::make();
        foreach($project->works as $wbs){
            $actualCostPerWbs = 0;
            $plannedCostPerWbs = $wbs->bom != null ? $wbs->bom->rap != null ? $wbs->bom->rap->total_price : 0 : 0;

            foreach($wbs->materialRequisitionDetails as $mrd){
                $actualCostPerWbs = $mrd->material->cost_standard_price * $mrd->issued;
            }

            $planned->push([
                "wbs_name" => $wbs->name,
                "cost" => $plannedCostPerWbs,                   
            ]);

            $actual->push([
                "wbs_name" => $wbs->name,
                "cost" => $actualCostPerWbs,                   
            ]);
        }

        return view('project.showPCE', compact('modelWBS','project','actual','planned'));
    }

    // Configuration WBS & Estimator
    public function selectProjectConfig(){
        $modelProject = Project::where('status',1)->get();

        return view('project.selectProject', compact('modelProject'));
    }

    public function configWbsEstimator($id){
        $project = Project::findOrFail($id);
        $works = Work::where('project_id',$project->id)->whereNull('work_id')->get();

        return view('project.configWbsEstimator', compact('project','works'));
    }

    //API
    public function getCustomerPM($id){
        $customer = Customer::find($id);
        return response($customer->jsonSerialize(), Response::HTTP_OK);
    }

    public function getResourceByCategoryAPI($id){
        $categories_id = json_decode($id);
        $resources = Resource::whereIn('category_id', $categories_id)->get();
        return response($resources->jsonSerialize(), Response::HTTP_OK);
    }

    public function getResourceAPI($id){
        $resource = Resource::where('id',$id)->with('category')->first();
        return response($resource->jsonSerialize(), Response::HTTP_OK);
    }

    public function getAllResourceAPI($id){
        $data = Collection::make();
        $refResources = ResourceDetail::where('work_id', $id)->get();
        $categories = [];
        $resources = Collection::make();
        foreach($refResources as $resource){
            if($resource->resource_id != null ){
                $resources->push([
                    "resource_id" => $resource->resource_id,
                    "resource_code" => $resource->resource->code,
                    "resource_name" => $resource->resource->name,
                    "quantity" => number_format($resource->quantity),
                    "quantityInt" => $resource->quantity,
                    "category_id" => $resource->category->id,                     
                ]);
            }
            array_push($categories,$resource->category->id."");
        }

        array_unique($categories);

        $data->push([
            "resources" => $resources,
            "categories" => $categories, 
        ]);
        return response($data->jsonSerialize(), Response::HTTP_OK);
    }
    
}
