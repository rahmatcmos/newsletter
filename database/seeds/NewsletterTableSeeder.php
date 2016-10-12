<?php

use App\Newsletter;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NewsletterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newsletter = new Newsletter();
        $user = User::whereGroup('user')->first();

        DB::table($newsletter->getTable())->insert([
            'user_id'     => $user->id,
            'title'       => 'First Come!',
            'description' => 'Simple newsletter template for new comer.',
            'content'     => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'status'      => 'drafted',
            'sent_at'     => Carbon::now(),
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),
        ]);
    }
}
