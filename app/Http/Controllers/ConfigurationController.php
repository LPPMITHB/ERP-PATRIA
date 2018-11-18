<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

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
}
