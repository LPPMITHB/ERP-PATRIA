<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Permission;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class PermissionController extends Controller
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
        $permissions = Permission::all();

        return view('permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = new Permission;

        $datas = Menu::where('menu_id','!=',null)->get();
        $menu_ids = array();
        foreach($datas as $data){
            $menu_ids[]= $data->menu_id;
        }
        $menu_ids = array_unique($menu_ids);

        $ids = "";
        foreach($menu_ids as $id){
            $ids .= $id;
            $ids .= ',';
        }
        $ids = substr($ids,0,-1);

        $menus = Menu::where('id','!=',$ids)->pluck('id','name');

        return view('permission.create', compact('permission','menus'));
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
            'middleware' => 'required|unique:permissions|string|max:255',
            'menu' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $permission = new Permission;
            $permission->name = ucwords($request->name);
            $permission->middleware = strtolower($request->middleware);
            $permission->menu_id = $request->menu;
            $permission->save();
            DB::commit();

            return redirect()->route('permission.show',$permission->id);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('permission.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return view('permission.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        
        $datas = Menu::where('menu_id','!=',null)->get();
        $menu_ids = array();
        foreach($datas as $data){
            $menu_ids[]= $data->menu_id;
        }
        $menu_ids = array_unique($menu_ids);

        $ids = "";
        foreach($menu_ids as $id){
            $ids .= $id;
            $ids .= ',';
        }
        $ids = substr($ids,0,-1);

        $menus = Menu::where('id','!=',$ids)->pluck('id','name');

        return view('permission.edit', compact('permission','menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => 'required|string|max:255|unique:permissions,name,'.$id,
                'menu' => 'required',
            ]);
            
            $permission = Permission::findOrFail($id);
            $permission->name = $request->input('name');
            $permission->middleware = $request->input('middleware');
            $permission->menu_id = $request->input('menu');
            $permission->save();

            DB::commit();

            return redirect()->route('permission.show', ['id' => $permission->id])->with('success', 'Permission Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('permission.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $permission = Permission::find($id);
            $permission->delete();
            DB::commit();

            return redirect()->route('permission.index')->with('success', 'Permission Deleted Succesfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('permission.show',$permission->id)->with('error', $e->getMessage());
        }
    }
}
