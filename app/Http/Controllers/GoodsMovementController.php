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
    public function index()
    {
        $modelWarehouse = Warehouse::where('status',1)->get();
        $modelSloc = StorageLocation::where('status',1)->with('storageLocationDetails')->get();

        return view ('goods_movement.index', compact('modelWarehouse','modelSloc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            return redirect()->route('goods_movement.show',$GM->id)->with('success', 'Goods Movement Success');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('goods_movement.index')->with('error', $e->getMessage());
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
                    $modelSLDTo->reserved = 0;
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
        $sld = StorageLocationDetail::where('storage_location_id',$id)->with('material')->get()->jsonSerialize();

        return response($sld, Response::HTTP_OK);
    }

    public function generateGMNumber(){
        $modelGM = GoodsMovement::orderBy('created_at','desc')->where('branch_id',Auth::user()->branch_id)->first();
        $modelBranch = Branch::where('id', Auth::user()->branch_id)->first();

        $branch_code = substr($modelBranch->code,4,2);
        $number = 1;
        if(isset($modelGM)){
            $number += intval(substr($modelGM->number, -6));
        }
        $year = date('y'.$branch_code.'000000');
        $year = intval($year);

        $gm_number = $year+$number;
        $gm_number = 'GM-'.$gm_number;
        return $gm_number;
    }
}
