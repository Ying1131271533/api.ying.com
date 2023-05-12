<?php

namespace App\Services\Admin;

use App\Models\Admin;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AdminService
{
    public static function saveAdmin($data, $model = null)
    {
        // 模型
        $admin = $model ? $model : new Admin();

        // 密码
        $data['password'] = bcrypt($data['password']);

        // 保存
        $result = $admin->fill($data)->save();
        if(!$result) throw new BadRequestException('保存失败');
    }
}
