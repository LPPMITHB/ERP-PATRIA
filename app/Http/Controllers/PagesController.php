<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\WBS;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Auth;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $business_unit_id = json_decode(Auth::user()->business_unit_id);
        $modelProject = Project::orderBy('planned_end_date','asc')->whereIn('business_unit_id', $business_unit_id)->where('status',1)->whereNull('project_id')->get();
        $datas = Collection::make();

        foreach($modelProject as $project){
            if(count($project->wbss) > 0){
                $modelWBS = WBS::where('project_id',$project->id)->get();
                $WbsAll = WBS::where('project_id',$project->id)->get();
                foreach($modelWBS as $key => $wbs){
                    foreach($WbsAll as $dataWbs){
                        if($dataWbs->wbs_id == $wbs->id){
                            $modelWBS->forget($key);
                        }
                    }
                }
                $dateGlobal = date("Y-m-d");
                $date = date_create($dateGlobal);
                $late_days = 0;
                foreach($modelWBS as $wbs){
                    if($wbs->progress >= 100){
                        $planned_end_date = date_create($wbs->planned_end_date);
                        $actual_end_date = date_create($wbs->actual_end_date);
                        $diff=date_diff($actual_end_date,$planned_end_date);
                        if($diff->invert == 0){
                            $late_days += $diff->d * -1;
                        }else{
                            $late_days += $diff->d;
                        }
                    }else{
                        if($wbs->planned_end_date < $dateGlobal){
                            $planned_end_date = date_create($wbs->planned_end_date);
                            $diff=date_diff($date,$planned_end_date);
                            $late_days += $diff->d;
                        }
                    }
                }
                $latestDate = WBS::orderBy('planned_end_date','desc')->where('project_id',$project->id)->first()->planned_end_date;
                $expectedDate = date($latestDate);
                $expectedDate = strtotime($expectedDate);
                $expectedDate = date("Y-m-d",strtotime("$late_days day", $expectedDate));
        
                $project_end_date = date_create($project->planned_end_date);
                $expected_end_date = date_create($expectedDate);
                $diff=date_diff($expected_end_date,$project_end_date);
        
                if($expectedDate <= $latestDate){
                    $status = 0;
                }else{
                    if($expectedDate == $project->planned_end_date){
                        $status = 2;
                    }elseif($expectedDate < $project->planned_end_date){
                        $status = 1;
                    }elseif($expectedDate > $project->planned_end_date){
                        $status = 2;
                    }
                }
                $date = date('Y-m-d');
                if($date > $project->planned_end_date){
                    $status = 3;
                }
    
                $datas->push([
                    "id" => $project->id, 
                    "status" => $status,
                ]);
            }else{
                $date = date('Y-m-d');
                if($date > $project->planned_end_date){
                    $status = 3;
                }else{
                    $status = 0;
                }
                $datas->push([
                    "id" => $project->id, 
                    "status" => $status,
                ]);
            }
        }
        return view('dashboard', compact('modelProject','datas'));
    }
}
