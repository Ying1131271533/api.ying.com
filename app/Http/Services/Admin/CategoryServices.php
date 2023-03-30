<?php

namespace App\Http\Services\Admin;

use App\Http\Services\BaseServices;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CategoryServices extends BaseServices
{
    public static function saveCategory($data, $model = null)
    {
        // 模型
        $blog = $model ? $model : new Category();

        // 获取父级id
        $parent_id = $data['parent_id'];

        // 计算等级
        $data['level'] = $parent_id == 0 ? 1 : Category::find($parent_id)->level + 1;

        // 分类不能超过3级
        if($data['level'] > 3) throw new BadRequestException('等级不能大于3级');

        // 保存数据
        $result = $blog->fill($data)->save();
        if(!$result) throw new HttpException('保存失败！');
    }
}
