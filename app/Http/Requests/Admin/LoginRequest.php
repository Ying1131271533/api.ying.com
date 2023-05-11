<?php

namespace App\Http\Requests\Admin;

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
            'account'  => 'required',
            'password' => 'required|min:6|max:50',
        ];
    }
}
