<?php

use Illuminate\Database\Seeder;

class QualityPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $quality_plan_role = array(
        //     0 => array(
        //         'id' => 1,
        //         'value' => 'internal',
        //     ),
        //     1 => array(
        //         'id' => 2,
        //         'value' => 'class',
        //     ),
        //     2 => array(
        //         'id' => 3,
        //         'value' => 'owner',
        //     ),
        //     3 => array(
        //         'id' => 4,
        //         'value' => 'regulator'
        //     ),
        // );
        // Quality Plan Role Configuration
        $data_1 = array(1, 2, 3, 4);
        $data_2 = array(1, 2, 4);
        $data_3 = array(1, 3, 4);
        $data_4 = array(2, 3, 4);

        DB::table('mst_quality_plans')->insert([
            'project_id' => 1,
            'tables' => json_encode($data_1),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('mst_quality_plans')->insert([
            'project_id' => 2,
            'tables' => json_encode($data_2),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('mst_quality_plans')->insert([
            'project_id' => 3,
            'tables' => json_encode($data_3),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('mst_quality_plans')->insert([
            'project_id' => 4,
            'tables' => json_encode($data_4),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        //detail
        // Schema::create('mst_quality_plan_details', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->unsignedBigInteger('quality_plan_id');
        //     $table->unsignedBigInteger('quality_type_id');
        //     $table->unsignedBigInteger('quality_plan_role');
        //     $table->unsignedBigInteger('quality_plan_role_action');
        //     $table->timestamps();
        // });
        DB::table('mst_quality_plan_details')->insert([
            'quality_plan_id' => 1,
            'quality_type_id' => 1,
            'quality_plan_role' => 1,
            'quality_plan_role_action' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        DB::table('mst_quality_plan_details')->insert([
            'quality_plan_id' => 1,
            'quality_type_id' => 2,
            'quality_plan_role' => 2,
            'quality_plan_role_action' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        DB::table('mst_quality_plan_details')->insert([
            'quality_plan_id' => 1,
            'quality_type_id' => 3,
            'quality_plan_role' => 3,
            'quality_plan_role_action' => 2,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        DB::table('mst_quality_plan_details')->insert([
            'quality_plan_id' => 1,
            'quality_type_id' => 3,
            'quality_plan_role' => 4,
            'quality_plan_role_action' => 2,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        //2
        DB::table('mst_quality_plan_details')->insert([
            'quality_plan_id' => 2,
            'quality_type_id' => 1,
            'quality_plan_role' => 1,
            'quality_plan_role_action' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        DB::table('mst_quality_plan_details')->insert([
            'quality_plan_id' => 2,
            'quality_type_id' => 2,
            'quality_plan_role' => 2,
            'quality_plan_role_action' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        DB::table('mst_quality_plan_details')->insert([
            'quality_plan_id' => 2,
            'quality_type_id' => 3,
            'quality_plan_role' => 4,
            'quality_plan_role_action' => 2,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        //3
        DB::table('mst_quality_plan_details')->insert([
            'quality_plan_id' => 3,
            'quality_type_id' => 7,
            'quality_plan_role' => 1,
            'quality_plan_role_action' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        DB::table('mst_quality_plan_details')->insert([
            'quality_plan_id' => 3,
            'quality_type_id' => 6,
            'quality_plan_role' => 3,
            'quality_plan_role_action' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        DB::table('mst_quality_plan_details')->insert([
            'quality_plan_id' => 3,
            'quality_type_id' => 5,
            'quality_plan_role' => 4,
            'quality_plan_role_action' => 2,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        //4
        DB::table('mst_quality_plan_details')->insert([
            'quality_plan_id' => 4,
            'quality_type_id' => 7,
            'quality_plan_role' => 2,
            'quality_plan_role_action' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        DB::table('mst_quality_plan_details')->insert([
            'quality_plan_id' => 4,
            'quality_type_id' => 3,
            'quality_plan_role' => 3,
            'quality_plan_role_action' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        DB::table('mst_quality_plan_details')->insert([
            'quality_plan_id' => 4,
            'quality_type_id' => 2,
            'quality_plan_role' => 4,
            'quality_plan_role_action' => 2,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
    }
}
