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
    public function index(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelQTs = Quotation::all();

        return view('quotation.index', compact('modelQTs', 'route'));
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
            $quotation->number = $qt_number;
            $quotation->profile_id = $data->profile_id;
            $quotation->customer_id = ($data->customer_id != "") ? $data->customer_id : null;
            $quotation->description = $data->description;
            $quotation->price = $data->price;
            $quotation->total_price = $data->total_price;
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
    public function show(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelQT = Quotation::findOrFail($id);
        if ($modelQT->status == 1) {
            $statusQT = 'OPEN';
        } elseif ($modelQT->status == 0) {
            $statusQT = 'CONVERTED TO SO';
        } elseif ($modelQT->status == 2) {
            $statusQT = 'CANCELED';
        }

        $wbs = [];
        foreach($modelQT->quotationDetails as $qd){
            array_push($wbs,$qd->estimatorCostStandard->estimatorWbs);
        }
        $wbs = array_unique($wbs);
        $tops = json_decode($modelQT->terms_of_payment);

        return view('quotation.show', compact('route', 'modelQT', 'statusQT','wbs','tops'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $quotation = Quotation::where('id',$id)->with('quotationDetails','quotationDetails.estimatorCostStandard','quotationDetails.estimatorCostStandard.estimatorWbs','quotationDetails.estimatorCostStandard.uom')->first();
        $customers = Customer::where('status',1)->get(); 
        $profiles = EstimatorProfile::where('status',1)->with('ship','estimatorProfileDetails','estimatorProfileDetails.estimatorCostStandard','estimatorProfileDetails.estimatorCostStandard.estimatorWbs','estimatorProfileDetails.estimatorCostStandard.uom')->get();

        return view('quotation.create', compact('quotation','route','profiles','customers'));
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
        $route = $request->route()->getPrefix();
        $data = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $quotation = Quotation::findOrFail($data->pd->id);
            $quotation->customer_id = ($data->customer_id != "") ? $data->customer_id : null;
            $quotation->description = $data->description;
            $quotation->price = $data->price;
            $quotation->total_price = $data->total_price;
            $quotation->margin = $data->margin;
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
                foreach($data->pd->quotation_details as $qd){
                    $quotation_detail = QuotationDetail::findOrFail($qd->id);
                    $quotation_detail->value = $qd->value;
                    $quotation_detail->save();
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
                return redirect()->route('quotation.edit', ['id' => $quotation->id])->with('error', $e->getMessage());
            }elseif($route == "/quotation_repair"){
                return redirect()->route('quotation_repair.edit', ['id' => $quotation->id])->with('error', $e->getMessage());
            }
        }
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
