<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class SubscriberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('id_ID');
        foreach (range(1, 100) as $index) {
        	DB::table('subscribers')->insert([
        		'name' => $faker->name,
        		'email' => $faker->email,
        		'status' => 'subscribed',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	]);
        }
    }
}
