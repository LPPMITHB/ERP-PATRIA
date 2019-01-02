<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Configuration;
use App\Models\Branch;
use App\Models\BusinessUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input as input;
use Auth;

class UserController extends Controller
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
        $users = User::all();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User;
        $roles = Role::pluck('id','name');
        $branches = Branch::where('status',1)->pluck('id','name');
        $businessUnits = BusinessUnit::all();

        return view('user.create', compact('user','roles','branches','businessUnits'));
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
            'username' => 'required|alpha_dash|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'nullable|numeric',
            'role' => 'required',
            'branch' => 'required',
        ]);
        
        $stringBusinessUnit = '['.implode(',', $request->businessUnit).']';
        $configuration = Configuration::get('default-password');
        DB::beginTransaction();
        try {
            $user = new User;
            $user->username = $request->username;
            $user->name = ucwords($request->name);
            $user->email = $request->email;
            $user->password = Hash::make($configuration->password);
            $user->address = ucfirst($request->address);
            $user->phone_number = $request->phone_number;
            $user->role_id = $request->role;
            $user->business_unit_id = $stringBusinessUnit;
            $user->branch_id = $request->branch;
            $user->status = $request->status;
            $user->save();
            DB::commit();

            return redirect()->route('user.show', ['id' => $user->id])->with('success', 'User Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('user.create')->with('error', $e->getMessage());
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
        $user = User::findOrFail($id);
        $businessUnits = BusinessUnit::whereIn('id',json_decode($user->business_unit_id))->pluck('name')->toArray();
        $stringBusinessUnit = implode(', ', $businessUnits);
        return view('user.show', compact('user','stringBusinessUnit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('id','name');
        $branches = Branch::where('status',1)->pluck('id','name');

        return view('user.edit', compact('user','roles','branches'));
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
        $user = User::findOrFail($id);
        DB::beginTransaction();
        try {
            $arrayValidate = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,'.$id,
                'phone_number' => 'nullable|numeric',
            ];

            if ($request->user()->can('change-role')) {
                $arrayValidate['role']='required';
            } 
            if ($request->user()->can('change-branch')) {
                $arrayValidate['branch']='required';
            }

            $this->validate($request, $arrayValidate);

            $user->name = ucwords($request->input('name'));
            $user->email = $request->input('email');
            $user->address = ucfirst($request->input('address'));
            $user->phone_number = $request->input('phone_number');
            if ($request->user()->can('change-branch')) {
                $user->branch_id = $request->branch;
            }
            if ($request->user()->can('change-status')) {
                $user->status = $request->status;
            }
            if ($request->user()->can('change-role')) {
                $user->role_id = $request->role;
            }
            $user->save();
            DB::commit();

            return redirect()->route('user.show', ['id' => $user->id])->with('success', 'User Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('user.edit', ['id' => $user->id])->with('error', $e->getMessage());
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
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            if($user->id == Auth::user()->id){
                DB::rollback();
                return redirect()->route('user.show',$user->id)->with('warning', 'You cannot delete your own account !');
            }else{
                $user->delete();
                DB::commit();
    
                return redirect()->route('user.index')->with('success', 'User Deleted');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('user.show',$user->id)->with('error', $e->getMessage());
        }
    }
   
    public function editPassword($id){
        $user = User::find($id);

        return view('user.change_password',compact('user'));
    }

    public function updatePassword(Request $request, $id){
        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
            'new_password_confirmation' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $user = User::find($id);
            if(Hash::check(Input::get('current_password'), $user['password'])){
                $user->password = Hash::make(Input::get('new_password'));
                $user->updated_at = Carbon::now();
                $user->save();
                DB::commit();

                return redirect()->route('user.show',$user->id)->with('success', 'Password Updated');
            } else{
                return redirect()->route('user.change_password',$user->id)->with('warning', 'Wrong Old Password !');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('user.show',$user->id)->with('error', $e->getMessage());
        }
    }
    
    public function changeDefaultPassword(){
        $configuration = Configuration::get('default-password');

        return view('user.change_default_password',compact('configuration'));
    }

    public function updateDefaultPassword(Request $request){
        $this->validate($request, [
            'new_password' => 'required|string|min:6|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        $defaultPassword = Configuration::where('slug', 'default-password')->firstOrFail();
        $array['password'] = $request->new_password;      
        $defaultPassword->value = json_encode($array);
        $defaultPassword->save();
        
        return redirect()->route('user.changeDefaultPassword')->with('success', 'Default Password Updated');
    }
}
