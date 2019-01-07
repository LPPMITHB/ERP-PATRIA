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
        $modelWRs = WorkRequest::where('status',2)->get();
        
        return view('work_order.selectWR', compact('modelWRs'));
    }
    
    public function index()
    {
        $modelPOs = WorkOrder::all();

        return view('work_order.index', compact('modelPOs'));
    
    }

    public function indexApprove()
    {
        $modelPOs = WorkOrder::whereIn('status',[1,4])->get();

        return view('work_order.indexApprove', compact('modelPOs'));
    
    }

    public function create(Request $request)
    {
        $datas = json_decode($request->datas);
        $modelPR = WorkRequest::where('id',$datas->id)->with('project')->first();
        $modelPRD = WorkRequestDetail::whereIn('id',$datas->checkedPRD)->with('material','wbs')->get();
        foreach($modelPRD as $key=>$PRD){
            if($PRD->reserved >= $PRD->quantity){
                $modelPRD->forget($key);
            }
        }
        $modelProject = Project::where('id',$modelPR->project_id)->with('ship','customer')->first();

        return view('work_order.create', compact('modelPR','modelPRD','modelProject'));
    }

    public function selectWRD($id)
    {
        $modelWR = WorkRequest::findOrFail($id);
        $modelWRD = WorkRequestDetail::where('work_request_id',$modelWR->id)->with('material','wbs')->get();
        foreach($modelWRD as $key=>$PRD){
            if($PRD->received == $PRD->quantity){
                $modelWRD->forget($key);
            }
        }
        $modelWRD = $modelWRD->values();
        $modelWRD->all();
        return view('work_order.selectWRD', compact('modelWR','modelWRD'));
    }

    public function storeResource(Request $request){
        $datas = json_decode($request->datas);
        $po_number = $this->generatePONumber();

        DB::beginTransaction();
        try {
            $PO = new WorkOrder;
            $PO->number = $po_number;
            $PO->vendor_id = $datas->vendor_id;
            $PO->project_id = $datas->project_id;
            $PO->description = $datas->description;
            $PO->status = 1;
            $PO->user_id = Auth::user()->id;
            $PO->branch_id = Auth::user()->branch->id;
            $PO->save();

            $total_price = 0;
            foreach($datas->resources as $data){
                $POD = new WorkOrderDetail;
                $POD->work_order_id = $PO->id;
                $POD->quantity = $data->quantity;
                $POD->resource_id = $data->resource_id;
                $POD->wbs_id = $data->wbs_id;
                $POD->total_price = $data->cost;
                $POD->save();

                $total_price += $POD->total_price;
            }

            $PO->total_price = $total_price;
            $PO->save(); 
            DB::commit();
            return redirect()->route('work_order.showResource',$PO->id)->with('success', 'Purchase Order Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('work_order.createPOResource')->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $datas = json_decode($request->datas);
        $po_number = $this->generatePONumber();

        DB::beginTransaction();
        try {
            $PO = new WorkOrder;
            $PO->number = $po_number;
            $PO->purchase_requisition_id = $datas->pr_id;
            $PO->vendor_id = $datas->vendor_id;
            $PO->project_id = $datas->project_id;
            $PO->description = $datas->description;
            $PO->status = 1;
            $PO->user_id = Auth::user()->id;
            $PO->branch_id = Auth::user()->branch->id;
            $PO->save();

            $status = 0;
            $total_price = 0;
            foreach($datas->PRD as $data){
                $POD = new WorkOrderDetail;
                $POD->work_order_id = $PO->id;
                $POD->quantity = $data->quantity;
                $POD->material_id = $data->material_id;
                $POD->purchase_requisition_detail_id = $data->id;
                $POD->wbs_id = $data->wbs_id;
                $POD->total_price = $data->material->cost_standard_price * $data->quantity;
                $POD->save();

                $statusPR = $this->updatePR($data->id,$data->quantity);
                if($statusPR === true){
                    $status = 1;
                }
                $total_price += $POD->total_price;
            }

            $PO->total_price = $total_price;
            $PO->save(); 
            $this->checkStatusPr($datas->pr_id,$status);
            DB::commit();
            return redirect()->route('work_order.show',$PO->id)->with('success', 'Purchase Order Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('work_order.selectWRD',$datas->pr_id)->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $modelPO = WorkOrder::findOrFail($id);

        return view('work_order.show', compact('modelPO'));
    }

    public function showApprove($id)
    {
        $modelPO = WorkOrder::findOrFail($id);

        return view('work_order.showApprove', compact('modelPO'));
    }

    public function showResource($id)
    {
        $modelPO = WorkOrder::findOrFail($id);

        return view('work_order.showResource', compact('modelPO'));
    }

    public function edit($id)
    {
        $modelPO = WorkOrder::where('id',$id)->with('purchaseRequisition')->first();
        $modelPOD = WorkOrderDetail::where('work_order_id',$id)->with('material','purchaseRequisitionDetail','wbs')->get();
        $modelProject = Project::where('id',$modelPO->purchaseRequisition->project_id)->with('ship','customer')->first();

        return view('work_order.edit', compact('modelPO','modelPOD','modelProject'));
    }

    public function createPOResource(){
        $modelProject = Project::where('status',1)->get();
        $modelVendor = Vendor::where('status',1)->get();
        $modelResource = Resource::all();

        return view('work_order.createPOResource', compact('modelResource','modelProject','modelVendor'));
    }

    public function update(Request $request)
    {
        $datas = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $PO = WorkOrder::findOrFail($datas->modelPO->id);
            
            $status = 0;
            $total_price = 0;
            foreach($datas->PODetail as $data){
                $POD = WorkOrderDetail::findOrFail($data->id);
                $diff = $data->quantity - $POD->quantity;
                $POD->quantity = $data->quantity;
                $POD->total_price = $data->quantity * $data->total_price;
                $POD->save();

                $statusPR = $this->updatePR($data->purchase_requisition_detail_id,$diff);
                if($statusPR === true){
                    $status = 1;
                }
                $total_price += $POD->total_price;
            }
            $PO->vendor_id = $datas->modelPO->vendor_id;
            $PO->description = $datas->modelPO->description;
            $PO->total_price = $total_price;
            if($PO->status == 3){
                $PO->status = 4;
            }
            $PO->save();

            $this->checkStatusPr($datas->modelPO->purchase_requisition_id,$status);
            DB::commit();
            return redirect()->route('work_order.show',$PO->id)->with('success', 'Purchase Order Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('work_order.index')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        //
    }

    public function approval($po_id,$status)
    {
        DB::beginTransaction();
        try{
            $modelPO = WorkOrder::findOrFail($po_id);
            if($status == "approve"){
                $modelPO->status = 2;
                $modelPO->update();
                DB::commit();
                return redirect()->route('work_order.showApprove',$po_id)->with('success', 'Purchase Order Approved');
            }elseif($status == "need-revision"){
                $modelPO->status = 3;
                $modelPO->update();
                DB::commit();
                return redirect()->route('work_order.showApprove',$po_id)->with('success', 'Purchase Order Need Revision');
            }elseif($status == "reject"){
                $modelPO->status = 5;
                $modelPO->update();
                DB::commit();
                return redirect()->route('work_order.showApprove',$po_id)->with('success', 'Purchase Order Rejected');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('work_order.show',$po_id);
        }
    }

    // function
    public function generatePONumber(){
        $modelPO = WorkOrder::orderBy('created_at','desc')->first();
        $yearNow = date('y');

        $number = 1;
        if(isset($modelPO)){
            $yearDoc = substr($modelPO->number, 3,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelPO->number, -5));
            }
        }

        $year = date($yearNow.'00000');
        $year = intval($year);

        $po_number = $year+$number;
        $po_number = 'PO-'.$po_number;
        
        return $po_number;
    }
    
    public function updatePR($prd_id,$quantity){
        $modelPRD = WorkRequestDetail::findOrFail($prd_id);

        if($modelPRD){
            $modelPRD->reserved += $quantity;
            $modelPRD->save();
        }
        if($modelPRD->reserved < $modelPRD->quantity){
            return true;
        }
    }

    public function checkStatusPr($pr_id,$status){
        $modelPR = WorkRequest::findOrFail($pr_id);
        if($status == 0){
            $modelPR->status = 0;
        }else{
            $modelPR->status = 7;
        }
        $modelPR->save();
    }

    public function getVendorAPI(){
        $vendor = Vendor::where('status',1)->select('id','name','code')->get()->jsonSerialize();

        return response($vendor, Response::HTTP_OK);
    }

    public function getResourceAPI($id){
        $resource = Resource::where('id',$id)->with('uom')->first()->jsonSerialize();

        return response($resource, Response::HTTP_OK);
    }
}
