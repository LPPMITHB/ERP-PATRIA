<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Uom;
use App\Models\Configuration;
use Illuminate\Support\Collection;
use Auth;
use DB;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = Material::where('status',1)->select('code','description','type','status','id')->get()->jsonSerialize();

        return view('material.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $material = new Material;
        $uoms = Uom::all();
        $material_families = Configuration::get('material_family');
        $densities = Configuration::get('density');

        return view('material.create', compact('material','uoms','material_families','densities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->datas);

        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_material|string|max:255',
            // 'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'cost_standard_price' => 'nullable',
            'cost_standard_price_service' => 'nullable',
            'weight' => 'nullable',
            'height' => 'nullable',
            'length' => 'nullable',
            'width' => 'nullable',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3000'
        ]);

        DB::beginTransaction();
        try {
            $material = new Material;
            $material->code = $data->code;
            // $material->name = $data->name;
            $material->description = $data->description;
            $material->cost_standard_price = $data->cost_standard_price == "" ? 0 : $data->cost_standard_price;

            if($data->dimension_uom_id != ""){
                $uom = Uom::where('id',$data->dimension_uom_id)->first();
                if($uom->unit == "M"){
                    $dataDensity = Configuration::get('density');
                    foreach($dataDensity as $density){
                        if($density->id == $data->density_id){
                            $value = $density->value;
                        }
                    }

                    $result = $data->lengths * $data->width * $data->height * $value;
                    $material->cost_standard_price_kg = 1/$result * $data->cost_standard_price;
                }else{
                    $material->cost_standard_price_kg = 0;
                }
            }

            $material->cost_standard_price_service = $data->cost_standard_service == "" ? 0 : $data->cost_standard_service;
            $material->uom_id = $data->uom_id;
            $material->min = $data->min == "" ? 0 : $data->min;
            $material->max = $data->max == "" ? 0 : $data->max;
            $material->weight = $data->weight;
            $material->weight_uom_id = $data->weight_uom_id == "" ? null : $data->weight_uom_id;
            $material->length = $data->lengths;
            $material->width = $data->width;
            $material->height = $data->height;
            $material->type = $data->type;
            $material->family_id = $data->family_id == "" ? null : json_encode($data->family_id);
            $material->density_id = $data->density_id == "" ? null : $data->density_id;
            $material->dimension_uom_id = $data->dimension_uom_id == "" ? null : $data->dimension_uom_id;
            $material->status = $data->status;
            if($request->hasFile('image')){
                // Get filename with the extension
                $fileNameWithExt = $request->file('image')->getClientOriginalName();
                // Get just file name
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('image')->getClientOriginalExtension();
                // File name to store
                $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                // Upload image
                $path = $request->file('image')->storeAs('documents/material',$fileNameToStore);
            }else{
                $fileNameToStore =  null;
            }
            $material->image = $fileNameToStore;
            $material->user_id = Auth::user()->id;
            $material->branch_id = Auth::user()->branch->id;
            $material->save();
        
        DB::commit();
        return redirect()->route('material.show',$material->id)->with('success', 'Success Created New Material!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('material.create')->with('error', $e->getMessage())->withInput();
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
        $material = Material::findOrFail($id);

        $dataFamily = Configuration::get('material_family');

        $arrayMaterialFamily = json_decode($material->family_id);

        $array = array();
        
        if($material->family_id != null){
            foreach($arrayMaterialFamily as $dataArray){
                foreach($dataFamily as $data){
                    if($data->id == $dataArray){
                        array_push($array,$data->name);
                    }
                }
            }
            $arrayFamily = implode(", ", $array);

        }else{
            $arrayFamily = null;
        }

        $dataDensity = Configuration::get('density');
        foreach($dataDensity as $data){
            if($data->id == $material->density_id){
                $nameDensity = $data->name;
                break;
            }else{
                $nameDensity = null;
            }
        }
        $uoms = Uom::all();

        $documents = Collection::make();
        $prds = $material->PurchaseRequisitionDetails;
        $pods = $material->PurchaseOrderDetails;
        $grds = $material->goodsReceiptDetails;
        $mrds = $material->materialRequisitionDetails;
        $gids = $material->goodsIssueDetails;
        $grtds = $material->goodsReturnDetails;
        $snds = $material->snapshotDetails;
        $mwods = $material->materialWriteOffDetails;
        $gmds = $material->goodsMovementDetails;

        foreach($prds as $prd){
            $pr = $prd->purchaseRequisition;
            $pr->type_doc = "Purchase Requisition";
            if($pr != null){
                $documents->push($pr);
            }
        }

        foreach($pods as $pod){
            $po = $pod->purchaseOrder;
            $po->type_doc = "Purchase Order";
            if($po != null){
                $documents->push($po);
            }
        }

        foreach($grds as $grd){
            $gr = $grd->goodsReceipt;
            $gr->type_doc = "Goods Receipt";
            if($gr != null){
                $documents->push($gr);
            }
        }

        foreach($mrds as $mrd){
            $mr = $mrd->material_requisition;
            $mr->type_doc = "Material Requisition";
            if($mr != null){
                $documents->push($mr);
            }
        }

        foreach($gids as $gid){
            $gi = $gid->goodsIssue;
            $gi->type_doc = "Goods Issue";
            if($gi != null){
                $documents->push($gi);
            }
        }

        foreach($grtds as $grtd){
            $grt = $grtd->goodsReturn;
            $grt->type_doc = "Goods Return";
            if($grt != null){
                $documents->push($grt);
            }
        }
        
        foreach($snds as $snd){
            $sn = $snd->snapshot;
            $sn->type_doc = "Physical Inventory";
            if($sn != null){
                $documents->push($sn);
            }
        }
        
        foreach($mwods as $mwod){
            $mwo = $mwod->materialWriteOff;
            $mwo->type_doc = "Material Write Off";
            if($mwo != null){
                $documents->push($mwo);
            }
        }

        foreach($gmds as $gmd){
            $gm = $gmd->goodsMovement;
            $gm->type_doc = "Goods Movement";
            if($gm != null){
                $documents->push($gm);
            }
        }

        return view('material.show', compact('material','uoms','arrayFamily','nameDensity','documents','route'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $material = Material::findOrFail($id);
        if($material->family_id != null){
            $dataFamily = json_decode($material->family_id);
        }else{
            $dataFamily = "";
        }
        $material_families = Configuration::get('material_family');
        $densities = Configuration::get('density');
        $uoms = Uom::all();
        
        return view('material.edit', compact('material','uoms','material_families','densities','dataFamily'));
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
        $data = json_decode($request->datas);
        $request = new Request([
            'code' => $data->code,
            // 'name' => $data->name,
            'description' => $data->description,
            'cost_standard_price' => $data->cost_standard_price,
            'cost_standard_price_service' => $data->cost_standard_service,
            'weight' => $data->weight,
            'height' => $data->height,
            'length' => $data->lengths,
            'width' => $data->width,
            'volume' => $data->volume

        ]);
        
        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_material,code,'.$id.',id|string|max:255',
            // 'name' => 'required|string|max:255',   
            'description' => 'nullable|string|max:255',    
            'cost_standard_price' => 'nullable',
            'cost_standard_price_service' => 'nullable',
            'weight' => 'nullable',
            'height' => 'nullable',
            'length' => 'nullable',
            'width' => 'nullable',
            'volume' => 'nullable'

        ]);

        DB::beginTransaction();
        try {
        $material = Material::find($id);
        $material->code = $data->code;
        // $material->name = $data->name;
        $material->description = $data->description;
        $material->cost_standard_price = $data->cost_standard_price == "" ? 0 : $data->cost_standard_price;
        if($data->dimension_uom_id != ""){
            $uom = Uom::where('id',$data->dimension_uom_id)->first();
            if($uom->unit == "M"){
                $dataDensity = Configuration::get('density');
                foreach($dataDensity as $density){
                    if($density->id == $data->density_id){
                        $value = $density->value;
                    }
                }
                
                $result = $data->lengths * $data->width * $data->height * $value;
                $material->cost_standard_price_kg = 1/$result * $data->cost_standard_price;
            }else{
                $material->cost_standard_price_kg = 0;
            }
        }
        $material->cost_standard_price_service = $data->cost_standard_service == "" ? 0 : $data->cost_standard_service;
        $material->uom_id = $data->uom_id;
        $material->min = $data->min == "" ? 0 : $data->min;
        $material->max = $data->max == "" ? 0 : $data->max;
        $material->weight = $data->weight;
        $material->weight_uom_id = $data->weight_uom_id == "" ? null : $data->weight_uom_id;
        $material->height = $data->height;
        $material->length = $data->lengths;
        $material->width = $data->width;
        $material->type = $data->type;
        $material->family_id = $data->family_id == "" ? null : json_encode($data->family_id);
        $material->density_id = $data->density_id == "" ? null : $data->density_id;
        $material->dimension_uom_id = $data->dimension_uom_id == "" ? null : $data->dimension_uom_id;
        $material->status = $data->status;
        if($request->hasFile('image')){
            // Get filename with the extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // Get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // File name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('image')->storeAs('documents/material',$fileNameToStore);
        }else{
            $fileNameToStore =  null;
        }
        $material->image = $fileNameToStore;
        $material->update();

        DB::commit();
        return redirect()->route('material.show',$material->id)->with('success', 'Material Updated Succesfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('material.update',$material->id)->with('error', $e->getMessage())->withInput();
        }
            
    }

    public function destroy($id)
    {
        $material = Material::find($id);

        try {
            $material->delete();
            return redirect()->route('material.index')->with('status', 'Material Deleted Succesfully!');
        } catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('material.index')->with('status', 'Can\'t Delete The Material Because It Is Still Being Used');
        }   
    }

    public function generateMaterialCode(){
        $code = 'MT';
        $modelMaterial = Material::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelMaterial)){
            $number += intval(substr($modelMaterial->code, -4));
		}

        $material_code = $code.''.sprintf('%04d', $number);
		return $material_code;
    }
    

}


