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
        $customer_code = self::generateCustomerCode();
        $businessUnits = BusinessUnit::all();

        return view('customer.create', compact('customer', 'customer_code','user','businessUnits'));
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
            'name' => 'required|string|unique:mst_customer|max:255',
            'contact_person_name' => 'required|string|max:255',
            'contact_person_email' => 'required|email|unique:mst_customer|string|max:255',
            'contact_person_phone' => 'nullable|numeric'
        ]);

        $configuration = Configuration::get('default-password')->password;
        $password = $configuration;

        DB::beginTransaction();
        try {
            $customer = new Customer;
            $customer->code = strtoupper($request->input('code'));
            $customer->name = ucwords($request->input('name'));
            $customer->contact_person_name = $request->input('contact_person_name');
            $customer->contact_person_email = $request->input('contact_person_email');
            $customer->address = ucfirst($request->input('address'));
            $customer->contact_person_phone = $request->input('contact_person_phone');
            $customer->status = $request->input('status');
            $customer->user_id = Auth::user()->id;
            $customer->branch_id = Auth::user()->branch->id;
            $customer->save();

            $modelRole = Role::where('name','CUSTOMER')->first();
            $stringBusinessUnit = '['.$request->input('businessUnit').']';
            
            $user = new User;
            $user->username = $request->input('code');
            $user->name = $request->input('name');
            $user->email = $request->input('contact_person_email');
            $user->password = Hash::make($password);
            $user->address = $request->input('address');
            $user->phone_number = $request->input('contact_person_phone');
            $user->role_id = $modelRole->id;
            $user->business_unit_id = $stringBusinessUnit;
            $user->branch_id = Auth::user()->branch->id;
            $user->save();

            DB::commit();
            return redirect()->route('customer.show',$customer->id)->with('success', 'Success Created New Customer!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('customer.create')->with('error', $e->getMessage());
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
        
        return view('customer.show', compact('customer'));
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
            'contact_person_name' => 'required|string|max:255',            
            'contact_person_email' => 'required|email|unique:mst_customer,contact_person_email,'.$id.',id|string|max:255',
            'contact_person_phone' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $customer = Customer::find($id);
            $customer->name = ucwords($request->input('name'));
            $customer->contact_person_name = $request->input('contact_person_name');
            $customer->contact_person_email = $request->input('contact_person_email');
            $customer->address = ucfirst($request->input('address'));
            $customer->contact_person_phone = $request->input('contact_person_phone');
            $customer->status = $request->input('status');
            $customer->update();

            $user = User::where('username', $customer->code)->first();
            $user->name = ucwords($request->input('name'));
            $user->email = $request->input('contact_person_email');
            $user->address = ucfirst($request->input('address'));
            $user->phone_number = $request->input('contact_person_phone');
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
        $code = 'CUST';
        $modelCustomer = Customer::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelCustomer)){
            $number += intval(substr($modelCustomer->code, -4));
		}

        $customer_code = $code.''.sprintf('%04d', $number);
		return $customer_code;
	}
}
