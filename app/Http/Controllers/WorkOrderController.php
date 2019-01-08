<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Vendor;
use App\Models\WorkOrder;
use App\Models\WorkOrderDetail;
use App\Models\Branch;
use App\Models\Project;
use App\Models\Resource;
use App\Models\WorkRequest;
use App\Models\WorkRequestDetail;
use Auth;
use DB;

class WorkOrderController extends Controller
{
    public function selectWR()
    {
        $modelWRs = WorkRequest::whereIn('status',[2,7])->get();
        
        return view('work_order.selectWR', compact('modelWRs'));
    }
    
    public function index()
    {
        $modelWOs = WorkOrder::all();

        return view('work_order.index', compact('modelWOs'));
    
    }

    public function indexApprove()
    {
        $modelWOs = WorkOrder::whereIn('status',[1,4])->get();

        return view('work_order.indexApprove', compact('modelWOs'));
    
    }

    public function create(Request $request)
    {
        $datas = json_decode($request->datas);
        $modelWR = WorkRequest::where('id',$datas->id)->with('project')->first();
        $modelWRD = WorkRequestDetail::whereIn('id',$datas->checkedWRD)->with('material','wbs')->get();
        foreach($modelWRD as $key=>$WRD){
            if($WRD->reserved >= $WRD->quantity){
                $modelWRD->forget($key);
            }
        }
        $modelProject = Project::where('id',$modelWR->project_id)->with('ship','customer')->first();

        return view('work_order.create', compact('modelWR','modelWRD','modelProject'));
    }

    public function selectWRD($id)
    {
        $modelWR = WorkRequest::findOrFail($id);
        $modelWRD = WorkRequestDetail::where('work_request_id',$modelWR->id)->with('material','wbs')->get();
        foreach($modelWRD as $key=>$WRD){
            if($WRD->received == $WRD->quantity){
                $modelWRD->forget($key);
            }
        }
        $modelWRD = $modelWRD->values();
        $modelWRD->all();
        return view('work_order.selectWRD', compact('modelWR','modelWRD'));
    }


    public function store(Request $request)
    {
        $datas = json_decode($request->datas);
        $wo_number = $this->generateWONumber();

        DB::beginTransaction();
        try {
            $WO = new WorkOrder;
            $WO->number = $wo_number;
            $WO->work_request_id = $datas->wr_id;
            $WO->vendor_id = $datas->vendor_id;
            $WO->project_id = $datas->project_id;
            $WO->description = $datas->description;
            $WO->status = 1;
            $WO->user_id = Auth::user()->id;
            $WO->branch_id = Auth::user()->branch->id;
            $WO->save();

            $status = 0;
            $total_price = 0;
            foreach($datas->WRD as $data){
                $WOD = new WorkOrderDetail;
                $WOD->work_order_id = $WO->id;
                $WOD->quantity = $data->quantity;
                $WOD->material_id = $data->material_id;
                $WOD->work_request_detail_id = $data->id;
                $WOD->wbs_id = $data->wbs_id;
                $WOD->total_price = $data->material->cost_standard_price * $data->quantity;
                $WOD->save();

                $statusPR = $this->updateWR($data->id,$data->quantity);
                if($statusPR === true){
                    $status = 1;
                }
                $total_price += $WOD->total_price;
            }

            $WO->total_price = $total_price;
            $WO->save(); 
            $this->checkStatusWr($datas->wr_id,$status);
            DB::commit();
            return redirect()->route('work_order.show',$WO->id)->with('success', 'Work Order Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('work_order.selectWRD',$datas->wr_id)->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $modelWO = WorkOrder::findOrFail($id);

        return view('work_order.show', compact('modelWO'));
    }

    public function showApprove($id)
    {
        $modelWO = WorkOrder::findOrFail($id);

        return view('work_order.showApprove', compact('modelWO'));
    }

    public function edit($id)
    {
        $modelWO = WorkOrder::where('id',$id)->with('workRequest')->first();
        $modelWOD = WorkOrderDetail::where('work_order_id',$id)->with('material','workRequestDetail','wbs')->get();
        $modelProject = Project::where('id',$modelWO->workRequest->project_id)->with('ship','customer')->first();

        return view('work_order.edit', compact('modelWO','modelWOD','modelProject'));
    }

    public function update(Request $request)
    {
        $datas = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $WO = WorkOrder::findOrFail($datas->modelWO->id);
            
            $status = 0;
            $total_price = 0;
            foreach($datas->WODetail as $data){
                $WOD = WorkOrderDetail::findOrFail($data->id);
                $diff = $data->quantity - $WOD->quantity;
                $WOD->quantity = $data->quantity;
                $WOD->total_price = $data->quantity * $data->total_price;
                $WOD->save();

                $statusPR = $this->updateWR($data->work_request_detail_id,$diff);
                if($statusPR === true){
                    $status = 1;
                }
                $total_price += $WOD->total_price;
            }
            $WO->vendor_id = $datas->modelWO->vendor_id;
            $WO->description = $datas->modelWO->description;
            $WO->total_price = $total_price;
            if($WO->status == 3){
                $WO->status = 4;
            }
            $WO->save();

            $this->checkStatusWr($datas->modelWO->work_request_id,$status);
            DB::commit();
            return redirect()->route('work_order.show',$WO->id)->with('success', 'Work Order Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('work_order.index')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        //
    }

    public function approval($wo_id,$status)
    {
        DB::beginTransaction();
        try{
            $modelWO = WorkOrder::findOrFail($wo_id);
            if($status == "approve"){
                $modelWO->status = 2;
                $modelWO->update();
                DB::commit();
                return redirect()->route('work_order.showApprove',$wo_id)->with('success', 'Work Order Approved');
            }elseif($status == "need-revision"){
                $modelWO->status = 3;
                $modelWO->update();
                DB::commit();
                return redirect()->route('work_order.showApprove',$wo_id)->with('success', 'Work Order Updated');
            }elseif($status == "reject"){
                $modelWO->status = 5;
                $modelWO->update();
                DB::commit();
                return redirect()->route('work_order.showApprove',$wo_id)->with('success', 'Work Order Rejected');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('work_order.show',$wo_id);
        }
    }

    // function
    public function generateWONumber(){
        $modelWO = WorkOrder::orderBy('created_at','desc')->first();
        $yearNow = date('y');

        $number = 1;
        if(isset($modelWO)){
            $yearDoc = substr($modelWO->number, 3,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelWO->number, -5));
            }
        }

        $year = date($yearNow.'00000');
        $year = intval($year);

        $wo_number = $year+$number;
        $wo_number = 'WO-'.$wo_number;
        
        return $wo_number;
    }
    
    public function updateWR($prd_id,$quantity){
        $modelWRD = WorkRequestDetail::findOrFail($prd_id);

        if($modelWRD){
            $modelWRD->reserved += $quantity;
            $modelWRD->save();
        }
        if($modelWRD->reserved < $modelWRD->quantity){
            return true;
        }
    }

    public function checkStatusWr($wr_id,$status){
        $modelWR = WorkRequest::findOrFail($wr_id);
        if($status == 0){
            $modelWR->status = 0;
        }else{
            $modelWR->status = 7;
        }
        $modelWR->save();
    }

    public function getVendorAPI(){
        $vendor = Vendor::where('status',1)->select('id','name','code')->get()->jsonSerialize();

        return response($vendor, Response::HTTP_OK);
    }
}
