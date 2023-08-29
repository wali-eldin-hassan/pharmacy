<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'superadmin', 'description' => 'A Superadmin User'],
            ['name' => 'admin', 'description' => 'A Admin User'],
        ]);
    }
}
