<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class OrderRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'address_id' => 'required', // TODO 地址要存在才行 exists:address,id
        ];
    }
}
