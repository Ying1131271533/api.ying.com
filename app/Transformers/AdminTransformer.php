<?php

namespace App\Transformers;

use App\Models\Admin;
use League\Fractal\TransformerAbstract;

class AdminTransformer extends TransformerAbstract
{
    public function transform(Admin $admin)
    {
        return [
            'id'         => $admin->id,
            'name'       => $admin->name,
            'email'      => $admin->email,
            'phone'      => $admin->phone,
            'is_locked'  => $admin->is_locked,
            'created_at' => $admin->created_at,
            'updated_at' => $admin->updated_at,
        ];
    }
}
