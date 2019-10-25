<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;


class RoleController extends Controller
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
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::where('menu_id', null)->where('name','!=','Ship Building')->where('name','!=','Ship Repair')->where('name','!=','Trading')->get();
        $mainMenu = Menu::whereIn('name',['Ship Building','Ship Repair','Trading'])->get();
        $role = new Role;
        return view('role.create', compact('role', 'menus','mainMenu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas = json_decode($request->datas);
        $stringPermissions = '{'.implode(',', $datas->permissions).'}';
        $menus = array();

        foreach($datas->checkedPermissions as $permission){
            $permission = Permission::where('middleware',$permission)->select('menu_id')->first();
            $menus[] = $permission->menu_id;
        }
        $menus = array_unique($menus);

        $this->validate($request, [
            'name' => 'required|unique:roles|string|max:255',
            'description' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $role = new Role;
            $role->name = strtoupper($datas->name);
            $role->description = $datas->description;
            $role->permissions = $stringPermissions;
            $role->branch_id = Auth::user()->branch->id;
            $role->save();

            self::saveMenu($menus,$role);
            
            DB::commit();
            return redirect()->route('role.show', ['id' => $role->id])->with('success', 'Role Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('role.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        $permissionKeys = array_keys(json_decode($role->permissions, true));
        
        $jsonRole = Role::findOrFail($id)->jsonSerialize();
        $permissions = Permission::whereIn('middleware', $permissionKeys)->with('menu')->get()->jsonSerialize();

        return view('role.show', compact('role','permissions','jsonRole'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $userPermissions = $role->permissions;
        $checkedPermissions = array_keys(json_decode($userPermissions, true));
        $checkedPermissions = $checkedPermissions;
        
        $menus = Menu::where('menu_id', null)->where('name','!=','Ship Building')->where('name','!=','Ship Repair')->where('name','!=','Trading')->get();
        $mainMenu = Menu::whereIn('name',['Ship Building','Ship Repair','Trading'])->get();

        return view('role.edit', compact('role', 'checkedPermissions', 'menus','mainMenu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $datas = json_decode($request->datas);
        $stringPermissions = '{'.implode(',', $datas->permissions).'}';
        $menus = array();
        foreach($datas->checkedPermissions as $checkedPermission){
            $permission = Permission::where('middleware',$checkedPermission)->select('menu_id')->first();
            if($permission != null){
                $menus[] = $permission;
            }
        }
        $menus = array_unique($menus);

        DB::beginTransaction();
        try {
            $role = Role::findOrFail($id);
            $role->name = strtoupper($datas->name);
            $role->description = $datas->description;
            $role->permissions = $stringPermissions;
            $role->save();

            self::updateMenu($menus,$role);
            
            DB::commit();
            return redirect()->route('role.show', ['id' => $role->id])->with('success', 'Role Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('role.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $role = Role::find($id);
            $role->delete();
            DB::commit();

            return redirect()->route('role.index')->with('success', 'Role Deleted Succesfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('role.index')->with('error', $e->getMessage());
        }
    }

    public function saveMenu($menus,$role){
        foreach ($menus as $menu) {
            $modelMenu = Menu::find($menu);
            if($modelMenu->menu_id){
                if($modelMenu->menu->menu){
                    if($modelMenu->menu->menu->menu){
                        $roles = explode(',',$modelMenu->menu->menu->menu->roles);

                        if(!in_array($role->name, $roles))
                            array_push($roles, $role->name);
    
                        $stringRoles = implode(',', $roles);
                        $stringRolesFinal = $stringRoles.",";
    
                        $modelMenu->menu->menu->menu->roles = $stringRolesFinal;
                        $modelMenu->menu->menu->menu->save();
                    }
                    $roles = explode(',',$modelMenu->menu->menu->roles);

                    if(!in_array($role->name, $roles))
                        array_push($roles, $role->name);

                    $stringRoles = implode(',', $roles);
                    $stringRolesFinal = $stringRoles.",";

                    $modelMenu->menu->menu->roles = $stringRolesFinal;
                    $modelMenu->menu->menu->save();
                }
                $roles = explode(',',$modelMenu->menu->roles);

                if(!in_array($role->name, $roles))
                    array_push($roles, $role->name);

                $stringRoles = implode(',', $roles);
                $stringRolesFinal = $stringRoles.",";

                $modelMenu->menu->roles = $stringRolesFinal;
                $modelMenu->menu->save();
            }
            $roles = explode(',',$modelMenu->roles);

            if(!in_array($role->name, $roles))
                array_push($roles, $role->name);

            $stringRoles = implode(',', $roles);
            $stringRolesFinal = $stringRoles.",";

            $modelMenu->roles = $stringRolesFinal;
            $modelMenu->save();
        }
    }

    public function updateMenu($menus,$role){
        $allMenu = Menu::all();
        foreach($allMenu as $menu){
            $roles = explode(',',$menu->roles);

            foreach($roles as $roleKey => $roleMenu){
                if($roleMenu == $role->name){
                    unset($roles[$roleKey]);
                }
                if($roleMenu == ""){
                    unset($roles[$roleKey]);
                }
            }
            $stringRoles = implode(',', $roles);
            $menu->roles = $stringRoles;
            $menu->save();
        }

        foreach ($menus as $menu) {
            $modelMenu = Menu::findOrFail($menu->menu_id);
            if($modelMenu->menu_id){
                if($modelMenu->menu->menu){
                    if($modelMenu->menu->menu->menu){
                        $roles = explode(',',$modelMenu->menu->menu->menu->roles);

                        if(!in_array($role->name, $roles))
                            array_push($roles, $role->name);
            
                        foreach($roles as $roleKey => $roleMenu){
                            if($roleMenu == ""){
                                unset($roles[$roleKey]);
                            }
                        }
            
                        $stringRoles = implode(',', $roles);
                        $modelMenu->menu->menu->menu->roles = $stringRoles;
                        $modelMenu->menu->menu->menu->save();
                    }
                    $roles = explode(',',$modelMenu->menu->menu->roles);

                    if(!in_array($role->name, $roles))
                        array_push($roles, $role->name);
        
                    foreach($roles as $roleKey => $roleMenu){
                        if($roleMenu == ""){
                            unset($roles[$roleKey]);
                        }
                    }
        
                    $stringRoles = implode(',', $roles);
                    $modelMenu->menu->menu->roles = $stringRoles;
                    $modelMenu->menu->menu->save();
                }
                $roles = explode(',',$modelMenu->menu->roles);

                if(!in_array($role->name, $roles))
                    array_push($roles, $role->name);
    
                foreach($roles as $roleKey => $roleMenu){
                    if($roleMenu == ""){
                        unset($roles[$roleKey]);
                    }
                }
    
                $stringRoles = implode(',', $roles);
                $modelMenu->menu->roles = $stringRoles;
                $modelMenu->menu->save();
            }
            $roles = explode(',',$modelMenu->roles);

            if(!in_array($role->name, $roles))
                array_push($roles, $role->name);

            foreach($roles as $roleKey => $roleMenu){
                if($roleMenu == ""){
                    unset($roles[$roleKey]);
                }
            }

            $stringRoles = implode(',', $roles);
            $modelMenu->roles = $stringRoles;
            $modelMenu->save();
        }
    }

    public function getPermissionAPI($id){
        $childs = Menu::where('menu_id',$id)->pluck('id')->toArray();
        $menu_id = array();

        $temp_child = $childs;
        if(count($childs) > 1){
            foreach($childs as $child){
                $has_child_again = Menu::where('menu_id',$child)->pluck('id')->toArray();
                foreach ($has_child_again as $last_child) {
                    array_push($temp_child, $last_child);
                }
            }
            $modelPermission = Permission::whereIn('menu_id',$temp_child)->get();
            foreach ($modelPermission as $permission) {
                if(!in_array($permission->menu_id, $childs)){
                    $temp_menu = Menu::where('id', $permission->menu_id)->first()->menu_id;
                    $permission->menu_id = $temp_menu;
                }
            }
        }else{
            $modelPermission = Permission::where('menu_id',$id)->get();
        }
        return response($modelPermission->jsonSerialize(), Response::HTTP_OK);
    }

    public function getSubMenuAPI($id){
        $modelMenu = Menu::where('menu_id',$id)->get()->jsonSerialize();

        return response($modelMenu, Response::HTTP_OK);
    }
}
