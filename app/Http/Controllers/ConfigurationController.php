<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Auth;


class ConfigurationController extends Controller
{
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
}
