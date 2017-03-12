<?php

/**
 *    配置账号信息
 */
class WxPayConf_pub
{
    //=======【基本信息设置】=====================================
    //微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
    //佳兆业全套
    const APPID = 'wx6a7da1d2770a17a0';
    //受理商ID，身份标识
    const MCHID = '1438028502';
    //商户支付密钥Key。审核通过后，在微信发送的邮件中查看
    const KEY = 'dongchengwangfujingbaihuo6666666';
    //JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
    const APPSECRET = '4578c042ea9361b6e16626f1aa3d7e52';

    const SUBMCHID = '';
    //异步支付结果同志url

    const  NOTIFY_URL = 'http://www.wexue.top/games/zz/wxPayApi/wx-scan-code-notify.php';
    //=======【curl超时设置】===================================
    //本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
    const CURL_TIMEOUT = 30;
}

?>