<?php

namespace App\Http\Controllers\Auth\Setting;
use App\Http\Controllers\Controller;

use DB;
use Carbon\Carbon;
use App\Setting;
use App\Http\Requests\Setting\SaveRequest;

/**
 * @author Yugo <dedy.yugo.purwanto@gmail.com>
 * @link https://github.com/arvernester/newsletter
 */
class GlobalController extends Controller
{
	/**
	 * Get all config and show it into forms
	 * 
	 * @return void
	 */
    public function getIndex()
    {
    	return view('auth.setting.global.index', compact('settings'))
    		->withTitle('Setting');
    }

    /**
     * Save all settings
     * 
     * @return void 
     */
    public function postCreate(SaveRequest $request)
    {
    	$setting = new Setting;

    	// clear all data
    	DB::statement("SET foreign_key_checks=0");
		DB::table($setting->getTable())->truncate();
		DB::statement("SET foreign_key_checks=1");

		foreach ($request->except('_token', '_method') as $property => $value) {
			// prepare for database
			$settings[] = [
				'key' => $property,
				'value' => $value,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			];
		}

		DB::table($setting->getTable())->insert($settings);

		return redirect()
			->back()
			->with('success', 'All settings has been saved.');
    }
}
