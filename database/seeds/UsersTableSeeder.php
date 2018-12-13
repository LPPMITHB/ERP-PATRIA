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
            'username' => 'mynameyoyoo',
            'name' => 'Yonathan Setiawan',
            'email' => 'admin@pmp.com',
            'role_id' => 1,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'regina23',
            'name' => 'Gabriella Regina',
            'email' => 'gabriellaregina@gmail.com',
            'role_id' => 1,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'ishak',
            'name' => 'Ishak Antony',
            'email' => 'asdf2796@gmail.com',
            'role_id' => 1,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'nathan',
            'name' => 'Nathanael Timotius',
            'email' => 'nathanaeltimotius@rocketmail.com',
            'role_id' => 1,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'richie',
            'name' => 'Richie Ivandi',
            'email' => 'richieivandik@rocketmail.com',
            'role_id' => 1,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'bene',
            'name' => 'Benedict Jeremiah',
            'email' => 'ben.jere0811@gmail.com',
            'role_id' => 1,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'aldy',
            'name' => 'Lievaldy Octa',
            'email' => 'aldy@gmail.com',
            'role_id' => 1,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'paipai',
            'name' => 'Christian Santosa',
            'email' => 'pai@gmail.com',
            'role_id' => 1,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'user',
            'name' => 'User Biasa',
            'email' => 'UB@rocketmail.com',
            'role_id' => 1,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'pmp',
            'name' => 'User PMP',
            'email' => 'pmp@pmp.com',
            'role_id' => 4,
            'branch_id' => 2,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'pami',
            'name' => 'User PAMI',
            'email' => 'pami@pami.com',
            'role_id' => 5,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
    }
}
