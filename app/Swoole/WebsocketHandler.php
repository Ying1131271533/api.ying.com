<?php

namespace App\Swoole;

// use Dingo\Api\Contract\Http\Request;

use Illuminate\Http\Request;

class WebsocketHandler
{
    protected $server;
    public function __construct()
    {
        $this->server = new \Swoole\WebSocket\Server('0.0.0.0', 1215);
    }
    public function onOpen($fd, Request $request)
    {
        /**
         * 客户端建立起长链接后，返回客户端fd
         */
        $this->server->push($fd, json_encode(['event' => 'open', 'data' => ['fd' => $fd]]));
        return true;
    }
}

