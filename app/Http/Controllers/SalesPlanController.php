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

class SalesPlanController extends Controller
{
    public function index(Request $request)
    {
        $route = $request->route()->getPrefix();
        $user_id = Auth::user()->id;
        $years = array();
        // $sales_plans = SalesPlan::where('user_id',$user_id)->get();
        $data_init = Collection::make();
        $this_year = date("Y");
        for ($i=0; $i < 5; $i++) { 
            array_push($years,$this_year+$i);
        }

        for ($j=0; $j < 12; $j++) { 
            $data_init->push([
                "month" => $j+1,
                "ship" => "",
                "customer" => 1,
                "value" => 0,
            ]);
        }


        return view('sales_plan.index', compact('data_init','this_year','route','user_id','years'));

    }

    //API 
    public function getSalesPlanAPI($year){
        $user_id = Auth::user()->id;
        $sales_plans_ref = SalesPlan::where('user_id',$user_id)->where('year',$year)->get();
        $sales_plans = Collection::make();

        foreach ($sales_plans_ref as $sales_plan) {
            $ship = "";
            $customer = "";
            
            $ship_ids = json_decode($sales_plan->ship_id);
            $customer_ids = json_decode($sales_plan->customer_id);

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
                "month" => $sales_plan->month,
                "ship" => $ship,
                "customer" => $customer,
                "value" => 0,
            ]);

        }

        $data_init = Collection::make();
        for ($i=0; $i < 12; $i++) {
            if(isset($sales_plans[$i])){
                $data_init->push($sales_plans[$i]);
            }else{
                $data_init->push([
                    "month" => $i+1,
                    "ship" => "",
                    "customer" => "",
                    "value" => 0,
                ]);
            }
        }

        return response($data_init, Response::HTTP_OK);
    }
}
