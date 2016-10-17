<?php

use App\NewsletterList;
use App\NewsletterSubscriber;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubscriberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // find default list
        $list = NewsletterList::whereIsDefault(true)->first();

        $subscriber = new NewsletterSubscriber();
        $faker = Faker\Factory::create('id_ID');
        foreach (range(1, 100) as $index) {
            DB::table($subscriber->getTable())->insert([
                'newsletter_list_id' => $list->id,
                'name'               => $faker->name,
                'email'              => $faker->email,
                'status'             => 'subscribed',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ]);
        }
    }
}
