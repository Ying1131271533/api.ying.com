<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SwooleController extends Controller
{
    /**
     * 测试
     */
    public function test()
    {
        return view('swoole.test');
    }

    /**
     * 消息通知
     */
    public function index()
    {
        return view('swoole.notify');
    }

    /**
     * 聊天室
     */
    public function room()
    {
        return view('swoole.room');
    }
}
