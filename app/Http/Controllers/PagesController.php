<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
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
        $modelProject = Project::orderBy('planned_end_date','asc')->whereIn('business_unit_id', $business_unit_id)->get();
        
        return view('dashboard', compact('modelProject'));
    }
}
