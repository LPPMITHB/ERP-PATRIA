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
            'code' => 'SH0001',
            'name' => 'Brahma',
            'type' => 'Tug Boat',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0002',
            'name' => 'Tanggon',
            'type' => 'Twin Screw Tug',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0003',
            'name' => 'Tongka',
            'type' => 'Flat Top Barge',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0004',
            'name' => 'Transko Ranao',
            'type' => 'Oil Barge',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0005',
            'name' => 'Mandiri Anyelir',
            'type' => 'Deck Cargo Barge',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0006',
            'name' => 'Lais',
            'type' => 'Self Propelled Barge',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0007',
            'name' => 'Antasena',
            'type' => 'Aluminium Crew Boat',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0008',
            'name' => 'Kamlan',
            'type' => 'Sternloader',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0009',
            'name' => 'Patria Mark LV',
            'type' => 'Cruise',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0010',
            'name' => 'Voyacht',
            'type' => 'Yacht',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0011',
            'name' => 'Greenlam',
            'type' => 'Aircraft carrier',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0012',
            'name' => 'Hercules',
            'type' => 'Warfare Ship',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0013',
            'name' => 'Pelita Anugerah Bahari',
            'type' => 'Offshore Supply Vessel',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0014',
            'name' => 'Alfa III',
            'type' => 'Ferry',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0015',
            'name' => 'Overhold',
            'type' => 'Frigate',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0016',
            'name' => 'Satinn',
            'type' => 'Catamaran',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0017',
            'name' => 'Alphazap',
            'type' => 'Trawler',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0018',
            'name' => 'Bintang 10',
            'type' => 'Cargo Ship',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0019',
            'name' => 'Chemicst',
            'type' => 'Chemical Tankers',
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_ship')->insert([
            'code' => 'SH0020',
            'name' => 'Pusher CL',
            'type' => 'Shallow Draught Tug BOat',
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);

    }
}
