<?php

namespace App\Http\Requests\User;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
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
        $groups = implode(',', array_keys(User::getGroups()));

        return [
            'id'    => [
                'required',
                'integer',
                Rule::exists($user->getTable()),
            ],
            'name'  => 'required|max:50',
            'email' => 'required|email|max:100',
            'group' => 'required|in:' . $groups,
        ];
    }
}
