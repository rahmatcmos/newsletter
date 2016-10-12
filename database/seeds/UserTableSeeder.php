<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();

        // default user for admin
        DB::table($user->getTable())->insert([
            'name'       => 'Administrator',
            'email'      => 'admin@email.com',
            'group'      => 'admin',
            'password'   => bcrypt('admin'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        // default user for user
        DB::table($user->getTable())->insert([
            'name'       => 'User',
            'email'      => 'user@email.com',
            'group'      => 'user',
            'password'   => bcrypt('user'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
