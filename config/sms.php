<?php

return [
    // HTTP 请求的超时时间（秒）
    'timeout'  => 5.0,

    // 默认发送配置
    'default'  => [
        // 网关调用策略，默认：顺序调用
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        // 默认可用的发送网关
        'gateways' => [
            'aliyun',
        ],
    ],
    // 可用的网关配置
    'gateways' => [
        'errorlog' => [
            // 'file' => '/tmp/easy-sms.log',
            'file' => '/var/www/api.ying.com/storage/logs/easy-sms.log',
        ],
        'aliyun'   => [
            'access_key_id'     => env('SMS_ACCESS_KEY'),
            'access_key_secret' => env('SMS_SECRET_KEY'),
            'sign_name'         => '神织知更',
        ],
    ],
    // 短信模版
    'template' => [
        'ordinary' => 'SMS_276351177'
    ],
];
