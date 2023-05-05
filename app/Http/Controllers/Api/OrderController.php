<?php

namespace App\Http\Controllers\Api;

use App\Facades\Express;
use App\Facades\UtilService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\OrderRequest;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Good;
use App\Models\Order;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $goods_title = $request->query('goods_title');

        $orders = Order::where('user_id', auth('api')->id())
        ->when($status, function($query) use ($status) {
            $query->where('status', $status);
        })
        ->when($goods_title, function($query) use ($goods_title) {
            // 因为定义了远程一对多，所以这里能这样用
            $query->whereHas('goods', function ($query) use ($goods_title) {
                $query->where('title', 'like', "%{$goods_title}%");
            });
        })
        ->paginate(3);
        return $this->response->paginator($orders, new OrderTransformer);
    }

    /**
     * 订单预览页
     */
    public function preview()
    {
        // 地址数据
        $address = Address::where('user_id', auth('api')->id())->orderBy('is_default', 'desc')->get();

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
        // $goods = User::with('cartGoods')->find(1);
        // return $goods;

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

    /**
     * 物流查询
     */
    public function express(Order $order)
    {
        if($order->status != 3) {
            return $this->response->errorBadRequest('订单状态异常！');
        }

        $resultData = Express::track($order->express_type, $order->express_no);
        // $resultData = Express::setType('track')->track($order->express_type, $order->express_no);
        if(!is_array($resultData)) {
            return $this->response->errorBadRequest($resultData);
        }
        return $this->response->array($resultData);
    }

    /**
     * 确认收货
     */
    public function confirm(Order $order)
    {
        if($order->status != 3) {
            return $this->response->errorBadRequest('订单状态异常！');
        }

        try {
            DB::beginTransaction();

            $order->status = 4;
            $order->save();

            // 获取订单所有的商品详情
            $orderDetails = $order->details;

            // 增加订单下所有商品的销量
            foreach ($orderDetails as $detail) {
                // 更新商品销量
                Good::where('id', $detail->goods_id)->increment('sales', $detail->number);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->response->noContent();
    }
}
