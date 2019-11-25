<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Project;
use App\Models\QualityControlTask;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Auth;
use DB;

class RfiController extends Controller
{
    public function selectProject(){
        $modelProject = Project::where('status',1)->get();

        return view('rfi.selectProject', compact('modelProject'));
    }

    public function selectQcTask(Request $request, $id)
    {
        $project = Project::find($id);
        $wbss = $project->wbss->pluck('id')->toArray();
        $modelQcTasks = QualityControlTask::whereIn('wbs_id',$wbss)->where('external_join', true)->get();

        return view('rfi.selectQcTask', compact('project','modelQcTasks'));
    }

    public function create(Request $request, $id)
    {
        $route = $request->route()->getPrefix();

        $qcTask = QualityControlTask::find($id);
        $emailTemplates = EmailTemplate::all();

        $wbs = $qcTask->wbs;
        $project = $wbs->project;
        
        return view('rfi.create', compact('project','wbs','qcTask','emailTemplates'));
    }
}
