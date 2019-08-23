<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use DB;
use Auth;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function selectQT(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelQTs = Quotation::whereIn('status', [1])->get();
        
        return view('sales_order.select_quotation', compact('modelQTs', 'route'));
    }

    public function index(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelSOs = SalesOrder::all();

        return view('sales_order.index', compact('modelSOs', 'route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $sales_order = new SalesOrder;
        $route = $request->route()->getPrefix();
        $quotation = Quotation::where('id',$id)->with('quotationDetails','quotationDetails.estimatorCostStandard','quotationDetails.estimatorCostStandard.estimatorWbs','quotationDetails.estimatorCostStandard.uom')->first();
        $customers = Customer::where('status',1)->get(); 
        
        return view('sales_order.create', compact('quotation','route','customers','sales_order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $route = $request->route()->getPrefix();
        $data = json_decode($request->datas);
        $so_number = $this->generateSONumber();

        DB::beginTransaction();
        try {
            $sales_order = new SalesOrder;
            $sales_order->number = $so_number;
            $sales_order->quotation_id = $data->pd->id;
            $sales_order->customer_id = ($data->customer_id != "") ? $data->customer_id : null;
            $sales_order->description = $data->description;
            $sales_order->price = $data->price;
            $sales_order->total_price = $data->total_price;
            $sales_order->margin = $data->margin;
            $sales_order->status = 1;
            $sales_order->terms_of_payment = json_encode($data->top);
            $sales_order->user_id = Auth::user()->id;
            $sales_order->branch_id = Auth::user()->branch->id;
            
            if(!$sales_order->save()){
                if($route == "/sales_order"){
                    return redirect()->route('sales_order.create', ['id' => $sales_order->id])->with('error', 'Failed Save Sales Order!');
                }elseif($route == "/sales_order_repair"){
                    return redirect()->route('sales_order_repair.create', ['id' => $sales_order->id])->with('error', 'Failed Save Sales Order!');
                }
            }else{
                // input quotation detail
                foreach($data->pd->quotation_details as $qd){
                    $sod = new SalesOrderDetail;
                    $sod->sales_order_id = $sales_order->id;
                    $sod->cost_standard_id = $qd->cost_standard_id;
                    $sod->value = $qd->value;
                    $sod->price = $qd->price;
                    $sod->save();
                }
                // update status quotation
                $quotation = Quotation::findOrFail($data->pd->id);
                $quotation->status = 0;
                $quotation->update();

                DB::commit();
                if($route == "/sales_order"){
                    return redirect()->route('sales_order.show', ['id' => $sales_order->id])->with('success', 'Sales Order Created');
                }elseif($route == "/sales_order_repair"){
                    return redirect()->route('sales_order_repair.show', ['id' => $sales_order->id])->with('success', 'Sales Order Created');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/sales_order"){
                return redirect()->route('sales_order.create', ['id' => $sales_order->id])->with('error', $e->getMessage());
            }elseif($route == "/sales_order_repair"){
                return redirect()->route('sales_order_repair.create', ['id' => $sales_order->id])->with('error', $e->getMessage());
            }
        }
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
        $modelSO = SalesOrder::findOrFail($id);
        if ($modelSO->status == 1) {
            $statusSO = 'OPEN';
        } elseif ($modelSO->status == 0) {
            $statusSO = 'CONNECTED TO PROJECT';
        } elseif ($modelSO->status == 2) {
            $statusSO = 'CANCELED';
        }

        $wbs = [];
        foreach($modelSO->salesOrderDetails as $sod){
            array_push($wbs,$sod->estimatorCostStandard->estimatorWbs);
        }
        $wbs = array_unique($wbs);
        $tops = json_decode($modelSO->terms_of_payment);

        return view('sales_order.show', compact('route', 'modelSO', 'statusSO','wbs','tops'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $sales_order = SalesOrder::where('id',$id)->with('salesOrderDetails','salesOrderDetails.estimatorCostStandard','salesOrderDetails.estimatorCostStandard.estimatorWbs','salesOrderDetails.estimatorCostStandard.uom')->first();
        $customers = Customer::where('status',1)->get(); 
        $quotation = Quotation::where('id',$sales_order->quotation->id)->with('quotationDetails','quotationDetails.estimatorCostStandard','quotationDetails.estimatorCostStandard.estimatorWbs','quotationDetails.estimatorCostStandard.uom')->first();

        return view('sales_order.create', compact('quotation','route','sales_order','customers'));
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
        $route = $request->route()->getPrefix();
        $data = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $sales_order = SalesOrder::findOrFail($data->pd->id);
            $sales_order->customer_id = ($data->customer_id != "") ? $data->customer_id : null;
            $sales_order->description = $data->description;
            $sales_order->price = $data->price;
            $sales_order->total_price = $data->total_price;
            $sales_order->margin = $data->margin;
            $sales_order->terms_of_payment = json_encode($data->top);
            $sales_order->user_id = Auth::user()->id;
            $sales_order->branch_id = Auth::user()->branch->id;

            if(!$sales_order->save()){
                if($route == "/sales_order"){
                    return redirect()->route('sales_order.create', ['id' => $sales_order->id])->with('error', 'Failed Save Sales !');
                }elseif($route == "/sales_order_repair"){
                    return redirect()->route('sales_order_repair.create', ['id' => $sales_order->id])->with('error', 'Failed Save Sales !');
                }
            }else{
                foreach($data->pd->sales_order_details as $sod){
                    $sales_order_detail = SalesOrderDetail::findOrFail($sod->id);
                    $sales_order_detail->value = $sod->value;
                    $sales_order_detail->save();
                }
                DB::commit();
                if($route == "/sales_order"){
                    return redirect()->route('sales_order.show', ['id' => $sales_order->id])->with('success', 'Quotation Created');
                }elseif($route == "/sales_order_repair"){
                    return redirect()->route('sales_order_repair.show', ['id' => $sales_order->id])->with('success', 'Quotation Created');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/sales_order"){
                return redirect()->route('sales_order.edit', ['id' => $sales_order->id])->with('error', $e->getMessage());
            }elseif($route == "/sales_order_repair"){
                return redirect()->route('sales_order_repair.edit', ['id' => $sales_order->id])->with('error', $e->getMessage());
            }
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
        //
    }

    // function
    public function generateSONumber()
    {
        $modelSO = SalesOrder::orderBy('created_at', 'desc')->first();
        $yearNow = date('y');

        $number = 1;
        if (isset($modelSO)) {
            $yearDoc = substr($modelSO->number, 3, 2);
            if ($yearNow == $yearDoc) {
                $number += intval(substr($modelSO->number, -5));
            }
        }

        $year = date($yearNow . '00000');
        $year = intval($year);

        $so_number = $year + $number;
        $so_number = 'SO-' . $so_number;

        return $so_number;
    }
}
