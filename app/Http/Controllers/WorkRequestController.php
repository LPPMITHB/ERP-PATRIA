<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\WorkRequest;
use App\Models\WorkRequestDetail;
use App\Models\Branch;
use App\Models\Material;
use App\Models\Stock;
use App\Models\WBS;
use App\Models\Bom;
use App\Models\BomDetail;
use App\Models\Project;
use Auth;
use DB;

class WorkRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/work_request" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->pluck('id')->toArray();
        }elseif($menu == "building"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->pluck('id')->toArray();
        }    
        $modelWRs = WorkRequest::whereIn('project_id',$modelProject)->get();;

        return view('work_request.index', compact('modelWRs','menu'));
    }

    public function indexApprove(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/work_request" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->pluck('id')->toArray();
        }elseif($menu == "building"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->pluck('id')->toArray();
        }    
        $modelWRs = WorkRequest::whereIn('status',[1,4])->whereIn('project_id',$modelProject)->get();

        return view('work_request.indexApprove', compact('modelWRs', 'menu'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/work_request" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = Project::where('status',1)->where('business_unit_id',2)->get();
        }elseif($menu == "building"){
            $modelProject = Project::where('status',1)->where('business_unit_id',1)->get();
        }

        return view('work_request.create', compact('modelProject', 'menu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/work_request" ? "building" : "repair";    
        $datas = json_decode($request->datas);

        $wr_number = $this->generateWRNumber();
        $current_date = today();
        $valid_to = $current_date->addDays(7);
        $valid_to = $valid_to->toDateString();

        DB::beginTransaction();
        try {

            $WR = new WorkRequest;
            $WR->number = $wr_number;
            $WR->valid_date = $valid_to;
            $WR->description = $datas->description;
            if($datas->project_id != null){
                $WR->project_id = $datas->project_id;
            }
            $WR->status = 1;
            $WR->user_id = Auth::user()->id;
            $WR->branch_id = Auth::user()->branch->id;
            $WR->save();


            foreach($datas->materials as $data){
                $modelWRDs = WorkRequestDetail::where('work_request_id',$WR->id)->get();
                if(count($modelWRDs)>0){
                    $status = 0;
                    foreach($modelWRDs as $WRD){
                        if($WRD->material_id == $data->material_id && $WRD->wbs_id == $data->wbs_id){
                            $updatedQty = $WRD->quantity + $data->quantityInt;
                            // $this->updateReserveStock($data->material_id, $WRD->quantity ,$updatedQty);
                            $WRD->quantity = $updatedQty;
                            $WRD->update();

                            $status = 1;
                        }
                    }
                    if($status == 0){
                        $WRD = new WorkRequestDetail;
                        $WRD->work_request_id = $WR->id;
                        $WRD->quantity = $data->quantityInt;
                        $WRD->description = $data->description;
                        $WRD->material_id = $data->material_id;
                        $WRD->wbs_id = $data->wbs_id;
                        $WRD->save();

                        // $this->reserveStock($data->material_id, $data->quantityInt);
                    }
                }else{
                    $WRD = new WorkRequestDetail;
                    $WRD->work_request_id = $WR->id;
                    $WRD->quantity = $data->quantityInt;
                    $WRD->description = $data->description;
                    $WRD->material_id = $data->material_id;
                    $WRD->wbs_id = $data->wbs_id;
                    $WRD->save();

                    // $this->reserveStock($data->material_id, $data->quantityInt);
                }
            }
            
            DB::commit();
            if($menu == "building"){
                return redirect()->route('work_request.show',$WR->id)->with('success', 'Work Request Created');
            }elseif($menu == "repair"){
                return redirect()->route('work_request_repair.show',$WR->id)->with('success', 'Work Request Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('work_request.create')->with('error', $e->getMessage());
            }elseif($menu == "repair"){
                return redirect()->route('work_request_repair.create')->with('error', $e->getMessage());
            }
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
        $modelWR = WorkRequest::findOrFail($id);

        return view('work_request.show', compact('modelWR'));
    }

    public function showApprove($id, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/work_request" ? "building" : "repair";  

        $modelWR = WorkRequest::findOrFail($id);

        return view('work_request.showApprove', compact('modelWR','menu'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/material_requisition" ? "building" : "repair";    
        if($menu == "repair"){
            $modelProject = $modelWR->project->with('ship','customer','wbss')->where('business_unit_id',2)->first()->jsonSerialize();
        }elseif($menu == "building"){
            $modelProject = $modelWR->project->with('ship','customer','wbss')->where('business_unit_id',1)->first()->jsonSerialize();
        }    
        $modelWR = WorkRequest::findOrFail($id);
        $project = Project::where('id',$modelWR->project_id)->with('customer','ship')->first();
        $modelWRD = WorkRequestDetail::where('work_request_id',$modelWR->id)->with('material','wbs')->get();
        foreach($modelWRD as $wrd){
            $material = Stock::where('material_id',$wrd->material_id)->first();
            $wrd['available'] = $material->quantity-$material->reserved;
        }
        $modelWRD->jsonSerialize();
        $wbss = [];
        $wbss = WBS::where('project_id',$modelWR->project_id)->get()->jsonSerialize();
        return view('work_request.edit', compact('modelWR','project','modelWRD','wbss','menu'));
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
        $menu = $request->route()->getPrefix() == "/work_request" ? "building" : "repair";    
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            $wrd_id = [];
            $WR = WorkRequest::find($id);
            $WR->description = $datas->description;
            if($WR->status == 3){
                $WR->status = 4;
            }
            $WR->update();
            
            foreach($datas->materials as $data){
                if($data->wrd_id != null){
                    $WRD = WorkRequestDetail::find($data->wrd_id);
                    // $this->updateReserveStock($data->material_id, $WRD->quantity ,$data->quantityInt);
                    
                    $WRD->quantity = $data->quantityInt;
                    $WRD->description = $data->description;
                    $WRD->material_id = $data->material_id;
                    $WRD->wbs_id = $data->wbs_id;
                    $WRD->update();
                }else{
                    $modelWRDs = WorkRequestDetail::where('work_request_id',$WR->id)->get();
                    if(count($modelWRDs)>0){
                        $status = 0;
                        foreach($modelWRDs as $WRD){
                            if($WRD->material_id == $data->material_id && $WRD->wbs_id == $data->wbs_id){
                                $updatedQty = $WRD->quantity + $data->quantityInt;
                                // $this->updateReserveStock($data->material_id, $WRD->quantity ,$updatedQty);
                                $WRD->quantity = $updatedQty;
                                $WRD->update();
    
                                $status = 1;
                            }
                        }
                        if($status == 0){
                            $WRD = new WorkRequestDetail;
                            $WRD->work_request_id = $WR->id;
                            $WRD->quantity = $data->quantityInt;
                            $WRD->description = $data->description;
                            $WRD->material_id = $data->material_id;
                            $WRD->wbs_id = $data->wbs_id;
                            $WRD->save();
    
                            // $this->reserveStock($data->material_id, $data->quantityInt);
                        }
                    }else{
                        $WRD = new WorkRequestDetail;
                        $WRD->work_request_id = $WR->id;
                        $WRD->quantity = $data->quantityInt;
                        $WRD->description = $data->description;
                        $WRD->material_id = $data->material_id;
                        $WRD->wbs_id = $data->wbs_id;
                        $WRD->save();
    
                        // $this->reserveStock($data->material_id, $data->quantityInt);
                    }
                }


            }

            DB::commit();
            if($menu == "building"){
                return redirect()->route('work_request.show',$WR->id)->with('success', 'Work Request Updated');
            }elseif($menu == "repair"){
                return redirect()->route('work_request_repair.show',$WR->id)->with('success', 'Work Request Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('work_request.create')->with('error', $e->getMessage());
            }elseif($menu == "repair"){
                return redirect()->route('work_request_repair.create')->with('error', $e->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function reserveStock($material_id,$quantity){
        $modelStock = Stock::where('material_id',$material_id)->first();
        if($modelStock){
            $modelStock->reserved = $modelStock->reserved + $quantity;
            $modelStock->save();
        }
    }

    public function updateReserveStock($material_id,$oldQty, $newQty){
        $difference = $newQty - $oldQty;
        $modelStock = Stock::where('material_id',$material_id)->first();
        if($modelStock){
            $modelStock->reserved = $modelStock->reserved + $difference;
            $modelStock->save();
        }
    }

    public function destroy($id){
        $prd_id = json_decode($id);

        DB::beginTransaction();
        try {
            foreach($prd_id as $id){
                $modelPRD = PurchaseRequisitionDetail::findOrFail($id);
                $modelPRD->delete();
            }
            DB::commit();
            return true;
        } catch(\Illuminate\Database\QueryException $e){
            DB::rollback();
            return redirect()->route('purchase_requisition.create')->with('error', 'Can\'t Delete The Material Because It Is Still Being Used');
        }  
    }
    public function approval($wr_id,$status, Request $request)
    {
        $menu = $request->route()->getPrefix() == "/work_request" ? "building" : "repair";    
        DB::beginTransaction();
        try{
            $modelWR = WorkRequest::findOrFail($wr_id);
            if($status == "approve"){
                $modelWR->status = 2;
                $modelWR->update();
                DB::commit();
                if($menu == "building"){
                    return redirect()->route('work_request.showApprove',$wr_id)->with('success', 'Work Request Approved');
                }elseif($menu == "repair"){
                    return redirect()->route('work_request_repair.showApprove',$wr_id)->with('success', 'Work Request Approved');
                }
            }elseif($status == "need-revision"){
                $modelWR->status = 3;
                $modelWR->update();
                DB::commit();
                if($menu == "building"){
                    return redirect()->route('work_request.showApprove',$wr_id)->with('success', 'Work Request Need Revision');
                }elseif($menu == "repair"){
                    return redirect()->route('work_request_repair.showApprove',$wr_id)->with('success', 'Work Request Need Revision');
                }
            }elseif($status == "reject"){
                $modelWR->status = 5;
                $modelWR->update();
                DB::commit();
                if($menu == "building"){
                    return redirect()->route('work_request.showApprove',$wr_id)->with('success', 'Work Request Rejected');
                }elseif($menu == "repair"){
                    return redirect()->route('work_request_repair.showApprove',$wr_id)->with('success', 'Work Request Rejected');
                }
            }
        } catch (\Exception $e){
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('work_request.show',$wr_id);
            }elseif($menu == "repair"){
                return redirect()->route('work_request_repair.show',$wr_id);
            }
        }

        
    }

    // function
    public function generateWRNumber(){
        $modelWR = WorkRequest::orderBy('created_at','desc')->first();
        $yearNow = date('y');
        
		$number = 1;
        if(isset($modelWR)){
            $yearDoc = substr($modelWR->number, 3,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelWR->number, -5));
            }
        }

        $year = date($yearNow.'00000');
        $year = intval($year);

		$wr_number = $year+$number;
        $wr_number = 'WR-'.$wr_number;

		return $wr_number;
    }

    public function getWbsEditAPI($id, $wr_id){
        $data = array();
        $wrds = WorkRequest::find($wr_id)->workRequestDetails;
        $exisiting_material = $wrds->where('wbs_id',$id)->pluck('material_id')->toArray();

        $wbs = WBS::findOrFail($id);
        if($wbs->bom != null){
            $material_ids = $wbs->bom->bomDetails->pluck('material_id')->toArray();
            $data['materials'] = Material::whereIn('id',$material_ids)->whereNotIn('id', $exisiting_material)->get();
        }else{
            $data['materials'] = [];
        }

        $data['wbs'] = $wbs->jsonSerialize();

        return response($data, Response::HTTP_OK);
    }

    public function getQuantityReservedApi($id){
        $materials = Stock::where('material_id',$id)->first();
        
        return response($materials, Response::HTTP_OK);
    }

    public function getProjectApi($id){
        $project = Project::where('id',$id)->with('ship','customer','wbss')->first()->jsonSerialize();

        return response($project, Response::HTTP_OK);
    }

    public function getMaterialWrAPI($id){
        
        return response(Material::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getWbsWrAPI($id){
        $wbs = WBS::findOrFail($id)->jsonSerialize();

        return response($wbs, Response::HTTP_OK);
    }

    public function getBomWrAPI($id){
        $bom = Bom::where('wbs_id',$id)->first()->jsonSerialize();

        return response($bom, Response::HTTP_OK);
    }

    public function getBomDetailWrAPI($id){
        $bomDetail = BomDetail::where('bom_id',$id)->with('material')->get()->jsonSerialize();

        return response($bomDetail, Response::HTTP_OK);
    }

    public function getMaterialsAPI($ids){
        $ids = json_decode($ids);

        return response(Material::whereNotIn('id',$ids)->get()->jsonSerialize(), Response::HTTP_OK);
    }

}
