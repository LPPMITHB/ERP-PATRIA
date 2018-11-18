<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currencies;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;

class CurrenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currencies::all();
        
        return view('currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currencies = new Currencies;
        return view('currencies.create', compact('currencies'));
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
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',  
        ]);

        DB::beginTransaction();
        try {
        $currencies = new Currencies;
        $currencies->name = ucwords($request->input('name'));
        $currencies->value = $request->input('value');
        $currencies->save();

        DB::commit();
        return redirect()->route('currencies.index')->with('success', 'Success Input Currency!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('currencies.create')->with('error', $e->getMessage());
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $currencies = Currencies::findOrFail($id);
        
        return view('currencies.create', compact('currencies'));

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
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',  
        ]);

        DB::beginTransaction();
        try {
        $currencies = Currencies::find($id);
        $currencies->name = ucwords($request->input('name'));
        $currencies->value = $request->input('value');
        $currencies->save();

        DB::commit();
        return redirect()->route('currencies.index')->with('success', 'Currencies Updated Succesfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('currencies.update',$currencies->id)->with('error', $e->getMessage());
        }
        
    }

}
