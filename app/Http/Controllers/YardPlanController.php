<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\YardPlan;
use App\Models\Yard;
use App\Models\Project;
use DB;
use Auth;
use DateTime;

class YardPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $yardPlan = YardPlan::with('yard')->with('project')->get();
        $modelYard = Yard::all();
        $modelProject = Project::where('status',1)->get();

        return view ('yard_plan.create', compact('yardPlan','modelYard','modelProject'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            $yardPlan = new YardPlan;
            $yardPlan->yard_id = $datas->yard_id;

            $planned_start_date = DateTime::createFromFormat('d-m-Y', $datas->planned_start_date);
            $yardPlan->planned_start_date= $planned_start_date->format('Y-m-d');

            $planned_end_date = DateTime::createFromFormat('d-m-Y', $datas->planned_end_date);
            $yardPlan->planned_end_date= $planned_end_date->format('Y-m-d');
            $yardPlan->planned_duration = $datas->planned_duration;
            $yardPlan->description = $datas->description;
            $yardPlan->project_id = $datas->project_id;
            if($datas->wbs_id != ""){
                $yardPlan->wbs_id = $datas->wbs_id;
            }
            $yardPlan->branch_id = Auth::user()->branch->id;
            $yardPlan->user_id = Auth::user()->id;
            $yardPlan->save();
            
            DB::commit();
            return redirect()->route('yard_plan.create')->with('success', 'Yard Plan Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('yard_plan.create')->with('error', $e->getMessage());
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
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            $yardPlan = YardPlan::find($id);
            $yardPlan->yard_id = $datas->yard_id;
            $planned_start_date = DateTime::createFromFormat('d-m-Y', $datas->planned_start_date);
            $yardPlan->planned_start_date= $planned_start_date->format('Y-m-d');

            $planned_end_date = DateTime::createFromFormat('d-m-Y', $datas->planned_end_date);
            $yardPlan->planned_end_date= $planned_end_date->format('Y-m-d');
            $yardPlan->planned_duration = $datas->planned_duration;
            $yardPlan->description = $datas->description;
            $yardPlan->project_id = $datas->project_id;
            if($datas->wbs_id != ""){
                $yardPlan->wbs_id = $datas->wbs_id;
            }
            $yardPlan->branch_id = Auth::user()->branch->id;
            $yardPlan->user_id = Auth::user()->id;
            $yardPlan->update();
            
            DB::commit();
            return redirect()->route('yard_plan.create')->with('success', 'Yard Plan Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('yard_plan.create')->with('error', $e->getMessage());
        }
    }
    
    public function confirmActual(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $yardPlan = YardPlan::find($id);
            $actual_start_date = DateTime::createFromFormat('d-m-Y', $request->actual_start_date);
            $yardPlan->actual_start_date= $actual_start_date->format('Y-m-d');

            $actual_end_date = DateTime::createFromFormat('d-m-Y', $request->actual_end_date);
            $yardPlan->actual_end_date= $actual_end_date->format('Y-m-d');
            $yardPlan->save();
            
            DB::commit();
            return redirect()->route('yard_plan.create')->with('success', 'Yard Plan Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('yard_plan.create')->with('error', $e->getMessage());
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
        DB::beginTransaction();
        try {
            $yardPlan = YardPlan::find($id);
            if($yardPlan->actual_start_date != ""){
                return redirect()->route('yard_plan.create')->with('error', 'Failed to delete, This yard plan has already been confirmed!');
            }else{
                $yardPlan->delete();
            }
            
            DB::commit();
            return redirect()->route('yard_plan.create')->with('success', 'Yard Plan Deleted');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('yard_plan.create')->with('error', $e->getMessage());
        }
    }

    //API
    public function getWbsAPI($id){
        $modelProject = Project::findOrFail($id);
        $wbss = $modelProject->wbss;
        
        return response($wbss->jsonSerialize(), Response::HTTP_OK);
    }
}
