<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use App\Models\Project;
use App\Models\WBS;
use App\Models\QualityControlTask;
use App\Models\QualityControlTaskDetail;
use App\Models\QualityControlType;
use App\Models\QualityControlTypeDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
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
    public function selectProject()
    {
        $modelProject = Project::where('status',1)->get();

        return view('qc_task.selectProject',compact('modelProject'));
    }

    public function selectProjectIndex()
    {
        $modelProject = Project::where('status',1)->get();

        return view('qc_task.selectProjectIndex',compact('modelProject'));
    }
    
    public function selectProjectConfirm()
    {
        $modelProject = Project::where('status',1)->get();

        return view('qc_task.selectProjectConfirm',compact('modelProject'));
    }
    
    public function selectProjectSummary()
    {
        $modelProject = Project::where('status',1)->get();

        return view('qc_task.selectProjectSummary',compact('modelProject'));
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
                                "a_attr" =>  ["href" => route('qc_task_repair.edit',$bom->id)],
                            ]);
                        }else{
                            $data->push([
                                "id" => $wbs->code , 
                                "parent" => $project->number,
                                "text" => $wbs->number.' - '.$wbs->description.'<b>'.$qc_task_number.'</b>',
                                "icon" => "fa fa-suitcase",
                                "a_attr" =>  ["href" => route('qc_task_repair.edit',$bom->id)],
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
                return redirect()->route('qc_task_repair.selectProject')->with('error', 'Project isn\'t exist, Please try again !');
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
        $project = Project::find($id);
        $wbss = $project->wbss->pluck('id')->toArray();
        $modelQcTasks = QualityControlTask::whereIn('wbs_id',$wbss)->with('wbs','qualityControlTaskDetails')->get();

        return view('qc_task.summaryReport', compact('project','modelQcTasks'));
    }

    public function confirm(Request $request, $id)
    {
        $qcTask = QualityControlTask::findOrFail($id);
        $route = $request->route()->getPrefix();
        return view('qc_task.confirm', compact('qcTask', 'route'));
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
        $planned_end_date = DateTime::createFromFormat('Y-m-d', $modelWbs->planned_end_date);
        $modelWbs->planned_end_date = $planned_end_date->format('d-m-Y');
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
            DB::commit();
            return redirect()->route('qc_task.show', $qcTask->id)->with('success', 'Success Created New Quality Control Task!');
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
    public function show($id)
    {
        $qcTask = QualityControlTask::findOrFail($id);
        $wbs = $qcTask->wbs;
        return view('qc_task.show', compact('qcTask','wbs'));
        
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
            $qcTask->description = $data->description;
            $qcTask->user_id = Auth::user()->id;
            $qcTask->branch_id = Auth::user()->branch->id;
            $qcTask->update();


            foreach ($data->deletedQcTaskDetail as $id) {
                $qcTaskDetail = QualityControlTaskDetail::find($id);
                $qcTaskDetail->delete();
            }
            foreach ($data->dataQcTask as $data) {
                if(isset($data->id)){
                    $qcTaskDetail = QualityControlTaskDetail::find($data->id);
                    $qcTaskDetail->name = $data->name;
                    $qcTaskDetail->description = $data->description;
                    $qcTaskDetail->update();
                }else{
                    $qcTaskDetail = new QualityControlTaskDetail;
                    $qcTaskDetail->quality_control_task_id = $qcTask->id;
                    $qcTaskDetail->name = $data->name;
                    $qcTaskDetail->description = $data->description;
                    $qcTaskDetail->save();
                }
            }
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
            $qc_task = QualityControlTask::find($id);
            $qc_task->status = 0;

            if(!$qc_task->update()){
                return redirect()->route('qc_task.confirm', $qc_task->id)->with('error', 'Failed to save, please try again!');
            }else{
                DB::commit();
                return redirect()->route('qc_task.selectQcTask', $qc_task->wbs->project_id)->with('success', 'Success to confirm Finish QC Task!');
            }
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('qc_task.confirm', $qc_task->id)->with('error', $e->getMessage());
        }
    }

    public function cancelFinish(Request $request,$id){
        DB::beginTransaction();
        try{
            $qc_task = QualityControlTask::find($id);
            $qc_task->status = 1;

            if(!$qc_task->update()){
                return redirect()->route('qc_task.confirm', $qc_task->id)->with('error', 'Failed to save, please try again!');
            }else{
                DB::commit();
                return redirect()->route('qc_task.confirm', $qc_task->id)->with('success', 'Success to cancel Finish QC Task!');
            }
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('qc_task.confirm', $qc_task->id)->with('error', $e->getMessage());
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
