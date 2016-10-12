<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new Setting();

        $defaults = [
            'app_name'     => 'Newsletter Manager',
            'app_email'    => ' mail@laravel.web.id',
            'app_timezone' => 'Asia/Jakarta',
            'date_format'  => 'd M Y H:i',
        ];

        foreach ($defaults as $key => $value) {
            $settings[] = [
                'key'        => $key,
                'value'      => $value,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ];
        }

        DB::statement('SET foreign_key_checks=0');
        DB::table($setting->getTable())->truncate();
        DB::statement('SET foreign_key_checks=1');

        DB::table($setting->getTable())->insert($settings);
    }
}
