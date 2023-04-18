<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;

    /**
     * 可批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'stock',
        'cover',
        'pics',
        'is_on',
        'is_recommend',
        'details',
    ];

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
}
