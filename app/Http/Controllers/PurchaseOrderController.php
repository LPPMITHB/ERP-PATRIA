<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Models\Vendor;
use App\Models\Configuration;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Branch;
use App\Models\Project;
use App\Models\Resource;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use DateTime;
use Auth;
use DB;

class PurchaseOrderController extends Controller
{
    public function selectPR(Request $request)
    {
        $route = $request->route()->getPrefix();
        // print_r($route);exit();
        if($route == "/purchase_order"){
            $business_unit_id = 1;
        }elseif($route == "/purchase_order_repair"){
            $business_unit_id = 2;
        }

        $modelPRs = PurchaseRequisition::whereIn('status',[2,7])->where('business_unit_id',$business_unit_id)->get();
        
        return view('purchase_order.selectPR', compact('modelPRs','route'));
    }
    
    public function index(Request $request)
    {
        $route = $request->route()->getPrefix();
        if($route == "/purchase_order"){
            $modelPRs = PurchaseRequisition::where('business_unit_id',1)->get();
        }elseif($route == "/purchase_order_repair"){
            $modelPRs = PurchaseRequisition::where('business_unit_id',2)->get();
        }
        $modelPOs = PurchaseOrder::whereIn('purchase_requisition_id',$modelPRs)->get();

        return view('purchase_order.index', compact('modelPOs','route'));
    
    }

    public function indexApprove(Request $request)
    {
        $route = $request->route()->getPrefix();
        if($route == "/purchase_order"){
            $modelPRs = PurchaseRequisition::where('business_unit_id',1)->get();
        }elseif($route == "/purchase_order_repair"){
            $modelPRs = PurchaseRequisition::where('business_unit_id',2)->get();
        }
        $modelPOs = PurchaseOrder::whereIn('status',[1,4])->whereIn('purchase_requisition_id',$modelPRs)->get();

        return view('purchase_order.indexApprove', compact('modelPOs','route'));
    
    }

    public function create(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $currencies = Configuration::get('currencies');
        $modelPR = PurchaseRequisition::where('id',$datas->id)->with('project')->first();
        $modelPRD = PurchaseRequisitionDetail::whereIn('id',$datas->checkedPRD)->with('material','wbs','resource')->get();
        foreach($modelPRD as $key=>$PRD){
            if($PRD->reserved >= $PRD->quantity){
                $modelPRD->forget($key);
            }
        }
        if($modelPR->project_id){
            $modelProject = Project::where('id',$modelPR->project_id)->with('ship','customer')->first();
        }else{
            $modelProject = [];
        }
        return view('purchase_order.create', compact('modelPR','modelPRD','modelProject','currencies','route'));
    }

    public function selectPRD(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPR = PurchaseRequisition::findOrFail($id);
        $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id',$modelPR->id)->with('material','wbs','resource')->get();
        foreach($modelPRD as $key=>$PRD){
            if($PRD->reserved >= $PRD->quantity){
                $modelPRD->forget($key);
            }
        }
        $modelPRD = $modelPRD->values();
        $modelPRD->all();
        return view('purchase_order.selectPRD', compact('modelPR','modelPRD','route'));
    }

    public function store(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $po_number = $this->generatePONumber();
        $value = "";
        $valueCurrency = Configuration::get('currencies');
        foreach ($valueCurrency as $data) {
            if($data->name == $datas->currency){
                $value = $data->value;
            }
        }


        DB::beginTransaction();
        try {
            $PO = new PurchaseOrder;
            $PO->number = $po_number;
            $PO->purchase_requisition_id = $datas->pr_id;
            $PO->vendor_id = $datas->vendor_id;
            $PO->currency = $datas->currency;
            $PO->value = $value;
            $required_date = DateTime::createFromFormat('m/j/Y', $datas->required_date);
            $PO->required_date = $required_date->format('Y-m-d');
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
                if($datas->type == 1){
                    $POD->material_id = $data->material_id;
                    $POD->total_price = $data->material->cost_standard_price * $value * $data->quantity;
                }elseif($datas->type == 2){
                    $POD->resource_id = $data->resource_id;
                    $POD->total_price = $data->resource->cost_standard_price * $value * $data->quantity;
                }
                $POD->purchase_requisition_detail_id = $data->id;
                $POD->wbs_id = $data->wbs_id;
                $POD->save();

                $statusPR = $this->updatePR($data->id,$data->quantity);
                if($statusPR === true){
                    $status = 1;
                }
                $total_price += $POD->total_price;
            }

            $modelPR = PurchaseRequisition::where('id',$datas->pr_id)->with('purchaseRequisitionDetails')->first();
            foreach($modelPR->purchaseRequisitionDetails as $modelPRD){
                if($modelPRD->reserved < $modelPRD->quantity){
                    $status = 1;
                }
            }
            $PO->total_price = $total_price;
            $PO->save(); 
            $this->checkStatusPr($datas->pr_id,$status);
            DB::commit();
            if($route == "/purchase_order"){
                return redirect()->route('purchase_order.show',$PO->id)->with('success', 'Purchase Order Created');
            }elseif($route == "/purchase_order_repair"){
                return redirect()->route('purchase_order_repair.show',$PO->id)->with('success', 'Purchase Order Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/purchase_order"){
                return redirect()->route('purchase_order.selectPRD',$datas->pr_id)->with('error', $e->getMessage());
            }elseif($route == "/purchase_order_repair"){
                return redirect()->route('purchase_order_repair.selectPRD',$datas->pr_id)->with('error', $e->getMessage());
            }
        }
    }

    public function show(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPO = PurchaseOrder::findOrFail($id);
        $datas = Collection::make();
        $unit = "";
        $unitCurrency = Configuration::get('currencies');
        foreach($unitCurrency as $data){
            if($data->name == $modelPO->currency){
                $unit = $data->unit;
            }
        }

        if($modelPO->purchaseRequisition->type == 1){
            foreach($modelPO->purchaseOrderDetails as $POD){
                if(count($datas) > 0){
                    $status = 0;
                    foreach($datas as $data){
                         if($data['material_code'] == $POD->material->code){
                            $quantity = $data['quantity'] + $POD->quantity;
                            $sub_total = $data['sub_total'] + $POD->total_price;

                            $datas->push([
                                "material_code" => $POD->material->code , 
                                "material_name" => $POD->material->name,
                                "quantity" => $quantity,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if($status == 0){
                        $datas->push([
                            "material_code" => $POD->material->code , 
                            "material_name" => $POD->material->name,
                            "quantity" => $POD->quantity,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price
                        ]);
                    }
                }else{
                    $datas->push([
                        "material_code" => $POD->material->code , 
                        "material_name" => $POD->material->name,
                        "quantity" => $POD->quantity,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price
                    ]);
                }
            }
        }elseif($modelPO->purchaseRequisition->type == 2){
            foreach($modelPO->purchaseOrderDetails as $POD){
                if(count($datas) > 0){
                    $status = 0;
                    foreach($datas as $key => $data){
                        if($data['resource_code'] == $POD->resource->code){
                            $quantity = $data['quantity'] + $POD->quantity;
                            $sub_total = $data['sub_total'] + $POD->total_price;

                            $datas->push([
                                "resource_code" => $POD->resource->code , 
                                "resource_name" => $POD->resource->name,
                                "quantity" => $quantity,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if($status == 0){
                        $datas->push([
                            "resource_code" => $POD->resource->code , 
                            "resource_name" => $POD->resource->name,
                            "quantity" => $POD->quantity,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price
                        ]);
                    }
                }else{
                    $datas->push([
                        "resource_code" => $POD->resource->code , 
                        "resource_name" => $POD->resource->name,
                        "quantity" => $POD->quantity,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price
                    ]);

                }
            }
        }
        return view('purchase_order.show', compact('modelPO','unit','route','datas'));
    }

    public function showApprove(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPO = PurchaseOrder::findOrFail($id);
        $datas = Collection::make();
        
        if($modelPO->purchaseRequisition->type == 1){
            foreach($modelPO->purchaseOrderDetails as $POD){
                if(count($datas) > 0){
                    $status = 0;
                    foreach($datas as $data){
                         if($data['material_code'] == $POD->material->code){
                            $quantity = $data['quantity'] + $POD->quantity;
                            $sub_total = $data['sub_total'] + $POD->total_price;

                            $datas->push([
                                "material_code" => $POD->material->code , 
                                "material_name" => $POD->material->name,
                                "quantity" => $quantity,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if($status == 0){
                        $datas->push([
                            "material_code" => $POD->material->code , 
                            "material_name" => $POD->material->name,
                            "quantity" => $POD->quantity,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price
                        ]);
                    }
                }else{
                    $datas->push([
                        "material_code" => $POD->material->code , 
                        "material_name" => $POD->material->name,
                        "quantity" => $POD->quantity,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price
                    ]);
                }
            }
        }elseif($modelPO->purchaseRequisition->type == 2){
            foreach($modelPO->purchaseOrderDetails as $POD){
                if(count($datas) > 0){
                    $status = 0;
                    foreach($datas as $key => $data){
                        if($data['resource_code'] == $POD->resource->code){
                            $quantity = $data['quantity'] + $POD->quantity;
                            $sub_total = $data['sub_total'] + $POD->total_price;

                            $datas->push([
                                "resource_code" => $POD->resource->code , 
                                "resource_name" => $POD->resource->name,
                                "quantity" => $quantity,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if($status == 0){
                        $datas->push([
                            "resource_code" => $POD->resource->code , 
                            "resource_name" => $POD->resource->name,
                            "quantity" => $POD->quantity,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price
                        ]);
                    }
                }else{
                    $datas->push([
                        "resource_code" => $POD->resource->code , 
                        "resource_name" => $POD->resource->name,
                        "quantity" => $POD->quantity,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price
                    ]);

                }
            }
        }
        return view('purchase_order.showApprove', compact('modelPO','route','datas'));
    }

    public function edit(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPO = PurchaseOrder::where('id',$id)->with('purchaseRequisition')->first();
        $modelPOD = PurchaseOrderDetail::where('purchase_order_id',$id)->with('material','purchaseRequisitionDetail','wbs','resource')->get();
        $modelProject = Project::where('id',$modelPO->purchaseRequisition->project_id)->with('ship','customer')->first();

        return view('purchase_order.edit', compact('modelPO','modelPOD','modelProject','route'));
    }

    public function update(Request $request)
    {
        $route = $request->route()->getPrefix();
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
            if($PO->status == 3){
                $PO->status = 4;
            }
            $PO->save();

            $this->checkStatusPr($datas->modelPO->purchase_requisition_id,$status);
            DB::commit();
            if($route == "/purchase_order"){
                return redirect()->route('purchase_order.show',$PO->id)->with('success', 'Purchase Order Updated');
            }elseif($route == "/purchase_order_repair"){
                return redirect()->route('purchase_order_repair.show',$PO->id)->with('success', 'Purchase Order Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/purchase_order"){
                return redirect()->route('purchase_order.index')->with('error', $e->getMessage());
            }elseif($route == "/purchase_order_repair"){
                return redirect()->route('purchase_order_repair.index')->with('error', $e->getMessage());
            }
        }
    }

    public function destroy($id)
    {
        //
    }

    public function approval(Request $request, $po_id, $status)
    {
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try{
            $modelPO = PurchaseOrder::findOrFail($po_id);
            if($status == "approve"){
                $modelPO->status = 2;
                $modelPO->update();
                DB::commit();
                if($route == "/purchase_order"){
                    return redirect()->route('purchase_order.showApprove',$po_id)->with('success', 'Purchase Order Approved');
                }elseif($route == "/purchase_order_repair"){
                    return redirect()->route('purchase_order_repair.showApprove',$po_id)->with('success', 'Purchase Order Approved');
                }
            }elseif($status == "need-revision"){
                $modelPO->status = 3;
                $modelPO->update();
                DB::commit();
                if($route == "/purchase_order"){
                    return redirect()->route('purchase_order.showApprove',$po_id)->with('success', 'Purchase Order Need Revision');
                }elseif($route == "/purchase_order_repair"){
                    return redirect()->route('purchase_order_repair.showApprove',$po_id)->with('success', 'Purchase Order Need Revision');
                }
            }elseif($status == "reject"){
                $modelPO->status = 5;
                $modelPO->update();
                DB::commit();
                if($route == "/purchase_order"){
                    return redirect()->route('purchase_order.showApprove',$po_id)->with('success', 'Purchase Order Rejected');
                }elseif($route == "/purchase_order_repair"){
                    return redirect()->route('purchase_order_repair.showApprove',$po_id)->with('success', 'Purchase Order Rejected');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('purchase_order.show',$po_id);
        }
    }

    // function
    public function generatePONumber(){
        $modelPO = PurchaseOrder::orderBy('created_at','desc')->first();
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
