<?php

use Illuminate\Database\Seeder\Sidenav;
use Illuminate\Database\Seeder;
use App\Models\Menu; 

class ConfigurationMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * ========================================================================
         * =                              BUILDING STAGE
         * ========================================================================
         */


        /**
         * ========================================================================
         * =                                REPAIRING STAGE
         * ========================================================================
         */

        /**
         * ========================================================================
         * =                                ALL STAGE
         * ========================================================================
         */

        //menu
        $menus = Menu::where('route_name', 'menus.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $menus,
            'route_name' => 'menus.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $menus,
            'route_name' => 'menus.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $menus,
            'route_name' => 'menus.edit',
        ]);

        //appreance
        $appearance = Menu::where('route_name', 'appearance.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $appearance,
            'route_name' => 'appearance.index',
        ]);

        // DB::table('sidenav')->insert([
        //     'menu_id' => $appearance,
        //     'route_name' => 'appearance.create',
        // ]);

        // DB::table('sidenav')->insert([
        //     'menu_id' => $appearance,
        //     'route_name' => 'appearance.edit',
        // ]);

        //default passowrd
        $changeDefaultPassword = Menu::where('route_name', 'user.changeDefaultPassword')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $changeDefaultPassword,
            'route_name' => 'user.changeDefaultPassword',
        ]);

        //density
        $density = Menu::where('route_name', 'density.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $density,
            'route_name' => 'density.index',
        ]);

        //material family
        $materialFamily = Menu::where('route_name', 'material_family.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $materialFamily,
            'route_name' => 'material_family.index',
        ]);

        //payment terms
        $paymentTerms = Menu::where('route_name', 'payment_terms.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $paymentTerms,
            'route_name' => 'payment_terms.index',
        ]);

        //delivery terms
        $deliveryTerms = Menu::where('route_name', 'delivery_terms.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $deliveryTerms,
            'route_name' => 'delivery_terms.index',
        ]);

        //
        //uom
        $uom = Menu::where('route_name', 'unit_of_measurement.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $uom,
            'route_name' => 'unit_of_measurement.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $uom,
            'route_name' => 'unit_of_measurement.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $uom,
            'route_name' => 'unit_of_measurement.edit',
        ]);

        //currnecy
        $currencies = Menu::where('route_name', 'currencies.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $currencies,
            'route_name' => 'currencies.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $currencies,
            'route_name' => 'currencies.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $currencies,
            'route_name' => 'currencies.edit',
        ]);

        //dimension type
        $dimension_type = Menu::where('route_name', 'dimension_type.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $dimension_type,
            'route_name' => 'dimension_type.index',
        ]);

        //weather
        $weather = Menu::where('route_name', 'weather.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $weather,
            'route_name' => 'weather.index',
        ]);

        //tidal
        $tidal = Menu::where('route_name', 'tidal.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $tidal,
            'route_name' => 'tidal.index',
        ]);

        //approval
        $approval_config = Menu::where('route_name', 'approval.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $approval_config,
            'route_name' => 'approval.index',
        ]);
    }
}
