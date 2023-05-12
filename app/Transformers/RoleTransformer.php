<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Role;

class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            'id'         => $role->id,
            'name'       => $role->name,
            'email'      => $role->cn_name,
            'phone'      => $role->guard_name,
            'created_at' => $role->created_at,
            'updated_at' => $role->updated_at,
        ];
    }
}
