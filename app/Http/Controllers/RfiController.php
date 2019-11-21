<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Project;
use App\Models\QualityControlTask;
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
}
