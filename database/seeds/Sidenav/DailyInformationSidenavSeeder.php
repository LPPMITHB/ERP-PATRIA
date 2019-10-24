<?php


use Illuminate\Database\Seeder;
use App\Models\Menu; 

class DailyInformationSidenavSeeder extends Seeder
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

        $dailyManHour = Menu::where('route_name', 'daily_man_hour.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $dailyManHour,
            'route_name' => 'daily_man_hour.selectProject',
        ]);
        DB::table('sidenav')->insert([
            'menu_id' => $dailyManHour,
            'route_name' => 'daily_man_hour.create',
        ]);

        $daily_weather = Menu::where('route_name', 'daily_weather.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $daily_weather,
            'route_name' => 'daily_weather.index',
        ]);

        $daily_tidal = Menu::where('route_name', 'daily_tidal.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $daily_tidal,
            'route_name' => 'daily_tidal.index',
        ]);
    }
}
