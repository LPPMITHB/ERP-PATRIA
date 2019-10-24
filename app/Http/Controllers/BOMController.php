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
use App\Models\Notification;
use App\Models\Configuration;
use App\Models\BomPrep;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use App\Models\WbsMaterial;
use App\Models\Vendor;
use App\Models\Uom;
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

    public function selectProjectManage(){
        $projects = Project::where('status',1)->where('business_unit_id',2)->get();

        return view('bom.selectProjectManage', compact('projects'));
    }

    public function selectProjectSum(Request $request){
        $route = $request->route()->getPrefix();
        if($route == "/bom"){
            $projects = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route =="/bom_repair"){
            $projects = Project::where('status',1)->where('business_unit_id',2)->get();
        }

        return view('bom.selectProjectSum', compact('projects','route'));
    }

    public function materialSummary($id){
        $project = Project::where('id',$id)->with('ship','customer')->first();
        $bomPreps = BomPrep::where('project_id', $id)->where('status', 1)->with('bomDetails','material')->get();
        $stocks = Stock::with('material')->get();
        $materials = Material::with('stock')->get();
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

        return view('bom.materialSummary', compact('project','bomPreps','stocks','existing_bom','materials'));
    }


    public function materialSummaryBuilding($id){
        $wbs = WBS::where('id',$id)->first();
        $project = Project::where('id', $wbs->project_id)->with('ship','customer')->first();
        $bomPreps = BomPrep::where('wbs_id', $id)->where('status', 1)->with('bomDetails','material')->get();

        if(count($bomPreps)>0){
            $stocks = Stock::with('material')->get();
            $materials = Material::with('stock')->get();
            $existing_bom = $wbs->bom;

            foreach ($bomPreps as $bomPrep) {
                $temp_total = 0;
                if($bomPrep->weight != null){
                    $temp_total = ceil($bomPrep->weight/$bomPrep->material->weight);
                    if($bomPrep->quantity != null){
                        $temp_total += $bomPrep->quantity;
                    }
                }else{
                    $temp_total = $bomPrep->quantity;
                }
                $bomPrep['quantity'] = $temp_total;

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
        }else{
            return redirect()->route('bom.selectWBSSum',$wbs->id)->with('error', 'There are no materials accumulation for the selected WBS!');
        }

        return view('bom.materialSummaryBuilding', compact('project','wbs','bomPreps','stocks','existing_bom','materials'));
    }

    public function selectWBSSum(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $wbs = WBS::find($id);
        $project = Project::find($wbs->project_id);
        $wbss = $project->wbss->where('wbs_id',null);
        $data = Collection::make();

        $data->push([
            "id" => $project->number,
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);

        if($route == '/bom'){
            if($project->business_unit_id == 1){
                foreach($wbss as $wbs){
                    $bom_code = "";
                    $bom_prep = BomPrep::where('wbs_id',$wbs->id)->get();
                    if(count($bom_prep)>0){
                        $bom_code = " this WBS have materials accumulation";
                        $data->push([
                            "id" => $wbs->code ,
                            "parent" => $project->number,
                            "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom.materialSummaryBuilding',$wbs->id)],
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code ,
                            "parent" => $project->number,
                            "text" => $wbs->number.' - '.$wbs->description.'<b>'.$bom_code.'</b>',
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom.materialSummaryBuilding',$wbs->id)],
                        ]);
                    }
                }
            }else{
                return redirect()->route('bom.indexProject')->with('error', 'Project isn\'t exist, Please try again !');
            }
        }

        return view('bom.selectWBS', compact('project','data','route'));
    }

    public function selectWBS(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::find($id);
        $wbss = $project->wbss;
        $data = Collection::make();

        $data->push([
            "id" => $project->number,
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);

        if($route == '/bom'){
            if($project->business_unit_id == 1){
                foreach($wbss as $wbs){
                    $exist = "";
                    $wbs_material = WbsMaterial::where('wbs_id',$wbs->id)->first();
                    if($wbs_material){
                        $exist = " - this WBS already has materials, Click to Edit";
                        if($wbs->wbs){
                            $data->push([
                                "id" => $wbs->code ,
                                "parent" => $wbs->wbs->code,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$exist.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('bom.manageWbsMaterialBuilding',$wbs->id)],
                            ]);
                        }else{
                            $data->push([
                                "id" => $wbs->code ,
                                "parent" => $project->number,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$exist.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('bom.manageWbsMaterialBuilding',$wbs->id)],
                            ]);
                        }
                    }else{
                        if($wbs->wbs){
                            $data->push([
                                "id" => $wbs->code ,
                                "parent" => $wbs->wbs->code,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$exist.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('bom.manageWbsMaterialBuilding',$wbs->id)],
                            ]);
                        }else{
                            $data->push([
                                "id" => $wbs->code ,
                                "parent" => $project->number,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$exist.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('bom.manageWbsMaterialBuilding',$wbs->id)],
                            ]);
                        }
                    }
                }
            }else{
                return redirect()->route('bom.indexProject')->with('error', 'Project isn\'t exist, Please try again !');
            }
        }
        return view('bom.selectWBS', compact('project','data','route'));
    }

    public function selectWBSManage(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::find($id);
        $wbss = $project->wbss;
        $data = Collection::make();

        $data->push([
            "id" => $project->number,
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);

        if($project->business_unit_id == 2){
            foreach($wbss as $wbs){
                $exist = "";
                $wbs_material = WbsMaterial::where('wbs_id',$wbs->id)->first();
                if($wbs_material){
                    $exist = " - this WBS already has materials, Click to Edit";
                    if($wbs->wbs){
                        $data->push([
                            "id" => $wbs->code ,
                            "parent" => $wbs->wbs->code,
                            "text" => $wbs->number.' - '.$wbs->description.'<b>'.$exist.'</b>',
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom_repair.manageWbsMaterial',$wbs->id)],
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code ,
                            "parent" => $project->number,
                            "text" => $wbs->number.' - '.$wbs->description.'<b>'.$exist.'</b>',
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom_repair.manageWbsMaterial',$wbs->id)],
                        ]);
                    }
                }else{
                    if($wbs->wbs){
                        $data->push([
                            "id" => $wbs->code ,
                            "parent" => $wbs->wbs->code,
                            "text" => $wbs->number.' - '.$wbs->description.'<b>'.$exist.'</b>',
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom_repair.manageWbsMaterial',$wbs->id)],
                        ]);
                    }else{
                        $data->push([
                            "id" => $wbs->code ,
                            "parent" => $project->number,
                            "text" => $wbs->number.' - '.$wbs->description.'<b>'.$exist.'</b>',
                            "icon" => "fa fa-suitcase",
                            "a_attr" =>  ["href" => route('bom_repair.manageWbsMaterial',$wbs->id)],
                        ]);
                    }
                }
            }
        }
        return view('bom.selectWBS', compact('project','data','route'));
    }

    public function manageWbsMaterial($wbs_id, Request $request)
    {
        $wbs = Wbs::find($wbs_id);
        $project = Project::where('id',$wbs->project_id)->with('ship')->first();
        $materials = Material::orderBy('code')->get()->jsonSerialize();
        $services = Service::where('ship_id', null)->orWhere('ship_id', $wbs->project->ship_id)->with('serviceDetails','ship')->get();
        $vendors = Vendor::all();
        $densities = Configuration::get('density');
        $uoms = Uom::all();
        $existing_data = [];

        $material_ids = [];
        $edit = false;

        $temp_wbs_material = Collection::make();

        if(count($wbs->wbsMaterials)>0){
            $edit = true;
            $existing_data = WbsMaterial::where('wbs_id', $wbs->id)->get();
            foreach ($existing_data as $material) {
                if($temp_wbs_material->where('material_id', $material->material->id)->count() === 0){
                    array_push($material_ids,$material->material_id);
                    $temp_material = new \stdClass;
                    $temp_material->id = $material->id;
                    $temp_material->material_id = $material->material_id;
                    $temp_material->material_code = $material->material->code;
                    $temp_material->material_name = $material->material->description;
                    $temp_material->unit = $material->material->uom->unit;
                    $temp_material->uom = $material->material->uom;
                    $temp_material->parts_weight = $material->weight;
                    $temp_material->source = $material->source;
                    if($material->material->weight != 0){
                        $temp_material->quantity = ceil($material->weight / $material->material->weight);
                    }else{
                        $temp_material->quantity = $material->quantity;
                    }
                    $temp_material->weight_uom = $material->material->weightUom;
                    $temp_material->part_details = [];
                    $temp_material->selected_material = $material->material;

                    if($temp_material->selected_material->dimensions_value != null){
                        $dimensions = json_decode($temp_material->selected_material->dimensions_value);
                        foreach ($dimensions as $dimension) {
                            $uom = Uom::find($dimension->uom_id);
                            $dimension->uom = $uom;
                        }
                        $temp_material->selected_material->dimensions_value_obj = $dimensions;
                        $temp_material->selected_material->dimensions_value = json_encode($dimensions);
                    }

                    if($temp_material->selected_material->density_id != null){
                        foreach ($densities as $density) {
                            if($density->id == $temp_material->selected_material->density_id){
                                $temp_material->selected_material->density = $density;
                            }
                        }
                    }

                    if($material->dimensions_value != null){
                        $part = new \stdClass;
                        $part->id = $material->id;
                        $part->description = $material->part_description;
                        $part->edit = false;
                        $part->quantity = $material->quantity;
                        $part->weight = $material->weight;
                        $part->dimensions_value = $material->dimensions_value;
                        $part->dimensions_value_obj = json_decode($part->dimensions_value);
                        foreach ($part->dimensions_value_obj as $dimension) {
                            $dimension->uom = Uom::find($dimension->uom_id);
                        }
                        array_push($temp_material->part_details,$part);
                    }

                    $temp_wbs_material->push($temp_material);
                }else{
                    if($material->dimensions_value != null){
                        $part = new \stdClass;
                        $part->id = $material->id;
                        $part->description = $material->part_description;
                        $part->edit = false;
                        $part->quantity = $material->quantity;
                        $part->weight = $material->weight;
                        $part->dimensions_value = $material->dimensions_value;
                        $part->dimensions_value_obj = json_decode($part->dimensions_value);
                        foreach ($part->dimensions_value_obj as $dimension) {
                            $dimension->uom = Uom::find($dimension->uom_id);
                        }
                        $existed_temp = $temp_wbs_material->where('material_id', $material->material->id)->first();
                        $existed_temp->parts_weight += $material->weight;
                        $existed_temp->quantity = ceil($existed_temp->parts_weight / $material->material->weight);
                        array_push($existed_temp->part_details,$part);
                    }
                }
            }

            $existing_data = $temp_wbs_material;
        }

        return view('bom.manageWbsMaterial', compact('project','materials','wbs','edit','existing_data','material_ids','services','vendors','uoms'));
    }

    public function manageWbsMaterialBuilding($wbs_id, Request $request)
    {
        $wbs = Wbs::find($wbs_id);
        $project = Project::where('id',$wbs->project_id)->with('ship')->first();
        $materials = Material::orderBy('code')->get()->jsonSerialize();
        $services = Service::where('ship_id', null)->orWhere('ship_id', $wbs->project->ship_id)->with('serviceDetails','ship')->get();
        $vendors = Vendor::all();
        $densities = Configuration::get('density');
        $uoms = Uom::all();
        $existing_data = [];

        $material_ids = [];
        $edit = false;

        $temp_wbs_material = Collection::make();

        if(count($wbs->wbsMaterials)>0){
            $edit = true;
            $existing_data = WbsMaterial::where('wbs_id', $wbs->id)->get();
            foreach ($existing_data as $material) {
                if($temp_wbs_material->where('material_id', $material->material->id)->count() === 0){
                    array_push($material_ids,$material->material_id);
                    $temp_material = new \stdClass;
                    $temp_material->id = $material->id;
                    $temp_material->material_id = $material->material_id;
                    $temp_material->material_code = $material->material->code;
                    $temp_material->material_name = $material->material->description;
                    $temp_material->unit = $material->material->uom->unit;
                    $temp_material->uom = $material->material->uom;
                    $temp_material->parts_weight = $material->weight;
                    $temp_material->source = $material->source;
                    if($material->material->weight != 0){
                        $temp_material->quantity = ceil($material->weight / $material->material->weight);
                    }else{
                        $temp_material->quantity = $material->quantity;
                    }
                    $temp_material->weight_uom = $material->material->weightUom;
                    $temp_material->part_details = [];
                    $temp_material->selected_material = $material->material;

                    if($temp_material->selected_material->dimensions_value != null){
                        $dimensions = json_decode($temp_material->selected_material->dimensions_value);
                        foreach ($dimensions as $dimension) {
                            $uom = Uom::find($dimension->uom_id);
                            $dimension->uom = $uom;
                        }
                        $temp_material->selected_material->dimensions_value_obj = $dimensions;
                        $temp_material->selected_material->dimensions_value = json_encode($dimensions);
                    }

                    if($temp_material->selected_material->density_id != null){
                        foreach ($densities as $density) {
                            if($density->id == $temp_material->selected_material->density_id){
                                $temp_material->selected_material->density = $density;
                            }
                        }
                    }

                    if($material->dimensions_value != null){
                        $part = new \stdClass;
                        $part->id = $material->id;
                        $part->description = $material->part_description;
                        $part->edit = false;
                        $part->quantity = $material->quantity;
                        $part->weight = $material->weight;
                        $part->dimensions_value = $material->dimensions_value;
                        $part->dimensions_value_obj = json_decode($part->dimensions_value);
                        foreach ($part->dimensions_value_obj as $dimension) {
                            $dimension->uom = Uom::find($dimension->uom_id);
                        }
                        array_push($temp_material->part_details,$part);
                    }

                    $temp_wbs_material->push($temp_material);
                }else{
                    if($material->dimensions_value != null){
                        $part = new \stdClass;
                        $part->id = $material->id;
                        $part->description = $material->part_description;
                        $part->edit = false;
                        $part->quantity = $material->quantity;
                        $part->weight = $material->weight;
                        $part->dimensions_value = $material->dimensions_value;
                        $part->dimensions_value_obj = json_decode($part->dimensions_value);
                        foreach ($part->dimensions_value_obj as $dimension) {
                            $dimension->uom = Uom::find($dimension->uom_id);
                        }
                        $existed_temp = $temp_wbs_material->where('material_id', $material->material->id)->first();
                        $existed_temp->parts_weight += $material->weight;
                        $existed_temp->quantity = ceil($existed_temp->parts_weight / $material->material->weight);
                        array_push($existed_temp->part_details,$part);
                    }
                }
            }

            $existing_data = $temp_wbs_material;
        }

        return view('bom.manageWbsMaterialBuilding', compact('project','materials','wbs','edit','existing_data','material_ids','services','vendors','uoms'));
    }

    public function storeWbsMaterial(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            foreach($datas->materials as $material){
                if(count($material->part_details) > 0){
                    foreach ($material->part_details as $part) {
                        $wbsMaterial = new WbsMaterial;
                        $wbsMaterial->wbs_id = $datas->wbs_id;
                        $wbsMaterial->material_id = $material->material_id;
                        $wbsMaterial->quantity = $part->quantity;
                        if($part->dimensions_value_obj != null){
                            foreach ($part->dimensions_value_obj as $dimension) {
                                unset($dimension->value);
                                unset($dimension->uom);
                            }
                            $temp_dimensions_value = json_encode($part->dimensions_value_obj);
                            $wbsMaterial->dimensions_value = $temp_dimensions_value;
                        }
                        $old_material_source = $material->source;
                        $wbsMaterial->source = $material->source;
                        $wbsMaterial->weight = $part->weight;
                        $wbsMaterial->save();

                        $weight = $part->weight;

                        $modelBomPrep = BomPrep::where('project_id', $datas->project_id)->where('material_id', $material->material_id)->where('source', $old_material_source)->get();
                        if(count($modelBomPrep) > 0){
                            $not_found_bom_prep = false;
                            $not_added = true;
                            foreach ($modelBomPrep as $bomPrep) {
                                if($bomPrep->status == 1){
                                    if($weight == 0){
                                        $bomPrep->quantity += $material->quantity;
                                    }else{
                                        $bomPrep->weight += $weight;
                                    }
                                    $bomPrep->source = $material->source;
                                    $bomPrep->update();

                                    $wbsMaterial->bom_prep_id = $bomPrep->id;
                                    $wbsMaterial->update();

                                    $not_added = false;
                                }else{
                                    $not_found_bom_prep = true;
                                }

                            }
                            if($not_found_bom_prep && $not_added){
                                $bomPrep = new BomPrep;
                                $bomPrep->project_id = $datas->project_id;
                                $bomPrep->material_id = $material->material_id;
                                if($weight == 0){
                                    $bomPrep->quantity = $material->quantity;
                                }else{
                                    $bomPrep->weight = $weight;
                                }
                                $bomPrep->status = 1;
                                $bomPrep->source = $material->source;
                                $bomPrep->save();

                                $wbsMaterial->bom_prep_id = $bomPrep->id;
                                $wbsMaterial->update();
                            }
                        }else{
                            $bomPrep = new BomPrep;
                            $bomPrep->project_id = $datas->project_id;
                            $bomPrep->material_id = $material->material_id;
                            if($weight == 0){
                                $bomPrep->quantity = $material->quantity;
                            }else{
                                $bomPrep->weight = $weight;
                            }
                            $bomPrep->status = 1;
                            $bomPrep->source = $material->source;
                            $bomPrep->save();

                            $wbsMaterial->bom_prep_id = $bomPrep->id;
                            $wbsMaterial->update();
                        }
                    }
                }else{
                    $wbsMaterial = new WbsMaterial;
                    $wbsMaterial->wbs_id = $datas->wbs_id;
                    $wbsMaterial->material_id = $material->material_id;
                    $wbsMaterial->quantity = $material->quantity;
                    if(isset($material->dimensions_value)){
                        $wbsMaterial->dimensions_value = $material->dimensions_value;
                    }else{
                        $wbsMaterial->dimensions_value = null;
                    }
                    $old_material_source = $material->source;
                    $wbsMaterial->source = $material->source;
                    $wbsMaterial->save();

                    if($wbsMaterial->dimensions_value == null){
                        $weight = 0;
                    }

                    $modelBomPrep = BomPrep::where('project_id', $datas->project_id)->where('material_id', $material->material_id)->where('source', $old_material_source)->get();
                    if(count($modelBomPrep) > 0){
                        $not_found_bom_prep = false;
                        $not_added = true;
                        foreach ($modelBomPrep as $bomPrep) {
                            if($bomPrep->status == 1){
                                if($weight == 0){
                                    $bomPrep->quantity += $material->quantity;
                                }else{
                                    $bomPrep->weight += $weight;
                                }
                                $bomPrep->source = $material->source;
                                $bomPrep->update();

                                $wbsMaterial->bom_prep_id = $bomPrep->id;
                                $wbsMaterial->update();

                                $not_added = false;
                            }else{
                                $not_found_bom_prep = true;
                            }

                        }
                        if($not_found_bom_prep && $not_added){
                            $bomPrep = new BomPrep;
                            $bomPrep->project_id = $datas->project_id;
                            $bomPrep->material_id = $material->material_id;
                            if($weight == 0){
                                $bomPrep->quantity = $material->quantity;
                            }else{
                                $bomPrep->weight = $weight;
                            }
                            $bomPrep->status = 1;
                            $bomPrep->source = $material->source;
                            $bomPrep->save();

                            $wbsMaterial->bom_prep_id = $bomPrep->id;
                            $wbsMaterial->update();
                        }
                    }else{
                        $bomPrep = new BomPrep;
                        $bomPrep->project_id = $datas->project_id;
                        $bomPrep->material_id = $material->material_id;
                        if($weight == 0){
                            $bomPrep->quantity = $material->quantity;
                        }else{
                            $bomPrep->weight = $weight;
                        }
                        $bomPrep->status = 1;
                        $bomPrep->source = $material->source;
                        $bomPrep->save();

                        $wbsMaterial->bom_prep_id = $bomPrep->id;
                        $wbsMaterial->update();
                    }
                }
            }
            DB::commit();
            return redirect()->route('bom_repair.selectWBSManage', ['id' => $datas->project_id])->with('success', 'Material Standard Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom_repair.selectProjectManage')->with('error', $e->getMessage());
        }
    }

    public function storeWbsMaterialBuilding(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $wbs = WBS::find($datas->wbs_id);
        $top_wbs = self::getTopWbs($wbs);
        DB::beginTransaction();
        try {
            foreach($datas->materials as $material){
                if(count($material->part_details) > 0){
                    foreach ($material->part_details as $part) {
                        $wbsMaterial = new WbsMaterial;
                        $wbsMaterial->wbs_id = $datas->wbs_id;
                        $wbsMaterial->part_description = $part->description;
                        $wbsMaterial->material_id = $material->material_id;
                        $wbsMaterial->quantity = $part->quantity;
                        if($part->dimensions_value_obj != null){
                            foreach ($part->dimensions_value_obj as $dimension) {
                                unset($dimension->value);
                                unset($dimension->uom);
                            }
                            $temp_dimensions_value = json_encode($part->dimensions_value_obj);
                            $wbsMaterial->dimensions_value = $temp_dimensions_value;
                        }
                        $old_material_source = $material->source;
                        $wbsMaterial->source = $material->source;
                        $wbsMaterial->weight = $part->weight;
                        $wbsMaterial->save();

                        $weight = $part->weight;

                        $modelBomPrep = BomPrep::where('wbs_id', $top_wbs->id)->where('material_id', $material->material_id)->where('source', $old_material_source)->get();
                        if(count($modelBomPrep) > 0){
                            $not_found_bom_prep = false;
                            $not_added = true;
                            foreach ($modelBomPrep as $bomPrep) {
                                if($bomPrep->status == 1){
                                    if($weight == 0){
                                        $bomPrep->quantity += $material->quantity;
                                    }else{
                                        $bomPrep->weight += $weight;
                                    }
                                    $bomPrep->source = $material->source;
                                    $bomPrep->update();

                                    $wbsMaterial->bom_prep_id = $bomPrep->id;
                                    $wbsMaterial->update();

                                    $not_added = false;
                                }else{
                                    $not_found_bom_prep = true;
                                }

                            }
                            if($not_found_bom_prep && $not_added){
                                $bomPrep = new BomPrep;
                                $bomPrep->project_id = $datas->project_id;
                                $bomPrep->wbs_id = $top_wbs->id;
                                $bomPrep->material_id = $material->material_id;
                                if($weight == 0){
                                    $bomPrep->quantity = $material->quantity;
                                }else{
                                    $bomPrep->weight = $weight;
                                }
                                $bomPrep->status = 1;
                                $bomPrep->source = $material->source;
                                $bomPrep->save();

                                $wbsMaterial->bom_prep_id = $bomPrep->id;
                                $wbsMaterial->update();
                            }
                        }else{
                            $bomPrep = new BomPrep;
                            $bomPrep->project_id = $datas->project_id;
                            $bomPrep->wbs_id = $top_wbs->id;
                            $bomPrep->material_id = $material->material_id;
                            if($weight == 0){
                                $bomPrep->quantity = $material->quantity;
                            }else{
                                $bomPrep->weight = $weight;
                            }
                            $bomPrep->status = 1;
                            $bomPrep->source = $material->source;
                            $bomPrep->save();

                            $wbsMaterial->bom_prep_id = $bomPrep->id;
                            $wbsMaterial->update();
                        }
                    }
                }else{

                    $wbsMaterial = new WbsMaterial;
                    $wbsMaterial->wbs_id = $datas->wbs_id;
                    $wbsMaterial->material_id = $material->material_id;
                    $wbsMaterial->quantity = $material->quantity;
                    if(isset($material->dimensions_value)){
                        $wbsMaterial->dimensions_value = $material->dimensions_value;
                    }else{
                        $wbsMaterial->dimensions_value = null;
                    }
                    $old_material_source = $material->source;
                    $wbsMaterial->source = $material->source;
                    $wbsMaterial->save();

                    if($wbsMaterial->dimensions_value == null){
                        $weight = 0;
                    }


                    $modelBomPrep = BomPrep::where('wbs_id', $top_wbs->id)->where('material_id', $material->material_id)->where('source', $old_material_source)->get();
                    
                    if(count($modelBomPrep) > 0){
                        $not_found_bom_prep = false;
                        $not_added = true;
                        foreach ($modelBomPrep as $bomPrep) {
                            if($bomPrep->status == 1){
                                if($weight == 0){
                                    $bomPrep->quantity += $material->quantity;
                                }else{
                                    $bomPrep->weight += $weight;
                                }
                                $bomPrep->source = $material->source;
                                $bomPrep->update();

                                $wbsMaterial->bom_prep_id = $bomPrep->id;
                                $wbsMaterial->update();

                                $not_added = false;
                            }else{
                                $not_found_bom_prep = true;
                            }

                        }
                        if($not_found_bom_prep && $not_added){
                            $bomPrep = new BomPrep;
                            $bomPrep->project_id = $datas->project_id;
                            $bomPrep->wbs_id = $top_wbs->id;
                            $bomPrep->material_id = $material->material_id;
                            if($weight == 0){
                                $bomPrep->quantity = $material->quantity;
                            }else{
                                $bomPrep->weight = $weight;
                            }
                            $bomPrep->status = 1;
                            $bomPrep->source = $material->source;
                            $bomPrep->save();

                            $wbsMaterial->bom_prep_id = $bomPrep->id;
                            $wbsMaterial->update();
                        }
                    }else{
                        $bomPrep = new BomPrep;                        
                        $bomPrep->project_id = $datas->project_id;
                        $bomPrep->wbs_id = $top_wbs->id;
                        $bomPrep->material_id = $material->material_id;
                        if($weight == 0){
                            $bomPrep->quantity = $material->quantity;
                        }else{
                            $bomPrep->weight = $weight;
                        }
                        $bomPrep->status = 1;
                        $bomPrep->source = $material->source;
                        $bomPrep->save();

                        $wbsMaterial->bom_prep_id = $bomPrep->id;
                        $wbsMaterial->update();
                    }
                }
            }
            DB::commit();
            return redirect()->route('bom.selectWBS', ['id' => $datas->project_id])->with('success', 'Material Standard Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom.selectProject')->with('error', $e->getMessage());
        }
    }

    public function updateWbsMaterial(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            $wbs = WBS::find($datas->wbs_id);
            if($datas->service_detail_id != ""){
                $wbs->service_detail_id = $datas->service_detail_id;
                $wbs->vendor_id = $datas->vendor_id;
                $wbs->area = $datas->area;
                $wbs->area_uom_id = $datas->area_uom_id;
            }
            $wbs->update();

            foreach ($datas->deleted_id as $id) {
                $wbsMaterials = WbsMaterial::where('material_id',$id)->where('wbs_id',$datas->wbs_id)->get();
                foreach ($wbsMaterials as $wbsMaterial) {
                    $bomPrep = $wbsMaterial->bomPrep;
                    if($bomPrep->weight != null){
                        $bomPrep->weight -= $wbsMaterial->weight;
                        $bomPrep->update();
                    }else{
                        $bomPrep->quantity -= $wbsMaterial->quantity;
                        $bomPrep->update();
                    }
                    $wbsMaterial->delete();
                }
            }
            foreach ($datas->deleted_part_id as $id) {
                $wbsMaterial = WbsMaterial::find($id);

                $bomPrep = $wbsMaterial->bomPrep;
                if($bomPrep->weight != null){
                    $bomPrep->weight -= $wbsMaterial->weight;
                    $bomPrep->update();
                }
                $wbsMaterial->delete();
            }
            foreach($datas->materials as $material){
                if(count($material->part_details) > 0){
                    foreach ($material->part_details as $part) {
                        $there_are_changes = false;
                        if(isset($part->id)){
                            $wbsMaterial = WbsMaterial::find($part->id);
                            if($wbsMaterial->source != null){
                                $old_material_source = $wbsMaterial->source;
                            }else{
                                $old_material_source = $material->source;
                            }
                            $wbsMaterial->material_id = $material->material_id;
                            $wbsMaterial->quantity = $part->quantity;

                            if($part->dimensions_value_obj != null){
                                foreach ($part->dimensions_value_obj as $dimension) {
                                    unset($dimension->value);
                                    unset($dimension->uom);
                                }
                                $temp_dimensions_value = json_encode($part->dimensions_value_obj);
                                $wbsMaterial->dimensions_value = $temp_dimensions_value;
                            }
                            $wbsMaterial->source = $material->source;
                            $wbsMaterial->update();

                            if(count($wbsMaterial->getChanges())>0){
                                $there_are_changes = true;
                            }
                        }else{
                            $wbsMaterial = new WbsMaterial;
                            $wbsMaterial->wbs_id = $datas->wbs_id;
                            $wbsMaterial->material_id = $material->material_id;
                            $wbsMaterial->quantity = $part->quantity;
                            if($part->dimensions_value_obj != null){
                                foreach ($part->dimensions_value_obj as $dimension) {
                                    unset($dimension->value);
                                    unset($dimension->uom);
                                }
                                $temp_dimensions_value = json_encode($part->dimensions_value_obj);
                                $wbsMaterial->dimensions_value = $temp_dimensions_value;
                            }
                            $old_material_source = $material->source;
                            $wbsMaterial->source = $material->source;
                            $wbsMaterial->save();

                            $there_are_changes = true;
                        }

                        $old_weight = $wbsMaterial->weight;
                        $weight = $part->weight;
                        $wbsMaterial->weight = $part->weight;
                        $wbsMaterial->update();

                        $modelBomPrep = BomPrep::where('project_id', $datas->project_id)->where('material_id', $material->material_id)->where('source', $old_material_source)->get();
                        if(count($modelBomPrep) > 0){
                            $not_found_bom_prep = false;
                            $not_added = true;
                            foreach ($modelBomPrep as $bomPrep) {
                                if($bomPrep->status == 1){
                                    if($weight == 0 && $there_are_changes){
                                        $bomPrep->quantity += $material->quantity;
                                    }else{
                                        if($there_are_changes){
                                            if($weight != $old_weight){
                                                $bomPrep->weight += $weight - $old_weight;
                                            }else{
                                                $bomPrep->weight += $weight;
                                            }
                                        }
                                    }
                                    $bomPrep->source = $material->source;
                                    $bomPrep->update();

                                    $wbsMaterial->bom_prep_id = $bomPrep->id;
                                    $wbsMaterial->update();

                                    $not_added = false;
                                }else{
                                    $not_found_bom_prep = true;
                                }

                            }
                            if($not_found_bom_prep && $not_added){
                                $bomPrep = new BomPrep;
                                $bomPrep->project_id = $datas->project_id;
                                $bomPrep->material_id = $material->material_id;
                                if($weight == 0){
                                    $bomPrep->quantity = $material->quantity;
                                }else{
                                    $bomPrep->weight = $weight;
                                }
                                $bomPrep->status = 1;
                                $bomPrep->source = $material->source;
                                $bomPrep->save();

                                $wbsMaterial->bom_prep_id = $bomPrep->id;
                                $wbsMaterial->update();
                            }
                        }else{
                            $bomPrep = new BomPrep;
                            $bomPrep->project_id = $datas->project_id;
                            $bomPrep->material_id = $material->material_id;
                            if($weight == 0){
                                $bomPrep->quantity = $material->quantity;
                            }else{
                                $bomPrep->weight = $weight;
                            }
                            $bomPrep->status = 1;
                            $bomPrep->source = $material->source;
                            $bomPrep->save();

                            $wbsMaterial->bom_prep_id = $bomPrep->id;
                            $wbsMaterial->update();
                        }
                    }
                }else{
                    $there_are_changes = false;
                    if(isset($material->id)){
                        $wbsMaterial = WbsMaterial::find($material->id);
                        if($wbsMaterial->source != null){
                            $old_material_source = $wbsMaterial->source;
                        }else{
                            $old_material_source = $material->source;
                        }
                        $wbsMaterial->material_id = $material->material_id;
                        $wbsMaterial->quantity = $material->quantity;
                        if(isset($material->dimensions_value)){
                            $wbsMaterial->dimensions_value = $material->dimensions_value;
                        }else{
                            $wbsMaterial->dimensions_value = null;
                        }
                        $wbsMaterial->source = $material->source;
                        $wbsMaterial->update();

                        if(count($wbsMaterial->getChanges())>0){
                            $there_are_changes = true;
                        }
                    }else{
                        $wbsMaterial = new WbsMaterial;
                        $wbsMaterial->wbs_id = $datas->wbs_id;
                        $wbsMaterial->material_id = $material->material_id;
                        $wbsMaterial->quantity = $material->quantity;
                        if(isset($material->dimensions_value)){
                            $wbsMaterial->dimensions_value = $material->dimensions_value;
                        }else{
                            $wbsMaterial->dimensions_value = null;
                        }
                        $old_material_source = $material->source;
                        $wbsMaterial->source = $material->source;
                        $wbsMaterial->save();

                        $there_are_changes = true;
                    }
                    if($wbsMaterial->dimensions_value == null){
                        $weight = 0;
                        $old_weight = $wbsMaterial->weight;
                    }

                    $modelBomPrep = BomPrep::where('project_id', $datas->project_id)->where('material_id', $material->material_id)->where('source', $old_material_source)->get();
                    if(count($modelBomPrep) > 0){
                        $not_found_bom_prep = false;
                        $not_added = true;
                        foreach ($modelBomPrep as $bomPrep) {
                            if($bomPrep->status == 1){
                                if($weight == 0 && $there_are_changes){
                                    $bomPrep->quantity += $material->quantity;
                                    if($old_weight != 0){
                                        $bomPrep->weight += $weight - $old_weight;
                                    }
                                }else{
                                    if($there_are_changes){
                                        if($weight != $old_weight){
                                            $bomPrep->weight += $weight - $old_weight;
                                        }else{
                                            $bomPrep->weight += $weight;
                                        }
                                    }
                                }
                                $bomPrep->source = $material->source;
                                $bomPrep->update();

                                $wbsMaterial->bom_prep_id = $bomPrep->id;
                                $wbsMaterial->update();

                                $not_added = false;
                            }else{
                                $not_found_bom_prep = true;
                            }

                        }
                        if($not_found_bom_prep && $not_added){
                            $bomPrep = new BomPrep;
                            $bomPrep->project_id = $datas->project_id;
                            $bomPrep->material_id = $material->material_id;
                            if($weight == 0){
                                $bomPrep->quantity = $material->quantity;
                            }else{
                                $bomPrep->weight = $weight;
                            }
                            $bomPrep->status = 1;
                            $bomPrep->source = $material->source;
                            $bomPrep->save();

                            $wbsMaterial->bom_prep_id = $bomPrep->id;
                            $wbsMaterial->update();
                        }
                    }else{
                        $bomPrep = new BomPrep;
                        $bomPrep->project_id = $datas->project_id;
                        $bomPrep->material_id = $material->material_id;
                        if($weight == 0){
                            $bomPrep->quantity = $material->quantity;
                        }else{
                            $bomPrep->weight = $weight;
                        }
                        $bomPrep->status = 1;
                        $bomPrep->source = $material->source;
                        $bomPrep->save();

                        $wbsMaterial->bom_prep_id = $bomPrep->id;
                        $wbsMaterial->update();
                    }
                }
            }
            DB::commit();
            if($datas->edit){
                return redirect()->route('bom_repair.selectWBSManage', ['id' => $datas->project_id])->with('success', 'Material Standard Updated');
            }else{
                return redirect()->route('bom_repair.selectWBSManage', ['id' => $datas->project_id])->with('success', 'Material Standard Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom_repair.selectProjectManage')->with('error', $e->getMessage());
        }
    }

    public function updateWbsMaterialBuilding(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $wbs = WBS::find($datas->wbs_id);
        $top_wbs = self::getTopWbs($wbs);
        DB::beginTransaction();
        try {
            $wbs = WBS::find($datas->wbs_id);
            if($datas->service_detail_id != ""){
                $wbs->service_detail_id = $datas->service_detail_id;
                $wbs->vendor_id = $datas->vendor_id;
                $wbs->area = $datas->area;
                $wbs->area_uom_id = $datas->area_uom_id;
            }
            $wbs->update();

            foreach ($datas->deleted_id as $id) {
                $wbsMaterials = WbsMaterial::where('material_id',$id)->where('wbs_id',$datas->wbs_id)->get();
                foreach ($wbsMaterials as $wbsMaterial) {
                    $bomPrep = $wbsMaterial->bomPrep;
                    if($bomPrep->weight != null){
                        $bomPrep->weight -= $wbsMaterial->weight;
                        $bomPrep->update();
                    }else{
                        $bomPrep->quantity -= $wbsMaterial->quantity;
                        $bomPrep->update();
                    }
                    $wbsMaterial->delete();
                }
            }
            foreach ($datas->deleted_part_id as $id) {
                $wbsMaterial = WbsMaterial::find($id);

                $bomPrep = $wbsMaterial->bomPrep;
                if($bomPrep->weight != null){
                    $bomPrep->weight -= $wbsMaterial->weight;
                    $bomPrep->update();
                }
                $wbsMaterial->delete();
            }
            foreach($datas->materials as $material){
                if(count($material->part_details) > 0){
                    foreach ($material->part_details as $part) {
                        $there_are_changes = false;
                        if(isset($part->id)){
                            $wbsMaterial = WbsMaterial::find($part->id);
                            if($wbsMaterial->source != null){
                                $old_material_source = $wbsMaterial->source;
                            }else{
                                $old_material_source = $material->source;
                            }
                            $wbsMaterial->material_id = $material->material_id;
                            $wbsMaterial->quantity = $part->quantity;

                            if($part->dimensions_value_obj != null){
                                foreach ($part->dimensions_value_obj as $dimension) {
                                    unset($dimension->value);
                                    unset($dimension->uom);
                                }
                                $temp_dimensions_value = json_encode($part->dimensions_value_obj);
                                $wbsMaterial->dimensions_value = $temp_dimensions_value;
                            }
                            $wbsMaterial->source = $material->source;
                            $wbsMaterial->update();

                            if(count($wbsMaterial->getChanges())>0){
                                $there_are_changes = true;
                            }
                        }else{
                            $wbsMaterial = new WbsMaterial;
                            $wbsMaterial->wbs_id = $datas->wbs_id;
                            $wbsMaterial->material_id = $material->material_id;
                            $wbsMaterial->quantity = $part->quantity;
                            if($part->dimensions_value_obj != null){
                                foreach ($part->dimensions_value_obj as $dimension) {
                                    unset($dimension->value);
                                    unset($dimension->uom);
                                }
                                $temp_dimensions_value = json_encode($part->dimensions_value_obj);
                                $wbsMaterial->dimensions_value = $temp_dimensions_value;
                            }
                            $old_material_source = $material->source;
                            $wbsMaterial->source = $material->source;
                            $wbsMaterial->save();

                            $there_are_changes = true;
                        }

                        $old_weight = $wbsMaterial->weight;
                        $weight = $part->weight;
                        $wbsMaterial->weight = $part->weight;
                        $wbsMaterial->update();

                        $modelBomPrep = BomPrep::where('wbs_id', $top_wbs->id)->where('material_id', $material->material_id)->where('source', $old_material_source)->get();
                        if(count($modelBomPrep) > 0){
                            $not_found_bom_prep = false;
                            $not_added = true;
                            foreach ($modelBomPrep as $bomPrep) {
                                if($bomPrep->status == 1){
                                    if($weight == 0 && $there_are_changes){
                                        $bomPrep->quantity += $material->quantity;
                                    }else{
                                        if($there_are_changes){
                                            if($weight != $old_weight){
                                                $bomPrep->weight += $weight - $old_weight;
                                            }else{
                                                $bomPrep->weight += $weight;
                                            }
                                        }
                                    }
                                    $bomPrep->source = $material->source;
                                    $bomPrep->update();

                                    $wbsMaterial->bom_prep_id = $bomPrep->id;
                                    $wbsMaterial->update();

                                    $not_added = false;
                                }else{
                                    $not_found_bom_prep = true;
                                }

                            }
                            if($not_found_bom_prep && $not_added){
                                $bomPrep = new BomPrep;
                                $bomPrep->project_id = $datas->project_id;
                                $bomPrep->wbs_id = $top_wbs->id;
                                $bomPrep->material_id = $material->material_id;
                                if($weight == 0){
                                    $bomPrep->quantity = $material->quantity;
                                }else{
                                    $bomPrep->weight = $weight;
                                }
                                $bomPrep->status = 1;
                                $bomPrep->source = $material->source;
                                $bomPrep->save();

                                $wbsMaterial->bom_prep_id = $bomPrep->id;
                                $wbsMaterial->update();
                            }
                        }else{
                            $bomPrep = new BomPrep;
                            $bomPrep->project_id = $datas->project_id;
                            $bomPrep->wbs_id = $top_wbs->id;
                            $bomPrep->material_id = $material->material_id;
                            if($weight == 0){
                                $bomPrep->quantity = $material->quantity;
                            }else{
                                $bomPrep->weight = $weight;
                            }
                            $bomPrep->status = 1;
                            $bomPrep->source = $material->source;
                            $bomPrep->save();

                            $wbsMaterial->bom_prep_id = $bomPrep->id;
                            $wbsMaterial->update();
                        }
                    }
                }else{
                    $there_are_changes = false;
                    if(isset($material->id)){
                        $wbsMaterial = WbsMaterial::find($material->id);
                        if($wbsMaterial->source != null){
                            $old_material_source = $wbsMaterial->source;
                        }else{
                            $old_material_source = $material->source;
                        }
                        $wbsMaterial->material_id = $material->material_id;
                        $wbsMaterial->quantity = $material->quantity;
                        if(isset($material->dimensions_value)){
                            $wbsMaterial->dimensions_value = $material->dimensions_value;
                        }else{
                            $wbsMaterial->dimensions_value = null;
                        }
                        $wbsMaterial->source = $material->source;
                        $wbsMaterial->update();

                        if(count($wbsMaterial->getChanges())>0){
                            $there_are_changes = true;
                        }
                    }else{
                        $wbsMaterial = new WbsMaterial;
                        $wbsMaterial->wbs_id = $datas->wbs_id;
                        $wbsMaterial->material_id = $material->material_id;
                        $wbsMaterial->quantity = $material->quantity;
                        if(isset($material->dimensions_value)){
                            $wbsMaterial->dimensions_value = $material->dimensions_value;
                        }else{
                            $wbsMaterial->dimensions_value = null;
                        }
                        $old_material_source = $material->source;
                        $wbsMaterial->source = $material->source;
                        $wbsMaterial->save();

                        $there_are_changes = true;
                    }
                    if($wbsMaterial->dimensions_value == null){
                        $weight = 0;
                        $old_weight = $wbsMaterial->weight;
                    }

                    $modelBomPrep = BomPrep::where('wbs_id', $top_wbs->id)->where('material_id', $material->material_id)->where('source', $old_material_source)->get();
                    if(count($modelBomPrep) > 0){
                        $not_found_bom_prep = false;
                        $not_added = true;
                        foreach ($modelBomPrep as $bomPrep) {
                            if($bomPrep->status == 1){
                                if($weight == 0 && $there_are_changes){
                                    $bomPrep->quantity += $material->quantity;
                                    if($old_weight != 0){
                                        $bomPrep->weight += $weight - $old_weight;
                                    }
                                }else{
                                    if($there_are_changes){
                                        if($weight != $old_weight){
                                            $bomPrep->weight += $weight - $old_weight;
                                        }else{
                                            $bomPrep->weight += $weight;
                                        }
                                    }
                                }
                                $bomPrep->source = $material->source;
                                $bomPrep->update();

                                $wbsMaterial->bom_prep_id = $bomPrep->id;
                                $wbsMaterial->update();

                                $not_added = false;
                            }else{
                                $not_found_bom_prep = true;
                            }

                        }
                        if($not_found_bom_prep && $not_added){
                            $bomPrep = new BomPrep;
                            $bomPrep->project_id = $datas->project_id;
                            $bomPrep->wbs_id = $top_wbs->id;
                            $bomPrep->material_id = $material->material_id;
                            if($weight == 0){
                                $bomPrep->quantity = $material->quantity;
                            }else{
                                $bomPrep->weight = $weight;
                            }
                            $bomPrep->status = 1;
                            $bomPrep->source = $material->source;
                            $bomPrep->save();

                            $wbsMaterial->bom_prep_id = $bomPrep->id;
                            $wbsMaterial->update();
                        }
                    }else{
                        $bomPrep = new BomPrep;
                        $bomPrep->project_id = $datas->project_id;
                        $bomPrep->wbs_id = $top_wbs->id;
                        $bomPrep->material_id = $material->material_id;
                        if($weight == 0){
                            $bomPrep->quantity = $material->quantity;
                        }else{
                            $bomPrep->weight = $weight;
                        }
                        $bomPrep->status = 1;
                        $bomPrep->source = $material->source;
                        $bomPrep->save();

                        $wbsMaterial->bom_prep_id = $bomPrep->id;
                        $wbsMaterial->update();
                    }
                }
            }
            DB::commit();
            if($datas->edit){
                return redirect()->route('bom.selectWBS', ['id' => $datas->project_id])->with('success', 'Material Standard Updated');
            }else{
                return redirect()->route('bom.selectWBS', ['id' => $datas->project_id])->with('success', 'Material Standard Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom.selectProject')->with('error', $e->getMessage());
        }
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
                self::createRapRepair($bom);
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
                $bom->wbs_id = $datas->wbs_id;
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

            // foreach ($datas->fulfilledBomPrep as $bom_prep_id) {
            //     $bom_prep = BomPrep::find($bom_prep_id);
            //     $bom_prep->status = 0;
            //     $bom_prep->update();
            // }

            self::saveBomDetailBuilding($bom,$datas->bom_preps, $rap);
            if($rap == null){
                // self::createRapRepair($bom);
            }

            DB::commit();
            return redirect()->route('bom.show', ['id' => $bom->id])->with('success', 'BOM Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('bom.materialSummaryBuilding',['id' => $datas->wbs_id])->with('error', $e->getMessage());
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
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $modelBOMDetail = BomDetail::findOrFail($data['bom_detail_id']);
            $old_qty = $modelBOMDetail->quantity;
            $diff = $data['quantity'] - $modelBOMDetail->quantity;
            $modelBOMDetail->quantity = $data['quantity'];
            $modelBOMDetail->material_id = ($data['material_id'] != '') ? $data['material_id'] : null;
            if(isset($data['service_id'])){
                $modelBOMDetail->service_id = ($data['service_id'] != '') ? $data['service_id'] : null;
            }
            $old_resource = $modelBOMDetail->source;
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
                    if($old_resource == "WIP" && $modelBOMDetail->source == "Stock"){
                        if($modelStock){
                            $modelStock->reserved += $data['quantity'];
                            $modelStock->update();
                        }else{
                            $modelStock = new Stock;
                            $modelStock->material_id = $modelBOMDetail->material_id;
                            $modelStock->quantity = 0;
                            $modelStock->reserved += $data['quantity'];
                            $modelStock->reserved_gi = 0;
                            $modelStock->branch_id = Auth::user()->branch->id;
                            $modelStock->save();
                        }
                    }elseif($old_resource == "Stock" && $modelBOMDetail->source == "WIP"){
                        $modelStock->reserved -= $old_qty;
                        $modelStock->update();
                    }elseif($old_resource == "Stock" && $modelBOMDetail->source == "Stock"){
                        if($modelStock){
                            $modelStock->reserved += $diff;
                            $modelStock->update();
                        }else{
                            $modelStock = new Stock;
                            $modelStock->material_id = $modelBOMDetail->material_id;
                            $modelStock->quantity = 0;
                            $modelStock->reserved += $diff;
                            $modelStock->reserved_gi = 0;
                            $modelStock->branch_id = Auth::user()->branch->id;
                            $modelStock->save();
                        }
                    }
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

    private function saveBomDetailBuilding($bom, $bom_preps, $rap){
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
                            $bom_detail_input->source = $bom_prep_model->source;
                            $bom_detail_input->type = "Planned";

                            $stock = Stock::where('material_id', $bom_detail->material_id)->first();
                            if($stock == null){
                                $new_stock = new Stock;
                                $new_stock->material_id = $bom_detail->material_id;
                                $new_stock->quantity = 0;
                                $new_stock->reserved = $bom_detail->prepared;
                                $new_stock->branch_id = Auth::user()->branch->id;
                                if($bom_detail_input->source == "Stock"){
                                    $bom_detail_input->pr_quantity = $bom_detail->prepared;
                                }
                                $new_stock->save();
                            }else{
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
                            }

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
                            if($stock == null){
                                $new_stock = new Stock;
                                $new_stock->material_id = $bom_detail_update->material_id;
                                $new_stock->quantity = 0;
                                $new_stock->reserved = $bom_detail->prepared - $temp_quantity;
                                $new_stock->branch_id = Auth::user()->branch->id;
                                $new_stock->save();
                                if($bom_detail_input->source == "Stock"){
                                    $bom_detail_input->pr_quantity = $bom_detail->prepared;
                                }
                            }else{
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
                            }
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
        }

        if($rap != null){
            $total_price = self::calculateTotalPrice($rap->id);

            $rap->total_price = $total_price;
            $rap->update();
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
                            $bom_detail_input->source = $bom_prep_model->source;

                            $stock = Stock::where('material_id', $bom_detail->material_id)->first();
                            if($stock == null){
                                $new_stock = new Stock;
                                $new_stock->material_id = $bom_detail->material_id;
                                $new_stock->quantity = 0;
                                $new_stock->reserved = $bom_detail->prepared;
                                $new_stock->branch_id = Auth::user()->branch->id;
                                if($bom_detail_input->source == "Stock"){
                                    $bom_detail_input->pr_quantity = $bom_detail->prepared;
                                }
                                $new_stock->save();
                            }else{
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
                            }

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
                            if($stock == null){
                                $new_stock = new Stock;
                                $new_stock->material_id = $bom_detail_update->material_id;
                                $new_stock->quantity = 0;
                                $new_stock->reserved = $bom_detail->prepared - $temp_quantity;
                                $new_stock->branch_id = Auth::user()->branch->id;
                                $new_stock->save();
                                if($bom_detail_input->source == "Stock"){
                                    $bom_detail_input->pr_quantity = $bom_detail->prepared;
                                }
                            }else{
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
                            }
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
                    if($bom_detail->pr_quantity != null && $bom_detail->source != "WIP"){
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
            // $rap_detail->service_id = $bomDetail->service_id;
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
            $rap_detail->source = $bomDetail->source;
            $rap_detail->save();
        }
    }

    public function createRapRepair($bom){
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
            self::saveRapDetailRepair($rap->id,$bom->bomDetails);
            $total_price = self::calculateTotalPrice($rap->id);

            $modelRap = Rap::findOrFail($rap->id);
            $modelRap->total_price = $total_price;
            $modelRap->save();
        }
    }

    public function saveRapDetailRepair($rap_id,$bomDetails){
        foreach($bomDetails as $bomDetail){
            $wbs_materials = $bomDetail->bomPrep->wbsMaterials;
            foreach ($wbs_materials as $wbs_material) {
                $exist_rap = RapDetail::where('material_id', $bomDetail->material_id)
                ->where('dimensions_value',$wbs_material->dimensions_value)
                ->where('source',$wbs_material->source)
                ->where('wbs_id',$wbs_material->wbs_id)->first();
                if($exist_rap != null){
                    $exist_rap->quantity += $wbs_material->quantity;
                    if($exist_rap->source == 'WIP'){
                        $exist_rap->price += $wbs_material->quantity * $wbs_material->material->cost_standard_price_service;
                    }else{
                        $exist_rap->price += $wbs_material->quantity * $wbs_material->material->cost_standard_price;
                    }
                    $rap_detail->update();
                }else{
                    $rap_detail = new RapDetail;
                    $rap_detail->rap_id = $rap_id;
                    $rap_detail->wbs_id = $wbs_material->wbs_id;
                    $rap_detail->material_id = $wbs_material->material_id;
                    $rap_detail->quantity = $wbs_material->quantity;
                    $rap_detail->dimensions_value = $wbs_material->dimensions_value;
                    $rap_detail->source = $wbs_material->source;
                    if($rap_detail->source == 'WIP'){
                        $rap_detail->price = $wbs_material->quantity * $wbs_material->material->cost_standard_price_service;
                    }else{
                        $rap_detail->price = $wbs_material->quantity * $wbs_material->material->cost_standard_price;
                    }
                    $rap_detail->save();
                }
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
        //$status = 1 => buat pr artinya
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
                        if($remaining < $bomDetail->quantity){
                            $PRD = new PurchaseRequisitionDetail;
                            $PRD->purchase_requisition_id = $PR->id;
                            $PRD->material_id = $bomDetail->material_id;
                            $PRD->quantity = $bomDetail->pr_quantity;
                            $PRD->project_id = $project_id;
                            $PRD->save();
                        }
                    }else{
                        if($status == 1){
                            $PRD = new PurchaseRequisitionDetail;
                            $PRD->purchase_requisition_id = $PR->id;
                            $PRD->material_id = $bomDetail->material_id;
                            $PRD->quantity = $bomDetail->pr_quantity;
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

        if($status == 1){
            //MAKE NOTIFICATION
            if($route == '/bom'){
                $data = json_encode([
                    'text' => 'Purchase Requisition ('.$PR->number.') has been created, action required',
                    'time_info' => 'Created at',
                    'title' => 'Purchase Requisition',
                    'url' => '/purchase_requisition/showApprove/'.$PR->id,
                ]);
            }else if($route == '/bom_repair'){
                $data = json_encode([
                    'text' => 'Purchase Requisition ('.$PR->number.') has been created, action required',
                    'time_info' => 'Created at',
                    'title' => 'Purchase Requisition',
                    'url' => '/purchase_requisition_repair/showApprove/'.$PR->id,
                ]);
            }

            $pr_value = $this->checkValueMaterial($PR->purchaseRequisitionDetails);
            $approval_config = Configuration::get('approval-pr')[0];
            foreach($approval_config->value as $pr_config){
                if($pr_config->minimum <= $pr_value && $pr_config->maximum >= $pr_value){
                    if($pr_config->role_id_1 != null){
                        $users = User::where('role_id', $pr_config->role_id_1)->select('id')->get();
                        foreach ($users as $user) {
                            $user->status = 1;
                        }
                        $users = json_encode($users);

                        $new_notification = new Notification;
                        $new_notification->type = "Purchase Requisition";
                        $new_notification->document_id = $PR->id;
                        $new_notification->role_id = $pr_config->role_id_1;
                        $new_notification->notification_date = $PR->created_at->toDateString();
                        $new_notification->data = $data;
                        $new_notification->user_data = $users;
                        $new_notification->save();

                        $PR->role_approve_1 = $pr_config->role_id_1;
                        $PR->save();
                    }

                    if($pr_config->role_id_2 != null){
                        $users = User::where('role_id', $pr_config->role_id_2)->select('id')->get();
                        foreach ($users as $user) {
                            $user->status = 1;
                        }
                        $users = json_encode($users);

                        $new_notification = new Notification;
                        $new_notification->type = "Purchase Requisition";
                        $new_notification->document_id = $PR->id;
                        $new_notification->role_id = $pr_config->role_id_2;
                        $new_notification->notification_date = $PR->created_at->toDateString();
                        $new_notification->data = $data;
                        $new_notification->user_data = $users;
                        $new_notification->save();

                        $PR->role_approve_2 = $pr_config->role_id_2;
                        $PR->save();
                    }
                }
            }
            // END MAKE NOTIF
        }
    }

    public function checkStockEdit($data){
        if(isset($data['source']) != false){
            if($data['source'] != "WIP"){
                if($data['material_id'] != null){
                    $modelStock = Stock::where('material_id',$data['material_id'])->first();
                    if(isset($modelStock)){
                        $modelStock->reserved += $data['quantity'];
                        $modelStock->update();
                    }else{
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

    // public function checkStockEdit($data,$project_id,$route){
    //     if($route=="/bom"){
    //         $business_unit = 1;
    //     }elseif($route == "/bom_repair"){
    //         $business_unit = 2;
    //     }
    //     // create PR (optional)
    //     if(isset($data['source']) != false){
    //         if($data['source'] != "WIP"){
    //             $status = 0;
    //             if($data['material_id'] != null){
    //                 $modelStock = Stock::where('material_id',$data['material_id'])->first();
    //                 if(!isset($modelStock)){
    //                     $status = 1;
    //                 }else{
    //                     $remaining = $modelStock->quantity - $modelStock->reserved;
    //                     if($remaining < $data['quantity']){
    //                         $status = 1;
    //                     }
    //                 }

    //                 if($status == 1){
    //                     $PR = PurchaseRequisition::where('bom_id',$data['bom_id'])->first();
    //                     if(!$PR){
    //                         $pr_number = $this->pr->generatePRNumber();
    //                         $modelProject = Project::findOrFail($project_id);

    //                         $PR = new PurchaseRequisition;
    //                         $PR->number = $pr_number;
    //                         $PR->business_unit_id = $business_unit;
    //                         $PR->type = 1;
    //                         $PR->bom_id = $data['bom_id'];
    //                         $PR->description = 'AUTO PR FOR '.$modelProject->number;
    //                         $PR->status = 1;
    //                         $PR->user_id = Auth::user()->id;
    //                         $PR->branch_id = Auth::user()->branch->id;
    //                         $PR->save();
    //                     }
    //                 }

    //                 // reservasi & PR Detail
    //                 $modelStock = Stock::where('material_id',$data['material_id'])->first();
    //                 $modelBom = Bom::findOrFail($data['bom_id']);
    //                 if(isset($modelStock)){
    //                     $remaining = $modelStock->quantity - $modelStock->reserved;
    //                     if($remaining < $data['quantity']){
    //                         $PRD = new PurchaseRequisitionDetail;
    //                         $PRD->purchase_requisition_id = $PR->id;
    //                         $PRD->project_id = $project_id;
    //                         $PRD->material_id = $data['material_id'];
    //                         $PRD->quantity = $data['quantity'] - $remaining;
    //                         $PRD->save();
    //                     }
    //                     $modelStock->reserved += $data['quantity'];
    //                     $modelStock->update();
    //                 }else{
    //                     $PRD = new PurchaseRequisitionDetail;
    //                     $PRD->purchase_requisition_id = $PR->id;
    //                     $PRD->material_id = $data['material_id'];
    //                     $PRD->quantity = $data['quantity'];
    //                     $PRD->save();

    //                     $modelStock = new Stock;
    //                     $modelStock->material_id = $data['material_id'];
    //                     $modelStock->quantity = 0;
    //                     $modelStock->reserved = $data['quantity'];
    //                     $modelStock->branch_id = Auth::user()->branch->id;
    //                     $modelStock->save();
    //                 }
    //             }
    //         }
    //     }
    // }

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

    public function checkValueMaterial($prds){
        $pr_value = 0;
        foreach ($prds as $prd) {
            $pr_value += $prd->material->cost_standard_price * $prd->quantity;
        }

        return $pr_value;
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

    private function getTopWbs($wbs)
    {
        if ($wbs) {
            if($wbs->wbs){
                return self::getTopWbs($wbs->wbs);
            }else{
                return $wbs;
            }
        }
    }
}
