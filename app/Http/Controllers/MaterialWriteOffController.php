<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Material;
use App\Models\StorageLocationDetail;
use App\Models\Stock;
use App\Models\StorageLocation;
use App\Models\GoodsIssue;
use App\Models\GoodsIssueDetail;
use App\Models\MaterialWriteOff;
use App\Models\MaterialWriteOffDetail;
use App\Models\Branch;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Auth;
use DB;

class MaterialWriteOffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $route = $request->route()->getPrefix();    
        $modelWriteOffs = MaterialWriteOff::all();

        return view('material_write_off.index', compact('modelWriteOffs','route'));

    }

    public function indexApprove(Request $request)
    {
        $route = $request->route()->getPrefix();    
        if($route == "/material_write_off"){
            $modelGIs = MaterialWriteOff::whereIn('status',[1,4])->where('business_unit_id',1)->get();
        }elseif($route == "/material_write_off_repair"){
            $modelGIs = MaterialWriteOff::whereIn('status',[1,4])->where('business_unit_id',2)->get();
        }

        return view('material_write_off.indexApprove', compact('modelGIs','route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $menu = $request->route()->getPrefix() == "/material_write_off" ? "building" : "repair";    
        $materials = Material::all();
        $storageLocations = StorageLocation::where('status',1)->get();

        return view('material_write_off.create', compact('materials','storageLocations','menu'));
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
        $menu = $request->route()->getPrefix() == "/material_write_off" ? "building" : "repair";    
        $number = $this->generateMWONumber();

        DB::beginTransaction();
        try{

            $MWO = new MaterialWriteOff;
            $MWO->number = $number;
            $MWO->description = $datas->description;
            if($menu == "building"){
                $MWO->business_unit_id = 1;
            }else if($menu == "repair"){
                $MWO->business_unit_id = 2;
            }
            $MWO->user_id = Auth::user()->id;
            $MWO->branch_id = Auth::user()->branch->id;
            $MWO->save();

            foreach($datas->materials as $data){
                $MWOD = new MaterialWriteOffDetail;
                $MWOD->material_write_off_id = $MWO->id;
                $MWOD->quantity = $data->quantity;
                $MWOD->material_id = $data->material_id;
                $MWOD->storage_location_id = $data->sloc_id;
                $MWOD->save();
            }

            DB::commit();
            if($menu == "building"){
                return redirect()->route('material_write_off.show',$MWO->id)->with('success', 'Material Write Off Created');
            }else{
                return redirect()->route('material_write_off_repair.show',$MWO->id)->with('success', 'Material Write Off Created');
            }
        }catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('material_write_off.create')->with('error', $e->getMessage());
            }else{
                return redirect()->route('material_write_off_repair.create')->with('error', $e->getMessage());
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $route = $request->route()->getPrefix();    
        $modelMWO = MaterialWriteOff::findOrFail($id);
        $modelMWOD = $modelMWO->materialWriteOffDetails;

        return view('material_write_off.show', compact('modelMWO','modelMWOD','route'));
    }

    public function showApprove($id, Request $request)
    {
        $route = $request->route()->getPrefix();    
        $modelGI = MaterialWriteOff::findOrFail($id);
        $modelGID = $modelGI->materialWriteOffDetails;

        return view('material_write_off.showApprove', compact('modelGI','modelGID','route'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $route = $request->route()->getPrefix();    
        $modelGI = MaterialWriteOff::findOrFail($id);
        $modelGID = $modelGI->MaterialWriteOffDetails;   

        $materials = Material::with('uom')->get();
        $storageLocations = StorageLocation::where('status',1)->with('storageLocationDetails.material.uom')->get();

        $materials = Collection::make();
        foreach($modelGID as $gid){
            $materials->push([
                "gid_id" =>$gid->id,
                "sloc_id" =>$gid->storage_location_id,
                "sloc_name" => $gid->storageLocation->name,
                "material_id" => $gid->material_id,
                "material_code" => $gid->material->code,
                "material_name" => $gid->material->description,
                "unit" => $gid->material->uom->unit,
                "is_decimal" => $gid->material->uom->is_decimal,
                "quantity" => $gid->quantity."",
                "available" => $gid->storageLocation->storageLocationDetails->where('material_id',$gid->material_id)->first()->quantity,
            ]);
        }

        return view('material_write_off.edit', compact('modelGI','materials','materials','storageLocations','route'));
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
        $datas = json_decode($request->datas);
        $menu = $request->route()->getPrefix() == "/material_write_off" ? "building" : "repair";    
        $MWO = MaterialWriteOff::find($id);

        DB::beginTransaction();
        try{

            $MWO->description = $datas->description;
            if($MWO->status == 3){
                $MWO->status = 4;
            }
            $MWO->update();

            if(count($datas->gid_deleted)>0){
                foreach($datas->gid_deleted as $gid_id){
                    $gid = MaterialWriteOffDetail::find($gid_id);
                    $gid->delete();
                }
            }
            foreach($datas->materials as $data){
                if(isset($data->gid_id)){
                    $MWOD = MaterialWriteOffDetail::find($data->gid_id);
                    $MWOD->material_id = $data->material_id;
                    $MWOD->quantity = $data->quantity;
                    $MWOD->storage_location_id = $data->sloc_id;
                    $MWOD->update();
                }else{
                    $MWOD = new MaterialWriteOffDetail;
                    $MWOD->material_write_off_id = $MWO->id;
                    // $MWOD->goods_issue_id = $MWO->id;
                    $MWOD->quantity = $data->quantity;
                    $MWOD->material_id = $data->material_id;
                    $MWOD->storage_location_id = $data->sloc_id;
                    $MWOD->save();
                }
            }
            DB::commit();
            if($menu == "building"){
                return redirect()->route('material_write_off.show',$MWO->id)->with('success', 'Material Write Off Updated');
            }else{
                return redirect()->route('material_write_off_repair.show',$MWO->id)->with('success', 'Material Write Off Updated');
            }
        }catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('material_write_off.edit',$MWO->id)->with('error', $e->getMessage());
            }else{
                return redirect()->route('material_write_off_repair.edit',$MWO->id)->with('error', $e->getMessage());
            }
        }
            
    }

    public function approval(Request $request){

        $datas = json_decode($request->datas);
        $menu = $request->route()->getPrefix() == "/material_write_off" ? "building" : "repair";   
        $gi_number = $this->generateGINumber();
        
        DB::beginTransaction();
        try {
            $modelMWO = MaterialWriteOff::findOrFail($datas->mwo_id);
            $modelMWOD = MaterialWriteOffDetail::where('material_write_off_id',$modelMWO->id)->get();

            if($datas->status == "approve"){
                $modelMWO->status = 2;
                $modelMWO->approved_by = Auth::user()->id;
                $modelMWO->approval_date = Carbon::now();
                $modelMWO->update();

                $GI = new GoodsIssue;
                $GI->number = $gi_number;
                $GI->material_write_off_id = $modelMWO->id;
                $GI->description = $modelMWO->description;
                if($menu ==  "building"){
                    $GI->business_unit_id = 1;
                }elseif($menu == "repair"){
                    $GI->business_unit_id = 2;
                }
                $GI->type = 5;
                $GI->branch_id = Auth::user()->branch->id;
                $GI->user_id = Auth::user()->id;
                $GI->save();

                foreach($modelMWO->materialWriteOffDetails as $data){

                    $GID = new GoodsIssueDetail;
                    $GID->goods_issue_id = $GI->id;
                    $GID->quantity = $data->quantity;
                    $GID->material_id = $data->material_id;
                    $GID->storage_location_id = $data->storage_location_id;
                    $GID->save();

                    $this->updateSlocDetailApproved($data);
                    $this->updateStockApproved($data);
                }

            }elseif($datas->status == "need-revision"){
                $modelMWO->status = 3;
                $modelMWO->update();
            }elseif($datas->status == "reject"){
                $modelMWO->status = 4;
                $modelMWO->approved_by = Auth::user()->id;
                $modelMWO->approval_date = Carbon::now();
                $modelMWO->update();
            }
            
            DB::commit();
            if($menu == "building"){
                return redirect()->route('material_write_off.show',$datas->mwo_id)->with('success', 'Material Write Off Updated');
            }elseif($menu == "repair"){
                return redirect()->route('material_write_off_repair.show',$datas->mwo_id)->with('success', 'Material Write Off Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($menu == "building"){
                return redirect()->route('material_write_off.show',$datas->mwo_id)->with('error', $e->getMessage());
            }elseif($menu == "repair"){
                return redirect()->route('material_write_off_repair.show',$datas->mwo_id)->with('error', $e->getMessage());
            }
        }

    }

    public function destroy($id)
    {
        
    }

    public function generateGINumber(){
        $modelGI = GoodsIssue::orderBy('created_at','desc')->first();
        $yearNow = date('y');
        
		$number = 1;
        if(isset($modelGI)){
            $yearDoc = substr($modelGI->number, 3,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelGI->number, -5));
            }
        }

        $year = date($yearNow.'000000');
        $year = intval($year);

		$gi_number = $year+$number;
        $gi_number = 'GI-'.$gi_number;

        return $gi_number;
    }

    public function generateMWONumber(){
        $modelMWO = MaterialWriteOff::orderBy('created_at','desc')->first();
        $yearNow = date('y');
        
		$number = 1;
        if(isset($modelMWO)){
            $yearDoc = substr($modelMWO->number, 4,2);
            if($yearNow == $yearDoc){
                $number += intval(substr($modelMWO->number, -5));
            }
        }

        $year = date($yearNow.'000000');
        $year = intval($year);

		$mwo_number = $year+$number;
        $mwo_number = 'MWO-'.$mwo_number;

        return $mwo_number;
    }

    
    //Function
    public function updateStockApproved($data){
        $modelStock = Stock::where('material_id',$data->material_id)->first();
        $modelStock->quantity -= $data->quantity;
        $modelStock->save();
    }

    public function updateSlocDetailApproved($data){
        $modelSlocDetail = StorageLocationDetail::where('material_id',$data->material_id)->where('storage_location_id',$data->storage_location_id)->first();
        $modelSlocDetail->quantity -= $data->quantity;
        $modelSlocDetail->save();
    }

    public function getMaterialApi($id){
        $materials = StorageLocationDetail::where('storage_location_id',$id)->where('quantity','>','0')->with('material','material.uom')->get();
        foreach($materials as $material){
            $material['selected'] = false;
        }
        
        return response($materials, Response::HTTP_OK);
    }

    public function getMaterialsMWOApi($id){
        
        return response(Material::where('id',$id)->with('uom')->first()->jsonSerialize(), Response::HTTP_OK);
    }

    public function getSlocApi($id){
        
        return response(StorageLocation::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }



}


