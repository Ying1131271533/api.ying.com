<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;

class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $permission)
    {
        return [
            'id'         => $permission->id,
            'parent_id'  => $permission->parent_id,
            'name'       => $permission->name,
            'cn_name'    => $permission->cn_name,
            'url'        => $permission->url,
            'level'      => $permission->level,
            'show'       => $permission->show,
            'sort'       => $permission->sort,
            'icon'       => $permission->icon,
            'guard_name' => $permission->guard_name,
            'created_at' => $permission->created_at,
            'updated_at' => $permission->updated_at,
        ];
    }
}
