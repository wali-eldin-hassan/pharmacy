<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'name' => 'Demo Admin',
            'email' => 'admin@demo.com',
            'password' => bcrypt('123123'),
        ]);
        DB::table('roles_user')->insert([
            'roles_id' => '1',
            'user_id' => User::get()->last()->id,
        ]);
    }
}
