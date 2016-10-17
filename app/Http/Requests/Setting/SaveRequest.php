<?php

namespace App\Http\Requests\Setting;

use App\Setting;
use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $drivers = implode(',', array_keys(Setting::getDrivers()));

        return [
            'app_name' => 'required',
            'app_email' => 'required|email',
            'mail_driver' => 'required',
            'newsletter_list' => 'required|integer|exists:newsletter_lists,id',

            // drivers
            'mail_driver' => 'required:in' . $drivers,
            'mail_host' => 'required',

            // sender
            'mail_from_name' => 'required|string',
            'mail_from_address' => 'required|email',
        ];
    }
}
