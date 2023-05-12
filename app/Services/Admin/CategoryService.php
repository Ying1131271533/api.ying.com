<?php

namespace App\Services\Admin;

use App\Models\Category;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class CategoryService
{
    public static function saveCategory($data, $model = null)
    {
        // 模型
        $category = $model ? $model : new Category();

        // 获取父级id
         $parent_id = isset($data['parent_id']) ? $data['parent_id'] : 0;

        // 计算等级
        $data['level'] = $parent_id == 0 ? 1 : Category::find($parent_id)->level + 1;

        // 分类不能超过3级
        if($data['level'] > 3) throw new UnprocessableEntityHttpException('等级不能大于3级');

        // 保存数据
        $result = $category->fill($data)->save();
        if(!$result) throw new BadRequestException('保存失败！');  // 500
    }
}
