<?php

use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_vendor')->insert([
                    'code' => 'VR0001',
                    'name' => 'Korfmann',
                    'type' => 'Subcon',
                    'email' => 'akorfmannr@technorati.com',
                    'address' => '0148 Commercial Point',
                    'phone_number' => '1328561818',
                    'status' => 0,
                    'competence' => 'Welding',
                    'branch_id' => 1,
                    'user_id' =>5,                    
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0002',
                    'name' => 'Cobley',
                    'type' => 'Subcon',
                    'email' => 'acobleyu@symantec.com',
                    'address' => '205 Lunder Parkway',
                    'phone_number' => '5695925032',
                    'status' => 0,
                    'competence' => 'Welding',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0003',
                    'name' => 'Baggallay',
                    'type' => 'Subcon',
                    'email' => 'abaggallayn@t.co',
                    'address' => '36423 Crownhardt Junction',
                    'phone_number' => '1372435998',
                    'status' => 0,
                    'competence' => 'Welding',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0004',
                    'name' => 'Rigbye',
                    'type' => 'Subcon',
                    'email' => 'arigbyeo@newyorker.com',
                    'address' => '94 Nova Parkway',
                    'phone_number' => '9644267819',
                    'status' => 1,
                    'competence' => 'Welding',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0005',
                    'name' => 'Llewelly',
                    'type' => 'Subcon',
                    'email' => 'bllewelly2@vk.com',
                    'address' => '82 Graceland Drive',
                    'phone_number' => '9122529496',
                    'status' => 0,
                    'competence' => 'Welding',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0006',
                    'name' => 'Nickell',
                    'type' => 'Subcon',
                    'email' => 'bnickell1@squarespace.com',
                    'address' => '06 Chinook Junction',
                    'phone_number' => '4635784297',
                    'status' => 0,
                    'competence' => 'Welding',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0007',
                    'name' => 'Clement',
                    'type' => 'Subcon',
                    'email' => 'bclementc@trellian.com',
                    'address' => '0 Menomonie Trail',
                    'phone_number' => '6069972050',
                    'status' => 0,
                    'competence' => 'Welding',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);
        DB::table('mst_vendor')->insert([
                    'code' => 'VR0008',
                    'name' => 'Wafer',
                    'type' => 'Subcon',
                    'email' => 'cwaferf@hubpages.com',
                    'address' => '1 Forest Terrace',
                    'phone_number' => '5859364585',
                    'status' => 0,
                    'competence' => 'Welding',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0009',
                    'name' => 'O Cassidy',
                    'type' => 'Subcon',
                    'email' => 'cocassidyt@msu.edu',
                    'address' => '3 Service Circle',
                    'phone_number' => '5405085750',
                    'status' => 1,
                    'competence' => 'Welding',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0010',
                    'name' => 'Greswell',
                    'type' => 'Subcon',
                    'email' => 'dgreswell12@jiathis.com',
                    'address' => '23 Butterfield Terrace',
                    'phone_number' => '8014902121',
                    'status' => 1,
                    'competence' => 'Welding',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0011',
                    'name' => 'Brim',
                    'type' => 'Material',
                    'email' => 'gbrim6@nbcnews.com',
                    'address' => '122 Oak Valley Court',
                    'phone_number' => '1845604194',
                    'status' => 1,
                    'competence' => 'Cutting',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0012',
                    'name' => 'Storek',
                    'type' => 'Material',
                    'email' => 'hstorekl@ebay.com',
                    'address' => '717 Menomonie Junction',
                    'phone_number' => '9279579686',
                    'status' => 0,
                    'competence' => 'Cutting',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0013',
                    'name' => 'Dabell',
                    'type' => 'Material',
                    'email' => 'hdabell4@noaa.gov',
                    'address' => '4086 Westend Road',
                    'phone_number' => '1077539470',
                    'status' => 0,
                    'competence' => 'Cutting',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0014',
                    'name' => 'Pittet',
                    'type' => 'Material',
                    'email' => 'hpittet3@typepad.com',
                    'address' => '158 Drewry Court',
                    'phone_number' => '8907685676',
                    'status' => 0,
                    'competence' => 'Cutting',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0015',
                    'name' => 'Tolchar',
                    'type' => 'Material',
                    'email' => 'htolcharw@slashdot.org',
                    'address' => '7869 Roxbury Junction',
                    'phone_number' => '2366583430',
                    'status' => 1,
                    'competence' => 'Cutting',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0016',
                    'name' => 'Jandy',
                    'type' => 'Material',
                    'email' => 'jfry9@washington.edu',
                    'address' => '0149 Warbler Hill',
                    'phone_number' => '2453525392',
                    'status' => 0,
                    'competence' => 'Cutting',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0017',
                    'name' => 'Pumfrey',
                    'type' => 'Material',
                    'email' => 'kpumfreyj@prnewswire.com',
                    'address' => '3076 Summerview Plaza',
                    'phone_number' => '2461807852',
                    'status' => 1,
                    'competence' => 'Cutting',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0018',
                    'name' => 'Pates',
                    'type' => 'Material',
                    'email' => 'lpates0@ucla.edu',
                    'address' => '483 Meadow Ridge Road',
                    'phone_number' => '5104255709',
                    'status' => 1,
                    'competence' => 'Cutting',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0019',
                    'name' => 'Sandon',
                    'type' => 'Material',
                    'email' => 'lsandon5@imdb.com',
                    'address' => '27 Westerfield Court',
                    'phone_number' => '2614084969',
                    'status' => 0,
                    'competence' => 'Cutting',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0020',
                    'name' => 'Marnes',
                    'type' => 'Material',
                    'email' => 'lmarnesk@bloglines.com',
                    'address' => '4041 Meadow Vale Pass',
                    'phone_number' => '5322899006',
                    'status' => 0,
                    'competence' => 'Cutting',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0021',
                    'name' => 'Stanesby',
                    'type' => 'Resource',
                    'email' => 'lstanesby8@yale.edu',
                    'address' => '238 Bunting Crossing',
                    'phone_number' => '2749242340',
                    'status' => 1,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0022',
                    'name' => 'Laxston',
                    'type' => 'Resource',
                    'email' => 'llaxstong@usa.gov',
                    'address' => '448 Butternut Junction',
                    'phone_number' => '5302114662',
                    'status' => 1,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0023',
                    'name' => 'Lacroutz',
                    'type' => 'Resource',
                    'email' => 'llacroutzv@ezinearticles.com',
                    'address' => '81864 Mayfield Alley',
                    'phone_number' => '5816889446',
                    'status' => 1,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0024',
                    'name' => 'Coite',
                    'type' => 'Resource',
                    'email' => 'lcoiteh@gmpg.org',
                    'address' => '32333 Hermina Point',
                    'phone_number' => '7924393633',
                    'status' => 0,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0025',
                    'name' => 'Pacitti',
                    'type' => 'Resource',
                    'email' => 'mpacitti11@youtu.be',
                    'address' => '8792 Bunker Hill Hill',
                    'phone_number' => '9934000218',
                    'status' => 0,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0026',
                    'name' => 'Attyeo',
                    'type' => 'Resource',
                    'email' => 'mattyeoi@auda.org.au',
                    'address' => '55439 Cottonwood Junction',
                    'phone_number' => '3771454525',
                    'status' => 0,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0027',
                    'name' => 'MacDuff',
                    'type' => 'Resource',
                    'email' => 'mmacduffd@mapy.cz',
                    'address' => '00393 Upham Circle',
                    'phone_number' => '3376677689',
                    'status' => 1,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0028',
                    'name' => 'Doudny',
                    'type' => 'Resource',
                    'email' => 'ndoudnyz@homestead.com',
                    'address' => '13609 Prairie Rose Junction',
                    'phone_number' => '4409518680',
                    'status' => 1,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0029',
                    'name' => 'Vigus',
                    'type' => 'Resource',
                    'email' => 'pvigusq@meetup.com',
                    'address' => '9887 Granby Court',
                    'phone_number' => '6506628056',
                    'status' => 0,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0030',
                    'name' => 'Tolputt',
                    'type' => 'Resource',
                    'email' => 'ptolputtb@slideshare.net',
                    'address' => '61 Logan Trail',
                    'phone_number' => '7061981072',
                    'status' => 1,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);
                    
        DB::table('mst_vendor')->insert([
                    'code' => 'VR0031',
                    'name' => 'Paoloni',
                    'type' => 'Resource',
                    'email' => 'spaoloni10@wikia.com',
                    'address' => '91 Jana Point',
                    'phone_number' => '1783982085',
                    'status' => 0,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0032',
                    'name' => 'Andrysek',
                    'type' => 'Resource',
                    'email' => 'sandrysekx@amazon.co.uk',
                    'address' => '1280 Summer Ridge Center',
                    'phone_number' => '5929385857',
                    'status' => 0,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0033',
                    'name' => 'Kinsman',
                    'type' => 'Resource',
                    'email' => 'skinsman7@imgur.com',
                    'address' => '907 Erie Trail',
                    'phone_number' => '2083399543',
                    'status' => 1,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0034',
                    'name' => 'Neames',
                    'type' => 'Resource',
                    'email' => 'tneamesa@harvard.edu',
                    'address' => '2 Utah Road',
                    'phone_number' => '1966019529',
                    'status' => 1,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0035',
                    'name' => 'Nanson',
                    'type' => 'Resource',
                    'email' => 'tnansons@va.gov',
                    'address' => '48029 Schiller Way',
                    'phone_number' => '5755858235',
                    'status' => 1,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0036',
                    'name' => 'Fonzo',
                    'type' => 'Resource',
                    'email' => 'tfonzo13@cpanel.net',
                    'address' => '84 Moulton Lane',
                    'phone_number' => '2107643709',
                    'status' => 1,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0037',
                    'name' => 'Maruszewski',
                    'type' => 'Resource',
                    'email' => 'tmaruszewskie@washingtonpost.com',
                    'address' => '1 Merry Avenue',
                    'phone_number' => '3918020317',
                    'status' => 0,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0038',
                    'name' => 'Gostridge',
                    'type' => 'Resource',
                    'email' => 'vgostridgey@umich.edu',
                    'address' => '374 Nevada Street',
                    'phone_number' => '4631605200',
                    'status' => 1,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        DB::table('mst_vendor')->insert([
                    'code' => 'VR0039',
                    'name' => 'Broxap',
                    'type' => 'Resource',
                    'email' => 'vbroxapm@google.pl',
                    'address' => '2982 Huxley Hill',
                    'phone_number' => '5149875124',
                    'status' => 1,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);
                    
        DB::table('mst_vendor')->insert([
                    'code' => 'VR0040',
                    'name' => 'Blinman',
                    'type' => 'Resource',
                    'email' => 'yblinmanp@stanford.edu',
                    'address' => '777 Manitowish Avenue',
                    'phone_number' => '8441086097',
                    'status' => 1,
                    'competence' => 'Bending',
                    'branch_id' => 1,
                    'user_id' =>5,
                    ]);

        }
    }

