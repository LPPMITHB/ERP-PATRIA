<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SalesOrder;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Ship;
use App\Models\WBS;
use App\Models\ProductionOrder;
use App\Models\Activity;
use App\Models\Structure;
use App\Models\Category;
use App\Models\Resource;
use App\Models\ResourceDetail;
use App\Models\BusinessUnit;
use Illuminate\Support\Collection;
use DB;
use DateTime;
use Auth;


class ProjectController extends Controller
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
    //             'product'   => $data->quotation->estimator->ship->name,
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

    public function index(Request $request)
    {

        $projects = Project::orderBy('planned_start_date', 'asc')->where('business_unit_id', 1)->get();
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";

        return view('project.index', compact('projects','menu'));

        // $sos = SalesOrder::where('status', 1)->get();
        // $modelSO = array();

        // foreach($sos as $data){
        //     $arr = array(
        //         'number'    => $data->number,
        //         'customer'  => $data->quotation->customer->name,
        //         'product'   => $data->quotation->estimator->ship->name,
        //         'created_at'=> $data->created_at,
        //     );

        //     $modelSO[] = $arr;
        // }

        // return view('project.index', compact('modelSO'));
    }

    public function indexRepair(Request $request)
    {

        $projects = Project::orderBy('planned_start_date', 'asc')->where('business_unit_id', 2)->get();
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";

        return view('project.index', compact('projects','menu'));

        // $sos = SalesOrder::where('status', 1)->get();
        // $modelSO = array();

        // foreach($sos as $data){
        //     $arr = array(
        //         'number'    => $data->number,
        //         'customer'  => $data->quotation->customer->name,
        //         'product'   => $data->quotation->estimator->ship->name,
        //         'created_at'=> $data->created_at,
        //     );

        //     $modelSO[] = $arr;
        // }

        // return view('project.index', compact('modelSO'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $customers = Customer::all();
        $ships = Ship::all();
        // $project_code = self::generateProjectCode();
        $project = new Project;
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";

        return view('project.create', compact('customers','ships','project','businessUnit','menu'));
    }

    public function createRepair(Request $request)
    {
        $customers = Customer::all();
        $ships = Ship::all();
        // $project_code = self::generateProjectCode();
        $project = new Project;
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";

        return view('project.create', compact('customers','ships','project','businessUnit','menu'));
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

        DB::beginTransaction();
        try {
            $project = new Project;
            $project->number =  $request->number;
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
            $project->business_unit_id = 1;
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

    public function storeRepair(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:pro_project|string|max:255',
            'customer' => 'required',
            'ship' => 'required',
            'planned_start_date' => 'required',
            'planned_end_date' => 'required',
            'planned_duration' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $project = new Project;
            $project->number =  $request->number;
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
            $project->business_unit_id = 2;
            $project->user_id = Auth::user()->id;
            $project->branch_id = Auth::user()->branch->id;
            $project->save();

            
            DB::commit();
            return redirect()->route('project_repair.show', ['id' => $project->id])->with('success', 'Project Created');
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
    public function show(Request $request, $id)
    {
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";
        $project = Project::find($id);
        $wbss = $project->wbss;
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

        self::getOutstandingItem($wbss,$outstanding_item, $project,$today);
        self::getDataForGantt($project, $wbss, $data, $links, $today);       

        $links->jsonSerialize();
        $data->jsonSerialize();

        $modelPrO = productionOrder::where('project_id',$project->id)->where('status',0)->get();
        return view('project.show', compact('project','today','data','links','outstanding_item','modelPrO','menu'));
    }

    public function showRepair(Request $request, $id)
    {
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";
        $project = Project::find($id);
        $wbss = $project->wbss;
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

        self::getOutstandingItem($wbss,$outstanding_item, $project,$today);
        self::getDataForGantt($project, $wbss, $data, $links, $today);       

        $links->jsonSerialize();
        $data->jsonSerialize();

        $modelPrO = productionOrder::where('project_id',$project->id)->where('status',0)->get();
        return view('project.show', compact('project','today','data','links','outstanding_item','modelPrO','menu'));
    }

    public function showGanttChart($id)
    {
        $project = Project::find($id);
        $wbss = $project->wbss;

        $data = Collection::make();
        $links = Collection::make();


        self::getDataForGantt($project, $wbss, $data, $links, $today);
        
        $links->jsonSerialize();
        $data->jsonSerialize();
        return view('project.ganttChart', compact('project','data','links'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $customers = Customer::all();
        $ships = Ship::all();
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";

        return view('project.create', compact('project','customers','ships','menu'));
    }

    public function editRepair(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $customers = Customer::all();
        $ships = Ship::all();
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";

        return view('project.create', compact('project','customers','ships','menu'));
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
            $project->save();

            
            DB::commit();
            return redirect()->route('project.show', ['id' => $project->id])->with('success', 'Project Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project.update', ['id' => $project->id])->with('error', $e->getMessage());
        }
    }

    public function updateRepair(Request $request, $id)
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
            $project->save();

            
            DB::commit();
            return redirect()->route('project_repair.show', ['id' => $project->id])->with('success', 'Project Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project.update', ['id' => $project->id])->with('error', $e->getMessage());
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

        
    // Project Cost Evaluation
    public function projectCE($id){
        $modelWBS = WBS::where('project_id',$id)->where('wbs_id','!=',null)->get();
        $project = Project::findOrFail($id);

        $planned = Collection::make();

        $actual = Collection::make();
        foreach($project->wbss as $wbs){
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
        $wbss = Work::where('project_id',$project->id)->whereNull('wbs_id')->get();

        return view('project.configWbsEstimator', compact('project','wbss'));
    }
    
    //Methods
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

    function getOutstandingItem($wbss,$outstanding_item,$project,$today){
        foreach($wbss as $wbs){
            if($wbs->wbs){
                if($wbs->progress == 100){
                    $outstanding_item->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->name.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#0b710b; font-weight:bold; color:white;"], 
                    ]);
                }elseif($today>$wbs->planned_deadline && $wbs->progress != 100){
                    $outstanding_item->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->name.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:red; font-weight:bold; color:white;"],
                    ]);
                }elseif($today==$wbs->planned_deadline && $wbs->progress != 100){
                    $outstanding_item->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->name.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#f39c12; font-weight:bold; color:white;"],
                    ]);
                }else{
                    $outstanding_item->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->name.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#3db9d3; font-weight:bold; color:white;"],
                    ]);
                }
            }else{
                if($wbs->progress == 100){
                    $outstanding_item->push([
                        "id" => $wbs->code , 
                        "parent" => $project->number,
                        "text" => $wbs->name.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#0b710b; font-weight:bold; color:white;"],
                    ]);
                }elseif($today>$wbs->planned_deadline && $wbs->progress != 100){
                    $outstanding_item->push([
                        "id" => $wbs->code , 
                        "parent" => $project->number,
                        "text" => $wbs->name.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:red; font-weight:bold; color:white;"],
                    ]);
                }elseif($today==$wbs->planned_deadline && $wbs->progress != 100){
                    $outstanding_item->push([
                        "id" => $wbs->code , 
                        "parent" => $project->number,
                        "text" => $wbs->name.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#f39c12; font-weight:bold; color:white;"],
                    ]);
                }else{
                    $outstanding_item->push([
                        "id" => $wbs->code , 
                        "parent" => $project->number,
                        "text" => $wbs->name.' <b>| Progress : '.$wbs->progress.' %</b>',
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["style" => "background-color:#3db9d3; font-weight:bold; color:white;"],
                    ]);
                }
            }  
        }
    }

    function getDataForGantt($project, $wbss, $data, $links, $today){
        foreach($wbss as $wbs){
            if(count($wbs->activities)>0){
                $earliest_date = null;
                $index = 0;
                foreach($wbs->activities as $activity){
                    $start_date_activity = date_create($activity->planned_start_date);
                    if($today>$activity->planned_end_date && $activity->status != 0){
                        $data->push([
                            "id" => $activity->code , 
                            "text" => $activity->name,
                            "progress" => 0,
                            "status" => 1,
                            "start_date" =>  date_format($start_date_activity,"d-m-Y"), 
                            "duration" => $activity->planned_duration,
                            "parent" => $wbs->code,
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
                            "parent" => $wbs->code, 
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
                                "parent" => $wbs->code, 
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
                                "parent" => $wbs->code,  
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
                $start_date_wbs = date_create($earliest_date);

                $earlier = new DateTime($earliest_date);
                $later = new DateTime($wbs->planned_deadline);

                $duration = $later->diff($earlier)->format("%a");

                if($wbs->wbs_id != null){
                    if($today>$wbs->planned_deadline && $wbs->progress != 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name,
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,
                            "parent" => $wbs->wbs->code,
                            "color" => "red"
                        ]);
                    }else if($wbs->progress == 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name,
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration, 
                            "parent" => $wbs->wbs->code, 
                            "color" => "green"
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name,
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,
                            "parent" => $wbs->wbs->code,  
                        ]);
                    }   
                }else{
                    if($today>$wbs->planned_deadline && $wbs->progress != 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name,
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,
                            "color" => "red"
                        ]);
                    }else if($wbs->progress == 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name,
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,  
                            "color" => "green"
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name,
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,  
                        ]);
                    }  
                } 
            }else{
                if($wbs->wbs){
                    if(count($wbs->wbs->activities)>0){
                        $earliest_date = null;
                        foreach($wbs->wbs->activities as $activity){
                            if($earliest_date != null){
                                if($earliest_date > $activity->planned_start_date){
                                    $earliest_date = $activity->planned_start_date;
                                }
                            }else{
                                $earliest_date = $activity->planned_start_date;
                            }
                        }
                        $start_date_wbs = date_create($earliest_date);
                        $earlier = new DateTime($earliest_date);
                        $later = new DateTime($wbs->planned_deadline);
                        
                    }else{
                        $start_date_wbs = date_create($project->planned_start_date);
                        $earlier = new DateTime($project->planned_start_date);
                        $later = new DateTime($wbs->planned_deadline);
                    }
                }else{
                    $start_date_wbs = date_create($project->planned_start_date);
                    $earlier = new DateTime($project->planned_start_date);
                    $later = new DateTime($wbs->planned_deadline);
                }

                $duration = $later->diff($earlier)->format("%a");
                if($wbs->wbs_id != null){
                    if($today>$wbs->planned_deadline && $wbs->progress != 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name,
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,
                            "parent" => $wbs->wbs->code,
                            "color" => "red"
                        ]);
                    }else if($wbs->progress == 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name,
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration, 
                            "parent" => $wbs->wbs->code, 
                            "color" => "green"
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name,
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,
                            "parent" => $wbs->wbs->code,  
                        ]);
                    }   
                }else{
                    if($today>$wbs->planned_deadline && $wbs->progress != 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name,
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,
                            "color" => "red"
                        ]);
                    }else if($wbs->progress == 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name,
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,  
                            "color" => "green"
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name,
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,  
                        ]);
                    }
                } 
            }   
        }
    }

    //API
    public function getDataGanttAPI($id){
        $project = Project::find($id);
        $wbss = $project->wbss;
        $today = date("Y-m-d");

        $data = Collection::make();
        $links = Collection::make();

        self::getDataForGantt($project, $wbss, $data, $links, $today);

        $links->jsonSerialize();
        $data->jsonSerialize();


        return response(['data' => $data, 'links'=> $links], Response::HTTP_OK);
    }
    
    public function getActivityAPI($activity_code){
        $activity = Activity::where('code',$activity_code)->get()->jsonSerialize();
        return response($activity, Response::HTTP_OK);
    }
    
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
        $refResources = ResourceDetail::where('wbs_id', $id)->get();
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
