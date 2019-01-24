<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Auth;
use DB;

class CompanyController extends Controller
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
        $companies = Company::all();

        return view ('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = new Company;
        $company_code = self::generateCompanyCode();
        return view('company.create', compact('company','company_code'));
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
            'code' => 'required|alpha_dash|unique:mst_company|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'fax' => 'nullable|numeric|unique:mst_company|min:6',
            'email' => 'required|email|unique:mst_company|max:255',
        ]);
        DB::beginTransaction();
    try{
        $company = new company;
        $company->code = strtoupper($request->input('code'));
        $company->name = ucwords($request->input('name'));
        $company->address = ucwords(strtolower($request->input('address')));
        $company->phone_number = $request->input('phone_number');
        $company->fax = $request->input('fax');
        $company->email = $request->input('email');
        $company->status = $request->input('status');
        $company->save();
        
        DB::commit();
        return redirect()->route('company.show',$company->id)->with('success', 'Success Created New Company!');
    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->route('company.create')->with('error', $e->getMessage())->withInput();
    }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::findOrFail($id);
        
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        
        return view('company.create', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|alpha_dash|unique:mst_company,code,'.$id.',id|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'fax' => 'nullable|numeric|unique:mst_company,email,'.$id.',id|min:6',
            'email' => 'required|email|unique:mst_company,email,'.$id.',id|string|max:255'
        ]);
        
        DB::beginTransaction();
        try {
        $company = Company::find($id);
        $company->code = strtoupper($request->input('code'));
        $company->name = ucwords($request->input('name'));
        $company->address = ucwords(strtolower($request->input('address')));
        $company->phone_number = $request->input('phone_number');
        $company->fax = $request->input('fax');
        $company->email = $request->input('email');
        $company->status = $request->input('status');
        $company->update();

        DB::commit();
            return redirect()->route('company.show',$company->id)->with('success', 'Success Edit Company!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('company.update')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);

        try {
            $company->delete();
            return redirect()->route('company.index')->with('status', 'Company Deleted Succesfully!');
        } catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('company.index')->with('status', 'Can\'t Delete The company Because It Is Still Exist');
        }  
    }
    
    public function generateCompanyCode(){
        $code = 'CP';
        $modelCompany = Company::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelCompany)){
            $number += intval(substr($modelCompany->code, -4));
		}

        $company_code = $code.''.sprintf('%04d', $number);
		return $company_code;
    }
}
