<?php

declare (strict_types = 1);

use Yansongda\Pay\Pay;

return [
    'alipay' => [
        'default' => [
            // 必填-支付宝分配的 app_id
            'app_id'                  => env('ALIPAY_APP_ID'),
            // 必填-应用私钥 字符串或路径
            'app_secret_cert'         => env('ALIPAY_APP_SECRET'),
            // 必填-应用公钥证书 路径
            'app_public_cert_path'    => env('ALIPAY_APP_PUBLIC_CERT_PATH'),
            // 必填-支付宝公钥证书 路径
            'alipay_public_cert_path' => env('ALIPAY_PUBLIC_CERT_PATH'),
            // 必填-支付宝根证书 路径
            'alipay_root_cert_path'   => env('ALIPAY_ROOT_CERT_PATH'),
            // 同步通知地址 支付成功后跳到我们项目的哪个地址 老师没用这个
            'return_url'              => '',
            // 异步通知地址 支付宝请求我们项目的api，告诉我们支付成功
            'notify_url'              => 'https://d51f-116-21-93-56.ngrok-free.app/api/pay/notify/aliyun',
            // 选填-服务商模式下的服务商 id，当 mode 为 Pay::MODE_SERVICE 时使用该参数
            'service_provider_id'     => '',
            // 可选为：正常 MODE_NORMAL 沙箱 MODE_SANDBOX 商务 MODE_SERVICE
            'mode'                    => Pay::MODE_SANDBOX,
        ],
    ],
    'wechat' => [
        'default' => [
            // 必填-商户号，服务商模式下为服务商商户号
            'mch_id'                  => env('WECHAT_MCH_ID'),
            // 必填-商户秘钥
            'mch_secret_key'          => env('WECHAT_MCH_SECRET_KEY'),
            // 必填-商户私钥 字符串或路径
            'mch_secret_cert'         => env('WECHAT_MCH_SECRET_CERT'),
            // 必填-商户公钥证书路径
            'mch_public_cert_path'    => env('WECHAT_MCH_PUBLIC_CERT_PATH'),
            // 必填-异步通知
            'notify_url'              => 'https://d51f-116-21-93-56.ngrok-free.app/api/pay/notify/wechat',
            // 选填-公众号 的 app_id
            'mp_app_id'               => '',
            // 选填-小程序 的 app_id
            'mini_app_id'             => '',
            // 选填-app 的 app_id
            'app_id'                  => '',
            // 选填-合单 app_id
            'combine_app_id'          => '',
            // 选填-合单商户号
            'combine_mch_id'          => '',
            // 选填-服务商模式下，子公众号 的 app_id
            'sub_mp_app_id'           => '',
            // 选填-服务商模式下，子 app 的 app_id
            'sub_app_id'              => '',
            // 选填-服务商模式下，子小程序 的 app_id
            'sub_mini_app_id'         => '',
            // 选填-服务商模式下，子商户id
            'sub_mch_id'              => '',
            // 选填-微信公钥证书路径, optional，强烈建议 php-fpm 模式下配置此参数
            'wechat_public_cert_path' => [
                '45F59D4DABF31918AFCEC556D5D2C6E376675D57' => env('WECHAT_PUBLIC_CERT_PATH'),
            ],
            // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SERVICE
            'mode' => Pay::MODE_NORMAL,
        ],
    ],
    'unipay' => [
        'default' => [
            // 必填-商户号
            'mch_id'                  => '',
            // 必填-商户公私钥
            'mch_cert_path'           => '',
            // 必填-商户公私钥密码
            'mch_cert_password'       => '000000',
            // 必填-银联公钥证书路径
            'unipay_public_cert_path' => '',
            // 必填
            'return_url'              => '',
            // 必填
            'notify_url'              => '',
        ],
    ],
    'http'   => [ // optional
        'timeout'         => 5.0,
        'connect_timeout' => 5.0,
        // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
    ],
    // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
    'logger' => [
        'enable' => false,
        'file'   => null,
        'level'  => 'debug',
        'type'   => 'single', // optional, 可选 daily.
        'max_file' => 30,
    ],
];
