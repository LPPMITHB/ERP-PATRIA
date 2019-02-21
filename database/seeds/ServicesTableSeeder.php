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
            'description' => 'General Drawing ; GA, lines plan, Hydrostatic, Preliminary Stability, etc',
            'cost_standard_price' => 10000,
            'status' => 1,
            ]);
            
            DB::table('mst_service')->insert([
            'code' => 'SRV0002',
            'description' => 'Construction Drawing ; Const. profile, Midship section Frame section, etc',
            'cost_standard_price' => 12000,
            'status' => 1,
            ]);
            
            DB::table('mst_service')->insert([
            'code' => 'SRV0003',
            'description' => 'System Drawing ; ER layout, Cargo oil system, Fuel oil system, etc',
            'cost_standard_price' => 12000,
            'status' => 1,
            ]);
            
            DB::table('mst_service')->insert([
            'code' => 'SRV0004',
            'description' => 'Electrical Drawing ; Power balance, Wiring diagram, Lighting arranggement, etc',
            'cost_standard_price' => 12000,
            'status' => 1,
            ]);
            
            DB::table('mst_service')->insert([
            'code' => 'SRV0005',
            'description' => 'Bill of Materials, Materials & Component ; PPC Dept',
            'cost_standard_price' => 12000,
            'status' => 0,
            ]);

            DB::table('mst_service')->insert([
            'code' => 'SRV0006',
            'description' => 'Prepare production DWG & As-Built Drawing ; Engineering Dept & PE',
            'cost_standard_price' => 12000,
            'status' => 0,
            ]);

            DB::table('mst_service')->insert([
            'code' => 'SRV0007',
            'description' => 'Prepare facility support ; facility dept',
            'cost_standard_price' => 12000,
            'status' => 0,
            ]);

            DB::table('mst_service')->insert([
            'code' => 'SRV0008',
            'description' => 'Assignment subcont, Approved BOM ; PPIC dept',
            'cost_standard_price' => 12000,
            'status' => 0,
            ]);

            DB::table('mst_service')->insert([
            'code' => 'SRV0009',
            'description' => 'Prepare quality document,Manual and Operation book of Equipment ; Qa/Qc dept',
            'cost_standard_price' => 12000,
            'status' => 0,
            ]);

            DB::table('mst_service')->insert([
            'code' => 'SRV0010',
            'description' => 'Prepare ship document ; HCGA Dept',
            'cost_standard_price' => 12000,
            'status' => 0,
            ]);
    }
}
