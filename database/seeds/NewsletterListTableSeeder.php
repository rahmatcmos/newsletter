<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\NewsletterList;
use App\User;

class NewsletterListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$list = new NewsletterList;
        $user = User::whereGroup('user')->first();

        DB::table($list->getTable())->insert([
            'user_id' => $user->id,
        	'slug' => 'default',
        	'name' => 'Default',
        	'description' => 'Default list for all subscribers.',
        	'is_default' => true,
        	'created_at' => Carbon::now(),
        	'updated_at' => Carbon::now()
        ]);
    }
}
