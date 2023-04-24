<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\CartRequest;
use App\Services\Api\CartService;
use App\Models\Cart;
use App\Transformers\CartTransformer;
use Illuminate\Http\Request;

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
        CartService::saveCart($validated);
        // Cart::create($validated);
        return $this->response->created();
    }

    /**
     * 数量修改
     */
    public function update(CartRequest $request, Cart $cart)
    {
        $validated = $request->validated();
        CartService::saveCart($validated, $cart);
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
