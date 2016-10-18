<?php

use App\NewsletterList;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NewsletterListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = new NewsletterList();
        $user = User::whereGroup('user')->first();

        DB::table($list->getTable())->insert([
            'user_id' => $user->id,
            'slug' => 'default',
            'name' => 'Default',
            'description' => 'Default list for all subscribers.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
