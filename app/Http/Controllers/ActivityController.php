<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Notifications\ProjectActivity;
use App\Http\Controllers\Controller;
use App\Models\Uom;
use App\Models\WBS;
use App\Models\Notification;
use App\Models\Project;
use App\Models\Activity;
use App\Models\ActivityDetail;
use App\Models\Material;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\Vendor;
use App\Models\WbsProfile;
use App\Models\WbsStandard;
use App\Models\Configuration;
use App\Models\ActivityProfile;
use App\Models\ActivityConfiguration;
use App\Models\User;
use App\Models\BomPrep;
use DB;
use DateTime;
use Auth;
use File;

class ActivityController extends Controller
{

    public function create($id, Request $request)
    {
        $wbs = WBS::find($id);
        $project = $wbs->project;
        $menu = $project->business_unit_id == "1" ? "building" : "repair";
        $services = Service::where('ship_id', null)->orWhere('ship_id', $wbs->project->ship_id)->with('serviceDetails','ship')->get();

        if($wbs->weight == null){
            return redirect()->route('project_repair.listWBS', [$wbs->project->id,'addAct'])->with('error', 'Please configure weight for WBS '.$wbs->number.' - '.$wbs->description);
        }else{
            return view('activity.create', compact('project', 'wbs','menu','services'));
        }

    }

    public function createActivityRepair($id, Request $request)
    {
        $wbs = WBS::find($id);
        $materials = Material::with('dimensionUom')->get();
        foreach ($materials as $material) {
            $material['selected'] = false;
        }
        $vendors = Vendor::all();
        $uoms = Uom::all();
        $project = $wbs->project;
        $menu = "repair";

        return view('activity.createActivityRepair', compact('vendors','uoms','materials','services','project', 'wbs','menu'));
    }

    public function createActivityProfile($id, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/activity" ? "building" : "repair";
        $wbs = WbsProfile::find($id);

        return view('activity.createActivityProfile', compact('wbs','menu'));
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();
        $predecessorArray = [];
        foreach($data['allPredecessor'] as $predecessor){
            $temp = [];
            array_push($temp, $predecessor[0]);
            array_push($temp, $predecessor[1]);
            array_push($predecessorArray, $temp);

        }
        DB::beginTransaction();
        try {
            $activity = new Activity;
            $activity->code = self::generateActivityCode($data['wbs_id']);
            $activity->name = $data['name'];
            $activity->type = $data['type'];
            $activity->description = $data['description'];
            $activity->wbs_id = $data['wbs_id'];
            $activity->planned_duration = $data['planned_duration'];

            if($data['planned_start_date'] != ""){
                $planStartDate = DateTime::createFromFormat('d-m-Y', $data['planned_start_date']);
                $activity->planned_start_date = $planStartDate->format('Y-m-d');
            }

            if($data['planned_end_date'] != ""){
                $planEndDate = DateTime::createFromFormat('d-m-Y', $data['planned_end_date']);
                $activity->planned_end_date = $planEndDate->format('Y-m-d');
            }

            if(count($predecessorArray) >0){
                $activity->predecessor = json_encode($predecessorArray);
            }

            if(isset($data['activity_configuration_id'])){
                $activity->activity_configuration_id = $data['activity_configuration_id'];

            }

            $activity->weight = $data['weight'];
            $activity->service_id = $data['service_id'];
            $activity->service_detail_id = $data['service_detail_id'];
            $activity->user_id = Auth::user()->id;
            $activity->branch_id = Auth::user()->branch->id;

            if($activity->wbs->project->business_unit_id == 2){
                $activity->service_id = $data['service_id'];
                $activity->service_detail_id = $data['service_detail_id'];
            }
            // if($activity->wbs->project->business_unit_id == 2){
            //     $project_id = $activity->wbs->project_id;
            //     if(count($data['dataMaterial']) > 0 || $data['service_id'] != null){
            //         if(count($data['dataMaterial']) > 0){
            //             foreach ($data['dataMaterial'] as $material) {
            //                 $weight = 0;
            //                 $uom = UOM::find($material['dimension_uom_id']);
            //                 if($uom != null){
            //                     $uom_name = $uom->name;
            //                     if($uom_name == "Milimeter" || $uom_name == "milimeter"){
            //                         $densities = Configuration::get('density');
            //                         $model_material = Material::find($material['material_id']);
            //                         $material_density = 0;
            //                         foreach($densities as $density){
            //                             if($density->id == $model_material->density_id){
            //                                 $material_density = $density->value;
            //                             }
            //                         }
            //                         if($material_density == 0){
            //                             DB::rollback();
            //                             return response(["error"=> "There is material that doesn't have density, please define it first at material master data"],Response::HTTP_OK);
            //                         }
            //                         $volume = ($material['lengths'] * $material['width'] * $material['height'] )/ 1000000;
            //                         $weight = round(($volume * $material_density) * $material['quantity'],2);
            //                     }
            //                 }

            //                 $activityDetailMaterial = new ActivityDetail;
            //                 $activityDetailMaterial->activity_id = $activity->id;
            //                 $activityDetailMaterial->material_id = $material['material_id'];
            //                 $activityDetailMaterial->quantity_material = $material['quantity'];
            //                 $activityDetailMaterial->source = $material['source'];
            //                 if($material['dimension_uom_id'] != "" && $material['dimension_uom_id'] != null){
            //                     $activityDetailMaterial->dimension_uom_id = $material['dimension_uom_id'];
            //                     $activityDetailMaterial->length = $material['lengths'] == "" ? 0 : $material['lengths'];
            //                     $activityDetailMaterial->width = $material['width'] == "" ? 0 : $material['width'];
            //                     $activityDetailMaterial->height = $material['height'] == "" ? 0 : $material['height'];
            //                     $activityDetailMaterial->weight = $weight;
            //                 }
            //                 $activityDetailMaterial->save();

            //                 $modelBomPrep = BomPrep::where('project_id', $project_id)->where('material_id', $material['material_id'])->get();
            //                 if(count($modelBomPrep) > 0){
            //                     $found_bom_prep = false;
            //                     $not_added = true;
            //                     foreach ($modelBomPrep as $bomPrep) {
            //                         if($bomPrep->status == 1){
            //                             if($weight == 0){
            //                                 $bomPrep->quantity += $material['quantity'];
            //                             }else{
            //                                 $bomPrep->weight += $weight;
            //                             }
            //                             $bomPrep->update();

            //                             $activityDetailMaterial->bom_prep_id = $bomPrep->id;
            //                             $activityDetailMaterial->update();
            //                             $not_added = false;
            //                         }else{
            //                             $found_bom_prep = true;
            //                         }

            //                     }
            //                     if($found_bom_prep && $not_added){
            //                         $bomPrep = new BomPrep;
            //                         $bomPrep->project_id = $project_id;
            //                         $bomPrep->material_id = $material['material_id'];
            //                         if($weight == 0){
            //                             $bomPrep->quantity = $material['quantity'];
            //                         }else{
            //                             $bomPrep->weight = $weight;
            //                         }
            //                         $bomPrep->weight = $weight;
            //                         $bomPrep->status = 1;
            //                         $bomPrep->source = $material['source'];
            //                         $bomPrep->save();

            //                         $activityDetailMaterial->bom_prep_id = $bomPrep->id;
            //                         $activityDetailMaterial->update();
            //                     }
            //                 }else{
            //                     $bomPrep = new BomPrep;
            //                     $bomPrep->project_id = $project_id;
            //                     $bomPrep->material_id = $material['material_id'];
            //                     if($weight == 0){
            //                         $bomPrep->quantity = $material['quantity'];
            //                     }else{
            //                         $bomPrep->weight = $weight;
            //                     }
            //                     $bomPrep->status = 1;
            //                     $bomPrep->source = $material['source'];
            //                     $bomPrep->save();

            //                     $activityDetailMaterial->bom_prep_id = $bomPrep->id;
            //                     $activityDetailMaterial->update();
            //                 }
            //             }
            //         }
            //         if($data['service_id'] != null){
            //             $activityDetailService = new ActivityDetail;
            //             $activityDetailService->activity_id = $activity->id;
            //             $activityDetailService->service_detail_id = $data['service_detail_id'];
            //             $activityDetailService->area = $data['area'];
            //             $activityDetailService->vendor_id = $data['vendor_id'];
            //             $activityDetailService->area_uom_id = $data['area_uom_id'];
            //             $activityDetailService->save();
            //         }
            //     }
            // }
            $activity->save();
            DB::commit();
            return response(["response"=>"Success to create new activity"],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeActivityProfile(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $activity = new ActivityProfile;
            $activity->name = $data['name'];
            $activity->type = $data['type'];
            $activity->description = $data['description'];
            $activity->wbs_id = $data['wbs_id'];
            $activity->duration = $data['duration'];
            $activity->user_id = Auth::user()->id;
            $activity->branch_id = Auth::user()->branch->id;

            if(!$activity->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to create new activity profile"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->json()->all();
        $error = [];

        DB::beginTransaction();
        try {
            $activity = Activity::find($id);
            $activity->name = $data['name'];
            $activity->type = $data['type'];
            $activity->description = $data['description'];
            $activity->planned_duration = $data['planned_duration'];

            $planStartDate = DateTime::createFromFormat('d-m-Y', $data['planned_start_date']);
            $planEndDate = DateTime::createFromFormat('d-m-Y', $data['planned_end_date']);

            $activity->planned_start_date = $planStartDate->format('Y-m-d');
            $activity->planned_end_date = $planEndDate->format('Y-m-d');
            $activity->weight = $data['weight'];
            if(count($data['allPredecessor']) > 0){
                $predecessorArray = [];
                foreach($data['allPredecessor'] as $predecessor){
                    $temp = [];
                    array_push($temp, $predecessor[0]);
                    array_push($temp, $predecessor[1]);
                    array_push($predecessorArray, $temp);

                }
                $activity->predecessor = json_encode($predecessorArray);
            }else{
                $activity->predecessor = null;
            }

            if($activity->wbs->project->business_unit_id == 2){
                $activity->service_id = $data['service_id'];
                $activity->service_detail_id = $data['service_detail_id'];
            }
            // if(isset($data['deletedActDetail'])){
            //     if(count($data['deletedActDetail'])>0){
            //         foreach ($data['deletedActDetail'] as $act_detail_id) {
            //             $activityDetailMaterial = ActivityDetail::find($act_detail_id);
            //             $bomPrep = $activityDetailMaterial->bomPrep;
            //             $delete_bom_prep = false;
            //             if($bomPrep->status == 0){
            //                 array_push($error, ["Failed to delete, this activity material has been already summarized"]);
            //                 return response(["error"=> $error],Response::HTTP_OK);
            //             }else{
            //                 if(count($bomPrep->bomDetails) > 0){
            //                     array_push($error, ["Failed to delete, this activity material has been already partially summarized"]);
            //                     return response(["error"=> $error],Response::HTTP_OK);
            //                 }else{
            //                     if($bomPrep->weight != null){
            //                         $bomPrep->weight -= $activityDetailMaterial->weight;
            //                         if($bomPrep->weight == 0){
            //                             $delete_bom_prep = true;
            //                         }else{
            //                             $bomPrep->update();
            //                         }
            //                     }else{
            //                         $bomPrep->quantity -= $activityDetailMaterial->quantity_material;
            //                         if($bomPrep->quantity == 0){
            //                             $delete_bom_prep = true;
            //                         }else{
            //                             $bomPrep->update();
            //                         }
            //                     }

            //                 }
            //             }
            //             $activityDetailMaterial->delete();
            //             if($delete_bom_prep){
            //                 $bomPrep->delete();
            //             }
            //         }
            //     }
            // }

            // if($activity->wbs->project->business_unit_id == 2){
            //     if(count($data['dataMaterial']) > 0 || $data['service_id'] != null){
            //         if(count($data['dataMaterial']) > 0){
            //             // print_r(count($data['dataMaterial'])); exit();
            //             foreach ($data['dataMaterial'] as $material) {
            //                 if($material['id'] == null){
            //                     $weight = 0;
            //                     $uom = UOM::find($material['dimension_uom_id']);
            //                     if($uom != null){
            //                         $uom_name = $uom->name;
            //                         if($uom_name == "Milimeter" || $uom_name == "milimeter"){
            //                             $densities = Configuration::get('density');
            //                             $model_material = Material::find($material['material_id']);
            //                             $material_density = 0;
            //                             foreach($densities as $density){
            //                                 if($density->id == $model_material->density_id){
            //                                     $material_density = $density->value;
            //                                 }
            //                             }
            //                             if($material_density == 0){
            //                                 DB::rollback();
            //                                 return response(["error"=> "There is material that doesn't have density, please define it first at material master data"],Response::HTTP_OK);
            //                             }
            //                             $volume = ($material['lengths'] * $material['width'] * $material['height'] )/ 1000000;
            //                             $weight = round(($volume * $material_density) * $material['quantity'],2);
            //                         }
            //                     }

            //                     $activityDetailMaterial = new ActivityDetail;
            //                     $activityDetailMaterial->activity_id = $activity->id;
            //                     $activityDetailMaterial->material_id = $material['material_id'];
            //                     $activityDetailMaterial->quantity_material = $material['quantity'];
            //                     $activityDetailMaterial->source = $material['source'];
            //                     if($material['dimension_uom_id'] != "" && $material['dimension_uom_id'] != null){
            //                         $activityDetailMaterial->dimension_uom_id = $material['dimension_uom_id'];
            //                         $activityDetailMaterial->length = $material['lengths'] == "" ? 0 : $material['lengths'];
            //                         $activityDetailMaterial->width = $material['width'] == "" ? 0 : $material['width'];
            //                         $activityDetailMaterial->height = $material['height'] == "" ? 0 : $material['height'];
            //                         $activityDetailMaterial->weight = $weight;
            //                     }
            //                     $activityDetailMaterial->save();
            //                     $modelBomPrep = BomPrep::where('project_id', $project_id)->where('material_id', $material['material_id'])->get();
            //                     if(count($modelBomPrep) > 0){
            //                         $not_found_bom_prep = false;
            //                         $not_added = true;
            //                         foreach ($modelBomPrep as $bomPrep) {
            //                             if($bomPrep->status == 1){
            //                                 //Masih belum pakai hitungan rumus
            //                                 if($weight == 0){
            //                                     $bomPrep->quantity += $material['quantity'];
            //                                 }else{
            //                                     $bomPrep->weight += $weight;
            //                                 }
            //                                 $bomPrep->update();

            //                                 $activityDetailMaterial->bom_prep_id = $bomPrep->id;
            //                                 $activityDetailMaterial->update();
            //                                 $not_added = false;
            //                             }else{
            //                                 $not_found_bom_prep = true;
            //                             }

            //                         }
            //                         if($not_found_bom_prep && $not_added){
            //                             $bomPrep = new BomPrep;
            //                             $bomPrep->project_id = $project_id;
            //                             $bomPrep->material_id = $material['material_id'];
            //                             if($weight == 0){
            //                                 $bomPrep->quantity = $material['quantity'];
            //                             }else{
            //                                 $bomPrep->weight = $weight;
            //                             }
            //                             $bomPrep->status = 1;
            //                             $bomPrep->source = $material['source'];
            //                             $bomPrep->save();

            //                             $activityDetailMaterial->bom_prep_id = $bomPrep->id;
            //                             $activityDetailMaterial->update();
            //                         }
            //                     }else{
            //                         $bomPrep = new BomPrep;
            //                         $bomPrep->project_id = $project_id;
            //                         $bomPrep->material_id = $material['material_id'];
            //                         if($weight == 0){
            //                             $bomPrep->quantity = $material['quantity'];
            //                         }else{
            //                             $bomPrep->weight = $weight;
            //                         }
            //                         $bomPrep->status = 1;
            //                         $bomPrep->source = $material['source'];
            //                         $bomPrep->save();

            //                         $activityDetailMaterial->bom_prep_id = $bomPrep->id;
            //                         $activityDetailMaterial->update();
            //                     }
            //                 }
            //             }
            //         }
            //         if($data['service_id'] != null){
            //             $activityDetailService = ActivityDetail::find($data['act_detail_service_id']);
            //             $new = false;
            //             if($activityDetailService == null){
            //                 $activityDetailService = new ActivityDetail;
            //                 $activityDetailService->activity_id = $activity->id;
            //                 $new = true;
            //             }
            //             $activityDetailService->service_detail_id = $data['service_detail_id'];
            //             $activityDetailService->area = $data['area'];
            //             $activityDetailService->vendor_id = $data['vendor_id'];
            //             $activityDetailService->area_uom_id = $data['area_uom_id'];

            //             if($new){
            //                 $activityDetailService->save();
            //             }else{
            //                 $activityDetailService->update();
            //             }

            //         }
            //     }
            // }
            if(!$activity->save()){
                array_push($error, ["Failed to save, please try again!"]);
                return response(["error"=> $error],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to update activity ".$activity->code],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            array_push($error, [$e->getMessage()]);
            return response(["error"=> $error],Response::HTTP_OK);
        }
    }

    public function updateActivityProfile(Request $request, $id)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $activity = ActivityProfile::find($id);
            $activity->name = $data['name'];
            $activity->type = $data['type'];
            $activity->description = $data['description'];
            $activity->duration = $data['duration'];

            if(!$activity->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to update activity profile ".$activity->name],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function index($id, Request $request)
    {
        $wbs = WBS::find($id);
        if(count($wbs->wbsConfig->activities)>0){
            $activity_config = $wbs->wbsConfig->activities;

            $materials = Material::with('dimensionUom')->get();
            foreach ($materials as $material) {
                $material['selected'] = false;
            }
            $services = Service::where('ship_id', null)->orWhere('ship_id', $wbs->project->ship_id)->with('serviceDetails','ship')->get();
            $vendors = Vendor::all();
            $uoms = Uom::all();
            $project = $wbs->project;
            $menu = "repair";

            $index = true;
            return view('activity.createActivityRepair', compact('index','vendors','uoms','materials','services','project', 'wbs','menu','activity_config'));
        }else{
            return redirect()->route('project_repair.listWBS', [$wbs->project->id,'addAct'])->with('error', 'Please Make Activity Configuration for WBS '.$wbs->number.' - '.$wbs->description);
        }
    }

    public function show($id,Request $request)
    {
        $activity = Activity::find($id);
        $project = $activity->wbs->project;
        $menu = $project->business_unit_id == "1" ? "building" : "repair";
        $activityPredecessor = Collection::make();

        if($activity->predecessor != null){
            $predecessor = json_decode($activity->predecessor);
            foreach($predecessor as $activity_predecessor){
                $refActivity = Activity::find($activity_predecessor[0]);
                $refActivity->type = $activity_predecessor[1];
                $activityPredecessor->push($refActivity);
            }
        }
        return view('activity.show', compact('activity','activityPredecessor','menu'));
    }

    public function manageNetwork($id,Request $request)
    {
        $project = Project::find($id);
        $menu = $project->business_unit_id == "1" ? "building" : "repair";

        return view('activity.indexNetwork', compact('project','menu'));
    }


    public function updatePredecessor(Request $request, $id)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $activity = Activity::find($id);
            if(count($data['allPredecessor']) > 0){
                $predecessorArray = [];
                foreach($data['allPredecessor'] as $predecessor){
                    $temp = [];
                    array_push($temp, $predecessor[0]);
                    array_push($temp, $predecessor[1]);
                    array_push($predecessorArray, $temp);

                }
                $activity->predecessor = json_encode($predecessorArray);
            }else{
                $activity->predecessor = null;
            }

            if(!$activity->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update Predecessor for Activity ".$activity->code],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function indexConfirm(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/activity" ? "building" : "repair";
        if($menu == "building"){
            $projects = Project::where('business_unit_id',1)->get();
        }else{
            $projects = Project::where('business_unit_id',2)->get();
        }

        return view('activity.indexConfirm', compact('projects','menu'));
    }

    public function confirmActivity($id, Request $request)
    {
        $wbs = WBS::find($id);
        $project = $wbs->project;
        $menu = $project->business_unit_id == "1" ? "building" : "repair";
        return view('activity.confirmActivity', compact('project','wbs','menu'));
    }

    public function updateActualActivity(Request $request, $id)
    {
        $dataActivity = json_decode($request->dataConfirmActivity);
        $dataFile = $request->file;
        DB::beginTransaction();
        try {
            $activity = Activity::find($id);
            if($dataActivity->actual_end_date == ""){
                $activity->status = 1;
                $activity->progress = $dataActivity->current_progress;
                $activity->actual_end_date = null;
                $activity->actual_duration = null;
            }else{
                $activity->status = 0;
                $activity->progress = 100;
                $actualEndDate = DateTime::createFromFormat('d-m-Y', $dataActivity->actual_end_date);
                $activity->actual_end_date = $actualEndDate->format('Y-m-d');
                $activity->actual_duration = $dataActivity->actual_duration;
            }
            $activity->document_number = $dataActivity->document_number;
            if($dataActivity->type == 'Upload'){
                if($request->hasFile('file')){
                    // Get filename with the extension
                    $fileNameWithExt = $request->file('file')->getClientOriginalName();
                    // Get just file name
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    // Get just ext
                    $extension = $request->file('file')->getClientOriginalExtension();
                    // File name to store
                    $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                    // Upload image
                    $path = $request->file('file')->storeAs('documents/activity',$fileNameToStore);
                    if($activity->drawing != $fileNameToStore){
                        $image_path = public_path("app/documents/activity/".$activity->drawing); 
                        if(File::exists($image_path)) {
                            File::delete($image_path);
                        }
                    }
                    $activity->drawing = $fileNameToStore;
                }
            }
            $actualStartDate = DateTime::createFromFormat('d-m-Y', $dataActivity->actual_start_date);
            $activity->actual_start_date = $actualStartDate->format('Y-m-d');
            $activity->save();

            $project = $activity->wbs->project;
            $wbss = $project->wbss->where('wbs_id',null);
            $earliest_date = null;
            foreach($wbss as $wbs){
                $temp = self::getEarliestActivity($wbs,$earliest_date);
                if($earliest_date == null){
                    $earliest_date = $temp;
                }else{
                    if($earliest_date > $temp){
                        $earliest_date = $temp;
                    }
                }
            }
            $project->actual_start_date = $earliest_date;

            $wbs = $activity->wbs;
            self::changeWbsProgress($wbs);

            $project = $wbs->project;
            $oldestWorks= $project->wbss->where('wbs_id', null);
            $progress = 0;
            foreach($oldestWorks as $wbs){
                $progress += $wbs->progress* ($wbs->weight /100);
            }
            $project->progress = $progress;
            $project->update();
            if($project->progress == 100){
                $wbss = $project->wbss->pluck('id')->toArray();
                $latest_date = Activity::whereIn('wbs_id',$wbss)->get()->groupBy('actual_end_date')->all();
                krsort($latest_date);
                $latest_date = collect($latest_date)->first()[0]->actual_end_date;
                $project->actual_end_date = $latest_date;

                $start_date=date_create($project->actual_start_date);
                $end_date=date_create($project->actual_end_date);

                $diff=date_diff($start_date,$end_date);
                $project->actual_duration = $diff->days;
                $project->update();
            }


            DB::commit();
            return response(["response"=>"Success to confirm activity ".$activity->code],Response::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function destroyActivityProfile(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try {
            $activityProfile = ActivityProfile::find($id);

            if(!$activityProfile->delete()){
                return response(["error"=> "Failed to delete, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to delete Activity"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function destroyActivity(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        $error = [];
        try {
            $activity = Activity::find($id);
            if($activity->progress > 0){
                array_push($error, ["Failed to delete, this activity already have ".$activity->progress." % progress"]);
                return response(["error"=> $error],Response::HTTP_OK);
            }

            $activity_ref = Activity::whereNotIn('id',[$activity->id])->get();
            foreach($activity_ref as $act){
                if($act->predecessor != null){
                    $predecessor = json_decode($act->predecessor);
                    foreach($predecessor as $act_id){
                        if($activity->id == $act_id[0]){
                            array_push($error, ["Failed to delete, this activity is predecessor to another activity"]);
                            return response(["error"=> $error],Response::HTTP_OK);
                        }
                    }
                }
            }
            if($activity->wbs->project->business_unit_id == 2){
                $project_id = $activity->wbs->project_id;
                foreach ($activity->activityDetails as $act_detail) {
                    $bomPrep = $act_detail->bomPrep;
                    $delete_bom_prep = false;
                    if($bomPrep->status == 0){
                        array_push($error, ["Failed to delete, this activity material has been already summarized"]);
                        return response(["error"=> $error],Response::HTTP_OK);
                    }else{
                        if(count($bomPrep->bomDetails) > 0){
                            array_push($error, ["Failed to delete, this activity material has been already partially summarized"]);
                            return response(["error"=> $error],Response::HTTP_OK);
                        }else{
                            $bomPrep->weight -= $act_detail->weight;
                            if($bomPrep->weight == 0){
                                $delete_bom_prep = true;
                            }else{
                                $bomPrep->update();
                            }
                        }
                    }
                    $act_detail->delete();
                    if($delete_bom_prep){
                        $bomPrep->delete();
                    }
                }
            }
            $activity->delete();
            DB::commit();
            return response(["response"=>"Success to delete Activity"],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            array_push($error, [$e->getMessage()]);
            return response(["error"=> $error],Response::HTTP_OK);
        }
    }

    //Method
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

    function getEarliestActivity($wbs, $earliest_date){
        if($wbs){
            if(count($wbs->wbss)>0){
                foreach($wbs->wbss as $wbs_child){
                    if(count($wbs_child->activities)>0){
                        $activityRef = Activity::where('wbs_id',$wbs_child->id)->whereRaw('actual_start_date is not null')->orderBy('actual_start_date','asc')->first();
                        if($activityRef != null){
                            $earliest_date_ref = $activityRef->actual_start_date;
                            if($earliest_date != null){
                                if($earliest_date > $earliest_date_ref){
                                    $earliest_date = $earliest_date_ref;
                                }
                            }else{
                                $earliest_date = $earliest_date_ref;
                            }
                        }else{
                            $earliest_date = $earliest_date;
                        }
                    }
                    return self::getEarliestActivity($wbs_child,$earliest_date);
                }
            }else{
                if(count($wbs->activities)>0){
                    $activityRef = Activity::where('wbs_id',$wbs->id)->whereRaw('actual_start_date is not null')->orderBy('actual_start_date','asc')->first();
                    if($activityRef != null){
                        $earliest_date_ref = $activityRef->actual_start_date;
                        if($earliest_date != null){
                            if($earliest_date > $earliest_date_ref){
                                $earliest_date = $earliest_date_ref;
                            }
                        }else{
                            $earliest_date = $earliest_date_ref;
                        }
                    }else{
                        $earliest_date = $earliest_date;
                    }
                }
                return $earliest_date;
            }
        }
    }

    function changeWbsProgress($wbs){
        if($wbs){
            if($wbs->wbs){
                $progress = 0;
                if($wbs->activities){
                    foreach($wbs->activities as $activity){
                        $progress += $activity->progress * ($activity->weight/100);
                    }
                }

                if($wbs->wbss){
                    foreach($wbs->wbss as $child_wbs){
                        $progress += $child_wbs->progress * ($child_wbs->weight/100);
                    }
                }
                $wbs->progress = ($progress /$wbs->weight) *100;
                $wbs->save();
                self::changeWbsProgress($wbs->wbs);
            }else{
                $progress = 0;
                if($wbs->activities){
                    foreach($wbs->activities as $activity){
                        $progress += $activity->progress * ($activity->weight/100);
                    }
                }

                if($wbs->wbss){
                    foreach($wbs->wbss as $child_wbs){
                        $progress += $child_wbs->progress * ($child_wbs->weight/100);
                    }
                }
                $wbs->progress = ($progress /$wbs->weight) *100;
                $wbs->save();
            }
        }
    }

    //API
    public function getActivitiesAPI($wbs_id){
        $activities = Activity::orderBy('planned_start_date', 'asc')->where('wbs_id', $wbs_id)->get()->jsonSerialize();
        return response($activities, Response::HTTP_OK);
    }

    public function getActivitiesProfileAPI($wbs_id){
        $activities = ActivityProfile::where('wbs_id', $wbs_id)->get()->jsonSerialize();
        return response($activities, Response::HTTP_OK);
    }

    public function getActivitiesNetworkAPI($project_id){
        $project = Project::find($project_id);
        $activities = Activity::whereIn('wbs_id',$project->wbss->pluck('id')->toArray())->orderBy('planned_start_date','asc')->get();

        $allActivities = Collection::make();
        foreach ($project->wbss as $wbsData) {
            foreach($wbsData->activities as $activity){
                $allActivities->push($activity);
            }
        }

        return response($activities->jsonSerialize(), Response::HTTP_OK);
    }

    public function getAllActivitiesAPI($project_id){
        $project = Project::find($project_id);

        $allActivities = Collection::make();
        foreach ($project->wbss as $wbsData) {
            foreach($wbsData->activities as $activity){
                $activity->push('wbs_number', $activity->wbs->number);
                $allActivities->push($activity);
            }
        }
        return response($allActivities->jsonSerialize(), Response::HTTP_OK);
    }

    public function getAllActivitiesEditAPI($project_id, $activity_id){
        $project = Project::find($project_id);

        $allActivities = Collection::make();
        foreach ($project->wbss as $wbsData) {
            foreach($wbsData->activities as $activity){
                if($activity->id != $activity_id){
                    $activity->push('wbs_number', $activity->wbs->number);
                    $allActivities->push($activity);
                }
            }
        }
        return response($allActivities->jsonSerialize(), Response::HTTP_OK);
    }

    public function getPredecessorAPI($id){
        $activity = Activity::find($id);
        $predecessor = json_decode($activity->predecessor);
        $predecessorActivities = Activity::orderBy('planned_start_date', 'asc')->whereIn('id', $predecessor)->with('wbs')->get()->jsonSerialize();
        return response($predecessorActivities, Response::HTTP_OK);
    }

    public function getProjectAPI($id){
        $project = Project::find($id)->jsonSerialize();
        return response($project, Response::HTTP_OK);
    }

    public function getLatestPredecessorAPI($id)
    {
        $predecessors = json_decode($id);
        $arrayPredecessor = [];
        foreach($predecessors as $predecessor){
            array_push($arrayPredecessor, $predecessor[0]);
        }
        $latestActivity = Activity::orderBy('planned_end_date', 'desc')->whereIn('id', $arrayPredecessor)->first()->jsonSerialize();

        return response($latestActivity, Response::HTTP_OK);

    }

    public function getServiceStandardAPI($id){

        return response(Service::where('id',$id)->first()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getServiceDetailStandardAPI($id){

        return response(ServiceDetail::where('id',$id)->first()->jsonSerialize(), Response::HTTP_OK);
    }
}
