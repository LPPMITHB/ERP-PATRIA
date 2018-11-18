<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Configuration;

class MainComposer
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
        $defaultSkin = Configuration::get('default-skin');

        $view->with('defaultSkin', $defaultSkin);
    }
}