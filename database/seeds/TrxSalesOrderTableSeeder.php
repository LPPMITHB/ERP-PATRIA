<?php

use Illuminate\Database\Seeder;

class TrxSalesOrderTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_sales_order')->delete();
        
        \DB::table('trx_sales_order')->insert(array (
            0 => 
            array (
                'id' => 1,
                'number' => 'SO-1900001',
                'quotation_id' => 1,
                'customer_id' => 1,
                'description' => '',
                'price' => 45000000,
                'margin' => 20.0,
                'total_price' => 54000000,
                'status' => '0',
                'terms_of_payment' => '[{"project_progress":"20","payment_percentage":"20"},{"project_progress":"50","payment_percentage":"40"},{"project_progress":"60","payment_percentage":"20"},{"project_progress":"70","payment_percentage":"10"},{"project_progress":"100","payment_percentage":"10"}]',
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => '2019-08-26 07:51:12',
                'updated_at' => '2019-08-26 07:51:43',
            ),
        ));
        
        
    }
}