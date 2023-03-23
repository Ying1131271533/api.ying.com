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
            'updated_at' => $user->updated_at->toDateString(),
            'created_at' => $user->updated_at->diffForHumans(),
        ];
    }
}
