<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Models\Pica;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseOrder;
use App\Models\GoodsReceipt;
use App\Models\MaterialRequisition;
use App\Models\GoodsIssue;
use App\Models\GoodsReturn;
use App\Models\PhysicalInventory;
use App\Models\MaterialWriteOff;
use App\Models\GoodsMovement;
use DB;
use Datetime;

class PicaController extends Controller
{
    public function selectDocument($type)
    {
        # code...
    }

    public function create()
    {
        
    }

    public function index()
    {
        $daily_weather = Weather::orderBy('input_date','desc')->get();
        $temp_weather = Configuration::get('weather');
        $weather_config = Collection::make();
        foreach($temp_weather as $data){
            if($data->status == 1){
                $weather_config->push($data);
            }
        }

        return view('weather.index', compact('daily_weather','weather_config'));
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $input_date = DateTime::createFromFormat('d-m-Y', $data['input_date']);
            $input_date = $input_date->format('Y-m-d');

            $new_data = new Weather;
            $new_data->input_date = $input_date;
            $new_data->weather_configuration_id = $data['weather_configuration_id'];
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

            $new_data = Weather::find($data['id']);
            $new_data->input_date = $input_date;
            $new_data->weather_configuration_id = $data['weather_configuration_id'];
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
            $dailyWeather = Weather::find($id);
            $dailyWeather->delete();
            
            DB::commit();
            return response(["response"=>"Success to delete Data"],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    //API
    public function getWeatherAPI(){
        $dailyWeather = Weather::orderBy('input_date', 'desc')->get()->jsonSerialize();
        return response($dailyWeather, Response::HTTP_OK);
    }
}
