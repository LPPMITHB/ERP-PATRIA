<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Uom;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Auth;


class ConfigurationController extends Controller
{
    public function approvalIndex(){
        $roles = Role::all();
        $approvalPR = Configuration::get('approval-pr');

        return view('approval.index', compact('roles','approvalPR'));
    }

    public function approvalSave(){

    }

    public function costTypeIndex(){

    }

    public function costTypeSave(){

    }

    public function appearanceIndex()
    {
        $defaultSkin = Configuration::get('default-skin');

        return view('appearance.index', compact('defaultSkin'));
    }

    public function appearanceSave(Request $request)
    {
        $this->validate($request, [
            'default-skin' => 'required',
        ]);

        $valueOfDefaultSkin = Configuration::get('default-skin');
        $valueOfDefaultSkin->default = $request->input('default-skin');

        $model = Configuration::where('slug', 'default-skin')->firstOrFail();
        $model->value = json_encode($valueOfDefaultSkin);
        $model->save();
        
        return redirect()->back();
    }

    public function currenciesIndex()
    {
        $currencies = Configuration::get('currencies');

        return view('currencies.index', compact('currencies'));
    }

    public function currenciesAdd(Request $request)
    {
        $data = $request->json()->all();
        $data = json_encode($data);

        DB::beginTransaction();
        try {
            $currencies = Configuration::where('slug','currencies')->first();
            $currencies->value = $data;
            $currencies->update();

            DB::commit();
            return response(json_encode($currencies),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('currencies.index')->with('error', $e->getMessage());
        }
    }

    public function materialFamilyIndex()
    {
        $material_family = Configuration::get('material_family');
        
        $id = count($material_family) + 1;

        return view('material_family.index', compact('material_family','id'));
    }

    public function materialFamilyAdd(Request $request)
    {
        $data = $request->json()->all();
        $data = json_encode($data);

        DB::beginTransaction();
        try {
            $material_family = Configuration::where('slug','material_family')->first();
            $material_family->value = $data;
            $material_family->update();

            DB::commit();
            return response(json_encode($material_family),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('material_family.index')->with('error', $e->getMessage());
        }
    }
    
    public function densityIndex()
    {
        $density = Configuration::get('density');
        
        $id = count($density) + 1;
        
        return view('density.index', compact('density','id'));
    }
    
    public function densityAdd(Request $request)
    {
        $data = $request->json()->all();
        $data = json_encode($data);
        
        DB::beginTransaction();
        try {
            $density = Configuration::where('slug','density')->first();
            $density->value = $data;
            $density->update();
            
            DB::commit();
            return response(json_encode($density),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('density.index')->with('error', $e->getMessage());
        }
    }
    
    public function paymentTermsIndex()
    {
        $payment_terms = Configuration::get('payment_terms');
        
        return view('payment_terms.index', compact('payment_terms'));
    }
    
    public function paymentTermsAdd(Request $request)
    {
        $data = $request->json()->all();
        $data = json_encode($data);
        
        DB::beginTransaction();
        try {
            $payment_terms = Configuration::where('slug','payment_terms')->first();
            $payment_terms->value = $data;
            $payment_terms->update();
            
            DB::commit();
            return response(json_encode($payment_terms),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('payment_terms.index')->with('error', $e->getMessage());
        }
    }

    public function deliveryTermsIndex()
    {
        $delivery_terms = Configuration::get('delivery_terms');
        
        return view('delivery_terms.index', compact('delivery_terms'));
    }
    
    public function deliveryTermsAdd(Request $request)
    {
        $data = $request->json()->all();
        $data = json_encode($data);
        
        DB::beginTransaction();
        try {
            $delivery_terms = Configuration::where('slug','delivery_terms')->first();
            $delivery_terms->value = $data;
            $delivery_terms->update();
            
            DB::commit();
            return response(json_encode($delivery_terms),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('delivery_terms.index')->with('error', $e->getMessage());
        }
    }
    
    public function weatherIndex()
    {
        $weather = Configuration::get('weather');
        
        return view('weather_config.index', compact('weather'));
    }
    
    public function weatherAdd(Request $request)
    {
        $data = $request->json()->all();
        $data = json_encode($data);
        
        DB::beginTransaction();
        try {
            $weather = Configuration::where('slug','weather')->first();
            $weather->value = $data;
            $weather->update();
            
            DB::commit();
            return response(json_encode($weather),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('weather.index')->with('error', $e->getMessage());
        }
    }
    
    public function tidalIndex()
    {
        $tidal = Configuration::get('tidal');
        
        return view('tidal_config.index', compact('tidal'));
    }
    
    public function tidalAdd(Request $request)
    {
        $data = $request->json()->all();
        $data = json_encode($data);
        
        DB::beginTransaction();
        try {
            $tidal = Configuration::where('slug','tidal')->first();
            $tidal->value = $data;
            $tidal->update();
            
            DB::commit();
            return response(json_encode($tidal),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('tidal.index')->with('error', $e->getMessage());
        }
    }
    
    public function dimensionTypeIndex()
    {
        $dimension_type = Configuration::get('dimension_type');
        $uom = Uom::all();
        
        return view('dimension_type_config.index', compact('dimension_type','uom'));
    }
    
    public function dimensionTypeAdd(Request $request)
    {
        $data = $request->json()->all();
        $data = json_encode($data);
        
        DB::beginTransaction();
        try {
            $dimension_type = Configuration::where('slug','dimension_type')->first();
            $dimension_type->value = $data;
            $dimension_type->update();

            DB::commit();
            return response(json_encode($dimension_type),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('dimension_type.index')->with('error', $e->getMessage());
        }
    }
    
    // API
    public function getCurrenciesAPI(){
        return response(Configuration::get('currencies')->jsonSerialize(), Response::HTTP_OK);
    }
    
    public function getMaterialFamilyAPI(){
        return response(Configuration::get('material_family')->jsonSerialize(), Response::HTTP_OK);
    }

    public function getDensityAPI(){
        return response(Configuration::get('density')->jsonSerialize(), Response::HTTP_OK);
    }

    public function getApprovalAPI($type){
        $slug = "";
        if($type == "Purchase Requisition"){
            $slug = 'approval-pr';
        }elseif($type == "Purchase Order"){
            $slug = 'approval-po';
        }elseif($type == "Material Requisition"){
            $slug = 'approval-mr';
        }
        
        return response(Configuration::get($slug), Response::HTTP_OK);
    }
}
