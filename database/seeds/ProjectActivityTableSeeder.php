<?php

use Illuminate\Database\Seeder;

class ProjectActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('pro_activity')->insert([
            'code' => 'PRA0001',
            'name' => 'PRA 001 001',
            'description' => 'PRA 001 001',
            'status' => 1,
            'wbs_id' => 1,
            'planned_duration' => 7,
            'planned_start_date' => '2018-9-1',
            'planned_end_date' => '2018-9-7',
            'actual_duration' => 14,
            'actual_start_date' => '2018-9-2',
            'actual_end_date' => '2018-9-15',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0002',
            'name' => 'PRA 001 002',
            'description' => 'PRA 001 002',
            'status' => 1,
            'wbs_id' => 1,
            'planned_duration' => 23,
            'planned_start_date' => '2018-9-12',
            'planned_end_date' => '2018-10-4',
            'actual_duration' => 20,
            'actual_start_date' => '2018-9-13',
            'actual_end_date' => '2018-10-2',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0003',
            'name' => 'PRA 001 003',
            'description' => 'PRA 001 003',
            'status' => 1,
            'wbs_id' => 1,
            'planned_duration' => 25,
            'planned_start_date' => '2018-9-1',
            'planned_end_date' => '2018-9-25',
            'actual_duration' => 16,
            'actual_start_date' => '2018-9-3',
            'actual_end_date' => '2018-9-18',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0004',
            'name' => 'PRA 002 004',
            'description' => 'PRA 002 004',
            'status' => 1,
            'wbs_id' => 2,
            'planned_duration' => 10,
            'planned_start_date' => '2018-9-1',
            'planned_end_date' => '2018-9-10',
            'actual_duration' => 11,
            'actual_start_date' => '2018-9-5',
            'actual_end_date' => '2018-9-15',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0005',
            'name' => 'PRA 002 005',
            'description' => 'PRA 002 005',
            'status' => 1,
            'wbs_id' => 2,
            'planned_duration' => 10,
            'planned_start_date' => '2018-9-2',
            'planned_end_date' => '2018-9-11',
            'actual_duration' => 10,
            'actual_start_date' => '2018-9-2',
            'actual_end_date' => '2018-9-11',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //06
        DB::table('pro_activity')->insert([
            'code' => 'PRA0006',
            'name' => 'General Drawing',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 23,
            'planned_duration' => 26,
            'planned_start_date' => '2018-12-30',
            'planned_end_date' => '2019-1-24',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0007',
            'name' => 'Construction Drawing',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 23,
            'planned_duration' => 15,
            'planned_start_date' => '2019-1-1',
            'planned_end_date' => '2019-1-15',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0008',
            'name' => 'System Drawing',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 23,
            'planned_duration' => 31,
            'planned_start_date' => '2019-1-1',
            'planned_end_date' => '2019-1-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0009',
            'name' => 'Electrical Drawing',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 23,
            'planned_duration' => 14,
            'planned_start_date' => '2019-1-18',
            'planned_end_date' => '2019-1-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0010',
            'name' => 'Submission DWG to class',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 23,
            'planned_duration' => 18,
            'planned_start_date' => '2019-1-14',
            'planned_end_date' => '2019-1-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0011',
            'name' => 'Approved DWG to class',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 23,
            'planned_duration' => 23,
            'planned_start_date' => '2019-1-24',
            'planned_end_date' => '2019-2-15',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0012',
            'name' => 'Bill of Materials, Materials & Components',
            'description' => 'PPC Dept',
            'status' => 1,
            'wbs_id' => 24,
            'planned_duration' => 11,
            'planned_start_date' => '2019-1-17',
            'planned_end_date' => '2019-1-27',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0013',
            'name' => 'Prepare production DWG',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 24,
            'planned_duration' => 17,
            'planned_start_date' => '2019-1-15',
            'planned_end_date' => '2019-1-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //14
        DB::table('pro_activity')->insert([
            'code' => 'PRA0014',
            'name' => 'Prepare facility support',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 24,
            'planned_duration' => 22,
            'planned_start_date' => '2019-1-29',
            'planned_end_date' => '2019-1-19',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0015',
            'name' => 'Assignment subcont, Approve BOM',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 24,
            'planned_duration' => 20,
            'planned_start_date' => '2018-12-29',
            'planned_end_date' => '2019-1-17',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0016',
            'name' => 'Prepare quality document, manual, and operation book of equipment',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 24,
            'planned_duration' => 152,
            'planned_start_date' => '2018-12-29',
            'planned_end_date' => '2019-5-28',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0017',
            'name' => 'Prepare ship document',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 24,
            'planned_duration' => 152,
            'planned_start_date' => '2018-12-29',
            'planned_end_date' => '2019-5-28',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //18
        DB::table('pro_activity')->insert([
            'code' => 'PRA0018',
            'name' => 'Raw Mateial',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 25,
            'planned_duration' => 59,
            'planned_start_date' => '2019-1-1',
            'planned_end_date' => '2019-2-28',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0019',
            'name' => 'Generator Set',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 25,
            'planned_duration' => 84,
            'planned_start_date' => '2019-1-18',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0020',
            'name' => 'Deck Machineries & compressor',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 25,
            'planned_duration' => 84,
            'planned_start_date' => '2019-1-18',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0021',
            'name' => 'Pumps, pipe, valve dan fittings',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 25,
            'planned_duration' => 84,
            'planned_start_date' => '2019-1-18',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0022',
            'name' => 'Safety Equipment',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 25,
            'planned_duration' => 84,
            'planned_start_date' => '2019-1-18',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);


        DB::table('pro_activity')->insert([
            'code' => 'PRA0023',
            'name' => 'Doors, windows, skylights and manhole',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 25,
            'planned_duration' => 61,
            'planned_start_date' => '2019-1-18',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0024',
            'name' => 'Electrical, panel & MSB',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 25,
            'planned_duration' => 84,
            'planned_start_date' => '2019-1-18',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0025',
            'name' => 'Lighting, Navigation and Communication',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 25,
            'planned_duration' => 56,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0026',
            'name' => 'Coating and Anodes',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 25,
            'planned_duration' => 56,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0027',
            'name' => 'Interior & Carpentry',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 25,
            'planned_duration' => 56,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0028',
            'name' => 'Bollards, Tyre fender and chain',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 25,
            'planned_duration' => 56,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //29 Transom
        DB::table('pro_activity')->insert([
            'code' => 'PRA0029',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 29,
            'planned_duration' => 8,
            'planned_start_date' => '2019-2-1',
            'planned_end_date' => '2019-2-8',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0030',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 29,
            'planned_duration' => 8,
            'planned_start_date' => '2019-2-9',
            'planned_end_date' => '2019-2-16',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0031',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 29,
            'planned_duration' => 8,
            'planned_start_date' => '2019-2-12',
            'planned_end_date' => '2019-2-19',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0032',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 29,
            'planned_duration' => 8,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-22',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0033',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 29,
            'planned_duration' => 4,
            'planned_start_date' => '2019-2-23',
            'planned_end_date' => '2019-2-26',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //34 Blok 1
        DB::table('pro_activity')->insert([
            'code' => 'PRA0034',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 30,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-1',
            'planned_end_date' => '2019-2-14',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0035',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 30,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-28',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0036',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 30,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-28',
            'planned_end_date' => '2019-3-13',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0037',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 30,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-14',
            'planned_end_date' => '2019-3-27',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0038',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 30,
            'planned_duration' => 6,
            'planned_start_date' => '2019-3-28',
            'planned_end_date' => '2019-4-2',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //39 Block 2
        DB::table('pro_activity')->insert([
            'code' => 'PRA0039',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 31,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-1',
            'planned_end_date' => '2019-2-14',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0040',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 31,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-28',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0041',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 31,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-28',
            'planned_end_date' => '2019-3-13',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0042',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 31,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-14',
            'planned_end_date' => '2019-3-27',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0043',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 31,
            'planned_duration' => 6,
            'planned_start_date' => '2019-3-28',
            'planned_end_date' => '2019-4-2',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //44 Block 3
        DB::table('pro_activity')->insert([
            'code' => 'PRA0044',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 32,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-1',
            'planned_end_date' => '2019-2-14',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0045',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 32,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-28',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0046',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 32,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-28',
            'planned_end_date' => '2019-3-13',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0047',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 32,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-14',
            'planned_end_date' => '2019-3-27',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0048',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 32,
            'planned_duration' => 6,
            'planned_start_date' => '2019-3-28',
            'planned_end_date' => '2019-4-2',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //49 Block 4
        DB::table('pro_activity')->insert([
            'code' => 'PRA0049',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 33,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-1',
            'planned_end_date' => '2019-2-14',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0050',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 33,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-28',
            'planned_end_date' => '2019-3-13',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0051',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 33,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-14',
            'planned_end_date' => '2019-3-27',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0052',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 33,
            'planned_duration' => 6,
            'planned_start_date' => '2019-3-28',
            'planned_end_date' => '2019-4-2',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //53 Block 5
        DB::table('pro_activity')->insert([
            'code' => 'PRA0053',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 34,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-1',
            'planned_end_date' => '2019-2-14',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0054',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 34,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-28',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0055',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 34,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-28',
            'planned_end_date' => '2019-3-13',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0056',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 34,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-14',
            'planned_end_date' => '2019-3-27',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0057',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 34,
            'planned_duration' => 6,
            'planned_start_date' => '2019-3-28',
            'planned_end_date' => '2019-4-2',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //58 Block 6
        DB::table('pro_activity')->insert([
            'code' => 'PRA0058',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 35,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-1',
            'planned_end_date' => '2019-2-14',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0059',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 35,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-28',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0060',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 35,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-28',
            'planned_end_date' => '2019-3-13',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0061',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 35,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-14',
            'planned_end_date' => '2019-3-27',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0062',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 35,
            'planned_duration' => 6,
            'planned_start_date' => '2019-3-28',
            'planned_end_date' => '2019-4-2',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //63 Block 1
        DB::table('pro_activity')->insert([
            'code' => 'PRA0063',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 37,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-8',
            'planned_end_date' => '2019-2-21',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0064',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 37,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-22',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0065',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 37,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0066',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 37,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0067',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 37,
            'planned_duration' => 5,
            'planned_start_date' => '2019-4-4',
            'planned_end_date' => '2019-4-8',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //68 Block 2
        DB::table('pro_activity')->insert([
            'code' => 'PRA0068',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 38,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-8',
            'planned_end_date' => '2019-2-21',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0069',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 38,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-22',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0070',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 38,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0071',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 38,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0072',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 38,
            'planned_duration' => 5,
            'planned_start_date' => '2019-4-4',
            'planned_end_date' => '2019-4-8',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //73 Block 3
        DB::table('pro_activity')->insert([
            'code' => 'PRA0073',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 39,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-8',
            'planned_end_date' => '2019-2-21',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0074',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 39,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-22',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0075',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 39,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0076',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 39,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0077',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 39,
            'planned_duration' => 5,
            'planned_start_date' => '2019-4-4',
            'planned_end_date' => '2019-4-8',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //78 Block 4
        DB::table('pro_activity')->insert([
            'code' => 'PRA0078',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 40,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-8',
            'planned_end_date' => '2019-2-21',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0079',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 40,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-22',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0080',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 40,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0081',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 40,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0082',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 40,
            'planned_duration' => 5,
            'planned_start_date' => '2019-4-4',
            'planned_end_date' => '2019-4-8',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //83 Block 5
        DB::table('pro_activity')->insert([
            'code' => 'PRA0083',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 41,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-8',
            'planned_end_date' => '2019-2-21',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0084',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 41,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-22',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0085',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 41,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0086',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 41,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0087',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 41,
            'planned_duration' => 5,
            'planned_start_date' => '2019-4-4',
            'planned_end_date' => '2019-4-8',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //88 Block 6
        DB::table('pro_activity')->insert([
            'code' => 'PRA0088',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 42,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-8',
            'planned_end_date' => '2019-2-21',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0089',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 42,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-22',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0090',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 42,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0091',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 42,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0092',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 42,
            'planned_duration' => 5,
            'planned_start_date' => '2019-4-4',
            'planned_end_date' => '2019-4-8',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //93 Block 1
        DB::table('pro_activity')->insert([
            'code' => 'PRA0093',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 44,
            'planned_duration' => 11,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-25',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0094',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 44,
            'planned_duration' => 12,
            'planned_start_date' => '2019-2-24',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0095',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 44,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0096',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 44,
            'planned_duration' => 11,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-3-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0097',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 44,
            'planned_duration' => 4,
            'planned_start_date' => '2019-3-31',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //98 Block 2
        DB::table('pro_activity')->insert([
            'code' => 'PRA0098',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 45,
            'planned_duration' => 11,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-25',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0099',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 45,
            'planned_duration' => 12,
            'planned_start_date' => '2019-2-24',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0100',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 45,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0101',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 45,
            'planned_duration' => 11,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-3-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0102',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 45,
            'planned_duration' => 4,
            'planned_start_date' => '2019-3-31',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //103 Block 3
        DB::table('pro_activity')->insert([
            'code' => 'PRA0103',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 46,
            'planned_duration' => 11,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-25',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0104',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 46,
            'planned_duration' => 12,
            'planned_start_date' => '2019-2-24',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0105',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 46,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0106',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 46,
            'planned_duration' => 11,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-3-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0107',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 46,
            'planned_duration' => 4,
            'planned_start_date' => '2019-3-31',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //104 Block 4
        DB::table('pro_activity')->insert([
            'code' => 'PRA0108',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 47,
            'planned_duration' => 11,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-25',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0109',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 47,
            'planned_duration' => 12,
            'planned_start_date' => '2019-2-24',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0110',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 47,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0111',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 47,
            'planned_duration' => 11,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-3-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0112',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 47,
            'planned_duration' => 4,
            'planned_start_date' => '2019-3-31',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //113 Block 6
        DB::table('pro_activity')->insert([
            'code' => 'PRA0113',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 48,
            'planned_duration' => 11,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-25',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0114',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 48,
            'planned_duration' => 12,
            'planned_start_date' => '2019-2-24',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0115',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 48,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0116',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 48,
            'planned_duration' => 11,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-3-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0117',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 48,
            'planned_duration' => 4,
            'planned_start_date' => '2019-3-31',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //118 Block 2
        DB::table('pro_activity')->insert([
            'code' => 'PRA0118',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 50,
            'planned_duration' => 11,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-25',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0119',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 50,
            'planned_duration' => 12,
            'planned_start_date' => '2019-2-24',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0120',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 50,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0121',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 50,
            'planned_duration' => 11,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-3-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0122',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 50,
            'planned_duration' => 4,
            'planned_start_date' => '2019-3-31',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //123 Block 3
        DB::table('pro_activity')->insert([
            'code' => 'PRA0123',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 51,
            'planned_duration' => 11,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-25',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0124',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 51,
            'planned_duration' => 12,
            'planned_start_date' => '2019-2-24',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0125',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 51,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0126',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 51,
            'planned_duration' => 11,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-3-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0127',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 51,
            'planned_duration' => 4,
            'planned_start_date' => '2019-3-31',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //128 Block 4
        DB::table('pro_activity')->insert([
            'code' => 'PRA0128',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 11,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-25',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0129',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 12,
            'planned_start_date' => '2019-2-24',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0130',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0131',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 11,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-3-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0132',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 4,
            'planned_start_date' => '2019-3-31',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //133 Block 5
        DB::table('pro_activity')->insert([
            'code' => 'PRA0133',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 11,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-25',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0134',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 12,
            'planned_start_date' => '2019-2-24',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0135',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0136',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 11,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-3-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0137',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 4,
            'planned_start_date' => '2019-3-31',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //138 Block 6
        DB::table('pro_activity')->insert([
            'code' => 'PRA0138',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 11,
            'planned_start_date' => '2019-2-15',
            'planned_end_date' => '2019-2-25',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0139',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 12,
            'planned_start_date' => '2019-2-24',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0140',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0141',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 11,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-3-31',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0142',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 52,
            'planned_duration' => 4,
            'planned_start_date' => '2019-3-31',
            'planned_end_date' => '2019-4-3',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //143 Block 1 Side Sheel
        DB::table('pro_activity')->insert([
            'code' => 'PRA0143',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 54,
            'planned_duration' => 10,
            'planned_start_date' => '2019-2-22',
            'planned_end_date' => '2019-3-2',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0144',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 54,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-28',
            'planned_end_date' => '2019-3-13',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0145',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 54,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-14',
            'planned_end_date' => '2019-3-27',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0146',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 54,
            'planned_duration' => 9,
            'planned_start_date' => '2019-3-30',
            'planned_end_date' => '2019-4-7',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0147',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 54,
            'planned_duration' => 3,
            'planned_start_date' => '2019-4-7',
            'planned_end_date' => '2019-4-9',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0148',
            'name' => 'Side Sheel platting',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 54,
            'planned_duration' => 9,
            'planned_start_date' => '2019-4-9',
            'planned_end_date' => '2019-4-17',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //149 Block 2 Side Sheel
        DB::table('pro_activity')->insert([
            'code' => 'PRA0149',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 55,
            'planned_duration' => 10,
            'planned_start_date' => '2019-2-22',
            'planned_end_date' => '2019-3-2',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0150',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 55,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-28',
            'planned_end_date' => '2019-3-13',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0151',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 55,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-14',
            'planned_end_date' => '2019-3-27',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0152',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 55,
            'planned_duration' => 9,
            'planned_start_date' => '2019-3-30',
            'planned_end_date' => '2019-4-7',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0153',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 55,
            'planned_duration' => 3,
            'planned_start_date' => '2019-4-7',
            'planned_end_date' => '2019-4-9',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0154',
            'name' => 'Side sheel platting',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 55,
            'planned_duration' => 9,
            'planned_start_date' => '2019-4-9',
            'planned_end_date' => '2019-4-17',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //155 Block 3 Side Sheel
        DB::table('pro_activity')->insert([
            'code' => 'PRA0155',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 55,
            'planned_duration' => 10,
            'planned_start_date' => '2019-2-22',
            'planned_end_date' => '2019-3-2',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0156',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 55,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-28',
            'planned_end_date' => '2019-3-13',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0157',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 55,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-14',
            'planned_end_date' => '2019-3-27',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0158',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 55,
            'planned_duration' => 9,
            'planned_start_date' => '2019-3-30',
            'planned_end_date' => '2019-4-7',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0159',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 55,
            'planned_duration' => 3,
            'planned_start_date' => '2019-4-7',
            'planned_end_date' => '2019-4-9',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0160',
            'name' => 'Side sheel platting',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 55,
            'planned_duration' => 9,
            'planned_start_date' => '2019-4-9',
            'planned_end_date' => '2019-4-17',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //161 Block 4 Side Sheel
        DB::table('pro_activity')->insert([
            'code' => 'PRA0161',
            'name' => 'Material preparation',
            'description' => 'Cutting, Shearing, Bending',
            'status' => 1,
            'wbs_id' => 56,
            'planned_duration' => 10,
            'planned_start_date' => '2019-2-22',
            'planned_end_date' => '2019-3-2',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0162',
            'name' => 'Fit-up panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 56,
            'planned_duration' => 14,
            'planned_start_date' => '2019-2-28',
            'planned_end_date' => '2019-3-13',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0163',
            'name' => 'Welding panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 56,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-14',
            'planned_end_date' => '2019-3-27',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0164',
            'name' => 'Erection panel to building berth',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 56,
            'planned_duration' => 9,
            'planned_start_date' => '2019-3-30',
            'planned_end_date' => '2019-4-7',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0165',
            'name' => 'Inspection panel',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 56,
            'planned_duration' => 3,
            'planned_start_date' => '2019-4-7',
            'planned_end_date' => '2019-4-9',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0166',
            'name' => 'Side sheel platting',
            'description' => 'sub-assembly',
            'status' => 1,
            'wbs_id' => 56,
            'planned_duration' => 9,
            'planned_start_date' => '2019-4-9',
            'planned_end_date' => '2019-4-17',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //167 block 5

        //172 block 6

        //178 block 1 main deck

        //183 block 2

        //188 block 3

        //193 block 4

        //198 block 5

        //203 block 6

        //208 block 8

        //213 block 9

        //218 block 7

        //223
        DB::table('pro_activity')->insert([
            'code' => 'PRA0223',
            'name' => 'Material Preparation',
            'description' => 'cutting, shearing, bending',
            'status' => 1,
            'wbs_id' => 72,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //224
        DB::table('pro_activity')->insert([
            'code' => 'PRA0224',
            'name' => 'Ladders, step stair & guard railing',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 73,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-28',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //225
        DB::table('pro_activity')->insert([
            'code' => 'PRA0225',
            'name' => 'Hatch coaming & manhole',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 73,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-28',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //226
        DB::table('pro_activity')->insert([
            'code' => 'PRA0226',
            'name' => 'Platform Deck',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 73,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-28',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0227',
            'name' => 'Bulwark/railing',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 73,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-28',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0228',
            'name' => 'Bollard, smith bracket',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 73,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-28',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0229',
            'name' => 'Main generator & Harbour generator seating',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 73,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-28',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0230',
            'name' => 'Vessel name, Draft, Plimsol mark',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 73,
            'planned_duration' => 14,
            'planned_start_date' => '2019-3-28',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0234',
            'name' => 'Anodes Sitting',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 73,
            'planned_duration' => 7,
            'planned_start_date' => '2019-4-18',
            'planned_end_date' => '2019-4-24',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //235
        DB::table('pro_activity')->insert([
            'code' => 'PRA0235',
            'name' => 'Ladders, step stair & guard railing',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 74,
            'planned_duration' => 14,
            'planned_start_date' => '2019-4-4',
            'planned_end_date' => '2019-4-17',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0236',
            'name' => 'Hatch coaming & manhole',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 74,
            'planned_duration' => 14,
            'planned_start_date' => '2019-4-4',
            'planned_end_date' => '2019-4-17',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0237',
            'name' => 'Platform Deck',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 74,
            'planned_duration' => 14,
            'planned_start_date' => '2019-4-4',
            'planned_end_date' => '2019-4-17',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0238',
            'name' => 'Bulwark/railing',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 74,
            'planned_duration' => 14,
            'planned_start_date' => '2019-4-4',
            'planned_end_date' => '2019-4-17',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0245',
            'name' => 'Anodes',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 74,
            'planned_duration' => 7,
            'planned_start_date' => '2019-4-18',
            'planned_end_date' => '2019-4-24',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //246 Cargo system
        DB::table('pro_activity')->insert([
            'code' => 'PRA0246',
            'name' => 'Marking & Cutting',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 76,
            'planned_duration' => 15,
            'planned_start_date' => '2019-2-21',
            'planned_end_date' => '2019-3-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0247',
            'name' => 'Wedding spools',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 76,
            'planned_duration' => 15,
            'planned_start_date' => '2019-3-6',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0248',
            'name' => 'Inhouse test spools',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 76,
            'planned_duration' => 9,
            'planned_start_date' => '2019-3-12',
            'planned_end_date' => '2019-3-20',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0249',
            'name' => 'Fit-up spools on board',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 76,
            'planned_duration' => 21,
            'planned_start_date' => '2019-3-21',
            'planned_end_date' => '2019-4-10',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0250',
            'name' => 'Welding spools on board',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 76,
            'planned_duration' => 14,
            'planned_start_date' => '2019-4-1',
            'planned_end_date' => '2019-4-14',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0251',
            'name' => 'Connection to pump system',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 76,
            'planned_duration' => 7,
            'planned_start_date' => '2019-4-11',
            'planned_end_date' => '2019-4-17',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0252',
            'name' => 'Testing on board',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 76,
            'planned_duration' => 7,
            'planned_start_date' => '2019-4-18',
            'planned_end_date' => '2019-4-24',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //253 General Service

        //260 Bilge

        //267 Emergency Fire Fighting System

        //274 Freshwater

        //281 Fuel Oil System

        //288 Holding tank

        //295 Air Compressor

        //302 CO2 fixed system

        //309 Electric Installation
        DB::table('pro_activity')->insert([
            'code' => 'PRA0309',
            'name' => 'Marking, Fit-up and welding cable coaming & tray',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 86,
            'planned_duration' => 12,
            'planned_start_date' => '2019-3-1',
            'planned_end_date' => '2019-3-12',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0310',
            'name' => 'Cable laying',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 86,
            'planned_duration' => 13,
            'planned_start_date' => '2019-3-14',
            'planned_end_date' => '2019-3-26',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0311',
            'name' => 'Install Distribution Box and MSB',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 86,
            'planned_duration' => 13,
            'planned_start_date' => '2019-3-14',
            'planned_end_date' => '2019-3-26',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //318
        DB::table('pro_activity')->insert([
            'code' => 'PRA0318',
            'name' => 'Fit-up/Leveling sitting main generator set and harbour generator',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 87,
            'planned_duration' => 30,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-4-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0319',
            'name' => 'Installation of Diesel Generator Set & Harbour generator',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 87,
            'planned_duration' => 30,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-4-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0320',
            'name' => 'Fit-up / Leveling sitting windlass',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 87,
            'planned_duration' => 30,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-4-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0321',
            'name' => 'Installation windlass',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 87,
            'planned_duration' => 30,
            'planned_start_date' => '2019-3-7',
            'planned_end_date' => '2019-4-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //322 Coating
        DB::table('pro_activity')->insert([
            'code' => 'PRA0322',
            'name' => 'Material and Surface preparation',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 88,
            'planned_duration' => 46,
            'planned_start_date' => '2019-2-21',
            'planned_end_date' => '2019-4-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0323',
            'name' => 'Internal Hull',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 88,
            'planned_duration' => 71,
            'planned_start_date' => '2019-2-28',
            'planned_end_date' => '2019-5-8',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0324',
            'name' => 'External Hull',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 88,
            'planned_duration' => 9,
            'planned_start_date' => '2019-4-13',
            'planned_end_date' => '2019-4-21',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //327 Interior
        DB::table('pro_activity')->insert([
            'code' => 'PRA0327',
            'name' => 'Flooring preparation & installation',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 89,
            'planned_duration' => 15,
            'planned_start_date' => '2019-4-24',
            'planned_end_date' => '2019-5-8',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0328',
            'name' => 'making, fitup partition & ceiling',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 89,
            'planned_duration' => 10,
            'planned_start_date' => '2019-5-6',
            'planned_end_date' => '2019-5-15',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0329',
            'name' => 'making, fitup & install furniture in accomodation room',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 89,
            'planned_duration' => 13,
            'planned_start_date' => '2019-5-8',
            'planned_end_date' => '2019-5-21',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //330 Testing
        DB::table('pro_activity')->insert([
            'code' => 'PRA0330',
            'name' => 'Load Test generator set & MSB',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 91,
            'planned_duration' => 6,
            'planned_start_date' => '2019-4-30',
            'planned_end_date' => '2019-5-5',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0331',
            'name' => 'Pumps System',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 91,
            'planned_duration' => 11,
            'planned_start_date' => '2019-5-4',
            'planned_end_date' => '2019-5-14',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0332',
            'name' => 'Windlass',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 91,
            'planned_duration' => 8,
            'planned_start_date' => '2019-5-4',
            'planned_end_date' => '2019-5-11',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //338 Delivery
        DB::table('pro_activity')->insert([
            'code' => 'PRA0338',
            'name' => 'Handover statement (BAST)',
            'description' => '-',
            'status' => 1,
            'wbs_id' => 92,
            'planned_duration' => 7,
            'planned_start_date' => '2019-5-22',
            'planned_end_date' => '2019-5-28',
            'user_id' => 5,
            'branch_id' => 1,
        ]);







        


    }
}
