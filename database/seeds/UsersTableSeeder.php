<?php

use Illuminate\Database\Seeder;
use App\User;

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
            'name' => 'laurus',
            'email' => 'laurus@ph.net',
            'password' => bcrypt('laurus'),
        ]);
        DB::table('roles_user')->insert([
            'roles_id' => '1',
            'user_id' => User::get()->last()->id,
        ]);
    }
}
