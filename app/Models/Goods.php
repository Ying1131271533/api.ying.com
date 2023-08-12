<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Goods extends Model
{
    use HasFactory;

    /**
     * 不可以批量赋值的属性。 给空数组 那就是所有属性都可以赋值
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 允许批量保存的字段
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'admin_id',
    //     'category_id',
    //     'brand_id',
    //     'goods_type_id',
    //     'title',
    //     'cover',
    //     'market_price',
    //     'shop_price',
    //     'stock',
    //     'sales',
    //     'is_on',
    //     'is_recommend',
    // ];

    /**
     * 类型转换
     *
     * @var array
     */
    protected $casts = [
        'cover_url' => 'array',
        'pics'      => 'array',
    ];

    /**
     * 追加字段 配合下面的访问器使用
     *
     * @var array
     */
    protected $appends = [
        'cover_url',
    ];

    /**
     * 获取oss封面链接 - 这种可以访问不存在的字段
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getCoverUrlAttribute()
    {
        return oss_url($this->cover);
    }

    /**
     * 获取商品图集oss链接
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getPicsUrlAttribute()
    {
        // 使用集合处理每一项元素，返回处理后新的集合
        return collect($this->pics)->map(function ($item, $key) {
            return oss_url($item);
        });
    }

    /**
     * 获取这个商品所属的创建管理员
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * 获取这个商品所属的分类
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 获取这个商品所属的品牌
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * 获取这个商品所属的商品类型
     */
    public function goodsType()
    {
        return $this->belongsTo(GoodsType::class);
    }

    /**
     * 获取这个商品的详情
     */
    public function details()
    {
        return $this->hasOne(GoodsDetails::class);
    }

    /**
     * 获取这个商品的所有属性
     */
    public function attributes()
    {
        return $this->hasMany(GoodsAttribute::class);
        // return $this->belongsToMany(Attribute::class, GoodsAttribute::class);
    }

    /**
     * 获取这个商品的所有规格套餐
     */
    public function specs()
    {
        return $this->hasMany(GoodsSpec::class);
    }

    /**
     * 获取这个商品所有规格项的图片
     */
    public function specItemPics()
    {
        return $this->hasMany(GoodsSpecItemPic::class);
    }

    /**
     * 获取这个商品的所有订单，这样行不行
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, OrderGoods::class);
    }

    /**
     * 获取这个商品的所有评论
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'goods_id', 'id');
    }

    /********************* ElasticSearch *********************/

    use Searchable;

    /**
     * 指定索引(表名)
     * @return string
     */
    // public function searchableAs()
    // {
    //     return 'goods';
    // }

    /**
     * 获取模型的可索引数据。
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        // $array = $this->toArray();

        $array = [
            'id'           => $this->id,
            'title'        => $this->title,
            'cover'        => $this->cover,
            'category_id'  => $this->category_id,
            'brand_id'     => $this->brand_id,
            'market_price' => $this->market_price,
            'shop_price'   => $this->shop_price,
            'stock'        => $this->stock,
            'sales'        => $this->sales,
            'is_on'        => $this->is_on,
            'is_recommend' => $this->is_recommend,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
            'is_on'        => $this->is_on,
            'is_recommend' => $this->is_recommend,
        ];

        $skus          = $this->specs()->select(['item_ids_name as name', 'spec_price as price'])->get();
        $array['skus'] = $skus->toArray();

        $attributes = $this->attributes()->with('attribute')->get()->toArray();
        $temp       = [];
        foreach ($attributes as $value) {
            $temp[] = [
                'name'  => $value['attribute']['name'],
                'value' => $value['value'],
            ];
        }
        $array['attributes'] = $temp;

        return $array;
    }

    /**
     * 指定 搜索索引中存储的唯一ID
     * @return mixed
     */
    public function getScoutKey()
    {
        return $this->id;
    }

    /**
     * 指定 搜索索引中存储的唯一ID的键名
     * @return string
     */
    public function getScoutKeyName()
    {
        return 'id';
    }
}
