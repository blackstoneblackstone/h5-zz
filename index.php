<?php
//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx4069e1635ae1be38&redirect_uri=http%3a%2f%2fwww.wexue.top%2fwxAuth.php&response_type=code&scope=snsapi_base&state=http%3a%2f%2fwww.wexue.top%3a20000%2fhuaxue%2findex.html#wechat_redirect
header("Content-type: text/html; charset=utf-8");
$openid = '';
$code = $_GET['code'];
$state = $_GET['state'];
$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx6a7da1d2770a17a0&secret=ee04d6255fd45e366a0650411e1c6839&code=' . $code . '&grant_type=authorization_code';
$user = null;

try {
    $result = curlGet($url);

    $obj = json_decode($result);

    $openid = $obj->openid;
    $at=$obj->access_token;
    $userInfo=curlGet("https://api.weixin.qq.com/sns/userinfo?access_token=".$at."&openid=".$openid."&lang=zh_CN");
    $user = json_decode($userInfo);
} catch (Exception $e) {
    echo $e->getTraceAsString();
}

function curlGet($url, $method = 'get', $data = '')
{
    $ch = curl_init();
    $header = "Accept-Charset: utf-8";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $temp = curl_exec($ch);
    return $temp;
}
$surl=urldecode($state);
if(strpos($surl,"&")>0){
    header("Location:" . $surl . "&openid=" . $openid."&un=".urlencode(base64_encode($user->nickname)));
}else{
    header("Location:" .$surl. "?openid=" . $openid."&un=".urlencode(base64_encode($user->nickname)));
}
?>