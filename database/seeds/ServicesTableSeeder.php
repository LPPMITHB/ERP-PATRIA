<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_service')->insert([
            'code' => 'SRV0001',
            'name' => 'General Drawing',
            'description' => 'GA, lines plan, Hydrostatic, Preliminary Stability, etc',
            'cost_standard_price' => 10000,
            'status' => 1,
            ]);
            
            DB::table('mst_service')->insert([
            'code' => 'SRV0002',
            'name' => 'Construction Drawing',
            'description' => 'Const. profile, Midship section Frame section, etc',
            'cost_standard_price' => 12000,
            'status' => 1,
            ]);
            
            DB::table('mst_service')->insert([
            'code' => 'SRV0003',
            'name' => 'System Drawing',
            'description' => 'ER layout, Cargo oil system, Fuel oil system, etc',
            'cost_standard_price' => 12000,
            'status' => 1,
            ]);
            
            DB::table('mst_service')->insert([
            'code' => 'SRV0004',
            'name' => 'Electrical Drawing',
            'description' => 'Power balance, Wiring diagram, Lighting arranggement, etc',
            'cost_standard_price' => 12000,
            'status' => 1,
            ]);
            
            DB::table('mst_service')->insert([
            'code' => 'SRV0005',
            'name' => 'Bill of Materials, Materials & Component',
            'description' => 'PPC Dept',
            'cost_standard_price' => 12000,
            'status' => 0,
            ]);

            DB::table('mst_service')->insert([
            'code' => 'SRV0006',
            'name' => 'Prepare production DWG & As-Built Drawing' ,
            'description' => 'Engineering Dept & PE',
            'cost_standard_price' => 12000,
            'status' => 0,
            ]);

            DB::table('mst_service')->insert([
            'code' => 'SRV0007',
            'name' => 'Prepare facility support',
            'description' => 'facility dept',
            'cost_standard_price' => 12000,
            'status' => 0,
            ]);

            DB::table('mst_service')->insert([
            'code' => 'SRV0008',
            'name' => 'Assignment subcont, Approved Bom',
            'description' => 'PPIC dept',
            'cost_standard_price' => 12000,
            'status' => 0,
            ]);

            DB::table('mst_service')->insert([
            'code' => 'SRV0009',
            'name' => 'Prepare quality document,Manual and Operation book of Equipment ',
            'description' => 'Qa/Qc dept',
            'cost_standard_price' => 12000,
            'status' => 0,
            ]);

            DB::table('mst_service')->insert([
            'code' => 'SRV0010',
            'name' => 'Prepare ship document',
            'description' => 'HCGA Dept',
            'cost_standard_price' => 12000,
            'status' => 0,
            ]);
    }
}
