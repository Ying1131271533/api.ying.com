<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class CommentRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'goods_id' => 'required',
            'rate'     => 'in:1,2,3',
            'content'  => 'required|min:3|max:255',
            'pics'     => 'array',
            'star'     => 'in:1,2,3,4,5',
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
            'rate.in'          => '评价等级只能是好评、中评、差评',
            'content.required' => '评价内容不能为空',
            'content.min'      => '评价不能少于3个字数',
            'content.max'      => '评价不能大于于255个字数',
            'pics.array'       => '商品晒图必须是数组',
            'star.in'          => '评价星级只能是1-5星',
        ];
    }
}
