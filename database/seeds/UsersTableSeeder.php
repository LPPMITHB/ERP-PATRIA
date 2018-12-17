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

        DB::table('users')->insert([
            'username' => 'CUST0001',
            'name' => 'PT. MEGA SURYA ERATAMA',
            'email' => 'mesakh.tama@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
    
        DB::table('users')->insert([
            'username' => 'CUST0002',
            'name' => 'PT. PELAYARAN NASIONAL TANJUNG RIAU SERVIS',
            'email' => 'kparlindungan@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
    
        DB::table('users')->insert([
            'username' => 'CUST0003',
            'name' => 'PT. KWAN SAMUDERA MANDIRI',
            'email' => 'iwansarm@yahoo.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
    
        DB::table('users')->insert([
            'username' => 'CUST0004',
            'name' => 'PT. ANDALAN SAMUDRA',
            'email' => 'esra_lumika@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
    
        DB::table('users')->insert([
            'username' => 'CUST0005',
            'name' => 'PT. PANCA PRIMA PRAKARSA',
            'email' => 'barry.perkasa@ymail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
    
        DB::table('users')->insert([
            'username' => 'CUST0006',
            'name' => 'PT. ARUNG SAMUDERA SEJATI',
            'email' => 'nidyarum@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
    
        DB::table('users')->insert([
            'username' => 'CUST0007',
            'name' => 'PT. PELAYARAN BERKALA PRIMA',
            'email' => 'ronald_malt@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
    
        DB::table('users')->insert([
            'username' => 'CUST0008',
            'name' => 'PT. TRIKARSA WIRA SAMUDERA',
            'email' => 'petruswandotela@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
    
        DB::table('users')->insert([
            'username' => 'CUST0009',
            'name' => 'PT. PRIMA ENERGI MULTI TRADING',
            'email' => 'santosa_ivan@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
    
        DB::table('users')->insert([
            'username' => 'CUST0010',
            'name' => 'PT. MITRA JAYA KALIMANTAN BERSINAR',
            'email' => 'loekman_marti@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0011',
            'name' => 'PT. BINTANG CAKRA BINASAMUDRA',
            'email' => 'winsu.kusuma@yahoo.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
        
        DB::table('users')->insert([
            'username' => 'CUST0012',
            'name' => 'PT. TRANS ENERGY INDONESIA',
            'email' => 'tj_akbarama@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
        
        DB::table('users')->insert([
            'username' => 'CUST0013',
            'name' => 'PT. BORNEO SAMUDRA PERKASA',
            'email' => 'pirata_ali@yahoo.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0014',
            'name' => 'PT. PELAYARAN GLORA PERSADA MANDIRI',
            'email' => 'michael.wijaya23@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0015',
            'name' => 'PT. HASNUR INTERNASIONAL SHIPPING',
            'email' => 'arimunthe@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0016',
            'name' => 'PT. SIGUR ROS INDONESIA',
            'email' => 'rudi_zik@ymail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
        
        DB::table('users')->insert([
            'username' => 'CUST0017',
            'name' => 'PT. WAY PIDADA JAYA',
            'email' => 'wahyu.pras@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0018',
            'name' => 'PT. MAJU MUNDUR ASIK ASIK',
            'email' => 'tanto_tomo@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0019',
            'name' => 'PT. PERKASA ARUNG SAMUDRA',
            'email' => 'firman.bastian@hotmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0020',
            'name' => 'GLENCORE INTERNATIONAL, AG',
            'email' => 'amalaskara@yahoo.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);

        DB::table('users')->insert([
            'username' => 'CUST0021',
            'name' => 'PT. ASMIN KOALINDO TUHUP',
            'email' => 'dnilriyadi@gmail.com',
            'role_id' => 3,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
        ]);
    }
}
