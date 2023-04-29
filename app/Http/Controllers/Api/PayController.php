<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\PayRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yansongda\LaravelPay\Facades\Pay;

class PayController extends BaseController
{
    /**
     * 支付
     */
    public function pay(PayRequest $request, Order $order)
    {
        $validated = $request->validated();

        // 订单状态是否为 1
        if ($order->status != 1) {
            // $errorMsg = '订单异常';
            // switch ($order->status) {
            //     case 2:
            //         $errorMsg = '订单已支付';
            //         break;
            //     case 3:
            //         $errorMsg = '订单已发货';
            //         break;
            //     case 4:
            //         $errorMsg = '订单已收货';
            //         break;
            //     case 5:
            //         $errorMsg = '订单已过期';
            //         break;
            //     case 6:
            //         $errorMsg = '订单已退换';
            //         break;
            //     case 7:
            //         $errorMsg = '订单已退货';
            //         break;
            // }
            // return $this->response->errorBadRequest($errorMsg);
            return $this->response->errorBadRequest('订单状态异常，请重新下单！');
        }

        // 支付宝
        if ($validated['type'] == 'alipay') {
            $order = [
                'out_trade_no' => $order->order_no,
                'total_amount' => $order->amount,
                'subject'      => $order->goods()->first()->title . ' 等 ' . $order->goods()->count() . '件商品',
            ];
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

    /**
     * 支付宝支付成功之后的异步回调
     */
    public function notifyAlipay(Request $request)
    {
        $alipay = Pay::alipay();

        try {
            $data = $alipay->callback(); // 是的，验签就这么简单！

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况




            // 判断支付状态
            if ($data['trade_status'] == 'TRADE_SUCCESS' || $data['trade_status'] == 'TRADE_FINISHED') {
                // 查询订单
                $order = Order::where('order_no', $data['out_trade_no'])->first();

                // 老师说还可以验证支付的金额是否匹配
                // if($data['total_amount'] !== (string)$order['amount']) { }

                // 更新订单数据
                $order->updte([
                    'status'   => $data['total_amount'] === (string)$order['amount'] ? 2 : 10,
                    'pay_time' => $data['gmt_payment'],
                    'pay_type' => '支付宝',
                    'trade_no' => $data['trade_no'],
                ]);
            }

            // 保存支付信息记录
            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
        }

        return $alipay->success();

    }
}
