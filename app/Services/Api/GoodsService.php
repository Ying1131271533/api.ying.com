<?php

namespace App\Services\Api;

use App\Models\Brand;
use App\Models\Goods;
use App\Models\GoodsAttribute;
use App\Models\SpecItem;
use App\Services\Lib\ElasticsearchService;
use App\Services\Lib\PublicService;

class GoodsService
{
    /**
     * 获取显示的商品规格
     */
    public static function getShowSpecs($goods_specs)
    {
        $item_ids = [];
        foreach ($goods_specs as $value) {
            $temp     = explode('_', $value->item_ids);
            $item_ids = array_merge($item_ids, $temp);
        }
        // 获取规格项数据
        $specsItems = SpecItem::whereIn('id', array_unique($item_ids))->with('spec')->get();
        // 处理数据
        $show_specs = [];
        foreach ($specsItems as $item) {
            $show_specs[$item->spec->name][] = [
                'id'      => $item->id,
                'spec_id' => $item->spec_id,
                'name'    => $item->name,
            ];
        }
        return $show_specs;
    }

    // 获取商品属性筛选数据
    public static function getGoodsAttrScreen($params)
    {
        // 品牌
        $brands = self::getBrandData($params);

        // 获取商品拥有的属性
        $attributes = self::getAttrData($params);

        // 返回数据
        return array_merge($brands, $attributes);
    }

    // 获取商品列表
    public static function getGoodsList(array $params)
    {
        // 参数
        $title       = $params['title'];
        $category_id = $params['category_id'];
        $brand_id    = $params['brand_id'];
        $attr        = $params['attr'];
        $sort        = $params['sort'];
        $is_on       = $params['is_on'];
        $price_range = $params['price_range'];
        $limit       = $params['limit'];
        $page        = $params['page'];

        // 查询条件
        $where   = [];
        $where[] = ['is_on', 1];
        $where[] = ['category_id', $category_id];

        // 商品的查询条件语句
        $goodsQuery = Goods::select('id', 'category_id', 'brand_id', 'title', 'cover', 'market_price', 'shop_price', 'stock', 'sales')
            ->where($where)
            ->when($title, function ($query) use ($title) {
                $query->where('title', 'like', "%{$title}%");
            })
            ->when($brand_id, function ($query) use ($brand_id) {
                $query->where('brand_id', $brand_id);
            })
            ->when($attr, function ($query) use ($attr) {
                $attrArray = GoodsService::handelAttrStrToArray($attr);
                $goods_ids = [];
                // 找到所有符合条件的数据
                foreach ($attrArray as $key => $value) {
                    $temp = GoodsAttribute::where('attribute_id', $key)
                        ->where('value', $value)
                        ->pluck('goods_id')
                        ->toArray();
                    if (empty($goods_ids)) {
                        $goods_ids = $temp;
                    } else {
                        // 符合条件的数组， 每次都进行交集
                        $goods_ids = array_intersect($goods_ids, $temp);
                    }

                }
                $query->whereIn('id', $goods_ids);
            });

        // 商品的排序，老师：正常的排序没有这么简单，而是使用了复杂的算法
        $goods = $goodsQuery->when($sort, function ($query) use ($sort) {
            $sortArray = explode('-', $sort);
            switch ($sortArray[0]) {
                case 'sales':
                    $query->orderBy('sales', $sortArray[1]);
                    break;
                case 'comments_count':
                    $query->orderBy('comments_count', $sortArray[1]);
                    break;
                case 'new':
                    $query->orderBy('id', $sortArray[1]);
                    break;
                case 'price':
                    $query->orderBy('shop_price', $sortArray[1]);
                    break;
                default:
                    // 默认的排序
                    $query->orderBy('sales', 'desc');
                    $query->orderBy('comments_count', 'desc');
                    break;
            }
        }, function ($query) {
            // 默认的排序
            $query->orderBy('sales', 'desc');
            $query->orderBy('comments_count', 'desc');
        })
            ->when($price_range, function ($query) use ($price_range) {
                // 价格范围
                $price = explode('-', $price_range);
                // 是否在给定的两个字段的值的范围中
                $query->whereBetween('shop_price', $price);
            })
            ->withCount('comments')
            ->simplePaginate($limit);
        return $goods;
    }

    // 获取es商品列表
    public static function getEsGoodsList(array $params)
    {
        // 参数
        $search      = $params['search'];
        $category_id = $params['category_id'];
        $brand_id    = $params['brand_id'];
        $attributes  = $params['attributes'];
        $skus        = $params['skus'];
        $sort        = $params['sort'];
        $price_range = $params['price_range'];
        $limit       = $params['limit'];
        $page        = $params['page'];

        $esService = new ElasticsearchService('goods');
        // 封装es类，增加商品状态为上架条件的分页查询结构
        // $builder = $esService->queryByFilter('term', 'shop_id', $shop_id)->paginate($page, $limit);
        $builder = $esService->queryByFilter('term', 'is_on', 1)->paginate($page, $limit);

        // 分类搜索
        if ($category_id) {
            // 获取分类信息
            $category = PublicService::category($category_id);

            // 根据字段-条件搜索
            if ($category && $category->is_directory) {
                $builder->queryByFilter('prefix', 'category_path', $category->path . $category->id . '-');
            } else {
                $builder->queryByFilter('term', 'category_id', $category->id);
            }
        }

        // 关键词按照权重进行搜索
        if ($search) {
            $keywords = array_filter(explode(' ', $search));

            $builder->keyWords($keywords);
        }

        // 排序
        if ($sort) {
            if (preg_match('/^(.+)_(asc|desc)$/', $sort, $m)) {
                // 只有当前三个字段才可以进行排序搜索
                if (in_array($m[1], ['price', 'sales', 'review_count'])) {
                    $builder->orderBy($m[1], $m[2]);
                }
            }
        }

        $attributeFilter = [];

        // 根据商品属性搜索
        if ($attributes) {
            $attrArray = explode("|", $attributes);
            foreach ($attrArray as $attr) {
                list($name, $value)     = explode(":", $attr);
                $attributeFilter[$name] = $value;
                $builder->attributeFilter($name, $value);
            }
        }

        // 获取的字段
        $builder->source(['id', 'title', 'cover', 'skus', 'attributes', 'created_at']);

        // 执行es搜索
        $restful = app('es')->search($builder->getParams());

        // 多维数组转换一维数组
        list($data, $total) = $builder->getDataByEs($restful);

        return compact('data', 'total', 'page');
    }

    // 获取商品拥有的属性
    protected static function getAttrData($params)
    {
        // dump($params);
        // 分类id
        $category_id = isset($params['category_id']) ? $params['category_id'] : 0;

        // 获取此分类下的所有商品id
        $goods_ids = Goods::where('category_id', $category_id)->pluck('id');

        // 获取商品拥有的属性
        $goodsAttr = GoodsAttribute::select('attributesibute_id', 'value')
            ->whereIn('goods_id', $goods_ids)
            ->with('attribute')
            ->groupBy('attribute_id', 'value')
            ->get();
        // dd($goodsAttr);
        // 获取筛选的属性
        // $attr = [
        //     '网络机制' => [
        //         [
        //             'value' => '低价机',
        //             'url' => '',
        //             'selected' => 1,
        //         ],
        //         [....]
        //     ]
        // ];

        $attrParamsArray = [];
        // 接收并处理attr参数
        if (isset($params['attr'])) {
            $attrParamsArray = self::handelAttrStrToArray($params['attr']);
        }

        $attributes = [];
        foreach ($goodsAttr as $value) {
            $tempAttrParams = $attrParamsArray;
            // 删除当前的attr值
            unset($tempAttrParams[$value->attribute_id]);
            // 每组属性还没添加到数组之前，第一项都是全部
            if (!isset($attributes[$value->attribute->name])) {
                // 把原来参数attr重新赋值每项的商品属性
                $params['attr']                        = self::handelAttrParams($tempAttrParams);
                $attributes[$value->attribute->name][] = [
                    'value'    => '全部',
                    'url'      => url('api/goods', $params),
                    'selected' => !isset($attrParamsArray[$value->attribute_id]) ? 1 : 0,
                ];
            }

            // 加入自己的attr值
            $tempAttrParams[$value->attribute_id]  = $value->value;
            $params['attr']                        = self::handelAttrParams($tempAttrParams);
            $attributes[$value->attribute->name][] = [
                'attribute_id' => $value->attribute_id,
                'value'        => $value->value,
                'url'          => url('api/goods', $params),
                'selected'     => isset($attrParamsArray[$value->attribute_id]) && $attrParamsArray[$value->attribute_id] == $value->value ? 1 : 0,
            ];
        }
        return $attributes;
    }

    // 处理属性字符串
    public static function handelAttrStrToArray($attr_str)
    {
        $attrParams = explode('-', $attr_str);
        foreach ($attrParams as $value) {
            $temp                      = explode('_', $value);
            $attrParamsArray[$temp[0]] = $temp[1];
        }
        return $attrParamsArray;
    }

    // 处理attr参数 - 返回链接上的形式：网络制式_4g-外观样式/手机类型_触屏
    protected static function handelAttrParams(array $attr_params)
    {
        $temp = [];
        foreach ($attr_params as $key => $value) {
            $temp[] = "{$key}_{$value}";
        }
        return implode('-', $temp);
    }

    // 获取商品品牌数据
    protected static function getBrandData($params)
    {
        // 分类id
        $category_id = isset($params['category_id']) ? $params['category_id'] : 0;

        // 找出分类中所有商品中的品牌
        $brand_ids = Goods::where('category_id', $category_id)
            ->groupBy('brand_id') // 分组去重
            ->pluck('brand_id');
        $brandsData = Brand::select(['id', 'name', 'logo'])->whereIn('id', $brand_ids)->get();
        // 如果没有传入分类id，则返回空数组
        if ($brandsData->isEmpty()) {
            return [];
        }

        $temp = $params;
        unset($temp['brand_id']);
        // 第一项是全部
        $brands['品牌'][] = [
            'value'    => '全部',
            'url'      => url('api/goods', $temp),
            'selected' => !isset($params['brand_id']) ? 1 : 0,
        ];
        foreach ($brandsData as $value) {
            $temp['brand_id']   = $value->id;
            $selected           = isset($params['brand_id']) && $params['brand_id'] == $value->id ? 1 : 0;
            $brands['品牌'][] = [
                'brand_id' => $value->id,
                'value'    => $value->name,
                'url'      => url('api/goods', $params),
                'selected' => $selected,
            ];
        }

        return $brands;
    }
}
