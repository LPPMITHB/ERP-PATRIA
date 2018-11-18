<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mst_customer')->insert([
        'code' => 'CUST0001',
        'name' => 'PT. MEGA SURYA ERATAMA',
        'contact_person_name' => 'Mesakh Tama',
        'contact_person_email' => 'mesakh.tama@gmail.com',
        'address' => 'Dsn Jasem, Kelurahan Jasem Kecamatan Ngoro Kab. Mojokerto',
        'contact_person_phone' => '08125456372',
        'status' => 0,
        'branch_id' => 1,
        'user_id' =>5,
        ]);

        DB::table('mst_customer')->insert([
        'code' => 'CUST0002',
        'name' => 'PT. PELAYARAN NASIONAL TANJUNG RIAU SERVIS',
        'contact_person_name' => 'Kris Parlindungan',
        'contact_person_email' => 'kparlindungan@gmail.com',
        'address' => 'Wisma Pondok Indah 2 Lt. 2 Suite 201 Jl Sultan Iskandar Muda Kav V - TA, Pondok Indah',
        'contact_person_phone' => '085314265833',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);

        DB::table('mst_customer')->insert([
        'code' => 'CUST0003',
        'name' => 'PT. KWAN SAMUDERA MANDIRI',
        'contact_person_name' => 'Iwan Sarmadi',
        'contact_person_email' => 'iwansarm@yahoo.com',
        'address' => 'Jl. Bandengan Selatan No 43 Puri Delta Mas Blok C Kav No 10',
        'contact_person_phone' => '08875476124',
        'status' => 0,
        'branch_id' => 1,
        'user_id' =>5,
        ]);

        DB::table('mst_customer')->insert([
        'code' => 'CUST0004',
        'name' => 'PT. ANDALAN SAMUDRA',
        'contact_person_name' => 'Esra Lumika Andaman',
        'contact_person_email' => 'esra_lumika@gmail.com',
        'address' => 'Jl. Ramin I No. 25 RT 006 RW 008 Pemurus Dalam Banjarmasin Selatan',
        'contact_person_phone' => '081350441156',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);

        DB::table('mst_customer')->insert([
        'code' => 'CUST0005',
        'name' => 'PT. PANCA PRIMA PRAKARSA',
        'contact_person_name' => 'Barry Perkasa',
        'contact_person_email' => 'barry.perkasa@ymail.com',
        'address' => 'Jl. Pramuka Komplek Mitra Mas Blok C1 No 301',
        'contact_person_phone' => '089763521431',
        'status' => 0,
        'branch_id' => 1,
        'user_id' =>5,
        ]);

        DB::table('mst_customer')->insert([
        'code' => 'CUST0006',
        'name' => 'PT. ARUNG SAMUDERA SEJATI',
        'contact_person_name' => 'Nidya Arum',
        'contact_person_email' => 'nidyarum@gmail.com',
        'address' => 'Komp. Putra Jaya Bintan Blok N No 26',
        'contact_person_phone' => '08782341997',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);

        DB::table('mst_customer')->insert([
        'code' => 'CUST0007',
        'name' => 'PT. PELAYARAN BERKALA PRIMA',
        'contact_person_name' => 'Ronald Malta',
        'contact_person_email' => 'ronald_malt@gmail.com',
        'address' => 'Jl. Rijali No 63 Rijali, Sirimau',
        'contact_person_phone' => '085663118923',
        'status' => 0,
        'branch_id' => 1,
        'user_id' =>5,
        ]);

        DB::table('mst_customer')->insert([
        'code' => 'CUST0008',
        'name' => 'PT. TRIKARSA WIRA SAMUDERA',
        'contact_person_name' => 'Petrus Wandotela',
        'contact_person_email' => 'petruswandotela@gmail.com',
        'address' => 'Jl. Dahlia II No. 57 RT.34 Kel. Telawang Kec. Banjarmasin',
        'contact_person_phone' => '08111350022',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);

        DB::table('mst_customer')->insert([
        'code' => 'CUST0009',
        'name' => 'PT. PRIMA ENERGI MULTI TRADING',
        'contact_person_name' => 'Ivan Santosa',
        'contact_person_email' => 'santosa_ivan@gmail.com',
        'address' => 'Jl. Jend. A. Yani Km. 12,2 RT.02 Kel. Gambut Barat, Kec. Gambut, Kab. Banjar',
        'contact_person_phone' => '08154217788',
        'status' => 0,
        'branch_id' => 1,
        'user_id' =>5,
        ]);

        DB::table('mst_customer')->insert([
        'code' => 'CUST0010',
        'name' => 'PT. MITRA JAYA KALIMANTAN BERSINAR',
        'contact_person_name' => 'Loekman Marti',
        'contact_person_email' => 'loekman_marti@gmail.com',
        'address' => 'Jl. Nelayan RT.01 No. 5 Desa Hilir Muara, Kec. Pulau Laut Utara, Kotabaru',
        'contact_person_phone' => '08931253467',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);
        DB::table('mst_customer')->insert([
        'code' => 'CUST0011',
        'name' => 'PT. BINTANG CAKRA BINASAMUDRA',
        'contact_person_name' => 'Wisnu Kusuma',
        'contact_person_email' => 'winsu.kusuma@yahoo.com',
        'address' => 'Jl. Kartika Alam III / 16, RT. 08 / 016 Pondok Pinang',
        'contact_person_phone' => '08881235644',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);
        DB::table('mst_customer')->insert([
        'code' => 'CUST0012',
        'name' => 'PT. TRANS ENERGY INDONESIA',
        'contact_person_name' => 'Tj Akbar Rama',
        'contact_person_email' => 'tj_akbarama@gmail.com',
        'address' => 'Jl. Jend. Sudirman Kav. 3-4 PRINCE CENTRE BUILDING Lt. 15 Unit 1505, Karet Tengsin - Tanah Abang',
        'contact_person_phone' => '08997536421',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);
        DB::table('mst_customer')->insert([
        'code' => 'CUST0013',
        'name' => 'PT. BORNEO SAMUDRA PERKASA',
        'contact_person_name' => 'Ali Pirata',
        'contact_person_email' => 'pirata_ali@yahoo.com',
        'address' => 'Pantai Mentari Blok B - 3 Kenjeran - Bulak',
        'contact_person_phone' => '08125354040',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);
        DB::table('mst_customer')->insert([
        'code' => 'CUST0014',
        'name' => 'PT. PELAYARAN GLORA PERSADA MANDIRI',
        'contact_person_name' => 'Michael Wijaya',
        'contact_person_email' => 'michael.wijaya23@gmail.com',
        'address' => 'Ruko Palais De Paris Blok I No. 21 Kota Deltamas, Sukamahi - Cikarang Pusat',
        'contact_person_phone' => '08164788228',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);
        DB::table('mst_customer')->insert([
        'code' => 'CUST0015',
        'name' => 'PT. HASNUR INTERNASIONAL SHIPPING',
        'contact_person_name' => 'Ari Munthe',
        'contact_person_email' => 'arimunthe@gmail.com',
        'address' => 'Wisma 77 Lt. 7. Jl. Letjen S. Parman Kav. 77 Slipi - Palmerah',
        'contact_person_phone' => '08563476229',
        'status' => 0,
        'branch_id' => 1,
        'user_id' =>5,
        ]);
        DB::table('mst_customer')->insert([
        'code' => 'CUST0016',
        'name' => 'PT. SIGUR ROS INDONESIA',
        'contact_person_name' => 'Rudi Zikarta',
        'contact_person_email' => 'rudi_zik@ymail.com',
        'address' => 'Menara Bidakara II Lt. 16 Unit 5 & 6 Jl. Jend. Gatot Subroto Kav. 71 - 73',
        'contact_person_phone' => '08357676231',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);
        DB::table('mst_customer')->insert([
        'code' => 'CUST0017',
        'name' => 'PT. WAY PIDADA JAYA',
        'contact_person_name' => 'Wahyu Prasita',
        'contact_person_email' => 'wahyu.pras@gmail.com',
        'address' => 'LINTAS RAWA JITU NO. RT. 003 RW.004',
        'contact_person_phone' => '08129798001',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);
        DB::table('mst_customer')->insert([
        'code' => 'CUST0018',
        'name' => 'PT. MAJU MUNDUR ASIK ASIK',
        'contact_person_name' => 'Tanto Tomo',
        'contact_person_email' => 'tanto_tomo@gmail.com',
        'address' => 'KEL. BATU AMP.',
        'contact_person_phone' => '0',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);
        DB::table('mst_customer')->insert([
        'code' => 'CUST0019',
        'name' => 'PT. PERKASA ARUNG SAMUDRA',
        'contact_person_name' => 'Firman Bastian',
        'contact_person_email' => 'firman.bastian@hotmail.com',
        'address' => 'GRAHA ARTERI MAS KAV.49, NO.68 JL. RAYA PANJANG,KEDOYA SELATAN',
        'contact_person_phone' => '081353010222',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);
        DB::table('mst_customer')->insert([
        'code' => 'CUST0020',
        'name' => 'GLENCORE INTERNATIONAL, AG',
        'contact_person_name' => 'Amal Askara',
        'contact_person_email' => 'amalaskara@yahoo.com',
        'address' => 'BAAREEMATTSTRASSE 3, CH-6341 BAAR, SWITZERLAND',
        'contact_person_phone' => '0817788901',
        'status' => 0,
        'branch_id' => 1,
        'user_id' =>5,
        ]);
        DB::table('mst_customer')->insert([
        'code' => 'CUST0021',
        'name' => 'PT. ASMIN KOALINDO TUHUP',
        'contact_person_name' => 'Daniel Riyadi',
        'contact_person_email' => 'dnilriyadi@gmail.com',
        'address' => 'Gedung Menara Danamon Lt.5 Jl. Prof. DR. Satrio Kav. EIV/16, Kuningan Timur',
        'contact_person_phone' => '081100090807',
        'status' => 1,
        'branch_id' => 1,
        'user_id' =>5,
        ]);
        }
    }