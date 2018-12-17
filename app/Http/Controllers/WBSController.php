<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Models\Structure;
use App\Models\Project;
use App\Models\WBS;
use App\Models\Category;
use DB;
use DateTime;
use Auth;

class WBSController extends Controller
{
    public function createWBS($id)
    {
        $project = Project::find($id);

        return view('wbs.createWBS', compact('project'));
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();
        $wbss = WBS::where('project_id',$data['project_id'])->get();
        foreach ($wbss as $wbs) {
            if($wbs->name == $data['name']){
                return response(["error"=>"WBS Name must be UNIQUE"],Response::HTTP_OK);
            }
        }
        DB::beginTransaction();
        try {
            $wbs = new WBS;
            $wbs->code = self::generateWbsCode($data['project_id']);
            $wbs->name = $data['name'];
            $wbs->description = $data['description'];
            $wbs->deliverables = $data['deliverables'];
            $wbs->project_id = $data['project_id'];

            if(isset($data['wbs_id'])){
                $wbs->wbs_id = $data['wbs_id'];
            }
            $plannedDeadline = DateTime::createFromFormat('m/j/Y', $data['planned_deadline']);
            $wbs->planned_deadline =  $plannedDeadline->format('Y-m-d');
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

    public function createSubWBS($project_id, $wbs_id)
    {
        $wbs = WBS::find($wbs_id);
        $project = Project::find($project_id);

        $array = [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$project->number => route('project.show',$project->id),
            'Add WBS' => route('wbs.createWBS',$project->id),
        ];
        $iteration = 0;
        $array_reverse = [];
        $array_reverse = array_reverse(self::getParents($wbs,$array_reverse,$project->id, $iteration));
        foreach ($array_reverse as $key => $value) {
            $array[$key] = $value;
        }
        $array[$wbs->code] = "";
        return view('wbs.createSubWBS', compact('project', 'wbs','array','structures'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->json()->all();
        $wbs_ref = WBS::find($id);
        $wbss = WBS::where('project_id',$data['project_id'])->get();
        foreach ($wbss as $wbs) {
            if($wbs->name == $data['name'] && $wbs_ref->name != $data['name'] ){
                return response(["error"=>"WBS Name must be UNIQUE"],Response::HTTP_OK);
            }
        }
        DB::beginTransaction();
        try {
            $wbs_ref->name = $data['name'];
            $wbs_ref->description = $data['description'];
            $wbs_ref->deliverables = $data['deliverables'];
            $plannedDeadline = DateTime::createFromFormat('m/j/Y', $data['planned_deadline']);
            $wbs_ref->planned_deadline =  $plannedDeadline->format('Y-m-d');
            $wbs_ref->weight =  $data['weight'];

            if(!$wbs_ref->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update WBS ".$wbs_ref->code],Response::HTTP_OK);
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
        $wbss = WBS::where('project_id',$data->project_id)->get();
        foreach ($wbss as $wbs) {
            if($wbs->name == $data->name && $wbs_ref->name != $data->name ){
                return response(["error"=>"WBS Name must be UNIQUE"],Response::HTTP_OK);
            }
        }
        DB::beginTransaction();
        try {
            $wbs_ref->name = $data->name;
            $wbs_ref->description = $data->description;
            $wbs_ref->deliverables = $data->deliverables;
            $plannedDeadline = DateTime::createFromFormat('m/j/Y', $data->planned_deadline);
            $wbs_ref->planned_deadline =  $plannedDeadline->format('Y-m-d');
            $wbs_ref->weight =  $data->weight;

            if(!$wbs_ref->save()){
                return redirect()->route('wbs.show', ['id' => $id])->with('success', "Failed to save, please try again!");
            }else{
                DB::commit();
                return redirect()->route('wbs.show', ['id' => $id])->with('success', 'WBS Successfully Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
                return redirect()->route('wbs.show', ['id' => $id])->with('success', 'Bill Of Material Created');
        }
    }

    public function index($id)
    {
        $project = Project::find($id);
        $resourceCategories = Category::where('used_for', 'RESOURCE')->get();

        $wbss=$project->wbss;
        $dataJsTree = Collection::make();
        $dataJsTree->push([
            "id" => $project->number , 
            "parent" => "#",
            "text" => $project->name,
            "icon" => "fa fa-ship"
        ]);
        foreach($wbss as $wbs){
            if($wbs->wbs){
                if(count($wbs->activities)>0){
                    $totalWeight = $wbs->wbss->sum('weight') + $wbs->activities->sum('weight');
                    $dataJsTree->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->name. " | Weight : (".$totalWeight."% / ".$wbs->weight."%)",
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => "/wbs/show/".$wbs->id],
                    ]);
                }else{
                    $dataJsTree->push([
                        "id" => $wbs->code , 
                        "parent" => $wbs->wbs->code,
                        "text" => $wbs->name. " | Weight : ".$wbs->weight."%",
                        "icon" => "fa fa-suitcase",
                        "a_attr" =>  ["href" => "/wbs/show/".$wbs->id],
                    ]);
                }
            }else{
                $totalWeight = $wbs->wbss->sum('weight') + $wbs->activities->sum('weight');

                $dataJsTree->push([
                    "id" => $wbs->code , 
                    "parent" => $project->number,
                    "text" => $wbs->name. " | Weight : (".$totalWeight."% / ".$wbs->weight."%)",
                    "icon" => "fa fa-suitcase",
                    "a_attr" =>  ["href" => "/wbs/show/".$wbs->id],
                ]);
            } 
        }

        return view('wbs.index', compact('project','resourceCategories','dataJsTree'));
    }

    public function show($id)
    {
        $wbs = WBS::find($id);

        return view('wbs.show', compact('wbs'));

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

    //BUAT BREADCRUMB DINAMIS
    function getParents($wbs, $array_reverse, $project_id, $iteration) {
        if ($wbs) {
            if($wbs->wbs){
                $array_reverse[$wbs->code] = route('wbs.createSubWBS',[$project_id,$wbs->wbs->id]);
                return self::getParents($wbs->wbs,$array_reverse, $project_id, $iteration);
            }else{
                $array_reverse[$wbs->code] = route('wbs.createSubWBS',[$project_id,$wbs->id]);
                return $array_reverse;
            }
        }
    }

    //API
    public function getWbsAPI($project_id){
        $wbss = WBS::orderBy('planned_deadline', 'asc')->where('project_id', $project_id)->where('wbs_id', null)->get()->jsonSerialize();
        return response($wbss, Response::HTTP_OK);
    }

    public function getAllWbsAPI($project_id){
        $wbss = WBS::orderBy('planned_deadline', 'asc')->where('project_id', $project_id)->with('wbs')->get()->jsonSerialize();
        return response($wbss, Response::HTTP_OK);
    }

    public function getSubWbsAPI($wbs_id){
        $wbss = WBS::orderBy('planned_deadline', 'asc')->where('wbs_id', $wbs_id)->get()->jsonSerialize();
        return response($wbss, Response::HTTP_OK);
    }

    public function getWeightWbsAPI($wbs_id){
        $wbs = WBS::find($wbs_id);
        $totalWeight = $wbs->wbss->sum('weight') + $wbs->activities->sum('weight');

        return response($totalWeight, Response::HTTP_OK);
    }
}
