<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'phone'      => $user->phone,
            'avatar'     => $user->avatar,
            'avatar_url' => oss_url($user->avatar),
            'is_locked'  => $user->is_locked,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }
}
