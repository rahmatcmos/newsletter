<?php

namespace App\Http\Requests\Newsletter;

use Illuminate\Foundation\Http\FormRequest;

class EditListRequest extends FormRequest
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
        return [
            'id'          => 'required|exists:newsletter_lists,id',
            'name'        => 'required|max:50',
            'description' => 'required|max:250',
        ];
    }
}
