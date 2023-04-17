<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string',
            'user_role_id' => 'required|exists:user_roles,id',
            'department.*.id' => 'exists:departments,id'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => __('user.username_required'),
            'password.required' => __('user.password_required'),
            'username.unique' => __('user.unique'),
        ];
    }
}
