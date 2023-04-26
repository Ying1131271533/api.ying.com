<?php

namespace App\Http\Controllers\Api;

use App\Facades\UtilService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\OrderRequest;
use App\Models\Cart;
use App\Models\Good;
use App\Models\Order;
use App\Models\User;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
     * 提交订单
     */
    public function store(OrderRequest $request)
    {
        // 测试远程一对多
        // $order = Order::find(1);
        // $goods = $order->goods;
        // return $goods;
        $goods = User::with('cartGoods')->find(1);
        return $goods;

        $validated = $request->validated();

        // 处理订单数据
        $user_id  = auth('api')->id();
        $order_no = UtilService::generateReceiptCode(); // 生成订单号
        $amount   = 0;

        // 获取选中的购物车 - 查询构造器
        $cartsQuery = Cart::where('user_id', $user_id)
            ->where('is_checked', 1)
            ->with('goods:id,title,price,stock');

        // 查询构造器获取购物车数据
        $carts = $cartsQuery->get();
        if (empty($carts)) {
            return $this->response->errorBadRequest('未选择商品！');
        }

        // 要保存的订单详情的数据
        $orderDetailData = [];

        // 计算总金额
        foreach ($carts as $key => $cart) {
            // 是否存在库存不足的商品
            if ($cart->goods->stock < $cart->number) {
                return $this->response->errorBadRequest('商品：' . $cart->goods->title . ' 库存不足，请重新选择商品！');
            }
            $orderDetailData[] = [
                'goods_id' => $cart->goods->id,
                'price'    => $cart->goods->price,
                'number'   => $cart->number,
            ];
            // 总金额
            $amount += $cart->goods->price * $cart->number;
        }

        // 开启事务
        DB::beginTransaction();

        try {
            // 生成订单
            $order = Order::create([
                'user_id'    => $user_id,
                'order_no'   => $order_no,
                'address_id' => $validated['address_id'],
                'amount'     => $amount,
            ]);

            // 生成订单详情
            $order->details()->createMany($orderDetailData);

            // 查询构造器删除选中的购物车数据
            $cartsQuery->delete();

            // 减去商品对应的库存量
            foreach ($carts as $cart) {
                Good::where('id', $cart->goods_id)->decrement('stock', $cart->number);
            }

            // 提交事务
            DB::commit();
            return $this->response->created();
        } catch (\Exception$e) {
            // 回滚事务
            DB::rollBack();
            throw $e;
            // return $this->response->errorInternal($e->getMessage());
        }
    }

    /**
     * 订单详情
     */
    public function show(Order $order)
    {
        return $this->response->item($order, new OrderTransformer);
    }
}
