<?php

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;

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
            'type' => 1,
            'role_id' => 1,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[1,2,3]',
        ]);

        DB::table('users')->insert([
            'username' => 'pmp',
            'name' => 'User PMP',
            'email' => 'pmp@pmp.com',
            'type' => 1,
            'role_id' => 4,
            'branch_id' => 1,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[1]',
        ]);

        DB::table('users')->insert([
            'username' => 'pami',
            'name' => 'User PAMI',
            'email' => 'pami@pami.com',
            'type' => 1,
            'role_id' => 5,
            'branch_id' => 2,
            'password' => bcrypt('patria'),
            'business_unit_id' => '[2]',
        ]);

        DB::table('users')->insert([
            'username' => 'johndoe',
            'name' => 'John Doe',
            'email' => 'johndoe@mail.com',
            'type' => 2,
            'role_id' => 2,
            'branch_id' => 2,
            'password' => bcrypt('johndoe'),
            'business_unit_id' => '[1,2,3]',
        ]);

        $modelCustomer = Customer::all();
        foreach($modelCustomer as $customer){
            DB::table('users')->insert([
                'username' => $customer->code,
                'name' => $customer->name,
                'email' => $customer->email,
                'type' => 3,
                'role_id' => 3,
                'branch_id' => $customer->branch_id,
                'password' => bcrypt('patria'),
                'business_unit_id' => '[2]',
            ]);
            $user = User::where('username',$customer->code)->first();
            $customer->user_id = $user->id;
            $customer->update();
        }
    }
}
