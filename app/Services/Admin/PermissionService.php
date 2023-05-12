<?php

namespace App\Services\Admin;

use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class PermissionService
{
    public static function savePermission($data, $model = null)
    {
        // 模型
        $permission = $model ? $model : new Permission();

        // 获取父级id
        $parent_id = isset($data['parent_id']) ? $data['parent_id'] : 0;

        // 等级赋值
        $level = 1;

        // 父级id不为0时，找到父级节点
        if($parent_id != 0) {
            $parentPermission = Permission::find($parent_id);
            if(empty($parentPermission)) throw new BadRequestHttpException('父级节点不存在！');
            $level = $parentPermission -> level + 1;
        }

        // 计算等级
        if($level > 3) throw new BadRequestHttpException('节点层级不能大于3级');
        $data['level'] = $level;

        // 看守器
        $data['guard_name'] = 'admin';

        $result = $permission->fill($data)->save();
        if(!$result) throw new BadRequestException('保存失败'); // 500
    }
}
