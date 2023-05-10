<?php

namespace App\Models;

use Spatie\Permission\Models\Permission;

class Node extends Permission
{
    /**
     * 子类
     */
    public function children()
    {
        return $this->hasMany(Node::class, 'parent_id', 'id');
    }
}
