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
     * 类型转换
     *
     * @var array
     */
    protected $casts = [
        'pics'  => 'array',
        'market_price' => 'decimal:2',
        'show_price' => 'decimal:2',
    ];

    /**
     * 追加字段 配合下面的访问器使用
     *
     * @var array
     */
    protected $appends = [
        'cover_url',
        // pics_url因为只有商品详情才会用到，所以这里在查询的时候，手动追加字段 使用 append()
        // 'pics_url',
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
        return collect($this->pics)->map(function($item, $key){
            return oss_url($item);
        });
    }

    /**
     * 获取这个商品所属的分类
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 获取这个商品所属的创建用户
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * 获取这个商品所属的用户
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取这个商品的所有评论
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'goods_id', 'id');
    }

    /**
     * 获取这个商品的所有规格项
     */
    public function specItems()
    {
        return $this->hasMany(SpecItem::class);
    }

    /**
     * 获取这个商品的所有属性
     */
    public function attributes()
    {
        return $this->hasMany(GoodsAttribute::class);
    }

    /**
     * 获取这个商品的所有规格项的图片
     */
    public function specItemPics()
    {
        return $this->hasMany(GoodsSpecItemPic::class);
    }
}
