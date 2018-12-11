<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uom;
use Auth;
use DB;

class UnitOfMeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uoms = Uom::all();

        return view('unit_of_measurement.index', compact('uoms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $uom = new Uom;
        $uom_code = self::generateUomCode();

        return view('unit_of_measurement.create', compact('uom', 'uom_code'));

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
            'code' => 'required|alpha_dash|unique:mst_uom|string|max:255',
            'name' => 'required|string|max:255'
        ]);

        DB::beginTransaction();
        try {
        $uom = new Uom;
        $uom->code = strtoupper($request->input('code'));
        $uom->name = ucwords($request->input('name'));
        $uom->unit = $request->input('unit');
        $uom->status = $request->input('status');
        $uom->user_id = Auth::user()->id;
        $uom->branch_id = Auth::user()->branch->id;
        $uom->save();

        DB::commit();
        return redirect()->route('unit_of_measurement.show',$uom->id)->with('success', 'Success Created New Unit Of Measurement!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('unit_of_measurement.create')->with('error', $e->getMessage());
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
        $uom = Uom::findOrFail($id);
        
        return view('unit_of_measurement.show', compact('uom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $uom = Uom::findOrFail($id);

        return view('unit_of_measurement.create', compact('uom'));
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
            'code' => 'required|alpha_dash|unique:mst_uom,code,'.$id.',id|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
        $uom = Uom::find($id);
        $uom->code = strtoupper($request->input('code'));
        $uom->name = ucwords($request->input('name'));
        $uom->unit = $request->input('unit');
        $uom->status = $request->input('status');
        $uom->update();

        DB::commit();
        return redirect()->route('unit_of_measurement.show',$uom->id)->with('success', 'Unit Of Measurement Updated Succesfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('unit_of_measurement.update',$uom->id)->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {

    }

    public function generateUomCode(){
        $code = 'UOM';
        $modelUnitOfMeasurement = Uom::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelUnitOfMeasurement)){
            $number += intval(substr($modelUnitOfMeasurement->code, -4));
		}

        $uom_code = $code.''.sprintf('%04d', $number);
		return $uom_code;
	}
}
