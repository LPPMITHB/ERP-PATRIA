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

        DB::table('users')->insert([
            'username' => 'CUST0003',
            'name' => 'DUMMY - PT. KWAN SAMUDERA MANDIRI',
            'email' => 'iwansarm@yahoo.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0004',
            'name' => 'DUMMY - PT. ANDALAN SAMUDRA',
            'email' => 'esra_lumika@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0005',
            'name' => 'DUMMY - PT. PANCA PRIMA PRAKARSA',
            'email' => 'barry.perkasa@ymail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0006',
            'name' => 'DUMMY - PT. ARUNG SAMUDERA SEJATI',
            'email' => 'nidyarum@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0007',
            'name' => 'DUMMY - PT. PELAYARAN BERKALA PRIMA',
            'email' => 'ronald_malt@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0008',
            'name' => 'PT. TRIKARSA WIRA SAMUDERA',
            'email' => 'petruswandotela@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0009',
            'name' => 'DUMMY - PT. PRIMA ENERGI MULTI TRADING',
            'email' => 'santosa_ivan@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0010',
            'name' => 'DUMMY - PT. MITRA JAYA KALIMANTAN BERSINAR',
            'email' => 'loekman_marti@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0011',
            'name' => 'DUMMY - PT. BINTANG CAKRA BINASAMUDRA',
            'email' => 'wisnu.kusuma@yahoo.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0012',
            'name' => 'DUMMY - PT. TRANS ENERGY INDONESIA',
            'email' => 'tj_akbarama@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0013',
            'name' => 'DUMMY - PT. BORNEO SAMUDRA PERKASA',
            'email' => 'pirata_ali@yahoo.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0014',
            'name' => 'DUMMY - PT. HASNUR INTERNASIONAL SHIPPING',
            'email' => 'arimunthe@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0015',
            'name' => 'DUMMY - PT. PELAYARAN GLORA PERSADA MANDIRI',
            'email' => 'michael.wijaya23@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0016',
            'name' => 'DUMMY - PT. SIGUR ROS INDONESIA',
            'email' => 'rudi_zik@ymail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0017',
            'name' => 'DUMMY - PT. WAY PIDADA JAYA',
            'email' => 'wahyu.pras@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0018',
            'name' => 'DUMMY - PT. MAJU MUNDUR ASIK ASIK',
            'email' => 'tanto_tomo@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0019',
            'name' => 'DUMMY - PT. PERKASA ARUNG SAMUDRA',
            'email' => 'firman.bastian@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0020',
            'name' => 'DUMMY - GLENCORE INTERNATIONAL, AG',
            'email' => 'amalaskara@yahoo.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0021',
            'name' => 'DUMMY - PT. ASMIN KOALINDO TUHUP',
            'email' => 'dnilriyadi@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

    }
}
