<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class PayRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => 'required|in:alipay,wechat',
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
            'type.required' => '支付类型不能为空',
            'type.in'       => '支付类型 只能是 alipay,wechat',
        ];
    }
}
