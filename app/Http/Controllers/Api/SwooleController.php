<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderNotify;
use App\Events\SwooleTest;
use App\Http\Controllers\BaseController;
use App\Models\Goods;
use Illuminate\Http\Request;
use SwooleTW\Http\Websocket\Facades\Websocket;

class SwooleController extends BaseController
{
    public function auth()
    {
        // 与当前 WebSocket 连接绑定
        // Websocket::loginUsingId(auth('api')->user()->id);
        return $this->response->array([
            'id' => auth('api')->user()->id,
            'name' => auth('api')->user()->name,
        ]);
    }
    /**
     * 测试
     */
    public function test()
    {
        SwooleTest::dispatch('你好啊！阿卡丽');
        // broadcast(new SwooleTest('你好啊！'));
        // 只发给其他人
        // broadcast(new SwooleTest('你好啊！'))->toOthers();
        return '发送成功';
    }

    public function messages()
    {
        return '阿卡丽';
    }
}
