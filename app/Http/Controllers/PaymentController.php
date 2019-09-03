<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use DB;
use Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectInvoice(Request $request){
        $menu = "manage_payment";
        $route = $request->route()->getPrefix();
        $modelInvoice = Invoice::whereIn('status', [1,3])->get();
        
        return view('payment.select_invoice', compact('modelInvoice', 'route','menu'));
    }

    public function selectInvoiceView(Request $request){
        $menu = "view_payment";
        $route = $request->route()->getPrefix();
        $modelInvoice = Invoice::whereIn('status', [0])->get();
        
        return view('payment.select_invoice', compact('modelInvoice', 'route','menu'));
    }

    public function manage(Request $request, $id, $menu)
    {
        $route = $request->route()->getPrefix();
        $payment = Payment::where('invoice_id',$id)->with('user')->get();
        $invoice = Invoice::where('id', $id)->with('salesOrder','project','project.ship','project.customer')->first();

        return view('payment.manage', compact('invoice','route','payment','menu'));
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $payment = new Payment;
            $payment->invoice_id = $data['invoice_id'];
            $payment->amount = $data['amount'];
            $payment->status = 1;
            $payment->user_id = Auth::user()->id;
            $payment->branch_id = Auth::user()->branch->id;
            $payment->save();

            $modelInvoice = Invoice::findOrFail($data['invoice_id']);
            $modelPayment = Payment::where('invoice_id',$data['invoice_id'])->get();
            
            $paid = 0;
            foreach($modelPayment as $payment){
                $paid += $payment->amount;
            }
            
            if($paid < $modelInvoice->payment_value){
                $modelInvoice->status = 3;
            }else{
                $modelInvoice->status = 0;
            }

            $modelInvoice->update();

            // update credit limit
            $customer = $modelInvoice->salesOrder->customer;
            $customer->used_limit -= $payment->amount;
            $customer->update();
            
            DB::commit();
            return response(json_encode($payment),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('payment.selectInvoice')->with('error', $e->getMessage());
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
        //
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

    // function
    public function getInvoiceAPI($id){
        $invoice = Invoice::where('id', $id)->with('salesOrder','project','project.ship','project.customer')->first()->jsonSerialize();

        return response($invoice, Response::HTTP_OK);
    }

    public function getPaymentAPI($id){
        $payment = Payment::where('invoice_id',$id)->with('user')->get()->jsonSerialize();

        return response($payment, Response::HTTP_OK);
    }
}
