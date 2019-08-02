<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\PurchaseOrder;
use App\Models\WorkOrder;
use App\Models\GoodsReceipt;
use App\Models\GoodsIssue;
use App\Models\Configuration;
use App\Models\Material;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Auth;
use DB;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::all();

        return view('vendor.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendor = new Vendor;
        $vendor_code = self::generateVendorCode();
        $vendor_categories = Configuration::get('vendor_category');
        $payment_terms = Configuration::get('payment_terms');
        $delivery_terms = Configuration::get('delivery_terms');

        return view('vendor.create',compact('vendor','vendor_code','vendor_categories','payment_terms','delivery_terms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_vendor|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:mst_customer|max:255'
        ]);
        DB::beginTransaction();
        try {
        $vendor = new Vendor;
        $vendor->code = strtoupper($request->input('code'));
        $vendor->name = ucwords($request->input('name'));
        $vendor->type = ucwords($request->input('type'));
        $vendor->address = ucfirst($request->input('address'));
        $vendor->phone_number_1 = $request->input('phone_number_1');
        $vendor->phone_number_2 = $request->input('phone_number_2');
        $vendor->contact_name = $request->input('contact_name');
        $vendor->email = $request->input('email');
        $vendor->status = $request->input('status');
        $vendor->description = $request->input('description');
        if($request->input('payment_term') != ""){
            $vendor->payment_term = $request->input('payment_term');
        }else{
            $vendor->payment_term = null;
        }
        if($request->input('delivery_term') != ""){
            $vendor->delivery_term = $request->input('delivery_term');
        }else{
            $vendor->delivery_term = null;
        }
        $vendor->user_id = Auth::user()->id;
        $vendor->branch_id = Auth::user()->branch->id;
        $vendor->save();

        DB::commit();
        return redirect()->route('vendor.show',$vendor->id)->with('success','Success Created New Vendor!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('vendor.create')->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);
        $modelPOs = PurchaseOrder::where('vendor_id',$id)->get();
        $modelWOs = WorkOrder::where('vendor_id',$id)->get();
        $po_ids = $modelPOs->pluck('id')->toArray();
        $modelGRs = GoodsReceipt::whereIn('purchase_order_id', $po_ids)->with('goodsReceiptDetails','purchaseOrder.purchaseOrderDetails')->get();
        $gr_ids = $modelGRs->pluck('id')->toArray();
        // broken code
        /*
        $return = GoodsIssue::whereIn('purchase_order_id', $po_ids)->orWhereIn('goods_receipt_id',$gr_ids)->where('type',4)->get();
        */
        // code fix. kolom purchase_order_id diganti ke goods_return_id, goods_receipt_id tidak ada di database trx_goods_issue
        $return = GoodsIssue::whereIn('goods_return_id', $gr_ids)->where('type',4)->get();

        $resourceDetails = $vendor->resourceDetails;

        $payment_terms = Configuration::get('payment_terms');
        $pt_name = "-";
        foreach($payment_terms as $payment_term){
            if($vendor->payment_term == $payment_term->id){
                $pt_name = $payment_term->name;
            }
        }

        $delivery_terms = Configuration::get('delivery_terms');
        $dt_name = "-";
        foreach($delivery_terms as $delivery_term){
            if($vendor->delivery_term == $delivery_term->id){
                $dt_name = $delivery_term->name;
            }
        }

        return view('vendor.show',compact('vendor','modelPOs','modelWOs','return','modelGRs','resourceDetails','pt_name','dt_name'));
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor_categories = Configuration::get('vendor_category');
        $payment_terms = Configuration::get('payment_terms');
        $delivery_terms = Configuration::get('delivery_terms');

        return view('vendor.create',compact('vendor','vendor_categories','payment_terms','delivery_terms'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_vendor,code,'.$id.',id|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:mst_customer|max:255'
        ]);
        DB::beginTransaction();
        try {
        $vendor = Vendor::find($id);
        $vendor->code = strtoupper($request->input('code'));
        $vendor->name = ucwords($request->input('name'));
        $vendor->type = ucwords($request->input('type'));
        $vendor->address = ucfirst($request->input('address'));
        $vendor->phone_number_1 = $request->input('phone_number_1');
        $vendor->phone_number_2 = $request->input('phone_number_2');
        $vendor->contact_name = $request->input('contact_name');
        $vendor->email = $request->input('email');
        $vendor->status = $request->input('status');
        $vendor->description = $request->input('description');
        if($request->input('payment_term') != ""){
            $vendor->payment_term = $request->input('payment_term');
        }else{
            $vendor->payment_term = null;
        }
        if($request->input('delivery_term') != ""){
            $vendor->delivery_term = $request->input('delivery_term');
        }else{
            $vendor->delivery_term = null;
        }
        $vendor->update();

        DB::commit();
        return redirect()->route('vendor.show',$vendor->id)->with('success','Vendor Updated Succesfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('vendor.update',$vendor->id)->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {

    }

    public function generateVendorCode(){
        $code = 'VR';
        $modelVendor = Vendor::orderBy('code', 'desc')->first();

        $number = 1;
		if(isset($modelVendor)){
            $number += intval(substr($modelVendor->code, -4));
		}

        $vendor_code = $code.''.sprintf('%04d', $number);
		return $vendor_code;
	}

    public function getMaterialAPI($id){
        return response(Material::where('id',$id)->first()->jsonSerialize(), Response::HTTP_OK);
    }
}
