<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\Role;
use App\Models\BusinessUnit;
use App\Models\Configuration;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = new Customer;
        $user = new User;
        $business_ids = Auth::user()->business_unit_id;
        $customer_code = self::generateCustomerCode();
        $businessUnits = BusinessUnit::all();

        return view('customer.create', compact('customer', 'customer_code','user','business_ids','businessUnits'));
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
            'code' => 'required|alpha_dash|unique:mst_customer|string|max:255',
        ]);

        $configuration = Configuration::get('default-password')->password;
        $password = $configuration;

        DB::beginTransaction();
        try {
            $customer = new Customer;
            $customer->code = strtoupper($request->input('code'));
            $customer->name = ucwords($request->input('name'));
            $customer->phone_number_1 = $request->input('phone_number_1');
            $customer->phone_number_2 = $request->input('phone_number_2');
            $customer->address_1 = ucfirst($request->input('address_1'));
            $customer->address_2 = ucfirst($request->input('address_2'));
            $customer->contact_name = $request->input('contact_name');
            $customer->tax_number = $request->input('tax_number');
            $customer->pkp_number = $request->input('pkp_number');
            $customer->email = $request->input('email');
            $customer->province = $request->input('province');
            $customer->zip_code = $request->input('zip_code');
            $customer->country = $request->input('country');
            $customer->status = $request->input('status');
            $customer->branch_id = Auth::user()->branch->id;
            
            $modelRole = Role::where('name','CUSTOMER')->first();
            $stringBusinessUnit = '['.$request->input('businessUnit').']';
            
            $user = new User;
            $user->username = $request->input('code');
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($password);
            $user->address = $request->input('address_1');
            $user->phone_number = $request->input('phone_number_1');
            $user->role_id = $modelRole->id;
            $user->business_unit_id = $stringBusinessUnit;
            $user->branch_id = Auth::user()->branch->id;
            $user->save();

            $customer->user_id = $user->id;
            $customer->save();

            DB::commit();
            return redirect()->route('customer.show',$customer->id)->with('success', 'Success Created New Customer!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('customer.create')->with('error', $e->getMessage())->withInput();
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
        $customer = Customer::findOrFail($id);
        $business_ids = json_decode($customer->user->business_unit_id);
        $business_unit = "";
        foreach($business_ids as $business_id){
            if($business_unit == ""){
                if($business_id == 1){
                    $business_unit = "Building";
                }elseif($business_id == 2){
                    $business_unit = "Repair";
                }elseif($business_id == 3){
                    $business_unit = "Trading";
                }
            }else{
                if($business_id == 1){
                    $business_unit = $business_unit.", Building";
                }elseif($business_id == 2){
                    $business_unit = $business_unit.", Repair";
                }elseif($business_id == 3){
                    $business_unit = $business_unit.", Trading";
                }
            }
        }
        
        return view('customer.show', compact('customer','business_unit','business_ids'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        
        $businessUnits = BusinessUnit::all();


        return view('customer.create', compact('customer','businessUnits'));
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
        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_customer,code,'.$id.',id|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:mst_customer,email,'.$id.',id|max:255',
        ]);

        DB::beginTransaction();
        try {
            $customer = Customer::find($id);
            $customer->name = ucwords($request->input('name'));
            $customer->phone_number_1 = $request->input('phone_number_1');
            $customer->phone_number_2 = $request->input('phone_number_2');
            $customer->address_1 = ucfirst($request->input('address_1'));
            $customer->address_2 = ucfirst($request->input('address_2'));
            $customer->contact_name = $request->input('contact_name');
            $customer->tax_number = $request->input('tax_number');
            $customer->pkp_number = $request->input('pkp_number');
            $customer->email = $request->input('email');
            $customer->province = $request->input('province');
            $customer->zip_code = $request->input('zip_code');
            $customer->country = $request->input('country');
            $customer->status = $request->input('status');
            $customer->update();

            $stringBusinessUnit = '['.$request->input('businessUnit').']';

            $user = User::where('username', $customer->code)->first();
            $user->name = ucwords($request->input('name'));
            $user->email = $request->input('email');
            $user->address = ucfirst($request->input('address_1'));
            $user->phone_number = $request->input('phone_number_1');
            $user->business_unit_id = $stringBusinessUnit;
            $user->update();
            

            DB::commit();
            return redirect()->route('customer.show',$customer->id)->with('success', 'Customer Updated Succesfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('customer.create')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        try {
            $customer->delete();
            return redirect()->route('customer.index')->with('status', 'Customer Deleted Succesfully!');
        } catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('customer.index')->with('status', 'Can\'t Delete The Customer Because It Is Still Being Used');
        }   
    }

    public function generateCustomerCode(){
        $code = 'C15';
        $modelCustomer = Customer::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelCustomer)){
            $number += intval(substr($modelCustomer->code, -3));
		}

        $customer_code = $code.''.sprintf('%03d', $number);
		return $customer_code;
	}
}
