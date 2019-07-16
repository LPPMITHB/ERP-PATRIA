<?php

namespace App\Http\Controllers;

use App\Models\StorageLocation;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Auth;
use DB;

class StorageLocationController extends Controller
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
        $storage_locations = StorageLocation::all();

        return view ('storage_location.index', compact('storage_locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $storage_location = new StorageLocation;
        $storage_location_code = self::generateStorageLocationCode();

        $warehouses = Warehouse::all();
        return view('storage_location.create', compact('storage_location','storage_location_code','warehouses'));
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
            'code' => 'required|alpha_dash|unique:mst_storage_location|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try{
        $storage_location = new StorageLocation;
        $storage_location->code = strtoupper($request->input('code'));
        $storage_location->name = ucwords($request->input('name'));
        if($request->input('area') == null)
        {
            $storage_location->area = 0;
        }
        else {
            $storage_location->area = $request->input('area');
        }
        $storage_location->description = $request->input('description');
        $storage_location->status = $request->input('status');
        $storage_location->warehouse_id = $request->input('warehouse');
        $storage_location->branch_id = Auth::user()->branch->id;
        $storage_location->user_id = Auth::user()->id;
        $storage_location->save();

        DB::commit();
            return redirect()->route('storage_location.show',$storage_location->id)->with('success', 'Success Create New Storage Location!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('storage_location.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StorageLocation  $storage_location
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $storage_location = StorageLocation::findOrFail($id);



        return view('storage_location.show', compact('storage_location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StorageLocation  $storage_location
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $storage_location = StorageLocation::findOrFail($id);

        $warehouses = Warehouse::all();
        return view('storage_location.create', compact('storage_location','warehouses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StorageLocation  $storage_location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_storage_location,code,'.$id.',id|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',

        ]);

        DB::beginTransaction();
        try{
        $storage_location = StorageLocation::find($id);
        $storage_location->code = strtoupper($request->input('code'));
        $storage_location->name = ucwords($request->input('name'));
        if($request->input('area') == null)
        {
            $storage_location->area = 0;
        }
        else {
            $storage_location->area = $request->input('area');
        }
        $storage_location->description = $request->input('description');
        $storage_location->warehouse_id = $request->input('warehouse');
        $storage_location->status = $request->input('status');
        $storage_location->update();

        DB::commit();
            return redirect()->route('storage_location.show',$storage_location->id)->with('success', 'Success Edit Storage Location');
        } catch (\Exception $e) {
        DB::rollback();
            return redirect()->route('storage_location.update')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StorageLocation  $storage_location
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $storage_location = StorageLocation::find($id);

        try {
            $storage_location->delete();
            return redirect()->route('storage_location.index')->with('status', 'Storage Location Deleted Succesfully!');
        } catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('storage_location.index')->with('status', 'Can\'t Delete The Storage Location Because It Is Still Exist');
        }
    }

    public function generateStorageLocationCode(){
        $code = 'SL';
        $modelStorageLocation = StorageLocation::orderBy('code', 'desc')->first();

        $number = 1;
		if(isset($modelStorageLocation)){
            $number += intval(substr($modelStorageLocation->code, -4));
		}

        $storage_location_code = $code.''.sprintf('%04d', $number);
		return $storage_location_code;
	}
}
