<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\EstimatorProfile;
use App\Models\EstimatorProfileDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use DB;
use Auth;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $route = $request->route()->getPrefix();
        $quotation = new Quotation;
        $customers = Customer::where('status',1)->get(); 
        $profiles = EstimatorProfile::where('status',1)->with('ship','estimatorProfileDetails','estimatorProfileDetails.estimatorCostStandard','estimatorProfileDetails.estimatorCostStandard.estimatorWbs','estimatorProfileDetails.estimatorCostStandard.uom')->get();

        return view('quotation.create', compact('quotation','route','profiles','customers'));
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
        $qt_number = $this->generateQTNumber();
        
        DB::beginTransaction();
        try {
            $quotation = new Quotation;
            $quotation->code = $qt_number;
            $quotation->profile_id = $data->profile_id;
            $quotation->customer_id = ($data->customer_id != "") ? $data->customer_id : null;
            $quotation->description = $data->description;
            $quotation->price = 0;
            $quotation->total_price = 0;
            $quotation->margin = $data->margin;
            $quotation->status = 1;
            $quotation->terms_of_payment = json_encode($data->top);
            $quotation->user_id = Auth::user()->id;
            $quotation->branch_id = Auth::user()->branch->id;

            if(!$quotation->save()){
                if($route == "/quotation"){
                    return redirect()->route('quotation.create')->with('error', 'Failed Save Quotation !');
                }elseif($route == "/quotation_repair"){
                    return redirect()->route('quotation_repair.create')->with('error', 'Failed Save Quotation !');
                }
            }else{
                foreach($data->pd[0]->estimator_profile_details as $pd){
                    $qd = new QuotationDetail;
                    $qd->quotation_id = $quotation->id;
                    $qd->cost_standard_id = $pd->estimator_cost_standard->id;
                    $qd->value = $pd->value;
                    $qd->price = $pd->total_price / $pd->value;
                    $qd->save();
                }
                DB::commit();
                if($route == "/quotation"){
                    return redirect()->route('quotation.show', ['id' => $quotation->id])->with('success', 'Quotation Created');
                }elseif($route == "/quotation_repair"){
                    return redirect()->route('quotation_repair.show', ['id' => $quotation->id])->with('success', 'Quotation Created');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/quotation"){
                return redirect()->route('quotation.create')->with('error', $e->getMessage());
            }elseif($route == "/quotation_repair"){
                return redirect()->route('quotation_repair.create')->with('error', $e->getMessage());
            }
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
    public function generateQTNumber()
    {
        $modelQT = Quotation::orderBy('created_at', 'desc')->first();
        $yearNow = date('y');

        $number = 1;
        if (isset($modelQT)) {
            $yearDoc = substr($modelQT->number, 3, 2);
            if ($yearNow == $yearDoc) {
                $number += intval(substr($modelQT->number, -5));
            }
        }

        $year = date($yearNow . '00000');
        $year = intval($year);

        $qt_number = $year + $number;
        $qt_number = 'QT-' . $qt_number;

        return $qt_number;
    }
}
