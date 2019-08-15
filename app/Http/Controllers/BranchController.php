<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Company;
use Auth;
use DB;

class BranchController extends Controller
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
        $branchs = Branch::all();
        
        return view('branch.index', compact('branchs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branch = new Branch;
        $branch_code = self::generateBranchCode();

        $companies = Company::all();
        
        return view('branch.create', compact('branch', 'branch_code','companies'));

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
            'code' => 'required|alpha_dash|unique:mst_branch|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',  
            'phone_number' => 'required|numeric',           
            'fax' => 'nullable|numeric',          
            'email' => 'required|email|unique:mst_branch|string|max:255'
        ]);

        DB::beginTransaction();
        try {
        $branch = new Branch;
        $branch->code = strtoupper($request->input('code'));
        $branch->name = ucwords($request->input('name'));
        $branch->address = $request->input('address');
        $branch->phone_number = $request->input('phone_number');
        $branch->fax = ucfirst($request->input('fax'));
        $branch->email = $request->input('email');
        $branch->status = $request->input('status');
        $branch->company_id = $request->input('company');
        $branch->save();

        DB::commit();
        return redirect()->route('branch.show',$branch->id)->with('success', 'Success Created New Branch!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('branch.create')->with('error', $e->getMessage());
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
        $branch = Branch::findOrFail($id);
        
        return view('branch.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);

        $companies = Company::all();
        
        return view('branch.create', compact('branch','companies'));
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
            'code' => 'required|alpha_dash|unique:mst_branch,code,'.$id.',id|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255', 
            'phone_number' => 'required|numeric',           
            'email' => 'required|email|unique:mst_branch,email,'.$id.',id|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            $branch = Branch::find($id);
            $branch->code = strtoupper($request->input('code'));
            $branch->name = ucwords($request->input('name'));
            $branch->address = $request->input('address');
            $branch->phone_number = $request->input('phone_number');
            $branch->fax = ucfirst($request->input('fax'));
            $branch->email = $request->input('email');
            $branch->status = $request->input('status');
            $branch->company_id = $request->input('company');
            $branch->update();

            DB::commit();
            return redirect()->route('branch.show',$branch->id)->with('success', 'Branch Updated Succesfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('branch.update',$branch->id)->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $branch = Branch::find($id);

        try {
            $branch->delete();
            return redirect()->route('branch.index')->with('success', 'Branch Deleted Succesfully!');
        } catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('branch.index')->with('error', 'Can\'t Delete The Branch Because It Is Still Being Used');
        }   
    }

    public function generateBranchCode(){
        $code = 'BR';
        $modelBranch = Branch::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelBranch)){
            $number += intval(substr($modelBranch->code, -4));
		}

        $branch_code = $code.''.sprintf('%04d', $number);
		return $branch_code;
	}
}
