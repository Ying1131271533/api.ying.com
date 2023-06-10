<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'pics' => 'array',
    ];

    /**
     * 追加字段 配合下面的访问器使用
     *
     * @var array
     */
    protected $appends = [];

    /**
     * 获取oss封面链接 - 这种可以访问不存在的字段
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    // public function getCoverUrlAttribute()
    // {
    //     return oss_url($this->cover);
    // }

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
}
