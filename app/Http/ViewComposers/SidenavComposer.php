<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Menu;
use App\Models\Sidenav;
use Auth;

class SidenavComposer
{
    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        // Type here
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $roleUser = Auth::user()->role->name;
        $menusActive = Menu::where('is_active', true)->get();

        $menus = array();
        $child = array();
        foreach ($menusActive as $menu){
            $roles = explode(',',$menu->roles);
            $status = 0;
            foreach($roles as $role){
                if($role == $roleUser){
                    $status = 1;
                }
            }
            if($status == 1){
                if($menu->menu_id != ""){
                    if($menu->menu->menu_id != ""){
                        $menus[] = $menu->menu->menu;
                    }
                    $menus[] = $menu->menu; 
                    $child[] = $menu;
                }else{
                    $menus[] = $menu; 
                }
            }
        }
        $sidenavs = Sidenav::all();
        $menus = array_unique($menus);
        $view->with('menus', $menus)->with('child',$child)->with('sidenavs', $sidenavs)->with('roleUser',$roleUser);
    }
}