<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\StorageLocation;
use App\Models\StorageLocationDetail;
use App\Models\Warehouse;
use App\Models\GoodsMovement;
use App\Models\GoodsMovementDetail;
use App\Models\Branch;
use Auth;
use DB;

class GoodsMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelGMs = GoodsMovement::all();

        return view('goods_movement.index', compact('modelGMs','route'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelWarehouse = Warehouse::where('status',1)->get();
        $modelSloc = StorageLocation::where('status',1)->with('storageLocationDetails')->get();
        
        return view ('goods_movement.create', compact('modelWarehouse','modelSloc','route'));
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
        $datas = json_decode($request->datas);
        $gm_number = $this->generateGMNumber();
        DB::beginTransaction();
        try {
            $GM = new GoodsMovement;
            $GM->number = $gm_number;
            $GM->description = $datas->dataHeader->description;
            $GM->storage_location_from_id = $datas->dataHeader->sloc_from_id;
            $GM->storage_location_to_id = $datas->dataHeader->sloc_to_id;
            $GM->user_id = Auth::user()->id;
            $GM->branch_id = Auth::user()->branch->id;
            $GM->save();

            foreach($datas->dataSLD as $SLD){
                if($SLD->quantity != ""){
                    $GMD = new GoodsMovementDetail;
                    $GMD->material_id = $SLD->material_id;
                    $GMD->quantity = $SLD->quantity;
                    $GMD->goods_movement_id = $GM->id;
                    $GMD->save();
                }
            }
            $this->updateSloc($datas->dataSLD,$datas->dataHeader->sloc_to_id);
            DB::commit();
            if($route == "/goods_movement"){
                return redirect()->route('goods_movement.show',$GM->id)->with('success', 'Goods Movement Success');
            }elseif($route == "/goods_movement_repair"){
                return redirect()->route('goods_movement_repair.show',$GM->id)->with('success', 'Goods Movement Success');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/goods_movement"){
                return redirect()->route('goods_movement.index')->with('error', $e->getMessage());
            }elseif($route == "/goods_movement_repair"){
                return redirect()->route('goods_movement_repair.index')->with('error', $e->getMessage());
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
        $modelGM = GoodsMovement::findOrFail($id);
        
        return view ('goods_movement.show', compact('modelGM'));
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
    public function updateSloc($datas,$sloc_to_id){
        foreach($datas as $data){
            if($data->quantity != ""){
                $modelSLDFrom = StorageLocationDetail::where('id',$data->id)->where('material_id',$data->material_id)->first();
                $modelSLDFrom->quantity -= $data->quantity;
                $modelSLDFrom->save();

                $modelSLDTo = StorageLocationDetail::where('storage_location_id',$sloc_to_id)->where('material_id',$data->material_id)->first();
                if($modelSLDTo){
                    $modelSLDTo->quantity += $data->quantity;
                    $modelSLDTo->save();
                }else{
                    $modelSLDTo = new StorageLocationDetail;
                    $modelSLDTo->material_id = $data->material_id;
                    $modelSLDTo->quantity = $data->quantity;
                    $modelSLDTo->storage_location_id = $sloc_to_id;
                    $modelSLDTo->save();
                }
            }
        }
    }

    public function getSlocAPI($id){
        $sloc = StorageLocation::where('status',1)->where('warehouse_id',$id)->get()->jsonSerialize();

        return response($sloc, Response::HTTP_OK);
    }

    public function getSlocToAPI($datas){
        $data = json_decode($datas);

        $sloc = StorageLocation::where('status',1)->where('warehouse_id',$data->warehouse_id)->whereNotIn('id',[$data->sloc_from_id])->get()->jsonSerialize();

        return response($sloc, Response::HTTP_OK);
    }

    public function getSlocDetailAPI($id){
        $sld = StorageLocationDetail::where('storage_location_id',$id)->with('material','material.uom')->get();
        foreach($sld as $key => $data){
            if($data->quantity < 1){
                unset($data[$key]);
            }
        }

        return response($sld, Response::HTTP_OK);
    }

    public function generateGMNumber(){
        $modelGM = GoodsMovement::orderBy('created_at','desc')->first();
        $yearNow = date('y');

        $number = 1;
        if(isset($modelGM)){
            $yearDoc = substr($modelGM->number, 3,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelGM->number, -6));
            }
        }

        $year = date($yearNow.'000000');
        $year = intval($year);

        $gm_number = $year+$number;
        $gm_number = 'GM-'.$gm_number;

        return $gm_number;
    }
}
