<?php

namespace Insyghts\Authentication\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUsersTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_users')->insert(array(
            array(
                'role_id' => 1,
                'user_id' => 1,
            ),

            array(
                'role_id' => 2,
                'user_id' => 2,
            )


        ));
    }
}
