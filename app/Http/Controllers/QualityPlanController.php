<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\QualityPlan;
use App\Models\QualityControlType;
use App\Models\Configuration;
use App\Models\QualityPlanDetail;

class QualityPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $qualityPlan = QualityPlan::findOrFail($id);
        $qualityPlanDetail = QualityPlanDetail::where('quality_plan_id', 'qualityPlan')->get();
		$project = Project::findOrFail($id);

        $qualityPlanTable = json_decode($qualityPlan->tables);
        $configurationQualityPlanTable = Configuration::where('slug', 'peran-quality-plan-role')->first();
        $configurationQualityPlanTable = $configurationQualityPlanTable->value;
        // $totalArray = count(json_decode($qualityPlanTable));
        $configurationQualityPlanTable = json_decode($configurationQualityPlanTable);

        $i = 0;
        $ade = (array) $configurationQualityPlanTable;
        // dd($ade->id);
		/*
        foreach ($qualityPlanTable as $qualityPlanTablese) {
            $qualityPlanTable[$i]->id = $this->ConfigurationFinder2d($configurationQualityPlanTable, "id", $qualityPlanTable[$i])->value;
            $i++;
        }*/
        $wbs = null;
        $wbs_images = null;
        return view('qc_plan.index', compact('qualityPlanTable','project'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show(Request $request, $id)
    {
		$route = $request->route()->getPrefix();
		$modelProject = Project::findOrFail($id);
		$modelQP = QualityPlan::where('project_id',$id)->first();
		$modelQPD = QualityPlanDetail::where('quality_plan_id',$modelQP->id)->get();
		$modelQCT = QualityControlType::where('ship_id',$modelProject->ship_id)->get();

		//To-Do : Throwback error if fail to retrieve data.
        return view('qc_plan.show', compact('modelProject','modelQP','modelQPD','modelQCT','route'));
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
    ///
    public function selectProject()
    {
        $modelProject = Project::where('status', 1)->get();
        return view('qc_plan.selectProject', compact('modelProject'));
    }

    private function ConfigurationFinder2d($products, $field, $value)
    {
        foreach ($products as $key => $product) {
            if ($product->$field === $value)
                return $product;
        }
        return false;
    }
}
