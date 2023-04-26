<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\PayRequest;
use App\Models\Order;
use Yansongda\LaravelPay\Facades\Pay;

class PayController extends BaseController
{
    /**
     * 支付
     */
    public function pay(PayRequest $request, Order $order)
    {
        $validated = $request->validated();

        // 支付宝
        if ($validated['type'] == 'aliyun') {
            $order = [
                'out_trade_no' => $order->order_no,
                'total_amount' => $order->amount,
                'subject'      => $order->goods()->first()->title . ' 等 ' . $order->goods()->count() . '件商品',
            ];
            return $order;
            // 电脑支付
            // return Pay::alipay()->web($order);
            // 扫码支付
            return Pay::alipay()->scan($order);
        }

        // 微信
        if ($validated['type'] == 'wechat') {
            $order = [
                'out_trade_no' => time(),
                'body'         => 'subject-测试',
                'total_fee'    => '1',
                'openid'       => 'onkVf1FjWS5SBIixxxxxxxxx',
            ];

            $result = Pay::wechat()->mp($order);
        }
    }
}
