<?php

namespace App\Http\Requests\User;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteRequest extends FormRequest
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
        $user = new User;

        return [
            'id' => [
                'required',
                'integer',
                Rule::exists($user->getTable()),
            ],
        ];
    }
}
