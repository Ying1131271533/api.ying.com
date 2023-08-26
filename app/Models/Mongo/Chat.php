<?php

namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Chat extends Model
{
    // 主动维护时间戳
    public $timestamps = true;

    // 连接类型
    protected $connection  = 'mongodb';

    // 集合名称
    protected $collection = 'chats';

    protected $guarded = []; // 允许所有字段批量操作
}
