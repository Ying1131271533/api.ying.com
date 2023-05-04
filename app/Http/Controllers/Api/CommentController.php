<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\CommentRequest;
use App\Models\Comment;
use App\Models\Order;
use Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends BaseController
{
    /**
     * 添加
     */
    public function store(CommentRequest $request, Order $order)
    {
        $validated = $request->validated();

        // 只有确认收货后，才可以评论 status=4
        if($order->status != 4) {
            return $this->response->errorBadRequest('订单状态异常！');
        }

        // 是否已经评价过
        $comment = Comment::where('user_id', auth('api')->id())
        ->where('order_id', $order->id)
        ->where('goods_id', $validated['goods_id'])
        ->count();
        if($comment > 0) {
            return $this->response->errorBadRequest('此订单已经评价过了~');
        }

        // 要评论的商品必须是这个订单里面存在的商品
        if(!$order->details()->pluck('goods_id')->has($validated['goods_id'])) {
            return $this->response->errorBadRequest('此订单不包含该商品！');
        }

        $validated['user_id'] = auth('api')->id();
        $validated['order_id'] = $order->id;
        // 生成评论
        try {
            DB::beginTransaction();
            Comment::create($validated);
            $order->status = 8;
            DB::commit();
            return $this->response->created();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
