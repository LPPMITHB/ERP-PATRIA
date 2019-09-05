<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\SalesPlan;
use App\Models\Ship;
use App\Models\Customer;
use Illuminate\Support\Collection;
use Auth;
use DB;

class SalesPlanController extends Controller
{
    public function index(Request $request)
    {
        $route = $request->route()->getPrefix();
        $user_id = Auth::user()->id;
        $years = array();
        $ships = Ship::all();
        $customers = Customer::all();

        // $years_exist = SalesPlan::where('user_id',$user_id)->distinct()->pluck('year')->toArray();

        $data_init = Collection::make();
        $this_year = date("Y");
        $this_month = date("m");
        for ($i=0; $i < 5; $i++) { 
            array_push($years,$this_year+$i);
        }

        for ($j=0; $j < 12; $j++) { 
            $data_init->push([
                "month" => $j+1,
                "ship" => "",
                "customer" => "",
                "value" => 0,
            ]);
        }

        return view('sales_plan.index', compact('data_init','this_year','this_month','route','user_id','years','ships','customers'));

    }

    public function store(Request $request)
    {
        $route = $request->route()->getPrefix();    
        $datas = json_decode($request->datas);

        DB::beginTransaction();
        try {
            if($datas->id != null){
                $sales_plan = SalesPlan::find($datas->id);
                $sales_plan->ship_id = json_encode($datas->ship_ids);
                $sales_plan->customer_id = json_encode($datas->customer_ids);
                $sales_plan->value = $datas->value;
                $sales_plan->update();
            }else{
                $sales_plan = new SalesPlan;
                if($route == "/sales_plan"){
                    $sales_plan->business_unit_id = 1;
                }elseif($route == "/sales_plan_repair"){
                    $sales_plan->business_unit_id = 2;
                }             
                $sales_plan->ship_id = json_encode($datas->ship_ids);
                $sales_plan->customer_id = json_encode($datas->customer_ids);   
                $sales_plan->month = $datas->month;   
                $sales_plan->year = $datas->year;   
                $sales_plan->value = $datas->value;   
                $sales_plan->user_id = Auth::user()->id;
                $sales_plan->branch_id = Auth::user()->branch->id;
                $sales_plan->save();
            }
            
            DB::commit();
            if($route == "/sales_plan"){
                return redirect()->route('sales_plan.index')->with('success', 'Sales Plan Updated');
            }elseif($route == "/sales_plan_repair"){
                return redirect()->route('sales_plan_repair.index')->with('success', 'Sales Plan Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/sales_plan"){
                return redirect()->route('sales_plan.index')->with('error', $e->getMessage());
            }elseif($route == "/sales_plan_repair"){
                return redirect()->route('sales_plan_repair.index')->with('error', $e->getMessage());
            }
        }
    }

    //API 
    public function getSalesPlanAPI($year){
        $user_id = Auth::user()->id;
        $sales_plans_ref = SalesPlan::where('user_id',$user_id)->where('year',$year)->get();
        $sales_plans = Collection::make();

        foreach ($sales_plans_ref as $sales_plan) {
            $ship = "";
            $customer = "";
            
            $ship_ids = $sales_plan->ship_id != null ? json_decode($sales_plan->ship_id) : [];
            $customer_ids = $sales_plan->customer_id != null ? json_decode($sales_plan->customer_id) : [];

            $max_ship_ids = count($ship_ids);
            $max_customer_ids = count($customer_ids);

            $count_ship_id = 1;
            $count_customer_id = 1;
            foreach ($ship_ids as $ship_id) {
                $ship_ref = Ship::find($ship_id);
                if($count_ship_id == $max_ship_ids){
                    $ship .= $ship_ref->type;
                }else{
                    $ship .= $ship_ref->type.", ";
                }

                $count_ship_id++;
            }

            foreach ($customer_ids as $customer_id) {
                $customer_ref = Customer::find($customer_id);
                if($count_customer_id == $max_customer_ids){
                    $customer .= $customer_ref->name;
                }else{
                    $customer .= $customer_ref->name.", ";
                }

                $count_customer_id++;
            }
            $sales_plans->put($sales_plan->month,[
                "id" =>$sales_plan->id,
                "month" => $sales_plan->month,
                "ship" => $ship,
                "ship_ids" => $ship_ids,
                "customer" => $customer,
                "customer_ids" => $customer_ids,
                "value" => $sales_plan->value,
            ]);

        }

        $data_init = Collection::make();
        for ($i=0; $i < 12; $i++) {
            if(isset($sales_plans[$i+1])){
                $data_init->push($sales_plans[$i+1]);
            }else{
                $data_init->push([
                    "id" => null,
                    "month" => $i+1,
                    "ship" => "",
                    "ship_ids" => [],
                    "customer" => "",
                    "customer_ids" => [],
                    "value" => 0,
                ]);
            }
        }

        return response($data_init, Response::HTTP_OK);
    }
}
