<?php
define('LOGPATH', dirname(__FILE__));
include_once(dirname(__FILE__) .'/wxapi/mi.php');

//以下三个变量，自己去开放平台上管理中心根据实际情况填写。
$encodingAesKey = 'lihb111111111122222222223333333333444444444';
$token = 'wxhongbao';
$appId = 'wx624aefb0655790c2';
$timeStamp  = empty($_GET['timestamp'])     ? ""    : trim($_GET['timestamp']) ;
$nonce      = empty($_GET['nonce'])     ? ""    : trim($_GET['nonce']) ;
$msg_sign   = empty($_GET['msg_signature']) ? ""    : trim($_GET['msg_signature']) ;
$encryptMsg = file_get_contents('php://input');
$pc = new WXBizMsgCrypt($token, $encodingAesKey, $appId);

$xml_tree = new DOMDocument();
$xml_tree->loadXML($encryptMsg);
$array_e = $xml_tree->getElementsByTagName('Encrypt');
$encrypt = $array_e->item(0)->nodeValue;


$format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
$from_xml = sprintf($format, $encrypt);
logResult('/form.log', $encryptMsg);
// 第三方收到公众号平台发送的消息
$msg = '';
$errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
if ($errCode == 0) {
    //print("解密后: " . $msg . "\n");
    $xml = new DOMDocument();
    $xml->loadXML($msg);
    $array_e = $xml->getElementsByTagName('ComponentVerifyTicket');
    $component_verify_ticket = $array_e->item(0)->nodeValue;
    file_put_contents(LOGPATH.'/ticket.log', $component_verify_ticket);
//    logResult('/msgmsg.log','解密后的component_verify_ticket是：'.$component_verify_ticket);

    $con = mysql_connect("localhost", "root", "lihb123456");
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("wxcms", $con);
    mysql_query('update pigcms_weixin_account set component_verify_ticket="'.$component_verify_ticket .'" where appId="'.$appId.'"');
    mysql_close($con);
    echo 'success';

} else {
    logResult('/error.log','解密后失败：'.$errCode);
    print($errCode . "\n");
}
function logResult($path,$data){
    file_put_contents(LOGPATH.$path, '['.date('Y-m-d : h:i:sa',time()).']'.$data."\r\n",FILE_APPEND);
}
die(); 