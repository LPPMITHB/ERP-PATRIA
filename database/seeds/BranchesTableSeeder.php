<?php

use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('mst_branch')->insert([
            'code' => 'BR0001',
            'name' => 'Patria Maritim Perkasa',
            'address' => 'Kav.20 Dapur 12 Sei Lekop',
            'city' => 'Sagulung, Batam',
            'phone_number' => '0778-7367111',
            'fax' => '0778-7367112',
            'email' => 'pmp@branch.com',
            'status' => 1,
            'company_id' => 1,
        ]);

        DB::table('mst_branch')->insert([
            'code' => 'BR0002',
            'name' => 'Patria Maritime Industry',
            'address' => 'Banjarmasin',
            'city' => 'Banjarmasin',
            'phone_number' => '0226650340',
            'fax' => '0226650341',
            'email' => 'pami@branch.com',
            'status' => 1,
            'company_id' => 2,
        ]);
    }
}
