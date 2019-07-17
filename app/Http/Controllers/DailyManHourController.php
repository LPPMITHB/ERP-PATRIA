<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\DailyManHour;
use App\Models\Project;
use DB;
use Datetime;

class DailyManHourController extends Controller
{
    public function selectProject(){
        $modelProject = Project::where('status',1)->get();

        return view('daily_man_hour.selectProject', compact('modelProject'));
    }

    public function create($id)
    {
        $dailyManHour = DailyManHour::where('project_id',$id)->get();
        $project_id = $id;
        return view('daily_man_hour.index', compact('dailyManHour','project_id'));
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();

        DB::beginTransaction();
        try {
            $input_date = DateTime::createFromFormat('d-m-Y', $data['input_date']);
            $input_date = $input_date->format('Y-m-d');

            $new_data = new DailyManHour;
            $new_data->input_date = $input_date;
            $new_data->project_id = $data['project_id'];
            $new_data->man_hour = $data['man_hour'];
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

            $new_data = DailyManHour::find($data['id']);
            $new_data->input_date = $input_date;
            $new_data->project_id = $data['project_id'];
            $new_data->man_hour = $data['man_hour'];
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
            $dmh = DailyManHour::find($id);
            $dmh->delete();
            
            DB::commit();
            return response(["response"=>"Success to delete Data"],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    //API
    public function getDailyManHourAPI($project_id){
        $dailyManHour = DailyManHour::orderBy('input_date', 'desc')->where('project_id', $project_id)->get()->jsonSerialize();
        return response($dailyManHour, Response::HTTP_OK);
    }
    
}
