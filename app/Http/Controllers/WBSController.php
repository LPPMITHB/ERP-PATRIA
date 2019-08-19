<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Models\Structure;
use App\Models\Project;
use App\Models\WBS;
use App\Models\Activity;
use App\Models\Category;
use App\Models\WbsProfile;
use App\Models\WbsStandard;
use App\Models\ActivityProfile;
use App\Models\BomProfile;
use App\Models\ResourceProfile;
use App\Models\Material;
use App\Models\Service;
use App\Models\Resource;
use App\Models\Bom;
use App\Models\BomDetail;
use App\Models\ResourceDetail;
use App\Models\Configuration;
use App\Models\ResourceTrx;
use DB;
use DateTime;
use Auth;

class WBSController extends Controller
{

    public function createWbsProfile(Request $request)
    {
        $project_type = Configuration::get('project_type');

        $menu = $request->route()->getPrefix() == "/wbs" ? "building" : "repair";
        return view('wbs.createWbsProfile', compact('menu','project_type'));
    }

    public function createBomProfile($wbs_id, Request $request)
    {
        $wbs = WbsProfile::find($wbs_id);
        $bom = BomProfile::where('wbs_id',$wbs_id)->with('material','service')->get();
        $route = $request->route()->getPrefix();

        $materials = Material::orderBy('code')->get();
        
        if($route == '/wbs'){
            if($wbs->business_unit_id == 1){
                return view('wbs.createBomProfile', compact('wbs','route','materials','bom'));
            }else{
                return redirect()->route('wbs.createWbsProfile')->with('error', 'WBS isn\'t exist, Please try again !');
            }
        }elseif($route == '/wbs_repair'){
            if($wbs->business_unit_id == 2){
                $services = Service::orderBy('code')->get()->jsonSerialize();
                return view('wbs.createBomRepairProfile', compact('wbs','route','materials','services','bom'));
            }else{
                return redirect()->route('wbs_repair.createWbsProfile')->with('error', 'WBS isn\'t exist, Please try again !');
            }
        }
    }

    public function storeBomProfile(Request $request){
        $route = $request->route()->getPrefix();
        $data = $request->json()->all();

        DB::beginTransaction();
        try{
            $bom = new BomProfile;
            $bom->wbs_id = $data['wbs_id'];
            $bom->material_id = ($data['material_id'] != '') ? $data['material_id'] : null;
            $bom->quantity = $data['quantityFloat'];
            if($route == "/wbs"){
                $bom->source = $data['source'];
            }else if($route == "/wbs_repair"){
                $bom->service_id = ($data['service_id'] != '') ? $data['service_id'] : null;
            }
            $bom->save();

            DB::commit();
            return response(json_encode($bom),Response::HTTP_OK);
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('wbs.createBomProfile',$data['wbs_id'])->with('error',$e->getMessage());
        }
    }

    public function updateBomProfile(Request $request){
        $route = $request->route()->getPrefix();
        $data = $request->json()->all();

        DB::beginTransaction();
        try{
            $bom = BomProfile::findOrFail($data['id']);
            $bom->material_id = ($data['material_id'] != '') ? $data['material_id'] : null;
            $bom->quantity = $data['quantityInt'];
            if($route == "/wbs"){
                $bom->source = $data['source'];
            }else if($route == "/wbs_repair"){
                $bom->service_id = ($data['service_id'] != '') ? $data['service_id'] : null;
            }
            $bom->update();

            DB::commit();
            return response(json_encode($bom),Response::HTTP_OK);
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('wbs.createBomProfile',$data['wbs_id'])->with('error',$e->getMessage());
        }
    }

    public function destroyBomProfile(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $bomProfile = BomProfile::findOrFail($id);
            $bomProfile->delete();

            DB::commit();
            return response(["response"=>"Success to delete material"],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function createResourceProfile($wbs_id, Request $request)
    {
        $wbs = WbsProfile::find($wbs_id);
        $route = $request->route()->getPrefix();
        $resources = Resource::all()->jsonSerialize();
        $resourceDetails = ResourceDetail::where('status','!=',0)->get()->jsonSerialize();
        $resource_categories = Configuration::get('resource_category');

        return view('wbs.createResourceProfile', compact('wbs','route','resources','resourceDetails','resource_categories'));
    }

    public function updateResourceProfile(Request $request){
        $route = $request->route()->getPrefix();
        $data = $request->json()->all();

        DB::beginTransaction();
        try{
            $resource = ResourceProfile::findOrFail($data['id']);
            $resource->resource_id = $data['resource_id'];
            $resource->resource_detail_id = ($data['resource_detail_id'] != '') ? $data['resource_detail_id'] : null;
            $resource->quantity = $data['quantity'];
            $resource->update();

            DB::commit();
            return response(json_encode($resource),Response::HTTP_OK);
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('wbs.createResourceProfile',$data['wbs_id'])->with('error',$e->getMessage());
        }
    }

    public function destroyResourceProfile(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $resourceProfile = ResourceProfile::findOrFail($id);
            $resourceProfile->delete();

            DB::commit();
            return response(["response"=>"Success to delete resource"],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeResourceProfile(Request $request){
        $route = $request->route()->getPrefix();
        $data = $request->json()->all();

        DB::beginTransaction();
        try{
            $resource_profile = new ResourceProfile;
            $resource_profile->wbs_id = $data['wbs_id'];
            $resource_profile->category_id = $data['category_id'];
            $resource_profile->resource_id = $data['resource_id'];
            $resource_profile->resource_detail_id = ($data['resource_detail_id'] != '') ? $data['resource_detail_id'] : null;
            $resource_profile->quantity = $data['quantity'];
            $resource_profile->save();

            DB::commit();
            return response(json_encode($resource_profile),Response::HTTP_OK);
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('wbs.createResourceProfile',$data['wbs_id'])->with('error',$e->getMessage());
        }
    }

    public function createSubWbsProfile($wbs_id, Request $request)
    {
        $wbs = WbsProfile::find($wbs_id);
        $menu = $request->route()->getPrefix() == "/wbs" ? "building" : "repair";
        if($menu=="building"){
            $array = [
                'Dashboard' => route('index'),
                'Create WBS Profile' => route('wbs.createWbsProfile'),
            ];
        }else{
            $array = [
                'Dashboard' => route('index'),
                'Create WBS Profile' => route('wbs_repair.createWbsProfile'),
            ];
        }
        $iteration = 0;
        $array_reverse = [];
        $array_reverse = array_reverse(self::getParentsWbsProfile($wbs,$array_reverse, $iteration, $menu));
        foreach ($array_reverse as $key => $value) {
            $array[$key] = $value;
        }
        $array[$wbs->number] = "";
        return view('wbs.createSubWbsProfile', compact('wbs','array','menu'));
    }


    public function createWBS($id, Request $request)
    {
        $project = Project::find($id);
        $menu = $project->business_unit_id == "1" ? "building" : "repair";
        if($menu == "building"){
            $businessUnit = 1;
        }elseif($menu == "repair"){
            $businessUnit = 2;
        }
        $wbs_profiles = WbsProfile::where('wbs_id', null)->where('business_unit_id', $businessUnit)->where('project_type_id', $project->project_type)->get()->jsonSerialize();

        return view('wbs.createWBS', compact('project','menu','wbs_profiles'));
    }

    public function createWbsRepair($id, Request $request)
    {
        $project = Project::find($id);
        $menu = "repair";
        $businessUnit = 2;
        $wbs_standard = WbsStandard::where('wbs_id', null)->get();

        return view('wbs.createWbsRepair', compact('project','menu','wbs_standard'));
    }

// public function createWbsRepair($id, Request $request)
// {
//     $project = Project::find($id);
//     $wbs_standard = WbsStandard::where('wbs_id', null)->get();

//     return view('wbs.createWbsRepair', compact('project','wbs_standard'));
// }


    public function store(Request $request)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $wbs = new WBS;
            $wbs->code = self::generateWbsCode($data['project_id']);
            $wbs->number = $data['number'];
            $wbs->description = $data['description'];
            $wbs->deliverables = $data['deliverables'];
            $wbs->project_id = $data['project_id'];

            if(isset($data['wbs_id'])){
                $wbs->wbs_id = $data['wbs_id'];
            }

            $planned_start_date = DateTime::createFromFormat('d-m-Y', $data['planned_start_date']);
            $wbs->planned_start_date =  $planned_start_date->format('Y-m-d');
            
            $planned_end_date = DateTime::createFromFormat('d-m-Y', $data['planned_end_date']);
            $wbs->planned_end_date =  $planned_end_date->format('Y-m-d');
            
            $wbs->planned_duration = $data['planned_duration'];
            $wbs->weight =  $data['weight'];
            $wbs->user_id = Auth::user()->id;
            $wbs->branch_id = Auth::user()->branch->id;
            

            if(!$wbs->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to create new WBS"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeWbsRepair(Request $request)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        $modelWbs = WBS::where('project_id',$data['project_id'])->where('number',$data['number'])->first();
        if($modelWbs != null){
            return response(["error"=> "WBS Number must be UNIQUE"],Response::HTTP_OK);
        }
        try {
            $wbsStandard = WbsStandard::find($data['wbs_standard_id']);
            $wbs = new WBS;
            $wbs->code = self::generateWbsCode($data['project_id']);
            $wbs->number = $data['number'];
            $wbs->description = $data['description'];
            $wbs->deliverables = $wbsStandard->deliverables;
            $wbs->wbs_standard_id = $wbsStandard->id;
            $wbs->project_id = $data['project_id'];

            if(isset($data['wbs_id'])){
                $wbs->wbs_id = $data['wbs_id'];
            }

            $planned_start_date = DateTime::createFromFormat('d-m-Y', $data['planned_start_date']);
            $wbs->planned_start_date =  $planned_start_date->format('Y-m-d');
            
            $planned_end_date = DateTime::createFromFormat('d-m-Y', $data['planned_end_date']);
            $wbs->planned_end_date =  $planned_end_date->format('Y-m-d');
            
            $wbs->planned_duration = $data['planned_duration'];
            $wbs->weight =  $data['weight'];
            $wbs->user_id = Auth::user()->id;
            $wbs->branch_id = Auth::user()->branch->id;
            

            if(!$wbs->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to create new WBS"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeWbsProfile(Request $request)
    {
        $data = $request->json()->all();
        $route = $request->route()->getPrefix();
        if($route == "/wbs"){
            $businessUnit = 1;
        }elseif($route == "/wbs_repair"){
            $businessUnit = 2;
        }
        DB::beginTransaction();
        try {
            $wbsProfile = new WbsProfile;
            $wbsProfile->number = $data['number'];
            $wbsProfile->description = $data['description'];
            $wbsProfile->deliverables = $data['deliverables'];
            $wbsProfile->duration = $data['duration'];

            if(isset($data['wbs_profile_id'])){
                $wbsProfile->wbs_id = $data['wbs_profile_id'];
            }

            if(isset($data['project_type'])){
                $wbsProfile->project_type_id = $data['project_type'];
            }

            $wbsProfile->user_id = Auth::user()->id;
            $wbsProfile->branch_id = Auth::user()->branch->id;
            $wbsProfile->business_unit_id = $businessUnit;

            if(!$wbsProfile->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to create new WBS Profile"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    
    public function adoptWbs(Request $request)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $wbsProfile = WbsProfile::find($data['selected_wbs_profile']);

            $wbs = new WBS;
            $wbs->code = self::generateWbsCode($data['project_id']);
            $wbs->number = $wbsProfile->number;
            $wbs->description = $wbsProfile->description;
            $wbs->deliverables = $wbsProfile->deliverables;
            $wbs->planned_duration = $wbsProfile->duration;
            $wbs->project_id = $data['project_id'];

            if(isset($data['parent_wbs'])){
                $wbs->wbs_id = $data['parent_wbs'];
            }
            $wbs->user_id = Auth::user()->id;
            $wbs->branch_id = Auth::user()->branch->id;
            $wbs->save();
            
            if(count($wbsProfile->activities)>0){
                foreach($wbsProfile->activities as $activity){
                    $activityInput = new Activity;
                    $activityInput->code = self::generateActivityCode($wbs->id);
                    $activityInput->name = $activity->name;
                    $activityInput->description = $activity->description;
                    $activityInput->planned_duration = $activity->duration;
                    $activityInput->wbs_id = $wbs->id;
                    $activityInput->user_id = Auth::user()->id;
                    $activityInput->branch_id = Auth::user()->branch->id;
                    $activityInput->save();
                }
            }
            $bomProfile = $wbsProfile->bom;
            if(count($bomProfile)>0){
                $bom = new Bom;
                $bom->code = self::generateBomCode($data['project_id']);
                $bom->description = "AUTO GENERATED FROM ADOPT WBS PROFILE";
                $bom->project_id = $data['project_id'];
                $bom->wbs_id = $wbs->id;
                $bom->branch_id = Auth::user()->branch->id;
                $bom->user_id = Auth::user()->id;
                $bom->save();
    
                foreach($bomProfile as $material){
                    $bom_detail = new BomDetail;
                    $bom_detail->bom_id = $bom->id;
                    $bom_detail->material_id = $material->material_id;
                    $bom_detail->quantity = $material->quantity;
                    $bom_detail->source = isset($material->source) ? $material->source : "Stock";
                    if(!$bom_detail->save()){
                        return response(["error"=> 'Failed Save Bom Detail !']);
                    }
                }
            }

            $resourceProfile = $wbsProfile->resources;
            if(count($resourceProfile)>0){
                foreach($resourceProfile as $resource){
                    $resourceInput = new ResourceTrx;
                    $resourceInput->resource_id = $resource->resource_id;
                    $resourceInput->resource_detail_id = $resource->resource_detail_id;
                    $resourceInput->category_id = $resource->category_id;
                    $resourceInput->project_id = $data['project_id'];
                    $resourceInput->wbs_id = $wbs->id;
                    $resourceInput->quantity = $resource->quantity;
                    $resourceInput->save();
                }
            }
            self::adoptWbsStructure($wbsProfile->wbss, $wbs->id,$data['project_id']);

            DB::commit();
            return response(["response"=>"Success to create adopt WBS"],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function updateWbsProfile(Request $request, $id)
    {
        $data = $request->json()->all();
        $wbs_ref = WbsProfile::find($id);
        DB::beginTransaction();
        try {
            $wbs_ref->number = $data['number'];
            $wbs_ref->description = $data['description'];
            $wbs_ref->deliverables = $data['deliverables'];
            $wbs_ref->duration = $data['duration'];

            if(!$wbs_ref->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update WBS ".$wbs_ref->number],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function createSubWBS($project_id, $wbs_id, Request $request)
    {
        $wbs = WBS::find($wbs_id);
        $project = Project::find($project_id);
        $menu = $project->business_unit_id == "1" ? "building" : "repair";
        if($menu == "building"){
            $businessUnit = 1;
        }elseif($menu == "repair"){
            $businessUnit = 2;
        }
        $wbs_profiles = WbsProfile::where('wbs_id', null)->where('business_unit_id', $businessUnit)->get()->jsonSerialize();

        if($menu=="building"){
            $array = [
                'Dashboard' => route('index'),
                'View all Projects' => route('project.index'),
                'Project|'.$project->number => route('project.show',$project->id),
                'Manage WBS' => route('wbs.createWBS',$project->id),
            ];
        }else{
            $array = [
                'Dashboard' => route('index'),
                'View all Projects' => route('project_repair.index'),
                'Project|'.$project->number => route('project_repair.show',$project->id),
                'Manage WBS' => route('wbs_repair.createWBS',$project->id),
            ];
        }
        $iteration = 0;
        $array_reverse = [];
        $array_reverse = array_reverse(self::getParents($wbs,$array_reverse,$project->id, $iteration, $menu));
        foreach ($array_reverse as $key => $value) {
            $array[$key] = $value;
        }
        
        $array["WBS ".$wbs->number] = "";
        return view('wbs.createSubWBS', compact('project', 'wbs','array','menu','wbs_profiles'));
    }

    public function createSubWbsRepair($project_id, $wbs_id, Request $request)
    {
        $wbs = WBS::find($wbs_id);
        if($wbs->weight == null){
            if($wbs->wbs != null){
                return redirect()->route('wbs_repair.createSubWBS', [$wbs->project_id,$wbs->wbs_id])->with('error', 'Please configure weight for WBS '.$wbs->number.' - '.$wbs->description);
            }else{
                return redirect()->route('wbs_repair.createWBS', [$wbs->project_id])->with('error', 'Please configure weight for WBS '.$wbs->number.' - '.$wbs->description);
            }
        }
        $wbs_standard = WbsStandard::where('wbs_id', $wbs->wbs_standard_id)->get();
        $project = Project::find($project_id);
        $menu = "repair";
        $businessUnit = 2;

        $array = [
            'Dashboard' => route('index'),
            'View all Projects' => route('project_repair.index'),
            'Project|'.$project->number => route('project_repair.show',$project->id),
            'Add WBS' => route('wbs_repair.createWBS',$project->id),
        ];

        $iteration = 0;
        $array_reverse = [];
        $array_reverse = array_reverse(self::getParents($wbs,$array_reverse,$project->id, $iteration, $menu));
        foreach ($array_reverse as $key => $value) {
            $array[$key] = $value;
        }
        
        $array["WBS ".$wbs->number] = "";
        return view('wbs.createSubWbsRepair', compact('project', 'wbs','array','menu','wbs_standard'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->json()->all();
        $wbs_ref = WBS::find($id);
        $wbss = WBS::where('project_id',$data['project_id'])->get();
        foreach ($wbss as $wbs) {
            if($wbs->number == $data['number'] && $wbs_ref->number != $data['number'] ){
                return response(["error"=>"WBS Name must be UNIQUE"],Response::HTTP_OK);
            }
        }
        DB::beginTransaction();
        try {
            $wbs_ref->number = $data['number'];
            $wbs_ref->description = $data['description'];
            $wbs_ref->deliverables = $data['deliverables'];
            $planned_start_date = DateTime::createFromFormat('d-m-Y', $data['planned_start_date']);
            $wbs_ref->planned_start_date =  $planned_start_date->format('Y-m-d');
            
            $planned_end_date = DateTime::createFromFormat('d-m-Y', $data['planned_end_date']);
            $wbs_ref->planned_end_date =  $planned_end_date->format('Y-m-d');
            
            $wbs_ref->planned_duration = $data['planned_duration'];
            $wbs_ref->weight =  $data['weight'];

            if(!$wbs_ref->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update WBS ".$wbs_ref->number],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function updateWbsRepair(Request $request, $id)
    {
        $data = $request->json()->all();
        $wbs_ref = WBS::find($id);
        $wbs_standard = WbsStandard::find($data['wbs_standard_id']);
        $modelWbs = WBS::where('id','!=',$id)->where('project_id',$wbs_ref->project_id)->where('number',$data['number'])->first();
        if($modelWbs != null){
            return response(["error"=> "WBS Number must be UNIQUE"],Response::HTTP_OK);
        }
        DB::beginTransaction();
        try {
            $wbs_ref->number = $data['number'];
            $wbs_ref->description = $data['description'];
            $wbs_ref->deliverables = $wbs_standard->deliverables;
            $wbs_ref->wbs_standard_id = $wbs_standard->id;
            $planned_start_date = DateTime::createFromFormat('d-m-Y', $data['planned_start_date']);
            $wbs_ref->planned_start_date =  $planned_start_date->format('Y-m-d');
            
            $planned_end_date = DateTime::createFromFormat('d-m-Y', $data['planned_end_date']);
            $wbs_ref->planned_end_date =  $planned_end_date->format('Y-m-d');
            
            $wbs_ref->planned_duration = $data['planned_duration'];
            $wbs_ref->weight =  $data['weight'];

            if(!$wbs_ref->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update WBS ".$wbs_ref->number],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function updateWithForm(Request $request, $id)
    {
        $data = json_decode($request->datas);
        $wbs_ref = WBS::find($id);
        $project = $wbs_ref->project;
        $menu = $project->business_unit_id == "1" ? "building" : "repair";
        $wbss = WBS::where('project_id',$data->project_id)->get();
        foreach ($wbss as $wbs) {
            if($wbs->number == $data->number && $wbs_ref->number != $data->number ){
                return response(["error"=>"WBS Number must be UNIQUE"],Response::HTTP_OK);
            }
        }
        DB::beginTransaction();
        try {
            $wbs_ref->number = $data->number;
            $wbs_ref->description = $data->description;
            $wbs_ref->deliverables = $data->deliverables;
            $planned_start_date = DateTime::createFromFormat('d-m-Y', $data->planned_start_date);
            $wbs_ref->planned_start_date =  $planned_start_date->format('Y-m-d');
            
            $planned_end_date = DateTime::createFromFormat('d-m-Y', $data->planned_end_date);
            $wbs_ref->planned_end_date =  $planned_end_date->format('Y-m-d');
            
            $wbs_ref->planned_duration = $data->planned_duration;
            $wbs_ref->weight =  $data->weight;

            if(!$wbs_ref->save()){
                if($menu == "building"){
                    return redirect()->route('wbs.show', ['id' => $id])->with('success', "Failed to save, please try again!");
                }elseif($menu == "repair"){
                    return redirect()->route('wbs_repair.show', ['id' => $id])->with('success', "Failed to save, please try again!");
                }
            }else{
                DB::commit();
                if($menu == "building"){
                    return redirect()->route('wbs.show', ['id' => $id])->with('success', 'WBS Successfully Updated');
                }elseif($menu == "repair"){
                    return redirect()->route('wbs_repair.show', ['id' => $id])->with('success', 'WBS Successfully Updated');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('wbs.show')->with( 'error',$e->getMessage())->withInput();
            }elseif($menu == "repair"){
                return redirect()->route('wbs_repair.show')->with( 'error',$e->getMessage())->withInput();
            }
        }
    }

    

    public function show($id, Request $request)
    {
        $wbs = WBS::find($id);
        $project = $wbs->project;
        $menu = $project->business_unit_id == "1" ? "building" : "repair";

        return view('wbs.show', compact('wbs','menu'));
    }

    public function destroyWbsProfile(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try {
            $wbsProfile = WbsProfile::find($id);
            $error = [];
            if(count($wbsProfile->wbss)>0){
                array_push($error, ["Failed to delete, this WBS have child WBS"]);
            }

            if(count($wbsProfile->activities)>0){
                array_push($error, ["Failed to delete, this WBS have activities"]);
            }
            if(count($wbsProfile->bom) > 0){
                array_push($error, ["Failed to delete, this WBS have BOM"]);
            }
            if(count($wbsProfile->resources)>0){
                array_push($error, ["Failed to delete, this WBS have resource"]);
            }

            if(count($error)>0){
                return response(["error"=> $error],Response::HTTP_OK);
            }
            if(!$wbsProfile->delete()){
                array_push($error, ["Failed to delete, please try again!"]);
                return response(["error"=> $error],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to delete WBS"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }


    public function destroyWbs(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try {
            $wbs = WBS::find($id);
            $error = [];
            if($wbs->productionOrder != null){
                array_push($error, ["Failed to delete, this WBS already have Production Order"]);                
                return response(["error"=> $error],Response::HTTP_OK);
            }

            if(count($wbs->wbss)>0){
                array_push($error, ["Failed to delete, this WBS have child WBS"]);
            }

            if(count($wbs->activities)>0){
                array_push($error, ["Failed to delete, this WBS have activities"]);
            }

            if(count($wbs->resourceTrxs)>0){
                array_push($error, ["Failed to delete, this WBS have assigned resource"]);
            }

            if($wbs->bom != null){
                array_push($error, ["Failed to delete, this WBS have BOM"]);
            }
            
            if(count($error)>0){
                return response(["error"=> $error],Response::HTTP_OK);
            }
            if(!$wbs->delete()){
                array_push($error, ["Failed to delete, please try again!"]);
                return response(["error"=> $error],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to delete WBS"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    //Methods
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

    //BUAT BREADCRUMB DINAMIS
    function getParentsWbsProfile($wbs, $array_reverse, $iteration, $menu) {
        if ($wbs) {
            if($wbs->wbs){
                if($menu == 'building'){
                    $array_reverse[$wbs->number] = route('wbs.createSubWbsProfile',[$wbs->wbs->id]);
                }else{
                    $array_reverse[$wbs->number] = route('wbs_repair.createSubWbsProfile',[$wbs->wbs->id]);
                }
                return self::getParentsWbsProfile($wbs->wbs,$array_reverse, $iteration,$menu);
            }else{
                if($menu == 'building'){
                    $array_reverse[$wbs->number] = route('wbs.createSubWbsProfile',[$wbs->id]);
                }else{
                    $array_reverse[$wbs->number] = route('wbs_repair.createSubWbsProfile',[$wbs->id]);
                }
                return $array_reverse;
            }
        }
    }

    //BUAT BREADCRUMB DINAMIS
    function getParents($wbs, $array_reverse, $project_id, $iteration, $menu) {
        if ($wbs) {
            if($wbs->wbs){
                if($menu == 'building'){
                    $array_reverse["WBS ".$wbs->number] = route('wbs.createSubWBS',[$project_id,$wbs->wbs->id]);
                }else{
                    $array_reverse["WBS ".$wbs->number] = route('wbs_repair.createSubWBS',[$project_id,$wbs->wbs->id]);
                }
                return self::getParents($wbs->wbs,$array_reverse, $project_id, $iteration,$menu);
            }else{
                if($menu == 'building'){
                    $array_reverse["WBS ".$wbs->number] = route('wbs.createSubWBS',[$project_id,$wbs->id]);
                }else{
                    $array_reverse["WBS ".$wbs->number] = route('wbs_repair.createSubWBS',[$project_id,$wbs->id]);
                }
                return $array_reverse;
            }
        }
    }

    public function getWbsProfileTree($dataWbsProfile, $wbss, $parent)
    {
        foreach($wbss as $wbs){
            if($wbs->wbss){
                if(count($wbs->activities)>0){
                    $dataWbsProfile->push([
                        "id" => "WBS".$wbs->id, 
                        "parent" => $parent,
                        "text" => $wbs->number,
                        "icon" => "fa fa-suitcase",
                    ]);
                    foreach($wbs->activities as $activity){
                        $dataWbsProfile->push([
                            "id" => "ACT".$activity->id, 
                            "parent" => "WBS".$activity->wbs_id,
                            "text" => $activity->name,
                            "icon" => "fa fa-clock-o",
                        ]);
                    }
                }else{
                    $dataWbsProfile->push([
                        "id" => "WBS".$wbs->id, 
                        "parent" => $parent,
                        "text" => $wbs->number,
                        "icon" => "fa fa-suitcase",
                    ]);
                }
                self::getWbsProfileTree($dataWbsProfile, $wbs->wbss, "WBS".$wbs->id);
            }else{
                if(count($wbs->activities)>0){
                    $dataWbsProfile->push([
                        "id" => "WBS".$wbs->id, 
                        "parent" => $parent,
                        "text" => $wbs->number,
                        "icon" => "fa fa-suitcase",
                    ]);
                    foreach($wbs->activities as $activity){
                        $dataWbsProfile->push([
                            "id" => "ACT".$activity->id, 
                            "parent" => "WBS".$activity->wbs_id,
                            "text" => $activity->name,
                            "icon" => "fa fa-clock-o",
                        ]);
                    }
                }else{
                    $dataWbsProfile->push([
                        "id" => "WBS".$wbs->id, 
                        "parent" => $parent,
                        "text" => $wbs->number,
                        "icon" => "fa fa-suitcase",
                    ]);
                }
            } 
        }
    }

    public function adoptWbsStructure($wbss, $parent, $project_id)
    {
        foreach($wbss as $wbs){
            if($wbs->wbss){
                if(count($wbs->activities)>0){
                    $wbsInput = new WBS;
                    $wbsInput->code = self::generateWbsCode($project_id);
                    $wbsInput->number = $wbs->number;
                    $wbsInput->description = $wbs->description;
                    $wbsInput->deliverables = $wbs->deliverables;
                    $wbsInput->planned_duration = $wbs->duration;
                    $wbsInput->project_id = $project_id;
                    $wbsInput->wbs_id = $parent;
                    $wbsInput->user_id = Auth::user()->id;
                    $wbsInput->branch_id = Auth::user()->branch->id;
                    $wbsInput->save();

                    foreach($wbs->activities as $activity){
                        $activityInput = new Activity;
                        $activityInput->code = self::generateActivityCode($wbsInput->id);
                        $activityInput->name = $activity->name;
                        $activityInput->description = $activity->description;
                        $activityInput->planned_duration = $activity->duration;
                        $activityInput->wbs_id = $wbsInput->id;
                        $activityInput->user_id = Auth::user()->id;
                        $activityInput->branch_id = Auth::user()->branch->id;
                        $activityInput->save();
                    }

                    if(count($wbs->bom)>0){
                        $bomProfile = $wbs->bom;
                        $bomInput = new Bom;
                        $bomInput->code = self::generateBomCode($project_id);
                        $bomInput->description = "AUTO GENERATED FROM ADOPT WBS PROFILE";
                        $bomInput->project_id = $project_id;
                        $bomInput->wbs_id = $wbsInput->id;
                        $bomInput->branch_id = Auth::user()->branch->id;
                        $bomInput->user_id = Auth::user()->id;
                        $bomInput->save();
    
                        foreach($bomProfile as $material){
                            $bom_detail = new BomDetail;
                            $bom_detail->bom_id = $bomInput->id;
                            $bom_detail->material_id = $material->material_id;
                            $bom_detail->quantity = $material->quantity;
                            $bom_detail->source = isset($material->source) ? $material->source : "Stock";
                            if(!$bom_detail->save()){
                                return response(["error"=> 'Failed Save Bom Detail !']);
                            }
                        }
                    }

                    $resourceProfile = $wbs->resources;
                    if(count($resourceProfile)>0){
                        foreach($resourceProfile as $resource){
                            $resourceInput = new ResourceTrx;
                            $resourceInput->resource_id = $resource->resource_id;
                            $resourceInput->resource_detail_id = $resource->resource_detail_id;
                            $resourceInput->category_id = $resource->category_id;
                            $resourceInput->project_id = $data['project_id'];
                            $resourceInput->wbs_id = $wbsInput->id;
                            $resourceInput->quantity = $resource->quantity;
                            $resourceInput->save();
                        }
                    }
                }else{
                    $wbsInput = new WBS;
                    $wbsInput->code = self::generateWbsCode($project_id);
                    $wbsInput->number = $wbs->number;
                    $wbsInput->description = $wbs->description;
                    $wbsInput->deliverables = $wbs->deliverables;
                    $wbsInput->planned_duration = $wbs->duration;
                    $wbsInput->project_id = $project_id;
                    $wbsInput->wbs_id = $parent;
                    $wbsInput->user_id = Auth::user()->id;
                    $wbsInput->branch_id = Auth::user()->branch->id;
                    $wbsInput->save();

                    if(count($wbs->bom)>0){
                        $bomProfile = $wbs->bom;
                        $bomInput = new Bom;
                        $bomInput->code = self::generateBomCode($project_id);
                        $bomInput->description = "AUTO GENERATED FROM ADOPT WBS PROFILE";
                        $bomInput->project_id = $project_id;
                        $bomInput->wbs_id = $wbsInput->id;
                        $bomInput->branch_id = Auth::user()->branch->id;
                        $bomInput->user_id = Auth::user()->id;
                        $bomInput->save();
    
                        foreach($bomProfile as $material){
                            $bom_detail = new BomDetail;
                            $bom_detail->bom_id = $bomInput->id;
                            $bom_detail->material_id = $material->material_id;
                            $bom_detail->quantity = $material->quantity;
                            $bom_detail->source = isset($material->source) ? $material->source : "Stock";
                            if(!$bom_detail->save()){
                                return response(["error"=> 'Failed Save Bom Detail !']);
                            }
                        }
                    }

                    $resourceProfile = $wbs->resources;
                    if(count($resourceProfile)>0){
                        foreach($resourceProfile as $resource){
                            $resourceInput = new ResourceTrx;
                            $resourceInput->resource_id = $resource->resource_id;
                            $resourceInput->resource_detail_id = $resource->resource_detail_id;
                            $resourceInput->category_id = $resource->category_id;
                            $resourceInput->project_id = $data['project_id'];
                            $resourceInput->wbs_id = $wbsInput->id;
                            $resourceInput->quantity = $resource->quantity;
                            $resourceInput->save();
                        }
                    }
                }
                self::adoptWbsStructure($wbs->wbss, $wbsInput->id,$project_id);
            }else{
                if(count($wbs->activities)>0){
                    $wbsInput = new WBS;
                    $wbsInput->code = self::generateWbsCode($project_id);
                    $wbsInput->number = $wbs->number;
                    $wbsInput->description = $wbs->description;
                    $wbsInput->deliverables = $wbs->deliverables;
                    $wbsInput->planned_duration = $wbs->duration;
                    $wbsInput->project_id = $project_id;
                    $wbsInput->wbs_id = $parent;
                    $wbsInput->user_id = Auth::user()->id;
                    $wbsInput->branch_id = Auth::user()->branch->id;
                    $wbsInput->save();
                    foreach($wbs->activities as $activity){
                        $activityInput = new Activity;
                        $activityInput->code = self::generateActivityCode($wbsInput->id);
                        $activityInput->name = $activity->name;
                        $activityInput->description = $activity->description;
                        $activityInput->planned_duration = $activity->duration;
                        $activityInput->wbs_id = $wbsInput->id;
                        $activityInput->user_id = Auth::user()->id;
                        $activityInput->branch_id = Auth::user()->branch->id;
                        $activityInput->save();
                    }

                    if(count($wbs->bom)>0){
                        $bomProfile = $wbsProfile->bom;
                        $bomInput = new Bom;
                        $bomInput->code = self::generateBomCode($project_id);
                        $bomInput->description = "AUTO GENERATED FROM ADOPT WBS PROFILE";
                        $bomInput->project_id = $project_id;
                        $bomInput->wbs_id = $wbsInput->id;
                        $bomInput->branch_id = Auth::user()->branch->id;
                        $bomInput->user_id = Auth::user()->id;
                        $bomInput->save();
    
                        foreach($bomProfile as $material){
                            $bom_detail = new BomDetail;
                            $bom_detail->bom_id = $bomInput->id;
                            $bom_detail->material_id = $material->material_id;
                            $bom_detail->quantity = $material->quantity;
                            $bom_detail->source = isset($material->source) ? $material->source : "Stock";
                            if(!$bom_detail->save()){
                                return response(["error"=> 'Failed Save Bom Detail !']);
                            }
                        }
                    }

                    $resourceProfile = $wbs->resources;
                    if(count($resourceProfile)>0){
                        foreach($resourceProfile as $resource){
                            $resourceInput = new ResourceTrx;
                            $resourceInput->resource_id = $resource->resource_id;
                            $resourceInput->resource_detail_id = $resource->resource_detail_id;
                            $resourceInput->category_id = $resource->category_id;
                            $resourceInput->project_id = $data['project_id'];
                            $resourceInput->wbs_id = $wbsInput->id;
                            $resourceInput->quantity = $resource->quantity;
                            $resourceInput->save();
                        }
                    }
                }else{
                    $wbsInput = new WBS;
                    $wbsInput->code = self::generateWbsCode($project_id);
                    $wbsInput->number = $wbs->number;
                    $wbsInput->description = $wbs->description;
                    $wbsInput->deliverables = $wbs->deliverables;
                    $wbsInput->planned_duration = $wbs->duration;
                    $wbsInput->project_id = $project_id;
                    $wbsInput->wbs_id = $parent;
                    $wbsInput->user_id = Auth::user()->id;
                    $wbsInput->branch_id = Auth::user()->branch->id;
                    $wbsInput->save();

                    if(count($wbs->bom)>0){
                        $bomProfile = $wbsProfile->bom;
                        $bomInput = new Bom;
                        $bomInput->code = self::generateBomCode($project_id);
                        $bomInput->description = "AUTO GENERATED FROM ADOPT WBS PROFILE";
                        $bomInput->project_id = $project_id;
                        $bomInput->wbs_id = $wbsInput->id;
                        $bomInput->branch_id = Auth::user()->branch->id;
                        $bomInput->user_id = Auth::user()->id;
                        $bomInput->save();
    
                        foreach($bomProfile as $material){
                            $bom_detail = new BomDetail;
                            $bom_detail->bom_id = $bomInput->id;
                            $bom_detail->material_id = $material->material_id;
                            $bom_detail->quantity = $material->quantity;
                            $bom_detail->source = isset($material->source) ? $material->source : "Stock";
                            if(!$bom_detail->save()){
                                return response(["error"=> 'Failed Save Bom Detail !']);
                            }
                        }
                    }

                    $resourceProfile = $wbs->resources;
                    if(count($resourceProfile)>0){
                        foreach($resourceProfile as $resource){
                            $resourceInput = new ResourceTrx;
                            $resourceInput->resource_id = $resource->resource_id;
                            $resourceInput->resource_detail_id = $resource->resource_detail_id;
                            $resourceInput->category_id = $resource->category_id;
                            $resourceInput->project_id = $data['project_id'];
                            $resourceInput->wbs_id = $wbsInput->id;
                            $resourceInput->quantity = $resource->quantity;
                            $resourceInput->save();
                        }
                    }
                }
            } 
        }
    }

    //API
    public function getWbsProfileAPI($menu, $project_type){
        $businessUnit = 0;
        if($menu == "building"){
            $businessUnit = 1;
        }else if($menu == "repair"){
            $businessUnit = 2;
        }

        $wbss = WbsProfile::where('wbs_id', null)->where('business_unit_id',$businessUnit)->where('project_type_id',$project_type)->get()->jsonSerialize();
        return response($wbss, Response::HTTP_OK);
    }


    public function getSubWbsProfileAPI($wbs_id){
        $wbss = WbsProfile::where('wbs_id', $wbs_id)->get()->jsonSerialize();
        return response($wbss, Response::HTTP_OK);
    }
    
    public function getWbsAPI($project_id){
        $wbss = WBS::orderBy('planned_start_date', 'asc')->where('project_id', $project_id)->where('wbs_id', null)->get()->jsonSerialize();
        return response($wbss, Response::HTTP_OK);
    }

    public function getAllWbsAPI($project_id){
        $wbss = WBS::orderBy('planned_start_date', 'asc')->where('project_id', $project_id)->with('wbs')->get()->jsonSerialize();
        return response($wbss, Response::HTTP_OK);
    }

    public function getSubWbsAPI($wbs_id){
        $wbss = WBS::orderBy('planned_start_date', 'asc')->where('wbs_id', $wbs_id)->get()->jsonSerialize();
        return response($wbss, Response::HTTP_OK);
    }

    public function getWeightWbsAPI($wbs_id){
        $wbs = WBS::find($wbs_id);
        $totalWeight = $wbs->wbss->sum('weight') + $wbs->activities->sum('weight');

        return response($totalWeight, Response::HTTP_OK);
    }

    public function getWeightProjectAPI($project_id){
        $project = Project::find($project_id);
        $totalWeight = $project->wbss->where('wbs_id',null)->sum('weight');

        return response($totalWeight, Response::HTTP_OK);
    }

    public function getDataProfileJstreeAPI($id){
        $wbs_profile_ref = WbsProfile::find($id);

        $dataWbsProfile = Collection::make();

        $dataWbsProfile->push([
            "id" => "WBS".$wbs_profile_ref->id, 
            "parent" => "#",
            "text" => $wbs_profile_ref->number,
            "icon" => "fa fa-suitcase"
        ]);

        if(count($wbs_profile_ref->activities)>0){
            foreach ($wbs_profile_ref->activities as $activity) {
                $dataWbsProfile->push([
                    "id" => "ACT".$activity->id, 
                    "parent" => "WBS".$wbs_profile_ref->id,
                    "text" => $activity->name,
                    "icon" => "fa fa-clock-o"
                ]);
            }
        }

        $parent = "WBS".$wbs_profile_ref->id;
        if(count($wbs_profile_ref->wbss)>0){
            self::getWbsProfileTree($dataWbsProfile, $wbs_profile_ref->wbss, $parent);
        }

        return response($dataWbsProfile, Response::HTTP_OK);
    }
    
    public function getBomProfileAPI($wbs_id){
        $bom = BomProfile::where('wbs_id',$wbs_id)->with('material.uom','service')->get()->jsonSerialize();

        return response($bom, Response::HTTP_OK);
    }

    public function getResourceProfileAPI($wbs_id){
        $resource = ResourceProfile::where('wbs_id',$wbs_id)->with('resource','resourceDetail')->get()->jsonSerialize();

        return response($resource, Response::HTTP_OK);
    }

    public function getRdProfilesAPI($ids){
        $ids = json_decode($ids);       
        return response(ResourceDetail::whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }
}
