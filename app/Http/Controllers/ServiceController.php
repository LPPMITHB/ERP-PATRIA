<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Auth;
use DB;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        
        return view('service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $service = new Service;
        $service_code = self::generateServiceCode();
        
        return view('service.create', compact('service', 'service_code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_service|string|max:255',
            'name' => 'required|string|max:255',
            'cost_standard_price' => 'required|numeric',           
        ]);

        DB::beginTransaction();
        try {
        $service = new Service;
        $service->code = strtoupper($request->input('code'));
        $service->name = ucwords($request->input('name'));
        $service->description = $request->input('description');
        $service->cost_standard_price = $request->input('cost_standard_price');
        $service->status = $request->input('status');
        $service->save();

        DB::commit();
        return redirect()->route('service.show',$service->id)->with('success', 'Success Created New Service!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('service.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        
        return view('service.show', compact('service'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        
        return view('service.create', compact('service','companies'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_service,code,'.$id.',id|string|max:255',
            'name' => 'required|string|max:255',
            'cost_standard_price' => 'required|numeric',             
        ]);

        DB::beginTransaction();
        try {
        $service = Service::find($id);
        $service->code = strtoupper($request->input('code'));
        $service->name = ucwords($request->input('name'));
        $service->description = $request->input('description');
        $service->cost_standard_price = $request->input('cost_standard_price');
        $service->status = $request->input('status');
        $service->update();

        DB::commit();
        return redirect()->route('service.show',$service->id)->with('success', 'Service Updated Succesfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('service.update',$service->id)->with('error', $e->getMessage());
        }
        
    }

    public function destroy($id)
    {
        
    }

    public function generateServiceCode(){
        $code = 'SRV';
        $modelService = Service::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelService)){
            $number += intval(substr($modelService->code, -4));
		}

        $service_code = $code.''.sprintf('%04d', $number);
		return $service_code;
	}
}
