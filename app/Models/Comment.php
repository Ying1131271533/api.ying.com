<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     *  不可以批量赋值的属性
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
    ];

    /**
     * 追加字段 配合下面的访问器使用
     *
     * @var array
     */
    protected $appends = [
        'pics_url',
    ];


    /**
     * 获取商品图集oss链接
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getPicsUrlAttribute()
    {
        // 使用集合处理每一项元素，返回处理后新的集合
        return collect($this->pics)->map(function($item, $key) {
            return oss_url($item);
        });
    }

    /**
     * 获取这个评论所属的商品
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class, 'goods_id', 'id');
    }

    /**
     * 获取这个评论所属的用户
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
