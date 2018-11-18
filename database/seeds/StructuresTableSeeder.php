<?php

use Illuminate\Database\Seeder;

class StructuresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('mst_structure')->insert([
            'code' => 'ST0001', 
            'name' => 'Hull and Outfitting',
            'description' => 'Lambung kapal dan Luaran',
            'is_substructure' => '0',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0101',
            'structure_id' => '1', 
            'is_substructure' => '1',
            'name' => 'Hull and Superstructure',
            'description' => 'Lambung kapal dan Bagian Penunjang',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0102',
            'structure_id' => '1', 
            'is_substructure' => '1',
            'name' => 'Outfitting',
            'description' => 'Bagian Luaran Kapal',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0002',
            'name' => 'Piping',
            'description' => 'Perpipaan Dalam Kapal',
            'is_substructure' => '0',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0201',
            'structure_id' => '4', 
            'is_substructure' => '1',
            'name' => 'Piping',
            'description' => 'Perpipaan Kapal',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0202',
            'structure_id' => '4', 
            'is_substructure' => '1',
            'name' => 'Auxiliary Pump',
            'description' => 'Pompa Penunjang Kapal',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0203',
            'structure_id' => '4', 
            'is_substructure' => '1',
            'name' => 'Bulkpart',
            'description' => 'Komponen-Komponen Lain',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0003',
            'name' => 'Mechanical',
            'description' => 'Tenaga Penggerak Kapal',
            'is_substructure' => '0',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0301',
            'structure_id' => '8', 
            'is_substructure' => '1',
            'name' => 'Engines & Propulsion System',
            'description' => 'Mesin dan Sistem Tenaga Penggerak',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0302',
            'structure_id' => '8', 
            'is_substructure' => '1',
            'name' => 'Auxiliary Machine',
            'description' => 'Mesin Pendukung',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0303',
            'structure_id' => '8', 
            'is_substructure' => '1',
            'name' => 'Navigation & Communication System',
            'description' => 'Navigasi dan Sistem Komunikasi',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0004',
            'name' => 'Electrical',
            'description' => 'Perlistrikan Kapal',
            'is_substructure' => '0',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0401',
            'structure_id' => '12', 
            'is_substructure' => '1',
            'name' => 'Electrical System',
            'description' => 'Sistem Kelistrikan Kapal',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0005',
            'name' => 'Coating',
            'description' => 'Lapisan Pelindung',
            'is_substructure' => '0',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0501',
            'structure_id' => '14', 
            'is_substructure' => '1',
            'name' => 'Blasting & Painting',
            'description' => 'Pelapisan dan Pengecatan Kapal',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0006',
            'name' => 'Interior',
            'description' => 'Barang-barang penunjang',
            'is_substructure' => '0',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0601',
            'structure_id' => '16', 
            'is_substructure' => '1',
            'name' => 'Safety Fire Fighting',
            'description' => 'Pengamanan Terhadap Kebarakaran',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0602',
            'structure_id' => '16', 
            'is_substructure' => '1',
            'name' => 'Accomodation',
            'description' => 'Akomodasi Penunjang',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0603',
            'structure_id' => '16', 
            'is_substructure' => '1',
            'name' => 'Deck Machinery',
            'description' => 'Mesin-Mesin Dalam Anjungan',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0007',
            'name' => 'Others',
            'description' => 'Bagian-bagian lainnya',
            'is_substructure' => '0',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0701',
            'structure_id' => '20', 
            'is_substructure' => '1',
            'name' => 'Sparepart & Inventory',
            'description' => 'Suku Cadang dan Perlengkapan',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0702',
            'structure_id' => '20', 
            'is_substructure' => '1',
            'name' => 'Consumable',
            'description' => 'Barang Habis Pakai',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0703',
            'structure_id' => '20', 
            'is_substructure' => '1',
            'name' => 'Consumable Machinery',
            'description' => 'Barang Habis Pakai Bagian Permesinan',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

        DB::table('mst_structure')->insert([
            'code' => 'ST0704',
            'structure_id' => '20', 
            'is_substructure' => '1',
            'name' => 'Permit',
            'description' => 'Perijinan',
            'is_substructure' => '1',
            'status' => '1',
            'branch_id' => 1,
            'user_id' => 5,
        ]);

    }
}
