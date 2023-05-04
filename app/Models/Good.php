<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;

    /**
     * 不可以批量赋值的属性。 给空数组 那就是所有属性都可以赋值
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 可批量赋值的属性。
     *
     * @var array
     */
    // protected $fillable = [
    //     'user_id',
    //     'category_id',
    //     'title',
    //     'description',
    //     'price',
    //     'stock',
    //     'sales',
    //     'cover',
    //     'pics',
    //     'is_on',
    //     'is_recommend',
    //     'details',
    // ];

    /**
     * 类型转换
     *
     * @var array
     */
    protected $casts = [
        'pics'  => 'array',
        'price' => 'double',
    ];

    /**
     * 追加字段 配合下面的访问器使用
     *
     * @var array
     */
    protected $appends = [
        'cover_url',
        // 这里因为只有商品详情才会用到，所以这里在查询的时候，手动追加字段 使用 append()
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
     * 获取这个商品的所有订单
     */
    public function orderDateils()
    {
        return $this->hasMany(OrderDetails::class);
    }
}
