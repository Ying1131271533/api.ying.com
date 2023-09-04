<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\CartRequest;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\GoodsSpec;
use App\Services\Api\CartService;
use App\Services\Api\GoodsService;
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
        $validated            = $request->validated();
        $validated['user_id'] = auth('api')->id();
        // CartService::saveCart($validated);

        // 获取购物车商品数量
        $number = isset($validated['number']) ? $validated['number'] : 1;

        // 获取购物车模型
        $cart = new Cart();

        // 查询购物车是否已存在相同规格的商品
        $existCart = Cart::where('user_id', auth('api')->id())
            ->where('spec', $validated['spec'])
            ->where('goods_id', $validated['goods_id'])
            ->first();
        // return $existCart;
        // 如果存在，则购物车商品数量相加
        if (!empty($existCart)) {
            $cart                = $existCart;
            $validated['number'] = $number + $existCart->number;
        }

        // 验证器那边做了这里
        // 获取商品信息
        // $goods = Goods::find($validated['goods_id']);
        // // 是否上架
        // if($goods->is_on == 0) return $this->response->errorBadRequest('商品已下架');
        // // 数量是否大于库存
        // if($goods->stock < $validated['number']) return $this->response->errorBadRequest('数量不能大于库存！');

        // 保存数据
        $result = $cart->fill($validated)->save();
        if (!$result) {
            return $this->response->errorInternal('保存失败！');
        }

        return $this->response->created();
    }

    /**
     * 数量修改
     */
    public function number(CartRequest $request, Cart $cart)
    {
        // 接受参数
        $validated = $request->validated();
        // 保存数据
        $cart->number = $validated['number'];
        $result       = $cart->save();
        if (!$result) {
            return $this->response->errorInternal('保存失败！');
        }

        // 返回
        return $this->response->noContent();
    }

    /**
     * 规格修改
     */
    public function spec(CartRequest $request, Cart $cart)
    {
        // 接收数据
        $validated = $request->validated();

        // 检查规格是否存在
        $goods_spec = GoodsSpec::where('goods_id', $cart->goods_id)
            ->where('item_ids', $validated['spec'])
            ->first();
        if (!$goods_spec) {
            return $this->response->errorBadRequest('此规格的商品不存在');
        }

        // 保存数据
        $result = $cart->fill($validated)->save();
        if (!$result) {
            return $this->response->errorInternal('保存失败！');
        }

        // 返回
        return $this->response->noContent();
    }

    /**
     * 获取商品所有规格
     */
    public function showSpecs(Cart $cart)
    {
        // 获取商品信息规格
        $goods = Goods::with([
            'specs',
            'specItemPics',
        ])
            ->find($cart->goods_id);

        // 获取商品规格需要显示的规格项
        $show_specs = GoodsService::getShowSpecs($goods->specs);

        // 返回数据
        return $this->response->array([
            'cart'       => $cart,
            'goods'      => $goods,
            'show_specs' => $show_specs,
        ]);
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
