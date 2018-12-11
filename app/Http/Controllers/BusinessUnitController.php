<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessUnit;
use Auth;
use DB;

class BusinessUnitController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $business_units = BusinessUnit::all();
        
        return view('business_unit.index', compact('business_units'));
    }

    public function create()
    {
        $business_unit = new BusinessUnit;
        
        return view('business_unit.create', compact('business_unit'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:mst_business_unit|max:255',
            'description' => 'required|string|max:255',  
        ]);

        DB::beginTransaction();
        try {
            $business_unit = new BusinessUnit;
            $business_unit->name = ucwords($request->input('name'));
            $business_unit->description = $request->input('description');
            $business_unit->status = $request->input('status');
            $business_unit->save();

            DB::commit();
            return redirect()->route('business_unit.index')->with('success', 'Success Created New Business Unit!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('business_unit.create')->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $business_unit = BusinessUnit::findOrFail($id);

        return view('business_unit.create', compact('business_unit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:mst_business_unit,name,'.$id.',id',
            'description' => 'required|string|max:255', 
        ]);

        DB::beginTransaction();
        try {
            $business_unit = BusinessUnit::find($id);
            $business_unit->name = ucwords($request->input('name'));
            $business_unit->description = $request->input('description');
            $business_unit->status = $request->input('status');
            $business_unit->update();

            DB::commit();
            return redirect()->route('business_unit.index')->with('success', 'Business Unit Updated Succesfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('business_unit.update',$business_unit->id)->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        //
    }
}
