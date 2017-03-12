<?php
/**
 * Created by PhpStorm.
 * User: lihb
 * Date: 2/29/16
 * 微信服务商支付
 * Time: 4:31 PM
 */

$code = $_GET['code'];
$state = $_GET['state'];
$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx39616114bfa44653&secret=aa2ecb518bd2d5cce3b9774de7c5f920&code=' . $code . '&grant_type=authorization_code';
$result = null;
try {
    $result = curlGet($url);
} catch (Exception $e) {
    echo $e->getTraceAsString();

    return;
}
$obj = json_decode($result);

$openid=$obj->openid;


function curlGet($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $info = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Errno' . curl_error($ch);
    } else {
       // echo 'success!!!';
    }

    curl_close($ch);

    return $info;
}
$backUrl=base64_decode(split(";", $state)[0]);
$extend=base64_decode(split(";", $state)[1]);
if(!empty($openid)){
   header("Location: ".$backUrl."?openid=".$openid."&extend=".urlencode($extend));
}else{
   echo "无法获取openid";
}
?>
