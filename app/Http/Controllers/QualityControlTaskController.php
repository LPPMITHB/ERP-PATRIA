<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bom;
use App\Models\Project;
use App\Models\WBS;
use App\Models\QualityControlTask;
use App\Models\QualityControlType;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;


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

    public function index()
    {
        //
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

        // dd($modelWbs);
        
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
        $qc_type = QualityControlType::where('id',$id)->with('code','name')->first()->jsonSerialize();
        return response($qc_type, Response::HTTP_OK);
    }
}
