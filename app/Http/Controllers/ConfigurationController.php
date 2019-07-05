<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Auth;


class ConfigurationController extends Controller
{
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

    public function getCurrenciesAPI(){
        return response(Configuration::get('currencies')->jsonSerialize(), Response::HTTP_OK);
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

    public function getMaterialFamilyAPI(){
        return response(Configuration::get('material_family')->jsonSerialize(), Response::HTTP_OK);
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

    public function getDensityAPI(){
        return response(Configuration::get('density')->jsonSerialize(), Response::HTTP_OK);
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
}
