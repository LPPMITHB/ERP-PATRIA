<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Models\Branch;
use App\Models\Bom;
use App\Models\Rap;
use App\Models\Stock;
use App\Models\RapDetail;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use App\Models\Project;
use App\Models\Cost;
use App\Models\WBS;
use Auth;
use App\Http\Controllers\PurchaseRequisitionController;
use Illuminate\Support\Collection;

class RAPController extends Controller
{
    protected $pr;

    public function __construct(PurchaseRequisitionController $pr)
    {
        $this->pr = $pr;
    }

    // view RAP
    public function indexSelectProject(Request $request)
    {
        $route = $request->route()->getPrefix();
        $menu = "view_rap";

        if($route == '/rap'){
            $projects = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == '/rap_repair'){
            $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        }
        
        return view('rap.selectProject', compact('projects','menu','route'));
    }

    // create cost
    public function selectProjectCost(Request $request)
    {
        $menu = "create_cost";
        $route = $request->route()->getPrefix();

        if($route == '/rap'){
            $projects = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == '/rap_repair'){
            $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        }

        return view('rap.selectProject', compact('projects','menu','route'));
    }

    // input actual other cost
    public function selectProjectActualOtherCost(Request $request)
    {
        $menu = "input_actual_other_cost";
        $route = $request->route()->getPrefix();

        if($route == '/rap'){
            $projects = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == '/rap_repair'){
            $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        }

        return view('rap.selectProject', compact('projects','menu','route'));
    }

    // view planned cost
    public function selectProjectViewCost(Request $request)
    {
        $menu = "view_planned_cost";
        $route = $request->route()->getPrefix();

        if($route == '/rap'){
            $projects = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == '/rap_repair'){
            $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        }

        return view('rap.selectProject', compact('projects','menu','route'));
    }

    // view planned cost
    public function selectProjectViewRM(Request $request)
    {
        $menu = "view_rm";
        $route = $request->route()->getPrefix();

        if($route == '/rap'){
            $projects = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == '/rap_repair'){
            $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        }

        return view('rap.selectProject', compact('projects','menu','route'));
    }

    public function selectWBS(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::find($id);
        $wbss = $project->wbss;
        $dataWbs = Collection::make();

        $dataWbs->push([
            "id" => $project->number , 
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);

        if($route == '/rap'){
            foreach($wbss as $wbs){
                if($wbs->wbs){
                    $dataWbs->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->name,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('rap.showMaterialEvaluation',$wbs->id)],
                    ]);
                }else{
                    $dataWbs->push([
                        "id" => $wbs->code , 
                        "parent" => $project->number,
                        "text" => $wbs->name,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('rap.showMaterialEvaluation',$wbs->id)],
                    ]);
                }  
            }
        }elseif($route == '/rap_repair'){
            foreach($wbss as $wbs){
                if($wbs->wbs){
                    $dataWbs->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->name,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('rap_repair.showMaterialEvaluation',$wbs->id)],
                    ]);
                }else{
                    $dataWbs->push([
                        "id" => $wbs->code , 
                        "parent" => $project->number,
                        "text" => $wbs->name,
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => route('rap_repair.showMaterialEvaluation',$wbs->id)],
                    ]);
                }  
            }
        }

        return view('rap.selectWBS', compact('project','dataWbs'));
    }


    public function showMaterialEvaluation($id)
    {
        $wbs = WBS::findOrFail($id);
        $project = $wbs->project;
        $materialEvaluation = Collection::make();
        $modelBom = Bom::where('wbs_id',$id)->first();

        foreach($modelBom->bomDetails as $bomDetail){
            if(count($bomDetail->material->materialRequisitionDetails)>0){
                foreach ($bomDetail->material->materialRequisitionDetails as $mrd) {
                    if ($mrd->wbs_id == $id) {
                        $materialEvaluation->push([
                            "material" => $bomDetail->material->code.' - '.$bomDetail->material->name,
                            "quantity" => $bomDetail->quantity,
                            "used" => $mrd->issued,
                        ]);
                    }
                }
            }else{
                $materialEvaluation->push([
                    "material" => $bomDetail->material->code.' - '.$bomDetail->material->name,
                    "quantity" => $bomDetail->quantity,
                    "used" => 0,
                ]);
            }
        }
        return view('rap.showMaterialEvaluation', compact('project','wbs','materialEvaluation'));
    } 
    
     public function index(Request $request, $id)
    {
        $raps = Rap::where('project_id',$id)->get();
        $route = $request->route()->getPrefix();

        return view('rap.index', compact('raps','route'));
    }

    public function createCost($id)
    {
        $project = Project::findOrFail($id);  
        
        return view('rap.createOtherCost', compact('project'));
    }

    public function inputActualOtherCost($id)
    {
        $project = Project::findOrFail($id);       
        $modelOtherCost = Cost::with('project','wbs')->get();   

        return view('rap.inputActualOtherCost', compact('project','modelOtherCost'));
    }

    public function viewPlannedCost($id)
    {
        $project = Project::findOrFail($id);   
        $wbss = $project->wbss;
        $costs = Cost::where('project_id', $id)->get();  
        $raps = Rap::where('project_id', $id)->get();  
        $totalCost = 0;

        foreach($raps as $rap){
            $totalCost += $rap->total_price;
        }
        foreach($costs as $cost){
            $totalCost += $cost->plan_cost;
        }

        $data = Collection::make();

        $data->push([
            "id" => $project->number , 
            "parent" => "#",
            "text" => $project->name.' <b>| Total Cost : Rp.'.number_format($totalCost).'</b>',
            "icon" => "fa fa-ship"
        ]);

        foreach($wbss as $wbs){
            $RapCost = 0;
            foreach($raps as $rap){
                if($rap->bom->wbs_id == $wbs->id){
                    foreach($rap->RapDetails as $RD){
                        $RapCost += $RD->quantity * $RD->price;
                    }
                }
            }
            $otherCost = 0;
            foreach($costs as $cost){
                if($cost->wbs_id == $wbs->id){
                    $otherCost += $cost->plan_cost;
                }
            }
            $TempwbsCost = 0;
            $wbsCost = self::getwbsCost($wbs,$TempwbsCost,$raps,$costs);

            $totalCost = $wbsCost;

            if($wbs->wbs){
                $data->push([
                    "id" => $wbs->code , 
                    "parent" => $wbs->wbs->code,
                    "text" => $wbs->name.' <b>| Sub Total Cost : Rp.'.number_format($totalCost).'</b>',
                    "icon" => "fa fa-suitcase"
                ]);
            }else{
                $data->push([
                    "id" => $wbs->code , 
                    "parent" => $project->number,
                    "text" => $wbs->name.' <b>| Sub Total Cost : Rp.'.number_format($totalCost).'</b>',
                    "icon" => "fa fa-suitcase"
                ]);
            }  
        }

        foreach($raps as $rap){
            $wbss = [];
            array_push($wbss,$rap->bom->wbs_id);
            $wbss = array_unique($wbss);
            foreach($wbss as $wbs){
                $RapCost = 0;
                if($rap->bom->wbs_id == $wbs){
                    $wbs_code = $rap->bom->wbs->code;
                    foreach($rap->RapDetails as $RD){
                        $RapCost += $RD->price;
                    }
                }
                $data->push([
                    "id" => 'WBS'.$wbs.'COST'.$RapCost.'RAP'.$rap->id , 
                    "parent" => $wbs_code,
                    "text" => $rap->number. ' - <b>Rp.'.number_format($RapCost).'</b>' ,
                    "icon" => "fa fa-money"
                ]);
            }
        }

        foreach($costs as $cost){
            if($cost->wbs_id == null){
                $data->push([
                    "id" => 'COST'.$cost->id , 
                    "parent" => $project->number,
                    "text" => 'Other Cost - <b>Rp.'.number_format($cost->plan_cost).'</b>',
                    "icon" => "fa fa-money"
                ]);
            }else{
                $data->push([
                    "id" => 'COST'.$cost->id , 
                    "parent" => $cost->wbs->code,
                    "text" => 'Other Cost - <b>Rp.'.number_format($cost->plan_cost).'</b>',
                    "icon" => "fa fa-money"
                ]);
            }
        }
        return view('rap.viewPlannedCost', compact('project','costs','data'));
    }

    public function getWbsCost($wbs,$wbsCost,$raps,$costs){
        if(count($wbs->wbss)>0){
            $RapCost = 0;
            foreach($raps as $rap){
                if($rap->bom->wbs_id == $wbs->id){
                    foreach($rap->rapDetails as $RD){
                        $RapCost += $RD->price;
                    }
                }
            }

            $otherCost = 0;
            foreach($costs as $cost){
                if($cost->wbs_id == $wbs->id){
                    $otherCost += $cost->plan_cost;
                }
            } 
            $wbsCost += $RapCost + $otherCost;
            foreach($wbs->wbss as $wbs){
                return self::getWbsCost($wbs,$wbsCost,$raps,$costs);
            }
        }else{
            $RapCost = 0;
            foreach($raps as $rap){
                if($rap->bom->wbs_id == $wbs->id){
                    foreach($rap->rapDetails as $RD){
                        $RapCost += $RD->price;
                    }
                }
            }

            $otherCost = 0;
            foreach($costs as $cost){
                if($cost->wbs_id == $wbs->id){
                    $otherCost += $cost->plan_cost;
                }
            } 
            $wbsCost += $RapCost + $otherCost;
            return $wbsCost;
            exit();
        }
    }

    public function storeCost(Request $request)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $cost = new Cost;
            $cost->description = $data['description'];
            $cost->plan_cost = $data['cost'];
            if($data['wbs_id'] != ""){
                $cost->wbs_id = $data['wbs_id'];
            }
            $cost->project_id = $data['project_id'];

            $cost->user_id = Auth::user()->id;
            $cost->branch_id = Auth::user()->branch->id;

            if(!$cost->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to create new cost"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeActualCost(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $cost = Cost::find($data['cost_id']);
            $cost->actual_cost = $data['actual_cost'];
            if(!$cost->update()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update Cost"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeAssignCost(Request $request)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $modelCost = Cost::findOrFail($data['cost_id']);
            if($data['wbs_id'] == ""){
                $modelCost->wbs_id = null;
            }else{
                $modelCost->wbs_id = $data['wbs_id'];
            }
            if(!$modelCost->save()){
                return redirect()->route('rap.assignCost')->with('error','Failed to save, please try again !');
            }else{
                DB::commit();
                return response(json_encode($modelCost),Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('rap.assignCost')->with('error', $e->getMessage());
        }
    }

    public function updateCost(Request $request, $id)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $cost = Cost::find($id);
            $cost->description = $data['description'];
            $cost->plan_cost = $data['cost'];
            if($data['wbs_id'] == ""){
                $cost->wbs_id = null;
            }else{
                $cost->wbs_id = $data['wbs_id'];
            }
            $cost->project_id = $data['project_id'];

            if(!$cost->update()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update Cost"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function store(Request $request)
    {
        $datas = json_decode($request->datas);
        $rap_number = self::generateRapNumber();

        DB::beginTransaction();
        try {
            $rap = new Rap;
            $rap->number = $rap_number;
            $rap->project_id = $datas->project->id;
            $rap->user_id = Auth::user()->id;
            $rap->branch_id = Auth::user()->branch->id;
            $rap->save();

            self::saveRapDetail($rap->id,$datas->checkedBoms);
            $total_price = self::calculateTotalPrice($rap->id);

            $modelRap = Rap::findOrFail($rap->id);
            $modelRap->total_price = $total_price;
            $modelRap->save();

            self::updateStatusBom($datas->checkedBoms);
            self::checkstock($datas->checkedBoms);
            DB::commit();
            return redirect()->route('rap.show', ['id' => $rap->id])->with('success', 'RAP Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('rap.selectProject')->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $modelRap = Rap::findOrFail($id);

        return view('rap.show', compact('modelRap'));
    }

    public function edit($id)
    {
        $modelRap = Rap::findOrFail($id);
        $modelRAPD = RapDetail::where('rap_id',$modelRap->id)->with('bom','material')->get();
        $modelBOM = Bom::where('id',$modelRap->bom_id)->first();
        $project = Project::where('id',$modelRap->project_id)->first();
        
        return view('rap.edit', compact('modelRap','project','modelRAPD','modelBOM'));
    }

    public function update(Request $request, $id)
    {
        $datas = json_decode($request->datas);
        

        DB::beginTransaction();
        try {
            foreach($datas as $data){
                $modelRAPD = RapDetail::findOrFail($data->id);
                $modelRAPD->price = str_replace(',', '', $data->priceTotal);
                $modelRAPD->update();
            }
            $total_price = self::calculateTotalPrice($datas[0]->rap_id);

            $modelRap = Rap::findOrFail($datas[0]->rap_id);
            $modelRap->total_price = $total_price;
            $modelRap->update();

            DB::commit();
            return redirect()->route('rap.show', ['id' => $datas[0]->rap_id])->with('success', 'RAP Updated !');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('rap.indexSelectProject')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        //
    }

    // Function
    public function getCosts($project_id){
        $costs = Cost::where('project_id', $project_id)->with('wbs')->get()->jsonSerialize();
        return response($costs, Response::HTTP_OK);
    }

    public function checkStock($bom_ids){
        $datas = [];
        
        foreach($bom_ids as $bom_id){
            $modelBom = Bom::findOrFail($bom_id);
            foreach($modelBom->bomDetails as $bomDetail){
                $data = new \stdClass();
                $data->bomDetail = $bomDetail;
                array_push($datas,$data);
            }
        }
        // create PR (optional)
        foreach($datas as $data){
            $modelStock = Stock::where('material_id',$data->bomDetail->material_id)->first();
            $status = 0;
            $project_id = $data->bomDetail->bom->project_id;
            if(!isset($modelStock)){
                $status = 1;
            }else{
                $remaining = $modelStock->quantity - $modelStock->reserved;
                if($remaining < $data->bomDetail->quantity){
                    $status = 1;
                }
            }
        }
        if($status == 1){
            $pr_number = $this->pr->generatePRNumber();
            $current_date = today();
            $valid_to = $current_date->addDays(7);
            $valid_to = $valid_to->toDateString();
            $modelProject = Project::findOrFail($project_id);

            $PR = new PurchaseRequisition;
            $PR->number = $pr_number;
            $PR->valid_date = $valid_to;
            $PR->project_id = $project_id;
            $PR->description = 'AUTO PR FOR '.$modelProject->code;
            $PR->status = 1;
            $PR->user_id = Auth::user()->id;
            $PR->branch_id = Auth::user()->branch->id;
            $PR->save();
        }

        // reservasi & PR Detail
        foreach($datas as $data){
            $modelStock = Stock::where('material_id',$data->bomDetail->material_id)->first();
            
            if(isset($modelStock)){
                $remaining = $modelStock->quantity - $modelStock->reserved;
                if($remaining < $data->bomDetail->quantity){
                    $PRD = new PurchaseRequisitionDetail;
                    $PRD->purchase_requisition_id = $PR->id;
                    $PRD->material_id = $data->bomDetail->material_id;
                    $PRD->wbs_id = $data->bomDetail->bom->wbs_id;
                    $PRD->quantity = $data->bomDetail->quantity;
                    $PRD->save();
                }
                $modelStock->reserved += $data->bomDetail->quantity;
                $modelStock->updated_at = Carbon::now();
                $modelStock->save();
            }else{
                $PRD = new PurchaseRequisitionDetail;
                $PRD->purchase_requisition_id = $PR->id;
                $PRD->material_id = $data->bomDetail->material_id;
                $PRD->wbs_id = $data->bomDetail->bom->wbs_id;
                $PRD->quantity = $data->bomDetail->quantity;
                $PRD->save();

                $modelStock = new Stock;
                $modelStock->material_id = $data->bomDetail->material_id;
                $modelStock->quantity = 0;
                $modelStock->reserved = $data->bomDetail->quantity;
                $modelStock->branch_id = Auth::user()->branch->id;
                $modelStock->save();
            }
        }
    }

    public function saveRapDetail($rap_id,$boms){
        foreach ($boms as $bom) {
            $modelBom = Bom::findOrFail($bom);
            foreach($modelBom->bomDetails as $bomDetail){
                $rap_detail = new RapDetail;
                $rap_detail->rap_id = $rap_id;
                $rap_detail->bom_id = $bomDetail->bom_id;
                $rap_detail->material_id = $bomDetail->material_id;
                $rap_detail->quantity = $bomDetail->quantity;
                $rap_detail->price = $bomDetail->quantity * $bomDetail->material->cost_standard_price;
                $rap_detail->save();
            }
        }
    }

    public function calculateTotalPrice($id){
        $modelRap = Rap::findOrFail($id);
        $total_price = 0;
        foreach($modelRap->RapDetails as $RapDetail){
            $total_price += $RapDetail->price;
        }
        print_r($total_price);exit();
        return $total_price;
    }

    public function updateStatusBom($bom_ids){
        foreach($bom_ids as $bom_id){
            $modelBom = Bom::findOrFail($bom_id);
            $modelBom->status = 2;
            $modelBom->save();
        }
    }

    private function generateRapNumber(){
        $modelRap = Rap::orderBy('created_at','desc')->where('branch_id',Auth::user()->branch_id)->first();
        $modelBranch = Branch::where('id', Auth::user()->branch_id)->first();

        $branch_code = substr($modelBranch->code,4,2);
		$number = 1;
		if(isset($modelRap)){
            $number += intval(substr($modelRap->number, -6));
		}
        $year = date('y'.$branch_code.'000000');
        $year = intval($year);

		$rap_number = $year+$number;
        $rap_number = 'RAP-'.$rap_number;
		return $rap_number;
    }

    public function getNewCostAPI($id){
        return response(Cost::where('project_id',$id)->with('wbs')->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getAllWorksCostAPI($project_id){
        $works = WBS::orderBy('planned_deadline', 'asc')->where('project_id', $project_id)->get()->jsonSerialize();
        return response($works, Response::HTTP_OK);
    }





     // view RAP repair
    public function indexSelectProjectRepair(Request $request)
    {
        $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        $menu = "view_rap";
        $route = $request->route()->getPrefix();

        return view('rap.selectProject', compact('projects','menu','route'));
    }

    // create cost repair
    public function selectProjectCostRepair(Request $request)
    {
        $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        $menu = "create_cost";
        $route = $request->route()->getPrefix();

        return view('rap.selectProject', compact('projects','menu','route'));
    }

    // input actual other cost repair
    public function selectProjectActualOtherCostRepair(Request $request)
    {
        $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        $menu = "input_actual_other_cost";
        $route = $request->route()->getPrefix();

        return view('rap.selectProject', compact('projects','menu','route'));
    }

    // view planned cost repair
    public function selectProjectViewCostRepair(Request $request)
    {
        $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        $menu = "view_planned_cost";
        $route = $request->route()->getPrefix();

        return view('rap.selectProject', compact('projects','menu','route'));
    }

    // view planned cost repair
    public function selectProjectViewRMRepair(Request $request)
    {
        $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        $menu = "view_rm";
        $route = $request->route()->getPrefix();

        return view('rap.selectProject', compact('projects','menu','route'));
    }
}
