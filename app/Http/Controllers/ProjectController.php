<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Configuration;
use App\Models\Ship;
use App\Models\WBS;
use App\Models\ProductionOrder;
use App\Models\Activity;
use App\Models\Structure;
use App\Models\Category;
use App\Models\Resource;
use App\Models\ResourceTrx;
use App\Models\ResourceDetail;
use App\Models\BusinessUnit;
use App\Models\MaterialRequisition;
use App\Models\Bom;
use App\Models\BomDetail;
use App\Models\Material;
use App\Models\Service;
use App\Models\Cost;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use App\Models\Rap;
use App\Models\RapDetail;
use App\Models\Stock;
use App\Models\ProjectStandard;
use App\Models\WbsStandard;
use App\Models\ActivityStandard;
use App\Models\WbsMaterial;
use App\Models\MaterialStandard;
use App\Models\ResourceStandard;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use DB;
use DateTime;
use Auth;


class ProjectController extends Controller
{

    protected $pr;

    public function __construct(PurchaseRequisitionController $pr)
    {
        $this->pr = $pr;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function listWBS($id, $menu){
        $project = Project::find($id);
        $mainMenu = $project->business_unit_id == "1" ? "building" : "repair";
        $wbss = WBS::where('project_id',$id)->orderBy('planned_start_date','asc')->get();
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
                        "text" => $wbs->number." - ".$wbs->description." | Weight : (".$totalWeight."% / ".$wbs->weight."%)",
                        "start_date" => $wbs->planned_start_date,
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
                                    "start_date" => $activity->planned_start_date,
                                    "icon" => "fa fa-clock-o",
                                    "a_attr" =>  ["href" => "/activity/show/".$activity->id],
                                ]);
                            }else{
                                $dataWbs->push([
                                    "id" => $activity->code ,
                                    "parent" => $activity->wbs->code,
                                    "text" => $activity->name. " | Weight : ".$activity->weight."%",
                                    "start_date" => $activity->planned_start_date,
                                    "icon" => "fa fa-clock-o",
                                    "a_attr" =>  ["href" => "/activity_repair/show/".$activity->id],
                                ]);
                            }
                        }else{
                            $dataWbs->push([
                                "id" => $activity->code ,
                                "parent" => $activity->wbs->code,
                                "text" => $activity->name. " | Weight : ".$activity->weight."%",
                               "start_date" => $activity->planned_start_date,
                                "icon" => "fa fa-clock-o",
                            ]);
                        }
                    }
                }else{
                    $dataWbs->push([
                        "id" => $wbs->code ,
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                        "start_date" => $wbs->planned_start_date,
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
                                "start_date" => $activity->planned_start_date,
                                "icon" => "fa fa-clock-o",
                                "a_attr" =>  ["href" => "/activity/show/".$activity->id],
                        ]);
                        }else{
                            $dataWbs->push([
                                "id" => $activity->code ,
                                "parent" => $activity->wbs->code,
                                "text" => $activity->name. " | Weight : ".$activity->weight."%)",
                               "start_date" => $activity->planned_start_date,
                                "icon" => "fa fa-clock-o",
                            ]);
                        }
                    }
                }
                $totalWeight = $wbs->wbss->sum('weight') + $wbs->activities->sum('weight');

                $dataWbs->push([
                    "id" => $wbs->code ,
                    "parent" => $project->number,
                    "text" => $wbs->number." - ".$wbs->description." | Weight : (".$totalWeight."% / ".$wbs->weight."%)",
                    "start_date" => $wbs->planned_start_date,
                    "icon" => "fa fa-suitcase",
                    "a_attr" =>  ["href" => $route.$wbs->id],
                ]);
            }
        }

        $dataWbs = $dataWbs->toArray();
        // Asc sort
        // usort($dataWbs,function($first,$second){
        //     if ((strpos($first['id'], 'WBS') !== false || strpos($second['id'], 'WBS') !== false) &&
        //     (strpos($first['id'], 'ACT') !== false || strpos($second['id'], 'ACT') !== false)) {
        //         return $first['start_date'] > $second['start_date'];
        //     }
        // });

        return view('project.listWBS', compact('dataWbs','project','menu','menuTitle','mainMenu'));
    }

    public function copyProjectStructure($id, $newProject_id){
        $project = Project::find($id);
        $newProject = Project::find($newProject_id);
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

        foreach($wbss as $wbs){
            if($wbs->wbs){
                if(count($wbs->activities)>0){
                    $totalWeight = $wbs->wbss->sum('weight') + $wbs->activities->sum('weight');
                    $dataWbs->push([
                        "id" => $wbs->code ,
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->number." - ".$wbs->description." | Weight : (".$totalWeight."% / ".$wbs->weight."%",
                        "icon" => "fa fa-suitcase",
                    ]);
                    foreach($wbs->activities as $activity){
                        $dataWbs->push([
                            "id" => $activity->code ,
                            "parent" => $activity->wbs->code,
                            "text" => $activity->name. " | Weight : ".$activity->weight."%",
                            "icon" => "fa fa-clock-o",
                        ]);
                    }
                }else{
                    $dataWbs->push([
                        "id" => $wbs->code ,
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
                        "icon" => "fa fa-suitcase",
                    ]);
                }
            }else{
                if(count($wbs->activities)>0){
                    foreach($wbs->activities as $activity){
                        $dataWbs->push([
                            "id" => $activity->code ,
                            "parent" => $activity->wbs->code,
                            "text" => $activity->name. " | Weight : ".$activity->weight."%",
                            "icon" => "fa fa-clock-o",
                        ]);
                    }
                }
                $totalWeight = $wbs->wbss->sum('weight') + $wbs->activities->sum('weight');

                $dataWbs->push([
                    "id" => $wbs->code ,
                    "parent" => $project->number,
                    "text" => $wbs->number." - ".$wbs->description." | Weight : (".$totalWeight."% / ".$wbs->weight."%)",
                    "icon" => "fa fa-suitcase",
                ]);
            }
        }

        return view('project.copyProjectStructure', compact('dataWbs','project','mainMenu','newProject'));
    }

    public function selectStructure($project_standard_id, $project_id){
        $projectStandard = ProjectStandard::find($project_standard_id);
        $newProject = Project::find($project_id);
        $mainMenu = $newProject->business_unit_id == "1" ? "building" : "repair";
        $wbss = $projectStandard->wbss;
        $dataWbs = Collection::make();
        
        $totalWeightProject = $projectStandard->wbss->where('wbs_id',null)->sum('weight');
        $dataWbs->push([
            "id" => "PRO".$projectStandard->id,
            "parent" => "#",
            "text" => $projectStandard->name,
            "icon" => "fa fa-ship"
        ]);

        foreach($wbss as $wbs){
            if($wbs->wbs){
                // if(count($wbs->activities)>0){
                //     $dataWbs->push([
                //         "id" => "WBS".$wbs->id,
                //         "parent" => "WBS".$wbs->wbs->id,
                //         "text" => $wbs->number." - ".$wbs->description,
                //         "icon" => "fa fa-suitcase",
                //     ]);
                //     // foreach($wbs->activities as $activity){
                //     //     $dataWbs->push([
                //     //         "id" => "ACT".$activity->id,
                //     //         "parent" => "WBS".$activity->wbs->id,
                //     //         "text" => $activity->name,
                //     //         "icon" => "fa fa-clock-o",
                //     //     ]);
                //     // }
                // }else{
                    $dataWbs->push([
                        "id" => "WBS".$wbs->id,
                        "parent" => "WBS".$wbs->wbs->id,
                        "text" => $wbs->number." - ".$wbs->description,
                        "icon" => "fa fa-suitcase",
                    ]);
                // }
            }else{
                // if(count($wbs->activities)>0){
                //     foreach($wbs->activities as $activity){
                //         $dataWbs->push([
                //             "id" => "ACT".$activity->id,
                //             "parent" => "WBS".$activity->wbs->id,
                //             "text" => $activity->name,
                //             "icon" => "fa fa-clock-o",
                //         ]);
                //     }
                // }

                $dataWbs->push([
                    "id" => "WBS".$wbs->id,
                    "parent" => "PRO".$projectStandard->id,
                    "text" => $wbs->number." - ".$wbs->description,
                    "icon" => "fa fa-suitcase",
                ]);
            }
        }

        return view('project.selectStructure', compact('dataWbs','projectStandard','mainMenu','newProject'));
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

// public function index(Request $request)
// {
//     $projects = Project::orderBy('planned_start_date', 'asc')->get();
//     return view('project.index', compact('projects','menu'));
// }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $customers = Customer::all();
        $ships = Ship::all();
        $projectType = Configuration::get('project_type');
        // $project_code = self::generateProjectCode();
        $project = new Project;
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";
        $sales_orders = SalesOrder::where('status',1)->get();

        if($menu == "building"){
            return view('project.create', compact('customers','ships','project','menu','projectType','sales_orders'));
        }else{
            return view('project.createRepair', compact('customers','ships','project','menu','projectType','sales_orders'));
        }
    }
// public function create(Request $request)
// {
//     $customers = Customer::all();
//     $ships = Ship::all();
//     $projectType = Configuration::get('project_type');
//     $project = new Project;
//     return view('project.create', compact('customers','ships','project','menu','projectType'));
// }

    public function indexCopyProject(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";
        if($menu=="repair"){
            $projects = Project::orderBy('planned_start_date', 'asc')->where('business_unit_id', 2)->get();
        }else if($menu == "building"){
            $projects = Project::orderBy('planned_start_date', 'asc')->where('business_unit_id', 1)->get();
        }

        return view('project.indexCopyProject', compact('projects','menu'));
    }

    public function copyProject(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $customers = Customer::all();
        $ships = Ship::all();
        $projectType = Configuration::get('project_type');
        $menu = $project->business_unit_id == "1" ? "building" : "repair";


        return view('project.copyProjectInfo', compact('project','customers','ships','menu','projectType'));
    }
    public function storeCopyProjectStructure(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";
        $datas = json_decode($request->structures);
        $project_id = $request->project_id;
        $old_project_id = $request->old_project_id;
        $new_project_ref = Project::find($project_id);
        $old_project_ref = Project::find($old_project_id);

        $new_project_planned_start_date = date_create($new_project_ref->planned_end_date);
        $old_project_planned_start_date = date_create($old_project_ref->planned_end_date);
        $diff=date_diff($new_project_planned_start_date,$old_project_planned_start_date)->days;
        // dd($new_project_planned_start_date,$old_project_planned_start_date);
        $actIdConverter = [];
        $wbsIdConverter = [];

        DB::beginTransaction();
        try {
            foreach ($datas as $dataTree) {
                if(strpos($dataTree->id, 'WBS') !== false) {
                    $wbs_ref = WBS::where('code', $dataTree->id)->first();
                    $wbs = new WBS;
                    $wbs->number = $wbs_ref->number;
                    $wbs->description = $wbs_ref->description;
                    $wbs->deliverables = $wbs_ref->deliverables;
                    $wbs->weight = $wbs_ref->weight;

                    $date = date($wbs_ref->planned_start_date);
                    $date = strtotime($diff." day",strtotime($date));
                    $wbs->planned_start_date = date("Y-m-d",$date);

                    $date = date($wbs_ref->planned_end_date);
                    $date = strtotime($diff." day",strtotime($date));
                    $wbs->planned_end_date = date("Y-m-d",$date);
                    $wbs->planned_duration = $wbs_ref->planned_duration;

                    $wbs->code = self::generateWbsCode($project_id);
                    if(isset($wbsIdConverter[$dataTree->parent])){
                        $wbs->wbs_id = $wbsIdConverter[$dataTree->parent];
                    }
                    $wbs->project_id = $project_id;
                    $wbs->user_id = Auth::user()->id;
                    $wbs->branch_id = Auth::user()->branch->id;
                    $wbs->save();
                    $wbsIdConverter[$dataTree->id] = $wbs->id;
                    $bom_ref = Bom::where('wbs_id', $wbs_ref->id)->first();
                    if($bom_ref != null){
                        $bom = new Bom;
                        $bom = $bom_ref->replicate();
                        $bom->code = self::generateBomCode($project_id);
                        $bom->wbs_id = $wbs->id;
                        $bom->project_id = $project_id;
                        $bom->user_id = Auth::user()->id;
                        $bom->branch_id = Auth::user()->branch->id;
                        $bom->save();

                        foreach ($bom_ref->bomDetails as $bomD) {
                            $bom_detail = new BomDetail;
                            $bom_detail = $bomD->replicate();
                            $bom_detail->bom_id = $bom->id;
                            $bom_detail->save();
                        }
                    }

                    $resource_ref = ResourceTrx::where('wbs_id', $wbs_ref->id)->get();
                    if(count($resource_ref) > 0){
                        foreach ($resource_ref as $resource) {
                            $resource_input = new ResourceTrx;
                            $resource_input = $resource->replicate();
                            $resource_input->wbs_id = $wbs->id;
                            $resource_input->project_id = $project_id;
                            $resource_input->user_id = Auth::user()->id;
                            $resource_input->branch_id = Auth::user()->branch->id;
                            $resource_input->save();
                        }
                    }
                }elseif(strpos($dataTree->id, 'ACT') !== false){
                    $act_ref = Activity::where('code', $dataTree->id)->first();
                    $act = new Activity;
                    $act->name = $act_ref->name;
                    $act->description = $act_ref->description;
                    $date = date($act_ref->planned_start_date);
                    $date = strtotime($diff." day",strtotime($date));
                    $act->planned_start_date = date("Y-m-d",$date);

                    $date = date($act_ref->planned_end_date);
                    $date = strtotime($diff." day",strtotime($date));
                    $act->planned_end_date = date("Y-m-d",$date);
                    $act->planned_duration = $act_ref->planned_duration;
                    $act->weight = $act_ref->weight;

                    if(isset($wbsIdConverter[$dataTree->parent])){
                        $act->code = self::generateActivityCode($wbsIdConverter[$dataTree->parent]);
                        $act->wbs_id = $wbsIdConverter[$dataTree->parent];
                    }
                    $act->user_id = Auth::user()->id;
                    $act->branch_id = Auth::user()->branch->id;
                    if($act_ref->predecessor != null){
                        $predecessor = json_decode($act_ref->predecessor);
                        foreach($predecessor as $key => $id){
                            $temp_array = [];
                            array_push($temp_array, $actIdConverter[$id[0]]);
                            array_push($temp_array, $id[1]);

                            $predecessor[$key] = $temp_array;
                        }
                        $act->predecessor = json_encode($predecessor);
                    }
                    $act->save();

                    $actIdConverter[$act_ref->id] = $act->id;

                }
            }
            DB::commit();

            if($menu == "building"){
                return redirect()->route('project.show', ['id' => $request->project_id])->with('success', 'Project Created');
            }elseif($menu == "repair"){
                return redirect()->route('project_repair.show', ['id' => $request->project_id])->with('success', 'Project Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('project.copyProjectStructure', ['old_id' => $request->old_project_id,'new_id' => $request->project_id])->with('error', "Please Try Again, ".$e->getMessage());
            }elseif($menu == "repair"){
                return redirect()->route('project_repair.copyProjectStructure', ['old_id' => $request->old_project_id,'new_id' => $request->project_id])->with('error', "Please Try Again, ".$e->getMessage());
            }
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
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";

        if($menu == "building"){
            $this->validate($request, [
                'number' => 'required',
                'customer' => 'required',
                'ship' => 'required',
                'project_type' => 'required',
                // 'planned_start_date' => 'required',
                // 'planned_end_date' => 'required',
                // 'planned_duration' => 'required',
                'flag' => 'required',
                'class_name' => 'required',
                'class_contact_person_email' => 'nullable|email|max:255',
                'class_contact_person_email_2' => 'nullable|email|max:255',
                'drawing' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3000'
            ]);
        }elseif($menu == "repair"){
            $this->validate($request, [
                'number' => 'required',
                'customer' => 'required',
                'ship' => 'required',
                'project_type' => 'required',
                'planned_start_date' => 'required',
                'planned_end_date' => 'required',
                'planned_duration' => 'required',
                'drawing' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3000'
            ]);
        }
        $projects = Project::all();
        foreach ($projects as $project) {
            if($project->name == $request->name){
                if($menu == "building"){
                    if($request->name != null){
                        return redirect()->route('project.create')->with('error','The project name has been taken')->withInput();
                    }
                }else{
                    if($request->name != null){
                        return redirect()->route('project_repair.create')->with('error','The project name has been taken')->withInput();
                    }
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
            $project->budget_value = $request->budget_value_int;
            $project->ship_id = $request->ship;
            $project->project_type = $request->project_type;
            $project->flag = $request->flag;
            $project->hull_number = $request->hull_number;
            $project->class_name = $request->class_name;
            $project->class_name_2 = $request->class_name_2;
            $project->person_in_charge = $request->person_in_charge;
            $project->class_contact_person_name = $request->class_contact_person_name;
            $project->class_contact_person_name_2 = $request->class_contact_person_name_2;
            $project->class_contact_person_phone = $request->class_contact_person_phone;
            $project->class_contact_person_phone_2 = $request->class_contact_person_phone_2;
            $project->class_contact_person_email = $request->class_contact_person_email;
            $project->class_contact_person_email_2 = $request->class_contact_person_email_2;
            $project->sales_order_id = $request->sales_order_id;

            $planStartDate = DateTime::createFromFormat('m/j/Y', $request->planned_start_date);
            $planEndDate = DateTime::createFromFormat('m/j/Y', $request->planned_end_date);

            if($planStartDate){
                $project->planned_start_date = $planStartDate->format('Y-m-d');
            }else{
                $project->planned_start_date = null;
            }
            if($planEndDate){
                $project->planned_end_date = $planEndDate->format('Y-m-d');
            }else{
                $project->planned_end_date = null;
            }
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

            // update status SO
            if($request->sales_order_id != null && $request->sales_order_id != ""){
                $so = SalesOrder::findOrFail($request->sales_order_id);
                $so->status = 0;
                $so->update();

                $customer = Customer::findOrFail($so->customer_id);
                $customer->used_limit += $so->total_price;
                $customer->update();
            }
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

    public function storeGeneralInfo(Request $request)
    {
        $this->validate($request, [
            'number' => 'required',
            'customer' => 'required',
            'ship' => 'required',
            'project_type' => 'required',
            'planned_start_date' => 'required',
            'planned_end_date' => 'required',
            'arrival_date' => 'required',
            'planned_duration' => 'required',
            'drawing' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3000'
        ]);
        $projects = Project::all();
        foreach ($projects as $project) {
            if($project->name == $request->name){
                if($request->name != null){
                    return redirect()->route('project_repair.create')->with('error','The project name has been taken')->withInput();
                }
            }
            if($project->number == $request->number){
                return redirect()->route('project_repair.create')->with('error','The project number has been taken')->withInput();
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
            $project->budget_value = $request->budget_value_int;
            $project->ship_id = $request->ship;
            $project->project_standard_id = $request->project_standard;
            $project->project_type = $request->project_type;
            $project->person_in_charge = $request->person_in_charge;

            $planStartDate = DateTime::createFromFormat('m/j/Y', $request->planned_start_date);
            $planEndDate = DateTime::createFromFormat('m/j/Y', $request->planned_end_date);
            $arrivalDate = DateTime::createFromFormat('m/j/Y', $request->arrival_date);

            if($planStartDate){
                $project->planned_start_date = $planStartDate->format('Y-m-d');
            }else{
                $project->planned_start_date = null;
            }
            if($planEndDate){
                $project->planned_end_date = $planEndDate->format('Y-m-d');
            }else{
                $project->planned_end_date = null;
            }
            if($arrivalDate){
                $project->arrival_date = $arrivalDate->format('Y-m-d');
            }else{
                $project->arrival_date = null;
            }
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
            return redirect()->route('project_repair.selectStructure', ['project_standard_id' => $request->project_standard,'project_id' => $project->id])->with('success', 'Project Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project_repair.create')->with( 'error',$e->getMessage())->withInput();
        }
    }

    public function storeSelectedStructure(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";
        $datas = json_decode($request->structures);
        $project_id = $request->project_id;
        $project_ref = Project::find($project_id);

        $wbsIdConverter = [];

        DB::beginTransaction();
        try {
            foreach ($datas as $dataTree) {
                if(strpos($dataTree, 'WBS') !== false) {
                    $wbs_standard_id = str_replace("WBS", "", $dataTree);
                    $wbs_standard = WbsStandard::find($wbs_standard_id);

                    $wbs = new WBS;
                    $wbs->number = $wbs_standard->number;
                    $wbs->description = $wbs_standard->description;
                    $wbs->deliverables = $wbs_standard->deliverables;
                    $wbs->planned_duration = $wbs_standard->duration;
                    $wbs->wbs_standard_id = $wbs_standard_id;

                    $wbs->code = self::generateWbsCode($project_id);
                    if(isset($wbsIdConverter[$wbs_standard->wbs_id])){
                        $wbs->wbs_id = $wbsIdConverter[$wbs_standard->wbs_id];
                    }
                    $wbs->project_id = $project_id;
                    $wbs->user_id = Auth::user()->id;
                    $wbs->branch_id = Auth::user()->branch->id;
                    $wbs->save();
                    $wbsIdConverter[$wbs_standard_id] = $wbs->id;
                    $materialStandards = MaterialStandard::where('wbs_standard_id', $wbs_standard->id)->get();
                    if(count($materialStandards) > 0){
                        foreach ($materialStandards as $materialStandard) {
                            if(count($materialStandard->partDetails) > 0){
                                foreach ($materialStandard->partDetails as $part) {
                                    $wbs_material = new WbsMaterial;
                                    $wbs_material->wbs_id = $wbs->id;
                                    $wbs_material->part_description = $part->description;
                                    $wbs_material->material_id = $part->materialStandard->material_id;
                                    $wbs_material->quantity = $part->quantity;
                                    $wbs_material->dimensions_value = $part->dimensions_value;
                                    $wbs_material->weight = $part->weight;
                                    $wbs_material->save();

                                    $activity = new Activity;
                                    $activity->code = self::generateActivityCode($wbs->id);
                                    $activity->name = $part->description;
                                    $activity->type = "General";
                                    $activity->description = $part->description;
                                    $activity->wbs_id = $wbs->id;

                                    if($part->service_id!=null){
                                        $activity->service_id = $part->service_id;
                                    }

                                    if($part->service_detail_id!=null){
                                        $activity->service_detail_id = $part->service_detail_id;
                                    }
                                    
                                    $activity->wbs_material_id = $wbs_material->id;
                                    $activity->user_id = Auth::user()->id;
                                    $activity->branch_id = Auth::user()->branch->id;
                                    $activity->save();
                                }
                            }else{
                                $wbs_material = new WbsMaterial;
                                $wbs_material->wbs_id = $wbs->id;
                                $wbs_material->material_id = $materialStandard->material_id;
                                $wbs_material->quantity = $materialStandard->quantity;
                                $wbs_material->save();
                            }
                        }
                    }

                    $resourceStandards = ResourceStandard::where('wbs_standard_id', $wbs_standard->id)->get();
                    if(count($resourceStandards) > 0){
                        foreach ($resourceStandards as $resource) {
                            $resource_input = new ResourceTrx;
                            $resource_input->resource_id = $resource->resource_id;
                            $resource_input->wbs_id = $wbs->id;
                            $resource_input->project_id = $project_id;
                            $resource_input->quantity = $resource->quantity;
                            $resource_input->user_id = Auth::user()->id;
                            $resource_input->branch_id = Auth::user()->branch->id;
                            $resource_input->save();
                        }
                    }
                }
                // elseif(strpos($dataTree, 'ACT') !== false){
                //     $act_standard_id = str_replace("ACT", "", $dataTree);
                //     $act_standard = ActivityStandard::find($act_standard_id);
                //     $act = new Activity;
                //     $act->name = $act_standard->name;
                //     $act->description = $act_standard->description;
                //     $act->planned_duration = $act_standard->duration;
                //     $act->activity_standard_id = $act_standard_id;

                //     if(isset($wbsIdConverter[$act_standard->wbs_id])){
                //         $act->code = self::generateActivityCode($wbsIdConverter[$act_standard->wbs_id]);
                //         $act->wbs_id = $wbsIdConverter[$act_standard->wbs_id];
                //     }
                //     $act->user_id = Auth::user()->id;
                //     $act->branch_id = Auth::user()->branch->id;
                //     $act->save();
                // }
            }
            DB::commit();

            return redirect()->route('project_repair.show', ['id' => $request->project_id])->with('success', 'Project Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project_repair.selectStructure', ['project_standard_id' => $request->project_standard_id,'project_id' => $project_id])->with('error', "Please Try Again, ".$e->getMessage());
        }

    }
// public function store(Request $request)
// {
//     $this->validate($request, [
//         'number' => 'required',
//         'customer' => 'required',
//         'ship' => 'required',
//         'project_type' => 'required',
//         'planned_start_date' => 'required',
//         'planned_end_date' => 'required',
//         'planned_duration' => 'required',
//         'drawing' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3000'
//     ]);
//     $projects = Project::all();
//     foreach ($projects as $project) {
//         if($project->number == $request->number){
//             return redirect()->route('project_repair.create')->with('error','The project number has been taken')->withInput();
//         }
//     }

//     DB::beginTransaction();
//     $modelProject = Project::orderBy('id','desc')->whereYear('created_at', '=', date('Y'))->first();
//     try {
//         $project = new Project;
//         $project->number =  $request->number;
//         $project->project_sequence = $modelProject != null ? $modelProject->project_sequence + 1 : 1;
//         $project->name = $request->name;
//         $project->description = $request->description;
//         $project->customer_id = $request->customer;
//         $project->ship_id = $request->ship;
//         $project->project_type = $request->project_type;
//         $project->flag = $request->flag;
//         $project->class_name = $request->class_name;
//         $project->person_in_charge = $request->person_in_charge;
//         $project->class_contact_person_name = $request->class_contact_person_name;
//         $project->class_contact_person_phone = $request->class_contact_person_phone;
//         $project->class_contact_person_email = $request->class_contact_person_email;

//         $planStartDate = DateTime::createFromFormat('m/j/Y', $request->planned_start_date);
//         $planEndDate = DateTime::createFromFormat('m/j/Y', $request->planned_end_date);

//         $project->planned_start_date = $planStartDate->format('Y-m-d');
//         $project->planned_end_date = $planEndDate->format('Y-m-d');
//         $project->planned_duration =  $request->planned_duration;
//         $project->progress = 0;
//         $project->business_unit_id = $request->business_unit_id;
//         $project->user_id = Auth::user()->id;
//         $project->branch_id = Auth::user()->branch->id;

//         if($request->hasFile('drawing')){
//             // Get filename with the extension
//             $fileNameWithExt = $request->file('drawing')->getClientOriginalName();
//             // Get just file name
//             $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
//             // Get just ext
//             $extension = $request->file('drawing')->getClientOriginalExtension();
//             // File name to store
//             $fileNameToStore = $fileName.'_'.time().'.'.$extension;
//             // Upload image
//             $path = $request->file('drawing')->storeAs('documents/project',$fileNameToStore);
//         }else{
//             $fileNameToStore =  null;
//         }
//         $project->drawing = $fileNameToStore;
//         $project->save();


//         DB::commit();
//         return redirect()->route('project_repair.show', ['id' => $project->id])->with('success', 'Project Created');
//     } catch (\Exception $e) {
//         DB::rollback();
//         return redirect()->route('project_repair.create')->with( 'error',$e->getMessage())->withInput();
//     }
// }

    public function storeCopyProject(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";
        if($menu == "building"){
            $this->validate($request, [
                'number' => 'required',
                'customer' => 'required',
                'ship' => 'required',
                'project_type' => 'required',
                // 'planned_start_date' => 'required',
                // 'planned_end_date' => 'required',
                // 'planned_duration' => 'required',
                'flag' => 'required',
                'class_name' => 'required'
            ]);
        }elseif($menu == "repair"){
            $this->validate($request, [
                'number' => 'required',
                'customer' => 'required',
                'ship' => 'required',
                'project_type' => 'required',
                'planned_start_date' => 'required',
                'planned_end_date' => 'required',
                'planned_duration' => 'required',
            ]);
        }
        $projects = Project::all();
        foreach ($projects as $project) {
            if($project->number == $request->number){
                if($menu == "building"){
                    return redirect()->route('project.copyProject',$request->project_ref)->with('error','The project number has been taken')->withInput();
                }else{
                    return redirect()->route('project_repair.copyProject',$request->project_ref)->with('error','The project number has been taken')->withInput();
                }
            }
        }

        DB::beginTransaction();
        $modelProject = Project::orderBy('id','desc')->whereYear('created_at', '=', date('Y'))->first();
        try {
            $project = new Project;
            $project->number =  $request->number;
            $project->person_in_charge = $request->person_in_charge;
            $project->project_sequence = $modelProject != null ? $modelProject->project_sequence + 1 : 1;
            $project->name = $request->name;
            $project->description = $request->description;
            $project->customer_id = $request->customer;
            $project->budget_value = $request->budget_value;
            $project->ship_id = $request->ship;
            $project->project_type = $request->project_type;
            $project->flag = $request->flag;
            $project->hull_number = $request->hull_number;
            $project->class_name = $request->class_name;
            $project->class_name_2 = $request->class_name_2;
            $project->person_in_charge = $request->person_in_charge;
            $project->class_contact_person_name = $request->class_contact_person_name;
            $project->class_contact_person_name_2 = $request->class_contact_person_name_2;
            $project->class_contact_person_phone = $request->class_contact_person_phone;
            $project->class_contact_person_phone_2 = $request->class_contact_person_phone_2;
            $project->class_contact_person_email = $request->class_contact_person_email;
            $project->class_contact_person_email_2 = $request->class_contact_person_email_2;

            $planStartDate = DateTime::createFromFormat('m/j/Y', $request->planned_start_date);
            $planEndDate = DateTime::createFromFormat('m/j/Y', $request->planned_end_date);

            if($planStartDate){
                $project->planned_start_date = $planStartDate->format('Y-m-d');
            }else{
                $project->planned_start_date = null;
            }
            if($planEndDate){
                $project->planned_end_date = $planEndDate->format('Y-m-d');
            }else{
                $project->planned_end_date = null;
            }
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
                return redirect()->route('project.copyProjectStructure', ['old_id' => $request->project_ref,'new_id' => $project->id])->with('success', 'Project Created');
            }elseif($menu == "repair"){
                return redirect()->route('project_repair.copyProjectStructure', ['old_id' => $request->project_ref,'new_id' => $project->id])->with('success', 'Project Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('project.copyProject',$request->project_ref)->with( 'error',$e->getMessage())->withInput();
            }elseif($menu == "repair"){
                return redirect()->route('project_repair.copyProject',$request->project_ref)->with( 'error',$e->getMessage())->withInput();
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
        $is_pami = false;
        $business_ids = Auth::user()->business_unit_id;
        if (in_array("2", json_decode($business_ids))) {
            $is_pami = true;
        }
        //planned
        $dataPlannedCost = Collection::make();
        $modelBom = Bom::where('project_id',$id)->get();
        if($menu == "building"){
            $objectDate = $project->wbss->groupBy('planned_start_date');
        }else{
            $wbss_id = $project->wbss->pluck('id')->toArray();
            $objectDate = Activity::whereIn('wbs_id',$wbss_id)->get()->groupBy('planned_start_date');
        }
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

        //evm
        $dataEvm = Collection::make();
        if($project->actual_start_date != null){
            $dataEvm->push([
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
        self::getDataChart($dataPlannedCost,$objectDate,$modelMR,$dataActualCost, $project, $dataActualProgress, $dataPlannedProgress, $menu, $dataEvm);
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
        $dataPlannedCost->jsonSerialize();
        $dataActualCost->jsonSerialize();
        $dataActualProgress->jsonSerialize();
        $dataPlannedProgress->jsonSerialize();

        $activities = [];
        if($menu == "building"){
            $wbss = WBS::where('project_id', $project->id)->with('bom.purchaseRequisition.purchaseOrders.vendor',
            'bom.purchaseRequisition.purchaseOrders.goodsReceipts.purchaseOrder','productionOrder',
            'materialRequisitionDetails.material_requisition.goodsIssues.materialRequisition')->get();
        }else{
            $wbs_id = WBS::where('project_id', $project->id)->pluck('id')->toArray();
            if(count($wbs_id)>0){
                $activities = Activity::whereIn("wbs_id",$wbs_id)->
                // with('activityDetails.bomPrep.bomDetails.bom.purchaseRequisition.purchaseOrders.vendor',
                // 'activityDetails.bomPrep.bomDetails.bom.purchaseRequisition.purchaseOrders.goodsReceipts.purchaseOrder',
                // 'wbs.productionOrder.goodsReceipts.goodsReceiptDetails','wbs.materialRequisitionDetails.material_requisition.goodsIssues.materialRequisition')->
                get();
            }
        }
        $modelPrO = productionOrder::where('project_id',$project->id)->where('status',0)->get();

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
        return view('project.show', compact('activities','wbss','project','today','ganttData','links','is_pami',
        'outstanding_item','modelPrO','menu','dataPlannedCost','dataActualCost','project_done',
        'dataActualProgress','dataPlannedProgress', 'progressStatus','str_expected_date','expectedStatus','dataEvm'));
    }


    public function showGanttChart($id, Request $request)
    {
        $today = date("Y-m-d");
        $project = Project::find($id);
        $wbss = $project->wbss;
        $menu = $project->business_unit_id == "1" ? "building" : "repair";

        $data = Collection::make();
        $links = Collection::make();


        self::getDataForGantt($project, $data, $links, $today);

        $links->jsonSerialize();
        $data->jsonSerialize();
        return view('project.ganttChart', compact('project','data','links','today','menu','wbss'));
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
        $projectType = Configuration::get('project_type');
        if($project->sales_order_id != null && $project->sales_order_id != ""){
            $sales_orders = SalesOrder::where('status',1)->orWhere('id', $project->sales_order_id)->get();
        }else{
            $sales_orders = SalesOrder::where('status',1)->get();
        }
        $menu = $project->business_unit_id == "1" ? "building" : "repair";

        return view('project.create', compact('project','projectType','customers','ships','menu','sales_orders'));
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
                'class_name' => 'required',
                'class_contact_person_email' => 'nullable|email|max:255'

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
                    return redirect()->route('project.edit',$id)->with('error','The project name has been taken')->withInput();
                }else{
                    if($request->name != null){
                        return redirect()->route('project_repair.edit',$id)->with('error','The project name has been taken')->withInput();
                    }
                }
            }
            if($project->number == $request->number){
                if($menu == "building"){
                    return redirect()->route('project.edit',$id)->with('error','The project number has been taken')->withInput();
                }elseif ($menu=="repair"){
                    return redirect()->route('project_repair.edit',$id)->with('error','The project number has been taken')->withInput();
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
            $project->budget_value = $request->budget_value != null ? str_replace(",", "", $request->budget_value) : null;
            $project->flag = $request->flag;
            $project->class_name = $request->class_name;
            $project->person_in_charge = $request->person_in_charge;
            $project->class_contact_person_name = $request->class_contact_person_name;
            $project->class_contact_person_phone = $request->class_contact_person_phone;
            $project->class_contact_person_email = $request->class_contact_person_email;
            if($project->sales_order_id != null){
                if($project->sales_order_id != $request->sales_order_id){
                    // update status SO lama
                    $so = SalesOrder::findOrFail($project->sales_order_id);
                    $so->status = 1;
                    $so->update();

                    if($request->sales_order_id == null){
                        $customer = Customer::findOrFail($so->customer_id);
                        $customer->used_limit -= $so->total_price;
                        $customer->update();
                    }else{
                        $newSo = SalesOrder::findOrFail($request->sales_order_id);
                        if($newSo){
                            if($so->customer_id != $newSo->customer_id){
                                $customer = Customer::findOrFail($so->customer_id);
                                $customer->used_limit -= $so->total_price;
                                $customer->update();
    
                                $newCustomer = Customer::findOrFail($newSo->customer_id);
                                $newCustomer->used_limit += $newSo->total_price;
                                $newCustomer->update();
                            }
                        }else{
                            $customer = Customer::findOrFail($so->customer_id);
                            $customer->used_limit -= $so->total_price;
                            $customer->update();
                        }
                    }
                }
                $project->sales_order_id = $request->sales_order_id;
            }else{
                if($request->sales_order_id != null && $request->sales_order_id != ""){
                    $project->sales_order_id = $request->sales_order_id;
    
                    $so = SalesOrder::findOrFail($request->sales_order_id);
                    $customer = Customer::findOrFail($so->customer_id);
                    $customer->used_limit += $so->total_price;
                    $customer->update();
                }
            }

            $planStartDate = DateTime::createFromFormat('m/j/Y', $request->planned_start_date);
            $planEndDate = DateTime::createFromFormat('m/j/Y', $request->planned_end_date);

            $project->planned_start_date = $planStartDate->format('Y-m-d');
            $project->planned_end_date = $planEndDate->format('Y-m-d');
            $project->planned_duration =  $request->planned_duration;
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

            // update status SO
            if($request->sales_order_id != null && $request->sales_order_id != ""){
                $so = SalesOrder::findOrFail($request->sales_order_id);
                $so->status = 0;
                $so->update();
            }
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

        $is_pami = false;
        $business_ids = Auth::user()->business_unit_id;
        if (in_array("2", json_decode($business_ids))) {
            $is_pami = true;
        }

        $actual = Collection::make();
        foreach($project->wbss as $wbs){
            $actualCostPerWbs = 0;
            $plannedCostPerWbs = $wbs->bom != null ? $wbs->bom->rap != null ? $wbs->bom->rap->total_price : 0 : 0;

            foreach($wbs->materialRequisitionDetails as $mrd){
                $actualCostPerWbs += $mrd->material->cost_standard_price * $mrd->issued;
            }

            $planned->put($wbs->id,[
                "wbs_number" => $wbs->number." - ".$wbs->description,
                "cost" => $plannedCostPerWbs,
            ]);

            $actual->push([
                "wbs_id" => $wbs->id,
                "wbs_number" => $wbs->number." - ".$wbs->description,
                "cost" => $actualCostPerWbs,
            ]);
        }

        $modelWBS = WBS::where('project_id',$id)->get();
        foreach($modelWBS as $wbs){
            if($wbs->bom){
                foreach($wbs->bom->bomDetails as $bomDetail){
                    if($bomDetail->material){
                        if(count($bomDetail->material->materialRequisitionDetails)>0){
                            $status = 0;
                                foreach($materialEvaluation as $key => $data){
                                    $material = $bomDetail->material->code.' - '.$bomDetail->material->description;
                                    if($material == $data['material']){
                                        $status = 1;
                                        $quantity = $bomDetail->quantity + $data['quantity'];
                                        $issued = $data['used'];

                                        unset($materialEvaluation[$key]);
                                        $material = $bomDetail->material->code.' - '.$bomDetail->material->description;

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
                                        "material" => $bomDetail->material->code.' - '.$bomDetail->material->description,
                                        "quantity" => $bomDetail->quantity,
                                        "used" => $mrd->issued,
                                    ]);
                                }
                            }
                        }
                    }else{
                        $status = 0;
                        foreach($materialEvaluation as $key => $data){
                            $material = $bomDetail->material->code.' - '.$bomDetail->material->description;
                            if($material == $data['material']){
                                $status = 1;
                                $quantity = $bomDetail->quantity + $data['quantity'];
                                $issued = $data['used'];

                                unset($materialEvaluation[$key]);

                                $materialEvaluation->push([
                                    "material" => $bomDetail->material->code.' - '.$bomDetail->material->description,
                                    "quantity" => $quantity,
                                    "used" => $issued,
                                ]);
                            }
                        }
                        if($status == 0){
                            $materialEvaluation->push([
                                "material" => $bomDetail->material->code.' - '.$bomDetail->material->description,
                                "quantity" => $bomDetail->quantity,
                                "used" => 0,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return view('project.showPCE', compact('modelWBS','project','actual','planned','materialEvaluation','menu','is_pami'));
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

    public function generateWbsCode($id){
        $code = 'WBS';
        $project = Project::find($id);
        $projectSequence = $project->project_sequence;
        $businessUnit = $project->business_unit_id;
        $year = $project->created_at->year % 100;

        $modelWbs = WBS::orderBy('code', 'desc')->where('project_id', $id)->first();

        $number = 1;
		if(isset($modelWbs)){
            $number += intval(substr($modelWbs->code, -4));
		}

        $wbs_code = $code.sprintf('%02d', $year).sprintf('%01d', $businessUnit).sprintf('%02d', $projectSequence).sprintf('%04d', $number);
		return $wbs_code;
    }

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

    private function generateBomCode($project_id){
        $code = 'BOM';
        $project = Project::find($project_id);
        $projectSequence = $project->project_sequence;
        $year = $project->created_at->year % 100;

        $modelBom = Bom::orderBy('code', 'desc')->where('project_id', $project_id)->first();

        $number = 1;
		if(isset($modelBom)){
            $number += intval(substr($modelBom->code, -4));
		}

        $bom_code = $code.sprintf('%02d', $year).sprintf('%02d', $projectSequence).sprintf('%04d', $number);
		return $bom_code;
    }

    private function generateRapNumber(){
        $modelRap = Rap::orderBy('number','desc')->first();
        $yearNow = date('y');
        $number = 1;
        if(isset($modelRap)){
            $yearDoc = substr($modelRap->number, 4,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelRap->number, -5));
            }
        }
        $year = date($yearNow.'00000');
        $year = intval($year);

		$rap_number = $year+$number;
        $rap_number = 'RAP-'.$rap_number;

		return $rap_number;
    }

    public function createRap($project_id,$bom){
        $rap_number = self::generateRapNumber();
        $rap = new Rap;
        $rap->number = $rap_number;
        $rap->project_id = $project_id;
        $rap->bom_id = $bom->id;
        $rap->user_id = Auth::user()->id;
        $rap->branch_id = Auth::user()->branch->id;
        $rap->save();
        self::saveRapDetail($rap->id,$bom->bomDetails);
        $total_price = self::calculateTotalPrice($rap->id);

        $modelRap = Rap::findOrFail($rap->id);
        $modelRap->total_price = $total_price;
        $modelRap->update();
    }

    public function saveRapDetail($rap_id,$bomDetails){
        foreach($bomDetails as $bomDetail){
            $rap_detail = new RapDetail;
            $rap_detail->rap_id = $rap_id;
            $rap_detail->material_id = $bomDetail->material_id;
            $rap_detail->service_id = $bomDetail->service_id;
            $rap_detail->quantity = $bomDetail->quantity;
            if($bomDetail->material_id != null){
                if($bomDetail->source == 'WIP'){
                    $rap_detail->price = $bomDetail->quantity * $bomDetail->material->cost_standard_price_service;
                }else{
                    $rap_detail->price = $bomDetail->quantity * $bomDetail->material->cost_standard_price;
                }
            }else{
                $rap_detail->price = $bomDetail->quantity * $bomDetail->service->cost_standard_price;
            }
            $rap_detail->save();
        }
    }

    public function calculateTotalPrice($id){
        $modelRap = Rap::findOrFail($id);
        $total_price = 0;
        foreach($modelRap->RapDetails as $RapDetail){
            $total_price += $RapDetail->price;
        }
        return $total_price;
    }

    public function checkStock($bom,$menu){
        if($menu=="building"){
            $business_unit = 1;
        }elseif($menu == "repair"){
            $business_unit = 2;
        }
        // create PR (optional)
        $status = 0;
        foreach($bom->bomDetails as $bomDetail){
            if($bomDetail->source != 'WIP'){
                if($bomDetail->material_id != null){
                    $modelStock = Stock::where('material_id',$bomDetail->material_id)->first();
                    $project_id = $bomDetail->bom->project_id;
                    if(!isset($modelStock)){
                        $status = 1;
                    }else{
                        $remaining = $modelStock->quantity - $modelStock->reserved;
                        if($remaining < $bomDetail->quantity){
                            $status = 1;
                        }
                    }
                }
            }
        }
        if($status == 1){
            $pr_number = $this->pr->generatePRNumber();
            $earliest_date_ref = null;
            $earliest_date = self::getEarliestActivity($bom->wbs,$earliest_date_ref);
            $modelProject = Project::findOrFail($project_id);

            $PR = new PurchaseRequisition;
            $PR->number = $pr_number;
            $PR->business_unit_id = $business_unit;
            $PR->required_date = $earliest_date;
            $PR->type = 1;
            $PR->project_id = $project_id;
            $PR->bom_id = $bom->id;
            $PR->description = 'AUTO PR FOR '.$modelProject->number;
            $PR->status = 1;
            $PR->user_id = Auth::user()->id;
            $PR->branch_id = Auth::user()->branch->id;
            $PR->save();
        }

        // reservasi & PR Detail
        foreach($bom->bomDetails as $bomDetail){
            if($bomDetail->source != 'WIP'){
                if($bomDetail->material_id != null){
                    $modelStock = Stock::where('material_id',$bomDetail->material_id)->first();

                    if(isset($modelStock)){
                        $remaining = $modelStock->quantity - $modelStock->reserved;
                        if($remaining < $bomDetail->quantity){
                            $PRD = new PurchaseRequisitionDetail;
                            $PRD->purchase_requisition_id = $PR->id;
                            $PRD->material_id = $bomDetail->material_id;
                            $PRD->wbs_id = $bomDetail->bom->wbs_id;
                            $PRD->quantity = $bomDetail->quantity;
                            $PRD->save();
                        }
                        $modelStock->reserved += $bomDetail->quantity;
                        $modelStock->updated_at = Carbon::now();
                        $modelStock->save();
                    }else{
                        $PRD = new PurchaseRequisitionDetail;
                        $PRD->purchase_requisition_id = $PR->id;
                        $PRD->material_id = $bomDetail->material_id;
                        $PRD->wbs_id = $bomDetail->bom->wbs_id;
                        $PRD->quantity = $bomDetail->quantity;
                        $PRD->save();

                        $modelStock = new Stock;
                        $modelStock->material_id = $bomDetail->material_id;
                        $modelStock->quantity = 0;
                        $modelStock->reserved = $bomDetail->quantity;
                        $modelStock->branch_id = Auth::user()->branch->id;
                        $modelStock->save();
                    }
                }
            }
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


    public function getDataChart($dataPlannedCost,$objectDate,$modelMR,$dataActualCost, $project, $dataActualProgress,$dataPlannedProgress, $menu,$dataEvm)
    {
        $otherCosts = Cost::where('project_id', $project->id)->orderBy('created_at', 'ASC')->get();
        $sorted = $objectDate->all();
        ksort($sorted);
        $tempPlanned = Collection::make();
        $tempActual = Collection::make();
        foreach($otherCosts as $otherCost){
            if($otherCost->actual_cost != null){
                if($otherCost->wbs != null){
                    $tempPlanned->push([
                        "t" => $otherCost->wbs->planned_end_date,
                        "y" => ($otherCost->plan_cost/1000000)."",
                    ]);
                    $tempActual->push([
                        "t" => $otherCost->wbs->planned_end_date,
                        "y" => ($otherCost->actual_cost/1000000)."",
                    ]);
                }else{
                    $tempPlanned->push([
                        "t" => $otherCost->created_at->format('Y-m-d'),
                        "y" => ($otherCost->plan_cost/1000000)."",
                    ]);
                    $tempActual->push([
                        "t" => $otherCost->created_at->format('Y-m-d'),
                        "y" => ($otherCost->actual_cost/1000000)."",
                    ]);
                }
            }else{
                if($otherCost->wbs != null){
                    $tempPlanned->push([
                        "t" => $otherCost->wbs->planned_end_date,
                        "y" => ($otherCost->plan_cost/1000000)."",
                    ]);
                }else{
                    $tempPlanned->push([
                        "t" => $otherCost->created_at->format('Y-m-d'),
                        "y" => ($otherCost->plan_cost/1000000)."",
                    ]);
                }
            }
        }
        if($menu == "building"){
            foreach($sorted as $date => $group){
                foreach($group as $wbs){
                    if($wbs->bom){
                        if($wbs->bom->rap){
                            if($wbs->bom->rap->total_price != 0.0){
                                $tempPlanned->push([
                                    "t" => $date,
                                    "y" => ($wbs->bom->rap->total_price/1000000)."",
                                ]);
                            }
                        }
                    }
                }
            }
        }else{
            foreach($sorted as $date => $group){
                // foreach($group as $act){
                //     if(count($act->activityDetails)>0){
                //         foreach ($act->activityDetails as $act_detail) {
                //             if($act_detail->material != null){
                //                 $price_per_kg = $act_detail->material->cost_standard_price_per_kg;
                //                 $price = $act_detail->material->cost_standard_price;
                //                 if($act_detail->weight != null){
                //                     $tempPlanned->push([
                //                         "t" => $date,
                //                         "y" => number_format($price_per_kg * $act_detail->weight/1000000,2)."",
                //                     ]);
                //                 }else{
                //                     $tempPlanned->push([
                //                         "t" => $date,
                //                         "y" => number_format($price * $act_detail->quantity/1000000,2)."",
                //                     ]);
                //                 }
                //             }else{
                //                 if($act_detail->weight != null){
                //                     $tempPlanned->push([
                //                         "t" => $date,
                //                         "y" => number_format(0,2)."",
                //                     ]);
                //                 }else{
                //                     $tempPlanned->push([
                //                         "t" => $date,
                //                         "y" => number_format(0,2)."",
                //                     ]);
                //                 }
                //             }
                //         }
                //     }
                // }
            }
        }
        $tempPlanned = $tempPlanned->groupBy('t');
        $tempPlanned = $tempPlanned->all();
        ksort($tempPlanned);
        $plannedCost = 0;
        foreach ($tempPlanned as $date => $datas) {
            foreach ($datas as $data) {
                $plannedCost += $data['y'];
            }
            $dataPlannedCost->push([
                "t" => $date,
                "y" =>  $plannedCost."",
            ]);
        }

        foreach($modelMR as $mr){
            $modelGI = $mr->goodsIssues->groupBy(function($date) {
                return $date->issue_date;
            });
            $sorted = $modelGI->all();
            ksort($sorted);
            foreach($sorted as $date => $group){
                foreach($group as $gi){
                    $gids = $gi->goodsIssueDetails;
                    $giCost = 0;
                    foreach($gids as $gid){
                        $giCost += $gid->material->cost_standard_price * $gid->quantity;
                    }
                }
                $tempActual->push([
                    "t" => $date,
                    "y" => ($giCost/1000000)."",
                ]);
            }
        }

        $tempActual = $tempActual->groupBy('t');
        $tempActual = $tempActual->all();
        ksort($tempActual);

        $actualCost = 0;
        foreach ($tempActual as $date => $datas) {
            foreach ($datas as $data) {
                $actualCost += $data['y'];
            }
            $dataActualCost->push([
                "t" => $date,
                "y" =>  $actualCost."",
            ]);
        }

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
            if($date != ""){
                $dataPlannedProgress->push([
                    "t" => $date,
                    "y" => $plannedProgress."",
                ]);
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
        $wbsChart = $project->wbss->groupBy('planned_end_date');
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

    public function getProjectStandardAPI($ship_id){
        $project_standards = ProjectStandard::where('ship_id',$ship_id)->get()->jsonSerialize();
        return response($project_standards, Response::HTTP_OK);
    }

}
