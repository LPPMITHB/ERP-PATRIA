<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'name' => 'Super Admin',
            'email' => 'admin@ithb.com',
            'role_id' => 1,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[1,2,3]',
        ]);

        DB::table('users')->insert([
            'username' => 'pmp',
            'name' => 'User PMP',
            'email' => 'pmp@pmp.com',
            'role_id' => 4,
            'branch_id' => 2,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[1]',
        ]);

        DB::table('users')->insert([
            'username' => 'pami',
            'name' => 'User PAMI',
            'email' => 'pami@pami.com',
            'role_id' => 5,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0001',
            'name' => 'DUMMY - PT. MEGA SURYA ERATAMA',
            'email' => 'mesakh.tama@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[1]',
        ]);
    
        DB::table('users')->insert([
            'username' => 'CUST0002',
            'name' => 'DUMMY - PT. PELAYARAN NASIONAL TANJUNG RIAU SERVIS',
            'email' => 'kparlindungan@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);
    }
}
