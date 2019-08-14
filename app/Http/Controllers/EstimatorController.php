<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\EstimatorWbs;
use App\Models\EstimatorCostStandard;
use App\Models\EstimatorProfile;
use App\Models\EstimatorProfileDetail;
use App\Models\Uom;
use DB;
use Auth;

class EstimatorController extends Controller
{
    // WBS Cost Estimation
    public function indexEstimatorWbs(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelWbs = EstimatorWbs::all();

        return view('estimator.index_estimator_wbs', compact('modelWbs','route'));
    }

    public function createWbs(Request $request)
    {
        $route = $request->route()->getPrefix();
        $wbs = new EstimatorWbs;
        $wbs_code = self::generateWbsCode();

        return view('estimator.create_wbs', compact('wbs', 'wbs_code','route'));
    }

    public function storeWbs(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_branch|string|max:255',
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $route = $request->route()->getPrefix();

        DB::beginTransaction();
        try{
            $wbs = new EstimatorWbs;
            $wbs->code = $request->code;
            $wbs->name = $request->name;
            $wbs->description = $request->description;
            $wbs->status = $request->status;
            $wbs->user_id = Auth::user()->id;
            $wbs->branch_id = Auth::user()->branch->id;
            $wbs->save();

            DB::commit();
            if($route == "/estimator"){
                return redirect()->route('estimator.indexEstimatorWbs')->with('success','Success Created New WBS Cost Estimation!');
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.indexEstimatorWbs')->with('success','Success Created New WBS Cost Estimation!');
            }
        }catch (\Exception $e) {
            DB::rollback();
            if($route == "/estimator"){
                return redirect()->route('estimator.createWbs')->with('error',$e->getMessage());
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.createWbs')->with('error',$e->getMessage());
            }
        }
    }

    public function editWbs(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $wbs = EstimatorWbs::findOrFail($id);

        return view('estimator.create_wbs', compact('wbs','route')); 
    }

    public function updateWbs(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_branch|string|max:255',
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $route = $request->route()->getPrefix();

        DB::beginTransaction();
        try{
            $wbs = EstimatorWbs::findOrFail($id);
            $wbs->code = $request->code;
            $wbs->name = $request->name;
            $wbs->description = $request->description;
            $wbs->status = $request->status;
            $wbs->update();

            DB::commit();
            if($route == "/estimator"){
                return redirect()->route('estimator.indexEstimatorWbs')->with('success','Success Updated WBS Cost Estimation!');
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.indexEstimatorWbs')->with('success','Success Updated WBS Cost Estimation!');
            }
        }catch (\Exception $e) {
            DB::rollback();
            if($route == "/estimator"){
                return redirect()->route('estimator.editWbs')->with('error',$e->getMessage());
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.editWbs')->with('error',$e->getMessage());
            }
        }
    }

    // public function showWbs($id)
    // {
    //     //
    // }

    // Cost Standard
    public function indexEstimatorCostStandard(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelCostStandard = EstimatorCostStandard::all();

        return view('estimator.index_estimator_cost_standard', compact('modelCostStandard','route'));
    }
    
    public function createCostStandard(Request $request)
    {
        $route = $request->route()->getPrefix();
        $cost_standard = new EstimatorCostStandard;
        $cost_standard_code = self::generateCostStandardCode();
        $modelWbs = EstimatorWbs::where('status',1)->get();
        $modelUom = Uom::where('status',1)->get();

        return view('estimator.create_cost_standard', compact('cost_standard', 'cost_standard_code','route','modelWbs','modelUom'));
    }

    public function storeCostStandard(Request $request)
    {
        $route = $request->route()->getPrefix();
        $data = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $cost_standard = new EstimatorCostStandard;
            $cost_standard->code = $data->code;
            $cost_standard->name = $data->name;
            $cost_standard->description = $data->description;
            $cost_standard->estimator_wbs_id = $data->wbs_id;
            $cost_standard->uom_id = $data->uom_id;
            $cost_standard->value = $data->value;
            $cost_standard->status = $data->status;
            $cost_standard->user_id = Auth::user()->id;
            $cost_standard->branch_id = Auth::user()->branch->id;
            $cost_standard->save();

            DB::commit();
            if($route == "/estimator"){
                return redirect()->route('estimator.showCostStandard',$cost_standard->id)->with('success','Success Created New Cost Standard!');
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.showCostStandard',$cost_standard->id)->with('success','Success Created New Cost Standard!');
            }
        }catch (\Exception $e){
            DB::rollback();
            if($route == "/estimator"){
                return redirect()->route('estimator.createCostStandard')->with('error',$e->getMessage());
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.createCostStandard')->with('error',$e->getMessage());
            }
        }
    }

    public function showCostStandard(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $cost_standard = EstimatorCostStandard::findOrFail($id);

        return view('estimator.show_cost_standard', compact('cost_standard','route'));
    }

    public function editCostStandard(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $cost_standard = EstimatorCostStandard::findOrFail($id);
        $modelWbs = EstimatorWbs::where('status',1)->get();
        $modelUom = Uom::where('status',1)->get();
        $cost_standard_code = null;

        return view('estimator.create_cost_standard', compact('cost_standard','route','modelWbs','modelUom','cost_standard_code')); 
    }

    public function updateCostStandard(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $data = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $cost_standard = EstimatorCostStandard::findOrFail($id);
            $cost_standard->name = $data->name;
            $cost_standard->description = $data->description;
            $cost_standard->estimator_wbs_id = $data->wbs_id;
            $cost_standard->uom_id = $data->uom_id;
            $cost_standard->value = $data->value;
            $cost_standard->status = $data->status;
            $cost_standard->update();

            DB::commit();
            if($route == "/estimator"){
                return redirect()->route('estimator.showCostStandard',$cost_standard->id)->with('success','Success Updated Cost Standard!');
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.showCostStandard',$cost_standard->id)->with('success','Success Updated Cost Standard!');
            }
        }catch (\Exception $e){
            DB::rollback();
            if($route == "/estimator"){
                return redirect()->route('estimator.editCostStandard',$cost_standard->id)->with('error',$e->getMessage());
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.editCostStandard',$cost_standard->id)->with('error',$e->getMessage());
            }
        }
    }

    public function indexEstimatorProfile()
    {
        
    }

    public function createProfile()
    {
        
    }

    public function storeProfile(Request $request)
    {
        //
    }

    public function showProfile($id)
    {
        //
    }

    public function editProfile($id)
    {
        //
    }
    
    public function updateProfile(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    // function
    public function generateWbsCode(){
        $code = 'EWBS';
        $modelWbs = EstimatorWbs::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelWbs)){
            $number += intval(substr($modelWbs->code, -4));
		}

        $wbs_code = $code.''.sprintf('%04d', $number);
		return $wbs_code;
    }
    
    public function generateCostStandardCode(){
        $code = 'ECS';
        $modelCostStandard = EstimatorCostStandard::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelCostStandard)){
            $number += intval(substr($modelCostStandard->code, -4));
		}

        $cost_standard_code = $code.''.sprintf('%04d', $number);
		return $cost_standard_code;
    }
}
