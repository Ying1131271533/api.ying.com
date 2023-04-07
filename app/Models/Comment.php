<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * 可批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'goods_id',
        'rate',
        'content',
        'reply',
        'pics',
        'created_at',
        'updated_at',
    ];

    /**
     * 类型转换
     *
     * @var array
     */
    protected $casts = [
        'pics'  => 'array',
    ];

    /**
     * 获取这个评论所属的商品
     */
    public function goods()
    {
        return $this->belongsTo(Good::class, 'goods_id', 'id');
    }

    /**
     * 获取这个评论所属的用户
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
