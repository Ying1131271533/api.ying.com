<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'     => 'required|min:3|max:16|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|max:50|confirmed', // 必须有 password_confirmation
        ];
    }
}
