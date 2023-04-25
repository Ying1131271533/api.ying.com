<?php

namespace App\Services\Api;

use App\Models\Cart;
use App\Models\Good;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CartService
{
    public static function saveCart($data, $model = null)
    {
        // 是否有模型，有则是更新
        $cart = new Cart();
        if($model) {
            $cart = $model;
            $goods = $cart->goods;
            $number = $data['number'];
        }else{
            $goods = Good::find($data['goods_id']);
            $number = isset($data['number']) ? $data['number'] : 1;
            // 查询购物车是否已存在相同的商品
            $existCart = Cart::where('user_id', auth('api')->id())
            ->where('goods_id', $data['goods_id'])
            ->first();
            // 如果存在，则相加
            if(!empty($existCart)) {
                $cart = $existCart;
                $data['number'] = $number + $existCart->number;
            }
        }

        // 是否上架
        if($goods->is_on == 0) throw new BadRequestHttpException('商品已下架');
        // 数量是否大于库存
        if($goods->stock < $data['number']) throw new BadRequestHttpException('数量不能大于库存');

        // 保存数据
        $data['user_id'] = auth('api')->id();
        $result = $cart->fill($data)->save();
        if(!$result) throw new BadRequestException('保存失败！');
    }
}
