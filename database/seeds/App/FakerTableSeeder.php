 <?php

    use Illuminate\Database\Seeder;
    use Database\Data\MenuDataSeeder;
    use Database\Data\SidenavDataSeeder;
    use Database\Data\PermissionsDataSeeder;
    use App\Models\Permission;
    use Database\Data\Faker\RolesDataSeederFaker;

    class FakerTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {

            $this->command->getOutput()->progressStart(1000);

            DB::table('roles')->insert([
                'name' => 'USER',
                'description' => 'No Access',
                'permissions' =>  RolesDataSeederFaker::getRoleUser(),
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')
            ]);
            $this->command->getOutput()->progressAdvance();

            DB::table('roles')->insert([
                'name' => 'CUSTOMER',
                'description' => 'Customer Access',
                'permissions' =>  RolesDataSeederFaker::getRoleCustomer(),
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')
            ]);
            $this->command->getOutput()->progressAdvance();


            $this->command->getOutput()->progressFinish();
            echo " \n \n ";
        }
    }
