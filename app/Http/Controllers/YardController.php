<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Yard;
use Auth;
use DB;

class YardController extends Controller
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
        $yards = Yard::all();

        return view ('yard.index', compact('yards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $yard = new Yard;
        $yard_code = self::generateYardCode();

        return view('yard.create', compact('yard','yard_code'));
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
            'code' => 'required|alpha_dash|unique:mst_yard|string|max:255',
            'name' => 'required|string|max:255',
            'area' => 'required|string',
            'description' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try{
        $yard = new Yard;
        $yard->code = strtoupper($request->input('code'));
        $yard->name = ucwords($request->input('name'));
        $yard->area = $request->input('area');
        $yard->description = $request->input('description');
        $yard->status = $request->input('status');
        $yard->branch_id = Auth::user()->branch->id;
        $yard->user_id = Auth::user()->id;
        $yard->save();

        DB::commit();
            return redirect()->route('yard.show',$yard->id)->with('success', 'Success Create New Yard!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('yard.create')->with('error', $e->getMessage());
        }
    }

   
    public function show($id)
    {
        $yard = Yard::findOrFail($id);

        
        
        return view('yard.show', compact('yard'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StorageLocation  $storage_location
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $yard = Yard::findOrFail($id);
        
        return view('yard.create', compact('yard'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StorageLocation  $storage_location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_yard,code,'.$id.',id|string|max:255',
            'name' => 'required|string|max:255',
            'area' => 'required|string',
            'description' => 'nullable|string|max:255',
            
        ]);
        
        DB::beginTransaction();
        try{
        $yard = Yard::find($id);
        $yard->code = strtoupper($request->input('code'));
        $yard->name = ucwords($request->input('name'));
        $yard->area = $request->input('area');
        $yard->description = $request->input('description');
        $yard->status = $request->input('status');
        $yard->save();

        DB::commit();
            return redirect()->route('yard.show',$yard->id)->with('success', 'Success Edit Yard');
        } catch (\Exception $e) {
        DB::rollback();
            return redirect()->route('yard.update')->with('error', $e->getMessage());
        }
    }

   
    public function destroy($id)
    {
        $yard = Yard::find($id);

        try {
            $yard->delete();
            return redirect()->route('yard.index')->with('status', 'Yard Deleted Succesfully!');
        } catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('yard.index')->with('status', 'Can\'t Delete The Yard Because It Is Still Exist');
        }  
    }
    
    public function generateYardCode(){
        $code = 'YRD';
        $modelYard = Yard::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelYard)){
            $number += intval(substr($modelYard->code, -4));
		}

        $yard_code = $code.''.sprintf('%04d', $number);
		return $yard_code;
	}
}
