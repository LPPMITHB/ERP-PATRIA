<?php

use Illuminate\Database\Seeder;

class PamiTugboatWbsStandardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $level_1 = array(
            'Steelwork' => array('bottom', 'hull', 'Longitudinal Bulkhead', 'Transfersal Bulkhead', 'Main Deck', 'bullwark', 'Whinch House', 'Side Board', 'Rampdoor'),
            'blasting and coating' => array('Under Water', 'Top Side', 'Main Deck External', 'Main Deck Cargo Space', 'Side Board External', 'Side Board Cargo Space', 'Bullwark External', 'Bullwark Internal', 'Winch House External', 'Winch House Internal', 'Push Pad External', 'Push Pad Internal', 'Internal Tank', 'Chain Locker', 'Gate Door', 'Single Bollard', 'Double Bollard', 'Man Hole', 'Vertical Ladder', 'Skeg', 'Bracket Smith', 'Draught & Plimsol Mark', 'Barge Name & Port Register', 'Tonnage Measurment Number', 'Extreme Draught', 'New Material', 'Anchor', 'Anchor Chain', 'Chain Bridle'),
            'Anchor Equipment' => array('Hawse Pipe', 'Dudukan Windlass', 'Engine Windlass', 'Windlass', 'Gearbox', 'Anchor Set', 'Anchor Sliding'),
        );
        $level_2 = "";
        $level_3 = "";
    }
}
