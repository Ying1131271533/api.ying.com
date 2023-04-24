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
        // 是否有模型
        $cart = new Cart();
        if($model) {
            $cart = $model;
            $goods = $cart->goods;
            $number = $data['number'];
        }else{
            $goods = Good::find($data['goods_id']);
            $number = isset($data['number']) ? $data['number'] : 1;
        }

        // 是否上架
        if($goods->is_on == 0) throw new BadRequestHttpException('商品已下架');
        // 数量是否大于库存
        if($goods->stock < $number) throw new BadRequestHttpException('数量不能大于库存');

        // 保存数据
        $data['user_id'] = auth('api')->id();
        $result = $cart->fill($data)->save();
        if(!$result) throw new BadRequestException('保存失败！');
    }
}
