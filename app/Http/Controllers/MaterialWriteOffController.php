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
use App\Models\Branch;
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
        $modelWriteOffs = GoodsIssue::where('type', 5)->get();

        return view('material_write_off.index', compact('modelWriteOffs','route'));

    }

    public function indexApprove(Request $request)
    {
        $route = $request->route()->getPrefix();    
        if($route == "/material_write_off"){
            $modelGIs = GoodsIssue::whereIn('status',[1,4])->where('business_unit_id',1)->get();
        }elseif($route == "/material_write_off_repair"){
            $modelGIs = GoodsIssue::whereIn('status',[1,4])->where('business_unit_id',2)->get();
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
        $number = $this->generateGINumber();

        DB::beginTransaction();
        try{

            $MWO = new GoodsIssue;
            $MWO->number = $number;
            $MWO->description = $datas->description;
            if($menu == "building"){
                $MWO->business_unit_id = 1;
            }else if($menu == "repair"){
                $MWO->business_unit_id = 2;
            }
            $MWO->type = 5;
            $MWO->status = 1;
            $MWO->user_id = Auth::user()->id;
            $MWO->branch_id = Auth::user()->branch->id;
            $MWO->save();

            foreach($datas->materials as $data){
                $MWOD = new GoodsIssueDetail;
                $MWOD->goods_issue_id = $MWO->id;
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
        $modelGI = GoodsIssue::findOrFail($id);
        $modelGID = $modelGI->GoodsIssueDetails;

        return view('material_write_off.show', compact('modelGI','modelGID','route'));
    }

    public function showApprove($id, Request $request)
    {
        $route = $request->route()->getPrefix();    
        $modelGI = GoodsIssue::findOrFail($id);
        $modelGID = $modelGI->GoodsIssueDetails;

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
        $modelGI = GoodsIssue::findOrFail($id);
        $modelGID = $modelGI->GoodsIssueDetails;   

        $materials = Material::all();
        $storageLocations = StorageLocation::where('status',1)->get();

        $materials = Collection::make();
        foreach($modelGID as $gid){
            $materials->push([
                "gid_id" =>$gid->id,
                "sloc_id" =>$gid->storage_location_id,
                "sloc_name" => $gid->storageLocation->name,
                "material_id" => $gid->material_id,
                "material_code" => $gid->material->code,
                "material_name" => $gid->material->description,
                "quantity" => $gid->quantity."",
                "quantityInt" => $gid->quantity,
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
        $MWO = GoodsIssue::find($id);

        DB::beginTransaction();
        try{

            $MWO->description = $datas->description;
            if($MWO->status == 3){
                $MWO->status = 4;
            }
            $MWO->update();

            if(count($datas->gid_deleted)>0){
                foreach($datas->gid_deleted as $gid_id){
                    $gid = GoodsIssueDetail::find($gid_id);
                    $gid->delete();
                }
            }
            foreach($datas->materials as $data){
                if(isset($data->gid_id)){
                    $MWOD = GoodsIssueDetail::find($data->gid_id);
                    $MWOD->material_id = $data->material_id;
                    $MWOD->quantity = $data->quantity;
                    $MWOD->storage_location_id = $data->sloc_id;
                    $MWOD->update();
                }else{
                    $MWOD = new GoodsIssueDetail;
                    $MWOD->goods_issue_id = $MWO->id;
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

    public function approval($gi_id,$status, Request $request){
        $modelGI = GoodsIssue::findOrFail($gi_id);
        
        if($status == "approve"){
            $modelGI->status = 2;
            foreach($modelGI->goodsIssueDetails as $data){
                $this->updateSlocDetailApproved($data);
                $this->updateStockApproved($data);
            }
            $modelGI->update();
        }elseif($status == "need-revision"){
            $modelGI->status = 3;
            $modelGI->update();
        }elseif($status == "reject"){
            $modelGI->status = 4;
            $modelGI->update();
        }

        $menu = $request->route()->getPrefix() == "/material_write_off" ? "building" : "repair";    
        if($menu == "building"){
            return redirect()->route('material_write_off.show',$gi_id)->with('success', 'Material Write Off Updated');
        }elseif($menu == "repair"){
            return redirect()->route('material_write_off_repair.show',$gi_id)->with('success', 'Material Write Off Updated');
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
        $materials = StorageLocationDetail::where('storage_location_id',$id)->where('quantity','>','0')->with('material')->get();
        foreach($materials as $material){
            $material['selected'] = false;
        }
        
        return response($materials, Response::HTTP_OK);
    }

    public function getMaterialsApi($id){
        
        return response(Material::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getSlocApi($id){
        
        return response(StorageLocation::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }



}


