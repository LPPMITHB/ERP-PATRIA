<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Project;
use App\Models\DeliveryDocument;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use File;

class CloseProjectController extends Controller
{
    public function selectProject(){
        $modelProject = Project::where('status',1)->get();

        return view('close_project.selectProject', compact('modelProject'));
    }

    public function show(Request $request,$id){
        $route = $request->route()->getPrefix();
        $project = Project::find($id);
        $deliveryDocuments = $project->deliveryDocuments;

        return view('close_project.show', compact('deliveryDocuments','route','project'));
    }

    public function close(Request $request, $id)
    {
        $route = $request->route()->getPrefix();

        DB::beginTransaction();
        try {
            $project = Project::find($id);
            $project->status = 0;
            $project->update();

            DB::commit();
            if($route == "/close_project"){
                return redirect()->route('project.show', ['id' => $project->id])->with('success', 'Project Closed');
            }elseif($route == "/close_project_repair"){
                return redirect()->route('project_repair.show', ['id' => $project->id])->with('success', 'Project Closed');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/close_project"){
                return redirect()->route('close_project.show', ['id' => $project->id])->with('error', $e->getMessage());
            }elseif($route == "/close_project_repair"){
                return redirect()->route('close_project.show', ['id' => $project->id])->with('error', $e->getMessage());
            }
        }
    }
}
