<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ship;
use DB;
use Auth;

class ShipController extends Controller
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
        $ships = Ship::all();

        return view('ship.index', compact('ships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ship = new Ship;
        // $ship_code = self::generateShipCode();
        return view('ship.create', compact('ship','ship_code'));
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
            'type' => 'required|string|max:255',
        ]);

        $ships = Ship::all();
        foreach($ships as $ship) {
            if($ship->type == $request->type){
                return redirect()->route('ship.create')->with('error','The Ship Type Has Been Taken')->withInput();
            }
        }

        DB::beginTransaction();
        try {
            $ship = new Ship;
            $ship->type = ucwords(strtolower($request->input('type')));
            $ship->description = $request->input('description');
            $ship->status = $request->input('status');
            $ship->user_id = Auth::user()->id;
            $ship->branch_id = Auth::user()->branch->id;
            $ship->save();

            DB::commit();
            return redirect()->route('ship.show',$ship->id)->with('success', 'Success Created New Ship!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('ship.create')->with('error', $e->getMessage())->withInput();
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
        $ship = Ship::findOrFail($id);
        
        return view('ship.show', compact('ship'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ship = Ship::findOrFail($id);
        
        return view('ship.create', compact('ship'));
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
            'type' => 'required|string|max:255',
        ]);
        
        DB::beginTransaction();
        try {
            $ship = Ship::find($id);
            $ship->type = ucwords(strtolower($request->input('type')));
            $ship->description = $request->input('description');
            $ship->status = $request->input('status');        
            $ship->update();
            
            DB::commit();
            return redirect()->route('ship.show',$ship->id)->with('success', 'Ship Updated Succesfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('ship.update',$ship->id)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ship = Ship::find($id);

        try {
            $ship->delete();
            return redirect()->route('ship.index')->with('status', 'Ship Deleted Succesfully!');
        } catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('ship.index')->with('status', 'Can\'t Delete The Ship Because It Is Still Being Used');
        }   
    }

    // public function generateShipCode(){
    //     $code = 'SH';
    //     $modelShip = Ship::orderBy('code', 'desc')->first();
        
    //     $number = 1;
	// 	if(isset($modelShip)){
    //         $number += intval(substr($modelShip->code, -4));
	// 	}

    //     $ship_code = $code.''.sprintf('%04d', $number);
	// 	return $ship_code;
	// }
}
