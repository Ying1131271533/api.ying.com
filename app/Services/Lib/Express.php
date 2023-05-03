<?php
namespace App\Services\Lib;

use Illuminate\Support\Facades\Http;

class Express
{
    // 商户ID
    protected $EBusinessID;
    // Api Key
    protected $ApiKey;
    // 查询类型
    protected $type;
    // 模式
    protected $mode;

    public function __construct()
    {
        $config            = config('express');
        $this->EBusinessID = $config['EBusinessID'];
        $this->ApiKey      = $config['ApiKey'];
        $this->type        = 'track';
        $this->mode        = $config['mode'] ?? 'product';
    }

    /**
     * 即时物流轨迹
     */
    public function track($ShipperCode, $LogisticCode)
    {
        // 准备请求参数
        $requestData = "{" .
            "'CustomerName': ''," .
            "'OrderCode': ''," .
            "'ShipperCode': '{$ShipperCode}'," .
            "'LogisticCode': '{$LogisticCode}'," .
            "}";

        // 签名
        $datas['DataSign'] = $this->encrypt($requestData);

        // 发送请求
        $response   = Http::asForm()->post(
            $this->url(),
            $this->formatRequestData($requestData, '1002')
        );

        // 返回数据
        return $this->formatResponseData($response);
    }

    // 格式化请求参数
    protected function formatRequestData($requestData, $RequestType) {
        // 组装系统级参数
        $datas = array(
            'EBusinessID' => $this->EBusinessID,
            'RequestType' => $RequestType, // 免费即时查询接口指令1002/在途监控即时查询接口指令8001/地图版即时查询接口指令8003
            'RequestData' => urlencode($requestData),
            'DataType'    => '2',
        );
        return $datas;
    }

    // 格式化响应参数
    protected function formatResponseData ($response) {
        if($response['Success'] == false) {
            return $response;
        }
        return json_decode($response['ResponseData'], true);
    }

    /**
     * 返回Api url
     */
    protected function url()
    {
        $url = [
            'track' => [
                'product' => 'https://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx',
                'dev'     => 'http://wwe.kdniao.com/UserCenter/v2/SandBox/SandboxHandler.ashx?action=CommonExcuteInterface',
            ],
        ];
        return $url[$this->type][$this->mode];
    }

    /**
     * 设置url 类型
     */
    protected function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * 电商Sign签名生成
     */
    protected function encrypt($data)
    {
        return urlencode(base64_encode(md5($data . $this->ApiKey)));
    }
}
