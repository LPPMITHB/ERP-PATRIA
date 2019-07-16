<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Models\Tidal;
use App\Models\Configuration;
use DB;
use Datetime;

class TidalController extends Controller
{
    public function index()
    {
        $daily_tidal = Tidal::orderBy('input_date','desc')->get();
        $temp_tidal = Configuration::get('tidal');
        $tidal_config = Collection::make();
        foreach($temp_tidal as $data){
            if($data->status == 1){
                $tidal_config->push($data);
            }
        }

        return view('daily_tidal.index', compact('daily_tidal','tidal_config'));
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $input_date = DateTime::createFromFormat('d-m-Y', $data['input_date']);
            $input_date = $input_date->format('Y-m-d');

            $new_data = new Tidal;
            $new_data->input_date = $input_date;
            $new_data->tidal_configuration_id = $data['tidal_configuration_id'];
            $new_data->description = $data['description'];
            $new_data->save();
            
            DB::commit();
            return response(json_encode($new_data),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $input_date = DateTime::createFromFormat('d-m-Y', $data['input_date']);
            $input_date = $input_date->format('Y-m-d');

            $new_data = Tidal::find($data['id']);
            $new_data->input_date = $input_date;
            $new_data->tidal_configuration_id = $data['tidal_configuration_id'];
            $new_data->description = $data['description'];
            $new_data->update();
            
            DB::commit();
            return response(json_encode($new_data),Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function destroy(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        DB::beginTransaction();
        try {
            $dailyTidal = Tidal::find($id);
            $dailyTidal->delete();
            
            DB::commit();
            return response(["response"=>"Success to delete Data"],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    //API
    public function getTidalAPI(){
        $dailyTidal = Tidal::orderBy('input_date', 'desc')->get()->jsonSerialize();
        return response($dailyTidal, Response::HTTP_OK);
    }
}
