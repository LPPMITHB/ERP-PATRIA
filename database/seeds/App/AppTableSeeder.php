 <?php

    use Illuminate\Database\Seeder;
    use Database\Data\MenuDataSeeder;
    use Database\Data\SidenavDataSeeder;
    use Database\Data\PermissionsDataSeeder;
    use App\Models\Permission;

    class AppTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $dataMenu = MenuDataSeeder::getData();
            $dataSidenav =  SidenavDataSeeder::getData();
            $dataPermissions = PermissionsDataSeeder::getData();

            usort($dataMenu, function ($a, $b) {
                return $a['level'] <=> $b['level'];
            });
            $this->command->getOutput()->progressStart(count($dataMenu) + count($dataSidenav) + count($dataPermissions) + 1);
            for ($i = 0; $i < count($dataMenu); $i++) {
                // DB::table('mst_material')->insert([]);
                if (intval($dataMenu[$i]['menu_id']) == 0) {
                    $dataMenu_menu_id = null;
                } else {
                    $dataMenu_menu_id = intval($dataMenu[$i]['menu_id']);
                }
                DB::table('menus')->insert([
                    'id' => intval($dataMenu[$i]['id']),
                    'level' => intval($dataMenu[$i]['level']),
                    'name' => $dataMenu[$i]['name'],
                    'icon' => $dataMenu[$i]['icon'],
                    'route_name' => $dataMenu[$i]['route_name'],
                    'is_active' => intval($dataMenu[$i]['is_active']),
                    'menu_id' => $dataMenu_menu_id,
                    'roles' => $dataMenu[$i]['roles'],
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ]);
                $this->command->getOutput()->progressAdvance();
            }



            for ($i = 0; $i < count($dataSidenav); $i++) {
                DB::table('sidenav')->insert([
                    'id' => $dataSidenav[$i]['id'],
                    'menu_id' => $dataSidenav[$i]['menu_id'],
                    'route_name' => $dataSidenav[$i]['route_name'],
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ]);
                $this->command->getOutput()->progressAdvance();
            }



            for ($i = 0; $i < count($dataPermissions); $i++) {
                DB::table('permissions')->insert([
                    'id' => $dataPermissions[$i]['id'],
                    'name' => $dataPermissions[$i]['name'],
                    'menu_id' => $dataPermissions[$i]['menu_id'],
                    'middleware' => $dataPermissions[$i]['middleware'],
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ]);
                $this->command->getOutput()->progressAdvance();
            }



            $getDbPermissions = Permission::all();
            $arrPermissions = [];
            foreach ($getDbPermissions as $dbPermissions) {
                $arrPermissions = $arrPermissions + [$dbPermissions->middleware => true];
            }
            DB::table('roles')->insert([
                'name' => 'ADMIN',
                'description' => 'All Access',
                'permissions' => json_encode($arrPermissions)
            ]);

            $this->command->getOutput()->progressFinish();
            echo " \n \n ";
        }
    }
