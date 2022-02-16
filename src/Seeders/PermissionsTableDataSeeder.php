<?php

namespace Insyghts\Authentication\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert(array(
            array(
            'name' => "read_contact",
            'slug' => 'read-contact',

            ),
            array(
                'name' => "create_contact",
                'slug' => 'create-contact',

                ),
            array(
            'name' => "update_contact",
            'slug' => 'update-contact',
            ),
            array(
                'name' => "delete_contact",
                'slug' => 'delete-contact',
            ),
        ));
    }
}
