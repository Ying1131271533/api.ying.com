<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
use App\Rules\Api\CheckGoodsStock;
use App\Rules\Api\GoodsIsOn;
use App\Rules\Api\GoodsStock;

class CartRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return $this->scene();
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
            case 'carts.store':
                return [
                    'goods_id' => [
                        'required',
                        'integer',
                        'gt:0',
                        'exists:goods,id',
                        new GoodsIsOn($this->goods_id),
                    ],
                    'number'   => [
                        'integer',
                        'gt:0',
                        new CheckGoodsStock($this->goods_id),
                    ],
                    'spec'   => [
                        'required',
                        'max:120',
                        'exists:goods_specs,item_ids',
                    ],
                    'spec_name'   => [
                        'required',
                        'max:120',
                        'exists:goods_specs,item_ids_name',
                    ],
                ];
                break;
            case 'carts.number':
                return [
                    'number' => [
                        'required',
                        'integer',
                        'gt:0',
                        new GoodsIsOn($this->cart->goods_id),
                        new CheckGoodsStock($this->cart->goods->id),
                        // new CheckGoodsStock($this->cart->goods),
                        // function ($attribute, $value, $fail) {
                        //     if($value > $this->cart->goods->stock) {
                        //         $fail('数量不能大于库存！');
                        //     }
                        // }
                    ],
                ];
                break;
                case 'carts.spec':
                    return [
                        'spec'   => [
                            'required',
                            'max:255',
                            'exists:goods_specs,item_ids',
                            new GoodsIsOn($this->cart->goods_id),
                        ],
                        'spec_name'   => [
                            'required',
                            'max:255',
                            'exists:goods_specs,item_ids_name',
                        ],
                    ];
                    break;
            default:
                return [];
                break;

        }
    }

}
