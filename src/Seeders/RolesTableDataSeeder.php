<?php

namespace Insyghts\Authentication\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */



    public function run()
    {
        DB::table('roles')->insert(array(
            array(
            'name' => "SUPPERADMIN",
            'slug' => 'supperadmin',

            ),
            array(
                'name' => "ADMIN",
                'slug' => 'admin',

                ),
            array(
            'name' => "MEMBER",
            'slug' => 'member',
            )
        ));
    }
}
