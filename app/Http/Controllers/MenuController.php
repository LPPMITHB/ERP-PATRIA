<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Menu;
use App\Models\Configuration;
use Illuminate\Http\Request;

class MenuController extends Controller
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
        $menus = Menu::all();

        return view('menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu = new Menu;
        $parentMenus = Menu::where('level', 1)->where('is_active', 1)->pluck('id','name');

        $fontAwesomeIcons = Configuration::get('list-of-font-awesome');

        return view('menus.create', compact('menu','parentMenus','fontAwesomeIcons'));
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
            'name' => 'required|unique:menus',
            'icon' => 'required',
            'level' => 'required',
            'route_name' => 'required',
            'is_active' => 'boolean',
            'roles' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $menu = new Menu;
            $menu->name = $request->name;
            $menu->icon = $request->icon;
            $menu->level = $request->level;
            $menu->route_name = $request->route_name;
            $menu->is_active = $request->is_active;
            $menu->roles = $request->roles;
            $menu->menu_id = $request->parent_id;
            $menu->save();
            DB::commit();

            return redirect()->route('menus.show', ['id' => $menu->id])->with('success', 'Menu Created');
        } catch (\Exception $e) {
            DB::rollback();
            print_r($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = Menu::findOrFail($id);

        return view('menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $parentMenus = Menu::where('level', 1)->where('is_active', 1)->pluck('id','name');

        $fontAwesomeIcons = Configuration::get('list-of-font-awesome');

        return view('menus.create', compact('menu','parentMenus','fontAwesomeIcons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|unique:menus,name,'.$menu->id,
            'icon' => 'required',
            'level' => 'required',
            'route_name' => 'required',
            'is_active' => 'boolean',
            'roles' => 'required',
        ]);

        DB::beginTransaction();
        try {
            // Update Menu
            $menu->name = $request->name;
            $menu->icon = $request->icon;
            $menu->level = $request->level;
            $menu->route_name = $request->route_name;
            $menu->is_active = $request->is_active;
            $menu->roles = $request->roles;
            $menu->menu_id = $request->parent_id;
            $menu->save();
            DB::commit();

            return redirect()->route('menus.show', ['id' => $menu->id])->with('success', 'Menu Updated');
        } catch (\Exception $e) {
            DB::rollback();
            print_r($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        DB::beginTransaction();
        try {
            $menu->delete();
            DB::commit();

            return redirect()->route('menus.index')->with('success', 'Menu Deleted');
        } catch (\Exception $e) {
            DB::rollback();
            print_r($e->getMessage());
        }
    }
}
