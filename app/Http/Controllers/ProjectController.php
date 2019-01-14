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
use App\Models\MaterialRequisition;
use App\Models\Bom;
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

    public function listWBS($id, $menu){
        $project = Project::find($id);
        $mainMenu = $project->business_unit_id == "1" ? "building" : "repair";
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
            if($mainMenu == "building"){
                $route = "/activity/create/";
            }else{
                $route = "/activity_repair/create/";
            }
            $menuTitle = "Add Activities » Select WBS";
        }elseif($menu == "viewAct"){
            if($mainMenu == "building"){
                $route = "/activity/index/";
            }else{
                $route = "/activity_repair/index/";
            }
            $menuTitle = "View Activities » Select WBS";
        }elseif($menu == "confirmAct"){
            if($mainMenu == "building"){
                $route = "/activity/confirmActivity/";
            }else{
                $route = "/activity_repair/confirmActivity/";
            }
            $menuTitle = "Confirm Activity » Select WBS";
        }elseif($menu == "viewWbs"){
            if($mainMenu == "building"){
                $route = "/wbs/show/";
            }else{
                $route = "/wbs_repair/show/";
            }
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
                    foreach($wbs->activities as $activity){
                        if($menu == "viewAct"){
                            if($mainMenu == "building"){
                                $dataWbs->push([
                                    "id" => $activity->code , 
                                    "parent" => $activity->wbs->code,
                                    "text" => $activity->name. " | Weight : ".$activity->weight."%",
                                    "icon" => "fa fa-clock-o",
                                    "a_attr" =>  ["href" => "/activity/show/".$activity->id],
                                ]);
                            }else{
                                $dataWbs->push([
                                    "id" => $activity->code , 
                                    "parent" => $activity->wbs->code,
                                    "text" => $activity->name. " | Weight : ".$activity->weight."%",
                                    "icon" => "fa fa-clock-o",
                                    "a_attr" =>  ["href" => "/activity_repair/show/".$activity->id],
                                ]);
                            }
                        }else{
                            $dataWbs->push([
                                "id" => $activity->code , 
                                "parent" => $activity->wbs->code,
                                "text" => $activity->name. " | Weight : ".$activity->weight."%",
                                "icon" => "fa fa-clock-o",
                            ]);
                        }
                    }
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
                if(count($wbs->activities)>0){
                    foreach($wbs->activities as $activity){
                        if($menu == "viewAct"){
                            $dataWbs->push([
                                "id" => $activity->code , 
                                "parent" => $activity->wbs->code,
                                "text" => $activity->name. " | Weight : ".$activity->weight."%",
                                "icon" => "fa fa-clock-o",
                                "a_attr" =>  ["href" => "/activity/show/".$activity->id],
                        ]);
                        }else{
                            $dataWbs->push([
                                "id" => $activity->code , 
                                "parent" => $activity->wbs->code,
                                "text" => $activity->name. " | Weight : ".$activity->weight."%)",
                                "icon" => "fa fa-clock-o",
                            ]);
                        }
                    }
                }
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
        
        return view('project.listWBS', compact('dataWbs','project','menu','menuTitle','mainMenu'));
    }

    public function index(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";
        if($menu=="repair"){
            $projects = Project::orderBy('planned_start_date', 'asc')->where('business_unit_id', 2)->get();
        }else if($menu == "building"){
            $projects = Project::orderBy('planned_start_date', 'asc')->where('business_unit_id', 1)->get();
        }

        return view('project.index', compact('projects','menu'));
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

        return view('project.create', compact('customers','ships','project','menu'));
    }
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";

        if($menu == "building"){
            $this->validate($request, [
                'number' => 'required',
                'customer' => 'required',
                'ship' => 'required',
                'planned_start_date' => 'required',
                'planned_end_date' => 'required',
                'planned_duration' => 'required',
                'flag' => 'required',
                'class_name' => 'required'
            ]);
        }elseif($menu == "repair"){
            $this->validate($request, [
                'number' => 'required',
                'customer' => 'required',
                'ship' => 'required',
                'planned_start_date' => 'required',
                'planned_end_date' => 'required',
                'planned_duration' => 'required',
            ]);
        } 
        $projects = Project::all();
        foreach ($projects as $project) {
            if($project->name == $request->name){
                if($menu == "building"){
                    return redirect()->route('project.create')->with('error','The project name has been taken')->withInput();
                }
            }
            if($project->number == $request->number){
                if($menu == "building"){
                    return redirect()->route('project.create')->with('error','The project number has been taken')->withInput();
                }else{
                    return redirect()->route('project_repair.create')->with('error','The project number has been taken')->withInput();
                }
            }
        }

        DB::beginTransaction();
        $modelProject = Project::orderBy('id','desc')->whereYear('created_at', '=', date('Y'))->first();
        try {
            $project = new Project;
            $project->number =  $request->number;
            $project->project_sequence = $modelProject != null ? $modelProject->project_sequence + 1 : 1;
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
            $project->business_unit_id = $request->business_unit_id;
            $project->user_id = Auth::user()->id;
            $project->branch_id = Auth::user()->branch->id;
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
                $path = $request->file('drawing')->storeAs('documents/project',$fileNameToStore);
            }else{
                $fileNameToStore =  null;
            }
            $project->drawing = $fileNameToStore;
            $project->save();

            
            DB::commit();
            if($menu == "building"){
                return redirect()->route('project.show', ['id' => $project->id])->with('success', 'Project Created');
            }elseif($menu == "repair"){
                return redirect()->route('project_repair.show', ['id' => $project->id])->with('success', 'Project Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('project.create')->with( 'error',$e->getMessage())->withInput();
            }elseif($menu == "repair"){
                return redirect()->route('project_repair.create')->with( 'error',$e->getMessage())->withInput();
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
        $project = Project::find($id);
        $menu = $project->business_unit_id == "1" ? "building" : "repair";
        $wbss = $project->wbss;
        $today = date("Y-m-d");

        //planned
        $dataPlannedCost = Collection::make();
        $modelBom = Bom::where('project_id',$id)->get();
        $wbsChart = $project->wbss->groupBy('planned_deadline');
        $dataPlannedCost->push([
            "t" => $project->planned_start_date, 
            "y" => "0",
        ]);
        
        //actual
        $dataActualCost = Collection::make();
        $modelMR = MaterialRequisition::where('project_id',$id)->get();
        if($project->actual_start_date != null){
            $dataActualCost->push([
                "t" => $project->actual_start_date, 
                "y" => "0",
            ]);
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
        self::getDataChart($dataPlannedCost,$wbsChart,$modelMR,$dataActualCost, $project, $dataActualProgress, $dataPlannedProgress);
        $ganttData = Collection::make();
        $links = Collection::make();
        $outstanding_item = Collection::make();

        $outstanding_item->push([
            "id" => $project->number , 
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);

        self::getOutstandingItem($wbss,$outstanding_item, $project,$today);
        self::getDataForGantt($project, $ganttData, $links, $today);       

        $ganttData->jsonSerialize();
        $links->jsonSerialize();
        $dataPlannedCost->jsonSerialize();
        $dataActualCost->jsonSerialize();
        $dataActualProgress->jsonSerialize();
        $dataPlannedProgress->jsonSerialize();
        
        $modelPrO = productionOrder::where('project_id',$project->id)->where('status',0)->get();
        return view('project.show', compact('project','today','ganttData','links','outstanding_item','modelPrO','menu',
        'dataPlannedCost','dataActualCost','dataActualProgress','dataPlannedProgress'));
    }


    public function showGanttChart($id, Request $request)
    {
        $today = date("Y-m-d");
        $project = Project::find($id);
        $menu = $project->business_unit_id == "1" ? "building" : "repair";

        $data = Collection::make();
        $links = Collection::make();


        self::getDataForGantt($project, $data, $links, $today);
        
        $links->jsonSerialize();
        $data->jsonSerialize();
        return view('project.ganttChart', compact('project','data','links','today','menu'));
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
        $menu = $project->business_unit_id == "1" ? "building" : "repair";

        
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
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";

        if($menu == "building"){
            $this->validate($request, [
                'number' => 'required',
                'customer' => 'required',
                'ship' => 'required',
                'planned_start_date' => 'required',
                'planned_end_date' => 'required',
                'planned_duration' => 'required',
                'flag' => 'required',
                'class_name' => 'required'
            ]);
        }elseif($menu == "repair"){
            $this->validate($request, [
                'number' => 'required',
                'customer' => 'required',
                'ship' => 'required',
                'planned_start_date' => 'required',
                'planned_end_date' => 'required',
                'planned_duration' => 'required',
            ]);
        } 

        DB::beginTransaction();
        $projects = Project::where('id', '!=', $id)->get();
        foreach ($projects as $project) {
            if($project->name == $request->name){
                if($menu == "building"){
                    return redirect()->route('project.create')->with('error','The project name has been taken')->withInput();
                }
            }
            if($project->number == $request->number){
                if($menu == "building"){
                    return redirect()->route('project.create')->with('error','The project number has been taken')->withInput();
                }elseif ($menu=="repair"){
                    return redirect()->route('project_repair.create')->with('error','The project number has been taken')->withInput();
                }
            }
        }
        try {
            $project = Project::findOrFail($id);
            $project->number = $request->number;
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
            if($menu == "building"){
                return redirect()->route('project.show', ['id' => $project->id])->with('success', 'Project Updated');
            }elseif($menu == "repair"){
                return redirect()->route('project_repair.show', ['id' => $project->id])->with('success', 'Project Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('project.edit', ['id' => $project->id])->with('error', $e->getMessage());
            }elseif($menu == "repair"){
                return redirect()->route('project_repair.edit', ['id' => $project->id])->with('error', $e->getMessage());
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

        
    // Project Cost Evaluation
    public function projectCE($id, Request $request){
        $modelWBS = WBS::where('project_id',$id)->where('wbs_id','!=',null)->get();
        $project = Project::findOrFail($id);
        $menu = $project->business_unit_id == "1" ? "building" : "repair";

        $planned = Collection::make();
        $materialEvaluation = Collection::make();

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

        $modelWBS = WBS::where('project_id',$id)->get();
        foreach($modelWBS as $wbs){
            if($wbs->bom){
                foreach($wbs->bom->bomDetails as $bomDetail){
                    if(count($bomDetail->material->materialRequisitionDetails)>0){
                        $status = 0;
                        foreach($materialEvaluation as $key => $data){
                            $material = $bomDetail->material->code.' - '.$bomDetail->material->name;
                            if($material == $data['material']){
                                $status = 1;
                                $quantity = $bomDetail->quantity + $data['quantity'];
                                $issued = $data['used'];
    
                                unset($materialEvaluation[$key]);
                                $material = $bomDetail->material->code.' - '.$bomDetail->material->name;
    
                                foreach ($bomDetail->material->materialRequisitionDetails as $mrd) {
                                    if ($mrd->wbs_id == $id) {
                                        $materialEvaluation->push([
                                            "material" => $material,
                                            "quantity" => $quantity,
                                            "used" => $issued + $mrd->issued,
                                        ]);
                                    }
                                }
                            }
                        }
                        if($status == 0){
                            foreach ($bomDetail->material->materialRequisitionDetails as $mrd) {
                                if ($mrd->wbs_id == $id) {
                                    $materialEvaluation->push([
                                        "material" => $bomDetail->material->code.' - '.$bomDetail->material->name,
                                        "quantity" => $bomDetail->quantity,
                                        "used" => $mrd->issued,
                                    ]);
                                }
                            }
                        }
                    }else{
                        $status = 0;
                        foreach($materialEvaluation as $key => $data){
                            $material = $bomDetail->material->code.' - '.$bomDetail->material->name;
                            if($material == $data['material']){
                                $status = 1;
                                $quantity = $bomDetail->quantity + $data['quantity'];
                                $issued = $data['used'];
    
                                unset($materialEvaluation[$key]);
    
                                $materialEvaluation->push([
                                    "material" => $bomDetail->material->code.' - '.$bomDetail->material->name,
                                    "quantity" => $quantity,
                                    "used" => $issued,
                                ]);
                            }
                        }
                        if($status == 0){
                            $materialEvaluation->push([
                                "material" => $bomDetail->material->code.' - '.$bomDetail->material->name,
                                "quantity" => $bomDetail->quantity,
                                "used" => 0,
                                ]);
                            }
                        }
                    }
                }
            }
            
        return view('project.showPCE', compact('modelWBS','project','actual','planned','materialEvaluation','menu'));
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

    function getEarliestActivity($wbs, $earliest_date){
        if($wbs){
            if(count($wbs->wbss)>0){
                foreach($wbs->wbss as $wbs_child){
                    if(count($wbs_child->activities)>0){
                        $activityRef = Activity::where('wbs_id',$wbs_child->id)->orderBy('planned_start_date','asc')->first();
                        $earliest_date_ref = $activityRef->planned_start_date;
                        if($earliest_date != null){
                            if($earliest_date > $earliest_date_ref){
                                $earliest_date = $earliest_date_ref;
                            }
                        }else{
                            $earliest_date = $earliest_date_ref;
                        }
                    }
                    return self::getEarliestActivity($wbs_child,$earliest_date);
                }
            }else{
                if(count($wbs->activities)>0){
                    $activityRef = Activity::where('wbs_id',$wbs->id)->orderBy('planned_start_date','asc')->first();
                    $earliest_date_ref = $activityRef->planned_start_date;
                    if($earliest_date != null){
                        if($earliest_date > $earliest_date_ref){
                            $earliest_date = $earliest_date_ref;
                        }
                    }else{
                        $earliest_date = $earliest_date_ref;
                    }
                }
                return $earliest_date;
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
                        "color" => "red"
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
                        "color" => "yellow"
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
                    ]);
                }
            }
        }

        foreach ($wbss as $wbs) {
            $earliest_date_ref = null;
            if(count($wbs->activities)>0){
                $activityRef = Activity::where('wbs_id',$wbs->id)->orderBy('planned_start_date','asc')->first();
                $earliest_date_ref = $activityRef->planned_start_date;
            }
            
            $earliest_date = self::getEarliestActivity($wbs,$earliest_date_ref);

            $start_date_wbs = $earliest_date != null ? date_create($earliest_date) : date_create($project->planned_start_date);
            $earlier = new DateTime($earliest_date);
            $later = new DateTime($wbs->planned_deadline);
            $duration = $later->diff($earlier)->format("%a");
            if($wbs->wbs){
                if($today>$wbs->planned_deadline){
                    if($wbs->progress != 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,
                            "parent" => $wbs->wbs->code,
                            "color" => "red"
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration, 
                            "parent" => $wbs->wbs->code, 
                            "color" => "green"
                        ]);
                    }
                }else if($today==$wbs->planned_deadline){
                    if($wbs->progress != 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,
                            "parent" => $wbs->wbs->code,
                            "color" => "yellow"
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration, 
                            "parent" => $wbs->wbs->code, 
                            "color" => "green"
                        ]);
                    }
                }else{
                    if($wbs->progress == 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,
                            "parent" => $wbs->wbs->code,
                            "color" => "green"
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,
                            "parent" => $wbs->wbs->code,  
                        ]);
                    }
                } 
            }else{
                if($today>$wbs->planned_deadline){
                    if($wbs->progress != 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,
                            "color" => "red"
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,  
                            "color" => "green"
                        ]);
                    }
                }else if($today==$wbs->planned_deadline){
                    if($wbs->progress != 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,
                            "color" => "yellow"
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,  
                            "color" => "green"
                        ]);
                    }
                }else{
                    if($wbs->progress == 100){
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,
                            "color" => "green"
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "text" => $wbs->name." | Weight : ".$wbs->weight."%",
                            "progress" => $wbs->progress / 100,
                            "start_date" =>  date_format($start_date_wbs,"d-m-Y"), 
                            "duration" => $duration,  
                        ]);
                    }
                } 
            }
        }
    }
    public function getDataChart($dataPlannedCost,$wbsChart,$modelMR,$dataActualCost, $project, $dataActualProgress,$dataPlannedProgress)
    {
        $sorted = $wbsChart->all();
        ksort($sorted);
        $plannedCost = 0;
        foreach($sorted as $date => $group){
            foreach($group as $wbs){
                if($wbs->bom){
                    if($wbs->bom->rap->total_price != 0){
                        $plannedCost += $wbs->bom->rap->total_price;
                        $dataPlannedCost->push([
                            "t" => $date, 
                            "y" => ($plannedCost/1000000)."",
                        ]);
                    }
                }
            }
            
        }

        $actualCost = 0;
        foreach($modelMR as $mr){
            $modelGI = $mr->goodsIssues->groupBy(function($date) {
                return $date->created_at->toDateString();
            });
            $sorted = $modelGI->all();
            ksort($sorted);
            foreach($sorted as $date => $group){
                foreach($group as $gi){
                    $gids = $gi->goodsIssueDetails;
                    foreach($gids as $gid){
                        $actualCost += $gid->material->cost_standard_price * $gid->quantity;
                    }
                }
                $dataActualCost->push([
                    "t" => $date, 
                    "y" => ($actualCost/1000000)."",
                ]);
            }
        }

        $actualProgress = 0;
        $plannedProgress = 0;
        $wbss = WBS::where('project_id', $project->id)->pluck('id')->toArray();
        $activities = Activity::whereIn('wbs_id',$wbss)->get();
        $actualActivities =$activities->where('actual_end_date', "!=", "")->groupBy('actual_end_date');
        $plannnedActivities = $activities->groupBy('planned_end_date');
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
            }else{
                $project =$activity->wbs->project->actual_start_date;
                if($project != null){
                    if(date('Y-m-d')>$activity->wbs->project->actual_start_date){
                        $dataActualProgress->push([
                            "t" => date('Y-m-d'), 
                            "y" => $actualProgress."",
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

    //API
    public function getDataGanttAPI($id){
        $project = Project::find($id);
        $today = date("Y-m-d");

        $data = Collection::make();
        $links = Collection::make();

        self::getDataForGantt($project, $data, $links, $today);

        $links->jsonSerialize();
        $data->jsonSerialize();


        return response(['data' => $data, 'links'=> $links], Response::HTTP_OK);
    
    }

    public function getDataJstreeAPI($id){
        $project = Project::find($id);
        $wbss = $project->wbss;
        $today = date("Y-m-d");

        $outstanding_item = Collection::make();

        $outstanding_item->push([
            "id" => $project->number , 
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);

        self::getOutstandingItem($wbss,$outstanding_item, $project,$today);


        return response($outstanding_item, Response::HTTP_OK);
    
    }

    public function getDataChartAPI($id){
        $project = Project::find($id);
        $wbss = $project->Wbss;
        //planned
        $dataPlannedCost = Collection::make();
        $modelBom = Bom::where('project_id',$id)->get();
        $wbsChart = $project->wbss->groupBy('planned_deadline');
        $dataPlannedCost->push([
            "t" => $project->planned_start_date, 
            "y" => "0",
        ]);
        
        //actual
        $dataActualCost = Collection::make();
        $modelMR = MaterialRequisition::where('project_id',$id)->get();
        if($project->actual_start_date != null){
            $dataActualCost->push([
                "t" => $project->actual_start_date, 
                "y" => "0",
            ]);
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
        self::getDataChart($dataPlannedCost,$wbsChart,$modelMR,$dataActualCost, $project, $dataActualProgress, $dataPlannedProgress);
        
        return response(['dataPlannedCost' => $dataPlannedCost, 'dataActualCost'=> $dataActualCost,
        'dataActualProgress'=> $dataActualProgress,'dataPlannedProgress'=> $dataPlannedProgress], Response::HTTP_OK);
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

    public function getActualStartDateAPI($id){
        $actual_start_date = Project::find($id)->actual_start_date;
        $originalDate = $actual_start_date;
        $newDate = date("d-m-Y", strtotime($originalDate));
        return response($newDate, Response::HTTP_OK);
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
