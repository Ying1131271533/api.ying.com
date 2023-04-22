<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\CartRequest;
use App\Http\Services\Api\CartService;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends BaseController
{
    /**
     * 列表
     */
    public function index()
    {
        //
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
     * 勾选
     */
    public function isChecked(Cart $cart)
    {
        //
    }

    /**
     * 移除
     */
    public function destroy($cart)
    {
        //
    }
}
