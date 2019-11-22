<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use App\Models\Project;
use App\Models\WBS;
use App\Models\QualityControlTask;
use App\Models\QualityControlTaskDetail;
use App\Models\QualityControlType;
use App\Models\QualityControlTypeDetail;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use App\Exports\SummaryReportExport;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;
use Auth;
use DB;

class QualityControlTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectProject(Request $request)
    {
        $route = $request->route()->getPrefix();
        if($route == "/qc_task"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == "/qc_task_repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get();
        }

        return view('qc_task.selectProject',compact('modelProject'));
    }

    public function selectProjectIndex(Request $request)
    {
        $route = $request->route()->getPrefix();
        if($route == "/qc_task"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == "/qc_task_repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get();
        }

        return view('qc_task.selectProjectIndex',compact('route','modelProject'));
    }
    
    public function selectProjectConfirm(Request $request)
    {
        $route = $request->route()->getPrefix();
        if($route == "/qc_task"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == "/qc_task_repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get();
        }

        return view('qc_task.selectProjectConfirm',compact('route','modelProject'));
    }
    
    public function selectProjectSummary(Request $request)
    {
        $route = $request->route()->getPrefix();
        if($route == "/qc_task"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get();
        }elseif($route == "/qc_task_repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get();
        }

        return view('qc_task.selectProjectSummary',compact('route','modelProject'));
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

        if($route == '/qc_task'){
            if($project->business_unit_id == 1){
                foreach($wbss as $wbs){
                    $qc_task_number = "";
                    $qc_task = QualityControlTask::where('wbs_id',$wbs->id)->first();
                    if($qc_task){
                        $qc_task_number = " - This WBS has already assigned QC Tasks - ";
                        if($wbs->wbs){
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $wbs->wbs->code,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$qc_task_number.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('qc_task.edit',$qc_task->id)],
                            ]);
                        }else{
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $project->number,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$qc_task_number.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('qc_task.edit',$qc_task->id)],
                            ]);
                        } 
                    }else{
                        if($wbs->wbs){
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $wbs->wbs->code,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('qc_task.create',$wbs->id)],
                            ]);
                        }else{
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $project->number,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('qc_task.create',$wbs->id)],
                            ]);
                        } 
                    } 
                }
            }else{
                return redirect()->route('qc_task.selectProject')->with('error', 'Project isn\'t exist, Please try again !');
            }
        }elseif($route == '/qc_task_repair'){
            if($project->business_unit_id == 2){
                foreach($wbss as $wbs){
                    $qc_task_number = "";
                    $qc_task = QualityControlTask::where('wbs_id',$wbs->id)->first();
                    if($qc_task){
                        $qc_task_number = " - This WBS has already assigned QC Tasks - ";
                        if($wbs->wbs){
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $wbs->wbs->code,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$qc_task_number.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('qc_task_repair.edit',$qc_task->id)],
                            ]);
                        }else{
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $project->number,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$qc_task_number.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('qc_task_repair.edit',$qc_task->id)],
                            ]);
                        } 
                    }else{
                        if($wbs->wbs){
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $wbs->wbs->code,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$qc_task_number.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('qc_task_repair.create',$wbs->id)],
                            ]);
                        }else{
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $project->number,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$qc_task_number.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('qc_task_repair.create',$wbs->id)],
                            ]);
                        } 
                    } 
                }
            }else{
                return redirect()->route('qc_task_repair.selectProject')->with('error', 'Project doesn\'t exist, Please try again !');
            }
        }
        return view('qc_task.selectWBS', compact('project','data','route'));
    }

    public function index(Request $request, $id)
    {
        $project = Project::find($id);
        $wbss = $project->wbss->pluck('id')->toArray();
        $modelQcTasks = QualityControlTask::whereIn('wbs_id',$wbss)->get();

        return view('qc_task.index', compact('project','modelQcTasks'));
    }

    public function selectQcTask(Request $request, $id)
    {
        $project = Project::find($id);
        $wbss = $project->wbss->pluck('id')->toArray();
        $modelQcTasks = QualityControlTask::whereIn('wbs_id',$wbss)->get();

        return view('qc_task.selectQcTask', compact('project','modelQcTasks'));
    }

    public function summaryReport(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::find($id);
        $wbss = $project->wbss->pluck('id')->toArray();
        $modelQcTasks = QualityControlTask::whereIn('wbs_id',$wbss)->with('wbs','qualityControlTaskDetails','qualityControlType.qualityControlTypeDetails')->get();

        $wbss = WBS::where('project_id', $id)->with('qualityControlTask')->get();
        $data = Collection::make();

        $data->push([
            "id" => $project->number , 
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);

        $rejected = 0;
        $approved = 0;
        foreach ($modelQcTasks as $qc_task) {
            foreach ($qc_task->qualityControlTaskDetails as $qc_task_detail) {
                if($qc_task_detail->status_first == "OK"){
                    $approved++;
                }elseif($qc_task_detail->status_first == "NOT OK"){
                    $rejected++;
                }
            }
        }

        $rejection_ratio = $rejected/$approved;


        foreach($wbss as $wbs){
            $qc_task = QualityControlTask::where('wbs_id',$wbs->id)->first();
            if($qc_task){
                if($qc_task->status == 0){
                    $status = "DONE";
                }else{
                    $status = "NOT DONE";
                }
                if($wbs->wbs){
                    $data->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->number.' - '.$wbs->description.' <b>['.$status.']</b>',
                        "icon" => "fa fa-suitcase",
                        "qc_task_id" => $qc_task->id,
                    ]);
                }else{
                    $data->push([
                        "id" => $wbs->code , 
                        "parent" => $project->number,
                        "text" => $wbs->number.' - '.$wbs->description.' <b>['.$status.']</b>',
                        "icon" => "fa fa-suitcase",
                        "qc_task_id" => $qc_task->id,
                    ]);
                } 
            }else{
                if($wbs->wbs){
                    $data->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->number.' - '.$wbs->description.'<b>',
                        "icon" => "fa fa-suitcase",
                    ]);
                }else{
                    $data->push([
                        "id" => $wbs->code , 
                        "parent" => $project->number,
                        "text" => $wbs->number.' - '.$wbs->description.'<b>',
                        "icon" => "fa fa-suitcase",
                    ]);
                } 
            } 
        }

        return view('qc_task.summaryReport', compact('route','project','modelQcTasks','data','wbss','rejection_ratio','approved','rejected'));
    }

    public function confirm(Request $request, $id)
    {
        $qcTask = QualityControlTask::findOrFail($id);
        $route = $request->route()->getPrefix();
        $wbs_images = $qcTask->wbs->wbsi;
        return view('qc_task.confirm', compact('qcTask', 'route','wbs_images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        // print_r($id);exit();
        $route = $request->route()->getPrefix();
        $modelQcType = QualityControlType::all();
        $modelWbs = WBS::findOrFail($id);
        if($modelWbs->planned_end_date != null){
            $planned_end_date = DateTime::createFromFormat('Y-m-d', $modelWbs->planned_end_date);
            $modelWbs->planned_end_date = $planned_end_date->format('d-m-Y');
        }else{
            return redirect()->route('qc_task_repair.selectWBS', $modelWbs->project_id)->with('error', 'Please define end date for the WBS!');
        }
        return view('qc_task.create', compact('route','modelQcType','modelWbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->datas);
        $menu = $request->route()->getPrefix() == "/qc_task" ? "building" : "repair";

        DB::beginTransaction();
        try {
            $qcTask = new QualityControlTask;
            $qcTask->wbs_id = $data->wbs_id;
            $qcTask->quality_control_type_id = $data->qc_type_id;
            if($data->description != ''){
                $qcTask->description = $data->description;
            }else{
                $qcTask->description = null;
            }
            $qcTask->external_join = $data->checkedExternal;
            $startDate = DateTime::createFromFormat('d-m-Y', $data->start_date);
            $endDate = DateTime::createFromFormat('d-m-Y', $data->end_date);
            if($startDate){
                $qcTask->start_date = $startDate->format('Y-m-d');
            }else{
                $qcTask->start_date = null;
            }
            if($endDate){
                $qcTask->end_date = $endDate->format('Y-m-d');
            }else{
                $qcTask->end_date = null;
            }
            $qcTask->duration = $data->duration;
            $qcTask->user_id = Auth::user()->id;
            $qcTask->branch_id = Auth::user()->branch->id;
            
            if ($qcTask->save()) {
                foreach ($data->dataQcTask as $dataQCDetail) {
                    $qcTaskDetail = new QualityControlTaskDetail;
                    $qcTaskDetail->quality_control_task_id = $qcTask->id;
                    $qcTaskDetail->name = $dataQCDetail->name;
                    $qcTaskDetail->description = $dataQCDetail->task_description;
                    $qcTaskDetail->save();
                }
            }

            //MAKE NOTIF
            if ($menu == 'building') {
                $dataNotif = json_encode([
                    'text' => 'The Quality Control of WBS(' . $qcTask->wbs->number . '-' . $qcTask->wbs->description . ') is overdue, please do the Quality Control Task',
                    'time_info' => 'Created at',
                    'title' => 'Quality Control Overdue',
                    'url' => '/qc_task/confirm/' . $qcTask->id,
                ]);
            } else if ($menu == 'repair') {
                $dataNotif = json_encode([
                    'text' => 'The Quality Control of WBS(' . $qcTask->wbs->number . '-' . $qcTask->wbs->description . ') is overdue, please do the Quality Control Task',
                    'time_info' => 'Created at',
                    'title' => 'Quality Control Overdue',
                    'url' => '/qc_task_repair/confirm/' . $qcTask->id,
                ]);
            }

            if($menu == 'building'){
                $users = User::where('role_id', 4)->select('id')->get();
            }else{
                $users = User::where('role_id', 5)->select('id')->get();
            }
            foreach ($users as $user) {
                $user->status = 1;
            }
            $users = json_encode($users);

            $new_notification = new Notification;
            $new_notification->type = "Quality Control Overdue";
            $new_notification->document_id = $qcTask->id;
            if($menu == 'building'){
                $new_notification->role_id = 2;
            }else{
                $new_notification->role_id = 3;
            }
            $new_notification->notification_date = $qcTask->created_at->toDateString();
            $new_notification->show_date = $qcTask->start_date;
            $new_notification->data = $dataNotif;
            $new_notification->user_data = $users;
            $new_notification->save();
            //END NOTIF

            DB::commit();
            if($menu == "building"){
                return redirect()->route('qc_task.show', $qcTask->id)->with('success', 'Success Created New Quality Control Task!');
            }else{
                return redirect()->route('qc_task_repair.show', $qcTask->id)->with('success', 'Success Created New Quality Control Task!');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('qc_task.selectProject')->with('error', $e->getMessage())->withInput();
        }
    }

    public function storeConfirm(Request $request){
        $data = $request->json()->all();
        DB::beginTransaction();
        try{
            $qc_task_detail = QualityControlTaskDetail::find($data['id']);
            if($data['status_first_ref'] == null){
                $qc_task_detail->status_first = $data['status_first'];
            }else{
                $qc_task_detail->status_second = $data['status_second'];
            }
            $qc_task_detail->notes = $data['notes'];

            if(!$qc_task_detail->update()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to confirm QC Task Detail"],Response::HTTP_OK);
            }
        }catch(\Exception $e){
            DB::rollback();
            return response(["error"=>$e->getMessage()],Response::HTTP_OK);
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
        $route = $request->route()->getPrefix();
        $qcTask = QualityControlTask::findOrFail($id);
        $wbs = $qcTask->wbs;
        $wbs_images = $wbs->wbsi;
        return view('qc_task.show', compact('route','qcTask','wbs','wbs_images'));
        
    }

    public function exportToExcel($id, Request $request)
    {
        $project = Project::find($id);
        $now = date("Y_m_d_H_i_s");
        return Excel::download(new SummaryReportExport($id), 'Summary_Report_'.$project->number.'_' . $now . '.xlsx');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $qcTask = QualityControlTask::findOrFail($id);
        $start_date = DateTime::createFromFormat('Y-m-d', $qcTask->start_date);
        $qcTask->start_date = $start_date->format('d-m-Y');
        $end_date = DateTime::createFromFormat('Y-m-d', $qcTask->end_date);
        $qcTask->end_date = $end_date->format('d-m-Y');

        $route = $request->route()->getPrefix();
        $modelQcType = QualityControlType::all();
        
        $editable = true;
        foreach ($qcTask->qualityControlTaskDetails as $qcTaskDetail) {
            if($qcTaskDetail->status != null){
                $editable = false;
            }
        }
        return view('qc_task.edit', compact('qcTask', 'editable', 'route', 'modelQcType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = json_decode($request->datas);
        try {
            
            $qcTask = QualityControlTask::find($data->id);
            if($qcTask->quality_control_type_id != $data->qc_type_id){
                $qcTask->qualityControlTaskDetails()->delete();
            }
            $qcTask->quality_control_type_id = $data->qc_type_id;
            if($data->description != ''){
                $qcTask->description = $data->description;
            }else{
                $qcTask->description = null;
            }
            $qcTask->external_join = $data->checkedExternal;
            $startDate = DateTime::createFromFormat('d-m-Y', $data->start_date);
            $endDate = DateTime::createFromFormat('d-m-Y', $data->end_date);
            if($startDate){
                $qcTask->start_date = $startDate->format('Y-m-d');
            }else{
                $qcTask->start_date = null;
            }
            if($endDate){
                $qcTask->end_date = $endDate->format('Y-m-d');
            }else{
                $qcTask->end_date = null;
            }
            $qcTask->duration = $data->duration;
            $qcTask->user_id = Auth::user()->id;
            $qcTask->branch_id = Auth::user()->branch->id;
            $qcTask->update();

            // Delete first QC Task Detail
            $qcTaskDetail = QualityControlTaskDetail::where('quality_control_task_id',$data->id)->delete();
            // if(count($qcTaskDetail) > 0){
            //     $qcTaskDetail->delete();
            // }

            foreach ($data->dataQcTask as $data) {
                $qcTaskDetail = new QualityControlTaskDetail;
                $qcTaskDetail->quality_control_task_id = $qcTask->id;
                $qcTaskDetail->name = $data->name;
                $qcTaskDetail->description = $data->task_description;
                $qcTaskDetail->save();
            }

            //UPDATE NOTIF
            $update_notification = Notification::where('type','Quality Control Overdue')->where('document_id',$data->id)->first();
            $update_notification->show_date = $qcTask->start_date;
            $update_notification->save();
            //END NOTIF

            DB::commit();
            return redirect()->route('qc_task.show', $qcTask->id)->with('success', 'Success Updated Quality Control Task!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('qc_task.edit', $qcTask->id)->with('error', $e->getMessage())->withInput();
        }
    }

    public function confirmFinish(Request $request,$id){
        DB::beginTransaction();
        try{
            $route = $request->route()->getPrefix();
            $qc_task = QualityControlTask::find($id);
            $qc_task->status = 0;

            if(!$qc_task->update()){
                if($route == "/qc_task"){
                    return redirect()->route('qc_task.confirm', $qc_task->id)->with('error', 'Failed to save, please try again!');
                }elseif($route == "/qc_task_repair"){
                    return redirect()->route('qc_task_repair.confirm', $qc_task->id)->with('error', 'Failed to save, please try again!');
                }
            }else{
                DB::commit();
                if($route == "/qc_task"){
                    return redirect()->route('qc_task.selectQcTask', $qc_task->wbs->project_id)->with('success', 'Success to confirm Finish QC Task!');
                }elseif($route == "/qc_task_repair"){
                    return redirect()->route('qc_task_repair.selectQcTask', $qc_task->wbs->project_id)->with('success', 'Success to confirm Finish QC Task!');
                }
            }
        }catch(\Exception $e){
            DB::rollback();
            if($route == "/qc_task"){
                return redirect()->route('qc_task.confirm', $qc_task->id)->with('error', $e->getMessage());
            }elseif($route == "/qc_task_repair"){
                return redirect()->route('qc_task_repair.confirm', $qc_task->id)->with('error', $e->getMessage());
            }
        }
    }

    public function cancelFinish(Request $request,$id){
        DB::beginTransaction();
        try{
            $route = $request->route()->getPrefix();
            $qc_task = QualityControlTask::find($id);
            $qc_task->status = 1;

            if(!$qc_task->update()){
                if($route == "/qc_task"){
                    return redirect()->route('qc_task.confirm', $qc_task->id)->with('error', 'Failed to save, please try again!');
                }elseif($route == "/qc_task_repair"){
                    return redirect()->route('qc_task_repair.confirm', $qc_task->id)->with('error', 'Failed to save, please try again!');
                }
            }else{
                if($route == "/qc_task"){
                    return redirect()->route('qc_task.confirm', $qc_task->id)->with('success', 'Success to cancel Finish QC Task!');
                }elseif($route == "/qc_task_repair"){
                    return redirect()->route('qc_task_repair.confirm', $qc_task->id)->with('success', 'Success to cancel Finish QC Task!');
                }
                DB::commit();
            }
        }catch(\Exception $e){
            if($route == "/qc_task"){
                return redirect()->route('qc_task.confirm', $qc_task->id)->with('error', $e->getMessage());
            }elseif($route == "/qc_task_repair"){
                return redirect()->route('qc_task_repair.confirm', $qc_task->id)->with('error', $e->getMessage());
            }
            DB::rollback();
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

    public function getQcTypeApi($id){
        $qc_type = QualityControlType::where('id',$id)->with('qualityControlTypeDetails')->first()->jsonSerialize();
        return response($qc_type, Response::HTTP_OK);
    }

    public function getQcTypeDetailsApi($id){
        $qcTypeDetails = QualityControlTypeDetail::where('quality_control_type_id',$id)->get()->jsonSerialize();
        return response($qcTypeDetails, Response::HTTP_OK);
    }

    public function getQcTaskDetailsAPI($id){
        $qcTask = QualityControlTask::findOrFail($id);
        $qcTaskDetails = $qcTask->qualityControlTaskDetails;
        return response($qcTaskDetails->jsonSerialize(), Response::HTTP_OK);
    }
}
