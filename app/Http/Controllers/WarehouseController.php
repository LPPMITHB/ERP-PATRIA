<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;

class WarehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::all();

        return view ('warehouse.index', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouse = new Warehouse;
        $users = User::where('type','2')->get();
        $warehouse_code = self::generateWarehouseCode();

        return view('warehouse.create', compact('warehouse','warehouse_code', 'users'));
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
            'code' => 'required|alpha_dash|unique:mst_warehouse|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try{
        $warehouse = new Warehouse;
        $warehouse->code = strtoupper($request->input('code'));
        $warehouse->name = ucwords($request->input('name'));
        $warehouse->description = $request->input('description');
        $warehouse->pic = $request->input('pic');
        $warehouse->status = $request->input('status');
        $warehouse->branch_id = Auth::user()->branch->id;
        $warehouse->user_id = Auth::user()->id;
        $warehouse->save();

        DB::commit();
            return redirect()->route('warehouse.show',$warehouse->id)->with('success', 'Success Create New Warehouse!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('warehouse.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $pic = User::findOrFail($warehouse->pic);

        return view('warehouse.show', compact('warehouse','pic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $users = User::where('type','2')->get();

        return view('warehouse.create', compact('warehouse','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_warehouse,code,'.$id.',id|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try{
        $warehouse = Warehouse::find($id);
        $warehouse->code = strtoupper($request->input('code'));
        $warehouse->name = ucwords($request->input('name'));
        $warehouse->description = $request->input('description');
        $warehouse->pic = $request->input('pic');
        $warehouse->status = $request->input('status');
        $warehouse->save();

        DB::commit();
            return redirect()->route('warehouse.show',$warehouse->id)->with('success', 'Success Edit Warehouse');
        } catch (\Exception $e) {
        DB::rollback();
            return redirect()->route('warehouse.update')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warehouse = Warehouse::find($id);

        try {
            $warehouse->delete();
            return redirect()->route('warehouse.index')->with('status', 'Warehouse Deleted Succesfully!');
        } catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('warehouse.index')->with('status', 'Can\'t Delete The Warehouse Because It Still Exists');
        }
    }

    public function generateWarehouseCode(){
        $code = 'WRH';
        $modelWarehouse = Warehouse::orderBy('code', 'desc')->first();

        $number = 1;
		if(isset($modelWarehouse)){
            $number += intval(substr($modelWarehouse->code, -4));
		}

        $warehouse_code = $code.''.sprintf('%04d', $number);
		return $warehouse_code;
	}
}
