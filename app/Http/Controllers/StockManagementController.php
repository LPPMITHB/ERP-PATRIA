<?php

namespace App\Http\Controllers;

use App\Models\StorageLocation;
use App\Models\StorageLocationDetail;
use App\Models\Material;
use App\Models\Warehouse;
use App\Models\Stock;
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
        $stocks = Stock::with('material','material.uom')->get();

        return view('stock_management.index', compact('storage_locations','materials','warehouses','stocks'));
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
        $slocDetails = StorageLocationDetail::where('storage_location_id',$sloc->id)->with('material','material.uom')->get();
        $data['sloc'] = $sloc;
        $data['slocDetail'] = $slocDetails;

        $inventory_value = 0;
        $inventory_qty = 0;

        foreach($slocDetails as $slocDetail){
            $inventory_value += $slocDetail->material->cost_standard_price * $slocDetail->quantity;
            $inventory_qty += $slocDetail->quantity;
        }

        $inventory_value = number_format($inventory_value,2);
        $inventory_qty = number_format($inventory_qty,2);

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
        $sloc_ids = $slocs->pluck('id')->toArray();

        $sloc_details = StorageLocationDetail::whereIn('storage_location_id',$sloc_ids);
        $inventory_value = DB::table('mst_storage_location_detail')
        ->join('mst_material', 'mst_material.id', '=', 'mst_storage_location_detail.material_id')
        ->select(DB::raw('sum(mst_storage_location_detail.quantity*mst_material.cost_standard_price) AS sum'))
        ->whereIn('mst_storage_location_detail.storage_location_id', $sloc_ids)
        ->first()->sum;
        // $inventory_value = 0;
        $inventory_qty = $sloc_details->sum('quantity');
        // foreach($slocs as $sloc){
        //     $slocDetails = $sloc->storageLocationDetails;
        //     foreach($slocDetails as $slocDetail){
        //         $inventory_value += $slocDetail->material->cost_standard_price * $slocDetail->quantity;
        //         $inventory_qty += $slocDetail->quantity;
        //     }
        // }

        $inventory_value = number_format($inventory_value,2);
        $inventory_qty = number_format($inventory_qty,2);

        $data['sloc'] = $slocs;
        $data['warehouseValue'] = $inventory_value;
        $data['warehouseQuantity'] = $inventory_qty;
        return response($data, Response::HTTP_OK);
    }

    public function getWarehouseStockSM($id){
        $warehouse = Warehouse::where('id',$id)->first();
        $slocs = $warehouse->storageLocations;
        $sloc_ids = $slocs->pluck('id')->toArray();

        $sloc_details = StorageLocationDetail::whereIn('storage_location_id',$sloc_ids)->with('material','material.uom')->get();

        return response($sloc_details, Response::HTTP_OK);
    }

    public function getStockInfoSM(){
        $data = array();
        $stocks = Stock::all();

        $inventory_value = 0;
        $inventory_qty = 0;
        $reserved_inventory_qty = 0;
        $available_qty = 0;

        foreach($stocks as $stock){
            $inventory_value += $stock->material->cost_standard_price * $stock->quantity;
            $inventory_qty += $stock->quantity;
            $reserved_inventory_qty += $stock->reserved;
            $available_qty += ($stock->quantity)-($stock->reserved);
        }

        $inventory_value = number_format($inventory_value,2);
        $inventory_qty = number_format($inventory_qty,2);
        $reserved_inventory_qty = number_format($reserved_inventory_qty,2);
        $available_qty = number_format($available_qty,2);

        $data['stockValue'] = $inventory_value;
        $data['stockQuantity'] = $inventory_qty;
        $data['reservedStockQuantity'] = $reserved_inventory_qty;
        $data['availableQuantity'] = $available_qty;
        return response($data, Response::HTTP_OK);
    }

}
