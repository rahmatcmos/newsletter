<?php

namespace App\Http\Controllers\Auth\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SaveRequest;
use App\NewsletterList;
use App\Setting;
use Auth;
use Carbon\Carbon;
use DB;

/**
 * @author Yugo <dedy.yugo.purwanto@gmail.com>
 *
 * @link https://github.com/arvernester/newsletter
 */
class SettingController extends Controller
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

        // get lists
        $lists = NewsletterList::orderBy('name', 'ASC')->get();

        return view('auth.setting.setting.index', compact('drivers', 'lists'))
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

    /**
     * Test email based on provided settings.
     *
     * @return mixed
     */
    public function postEmail()
    {
        $this->authorize('email', Setting::class);

        $data = [
            'level' => 'success',
            'greeting' => 'Halo, ' . Auth::user()->name,
            'introLines' => [
                'Selamat! kamu berhasil mengirim email percobaan.',
                'Email ini dikirim sebagai percobaan pengaturan pada ' . config('app.name') . '.',
            ],
            'outroLines' => [],
        ];

        \Mail::send('email.default', $data, function ($mail) {
            $mail->to(request('email'))
                ->subject(sprintf('Test Email from %s', config('app.name')));
        });

        if (!empty(\Mail::failures())) {
            $message = 'Failed to send email based on provided settings.';
            if (request()->ajax()) {
                return [
                    'status' => false,
                    'message' => $message,
                ];
            }

            return redirect()
                ->route('admin.setting')
                ->with('error', $message);
        }

        $message = 'Congrats! Email has been sent using provider settings.';

        if (request()->ajax()) {
            return [
                'success' => true,
                'message' => $message,
            ];
        }

        return redirect()
            ->route('admin.setting')
            ->with('success', $message);
    }
}
