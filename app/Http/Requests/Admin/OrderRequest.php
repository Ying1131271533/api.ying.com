<?php

namespace App\Http\Requests\Admin;

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
            'express_type' => 'required|in:SF,YT,YD',
            'express_no'   => 'required',
        ];
    }

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'express_type.in' => '快递类型必须为 SF,TY,YD',
        ];
    }

}
