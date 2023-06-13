<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsDetails extends Model
{
    use HasFactory;

    /**
     * 指示模型是否主动维护时间戳。
     *
     * @var bool
     */
    public $timestamps = false;

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
    //     'goods_id',
    //     'pics',
    //     'content',
    // ];


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
        return collect($this->pics)->map(function($item, $key){
            return oss_url($item);
        });
    }
}
