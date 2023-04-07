<?php

namespace App\Transformers;

use App\Models\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    public function transform(Comment $comment)
    {
        // 可include的模型
        $this->setAvailableIncludes(['goods', 'user']);

        $pics_url = [];
        foreach ($comment->pics as $pic) {
            $pics_url[] = oss_url($pic);
        }

        return [
            'id'         => $comment->id,
            'user_id'    => $comment->user_id,
            'goods_id'   => $comment->goods_id,
            'rate'       => $comment->rate,
            'content'    => $comment->content,
            'reply'      => $comment->reply,
            'pics'       => $comment->pics,
            'pics_url'   => $comment->pics_url,
            'created_at' => $comment->created_at->toDateTimeString(),
            'updated_at' => $comment->updated_at->toDateTimeString(),
        ];
    }

    /**
     * 加载用户数据
     */
    public function includeUser(Comment $comment)
    {
        return $this->item($comment->user, new UserTransformer());
    }

    /**
     * 加载商品数据
     */
    public function includeGoods(Comment $comment)
    {
        return $this->item($comment->goods, new GoodsTransformer());
    }
}
