<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\Ship;
use App\Models\Uom;
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
        $services = Service::with('ship')->get();
        
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
        $ships = Ship::all();
        
        return view('service.create', compact('service', 'service_code','ships'));
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
        ]);

        DB::beginTransaction();
        try {
            $service = new Service;
            $service->code = strtoupper($request->input('code'));
            $service->name = ucwords($request->input('name'));
            if($request->input('type') != "-1"){
                $service->ship_id = $request->input('type');
            }
            $service->user_id = Auth::user()->id;
            $service->branch_id = Auth::user()->branch->id;
            $service->save();

        DB::commit();
        return redirect()->route('service.show',$service->id)->with('success', 'Success Created New Service!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('service.create')->with('error', $e->getMessage());
        }
    }

    public function createServiceDetail(Request $request,$id)
    {
        $service = Service::findOrFail($id);
        $uoms = Uom::all();
        
        return view('service.createServiceDetail', compact('service','uoms'));        
    }

    public function storeServiceDetail(Request $request){
        
       
        $data = json_decode($request->datas);
        DB::beginTransaction();
        try {
                $SD = new ServiceDetail;
                $SD->service_id = $data->service_id;
                $SD->name = $data->name;
                $SD->description = $data->description;
                $SD->uom_id = $data->uom_id;
                $SD->cost_standard_price = $data->cost_standard_price;
                $SD->save();

            DB::commit();
                return redirect()->route('service.show',$data->service_id)->with('success', 'Service Detail Created');
                
        } catch (\Exception $e) {
            DB::rollback();
                return redirect()->route('service.show',$data->service_id)->with('error', $e->getMessage());
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
        $service_id = $id;
        $modelSD = ServiceDetail::where('service_id',$id)->with('uom')->get();
        $uoms = Uom::all();

        return view('service.show', compact('service','modelSD','uoms','service_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ships = Collection::make();
        $service = Service::findOrFail($id);
        if($service->ship_id == null){
            $service->ship_id = 0;
        }
        $ships_data = Ship::all();

        $ships->push([
            "id" => 0 , 
            "type" => "General",
        ]);

        foreach($ships_data as $ship){
            $ships->push([
                "id" => $ship->id , 
                "type" => $ship->type,
            ]);
        }
        return view('service.edit', compact('service','ships'));
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
        $data = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $service = Service::find($id);
            $service->code = strtoupper($data->code);
            $service->name = ucwords($data->name);
            if($data->ship_id == 0){
                $service->ship_id = NULL;
            }else{
                $service->ship_id = $data->ship_id;}
            
            $service->update();

            DB::commit();
            return redirect()->route('service.show',$service->id)->with('success', 'Service Updated Succesfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('service.update',$service->id)->with('error', $e->getMessage());
        }
        
    }

    public function updateDetail(Request $request)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $modelSD = ServiceDetail::findOrFail($data['service_detail_id']);
            $modelSD->name = $data['name'];
            $modelSD->description = $data['description'];
            $modelSD->uom_id = $data['uom_id'];
            $modelSD->cost_standard_price = $data['cost_standard_price'];

            if(!$modelSD->update()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Service Detail Updated"],Response::HTTP_OK);
            }
        }
        catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function destroy($id)
    {
        
    }
    //Function

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

    public function getNewServiceDetailAPI($id){
        $modelSD = ServiceDetail::where('service_id',$id)->with('uom')->get()->jsonSerialize();

        return response($modelSD, Response::HTTP_OK);
    }
}
