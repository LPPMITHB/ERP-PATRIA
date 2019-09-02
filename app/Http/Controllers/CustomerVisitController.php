<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerVisit;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use DateTime;

class CustomerVisitController extends Controller
{
    public function index(Request $request)
    {
        $route = $request->route()->getPrefix();    
        $customerVisits = CustomerVisit::with('customer')->get();
        $modelCustomer = Customer::all();

        return view ('customer_visit.index', compact('customerVisits','modelCustomer','route'));   
    }

    public function store(Request $request)
    {
        $route = $request->route()->getPrefix();    
        $datas = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $customer_visit = new CustomerVisit;
            if($route == "/customer_visit"){
                $customer_visit->business_unit_id = 1;
            }elseif($route == "/customer_visit_repair"){
                $customer_visit->business_unit_id = 2;
            } 
            $customer_visit->type = $datas->type;

            $planned_date = DateTime::createFromFormat('d-m-Y', $datas->planned_date);
            $customer_visit->planned_date= $planned_date->format('Y-m-d');

            $customer_visit->customer_id = $datas->customer_id;
            $customer_visit->note = $datas->note;
            $customer_visit->branch_id = Auth::user()->branch->id;
            $customer_visit->user_id = Auth::user()->id;
            $customer_visit->save();
            
            DB::commit();
            if($route == "/customer_visit"){
                return redirect()->route('customer_visit.index')->with('success', 'Customer Call / Visit Updated');
            }elseif($route == "/customer_visit_repair"){
                return redirect()->route('customer_visit_repair.index')->with('success', 'Customer Call / Visit Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/customer_visit"){
                return redirect()->route('customer_visit.index')->with('error', $e->getMessage());
            }elseif($route == "/customer_visit_repair"){
                return redirect()->route('customer_visit_repair.index')->with('error', $e->getMessage());
            }
        }
    }

    public function update(Request $request, $id)
    {
        $route = $request->route()->getPrefix();    
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            $customer_visit = CustomerVisit::find($id);
            $customer_visit->type = $datas->type;
            $customer_visit->customer_id = $datas->customer_id;
            $customer_visit->note = $datas->note;
            $customer_visit->report = $datas->report;
            $customer_visit->update();
            
            DB::commit();
            if($route == "/customer_visit"){
                return redirect()->route('customer_visit.index')->with('success', 'Customer Call / Visit Updated');
            }elseif($route == "/customer_visit_repair"){
                return redirect()->route('customer_visit_repair.index')->with('success', 'Customer Call / Visit Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/customer_visit"){
                return redirect()->route('customer_visit.index')->with('error', $e->getMessage());
            }elseif($route == "/customer_visit_repair"){
                return redirect()->route('customer_visit_repair.index')->with('error', $e->getMessage());
            }
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $customer_visit = CustomerVisit::find($id);
            $customer_visit->delete();
            
            DB::commit();
            return redirect()->route('yard_plan.create')->with('success', 'Yard Plan Deleted');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('yard_plan.create')->with('error', $e->getMessage());
        }
    }
}
