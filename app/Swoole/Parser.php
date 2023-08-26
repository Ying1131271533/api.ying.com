<?php

namespace App\Swoole;

// use Dingo\Api\Contract\Http\Request;

use Illuminate\Http\Request;

class Parser
{
    public function encode(string $event, $data)
    {
        $string = ['event' => $event, 'data' => $data];
        return json_encode($string);
    }

public function decode($frame)
    {
        //这里是解析客户端发来的数据，我们约定所有的传输都是json
        $json = $frame->data;
        $data = json_decode($json, true);
        if (!$data || !isset($data['event'])) {
            return ['event' => 'error', 'data' => $frame->data];
        }
        return ['event' => $data['event'], 'data' => $data['data'] ?? ''];
    }
}

