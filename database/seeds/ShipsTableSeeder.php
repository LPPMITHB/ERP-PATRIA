<?php

use Illuminate\Database\Seeder;

class ShipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
            DB::table('mst_ship')->insert([
            'type' => 'Tug Boat',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Twin Screw Tug',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Flat Top Barge',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Oil Barge',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Deck Cargo Barge',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Self Propelled Barge',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Aluminium Crew Boat',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Sternloader',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Cruise',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Yacht',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Aircraft carrier',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Warfare Ship',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Offshore Supply Vessel',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Ferry',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Frigate',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Catamaran',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Trawler',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Cargo Ship',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Chemical Tankers',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'type' => 'Shallow Draught Tug Boat',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);

    }
}
