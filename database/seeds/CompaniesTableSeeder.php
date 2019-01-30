<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('mst_company')->insert([
            'code' => 'CP0001',
            'name' => 'Patria Maritim Perkasa',
            'address' => 'Batam',
            'phone_number' => '0226650343',
            'fax' => '0226650344',
            'email' => 'pmp@branch.com',
            'status' => 1,
        ]);

        DB::table('mst_company')->insert([
            'code' => 'CP0002',
            'name' => 'Patria Maritime Industry',
            'address' => 'Banjarmasin',
            'phone_number' => '0226650340',
            'fax' => '0226650341',
            'email' => 'pami@branch.com',
            'status' => 1,
        ]);
    }
}

