<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\SalesOrder;
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
                        "text" => $wbs->number." - ".$wbs->description." | Weight : (".$totalWeight."% / ".$wbs->weight."%)",
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
                        "text" => $wbs->number." - ".$wbs->description." | Weight : ".$wbs->weight."%",
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
                    "text" => $wbs->number." - ".$wbs->description." | Weight : (".$totalWeight."% / ".$wbs->weight."%)",
                    "icon" => "fa fa-suitcase",
                    "a_attr" =>  ["href" => $route.$wbs->id],
                ]);
            } 
        }
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
        $projectType = Configuration::get('project_type');
        // $project_code = self::generateProjectCode();
        $project = new Project;
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";

        return view('project.create', compact('customers','ships','project','menu','projectType'));
    }

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
        $actIdConverter = [];
        $wbsIdConverter = [];

        foreach ($datas as $dataTree) {
            if(strpos($dataTree->id, 'WBS') !== false) {
                $wbs_ref = WBS::where('code', $dataTree->id)->first();
                $wbs = new WBS;
                $wbs = $wbs_ref->replicate();
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
                $act = $act_ref->replicate();
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

        if($menu == "building"){
            return redirect()->route('project.show', ['id' => $request->project_id])->with('success', 'Project Created');
        }elseif($menu == "repair"){
            return redirect()->route('project_repair.show', ['id' => $request->project_id])->with('success', 'Project Created');
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
                'planned_start_date' => 'required',
                'planned_end_date' => 'required',
                'planned_duration' => 'required',
                'flag' => 'required',
                'class_name' => 'required',
                'class_contact_person_email' => 'nullable|email|max:255',
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
                    return redirect()->route('project.create')->with('error','The project name has been taken')->withInput();
                }else{
                    return redirect()->route('project_repair.create')->with('error','The project number has been taken')->withInput();
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
            $project->project_type = $request->project_type;
            $project->flag = $request->flag;
            $project->class_name = $request->class_name;
            $project->person_in_charge = $request->person_in_charge;
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

    public function storeCopyProject(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/project" ? "building" : "repair";
        if($menu == "building"){
            $this->validate($request, [
                'number' => 'required',
                'customer' => 'required',
                'ship' => 'required',
                'project_type' => 'required',
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
            $project->project_sequence = $modelProject != null ? $modelProject->project_sequence + 1 : 1;
            $project->name = $request->name;
            $project->description = $request->description;
            $project->customer_id = $request->customer;
            $project->ship_id = $request->ship;
            $project->project_type = $request->project_type;
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
        $projectType = Configuration::get('project_type');

        $menu = $project->business_unit_id == "1" ? "building" : "repair";

        
        return view('project.create', compact('project','projectType','customers','ships','menu'));
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
                "wbs_number" => $wbs->number." - ".$wbs->description,
                "cost" => $plannedCostPerWbs,                   
            ]);
                
            $actual->push([
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
            // $earliest_date_ref = null;
            // if(count($wbs->activities)>0){
            //     $activityRef = Activity::where('wbs_id',$wbs->id)->orderBy('planned_start_date','asc')->first();
            //     $earliest_date_ref = $activityRef->planned_start_date;
            // }
            
            // $earliest_date = self::getEarliestActivity($wbs,$earliest_date_ref);

            // $start_date_wbs = $earliest_date != null ? date_create($earliest_date) : date_create($project->planned_start_date);
            // $earlier = new DateTime($earliest_date);
            // $later = new DateTime($wbs->planned_end_date);
            // $duration = $later->diff($earlier)->format("%a");
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
                            "duration" => $dwbs->uration, 
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
                            "duration" => $duwbs->ration,  
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
                            "duration" => $duwbs->ration,  
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
    public function getDataChart($dataPlannedCost,$wbsChart,$modelMR,$dataActualCost, $project, $dataActualProgress,$dataPlannedProgress)
    {
        $otherCosts = Cost::where('project_id', $project->id)->orderBy('created_at', 'ASC')->get();
        $sorted = $wbsChart->all();
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
                return $date->created_at->toDateString();
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
    
}
