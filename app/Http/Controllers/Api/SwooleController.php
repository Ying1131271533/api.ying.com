<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SwooleController extends Controller
{
    public function test()
    {
        $client = new Client('ws://124.71.218.160:9502');
        // $client = new Client('wss://124.71.218.160:9502');
        $client->send('哎嘿');
        // 接收服务端返回的信息
        dump($client->receive());
        $client->close();
    }
}
