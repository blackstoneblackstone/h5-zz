<?php
/**
 * 通用通知接口demo
 * ====================================================
 * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，
 * 商户接收回调信息后，根据需要设定相应的处理流程。
 * wx-scan-code-notify.php
 * 这里举例使用log文件形式记录回调信息。
 * <xml>
 * <appid><![CDATA[wx4069e1635ae1be38]]></appid>
 * <attach><![CDATA[{"starttime":"20170227232734","endtime":"20170227233334"}]]></attach>
 * <bank_type><![CDATA[CFT]]></bank_type>
 * <cash_fee><![CDATA[1]]></cash_fee>
 * <fee_type><![CDATA[CNY]]></fee_type>
 * <is_subscribe><![CDATA[Y]]></is_subscribe>
 * <mch_id><![CDATA[1381605302]]></mch_id>
 * <nonce_str><![CDATA[9wus7zqwdwaw8q59pum13nhv173bdely]]></nonce_str>
 * <openid><![CDATA[oDs6gwVdlvZhV2N3RIJKereAktKY]]></openid>
 * <out_trade_no><![CDATA[201702272327346473]]></out_trade_no>
 * <result_code><![CDATA[SUCCESS]]></result_code>
 * <return_code><![CDATA[SUCCESS]]></return_code>
 * <sign><![CDATA[961178E20C6AC200FF6D8C5A091F8F1A]]></sign>
 * <time_end><![CDATA[20170227232739]]></time_end>
 * <total_fee>1</total_fee>
 * <trade_type><![CDATA[JSAPI]]></trade_type>
 * <transaction_id><![CDATA[4007132001201702271587207403]]></transaction_id>
 * </xml>
 */
include_once("../common/log.php");
include_once("WxPayPubHelper.php");

//使用通用通知接口
$notify = new Notify_pub();

//存储微信的回调
$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
$xmlDocument = new DOMDocument();
$xmlDocument->loadXML($xml);
$openidXml = $xmlDocument->getElementsByTagName('openid');
$openid = $openidXml->item(0)->nodeValue;

$transactionIdXml = $xmlDocument->getElementsByTagName('transaction_id');
$transactionId = $transactionIdXml->item(0)->nodeValue;

$cashFeeXml = $xmlDocument->getElementsByTagName('cash_fee');
$cashFee = $cashFeeXml->item(0)->nodeValue;

$timeEndXml = $xmlDocument->getElementsByTagName('time_end');
$timeEnd = $timeEndXml->item(0)->nodeValue;


$con = mysql_connect("123.57.237.121", "root", "lihb123456");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("games", $con);
mysql_query("INSERT INTO zz_transaction (openid,fee,transactionid,ctime,quanid) VALUES ('".$openid."',".$cashFee.",'".$transactionId."',".$timeEnd.",1)");
mysql_close($con);

$notify->saveData($xml);

$log_ = new Log_();

$log_->log_result("【接收到的notify通知】:\n" . $xml . "\n");

if ($notify->checkSign() == FALSE) {
    $notify->setReturnParameter("return_code", "FAIL");//返回状态码
    $notify->setReturnParameter("return_msg", "签名失败");//返回信息
} else {
    $notify->setReturnParameter("return_code", "SUCCESS");//设置返回码
    $notify->setReturnParameter("appid", "wxf1babed2c26ff04e");
    $notify->setReturnParameter("mch_id", "1247769601");
    $notify->setReturnParameter("nonce_str", "232fafwf323232323442");
    $notify->setReturnParameter("result_code", "SUCCESS");
}
$returnXml = $notify->returnXml();
echo $returnXml;
$log_->log_result("【返回信息】:\n" . $returnXml . "\n");

die;

?>