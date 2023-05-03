<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
use App\Models\Citie;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'     => 'required',
            'citie_code' => ['required', function ($attribute, $value, $fail) {
                $citie = Citie::where('code', $value)->first();
                if (empty($citie)) $fail('地区不存在');
                // if (!in_array($citie->level, [3, 4])) $fail('区域 必须是县级或乡镇');
                if ($citie->level != 4) $fail('区域 必须是县级或乡镇');
            }],
            'address'  => 'required',
            'phone'    => 'required|regex:/^1[3-9]\d{9}$/',
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
            'name.required' => '收货人名称不能为空',
            'address.required' => '详细收货地址不能为空',
            'phone.required' => '手机号码不能为空',
        ];
    }
}
