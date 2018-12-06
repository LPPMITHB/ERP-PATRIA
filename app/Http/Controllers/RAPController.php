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
use App\Models\Work;
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

    // create RAB
    public function selectProject()
    {
        $projects = Project::where('status',1)->get();
        $menu = "create_rap";

        return view('rap.selectProject', compact('projects','menu'));
    }

    // view RAB
    public function indexSelectProject()
    {
        $projects = Project::where('status',1)->get();
        $menu = "view_rap";

        return view('rap.selectProject', compact('projects','menu'));
    }

    // create cost
    public function selectProjectCost()
    {
        $projects = Project::where('status',1)->get();
        $menu = "create_cost";

        return view('rap.selectProject', compact('projects','menu'));
    }

    // assign cost
    public function selectProjectAssignCost()
    {
        $projects = Project::where('status',1)->get();
        $menu = "assign_cost";

        return view('rap.selectProject', compact('projects','menu'));
    }

    // view planned cost
    public function selectProjectViewCost()
    {
        $projects = Project::where('status',1)->get();
        $menu = "view_planned_cost";

        return view('rap.selectProject', compact('projects','menu'));
    }

    // view planned cost
    public function selectProjectViewRM()
    {
        $projects = Project::where('status',1)->get();
        $menu = "view_rm";

        return view('rap.selectProject', compact('projects','menu'));
    }

    public function selectWBS($id)
    {
        $project = Project::find($id);
        $works = $project->works;
        $wbs = Collection::make();

        $wbs->push([
                "id" => $project->code , 
                "parent" => "#",
                "text" => $project->name,
                "icon" => "fa fa-ship"
            ]);
    
        foreach($works as $work){
            if($work->work){
                $wbs->push([
                    "id" => $work->code , 
                    "parent" => $work->work->code,
                    "text" => $work->name,
                    "icon" => "fa fa-suitcase",
                    "a_attr" =>  ["href" => route('rap.showMaterialEvaluation',$work->id)],
                ]);
            }else{
                $wbs->push([
                    "id" => $work->code , 
                    "parent" => $project->code,
                    "text" => $work->name,
                    "icon" => "fa fa-suitcase",
                    "a_attr" =>  ["href" => route('rap.showMaterialEvaluation',$work->id)],
                ]);
            }  
        }

        return view('rap.selectWBS', compact('project','wbs'));
    }


    public function showMaterialEvaluation($id)
    {
        $work = Work::findOrFail($id);
        $project = $work->project;

        return view('rap.showMaterialEvaluation', compact('project','work'));
    } 
    
     public function index($id)
    {
        $raps = Rap::where('project_id',$id)->get();

        return view('rap.index', compact('raps'));
    }

    public function create($id)
    {
        $modelBOMs = BOM::where('work_id','!=','null')->where('status',1)->where('project_id',$id)->with('work')->get();
        $project = Project::findOrFail($id);

        return view('rap.create', compact('modelBOMs','project'));
    }

    public function createCost($id)
    {
        $project = Project::findOrFail($id);       

        return view('rap.createOtherCost', compact('project'));
    }

    public function assignCost($id)
    {
        $project = Project::findOrFail($id);   
        $costs = Cost::where('project_id', $id)->with('work')->get()->jsonSerialize();    

        return view('rap.assignCost', compact('project','costs'));
    }

    public function viewPlannedCost($id)
    {
        $project = Project::findOrFail($id);   
        $works = $project->works;
        $costs = Cost::where('project_id', $id)->get();  
        $raps = Rap::where('project_id', $id)->get();  

        $totalCost = 0;
        foreach($raps as $rap){
            $totalCost += $rap->total_price;
        }
        foreach($costs as $cost){
            $totalCost += $cost->cost;
        }

        $data = Collection::make();

        $data->push([
            "id" => $project->code , 
            "parent" => "#",
            "text" => $project->name.' <b>| Total Cost : Rp.'.number_format($totalCost).'</b>',
            "icon" => "fa fa-ship"
        ]);

        foreach($works as $work){
            // $RapCost = 0;
            // foreach($raps as $rap){
            //     foreach($rap->RapDetails as $RD){
            //         if($RD->bom->work_id == $work->id){
            //             $RapCost += $RD->quantity * $RD->price;
            //         }
            //     }
            // }
            // $otherCost = 0;
            // foreach($costs as $cost){
            //     if($cost->work_id == $work->id){
            //         $otherCost += $cost->cost;
            //     }
            // }
            $TempWorkCost = 0;
            $workCost = self::getWorkCost($work,$TempWorkCost,$raps,$costs);

            $totalCost = $workCost;

            if($work->work){
                $data->push([
                    "id" => $work->code , 
                    "parent" => $work->work->code,
                    "text" => $work->name.' <b>| Sub Total Cost : Rp.'.number_format($totalCost).'</b>',
                    "icon" => "fa fa-suitcase"
                ]);
            }else{
                $data->push([
                    "id" => $work->code , 
                    "parent" => $project->code,
                    "text" => $work->name.' <b>| Sub Total Cost : Rp.'.number_format($totalCost).'</b>',
                    "icon" => "fa fa-suitcase"
                ]);
            }  
            // print_r($data);exit();
        }

        foreach($raps as $rap){
            $works = [];
            foreach($rap->RapDetails as $RD){
                array_push($works,$RD->bom->work_id);
            }
            $works = array_unique($works);
            foreach($works as $work){
                $RapCost = 0;
                foreach($rap->RapDetails as $RD){
                    if($RD->bom->work_id == $work){
                        $RapCost += $RD->price;
                        $work_code = $RD->bom->work->code;
                    }
                }
                $data->push([
                    "id" => 'WORK'.$work.'COST'.$RapCost.'RAB'.$rap->id , 
                    "parent" => $work_code,
                    "text" => $rap->number. ' - <b>Rp.'.number_format($RapCost).'</b>' ,
                    "icon" => "fa fa-money"
                ]);
            }
        }

        foreach($costs as $cost){
            if($cost->work_id == null){
                $data->push([
                    "id" => 'COST'.$cost->id , 
                    "parent" => $project->code,
                    "text" => ($cost->type == 0) ? 'Other Cost - <b>Rp.'.number_format($cost->cost).'</b>' : 'Process Cost - <b>Rp.'.number_format($cost->cost).'</b>' ,
                    "icon" => "fa fa-money"
                ]);
            }else{
                $data->push([
                    "id" => 'COST'.$cost->id , 
                    "parent" => $cost->work->code,
                    "text" => ($cost->type == 0) ? 'Other Cost - <b>Rp.'.number_format($cost->cost).'</b>' : 'Process Cost - <b>Rp.'.number_format($cost->cost).'</b>' ,
                    "icon" => "fa fa-money"
                ]);
            }
        }
        return view('rap.viewPlannedCost', compact('project','costs','data'));
    }

    public function getWorkCost($work,$workCost,$raps,$costs){
        if(count($work->works)>0){
            $RapCost = 0;
            foreach($raps as $rap){
                foreach($rap->RapDetails as $RD){
                    if($RD->bom->work_id == $work->id){
                        $RapCost += $RD->price;
                    }
                }
            }

            $otherCost = 0;
            foreach($costs as $cost){
                if($cost->work_id == $work->id){
                    $otherCost += $cost->cost;
                }
            } 
            $workCost += $RapCost + $otherCost;
            foreach($work->works as $work){
                return self::getWorkCost($work,$workCost,$raps,$costs);
            }
        }else{
            $RapCost = 0;
            foreach($raps as $rap){
                foreach($rap->RapDetails as $RD){
                    if($RD->bom->work_id == $work->id){
                        $RapCost += $RD->price;
                    }
                }
            }

            $otherCost = 0;
            foreach($costs as $cost){
                if($cost->work_id == $work->id){
                    $otherCost += $cost->cost;
                }
            } 
            $workCost += $RapCost + $otherCost;
            return $workCost;
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
            $cost->cost = $data['cost'];
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

    public function storeAssignCost(Request $request)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $modelCost = Cost::findOrFail($data['cost_id']);
            if($data['work_id'] == ""){
                $modelCost->work_id = null;
            }else{
                $modelCost->work_id = $data['work_id'];
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
            $cost->cost = $data['cost'];
            $cost->project_id = $data['project_id'];

            if(!$cost->save()){
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
            return redirect()->route('rap.show', ['id' => $rap->id])->with('success', 'RAB Created');
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
        $project = Project::where('id',$modelRap->project_id)->first();

        return view('rap.edit', compact('modelRap','project','modelRAPD'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    // Function
    public function getCosts($project_id){
        $costs = Cost::where('project_id', $project_id)->with('work')->get()->jsonSerialize();
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
                    $PRD->work_id = $data->bomDetail->bom->work_id;
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
                $PRD->work_id = $data->bomDetail->bom->work_id;
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
        $rap_number = 'RAB-'.$rap_number;
		return $rap_number;
    }

    public function getNewCostAPI($id){
        return response(Cost::where('project_id',$id)->with('work')->get()->jsonSerialize(), Response::HTTP_OK);
    }
}
