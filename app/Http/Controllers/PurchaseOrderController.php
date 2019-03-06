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
use App\Models\PurchasingInfoRecord;
use DateTime;
use Auth;
use DB;
use App\Providers\numberConverter;

class PurchaseOrderController extends Controller
{
    public function selectPR(Request $request)
    {
        $route = $request->route()->getPrefix();
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
            $modelPRs = PurchaseRequisition::where('business_unit_id',1)->pluck('id')->toArray();
        }elseif($route == "/purchase_order_repair"){
            $modelPRs = PurchaseRequisition::where('business_unit_id',2)->pluck('id')->toArray();
        }
        $modelPOs = PurchaseOrder::whereIn('purchase_requisition_id',$modelPRs)->get();

        return view('purchase_order.index', compact('modelPOs','route'));
    
    }

    public function indexApprove(Request $request)
    {
        $route = $request->route()->getPrefix();
        if($route == "/purchase_order"){
            $modelPRs = PurchaseRequisition::where('business_unit_id',1)->pluck('id')->toArray();
        }elseif($route == "/purchase_order_repair"){
            $modelPRs = PurchaseRequisition::where('business_unit_id',2)->pluck('id')->toArray();
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
        $modelPRD = PurchaseRequisitionDetail::whereIn('id',$datas->checkedPRD)->with('material','project','resource','material.uom')->get();
        foreach($modelPRD as $key=>$PRD){
            if($PRD->reserved >= $PRD->quantity){
                $modelPRD->forget($key);
            }else{
                if($PRD->purchaseRequisition->type == 1){
                    $PRD['discount'] = 0;
                    $PRD['old_price'] = $PRD->material->cost_standard_price;
                    $PRD['remark'] = $PRD->remark;
                }elseif($PRD->purchaseRequisition->type == 2){
                    $PRD['discount'] = 0;
                    $PRD['old_price'] = $PRD->resource->cost_standard_price;
                    $PRD['remark'] = $PRD->remark;
                }
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
        $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id',$modelPR->id)->with('material','project','resource','material.uom')->get();
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
            if($datas->tax == ""){
                $PO->tax = 0;
            }else{
                $PO->tax = $datas->tax;
            }
            if($datas->estimated_freight == ""){
                $PO->estimated_freight = 0;
            }else{
                $PO->estimated_freight = $datas->estimated_freight * $value;
            }
            $PO->delivery_terms = $datas->delivery_terms;
            $PO->payment_terms = $datas->payment_terms;
            $PO->value = $value;
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
                $POD->purchase_requisition_detail_id = $data->id;
                $POD->quantity = $data->quantity;
                if($datas->type == 1){
                    $POD->material_id = $data->material_id;
                    $POD->total_price = $data->material->cost_standard_price * $value * $data->quantity;
                }elseif($datas->type == 2){
                    $POD->resource_id = $data->resource_id;
                    $POD->total_price = $data->resource->cost_standard_price * $value * $data->quantity;
                }
                $POD->discount = $data->discount;
                $POD->project_id = $data->project_id;
                $POD->remark = $data->remark;
                $delivery_date = DateTime::createFromFormat('d-m-Y', $data->required_date);
                if($delivery_date){
                    $delivery_date = $delivery_date->format('Y-m-d');
                }else{
                    $delivery_date = null;
                }
                $POD->delivery_date = $delivery_date;
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
        if($modelPO->status == 1){
            $statusPO = 'OPEN';
        }elseif($modelPO->status == 2){
            $statusPO = 'APPROVED';
        }elseif($modelPO->status == 3){
            $statusPO = 'NEEDS REVISION';
        }elseif($modelPO->status == 4){
            $statusPO = 'REVISED';
        }elseif($modelPO->status == 5){
            $statusPO = 'REJECTED';
        }elseif($modelPO->status == 0 || $modelPO->status == 7){
            $statusPO = 'RECEIVED';
        }

        $datas = Collection::make();
        $total_discount = 0;
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
                    foreach($datas as $key => $data){
                         if($data['material_code'] == $POD->material->code){
                            $quantity = $data['quantity'] + $POD->quantity;
                            $sub_total = $data['sub_total'] + $POD->total_price;

                            $datas->push([
                                "id" => $POD->id, 
                                "material_code" => $POD->material->code, 
                                "material_name" => $POD->material->description,
                                "quantity" => $quantity,
                                "discount" => $POD->discount,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total,
                                "remark" => $POD->remark,
                                "unit" => $POD->material->uom->unit,
                                "delivery_date" => $POD->delivery_date,
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if($status == 0){
                        $total_discount += $POD->total_price * ($POD->discount/100);
                        $datas->push([
                            "id" => $POD->id, 
                            "material_code" => $POD->material->code , 
                            "material_name" => $POD->material->description,
                            "quantity" => $POD->quantity,
                            "discount" => $POD->discount,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price,
                            "remark" => $POD->remark,
                            "unit" => $POD->material->uom->unit,
                            "delivery_date" => $POD->delivery_date,
                        ]);
                    }
                }else{
                    $total_discount += $POD->total_price * ($POD->discount/100);
                    $datas->push([
                        "id" => $POD->id, 
                        "material_code" => $POD->material->code , 
                        "material_name" => $POD->material->description,
                        "quantity" => $POD->quantity,
                        "discount" => $POD->discount,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price,
                        "remark" => $POD->remark,
                        "unit" => $POD->material->uom->unit,
                        "delivery_date" => $POD->delivery_date,
                    ]);
                }
            }
        }elseif($modelPO->purchaseRequisition->type == 2){
            $count = 0;
            foreach($modelPO->purchaseOrderDetails as $POD){
                if(count($datas) > 0){
                    $status = 0;
                    foreach($datas as $key => $data){
                        if($data['resource_code'] == $POD->resource->code){
                            $quantity = $data['quantity'] + $POD->quantity;
                            $sub_total = $data['sub_total'] + $POD->total_price;

                            $datas->push([
                                "id" => $POD->id, 
                                "resource_code" => $POD->resource->code , 
                                "resource_name" => $POD->resource->name,
                                "quantity" => $quantity,
                                "discount" => $POD->discount,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total,
                                "remark" => $POD->remark,
                                "unit" => '-',
                                "delivery_date" => $POD->delivery_date,
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if($status == 0){
                        $total_discount += $POD->total_price * ($POD->discount/100);
                        $datas->push([
                            "id" => $POD->id, 
                            "resource_code" => $POD->resource->code , 
                            "resource_name" => $POD->resource->name,
                            "quantity" => $POD->quantity,
                            "discount" => $POD->discount,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price,
                            "remark" => $POD->remark,
                            "unit" => '-',
                            "delivery_date" => $POD->delivery_date,
                        ]);
                    }
                }else{
                    $total_discount += $POD->total_price * ($POD->discount/100);
                    $datas->push([
                        "id" => $POD->id, 
                        "resource_code" => $POD->resource->code , 
                        "resource_name" => $POD->resource->name,
                        "quantity" => $POD->quantity,
                        "discount" => $POD->discount,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price,
                        "remark" => $POD->remark,
                        "unit" => '-',
                        "delivery_date" => $POD->delivery_date,
                    ]);
                }
            }
        }
        $tax = ($datas->sum('sub_total') - $total_discount) * ($modelPO->tax/100);
        return view('purchase_order.show', compact('modelPO','unit','route','datas','total_discount','tax','statusPO'));
    }

    public function showApprove(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPO = PurchaseOrder::findOrFail($id);
        if($modelPO->status == 1){
            $statusPO = 'OPEN';
        }elseif($modelPO->status == 2){
            $statusPO = 'APPROVED';
        }elseif($modelPO->status == 3){
            $statusPO = 'NEEDS REVISION';
        }elseif($modelPO->status == 4){
            $statusPO = 'REVISED';
        }elseif($modelPO->status == 5){
            $statusPO = 'REJECTED';
        }elseif($modelPO->status == 0 || $modelPO->status == 7){
            $statusPO = 'RECEIVED';
        }

        $datas = Collection::make();
        $total_discount = 0;
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
                    foreach($datas as $key => $data){
                         if($data['material_code'] == $POD->material->code){
                            $quantity = $data['quantity'] + $POD->quantity;
                            $sub_total = $data['sub_total'] + $POD->total_price;

                            $datas->push([
                                "id" => $POD->id, 
                                "material_code" => $POD->material->code, 
                                "material_name" => $POD->material->description,
                                "quantity" => $quantity,
                                "discount" => $POD->discount,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total,
                                "remark" => $POD->remark,
                                "unit" => $POD->material->uom->unit,
                                "delivery_date" => $POD->delivery_date,
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if($status == 0){
                        $total_discount += $POD->total_price * ($POD->discount/100);
                        $datas->push([
                            "id" => $POD->id, 
                            "material_code" => $POD->material->code , 
                            "material_name" => $POD->material->description,
                            "quantity" => $POD->quantity,
                            "discount" => $POD->discount,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price,
                            "remark" => $POD->remark,
                            "unit" => $POD->material->uom->unit,
                            "delivery_date" => $POD->delivery_date,
                        ]);
                    }
                }else{
                    $total_discount += $POD->total_price * ($POD->discount/100);
                    $datas->push([
                        "id" => $POD->id, 
                        "material_code" => $POD->material->code , 
                        "material_name" => $POD->material->description,
                        "quantity" => $POD->quantity,
                        "discount" => $POD->discount,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price,
                        "remark" => $POD->remark,
                        "unit" => $POD->material->uom->unit,
                        "delivery_date" => $POD->delivery_date,
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
                                "id" => $POD->id, 
                                "resource_code" => $POD->resource->code , 
                                "resource_name" => $POD->resource->name,
                                "quantity" => $quantity,
                                "discount" => $POD->discount,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total,
                                "remark" => $POD->remark,
                                "unit" => '-',
                                "delivery_date" => $POD->delivery_date,
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if($status == 0){
                        $total_discount += $POD->total_price * ($POD->discount/100);
                        $datas->push([
                            "id" => $POD->id, 
                            "resource_code" => $POD->resource->code , 
                            "resource_name" => $POD->resource->name,
                            "quantity" => $POD->quantity,
                            "discount" => $POD->discount,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price,
                            "remark" => $POD->remark,
                            "unit" => '-',
                            "delivery_date" => $POD->delivery_date,
                        ]);
                    }
                }else{
                    $total_discount += $POD->total_price * ($POD->discount/100);
                    $datas->push([
                        "id" => $POD->id, 
                        "resource_code" => $POD->resource->code , 
                        "resource_name" => $POD->resource->name,
                        "quantity" => $POD->quantity,
                        "discount" => $POD->discount,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price,
                        "remark" => $POD->remark,
                        "unit" => '-',
                        "delivery_date" => $POD->delivery_date,
                    ]);
                }
            }
        }
        $tax = ($datas->sum('sub_total') - $total_discount) * ($modelPO->tax/100);
        return view('purchase_order.showApprove', compact('modelPO','route','datas','total_discount','tax','unit','statusPO'));
    }

    public function edit(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPO = PurchaseOrder::where('id',$id)->with('purchaseRequisition')->first();
        $modelPOD = PurchaseOrderDetail::where('purchase_order_id',$id)->with('material','purchaseRequisitionDetail','wbs','resource','material.uom','purchaseRequisitionDetail.purchaseRequisition')->get();
        $modelProject = Project::where('id',$modelPO->purchaseRequisition->project_id)->with('ship','customer')->first();
        foreach($modelPOD as $POD){
            $POD['old_price'] = $POD->total_price / $POD->quantity;
        }
        $currencies = Configuration::get('currencies');
        return view('purchase_order.edit', compact('modelPO','modelPOD','modelProject','route','currencies'));
    }

    public function update(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $value = "";
        $valueCurrency = Configuration::get('currencies');
        foreach ($valueCurrency as $data) {
            if($data->name == $datas->modelPO->currency){
                $value = $data->value;
            }
        }

        DB::beginTransaction();
        try {
            $PO = PurchaseOrder::findOrFail($datas->modelPO->id);
            $status = 0;
            $total_price = 0;
            if($datas->modelPO->currency != $PO->currency){
                $PO->value = $value;
            }
            foreach($datas->PODetail as $data){
                $POD = PurchaseOrderDetail::findOrFail($data->id);
                $diff = $data->quantity - $POD->quantity;
                $POD->quantity = $data->quantity;
                $POD->total_price = $data->quantity * ($data->total_price * $PO->value);
                $POD->remark = $data->remark;
                $delivery_date = DateTime::createFromFormat('d-m-Y', $data->delivery_date);
                if($delivery_date){
                    $delivery_date = $delivery_date->format('Y-m-d');
                }else{
                    $delivery_date = null;
                }
                $POD->delivery_date = $delivery_date;
                $POD->discount = $data->discount;
                $POD->save();

                $statusPR = $this->updatePR($data->purchase_requisition_detail_id,$diff);
                if($statusPR === true){
                    $status = 1;
                }
                $total_price += $POD->total_price;
            }
            $PO->vendor_id = $datas->modelPO->vendor_id;
            $PO->description = $datas->modelPO->description;
            $PO->tax = $datas->modelPO->tax;
            if($datas->modelPO->estimated_freight == ""){
                $PO->estimated_freight = 0;
            }else{
                $PO->estimated_freight = $datas->modelPO->estimated_freight * $value;
            }
            $PO->delivery_terms = $datas->modelPO->delivery_terms;
            $PO->payment_terms = $datas->modelPO->payment_terms;
            
            if($datas->modelPO->currency != $PO->currency){
                $PO->value = $value;
            }
            $PO->currency = $datas->modelPO->currency;

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

    public function approval(Request $request)
    {
        $datas = json_decode($request->datas);
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try{
            $modelPO = PurchaseOrder::findOrFail($datas->po_id);
            if($datas->status == "approve"){
                $modelPO->status = 2;
                $modelPO->revision_description = $datas->desc;
                $modelPO->approved_by = Auth::user()->id;
                $modelPO->update();
                $this->generatePIR($modelPO);
                DB::commit();
                if($route == "/purchase_order"){
                    return redirect()->route('purchase_order.show',$datas->po_id)->with('success', 'Purchase Order Approved');
                }elseif($route == "/purchase_order_repair"){
                    return redirect()->route('purchase_order_repair.show',$datas->po_id)->with('success', 'Purchase Order Approved');
                }
            }elseif($datas->status == "need-revision"){
                $modelPO->status = 3;
                $modelPO->revision_description = $datas->desc;
                $modelPO->approved_by = Auth::user()->id;
                $modelPO->update();
                DB::commit();
                if($route == "/purchase_order"){
                    return redirect()->route('purchase_order.show',$datas->po_id)->with('success', 'Purchase Order Need Revision');
                }elseif($route == "/purchase_order_repair"){
                    return redirect()->route('purchase_order_repair.show',$datas->po_id)->with('success', 'Purchase Order Need Revision');
                }
            }elseif($datas->status == "reject"){
                $modelPO->status = 5;
                $modelPO->revision_description = $datas->desc;
                $modelPO->approved_by = Auth::user()->id;
                $modelPO->update();
                DB::commit();
                if($route == "/purchase_order"){
                    return redirect()->route('purchase_order.show',$datas->po_id)->with('success', 'Purchase Order Rejected');
                }elseif($route == "/purchase_order_repair"){
                    return redirect()->route('purchase_order_repair.show',$datas->po_id)->with('success', 'Purchase Order Rejected');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('purchase_order.show',$datas->po_id)->with('error', $e->getMessage());
        }
    }

    public function generatePIR($modelPO){
        foreach($modelPO->purchaseOrderDetails as $POD){
            $PIR = new PurchasingInfoRecord;
            $PIR->purchase_order_id = $modelPO->id;
            $PIR->purchase_order_detail_id = $POD->id;
            $PIR->material_id = $POD->material_id;
            $PIR->resource_id = $POD->resource_id;
            $PIR->vendor_id = $modelPO->vendor_id;
            $PIR->quantity = $POD->quantity;
            $PIR->save();
        }
    }

    public function printPdf($id, Request $request)
    { 
        $branch = Auth::user()->branch; 
        $modelPO = PurchaseOrder::find($id);
        $discount = 0;
        $tax = 0;
        $freight = 0;
        foreach($modelPO->purchaseOrderDetails as $POD){
            if($POD->quantity > 0){
                $discount += $POD->total_price * (($POD->discount)/100);
                $tax += $POD->total_price * (($POD->tax)/100);
                $freight += $POD->estimated_freight;
            }
        }
        $total_price = $modelPO->total_price - $discount + $tax + $freight;
        $words = numberConverter::longform($total_price);
        $route = $request->route()->getPrefix();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('purchase_order.pdf',['modelPO' => $modelPO,'words'=>$words,'branch'=>$branch, 'route'=> $route]);
        $now = date("Y_m_d_H_i_s");

        return $pdf->download('Purchase_Order_'.$now.'.pdf');
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
