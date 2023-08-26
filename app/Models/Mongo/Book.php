<?php

namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Book extends Model // 这里继承mongodb的模型类
{
    // 主动维护时间戳
    public $timestamps = true;

	// 软删除
	// use SoftDeletes;

    // 连接类型
    protected $connection  = 'mongodb';

    // 集合名称
    // protected $collection = 'books';

    protected $guarded = []; // 允许所有字段批量操作
    // protected $fillable = ['title', 'view_count', 'created_at'];

	// 设置为自己的主键属性名称
	// protected $primaryKey = 'id';

	// 日期：使用 Carbon 或 DateTime 对象
    // 如果开启了主动维护时间戳，这里就不需要了
	// protected $casts = [
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',
    // ];


    /**
     * 获取这本书的作者
     */
    public function author()
    {
        return $this->hasOne(Author::class);
    }
}
