<?php

namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Author extends Model
{
    // 连接类型
    protected $connection  = 'mongodb';

    // 集合名称
    // protected $collection = 'contents';

    protected $guarded = []; // 允许所有字段批量操作
}
