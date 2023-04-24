<?php

namespace App\Http\Controllers\Api;

use App\Facades\UtilService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class OrderController extends BaseController
{
    /**
     * 订单预览页
     */
    public function preview()
    {
        // 地址数据
        // TODO 暂时模拟用户的地址数据
        $address = [
            ['id' => 1, 'name' => 'Tom', 'address' => '北京xxx', 'phone' => '1511949xxxx'],
            ['id' => 2, 'name' => 'Akali', 'address' => '北京xxx', 'phone' => '1511949xxxx'],
            ['id' => 3, 'name' => 'Jinx', 'address' => '北京xxx', 'phone' => '1511949xxxx'],
        ];

        // 购物车数据
        $carts = Cart::where('user_id', auth('api')->id())
            ->where('is_checked', 1)
            ->with('goods:id,cover,title,price')
        // ->with(['goods:id,cover,title,price', 'user:id,name,avatar'])
            ->get();

        // 返回数据
        return $this->response->array([
            'address' => $address,
            'carts'   => $carts,
        ]);
    }

    /**
     * 订单预览页
     */
    public function store(OrderRequest $request)
    {
        $validated = $request->validated();

        // 处理订单数据
        $user_id  = auth('api')->id();
        $order_no = UtilService::generateReceiptCode(); // 生成订单号
        $amount   = 0;

        // 获取选中的购物车
        $carts = Cart::where('user_id', $user_id)
            ->where('is_checked', 1)
            ->with('goods:id,price')
            ->get();
        if (empty($carts)) {
            return $this->response->errorBadRequest('未选择商品！');
        }

        // 要保存的订单详情的数据
        $orderDetailData = [];

        // 计算总金额
        foreach ($carts as $key => $cart) {
            $orderDetailData[] = [
                'goods_id' => $cart->goods->id,
                'price'    => $cart->goods->price,
                'number'   => $cart->number,
            ];
            $amount += $cart->goods->price * $cart->number;
        }

        // 生成订单
        $order = Order::create([
            'user_id'    => $user_id,
            'order_on'   => $order_no,
            'address_id' => $validated['address_id'],
            'amount'     => $amount,
        ]);

        // 生成订单详情

        return $amount;
    }
}
