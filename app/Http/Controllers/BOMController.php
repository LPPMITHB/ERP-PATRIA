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
use App\Models\BomPrep;
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

    public function indexProject(Request $request)
    {
        $route = $request->route()->getPrefix();

        if($route == '/bom'){
            $projects = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == '/bom_repair'){
            $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        }

        return view('bom.indexProject', compact('projects','route'));
    }

    public function selectProject(Request $request)
    {
        $route = $request->route()->getPrefix();

        if($route == '/bom'){
            $projects = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == '/bom_repair'){
            $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        }

        return view('bom.selectProject', compact('projects','route'));
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
            if($project->business_unit_id == 1){
                foreach($wbss as $wbs){
                    $bom_code = "";
                    $bom = Bom::where('wbs_id',$wbs->id)->first();
                    if($bom){
                        $bom_code = " - ".$bom->code;
                        if($wbs->wbs){
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $wbs->wbs->code,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('bom.edit',$bom->id)],
                            ]);
                        }else{
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $project->number,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('bom.edit',$bom->id)],
                            ]);
                        } 
                    }else{
                        if($wbs->wbs){
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $wbs->wbs->code,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('bom.create',$wbs->id)],
                            ]);
                        }else{
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $project->number,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('bom.create',$wbs->id)],
                            ]);
                        } 
                    } 
                }
            }else{
                return redirect()->route('bom.indexProject')->with('error', 'Project isn\'t exist, Please try again !');
            }
        }elseif($route == '/bom_repair'){
            if($project->business_unit_id == 2){
                foreach($wbss as $wbs){
                    $bom_code = "";
                    $bom = Bom::where('wbs_id',$wbs->id)->first();
                    if($bom){
                        $bom_code = " - ".$bom->code;
                        if($wbs->wbs){
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $wbs->wbs->code,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('bom_repair.edit',$bom->id)],
                            ]);
                        }else{
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $project->number,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('bom_repair.edit',$bom->id)],
                            ]);
                        } 
                    }else{
                        if($wbs->wbs){
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $wbs->wbs->code,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('bom_repair.create',$wbs->id)],
                            ]);
                        }else{
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $project->number,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('bom_repair.create',$wbs->id)],
                            ]);
                        } 
                    } 
                }
            }else{
                return redirect()->route('bom_repair.indexProject')->with('error', 'Project isn\'t exist, Please try again !');
            }
        }
        return view('bom.selectWBS', compact('project','data','route'));
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
                            "text" => $work->number.' - '.$work->description.'<b>'.$bom_code.'</b>',
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom.show',$bom->id)],
                        ]);
                    }else{
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $project->number,
                            "text" => $work->number.' - '.$work->description.'<b>'.$bom_code.'</b>',
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom.show',$bom->id)],
                        ]);
                    } 
                }else{
                    if($work->wbs){
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $work->wbs->code,
                            "text" => $work->number.' - '.$work->description.'<b>'.$bom_code.'</b>',
                            "icon" => "fa fa-suitcase",
                        ]);
                    }else{
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $project->number,
                            "text" => $work->number.' - '.$work->description.'<b>'.$bom_code.'</b>',
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
                            "text" => $work->number.' - '.$work->description.'<b>'.$bom_code.'</b>',
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom_repair.show',$bom->id)],
                        ]);
                    }else{
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $project->number,
                            "text" => $work->number.' - '.$work->description.'<b>'.$bom_code.'</b>',
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom_repair.show',$bom->id)],
                        ]);
                    } 
                }else{
                    if($work->wbs){
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $work->wbs->code,
                            "text" => $work->number.' - '.$work->description.'<b>'.$bom_code.'</b>',
                            "icon" => "fa fa-suitcase",
                        ]);
                    }else{
                        $data->push([
                            "id" => $work->code , 
                            "parent" => $project->number,
                            "text" => $work->number.' - '.$work->description.'<b>'.$bom_code.'</b>',
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
        $materials = Material::orderBy('code')->get()->jsonSerialize();
        
        if($route == '/bom'){
            if($project->business_unit_id == 1){
                return view('bom.create', compact('project','materials','wbs'));
            }else{
                return redirect()->route('bom.indexProject')->with('error', 'WBS isn\'t exist, Please try again !');
            }
        }elseif($route == '/bom_repair'){
            if($project->business_unit_id == 2){
                $services = Service::orderBy('description')->get()->jsonSerialize();
                return view('bom.createRepair', compact('project','materials','wbs','services'));
            }else{
                return redirect()->route('bom_repair.indexProject')->with('error', 'WBS isn\'t exist, Please try again !');
            }
        }
    }

    public function store(Request $request)
    {
        $route = $request->route()->getPrefix();
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
                    if($route == "/bom"){
                        self::saveBomDetail($bom,$datas->materials);
                        DB::commit();
                        return redirect()->route('bom.show', ['id' => $bom->id])->with('success', 'Bill Of Material Created');
                    }else{
                        self::saveBomDetailRepair($bom,$datas->materials);
                        DB::commit();
                        return redirect()->route('bom_repair.show', ['id' => $bom->id])->with('success', 'BOM/BOS Created');
                    }
                }
            } catch (\Exception $e) {
                DB::rollback();
                if($route == "/bom"){
                    return redirect()->route('bom.indexProject')->with('error', $e->getMessage());
                }else{
                    return redirect()->route('bom_repair.indexProject')->with('error', $e->getMessage());
                }
            }
        }else{
            if($route == "/bom"){
                return redirect()->route('bom.indexProject')->with('error', 'WBS '.$modelBom->wbs->number.' already have BOM !');
            }else{
                return redirect()->route('bom_repair.indexProject')->with('error', 'WBS '.$modelBom->wbs->number.' already have BOM !');
            }
        }
    }

    public function storeBomRepair(Request $request)
    {
        $datas = json_decode($request->datas);

        $bom_code = self::generateBomCode($datas->project_id);
        DB::beginTransaction();
        try {
            $bom = null;
            $rap = null;
            if($datas->existing_bom == null){
                $bom = new Bom;
                $bom->code = $bom_code;
                $bom->description = $datas->description;
                $bom->project_id = $datas->project_id;
                $bom->branch_id = Auth::user()->branch->id;
                $bom->user_id = Auth::user()->id;
                $bom->save();

                $rap = $bom->rap;
            }else{
                $bom = Bom::find($datas->existing_bom->id);
                $bom->description = $datas->description;
                $bom->update();

                $rap = $bom->rap;
            }

            foreach ($datas->fulfilledBomPrep as $bom_prep_id) {
                $bom_prep = BomPrep::find($bom_prep_id);
                $bom_prep->status = 0;
                $bom_prep->update();
            }

            self::saveBomDetailRepair($bom,$datas->bom_preps, $rap);
            if($rap == null){
                self::createRap($bom);
            }

            DB::commit();
            return redirect()->route('bom_repair.show', ['id' => $bom->project->id])->with('success', 'BOM Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom_repair.materialSummary',['id' => $datas->project_id])->with('error', $e->getMessage());
        }
    }

    public function storeBom(Request $request)
    {
        $route = $request->route()->getPrefix();
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            if($route == "/bom"){
                $bom_detail = new BomDetail;
                $bom_detail->bom_id = $data['bom_id'];
                $bom_detail->material_id = $data['material_id'];
                $bom_detail->quantity = $data['quantity'];
                $bom_detail->source = $data['source'];
                $bom_detail->save();
            }elseif($route == "/bom_repair"){
                $bom_detail = new BomDetail;
                $bom_detail->bom_id = $data['bom_id'];
                if($data['material_id'] != ""){
                    $bom_detail->material_id = $data['material_id'];
                }elseif($data['service_id'] != ""){
                    $bom_detail->service_id = $data['service_id'];
                }
                $bom_detail->quantity = $data['quantity'];
                $bom_detail->save();
            }
            $modelBOM = Bom::findOrFail($data['bom_id']);
            if($modelBOM->status == 0){
                // Update RAP Detail
                $modelRap = Rap::where('bom_id',$data['bom_id'])->first();
                $rap_id = $modelRap->id;
                $rap_detail = new RapDetail;
                $rap_detail->rap_id = $rap_id;
                if($route == "/bom"){
                    $rap_detail->material_id = $data['material_id'];
                    $rap_detail->quantity = $data['quantity'];
                    if($data['source'] == "WIP"){
                        $rap_detail->price = $bom_detail->material->cost_standard_price_service * $data['quantity'];
                    }else{
                        $rap_detail->price = $bom_detail->material->cost_standard_price * $data['quantity'];
                    }
                    $rap_detail->save();
    
                    // create PR & Reserve stock
                    self::checkStockEdit($data,$modelRap->project_id,$route);
                }elseif($route == "/bom_repair"){
                    $rap_detail->material_id = $bom_detail->material_id;
                    $rap_detail->service_id = $bom_detail->service_id;
                    $rap_detail->quantity = $data['quantity'];
    
                    if($bom_detail->material_id != null){
                        $rap_detail->price = $bom_detail->material->cost_standard_price * $data['quantity'];
                    }elseif($bom_detail->service_id != null){
                        $rap_detail->price = $bom_detail->service->cost_standard_price * $data['quantity'];
                    }
                    $rap_detail->save();
                    // create PR & Reserve stock
                    self::checkStockEdit($data,$modelRap->project_id,$route);
                }
            }
            DB::commit();
            return response(json_encode($bom_detail),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/bom"){
                return redirect()->route('bom.indexProject')->with('error', $e->getMessage());
            }elseif($route == "/bom_repair"){
                return redirect()->route('bom_repair.indexProject')->with('error', $e->getMessage());
            }
        }
    }

    public function show(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelBOM = Bom::where('id',$id)->with('project','bomDetails','user','branch','wbs','project.customer','project.ship','rap','purchaseRequisition')->first();
        $modelBOMDetail = BomDetail::where('bom_id',$modelBOM->id)->with('material','service','material.uom')->get();

        return view('bom.show', compact('modelBOM','modelBOMDetail','route'));
    }

    public function showRepair(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelBOM = Bom::where('project_id',$id)->with('project','bomDetails','user','branch','wbs','project.customer','project.ship','rap','purchaseRequisition')->first();
        if($modelBOM == null){
            return redirect()->route('bom_repair.selectProject')->with('error', 'BOM doesn\'t exist, Please define BOM first!');
        }
        $modelBOMDetail = BomDetail::where('bom_id',$modelBOM->id)->with('material','service','material.uom')->get();

        return view('bom.show', compact('modelBOM','modelBOMDetail','route'));
    }

    public function edit(Request $request, $id)
    {
        $pr_number = '-';
        $rap_number = '-';
        $route = $request->route()->getPrefix();
        $menu = $request->route()->getPrefix() == "/bom" ? "building" : "repair";

        $modelBOM = Bom::where('id',$id)->with('project')->first();
        $modelBOMDetail = BomDetail::where('bom_id',$modelBOM->id)->with('material','service','material.uom')->get();
        $project = Project::where('id',$modelBOM->project_id)->with('ship','customer')->first();
        $modelPR = PurchaseRequisition::where('bom_id',$modelBOM->id)->first();
        if(isset($modelPR)){
            $pr_number = $modelPR->number;
        }

        $modelRAP = Rap::where('bom_id',$modelBOM->id)->first();
        if(isset($modelRAP)){
            $rap_number = $modelRAP->number;
        }

        $materials = Material::orderBy('description')->get()->jsonSerialize();
        $services = Service::orderBy('name')->get()->jsonSerialize();

        if($route == '/bom'){
            if($project->business_unit_id == 1){
                return view('bom.edit', compact('modelBOM','materials','modelBOMDetail','project','pr_number','rap_number','modelPR','modelRAP','menu'));
            }else{
                return redirect()->route('bom.selectProject')->with('error', 'BOM isn\'t exist, Please try again !');
            }
        }elseif($route == '/bom_repair'){
            if($project->business_unit_id == 2){
                return view('bom.editRepair', compact('modelBOM','materials','services','modelBOMDetail','project','modelPR','modelRAP','menu'));
            }else{
                return redirect()->route('bom_repair.selectProject')->with('error', 'BOM / BOS isn\'t exist, Please try again !');
            }
        }
    }

    public function confirm(Request $request){
        $route = $request->route()->getPrefix();
        $id = $request->json()->all();

        DB::beginTransaction();
        try {
            $modelBom = Bom::findOrFail($id[0]);
            $modelBom->status = 0;
            $modelBom->update();

            self::createRap($modelBom);
            self::checkStock($modelBom,$route);

            DB::commit();
            return response(json_encode($modelBom),Response::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom.show',$id)->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $modelBOMDetail = BomDetail::findOrFail($data['bom_detail_id']);
            $diff = $data['quantity'] - $modelBOMDetail->quantity;
            $modelBOMDetail->quantity = $data['quantity'];
            $modelBOMDetail->material_id = ($data['material_id'] != '') ? $data['material_id'] : null;
            if(isset($data['service_id'])){
                $modelBOMDetail->service_id = ($data['service_id'] != '') ? $data['service_id'] : null;
            }
            $modelBOMDetail->source = isset($data['source']) ? $data['source'] : null ;

            if(!$modelBOMDetail->update()){
                return redirect()->route('bom.edit',$modelBOMDetail->bom_id)->with('error','Failed to save, please try again !');
            }else{
                // update RAP
                if($modelBOMDetail->bom->status == 0){
                    $modelRAP = Rap::where('bom_id',$modelBOMDetail->bom_id)->first();
                    foreach($modelRAP->rapDetails as $rapDetail){
                        if($rapDetail->material_id == $modelBOMDetail->material_id){
                            $rapDetail->quantity = $data['quantity'];
                            $rapDetail->update();
                        }
                    }
                    // update reserve mst_stock
                    $modelStock = Stock::where('material_id',$modelBOMDetail->material_id)->first();
                    $modelStock->reserved += $diff;
                    $modelStock->update();
                }
                DB::commit();
                return response(json_encode($data),Response::HTTP_OK);
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
    
    private function saveBomDetail($bom, $materials){
        foreach($materials as $material){
            $bom_detail = new BomDetail;
            $bom_detail->bom_id = $bom->id;
            $bom_detail->material_id = $material->material_id;
            $bom_detail->quantity = $material->quantity;
            $bom_detail->source = $material->source;
            if(!$bom_detail->save()){
                return redirect()->route('bom.create')->with('error', 'Failed Save Bom Detail !');
            }
        }
    }

    private function saveBomDetailRepair($bom, $bom_preps, $rap){
        $pr_id = null;
        foreach($bom_preps as $bom_prep){
            $bom_prep_model = BomPrep::find($bom_prep->id);
            if(count($bom_prep->bom_details) > 0){
                foreach ($bom_prep->bom_details as $bom_detail) {
                    if($bom_detail->prepared != ""){
                        if($bom_detail->id == null){
                            $bom_detail_input = new BomDetail;
                            $bom_detail_input->bom_id = $bom->id;
                            $bom_detail_input->bom_prep_id = $bom_prep->id;
                            $bom_detail_input->material_id = $bom_detail->material_id;
                            $bom_detail_input->quantity = $bom_detail->prepared;

                            $stock = Stock::where('material_id', $bom_detail->material_id)->first();
                            $stock_available_old = $stock->quantity - $stock->reserved;
                            $still_positive = true;
                            if($stock_available_old < 0){
                                $bom_detail_input->pr_quantity = $bom_detail->prepared;
                                $still_positive = false;
                            }

                            $stock->reserved += $bom_detail->prepared;
                            $stock_available_new = $stock->quantity - $stock->reserved;
                            if($stock_available_new < 0 && $still_positive){
                                $bom_detail_input->pr_quantity = $stock->reserved - $stock->quantity;
                            }

                            $stock->update();
                            $bom_detail_input->save();

                            if($rap != null){
                                $rap_details = $rap->rapDetails;
                                $material_not_found = true;
                                foreach ($rap_details as $rap_detail) {
                                    if($rap_detail->material_id == $bom_detail->material_id){
                                        $rap_detail->quantity += $bom_detail->prepared; 
                                        $rap_detail->price = $rap_detail->quantity * $rap_detail->material->cost_standard_price;
                                        $rap_detail->update(); 
                                        $material_not_found = false;
                                    }
                                }

                                if($material_not_found){
                                    $rap_detail = new RapDetail;
                                    $rap_detail->rap_id = $rap->id;
                                    $rap_detail->material_id = $bom_detail->material_id;
                                    $rap_detail->quantity = $bom_detail->prepared;
                                    $rap_detail->price = $rap_detail->quantity * $rap_detail->material->cost_standard_price;
                                    $rap_detail->save();
                                }
                            }
                        }else{
                            $bom_detail_update = BomDetail::find($bom_detail->id);
                            $temp_quantity = $bom_detail_update->quantity;
                            $bom_detail_update->quantity = $bom_detail->prepared;

                            $stock = Stock::where('material_id', $bom_detail_update->material_id)->first();
                            $stock_available_old = $stock->quantity - $stock->reserved;
                            $still_positive = true;
                            if($stock_available_old < 0){
                                $bom_detail_update->pr_quantity = $bom_detail->prepared;
                                $still_positive = false;
                            }
                            $stock->reserved += $bom_detail->prepared - $temp_quantity;
                            $stock_available_new = $stock->quantity - $stock->reserved;
                            if($stock_available_new < 0 && $still_positive){
                                $bom_detail_update->pr_quantity = $stock->reserved - $stock->quantity;
                            }
                            $stock->update();
                            $bom_detail_update->update();

                            if($rap != null){
                                $rap_details = $rap->rapDetails;
                                $material_not_found = true;
                                foreach ($rap_details as $rap_detail) {
                                    if($rap_detail->material_id == $bom_detail->material_id){
                                        $rap_detail->quantity += $bom_detail->prepared - $temp_quantity; 
                                        $rap_detail->price = $rap_detail->quantity * $rap_detail->material->cost_standard_price;
                                        $rap_detail->update(); 
                                        $material_not_found = false;
                                    }
                                }

                                if($material_not_found){
                                    $rap_detail = new RapDetail;
                                    $rap_detail->rap_id = $rap->id;
                                    $rap_detail->material_id = $bom_detail->material_id;
                                    $rap_detail->quantity = $bom_detail->prepared;
                                    $rap_detail->price = $rap_detail->quantity * $rap_detail->material->cost_standard_price;
                                    $rap_detail->save();
                                }
                            }
                        }
                    }
                }
            }

            if($bom_prep_model->status == 0 && $pr_id == null && $bom_prep_model->bomDetails->sum('pr_quantity') > 0){
                $pr_number = $this->pr->generatePRNumber();
                $modelProject = Project::findOrFail($bom->project_id);
                $PR = new PurchaseRequisition;
                $PR->number = $pr_number;
                $PR->business_unit_id = 2;
                $PR->type = 1;
                $PR->bom_id = $bom->id;
                $PR->description = 'AUTO PR FOR '.$modelProject->number;
                $PR->status = 1;
                $PR->user_id = Auth::user()->id;
                $PR->branch_id = Auth::user()->branch->id;
                $PR->save();
                $pr_id = $PR->id;
            }

            if($pr_id != null){
                $bom_details = $bom_prep_model->bomDetails;
                foreach ($bom_details as $bom_detail) {
                    if($bom_detail->pr_quantity != null){
                        $PRD = new PurchaseRequisitionDetail;
                        $PRD->purchase_requisition_id = $pr_id;
                        $PRD->material_id = $bom_detail->material_id;
                        $PRD->quantity = $bom_detail->pr_quantity;
                        $PRD->project_id = $modelProject->id;
                        $PRD->alocation = "Stock";
                        $PRD->save();
                    }
                }
            }
        }

        if($rap != null){
            $total_price = self::calculateTotalPrice($rap->id);
    
            $rap->total_price = $total_price;
            $rap->update();
        }
    }

    public function createRap($bom){
        $rap_number = self::generateRapNumber();
        $rap = new Rap;
        $rap->number = $rap_number;
        $rap->project_id = $bom->project_id;
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

    public function checkStock($bom,$route){

        if($route=="/bom"){
            $business_unit = 1;
        }elseif($route == "/bom_repair"){
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
            $modelProject = Project::findOrFail($project_id);
            $PR = new PurchaseRequisition;
            $PR->number = $pr_number;
            $PR->business_unit_id = $business_unit;
            $PR->type = 1;
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
                        if($remaining > 0 && $remaining < $bomDetail->quantity){
                            $PRD = new PurchaseRequisitionDetail;
                            $PRD->purchase_requisition_id = $PR->id;
                            $PRD->material_id = $bomDetail->material_id;
                            $PRD->quantity = $bomDetail->quantity - $remaining;
                            $PRD->project_id = $project_id;
                            $PRD->save();
                        }else{
                            if($status == 1){
                                $PRD = new PurchaseRequisitionDetail;
                                $PRD->purchase_requisition_id = $PR->id;
                                $PRD->material_id = $bomDetail->material_id;
                                $PRD->quantity = $bomDetail->quantity;
                                $PRD->project_id = $project_id;
                                $PRD->save();
                            }
                        }
                        $modelStock->reserved += $bomDetail->quantity;
                        $modelStock->updated_at = Carbon::now();
                        $modelStock->save();
                    }else{
                        if($status == 1){
                            $PRD = new PurchaseRequisitionDetail;
                            $PRD->purchase_requisition_id = $PR->id;
                            $PRD->material_id = $bomDetail->material_id;
                            $PRD->quantity = $bomDetail->quantity;
                            $PRD->project_id = $project_id;
                            $PRD->save();
                        }

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

    public function checkStockEdit($data,$project_id,$route){
        if($route=="/bom"){
            $business_unit = 1;
        }elseif($route == "/bom_repair"){
            $business_unit = 2;
        }
        // create PR (optional)
        if(isset($data['source']) != false){
            if($data['source'] != "WIP"){
                $status = 0;
                if($data['material_id'] != null){
                    $modelStock = Stock::where('material_id',$data['material_id'])->first();
                    if(!isset($modelStock)){
                        $status = 1;
                    }else{
                        $remaining = $modelStock->quantity - $modelStock->reserved;
                        if($remaining < $data['quantity']){
                            $status = 1;
                        }
                    }
    
                    if($status == 1){
                        $PR = PurchaseRequisition::where('bom_id',$data['bom_id'])->first();
                        if(!$PR){
                            $pr_number = $this->pr->generatePRNumber();
                            $modelProject = Project::findOrFail($project_id);
    
                            $PR = new PurchaseRequisition;
                            $PR->number = $pr_number;
                            $PR->business_unit_id = $business_unit;
                            $PR->type = 1;
                            $PR->bom_id = $data['bom_id'];
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
                        if($remaining < $data['quantity']){
                            $PRD = new PurchaseRequisitionDetail;
                            $PRD->purchase_requisition_id = $PR->id;
                            $PRD->project_id = $project_id;
                            $PRD->material_id = $data['material_id'];
                            $PRD->quantity = $data['quantity'] - $remaining;
                            $PRD->save();
                        }
                        $modelStock->reserved += $data['quantity'];
                        $modelStock->update();
                    }else{
                        $PRD = new PurchaseRequisitionDetail;
                        $PRD->purchase_requisition_id = $PR->id;
                        $PRD->material_id = $data['material_id'];
                        $PRD->quantity = $data['quantity'];
                        $PRD->save();
    
                        $modelStock = new Stock;
                        $modelStock->material_id = $data['material_id'];
                        $modelStock->quantity = 0;
                        $modelStock->reserved = $data['quantity'];
                        $modelStock->branch_id = Auth::user()->branch->id;
                        $modelStock->save();
                    }
                }
            }
        }
    }

    public function deleteMaterial(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $bomDetail = BomDetail::findOrFail($id);
            $bomDetail->delete();

            DB::commit();
            return response(["response"=>"Success to delete material"],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function selectProjectSum(){
        $projects = Project::where('status',1)->where('business_unit_id',2)->get();

        return view('bom.selectProjectSum', compact('projects'));
    }

    public function materialSummary($id){
        $project = Project::where('id',$id)->with('ship','customer')->first();
        $bomPreps = BomPrep::where('project_id', $id)->where('source', "Stock")->where('status', 1)->with('bomDetails','material')->get();
        $stocks = Stock::with('material')->get();
        $existing_bom = $project->boms->first();
        foreach ($bomPreps as $bomPrep) {
            if($bomPrep->weight != null){
                $bomPrep['quantity'] = ceil($bomPrep->weight/$bomPrep->material->weight);
                if(count($bomPrep->bomDetails) > 0){
                    $bomPrep['already_prepared'] = $bomPrep->bomDetails->sum('quantity');
                    foreach ($bomPrep->bomDetails as $bomDetail) {
                        $bomDetail['prepared'] = $bomDetail->quantity;
                    }
                }else{
                    $bomPrep['bom_details'] = [];
                    $bomPrep['already_prepared'] = 0;
                }
            }elseif($bomPrep->quantity != null){
                $bomPrep['quantity'] = $bomPrep->quantity;
                if(count($bomPrep->bomDetails) > 0){
                    $bomPrep['already_prepared'] = $bomPrep->bomDetails->sum('quantity');
                    foreach ($bomPrep->bomDetails as $bomDetail) {
                        $bomDetail['prepared'] = $bomDetail->quantity;
                    }
                }else{
                    $bomPrep['bom_details'] = [];
                    $bomPrep['already_prepared'] = 0;
                }
            }
        }

        return view('bom.materialSummary', compact('project','bomPreps','stocks','existing_bom'));
    }

    public function getMaterialAPI($id){

        return response(Material::where('id',$id)->with('uom')->first()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getServiceAPI($id){

        return response(Service::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getBomAPI($id){

        return response(BomDetail::where('bom_id',$id)->with('material','service','material.uom')->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getNewBomAPI($id){

        return response($modelBOM = Bom::where('project_id',$id)->with('Work')->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getBomDetailAPI($id){

        return response($modelBD = BomDetail::where('id',$id)->with('material')->first()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getMaterialsAPI($ids){
        $ids = json_decode($ids);

        return response(Material::orderBy('code')->whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getServicesAPI($ids){
        $ids = json_decode($ids);

        return response(Service::orderBy('code')->whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getPRAPI($id){
        $modelPR = PurchaseRequisition::where('bom_id',$id)->first();

        return response($modelPR, Response::HTTP_OK);
    }

    public function getBomHeaderAPI($id){

        return response(Bom::where('id',$id)->with('project','bomDetails','user','branch','wbs','project.customer','project.ship','rap','purchaseRequisition')->first()->jsonSerialize(), Response::HTTP_OK);
    }
}
