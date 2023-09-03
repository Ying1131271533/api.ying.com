<?php
namespace App\Services\Auth;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class WechatApplet
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code        = $code;
        $this->wxAppID     = config('wechat.app_id');
        $this->wxAppSecret = config('wechat.app_secret');
        $this->wxLoginUrl  = sprintf(config('wechat.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    public function get()
    {
        $result   = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);

        if (empty($wxResult)) {
            if (!$result) {
                throw new BadRequestException('获取session_key及openid时异常，微信内部错误');
            }

        } else {
            $loginFail = array_key_exists('errorcode', $wxResult);
            if ($loginFail) {
                throw new BadRequestException('登录异常');
            } else {
                return $wxResult;
            }
        }
    }
}
