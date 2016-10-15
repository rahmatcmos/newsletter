<?php

namespace App\Http\Controllers\Auth\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SaveRequest;
use App\Setting;
use Auth;
use Carbon\Carbon;
use DB;

/**
 * @author Yugo <dedy.yugo.purwanto@gmail.com>
 *
 * @link https://github.com/arvernester/newsletter
 */
class GlobalController extends Controller
{
    /**
     * Get all config and show it into forms.
     *
     * @return void
     */
    public function getIndex()
    {
        $this->authorize('view', Setting::class);

        // list of supported drivers
        $drivers = Setting::getDrivers();

        return view('auth.setting.global.index', compact('drivers'))
            ->withTitle('Setting');
    }

    /**
     * Save all settings.
     *
     * @return void
     */
    public function postCreate(SaveRequest $request)
    {
        $this->authorize('create', Setting::class);

        $setting = new Setting();

        // clear all data
        DB::statement('SET foreign_key_checks=0');
        DB::table($setting->getTable())->truncate();
        DB::statement('SET foreign_key_checks=1');

        foreach ($request->except('_token', '_method') as $property => $value) {
            // prepare for database
            $settings[] = [
                'key' => $property,
                'value' => $value,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table($setting->getTable())->insert($settings);

        $message = 'All settings has been saved.';
        if (request()->ajax()) {
            return [
                'status' => true,
                'message' => $message,
            ];
        }

        return redirect()
            ->back()
            ->with('success', $message);
    }
}
