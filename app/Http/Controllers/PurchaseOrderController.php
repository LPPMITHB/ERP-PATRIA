<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Vendor;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Branch;
use App\Models\Project;
use App\Models\Resource;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use Auth;
use DB;

class PurchaseOrderController extends Controller
{
    public function selectPR()
    {
        $modelPRs = PurchaseRequisition::whereIn('status',[1,7])->get();
        
        return view('purchase_order.selectPR', compact('modelPRs'));
    }
    
    public function index()
    {
        $modelPOs = PurchaseOrder::all();

        return view('purchase_order.index', compact('modelPOs'));
    
    }

    public function indexApprove()
    {
        $modelPOs = PurchaseOrder::where('status',1)->get();

        return view('purchase_order.indexApprove', compact('modelPOs'));
    
    }

    public function create(Request $request)
    {
        $datas = json_decode($request->datas);

        $modelPR = PurchaseRequisition::where('id',$datas->id)->with('project')->first();
        $modelPRD = PurchaseRequisitionDetail::whereIn('id',$datas->checkedPRD)->with('material','work')->get();
        foreach($modelPRD as $key=>$PRD){
            if($PRD->reserved >= $PRD->quantity){
                $modelPRD->forget($key);
            }
        }
        $modelProject = Project::findOrFail($modelPR->project_id)->with('ship','customer')->first();

        return view('purchase_order.create', compact('modelPR','modelPRD','modelProject'));
    }

    public function selectPRD($id)
    {
        $modelPR = PurchaseRequisition::findOrFail($id);
        $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id',$modelPR->id)->with('material','work')->get();
        foreach($modelPRD as $key=>$PRD){
            if($PRD->reserved >= $PRD->quantity){
                $modelPRD->forget($key);
            }
        }
        $modelPRD = $modelPRD->values();
        $modelPRD->all();
        return view('purchase_order.selectPRD', compact('modelPR','modelPRD'));
    }

    public function storeResource(Request $request){
        $datas = json_decode($request->datas);
        $po_number = $this->generatePONumber();

        DB::beginTransaction();
        try {
            $PO = new PurchaseOrder;
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
                $POD = new PurchaseOrderDetail;
                $POD->purchase_order_id = $PO->id;
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
            return redirect()->route('purchase_order.showResource',$PO->id)->with('success', 'Purchase Order Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('purchase_order.createPOResource')->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $datas = json_decode($request->datas);
        $po_number = $this->generatePONumber();

        DB::beginTransaction();
        try {
            $PO = new PurchaseOrder;
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
                $POD = new PurchaseOrderDetail;
                $POD->purchase_order_id = $PO->id;
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
            return redirect()->route('purchase_order.show',$PO->id)->with('success', 'Purchase Order Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('purchase_order.selectPRD',$datas->pr_id)->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $modelPO = PurchaseOrder::findOrFail($id);

        return view('purchase_order.show', compact('modelPO'));
    }

    public function showApprove($id)
    {
        $modelPO = PurchaseOrder::findOrFail($id);

        return view('purchase_order.showApprove', compact('modelPO'));
    }

    public function showResource($id)
    {
        $modelPO = PurchaseOrder::findOrFail($id);

        return view('purchase_order.showResource', compact('modelPO'));
    }

    public function edit($id)
    {
        $modelPO = PurchaseOrder::where('id',$id)->with('purchaseRequisition')->first();
        $modelPOD = PurchaseOrderDetail::where('purchase_order_id',$id)->with('material','purchaseRequisitionDetail','work')->get();
        $modelProject = Project::findOrFail($modelPO->purchaseRequisition->project_id)->with('ship','customer')->first();

        return view('purchase_order.edit', compact('modelPO','modelPOD','modelProject'));
    }

    public function createPOResource(){
        $modelProject = Project::where('status',1)->get();
        $modelVendor = Vendor::where('status',1)->get();
        $modelResource = Resource::all();

        return view('purchase_order.createPOResource', compact('modelResource','modelProject','modelVendor'));
    }

    public function update(Request $request)
    {
        $datas = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $PO = PurchaseOrder::findOrFail($datas->modelPO->id);
            
            $status = 0;
            $total_price = 0;
            foreach($datas->PODetail as $data){
                $POD = PurchaseOrderDetail::findOrFail($data->id);
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
            $PO->save();

            $this->checkStatusPr($datas->modelPO->purchase_requisition_id,$status);
            DB::commit();
            return redirect()->route('purchase_order.show',$PO->id)->with('success', 'Purchase Order Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('purchase_order.index')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        //
    }

    // function
    public function generatePONumber(){
        $modelPO = PurchaseOrder::orderBy('created_at','desc')->where('branch_id',Auth::user()->branch_id)->first();
        $modelBranch = Branch::where('id', Auth::user()->branch_id)->first();

        $branch_code = substr($modelBranch->code,4,2);
        $number = 1;
        if(isset($modelPO)){
            $number += intval(substr($modelPO->number, -6));
        }
        $year = date('y'.$branch_code.'000000');
        $year = intval($year);

        $po_number = $year+$number;
        $po_number = 'PO-'.$po_number;
        return $po_number;
    }
    
    public function updatePR($prd_id,$quantity){
        $modelPRD = PurchaseRequisitionDetail::findOrFail($prd_id);

        if($modelPRD){
            $modelPRD->reserved += $quantity;
            $modelPRD->save();
        }
        if($modelPRD->reserved < $modelPRD->quantity){
            return true;
        }
    }

    public function checkStatusPr($pr_id,$status){
        $modelPR = PurchaseRequisition::findOrFail($pr_id);
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
