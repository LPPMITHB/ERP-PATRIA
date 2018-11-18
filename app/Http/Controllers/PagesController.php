<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Redirect;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $modelProject = Project::orderBy('planned_end_date','asc')->get();

        return view('dashboard', compact('modelProject'));
    }
}
