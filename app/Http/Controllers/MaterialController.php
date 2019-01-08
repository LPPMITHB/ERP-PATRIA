<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Configuration;
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
        $materials = Material::all();
        
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
        $currencies = Configuration::get('currencies');

        return view('material.create', compact('material','currencies'));
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
        $request = new Request([
            'code' => $data->code,
            'name' => $data->name,
            'description' => $data->description,
            'cost_standard_price' => $data->cost_standard_price,
            'weight' => $data->weight,
            'height' => $data->height,
            'length' => $data->lengths,
            'width' => $data->width,
            'volume' => $data->volume

        ]);

        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_material|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'cost_standard_price' => 'required|numeric',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
        ]);

        $currencies = collect(Configuration::get('Currencies'));
        
        $selectedCurrency = null;
        foreach($currencies as $currency){
            if($currency->unit == $data->currency){
                $selectedCurrency = $currency;
            }
        }

        DB::beginTransaction();
        try {
            $material = new Material;
            $material->code = $data->code;
            $material->name = $data->name;
            $material->description = $data->description;
            $material->currency = $data->currency;
            if($selectedCurrency->unit == "Rp"){
                $material->cost_standard_price = $data->cost_standard_price;
            }else{
                $material->cost_standard_price = $data->cost_standard_price*$selectedCurrency->value;                
            }
            $material->weight = $data->weight;
            $material->height = $data->height;
            $material->length = $data->lengths;
            $material->width = $data->width;
            $material->volume = $data->volume;
            $material->type = $data->type;
            $material->status = $data->status;
            $material->user_id = Auth::user()->id;
            $material->branch_id = Auth::user()->branch->id;
            $material->save();
        
        DB::commit();
        return redirect()->route('material.show',$material->id)->with('success', 'Success Created New Material!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('material.create')->with('error', $e->getMessage());
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
        $material = Material::findOrFail($id);
        $currencies = collect(Configuration::get('Currencies'));
        
        $selectedCurrency = null;
        foreach($currencies as $currency){
            if($currency->unit == $material->currency){
                $selectedCurrency = $currency;
            }
        }
        $material->cost_standard_price = $material->cost_standard_price / $selectedCurrency->value;
        
        return view('material.show', compact('material'));
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
        $currencies = collect(Configuration::get('Currencies'));
        
        $selectedCurrency = null;
        foreach($currencies as $currency){
            if($currency->unit == $material->currency){
                $selectedCurrency = $currency;
            }
        }
        $material->cost_standard_price = $material->cost_standard_price / $selectedCurrency->value;
        
        return view('material.edit', compact('material','currencies'));
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
            'name' => $data->name,
            'description' => $data->description,
            'cost_standard_price' => $data->cost_standard_price,
            'weight' => $data->weight,
            'height' => $data->height,
            'length' => $data->lengths,
            'width' => $data->width,
            'volume' => $data->volume

        ]);
        
        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_material,code,'.$id.',id|string|max:255',
            'name' => 'required|string|max:255',   
            'description' => 'nullable|string|max:255',    
            'cost_standard_price' => 'required|numeric',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'volume' => 'nullable|numeric'

        ]);

        $currencies = collect(Configuration::get('Currencies'));
        
        $selectedCurrency = null;
        foreach($currencies as $currency){
            if($currency->unit == $data->currency){
                $selectedCurrency = $currency;
            }
        }
        DB::beginTransaction();
        try {
        $material = Material::find($id);
        $material->code = $data->code;
        $material->name = $data->name;
        $material->description = $data->description;
        if($selectedCurrency->unit == "Rp"){
            $material->cost_standard_price = $data->cost_standard_price;
        }else{
            $material->cost_standard_price = $data->cost_standard_price*$selectedCurrency->value;                
        }
        $material->weight = $data->weight;
        $material->height = $data->height;
        $material->length = $data->lengths;
        $material->width = $data->width;
        $material->volume = $data->volume;
        $material->type = $data->type;
        $material->status = $data->status;
        $material->update();

        DB::commit();
        return redirect()->route('material.show',$material->id)->with('success', 'Material Updated Succesfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('material.update',$material->id)->with('error', $e->getMessage());
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


