<?php

namespace App\Http\Controllers;

use App\Models\EstimatorWbs;
use App\Models\EstimatorCostStandard;
use App\Models\EstimatorProfile;
use App\Models\EstimatorProfileDetail;
use App\Models\Uom;
use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
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

    public function deleteWbs(Request $request, $id){
        $route = $request->route()->getPrefix();

        DB::beginTransaction();
        try{
            $wbs = EstimatorWbs::findOrFail($id);
            if(count($wbs->costStandards) > 0){
                if($route == "/estimator"){
                    return redirect()->route('estimator.indexEstimatorWbs')->with('success','Cannot Delete WBS Cost Estimation Because Still Used In Another Cost Standard!');
                }elseif($route == "/estimator_repair"){
                    return redirect()->route('estimator_repair.indexEstimatorWbs')->with('success','Cannot Delete WBS Cost Estimation Because Still Used In Another Cost Standard!');
                }
            }else{
                $wbs->delete();
            }

            DB::commit();
            if($route == "/estimator"){
                return redirect()->route('estimator.indexEstimatorWbs')->with('success','Success Deleted WBS Cost Estimation!');
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.indexEstimatorWbs')->with('success','Success Deleted WBS Cost Estimation!');
            }
        }catch (\Exception $e) {
            DB::rollback();
            if($route == "/estimator"){
                return redirect()->route('estimator.indexEstimatorWbs')->with('error',$e->getMessage());
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.indexEstimatorWbs')->with('error',$e->getMessage());
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

    public function deleteCostStandard(Request $request, $id){
        $route = $request->route()->getPrefix();

        DB::beginTransaction();
        try{
            $cost_standard = EstimatorCostStandard::findOrFail($id);
            if(count($cost_standard->estimatorProfileDetails) > 0){
                if($route == "/estimator"){
                    return redirect()->route('estimator.indexEstimatorCostStandard')->with('success','Cannot Delete Cost Standard Because Still Used In Another Estimator Profile!');
                }elseif($route == "/estimator_repair"){
                    return redirect()->route('estimator_repair.indexEstimatorCostStandard')->with('success','Cannot Delete Cost Standard Because Still Used In Another Estimator Profile!');
                }
            }else{
                $cost_standard->delete();
            }

            DB::commit();
            if($route == "/estimator"){
                return redirect()->route('estimator.indexEstimatorCostStandard')->with('success','Success Deleted Cost Standard!');
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.indexEstimatorCostStandard')->with('success','Success Deleted Cost Standard!');
            }
        }catch (\Exception $e) {
            DB::rollback();
            if($route == "/estimator"){
                return redirect()->route('estimator.indexEstimatorCostStandard')->with('error',$e->getMessage());
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.indexEstimatorCostStandard')->with('error',$e->getMessage());
            }
        }
    }

    // Estimator Profile
    public function indexEstimatorProfile(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelProfile = EstimatorProfile::all();

        return view('estimator.index_estimator_profile', compact('modelProfile','route'));
    }

    public function createProfile(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelShip = Ship::where('status',1)->get();
        $modelWbs = EstimatorWbs::where('status',1)->get();
        $modelCostStandard = EstimatorCostStandard::where('status',1)->with('uom','estimatorWbs')->get();
        $profile = new EstimatorProfile;
        $profile_code = self::generateProfileCode();
        
        return view('estimator.create_profile', compact('modelShip','route','modelWbs','modelCostStandard','profile','profile_code'));
    }

    public function storeProfile(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $profile = new EstimatorProfile;
            $profile->code = $datas->code;
            $profile->description = $datas->description;
            $profile->ship_id = $datas->ship_id;
            $profile->status = $datas->status;
            $profile->branch_id = Auth::user()->branch->id;
            $profile->user_id = Auth::user()->id;
            if(!$profile->save()){
                return redirect()->route('estimator.createProfile')->with('error', 'Failed Save Estimator Profile !');
            }else{
                foreach($datas->datas as $data){
                    $pd = new EstimatorProfileDetail;
                    $pd->cost_standard_id = $data->cost_standard_id;
                    $pd->profile_id = $profile->id;
                    $pd->save();
                }
                DB::commit();
                if($route == "/estimator"){
                    return redirect()->route('estimator.showProfile', ['id' => $profile->id])->with('success', 'Estimator Profile Created');
                }elseif($route == "/estimator_repair"){
                    return redirect()->route('estimator_repair.showProfile', ['id' => $profile->id])->with('success', 'Estimator Profile Created');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/estimator"){
                return redirect()->route('estimator.indexEstimatorProfile')->with('error', $e->getMessage());
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.indexEstimatorProfile')->with('error', $e->getMessage());
            }
        }
    }

    public function showProfile(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $profile = EstimatorProfile::findOrFail($id);

        $tree = Collection::make();
        $wbs_ids = [];

        $tree->push([
            "id" => $profile->ship->type , 
            "parent" => "#",
            "text" => $profile->ship->type,
            "icon" => "fa fa-ship"
        ]);

        foreach($profile->estimatorProfileDetails as $pd){
            array_push($wbs_ids,$pd->estimatorCostStandard->estimator_wbs_id);
        }
        $wbs_ids = array_unique($wbs_ids);

        foreach($wbs_ids as $wbs_id){
            $wbs = EstimatorWbs::findOrFail($wbs_id);
            $tree->push([
                "id" => $wbs->code , 
                "parent" => $profile->ship->type,
                "text" => $wbs->name,
                "icon" => "fa fa-briefcase"
            ]);
            foreach($profile->estimatorProfileDetails as $pd){
                if($pd->estimatorCostStandard->estimator_wbs_id == $wbs_id){
                    $tree->push([
                        "id" => $pd->estimatorCostStandard->code , 
                        "parent" => $wbs->code,
                        "text" => $pd->estimatorCostStandard->name,
                        "icon" => "fa fa-cog"
                    ]);
                }
            }
        }

        return view('estimator.show_profile', compact('profile','route','tree'));
    }

    public function editProfile(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelShip = Ship::where('status',1)->get();
        $modelWbs = EstimatorWbs::where('status',1)->get();
        $modelCostStandard = EstimatorCostStandard::where('status',1)->with('uom','estimatorWbs')->get();
        $profile = EstimatorProfile::where('id',$id)->with('estimatorProfileDetails','estimatorProfileDetails.estimatorCostStandard','estimatorProfileDetails.estimatorCostStandard.uom','estimatorProfileDetails.estimatorCostStandard.estimatorWbs')->first();
        $profile_code = '';
        
        return view('estimator.create_profile', compact('modelShip','route','modelWbs','modelCostStandard','profile','profile_code','profileDetails'));
    }
    
    public function updateProfile(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $profile = EstimatorProfile::where('code',$datas->code)->first();
            $profile->description = $datas->description;
            $profile->ship_id = $datas->ship_id;
            $profile->status = $datas->status;
            if(!$profile->update()){
                return redirect()->route('estimator.createProfile')->with('error', 'Failed Update Estimator Profile !');
            }else{
                foreach($datas->datas as $data){
                    if(isset($data->id)){
                        $pd = EstimatorProfileDetail::findOrFail($data->id);
                        $pd->cost_standard_id = $data->cost_standard_id;
                        $pd->update();
                    }else{
                        $pd = new EstimatorProfileDetail;
                        $pd->cost_standard_id = $data->cost_standard_id;
                        $pd->profile_id = $profile->id;
                        $pd->save();
                    }
                }

                foreach($datas->deleted_id as $id){
                    $pd = EstimatorProfileDetail::findOrFail($id);
                    $pd->delete();
                }
                DB::commit();
                if($route == "/estimator"){
                    return redirect()->route('estimator.showProfile', ['id' => $profile->id])->with('success', 'Estimator Profile Updated');
                }elseif($route == "/estimator_repair"){
                    return redirect()->route('estimator_repair.showProfile', ['id' => $profile->id])->with('success', 'Estimator Profile Updated');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/estimator"){
                return redirect()->route('estimator.indexEstimatorProfile')->with('error', $e->getMessage());
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.indexEstimatorProfile')->with('error', $e->getMessage());
            }
        }
    }

    public function deleteProfile(Request $request, $id){
        $route = $request->route()->getPrefix();

        DB::beginTransaction();
        try{
            $profile = EstimatorProfile::findOrFail($id);
            foreach($profile->estimatorProfileDetails as $pd){
                $pd->delete();
            }
            $profile->delete();

            DB::commit();
            if($route == "/estimator"){
                return redirect()->route('estimator.indexEstimatorProfile')->with('success','Success Deleted Estimator Profile!');
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.indexEstimatorProfile')->with('success','Success Deleted Estimator Profile!');
            }
        }catch (\Exception $e) {
            DB::rollback();
            if($route == "/estimator"){
                return redirect()->route('estimator.indexEstimatorProfile')->with('error',$e->getMessage());
            }elseif($route == "/estimator_repair"){
                return redirect()->route('estimator_repair.indexEstimatorProfile')->with('error',$e->getMessage());
            }
        }
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

    public function generateProfileCode(){
        $code = 'EPF';
        $modelProfile = EstimatorProfile::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelProfile)){
            $number += intval(substr($modelProfile->code, -4));
		}

        $profile_code = $code.''.sprintf('%04d', $number);
		return $profile_code;
    }
}
