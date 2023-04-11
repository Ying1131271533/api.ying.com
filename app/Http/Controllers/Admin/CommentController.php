<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\CommentRequest;
use App\Models\Comment;
use App\Models\Good;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    /**
     * 评价列表
     */
    public function index(Request $request)
    {
        // 搜索条件
        $rate = $request->query('rate');
        $goods_title = $request->query('goods_title');
        $comments = Comment::when($rate, function($query) use ($rate) {
            $query->where('rate', $rate);
        })
        ->when($goods_title, function($query) use ($goods_title) {
            // 获取相关的商品id，老师说一般项目里面这样用，因为like很耗费性能
            $goods_ids = Good::where('title', 'like', "%{$goods_title}%")->pluck('id');
            $query->whereIn('goods_id', $goods_ids);
        })
        ->paginate(1);
        return $this->response->paginator($comments, new CommentTransformer);
    }

    /**
     * 评价详情
     */
    public function show(Comment $comment)
    {
        return $this->response->item($comment, new CommentTransformer);
    }

    /**
     * 商家回复
     */
    public function reply(CommentRequest $request, Comment $comment)
    {
        $validated = $request->validated();
        $result = $comment->fill($validated)->save();
        if(!$result) return $this->response->errorInternal('回复失败！');
        return $this->response->noContent();
    }
}
