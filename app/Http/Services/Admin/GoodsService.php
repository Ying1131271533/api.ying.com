<?php

namespace App\Http\Services\Admin;

use App\Models\Category;
use App\Models\Good;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class GoodsService
{
    public static function saveGoods($data, $model = null)
    {
        // 模型
        $good = $model ? $model : new Good();

        // 找到分类
        $category = Category::find($data['category_id']);
        // 是否被禁用
        if($category['status'] == 0) throw new BadRequestHttpException('分类已被禁用');
        // 是否为3级分类
        if($category['level'] != 3) throw new UnprocessableEntityHttpException('分类必须为3级');

        // 数据加入用户id
        $data['user_id'] = auth('api')->id();

        // 保存数据
        $result = $good->fill($data)->save();
        if(!$result) throw new BadRequestException('保存失败！');
    }
}
