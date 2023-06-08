<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // 'email'    => 'required|email',
            'account'  => 'required',
            'password' => 'required|min:6|max:50',
            // 直接验证密码
            // 'password' => 'current_password:api',
        ];
    }
}
