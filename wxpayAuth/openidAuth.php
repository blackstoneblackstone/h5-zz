<?php
/**
 * Created by PhpStorm.
 * User: lihb
 * Date: 1/29/16
 * Time: 4:31 PM
 * 城事汇一周年庆
 */
$callbackurl=$_GET['callbackurl'];
$extend=$_GET['extend'];
$state=base64_encode($callbackurl).";".base64_encode($extend);
header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx39616114bfa44653&redirect_uri=http%3a%2f%2fp.widalian.com%3a9001%2fauth%2fauth.php&response_type=code&scope=snsapi_base&state=".$state."&connect_redirect=1#wechat_redirect");

?>