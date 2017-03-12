<?php
define('LOGPATH', dirname(__FILE__));
include_once('../wxapi/mi.php');
include_once("../common/log.php");
$log_ = new Log_();
$openid=$_GET['openid'];
$timeStamp  = empty($_GET['timestamp'])     ? ""    : trim($_GET['timestamp']) ;
$nonce      = empty($_GET['nonce'])     ? ""    : trim($_GET['nonce']) ;
$msg_sign   = empty($_GET['msg_signature']) ? ""    : trim($_GET['msg_signature']) ;

$encodingAesKey = 'lihb111111111122222222223333333333444444444';
$token = 'wxhongbao';
$appId = 'wx624aefb0655790c2';
$encryptMsg = file_get_contents('php://input');
$log_->log_result("解码前:\n".$encryptMsg);
$pc = new WXBizMsgCrypt($token, $encodingAesKey, $appId);
$msg = '';
$errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $encryptMsg, $msg);
$log_->log_result("解码后:\n".$msg);
$xml = new DOMDocument();
$xml->loadXML($msg);
$array_e = $xml->getElementsByTagName('Event');
$event = $array_e->item(0)->nodeValue;

$log_->log_result("事件:".$event);
if(empty($event)||$event!="subscribe"){
    echo "";exit();
}

$con = mysql_connect("123.57.237.121", "root", "lihb123456");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db("games", $con);
$result = mysql_query("SELECT * FROM zz_hb WHERE openid='" . $openid . "'");
$row = mysql_fetch_array($result);
if (!empty($row)) {
    if($row['ishb']==0){
        mysql_query("update zz_hb set ishb=1 WHERE openid='" . $openid."'");
        $log_->log_result("openid:".$openid."人已经在,发红包");
        sendredpack($openid);
    }else{
        $log_->log_result("openid:".$openid."-----红包发过了");
    }
} else {
    mysql_query("INSERT INTO zz_hb (openid,ishb, hbprice) VALUES ('" . $openid . "',1, 100)");
    $sp=sendredpack($openid);
    $log_->log_result("openid:".$openid."人不在,发红包");
    $log_->log_result("$sp:".$sp);
}
mysql_close($con);

echo "";

// 现金红包
function sendredpack($oid){

    $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";

    $mch_billno = '0000000000' . date ( "YmdHis", time () ) . rand ( 1000, 9999 );      //商户订单号
    $mch_id = '1381605302';                         //微信支付分配的商户号
    $wxappid = 'wx4069e1635ae1be38';        //公众账号appid
    $send_name = "郑州王府井熙地港店";                          //商户名称
    $re_openid = $oid;         //用户openid
    $total_amount = "100";                              // 付款金额，单位分
    $total_num = 1;                                          //红包发放总人数
    $wishing = "开业大吉";                             //红包祝福语
    $client_ip = GetIP();                //Ip地址
    $act_name = "开业啦";                         //活动名称
    $remark = "关注送现金";                                      //备注
    $apikey = "lihongbin11111111111111111111111";   // key 商户后台设置的  微信商户平台(pay.weixin.qq.com)-->账户设置-->API安全-->密钥设置
    $nonce_str =  md5(rand());                                  //随机字符串，不长于32位
    $m_arr = array (
        'mch_billno' => $mch_billno,
        'mch_id' => $mch_id,
        'wxappid' => $wxappid,
        'send_name' => $send_name,
        're_openid' => $re_openid,
        'total_amount' => $total_amount,
        'total_num' => $total_num,
        'wishing' => $wishing,
        'client_ip' => $client_ip,
        'act_name' => $act_name,
        'remark' => $remark,
        'nonce_str'=> $nonce_str
    );
    array_filter ( $m_arr ); // 清空参数为空的数组元素
    ksort ( $m_arr ); // 按照参数名ASCII码从小到大排序

    $stringA = "";
    foreach ( $m_arr as $key => $row ) {
        $stringA .= "&" . $key . '=' . $row;
    }
    $stringA = substr ( $stringA, 1 );
    // 拼接API密钥：
    $stringSignTemp = $stringA."&key=" . $apikey;
    $sign = strtoupper ( md5 ( $stringSignTemp ) );         //签名
    $textTpl = '<xml>
                        <sign><![CDATA[%s]]></sign>
                        <mch_billno><![CDATA[%s]]></mch_billno>
                        <mch_id><![CDATA[%s]]></mch_id>
                        <wxappid><![CDATA[%s]]></wxappid>
                        <send_name><![CDATA[%s]]></send_name>
                        <re_openid><![CDATA[%s]]></re_openid>
                        <total_amount><![CDATA[%s]]></total_amount>
                        <total_num><![CDATA[%s]]></total_num>
                        <wishing><![CDATA[%s]]></wishing>
                        <client_ip><![CDATA[%s]]></client_ip>
                        <act_name><![CDATA[%s]]></act_name>
                        <remark><![CDATA[%s]]></remark>
                        <nonce_str><![CDATA[%s]]></nonce_str>
                        </xml>';
    $resultStr = sprintf($textTpl, $sign, $mch_billno, $mch_id, $wxappid, $send_name,$re_openid,$total_amount,$total_num,$wishing,$client_ip,$act_name,$remark,$nonce_str);
    return curl_post_ssl($url, $resultStr);
}
//裂变红包
function sendgroupredpack()
{
    $mch_billno = '0000000000' . date ( "YmdHis", time () ) . rand ( 1000, 9999 );      //商户订单号
    $mch_id = '0000000000';                         //微信支付分配的商户号
    $wxappid = '';        //公众账号appid
    $send_name = "";                          //商户名称
    $re_openid = "";         //用户openid
    $total_amount = "300";                              //付款金额，单位分
    $total_num = 3;                                          //红包发放总人数
    $amt_type = "ALL_RAND";                      //红包金额设置方式 ALL_RAND—全部随机,商户指定总金额和红包发放总人数，由微信支付随机计算出各红包金额
    $wishing = "恭喜发财";                             //红包祝福语
    $act_name = "关注有礼";                         //活动名称
    $remark = "测试";                                      //备注
    $apikey = "key";   // key 商户后台设置的  微信商户平台(pay.weixin.qq.com)-->账户设置-->API安全-->密钥设置
    $nonce_str =  md5(rand());                                  //随机字符串，不长于32位
    $m_arr = array (
        'mch_billno' => $mch_billno,
        'mch_id' => $mch_id,
        'wxappid' => $wxappid,
        'send_name' => $send_name,
        're_openid' => $re_openid,
        'total_amount' => $total_amount,
        'total_num' => $total_num,
        'amt_type' => $amt_type,
        'wishing' => $wishing,
        'act_name' => $act_name,
        'remark' => $remark,
        'nonce_str'=> $nonce_str
    );
    array_filter ( $m_arr ); // 清空参数为空的数组元素
    ksort ( $m_arr ); // 按照参数名ASCII码从小到大排序

    $stringA = "";
    foreach ( $m_arr as $key => $row ) {
        $stringA .= "&" . $key . '=' . $row;
    }
    $stringA = substr ( $stringA, 1 );
    // 拼接API密钥：
    $stringSignTemp = $stringA."&key=" . $apikey;
    $sign = strtoupper ( md5 ( $stringSignTemp ) );         //签名

    $textTpl = '<xml>
                        <sign><![CDATA[%s]]></sign>
                        <mch_billno><![CDATA[%s]]></mch_billno>
                        <mch_id><![CDATA[%s]]></mch_id>
                        <wxappid><![CDATA[%s]]></wxappid>
                        <send_name><![CDATA[%s]]></send_name>
                        <re_openid><![CDATA[%s]]></re_openid>
                        <total_amount><![CDATA[%s]]></total_amount>
                        <amt_type><![CDATA[%s]]></amt_type>
                        <total_num><![CDATA[%s]]></total_num>
                        <wishing><![CDATA[%s]]></wishing>
                        <act_name><![CDATA[%s]]></act_name>
                        <remark><![CDATA[%s]]></remark>
                        <nonce_str><![CDATA[%s]]></nonce_str>
                        </xml>';
    $resultStr = sprintf($textTpl, $sign, $mch_billno, $mch_id, $wxappid, $send_name,$re_openid,$total_amount,$amt_type,$total_num,$wishing,$act_name,$remark,$nonce_str);
    $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack";
    return curl_post_ssl($url, $resultStr);
}
function curl_post_ssl($url, $vars, $second=30,$aHeader=array())
{
    $ch = curl_init();
    //超时时间
    curl_setopt($ch,CURLOPT_TIMEOUT,$second);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    //这里设置代理，如果有的话
    //curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
    //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);

    //以下两种方式需选择一种

    //第一种方法，cert 与 key 分别属于两个.pem文件
    //默认格式为PEM，可以注释
    curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
    curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/apiclient_cert.pem');
    // 默认格式为PEM，可以注释
    curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
    curl_setopt($ch,CURLOPT_SSLKEY,getcwd().'/apiclient_key.pem');

    //第二种方式，两个文件合成一个.pem文件
    //curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');

    if( count($aHeader) >= 1 ){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
    }

    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
    $data = curl_exec($ch);
    if($data){
        curl_close($ch);
        return $data;
    }
    else {
        $error = curl_errno($ch);
        echo "call faild, errorCode:$error\n";
        curl_close($ch);
        return false;
    }
}
function GetIP(){
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif(!empty($_SERVER["REMOTE_ADDR"])){
        $cip = $_SERVER["REMOTE_ADDR"];
    }
    else{
        $cip = "无法获取！";
    }
    return $cip;
}
die();