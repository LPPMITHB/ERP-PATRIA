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
use Auth;
use DB;

class MaterialWriteOffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
            $MWO->status = 1;
            $MWO->type = 2;
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

                // $this->updateSlocDetail($data);
                // $this->updateStock($data);
            }
            DB::commit();
            if($menu == "building"){
                return redirect()->route('goods_issue.show',$MWO->id)->with('success', 'Material Write Off Created');
            }else{
                return redirect()->route('goods_issue_repair.show',$MWO->id)->with('success', 'Material Write Off Created');
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
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
       
            
    }
    
    public function approval($mwo_id,$status){
        $modelMWO = MaterialRequisition::findOrFail($mw_id);
        if($status == "approve"){
            $modelMR->status = 2;
            $modelMR->update();
        }elseif($status == "not-approve"){
            $modelMR->status = 3;
            $modelMR->update();
        }elseif($status == "reject"){
            $modelMR->status = 4;
            $modelMR->update();
        }
        return redirect()->route('material_requisition.show',$mr_id);
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

    public function updateStock($data){
        $modelStock = Stock::where('material_id',$data->material_id)->first();
        $modelStock->quantity -= $data->quantity;
        $modelStock->save();
    }

    public function updateSlocDetail($data){
        $modelSlocDetail = StorageLocationDetail::where('material_id',$data->material_id)->where('storage_location_id',$data->sloc_id)->first();
        $modelSlocDetail->quantity -= $data->quantity;
        $modelSlocDetail->save();
    }

    public function getMaterialApi($id){
        $materials = StorageLocationDetail::where('storage_location_id',$id)->with('material')->get();
        
        return response($materials, Response::HTTP_OK);
    }

    public function getMaterialsApi($id){
        
        return response(Material::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }

    public function getSlocApi($id){
        
        return response(StorageLocation::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);
    }



}


