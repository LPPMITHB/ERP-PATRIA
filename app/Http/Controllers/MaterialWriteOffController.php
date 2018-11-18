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
    public function create()
    {
        $materials = Material::all();
        $storageLocations = StorageLocation::where('status',1)->get();

        return view('material_write_off.create', compact('materials','storageLocations'));
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
        
        $number = $this->generateGINumber();

        DB::beginTransaction();
        try{

            $MWO = new GoodsIssue;
            $MWO->number = $number;
            $MWO->description = $datas->description;
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

                $this->updateSlocDetail($data);
                $this->updateStock($data);
            }
            DB::commit();
            return redirect()->route('goods_issue.show',$MWO->id)->with('success', 'Material Write Off Created');
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('material_write_off.create')->with('error', $e->getMessage());
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

    public function destroy($id)
    {
        
    }

    public function generateGINumber(){
        $modelGI = GoodsIssue::orderBy('created_at','desc')->where('branch_id',Auth::user()->branch_id)->first();
        $modelBranch = Branch::where('id', Auth::user()->branch_id)->first();

        $branch_code = substr($modelBranch->code,4,2);
        $number = 1;
        if(isset($modelGI)){
            $number += intval(substr($modelGI->number, -6));
        }
        $year = date('y'.$branch_code.'000000');
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


