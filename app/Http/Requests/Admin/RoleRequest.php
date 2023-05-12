<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class RoleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'       => 'required|unique:roles',
            'cn_name'    => 'required',
        ];
    }
}
