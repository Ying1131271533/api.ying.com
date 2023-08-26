<?php

namespace App\Transformers;

use App\Models\Mongo\Chat;
use League\Fractal\TransformerAbstract;

class ChatMessagesTransformer extends TransformerAbstract
{
    public function transform(Chat $chat)
    {
        return [
            'id'         => $chat->id,
            'admin_id'   => $chat->admin_id,
            'user_id'    => $chat->user_id,
            'message'     => $chat->message,
            'is_user'     => $chat->is_user,
            'created_at'  => $chat->created_at,
            'updated_at'  => $chat->updated_at,
        ];
    }

}
