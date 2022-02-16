<?php

namespace Insyghts\Authentication\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permissions')->insert(array(
            array(
                'role_id' => 3,
                'permission_id' => 1,
            ),

            array(
                'role_id' => 2,
                'permission_id' => 1,
            ),
            array(
                'role_id' => 2,
                'permission_id' => 2,
            ),

            array(
                'role_id' => 1,
                'permission_id' => 1,
            ),
            array(
                'role_id' => 1,
                'permission_id' => 2,
            ),
            array(
                'role_id' => 1,
                'permission_id' => 3,
            ),
            array(
                'role_id' => 1,
                'permission_id' => 4,
            ),
        ));
    }
}
