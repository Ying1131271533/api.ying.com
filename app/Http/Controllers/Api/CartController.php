<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\CartRequest;
use App\Services\Api\CartService;
use App\Models\Cart;
use App\Models\Good;
use App\Transformers\CartTransformer;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;

class CartController extends BaseController
{
    /**
     * 列表
     */
    public function index()
    {
        $carts = Cart::where('user_id', auth('api')->id())->get();
        return $this->response->collection($carts, new CartTransformer);
    }

    /**
     * 加入购物车
     */
    public function store(CartRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth('api')->id();
        // CartService::saveCart($validated);

        // 获取商品信息
        $goods = Good::find($validated['goods_id']);

        // 获取购物车商品数量
        $number = isset($validated['number']) ? $validated['number'] : 1;

        // 获取购物车模型
        $cart = new Cart();

        // 查询购物车是否已存在相同的商品
        $existCart = Cart::where('user_id', auth('api')->id())
        ->where('goods_id', $validated['goods_id'])
        ->first();
        // 如果存在，则购物车商品数量相加
        if(!empty($existCart)) {
            $cart = $existCart;
            $validated['number'] = $number + $existCart->number;
        }

        // 是否上架
        if($goods->is_on == 0) return $this->response->errorBadRequest('商品已下架');
        // 数量是否大于库存
        if($goods->stock < $validated['number']) return $this->response->errorBadRequest('数量不能大于库存！');

        // 保存数据
        $result = $cart->fill($validated)->save();
        if(!$result) return $this->response->errorInternal('保存失败！');

        return $this->response->created();
    }

    /**
     * 数量修改
     */
    public function update(CartRequest $request, Cart $cart)
    {
        $validated = $request->validated();
        // CartService::saveCart($validated, $cart);

        // 获取商品信息
        $goods = $cart->goods;
        // 是否上架
        if($goods->is_on == 0) return $this->response->errorBadRequest('商品已下架');
        // 数量是否大于库存
        if($goods->stock < $validated['number']) return $this->response->errorBadRequest('数量不能大于库存');

        // 保存数据
        $data['user_id'] = auth('api')->id();
        $result = $cart->fill($data)->save();
        if(!$result) return $this->response->errorInternal('保存失败！');

        return $this->response->noContent();
    }

    /**
     * 选中
     */
    public function isChecked(Cart $cart)
    {
        $cart->is_checked = $cart->is_checked == 0 ? 1 : 0;
        $cart->save();
        return $this->response->noContent();
    }

    /**
     * 移除
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return $this->response->noContent();
    }
}
