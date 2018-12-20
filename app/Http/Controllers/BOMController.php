<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Project;
use App\Models\Bom;
use App\Models\BomDetail;
use App\Models\Material;
use App\Models\Service;
use App\Models\Branch;
use App\Models\WBS;
use App\Models\User;
use App\Models\Rap;
use App\Models\RapDetail;
use App\Models\Stock;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Auth;

class BOMController extends Controller
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
    public function indexProject(Request $request)
    {
        $projects = Project::where('status',1)->where('business_unit_id',1)->get();
        $menu = $request->route()->getPrefix();

        return view('bom.indexProject', compact('projects','menu'));
    }

    public function selectProject(Request $request)
    {
        $projects = Project::where('status',1)->where('business_unit_id',1)->get();
        $menu = $request->route()->getPrefix();

        return view('bom.selectProject', compact('projects','menu'));
    }

    public function selectWBS(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::find($id);
        $wbss = $project->wbss;
        $data = Collection::make();

        $data->push([
                "id" => $project->number , 
                "parent" => "#",
                "text" => $project->name,
                "icon" => "fa fa-ship"
            ]);
        if($route == '/bom'){
            foreach($wbss as $wbs){
                $bom_code = "";
                $bom = Bom::where('wbs_id',$wbs->id)->first();
                if($bom){
                    $bom_code = " - ".$bom->code;
                    if($wbs->wbs){
                        $data->push([
                            "id" => $wbs->code , 
                            "parent" => $wbs->wbs->code,
                            "text" => $wbs->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom.edit',$bom->id)],
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "parent" => $project->number,
                            "text" => $wbs->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom.edit',$bom->id)],
                        ]);
                    } 
                }else{
                    if($wbs->wbs){
                        $data->push([
                            "id" => $wbs->code , 
                            "parent" => $wbs->wbs->code,
                            "text" => $wbs->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom.create',$wbs->id)],
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "parent" => $project->number,
                            "text" => $wbs->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom.create',$wbs->id)],
                        ]);
                    } 
                } 
            }
        }elseif($route == '/bom_repair'){
            foreach($wbss as $wbs){
                $bom_code = "";
                $bom = Bom::where('wbs_id',$wbs->id)->first();
                if($bom){
                    $bom_code = " - ".$bom->code;
                    if($wbs->wbs){
                        $data->push([
                            "id" => $wbs->code , 
                            "parent" => $wbs->wbs->code,
                            "text" => $wbs->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom_repair.edit',$bom->id)],
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "parent" => $project->number,
                            "text" => $wbs->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom_repair.edit',$bom->id)],
                        ]);
                    } 
                }else{
                    if($wbs->wbs){
                        $data->push([
                            "id" => $wbs->code , 
                            "parent" => $wbs->wbs->code,
                            "text" => $wbs->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom_repair.create',$wbs->id)],
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code , 
                            "parent" => $project->number,
                            "text" => $wbs->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom_repair.create',$wbs->id)],
                        ]);
                    } 
                } 
            }
        }
        
        return view('bom.selectWBS', compact('project','data'));
    }

    public function indexBom(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::find($id);
        $wbs = $project->wbss;
        $data = Collection::make();

        $data->push([
            "id" => $project->number , 
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);
        if($route == '/bom'){
            foreach($wbs as $work){
                $bom_code = "";
                $bom = Bom::where('wbs_id',$work->id)->first();
                if($bom){
                    $bom_code = " - ".$bom->code;
                    if($work->wbs){
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $work->wbs->code,
                            "text" => $work->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom.show',$bom->id)],
                        ]);
                    }else{
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $project->number,
                            "text" => $work->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom.show',$bom->id)],
                        ]);
                    } 
                }else{
                    if($work->wbs){
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $work->wbs->code,
                            "text" => $work->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                        ]);
                    }else{
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $project->number,
                            "text" => $work->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                        ]);
                    } 
                }
            }
        }else{
            foreach($wbs as $work){
                $bom_code = "";
                $bom = Bom::where('wbs_id',$work->id)->first();
                if($bom){
                    $bom_code = " - ".$bom->code;
                    if($work->wbs){
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $work->wbs->code,
                            "text" => $work->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom_repair.show',$bom->id)],
                        ]);
                    }else{
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $project->number,
                            "text" => $work->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom_repair.show',$bom->id)],
                        ]);
                    } 
                }else{
                    if($work->wbs){
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $work->wbs->code,
                            "text" => $work->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                        ]);
                    }else{
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $project->number,
                            "text" => $work->name. ''.$bom_code,
                            "icon" => "fa fa-suitcase",
                        ]);
                    } 
                }
            }
        }
        return view('bom.indexBom', compact('project','data'));
    }

    public function assignBom($id)
    {
        $modelBOM = Bom::where('project_id',$id)->with('work')->get();
        $project = Project::findOrFail($id);
        $wbs = Work::where('project_id',$id)->get();

        return view('bom.assignBom', compact('modelBOM','project','wbs'));
    }

    public function create(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $wbs = WBS::findOrFail($id);
        $project = Project::where('id',$wbs->project_id)->with('ship','customer')->first();
        $materials = Material::orderBy('name')->get()->jsonSerialize();
        
        if($route == '/bom'){
            return view('bom.create', compact('project','materials','wbs'));
        }elseif($route == '/bom_repair'){
            $services = Service::orderBy('name')->get()->jsonSerialize();
            return view('bom.createRepair', compact('project','materials','wbs','services'));
        }
    }

    public function store(Request $request)
    {
        $datas = json_decode($request->datas);
        $bom_code = self::generateBomCode($datas->project_id);
        $modelBom = Bom::where('wbs_id',$datas->wbs_id)->first();

        if(!$modelBom){
            DB::beginTransaction();
            try {
                $bom = new Bom;
                $bom->code = $bom_code;
                $bom->description = $datas->description;
                $bom->project_id = $datas->project_id;
                $bom->wbs_id = $datas->wbs_id;
                $bom->branch_id = Auth::user()->branch->id;
                $bom->user_id = Auth::user()->id;
                if(!$bom->save()){
                    return redirect()->route('bom.create',$bom->id)->with('error', 'Failed Save Bom !');
                }else{
                    $route = $request->route()->getPrefix();
                    if($route == "/bom"){
                        self::saveBomDetail($bom,$datas->materials);
                        self::createRap($datas,$bom);
                        self::checkStock($bom);
                        DB::commit();
                        return redirect()->route('bom.show', ['id' => $bom->id])->with('success', 'Bill Of Material Created');
                    }else{
                        self::saveBomDetailRepair($bom,$datas->materials);
                        self::createRap($datas,$bom);
                        self::checkStock($bom);
                        DB::commit();
                        return redirect()->route('bom_repair.show', ['id' => $bom->id])->with('success', 'BOM/BOS Created');
                    }
                }
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('bom.indexProject')->with('error', $e->getMessage());
            }
        }else{
            if($route == "/bom"){
                return redirect()->route('bom.indexProject')->with('error', 'WBS '.$modelBom->wbs->name.' already have BOM !');
            }else{
                return redirect()->route('bom_repair.indexProject')->with('error', 'WBS '.$modelBom->wbs->name.' already have BOM !');
            }
        }
    }

    public function storeBom(Request $request)
    {
        $route = $request->route()->getPrefix();
        $data = $request->json()->all();
        // $material = Material::findOrFail($data['material_id']);
        DB::beginTransaction();
        try {
            if($route == "/bom"){
                $bom_detail = new BomDetail;
                $bom_detail->bom_id = $data['bom_id'];
                $bom_detail->material_id = $data['material_id'];
                $bom_detail->quantity = $data['quantityInt'];
            }else{
                $bom_detail = new BomDetail;
                $bom_detail->bom_id = $data['bom_id'];
                if($data['material_id'] != ""){
                    $bom_detail->material_id = $data['material_id'];
                }elseif($data['service_id'] != ""){
                    $bom_detail->service_id = $data['service_id'];
                }
                $bom_detail->quantity = $data['quantityInt'];
            }
            if(!$bom_detail->save()){
                return back()->with('error','Failed to save, please try again !');
            }else{
                // Update RAP Detail
                $modelRap = Rap::where('bom_id',$data['bom_id'])->first();
                $rap_detail = new RapDetail;
                $rap_detail->rap_id = $modelRap->id;
                if($route == "/bom"){
                    $rap_detail->material_id = $data['material_id'];
                    $rap_detail->quantity = $data['quantityInt'];
                    $rap_detail->price = $material->cost_standard_price * $data['quantityInt'];
                    $rap_detail->save();

                    // create PR & Reserve stock
                    self::checkStockEdit($data,$modelRap->project_id);
                }else{
                    $rap_detail->material_id = $bom_detail->material_id;
                    $rap_detail->service_id = $bom_detail->service_id;
                    $rap_detail->quantity = $data['quantityInt'];
                    if($bom_detail->material_id != null){
                        $rap_detail->price = $bom_detail->material->cost_standard_price * $data['quantityInt'];
                    }elseif($bom_detail->service_id != null){
                        $rap_detail->price = $bom_detail->service->cost_standard_price * $data['quantityInt'];
                    }
                    $rap_detail->save();
                }

                DB::commit();
                return response(json_encode($bom_detail),Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom_repair.indexProjectRepair')->with('error', $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $pr_number = '-';
        $rap_number = '-';
        $modelBOM = Bom::where('id',$id)->with('project','bomDetails','user','branch')->first();
        $modelBOMDetail = BomDetail::where('bom_id',$modelBOM->id)->with('material','service')->get();

        $modelPR = PurchaseRequisition::where('bom_id',$modelBOM->id)->first();
        if(isset($modelPR)){
            $pr_number = $modelPR->number;
        }

        $modelRAP = Rap::where('bom_id',$modelBOM->id)->first();
        if(isset($modelRAP)){
            $rap_number = $modelRAP->number;
        }
        return view('bom.show', compact('modelBOM','modelBOMDetail','modelPR','modelRAP','route'));
    }

    public function edit(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $pr_number = '-';
        $rap_number = '-';
        $modelBOM = Bom::where('id',$id)->with('project')->first();
        $modelBOMDetail = BomDetail::where('bom_id',$modelBOM->id)->with('material','service')->get();
        $materials = Material::orderBy('name')->get()->jsonSerialize();
        $services = Service::orderBy('name')->get()->jsonSerialize();
        $project = $modelBOM->project;
        $project = Project::find($project->id)->with('ship','customer')->first();

        $modelPR = PurchaseRequisition::where('bom_id',$modelBOM->id)->first();
        if(isset($modelPR)){
            $pr_number = $modelPR->number;
        }

        $modelRAP = Rap::where('bom_id',$modelBOM->id)->first();
        if(isset($modelRAP)){
            $rap_number = $modelRAP->number;
        }
        if($route == '/bom'){
            return view('bom.edit', compact('modelBOM','materials','modelBOMDetail','project','pr_number','rap_number','modelPR','modelRAP'));
        }else{
            return view('bom.editRepair', compact('modelBOM','materials','services','modelBOMDetail','project','pr_number','rap_number','modelPR','modelRAP'));
        }
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $modelBOMDetail = BomDetail::findOrFail($data['bom_detail_id']);
            $diff = $data['quantityInt'] - $modelBOMDetail->quantity;
            $modelBOMDetail->quantity = $data['quantityInt'];

            if(!$modelBOMDetail->update()){
                return redirect()->route('bom.edit',$modelBOMDetail->bom_id)->with('error','Failed to save, please try again !');
            }else{
                // update RAP
                $modelRAP = Rap::where('bom_id',$modelBOMDetail->bom_id)->first();
                foreach($modelRAP->rapDetails as $rapDetail){
                    if($rapDetail->material_id == $modelBOMDetail->material_id){
                        $rapDetail->quantity = $data['quantityInt'];
                        $rapDetail->update();
                    }
                }
                // update reserve mst_stock
                $modelStock = Stock::where('material_id',$modelBOMDetail->material_id)->first();
                $modelStock->reserved += $diff;
                $modelStock->update();
                DB::commit();
                return response(json_encode($modelBOMDetail),Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom.edit',$modelBOMDetail->bom_id)->with('error', $e->getMessage());
        }
    }

    public function updateDesc(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $modelBOM = Bom::findOrFail($data['bom_id']);
            $modelBOM->description = $data['desc'];

            if(!$modelBOM->save()){
                return redirect()->route('bom.edit',$bom->id)->with('error','Failed to save, please try again !');
            }else{
                DB::commit();
                return response(json_encode($modelBOM),Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom.edit',$bom->id)->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $data = $request->json()->all();

        $modelBOMDetail = BomDetail::findOrFail($data[0]);
        DB::beginTransaction();
        try {
            $modelBOMDetail->delete();
            DB::commit();
            return response(json_encode($modelBOMDetail),Response::HTTP_OK);
        } catch(\Illuminate\Database\QueryException $e){
            DB::rollback();
            return redirect()->route('bom.edit',$bom->id)->with('status', 'Can\'t Delete The Material Because It Is Still Being Used');
        }  
    }

    // General Function
    private function generateBomCode($project_id){
        $modelBOM = Bom::orderBy('code','desc')->where('branch_id',Auth::user()->branch_id)->first();
        $modelProject = Project::where('id',$project_id)->first();

        $seqProject = $modelProject->project_sequence;

		$number = 1;
		if(isset($modelBOM)){
            $number += intval(substr($modelBOM->code, -4));
		}

        $code = $seqProject.'00000';
        $code = intval($code);
        $code = $code+$number;

        if($seqProject < 10){
            $code = '0'.$code;
        }

        $bom_code = 'BOM'.$code;
		return $bom_code;
    }
    
    private function generateRapNumber(){
        $modelRap = Rap::orderBy('created_at','desc')->where('branch_id',Auth::user()->branch_id)->first();

		$number = 1;
		if(isset($modelRap)){
            $number += intval(substr($modelRap->number, -6));
		}
        $year = date('y'.'000000');
        $year = intval($year);

		$rap_number = $year+$number;
        $rap_number = 'RAP-'.$rap_number;
		return $rap_number;
    }
    
    private function saveBomDetail($bom, $materials){
        foreach($materials as $material){
            $bom_detail = new BomDetail;
            $bom_detail->bom_id = $bom->id;
            $bom_detail->material_id = $material->material_id;
            $bom_detail->quantity = $material->quantityInt;
            if(!$bom_detail->save()){
                return redirect()->route('bom.create')->with('error', 'Failed Save Bom Detail !');
            }
        }
    }

    private function saveBomDetailRepair($bom, $materials){
        foreach($materials as $material){
            $bom_detail = new BomDetail;
            $bom_detail->bom_id = $bom->id;
            if($material->type == "Material"){
                $bom_detail->material_id = $material->material_id;
            }else{
                $bom_detail->service_id = $material->service_id;
            }
            $bom_detail->quantity = $material->quantityInt;
            if(!$bom_detail->save()){
                return redirect()->route('bom.create')->with('error', 'Failed Save Bom Detail !');
            }
        }
    }

    public function createRap($data,$bom){
        $rap_number = self::generateRapNumber();
        $rap = new Rap;
        $rap->number = $rap_number;
        $rap->project_id = $data->project_id;
        $rap->bom_id = $bom->id;
        $rap->user_id = Auth::user()->id;
        $rap->branch_id = Auth::user()->branch->id;
        if(!$rap->save()){
            return redirect()->route('bom.create')->with('error', 'Failed Save RAP !');
        }else{
            self::saveRapDetail($rap->id,$bom->bomDetails);
            $total_price = self::calculateTotalPrice($rap->id);

            $modelRap = Rap::findOrFail($rap->id);
            $modelRap->total_price = $total_price;
            $modelRap->save();
        }
    }

    public function saveRapDetail($rap_id,$bomDetails){
        foreach($bomDetails as $bomDetail){
            $rap_detail = new RapDetail;
            $rap_detail->rap_id = $rap_id;
            $rap_detail->material_id = $bomDetail->material_id;
            $rap_detail->service_id = $bomDetail->service_id;
            $rap_detail->quantity = $bomDetail->quantity;
            if($bomDetail->material_id != null){
                $rap_detail->price = $bomDetail->quantity * $bomDetail->material->cost_standard_price;
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

    public function checkStock($bom){
        // create PR (optional)
        $status = 0;
        foreach($bom->bomDetails as $bomDetail){
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
            $PR->bom_id = $bom->id;
            $PR->description = 'AUTO PR FOR '.$modelProject->number;
            $PR->status = 1;
            $PR->user_id = Auth::user()->id;
            $PR->branch_id = Auth::user()->branch->id;
            $PR->save();
        }

        // reservasi & PR Detail
        foreach($bom->bomDetails as $bomDetail){
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

    public function checkStockEdit($data,$project_id){
        // create PR (optional)
        $status = 0;
        if($data['material_id'] != null){
            $modelStock = Stock::where('material_id',$data['material_id'])->first();
            if(!isset($modelStock)){
                $status = 1;
            }else{
                $remaining = $modelStock->quantity - $modelStock->reserved;
                if($remaining < $data['quantityInt']){
                    $status = 1;
                }
            }

            if($status == 1){
                $PR = PurchaseRequisition::where('bom_id',$data['bom_id'])->first();
                if(!$PR){
                    $pr_number = $this->pr->generatePRNumber();
                    $current_date = today();
                    $valid_to = $current_date->addDays(7);
                    $valid_to = $valid_to->toDateString();
                    $modelProject = Project::findOrFail($project_id);

                    $PR = new PurchaseRequisition;
                    $PR->number = $pr_number;
                    $PR->valid_date = $valid_to;
                    $PR->project_id = $project_id;
                    $PR->bom_id = $bom->id;
                    $PR->description = 'AUTO PR FOR '.$modelProject->number;
                    $PR->status = 1;
                    $PR->user_id = Auth::user()->id;
                    $PR->branch_id = Auth::user()->branch->id;
                    $PR->save();
                }
            }

            // reservasi & PR Detail
            $modelStock = Stock::where('material_id',$data['material_id'])->first();
            $modelBom = Bom::findOrFail($data['bom_id']);
            
            if(isset($modelStock)){
                $remaining = $modelStock->quantity - $modelStock->reserved;
                if($remaining < $data['quantityInt']){
                    $PRD = new PurchaseRequisitionDetail;
                    $PRD->purchase_requisition_id = $PR->id;
                    $PRD->material_id = $data['material_id'];
                    $PRD->wbs_id = $modelBom->wbs_id;
                    $PRD->quantity = $data['quantityInt'];
                    $PRD->save();
                }
                $modelStock->reserved += $data['quantityInt'];
                $modelStock->update();
            }else{
                $PRD = new PurchaseRequisitionDetail;
                $PRD->purchase_requisition_id = $PR->id;
                $PRD->material_id = $data['material_id'];
                $PRD->wbs_id = $modelBom->wbs_id;
                $PRD->quantity = $data['quantityInt'];
                $PRD->save();

                $modelStock = new Stock;
                $modelStock->material_id = $data['material_id'];
                $modelStock->quantity = 0;
                $modelStock->reserved = $data['quantityInt'];
                $modelStock->branch_id = Auth::user()->branch->id;
                $modelStock->save();
            }
        }
    }

    public function getMaterialAPI($id){

        return response(Material::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getServiceAPI($id){

        return response(Service::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getBomAPI($id){

        return response(BomDetail::where('bom_id',$id)->with('material','service')->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getNewBomAPI($id){

        return response($modelBOM = Bom::where('project_id',$id)->with('Work')->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getBomDetailAPI($id){

        return response($modelBD = BomDetail::where('id',$id)->with('material')->first()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getMaterialsAPI($ids){
        $ids = json_decode($ids);

        return response(Material::orderBy('name')->whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getServicesAPI($ids){
        $ids = json_decode($ids);

        return response(Service::orderBy('name')->whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }

    // Untuk Module Ship Repair
    public function indexProjectRepair(Request $request)
    {
        $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        $menu = $request->route()->getPrefix();
        
        return view('bom.indexProject', compact('projects','menu'));
    }

    public function selectProjectRepair(Request $request)
    {
        $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        $menu = $request->route()->getPrefix();

        return view('bom.selectProject', compact('projects','menu'));
    }
}
