<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Invoice;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use DB;
use Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelInvoices = Invoice::all();

        return view('invoice.index', compact('modelInvoices', 'route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $project = Project::where('id', $id)->with('salesOrder','ship','customer')->first();
        $invoices = Invoice::where('sales_order_id',$project->sales_order_id)->get();

        return view('invoice.create', compact('invoices','route','project'));
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
        $invoice_number = $this->generateInvoiceNumber();

        DB::beginTransaction();
        try {
            $invoice = new Invoice;
            $invoice->number = $invoice_number;
            $invoice->project_id = $data->project_id;
            $invoice->sales_order_id = $data->sales_order_id;
            $invoice->current_project_progress = $data->current_progress;
            $invoice->top_project_progress = $data->top->project_progress;
            $invoice->top_payment_percentage = $data->top->payment_percentage;
            $invoice->payment_value = $data->total_price * ($data->top->payment_percentage / 100);
            $invoice->top_index = $data->top_index;
            $invoice->status = 1;
            $invoice->user_id = Auth::user()->id;
            $invoice->branch_id = Auth::user()->branch->id;
            
            if(!$invoice->save()){
                if($route == "/invoice"){
                    return redirect()->route('invoice.create', $invoice->id)->with('error', 'Failed Save Invoice!');
                }elseif($route == "/invoice_repair"){
                    return redirect()->route('invoice_repair.create', $invoice->id)->with('error', 'Failed Save Invoice!');
                }
            }else{
                DB::commit();
                if($route == "/invoice"){
                    return redirect()->route('invoice.show', $invoice->id)->with('success', 'Invoice Created');
                }elseif($route == "/invoice_repair"){
                    return redirect()->route('invoice_repair.show', $invoice->id)->with('success', 'Invoice Created');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/invoice"){
                return redirect()->route('invoice.selectProject')->with('error', $e->getMessage());
            }elseif($route == "/invoice_repair"){
                return redirect()->route('invoice_repair.selectProject')->with('error', $e->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $route = $request->route()->getPrefix();
        $modelInvoice = Invoice::findOrFail($id);
        if ($modelInvoice->status == 1) {
            $statusInvoice = 'BILLED';
        } elseif ($modelInvoice->status == 0) {
            $statusInvoice = 'PAID';
        } elseif ($modelInvoice->status == 2) {
            $statusInvoice = 'CANCELED';
        } elseif ($modelInvoice->status == 3) {
            $statusInvoice = 'SEPARATELY PAID';
        }

        return view('invoice.show', compact('route', 'modelInvoice', 'statusInvoice'));
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

    public function selectProject(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelProjects = Project::where('status', 1)->where('sales_order_id','!=',null)->get();
        
        return view('invoice.select_project', compact('modelProjects', 'route'));
    }

    // function
    public function generateInvoiceNumber(){
        $modelInv = Invoice::orderBy('created_at','desc')->first();
        $yearNow = date('y');
        
		$number = 1;
        if(isset($modelInv)){
            $yearDoc = substr($modelInv->number, 4,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelInv->number, -5));
            }
        }

        $year = date($yearNow.'000000');
        $year = intval($year);

		$inv_number = $year+$number;
        $inv_number = 'INV-'.$inv_number;

        return $inv_number;
    }
}
