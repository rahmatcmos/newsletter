<?php

use Illuminate\Database\Seeder;

class ExampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(NewsletterListTableSeeder::class);
        $this->call(SubscriberTableSeeder::class);
        $this->call(NewsletterReasonTableSeeder::class);
        $this->call(NewsletterTableSeeder::class);
        $this->call(SettingTableSeeder::class);
    }
}
