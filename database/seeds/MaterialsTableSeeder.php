<?php

use Illuminate\Database\Seeder;

class MaterialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        DB::table('mst_material')->insert([
            'code' => 'MT0001',
            'name' => 'ROUND BAR',
            'cost_standard_price' => 140000,
            'description' => 'material ke-1',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 1,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0002',
            'name' => 'STEEL PLATE',
            'cost_standard_price' => 2500000,
            'description' => 'material ke-2',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0003',
            'name' => 'GRAB RAIL',
            'cost_standard_price' => 300000,
            'description' => 'material ke-3',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0004',
            'name' => 'STEEL PLATE GRADE A',
            'cost_standard_price' => 64000000,  
            'description' => 'material ke-4',          
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0005',
            'name' => 'L 150x90x9',
            'cost_standard_price' => 750000,
            'description' => 'material ke-5',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0006',
            'name' => 'JOTUN ANTI FOULING',
            'cost_standard_price' => 220000,
            'description' => 'material ke-6',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0007',
            'name' => 'JOTUN TOPCOAT',
            'cost_standard_price' => 50000,
            'description' => 'material ke-7',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0008',
            'name' => 'TAPE, ANTI CORROSION',
            'cost_standard_price' => 100000,
            'description' => 'material ke-8',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0009',
            'name' => 'DEVCON COLD GALVANIZIN',
            'cost_standard_price' => 90000,
            'description' => 'material ke-9',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0010',
            'name' => 'ELBOW 1 1/4 in CARBON ST',
            'cost_standard_price' => 5500,
            'description' => 'material ke-10',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0011',
            'name' => 'RAILING 1" STAINLESS STEEL',
            'cost_standard_price' => 4000000,
            'description' => 'material ke-11',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0012',
            'name' => 'RUBBER SPONGE 25',
            'cost_standard_price' => 50000,
            'description' => 'material ke-12',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0013',
            'name' => 'PCSHIGH DENSITY DAMMING',
            'cost_standard_price' => 1000000,
            'description' => 'material ke-13',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0014',
            'name' => 'SILENCER MAIN ENGINE 100',
            'cost_standard_price' => 3500000,
            'description' => 'material ke-14',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0015',
            'name' => 'ELECTRO HYDRAULIC STEEL',
            'cost_standard_price' => 176000000,
            'description' => 'material ke-15',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0016',
            'name' => 'MITSUBISHI MARINE DIESEL',
            'cost_standard_price' => 1300000000,
            'description' => 'material ke-16',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0017',
            'name' => 'MANGANA RETAINING COMP',
            'cost_standard_price' => 200000,
            'description' => 'material ke-17',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0018',
            'name' => 'AIR COMPRESSOR 1 STAGE',
            'cost_standard_price' => 8500000,
            'description' => 'material ke-18',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 1,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0019',
            'name' => 'GENSET PORTABLE 7,2 KVA',
            'cost_standard_price' => 60000000,
            'description' => 'material ke-19',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 1,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0020',
            'name' => 'OILY WATER SEPARATOR CA',
            'cost_standard_price' => 20000000,
            'description' => 'material ke-20',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0021',
            'name' => 'MARINE GENERATOR SET 63',
            'cost_standard_price' => 350000000,
            'description' => 'material ke-21',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0022',
            'name' => 'BUTTERFLY VALVE WAFER',
            'cost_standard_price' => 200000,
            'description' => 'material ke-22',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0023',
            'name' => 'CABLE TIE 200MM X 4.6MM',
            'cost_standard_price' => 10000,
            'description' => 'material ke-23',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0024',
            'name' => 'CAMLOCK (TYPE A) C/W END',
            'cost_standard_price' => 500000,
            'description' => 'material ke-24',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0025',
            'name' => 'GASKET STEAM/ HIGH TEMP',
            'cost_standard_price' => 800000,
            'description' => 'material ke-25',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0026',
            'name' => 'FIRE BLANKET NON ASBEST',
            'cost_standard_price' => 750000,
            'description' => 'material ke-26',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0027',
            'name' => 'BOLT M10 X 35MM HT8.8',
            'cost_standard_price' => 500,
            'description' => 'material ke-27',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0028',
            'name' => 'BOLT M10 X 35MM HT8.8',
            'cost_standard_price' => 34000,
            'description' => 'material ke-28',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0029',
            'name' => 'U-BOLT C/W NUTS 5/8 in X 6 in',
            'cost_standard_price' => 19000,
            'description' => 'material ke-29',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0030',
            'name' => 'BOLT M24 X 100MM H.T',
            'cost_standard_price' => 220000,
            'description' => 'material ke-30',
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0031',
            'name' => 'SPRING WASHER M12 M/S',
            'cost_standard_price' => 520,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0032',
            'name' => 'DIRTY OIL PUMP, HORIZONT',
            'cost_standard_price' => 16000000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0033',
            'name' => 'SEA WATER PUMP PRESSURE',
            'cost_standard_price' => 38000000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0034',
            'name' => 'HAND PUMP SEMI ROTARY',
            'cost_standard_price' => 3100000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0035',
            'name' => 'BILGE/BALLAST PUMP, HORIZ',
            'cost_standard_price' => 33000000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0036',
            'name' => 'GS/FIRE PUMP, HORIZONTAL',
            'cost_standard_price' => 46000000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0037',
            'name' => 'ANCHOR CHAIN DIA. 16MM U2',
            'cost_standard_price' => 3049000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0038',
            'name' => 'FLUSH WALL WINDOW',
            'cost_standard_price' => 2500000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0039',
            'name' => 'ANCHOR WINDLASS, ELECTR',
            'cost_standard_price' => 180000000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0040',
            'name' => 'MANHOLE COVER COMMON T',
            'cost_standard_price' => 1500000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0041',
            'name' => 'CHAIN STOPPER CHAIN DIA.1',
            'cost_standard_price' => 2200000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0042',
            'name' => 'WINDOWS FIXED TYPE, CLEAR',
            'cost_standard_price' => 2700000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0043',
            'name' => 'WHARF LADDER',
            'cost_standard_price' => 28500000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0044',
            'name' => 'TURN KEY HVAC  PROJECT S',
            'cost_standard_price' => 500000000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0045',
            'name' => 'INVENTARIS AKOMODASI',
            'cost_standard_price' => 50000000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 0,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0046',
            'name' => 'SUPPLY MATERIAL CARPENT',
            'cost_standard_price' => 1100000000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 1,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0047',
            'name' => 'CABLE TIE NYLON BLACK 300',
            'cost_standard_price' => 43200,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 1,
            'status' => 0,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0048',
            'name' => 'TTYCY 10 PAIR X 0.75MM2',
            'cost_standard_price' => 125000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 1,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0049',
            'name' => 'MARINE CEILING LIGHT FITTING',
            'cost_standard_price' => 1320000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 1,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            
            DB::table('mst_material')->insert([
            'code' => 'MT0050',
            'name' => 'ENGINE ORDER TELEGRAPH',
            'cost_standard_price' => 40000000,
            'weight' => 0,
            'height' => 0,
            'length' => 0,
            'width' => 0,
            'type' => 1,
            'status' => 1,
            'branch_id' => 1,
            'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0051',
                'name' => 'MAIN SWITCH BOARD 2 X 63',
                'cost_standard_price' => 245000000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0052',
                'name' => 'MMSART (SEARCH & RESCUE',
                'cost_standard_price' => 10000000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0053',
                'name' => 'DIGITAL WIND ANEMOMETER',
                'cost_standard_price' => 25000000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0054',
                'name' => 'VHF RADIO TRANSCEIVER, F',
                'cost_standard_price' => 30000000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0055',
                'name' => 'MARINE RADAR MODEL 1835',
                'cost_standard_price' => 45000000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);    
            DB::table('mst_material')->insert([
                'code' => 'MT0056',
                'name' => 'CCTV SYSTEM 7 POINT FOR B',
                'cost_standard_price' => 50000000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0057',
                'name' => 'EMERGENCY FIRE PUMP',
                'cost_standard_price' => 12000000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0058',
                'name' => 'FIRE ALARM COMPLETE SET',
                'cost_standard_price' => 50000000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0059',
                'name' => 'RIGID INFLATABLE BOAT ZPR',
                'cost_standard_price' => 144000000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0060',
                'name' => 'LIFEJACKET FOR ADULT C/W',
                'cost_standard_price' => 175000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0061',
                'name' => 'CAPACITY 1 TON AT 5M CRAN',
                'cost_standard_price' => 190000000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0062',
                'name' => 'TV 32"',
                'cost_standard_price' => 1750000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0063',
                'name' => 'GANCO 3M STAINLESS STEEL',
                'cost_standard_price' => 550000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0064',
                'name' => 'RAGUM 8"',
                'cost_standard_price' => 1500000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0065',
                'name' => 'INVENTARIS SPAREPART',
                'cost_standard_price' => 42000000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0066',
                'name' => 'V.LPG Pertamina 50kg/Cly',
                'cost_standard_price' => 780000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0067',
                'name' => 'GAS OXYGEN 16 CLY/PALLET',
                'cost_standard_price' => 1000000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0068',
                'name' => 'HAND GLOVE WORKING FIT',
                'cost_standard_price' => 4300,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 0,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0069',
                'name' => 'MARKING CHALK WHITE',
                'cost_standard_price' => 65000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 0,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0070',
                'name' => 'GOUGING ROD 6.5MM X 305',
                'cost_standard_price' => 125000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 0,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0071',
                'name' => 'WELDING ELECTRODE E601',
                'cost_standard_price' => 11000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0072',
                'name' => 'OIL ENGINE PERTAMINA ME',
                'cost_standard_price' => 120500,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0073',
                'name' => 'OIL HYDRAULIC PERTAMINA',
                'cost_standard_price' => 89000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0074',
                'name' => 'OIL ENGINE PERTAMINA ME',
                'cost_standard_price' => 106800,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0075',
                'name' => 'SOLAR',
                'cost_standard_price' => 10800,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0076',
                'name' => 'KANGORO, THINNER CL',
                'cost_standard_price' => 400000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);
            DB::table('mst_material')->insert([
                'code' => 'MT0077',
                'name' => 'SEAMLESS PIPE, MS, SCH 40',
                'cost_standard_price' => 200000,
                'weight' => 0,
                'height' => 0,
                'length' => 0,
                'width' => 0,
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' =>5,
            ]);

    }
}
