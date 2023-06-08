<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class GoodsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = array_merge([
            'category_id'   => 'required|integer|gt:0|exists:categories,id',
            'brand_id'      => 'required|integer|gt:0|exists:brands,id',
            'goods_type_id' => 'required|integer|gt:0|exists:goods_types,id',
            'cover'         => 'required|max:100',
            // 'description'  => 'required|max:255',
            'market_price'  => 'required|numeric|min:0',
            'shop_price'    => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'is_on'         => 'in:0,1',
            'is_recommend'  => 'in:0,1',
            'pics'          => 'required|array',
            'content'       => 'required', // 商品详情内容
            'attributes' => 'required|array', // 商品属性
            'specs' => 'required|array', // 商品规格
            'spec_itme_pics' => 'array', // 商品规格项的图片
        ], $this->scene());
        return $rules;
    }

    /**
     * 验证场景
     *
     * @return array
     */
    protected function scene()
    {
        // 获取路由名称
        $route_name = $this->route()->getName();
        switch ($route_name) {
            case 'goods.store':
                return [
                    'title' => 'required|max:50|unique:goods',
                ];
                break;
            case 'goods.update':
                return [
                    'title' => [
                        'required',
                        'max:50',
                        Rule::unique('goods')
                            ->ignore($this->good), // 检查唯一性时，排除自己
                    ],
                ];
                break;
            default:
                return [];
                break;

        }
    }
}
