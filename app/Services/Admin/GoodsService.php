<?php

namespace App\Services\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Goods;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class GoodsService
{
    /**
     * 保存商品
     */
    public static function saveGoods($data, $model = null)
    {
        // 模型
        $goods = $model ? $model : new Goods();

        // 找到分类
        $category = Category::find($data['category_id']);
        // 是否被禁用
        if($category['status'] == 0) throw new BadRequestHttpException('分类已被禁用'); // 400
        // 是否为3级分类
        if($category['level'] != 3) throw new UnprocessableEntityHttpException('分类必须为3级'); // 422

        // 找到品牌
        $brand = Brand::find($data['brand_id']);
        // 是否被禁用
        if($brand['status'] == 0) throw new BadRequestHttpException('品牌已被禁用'); // 400

        // 数据加入用户id
        $data['admin_id'] = auth('admin')->id();

        // 取出商品图集和详情内容
        $details = [];
        $details['pics'] = $data['pics'];
        $details['content'] = $data['content'];
        unset($data['pics']);
        unset($data['content']);

        // 取出商品属性
        $attributes = $data['attributs'];
        unset($data['attributs']);

        // 取出商品规格
        $specs = $data['specs'];
        unset($data['specs']);

        // 取出商品规格项的图片
        $spec_itme_pics = $data['spec_itme_pics'];
        unset($data['spec_itme_pics']);

        try {

            // 开启事务
            DB::beginTransaction();

            // 如果是更新，则删除原来的商品属性和规格关联数据
            if(isset($goods->id)) {
                $goods->attributes()->delete();
                $goods->specItems()->delete();
                $goods->specItemPics()->delete();
            }

            // 保存商品
            $goods->fill($data)->save();
            // 保存商品详情
            $goods->details()->updateOrCreate($details);

            // 保存商品属性
            $goods->attributes()->createMany($attributes);

            // 保存商品规格套餐
            $goods->specItems()->createMany($specs);

            // 保存商品规格项的图片
            $goods->specItemPics()->createMany($spec_itme_pics);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
