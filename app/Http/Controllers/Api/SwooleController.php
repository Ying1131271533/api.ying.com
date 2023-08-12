<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderNotify;
use App\Http\Controllers\BaseController;
use App\Models\Goods;
use Illuminate\Http\Request;

class SwooleController extends BaseController
{
    /**
     * 测试
     */
    public function test()
    {
        return '阿卡丽';
        $goods = Goods::find(1);
        OrderNotify::dispatch($goods);
    }
}
