<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\PurchaseOrder;
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
        return view('vendor.create',compact('vendor','vendor_code'));
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
            'phone_number' => 'required|numeric',
            'email' => 'required|email|unique:mst_vendor|string|max:255'
        ]);
        DB::beginTransaction();
        try {
        $vendor = new Vendor;
        $vendor->code = strtoupper($request->input('code'));
        $vendor->name = ucwords($request->input('name'));
        $vendor->type = ucwords($request->input('type'));
        $vendor->address = ucfirst($request->input('address'));
        $vendor->phone_number = $request->input('phone_number');
        $vendor->email = $request->input('email');
        $vendor->status = $request->input('status');
        $vendor->competence = $request->input('competence');
        $vendor->user_id = Auth::user()->id;
        $vendor->branch_id = Auth::user()->branch->id;
        $vendor->save();

        DB::commit();
        return redirect()->route('vendor.show',$vendor->id)->with('success','Success Created New Vendor!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('vendor.update',$vendor->id)->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);
        $modelPOs = PurchaseOrder::where('vendor_id',$id)->get();

        return view('vendor.show',compact('vendor','modelPOs'));
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);

        return view('vendor.create',compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_vendor,code,'.$id.',id|string|max:255',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'email' => 'required|email|unique:mst_vendor,email,'.$id.',id|string|max:255'
        ]);
        DB::beginTransaction();
        try {
        $vendor = Vendor::find($id);
        $vendor->code = strtoupper($request->input('code'));
        $vendor->name = ucwords($request->input('name'));
        $vendor->type = ucwords($request->input('type'));
        $vendor->address = ucfirst($request->input('address'));
        $vendor->phone_number = $request->input('phone_number');
        $vendor->email = $request->input('email');
        $vendor->status = $request->input('status');
        $vendor->competence = $request->input('competence');
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
}
