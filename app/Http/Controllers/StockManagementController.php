<?php

namespace App\Http\Controllers;

use App\Models\StorageLocation;
use App\Models\StorageLocationDetail;
use App\Models\Material;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Auth;
use DB;

class StockManagementController extends Controller
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
        $warehouses = Warehouse::all();
        $materials = Material::all();
        return view('stock_management.index', compact('storage_locations','materials','warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

   
    public function show($id)
    {
        
    }

   
    public function edit($id)
    {
        
    }

    
    public function update(Request $request, $id)
    {
        
      
    }

    
    public function destroy($id)
    {
        
    }

    public function getSlocApi($id){
        $data = array();
        
        $sloc = StorageLocation::where('id',$id)->first();
        $slocDetails = StorageLocationDetail::where('storage_location_id',$sloc->id)->with('material')->get();
        $data['sloc'] = $sloc;
        $data['slocDetail'] = $slocDetails;
        
        $inventory_value = 0;
        $inventory_qty = 0;

        foreach($slocDetails as $slocDetail){
            $inventory_value += $slocDetail->material->cost_standard_price * $slocDetail->quantity;
            $inventory_qty += $slocDetail->quantity;
        }

        $inventory_value = number_format($inventory_value);
        $inventory_qty = number_format($inventory_qty);

        $data['sloc'] = $sloc;
        $data['slocDetail'] = $slocDetails;
        $data['slocValue'] = $inventory_value;
        $data['slocQuantity'] = $inventory_qty;
        
        return response($data, Response::HTTP_OK);
    }

    public function getWarehouseInfoSM($id){
        $data = array();
        
        $warehouse = Warehouse::where('id',$id)->first();
        $slocs = $warehouse->storageLocations;

        $inventory_value = 0;
        $inventory_qty = 0;

        foreach($slocs as $sloc){
            $slocDetails = $sloc->storageLocationDetails;
            foreach($slocDetails as $slocDetail){
                $inventory_value += $slocDetail->material->cost_standard_price * $slocDetail->quantity;
                $inventory_qty += $slocDetail->quantity;
            }
        }

        $inventory_value = number_format($inventory_value);
        $inventory_qty = number_format($inventory_qty);

        $data['sloc'] = $slocs;
        $data['warehouseValue'] = $inventory_value;
        $data['warehouseQuantity'] = $inventory_qty;
        return response($data, Response::HTTP_OK);
    }    
   
}
