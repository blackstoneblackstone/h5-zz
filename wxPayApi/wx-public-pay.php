<?php
/**
 * JS_API支付
 * ====================================================
 * 在微信浏览器里面打开H5网页中执行JS调起支付。接口输入输出数据格式为JSON。
 * 成功调起支付需要三个步骤：
 * 步骤1：网页授权获取用户openid
 * 步骤2：使用统一支付接口，获取prepay_id
 * 步骤3：使用jsapi调起支付
 * author:lihb
 */
$openid = $_GET['openid'];
$un = $_GET['un'];
if ($openid == '' || $openid == null) {
    if ($_COOKIE['openid'] == null || $_COOKIE['openid'] == '') {
        $sourceUrl = "http://www.wexue.top/games/zz/wxPayApi/wx-public-pay.php";
        $sourceUrl = urlencode($sourceUrl);
        header("location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx6a7da1d2770a17a0&redirect_uri=http%3a%2f%2fwww.wexue.top%2fgames%2fzz%2findex.php&response_type=code&scope=snsapi_userinfo&state=" . $sourceUrl . "#wechat_redirect");
    } else {
        $openid = $_COOKIE['openid'];
        $un = $_COOKIE['un'];
    }
} else {
    setcookie('openid', $openid);
    setcookie('un', $un);
}
$surl = $_SERVER["REQUEST_URI"];
//if (strpos($surl, "&") > 0) {
//    $wxParams = curlGet("http://www.wexue.top/wfj-zz.php?url=" . urlencode('http://www.wexue.top/games/zz/wxPayApi/wx-public-pay.php?openid=' . $openid . "&un=") . urlencode($un));
//} else {
$wxParams = curlGet("http://www.wexue.top/wfj-zz.php?url=" . urlencode('http://www.wexue.top' . $_SERVER["REQUEST_URI"]));
//}
$un = base64_decode($un);
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

        curl_close($ch);

        return $info;
    }
}

$con = mysql_connect("123.57.237.121", "root", "lihb123456");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("games", $con);
$result = mysql_query("SELECT * FROM zz_users WHERE openid='" . $openid . "'");
$row = mysql_fetch_array($result);
if (empty($row)) {
    mysql_query("insert zz_users (openid,sharenum,nickname)values('" . $openid . "',0,'" . $un . "')");
}
mysql_close($con);


include_once("../common/log.php");
include_once("WxPayPubHelper.php");

//使用jsapi接口
$jsApi = new JsApi_pub();


$paytime = date("YmdHis");
$orderid = date("YmdHis", time()) . rand(1000, 9999);
$orderName = "郑州王府井熙地港店一元购";

$log_ = new Log_();
//使用统一支付接口
$unifiedOrder = new UnifiedOrder_pub();


$total_fee = 100;
$unifiedOrder->setParameter("openid", "$openid");//商品描述
$unifiedOrder->setParameter("body", "$orderName");//商品描述
//自定义订单号，此处仅作举例
$timeStamp = time();
$unifiedOrder->setParameter("out_trade_no", "$orderid");//商户订单号
$unifiedOrder->setParameter("total_fee", $total_fee);//总金额
$unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
//非必填参数，商户可根据实际情况选填
//$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
//$unifiedOrder->setParameter("device_info","XXXX");//设备号

$starttime = date("YmdHis", strtotime($paytime));
$endtime = date("YmdHis", strtotime($paytime) + 360);
$attach = array(
    "starttime" => $starttime,
    "endtime" => $endtime,
);
$attachS = json_encode($attach, JSON_UNESCAPED_UNICODE);
$unifiedOrder->setParameter("time_start", "$starttime");//交易起始时间
$unifiedOrder->setParameter("time_expire", "$endtime");//交易结束时间
$unifiedOrder->setParameter("attach", "$attachS");//附加数据
//$unifiedOrder->setParameter("sub_mch_id", "1291693801");//子商户号
//$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
$unifiedOrder->setParameter("product_id", "2323");//商品ID
$prepay_result = $unifiedOrder->getPrepayId();

$log_->log_result("【接收到的支付调用参数】:\n" . json_encode($unifiedOrder->parameters) . "\n");

$prepay_id = $prepay_result["prepay_id"];
$log_->log_result("【获取预支付订单结果】:\n" . $prepay_result['err_code_des'] . "\n prepayid:" . $prepay_id . "\n " . json_encode($prepay_result, JSON_UNESCAPED_UNICODE));
//=========步骤3：使用jsapi调起支付============
$jsApi->setPrepayId($prepay_id);
$jsApiParameters = $jsApi->getParameters();
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>郑州王府井熙地港店开业啦</title>
    <meta name="viewport" content="width=device-width,user-scalable=no"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="msapplication-tap-highlight" content="no"/>
    <meta name="viewport" content="width=750, target-densitydpi=device-dpi">
    <link href="../css/index.css?v=4" rel="stylesheet">
    <script src="../lib/jquery-2.0.3.min.js"></script>
    <script type="text/javascript">

        if (/Android (\d+\.\d+)/.test(navigator.userAgent)) {
            var version = parseFloat(RegExp.$1);
            if (version > 2.3) {
                var phoneScale = parseInt(window.screen.width) / 750;
                document.write('<meta name="viewport" content="width=750, minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi">');
            } else {
                document.write('<meta name="viewport" content="width=750, target-densitydpi=device-dpi">');
            }
        } else {
            document.write('<meta name="viewport" content="width=750, user-scalable=no, target-densitydpi=device-dpi">');
        }

        //统计分析
        var _mtac = {};
        (function () {
            var mta = document.createElement("script");
            mta.src = "http://pingjs.qq.com/h5/stats.js?v2.0.2";
            mta.setAttribute("name", "MTAH5");
            mta.setAttribute("sid", "500408319");

            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(mta, s);
        })();


        var CANVAS_HEIGHT = 1334;
        var CANVAS_WIDTH = 750;
        var CURRENT_PAGE = 1;
        var s_oMain, s_oSpriteLibrary, s_oStage;
        var ON_MOUSE_DOWN = 0;
        var ON_MOUSE_UP = 1;
        var ON_MOUSE_OVER = 2;
        var ON_MOUSE_OUT = 3;
        var ON_DRAG_START = 4;
        var ON_DRAG_END = 5;

        //        调用微信JS api 支付
        function jsApiCall() {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $jsApiParameters;?>,
                function (res) {
                    //WeixinJSBridge.log(res.err_msg);
                    if (res.err_msg == "get_brand_wcpay_request:ok") {
                        $(".p2").fadeOut();
                        $(".p3").fadeIn();
                    } else if (res.err_msg == "get_brand_wcpay_request:cancel") {
                        alert("取消支付啦");
                    } else {
                        alert(res.err_desc);
                    }
                }
            );
        }

        function callpay() {
            if (typeof WeixinJSBridge == "undefined") {
                if (document.addEventListener) {
                    //alert('WeixinJSBridgeReady');
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                } else if (document.attachEvent) {
                    //alert('onWeixinJSBridgeReady');
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            } else {
                jsApiCall();
            }
        }
    </script>
</head>
<body>
<div class="p p3" style="font-size: 40px;text-align: center;background: url(../img/p3-success.jpg)">
    <h1 style="margin-top: 50px;font-size: 100px;color: #6d2a16;">
        换购成功
    </h1>
    <img src="../img/code.jpeg" style="width: 400px;">
    <p style="font-size: 25px;">
        长按二维码关注公众号
    </p>
    <p></p>
    <p>请关注郑州王府井熙地港店公众号,</p>
    <p>点击“一元购”查看使用说明</p>
    <p>换取100元美食大礼包。</p>

    <img onclick="again()" src="../img/p3-again.png" style="margin-left: auto;margin-right: auto;">
    <p>活动时间:3月10日--3月19日</p>

</div>
<div class="p p4" style="font-size: 40px;text-align: center;background: url(../img/p3-success.jpg)">
    <h1 style="margin-top: 50px;font-size: 100px;color: #6d2a16;">
        换购失败
    </h1>
    <img src="../img/code.jpeg" style="width: 400px;">
    <p style="font-size: 25px;">
        长按二维码关注公众号
    </p>
    <p></p>
    <p>您的换购机会已经用完了,</p>
    <p>分享给好友可以重新获得一次换购机会</p>
    <p>每人最多只能换购两次哦!</p>
    <img onclick="again()" src="../img/p3-again.png" style="margin-left: auto;margin-right: auto;">
    <p>活动时间:3月10日--3月19日</p>
</div>
<div class="loading">
    <div align="center" id="loading"
         style="background-color: #ffffff;padding-top:300px;position: absolute;top:0px;left: 0px;right: 0px;bottom: 0px">
        <div class="load" style="width: 200px;height: 273px;">
            <div style="font-size: 60px;padding-top: 80px;color: red" id="shu">1%</div>
        </div>
        <div style="color: red;font-size: 35px;margin-top: 50px;">
            红包发放中...
        </div>
    </div>
    <img src="../img/logo.png" style="position: absolute;left: 300px;
        bottom: 60px;width: 150px;">
</div>
<div class="p p2">
    <img id="p2b1" src="../img/p2-top.jpg" style="position: absolute;top: 0px;left: 0px">
    <ul id="p2Scene">
        <li class="layer" data-depth="0.6">
            <canvas id="gameCanvas" width="750" height="1334" style="position: absolute;"></canvas>
        </li>
    </ul>
    <a href="http://mp.weixin.qq.com/s/ggISehPAfZECAlNIJlHGbQ">
        <img id="p2b2" src="../img/p2-hd.png" style="position: absolute;top: 0px;right: 50px">
    </a>
</div>
<div class="p p1">

    <img src="../img/p1-top.png" style="position: absolute;top: 0px;">
    <img class="yun2" src="../img/p1-yun-2.png" style="position: absolute;left: 150px;top: 100px;">
    <img class="yun1" src="../img/p1-yun-1.png" style="position: absolute;left: 0px;top: 100px;">
    <img class="ta" src="../img/p1-ta-1.png" style="position: absolute;left: -150px;top: 100px;">
    <img class="ta" src="../img/p1-ta-2.png" style="position: absolute;left: 250px;top: 100px;">
    <img class="yun3" src="../img/p1-yun-3.png" style="position: absolute;left: 250px;top: 100px;">

    <ul id="p1Scene">
        <li class="layer" data-depth="0.60">
            <img src="../img/p1-mid.png" style="position: absolute;left: -240px;bottom: -100px;">
        </li>
        <li class="layer" data-depth="0.60">
            <img class="dl" src="../img/p1-door-l.png" style="position: absolute;left: -10px;bottom: 50px;">
        </li>
        <li class="layer" data-depth="0.60">
            <img class="dr" src="../img/p1-door-r.png" style="position: absolute;left: 375px;bottom: 50px;">
        </li>
        <li class="layer" data-depth="1">
            <img src="../img/p1-text.png" style="position: absolute;top: 150px;left: 80px">
        </li>
    </ul>
    <img class="floor-top" src="../img/p1-floor.png" style="top: -240px;position: absolute;left: -100px;">
    <img class="floor-bottom" src="../img/p1-floor.png" style="bottom: -220px;position: absolute;left: -100px;">

    <img id="open" class="hand" src="../img/hand.png" style="position: absolute;bottom: 100px;left: 340px">
</div>


<div id="f" style="display: none;height: 100%;width: 100%;overflow: hidden;position: absolute">
    <img class="f f1" src="../img/p1-f.png" style="position: absolute;left: -760px;
        top: -750px;">
    <img class="f f2" src="../img/p1-f.png" style="position: absolute; left: 750px;
        top: -750px;">
    <img class="f f3" src="../img/p1-f.png" style="position: absolute; left: -760px;
        top: 1330px;">
    <img class="f f4" src="../img/p1-f.png" style="position: absolute;left: 760px;
        top: 1330px;">
</div>


<script src="../lib/jweixin-1.0.0.js"></script>
<script>
    wx.config(
        <?php echo $wxParams;?>
    );
    wx.ready(function () {
        wx.onMenuShareTimeline({
            title: '1元换100元大礼包？！郑州新开业的王府井抢购大福利', // 分享标题
            link: 'http://www.wexue.top/games/zz/wxPayApi/wx-public-pay.php', // 分享链接
            imgUrl: 'http://www.wexue.top/games/zz/img/rank-bg.png', // 分享图标
            success: function () {
                $.get("shareAdd.php?openid=<?php echo $openid?>");
            },
            cancel: function () {
            }
        });
        wx.onMenuShareAppMessage({
            title: '1元换100元大礼包？！郑州新开业的王府井抢购大福利', // 分享标题
            desc: '王府井首家新中式商场3.16火爆开业，1元超值抢购仅有5000份，每人仅限购买1次哟', // 分享描述
            link: "http://www.wexue.top/games/zz/wxPayApi/wx-public-pay.php", // 分享链接
            imgUrl: 'http://www.wexue.top/games/zz/img/rank-bg.png', // 分享图标
            type: 'link', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                $.get("shareAdd.php?openid=<?php echo $openid?>");
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
    });

    function again() {
        window.location.reload();
    }
    function huagou() {
        $.ajax({
            url: "huangounum.php",
            type: 'get',
            data: {openid: "<?php echo $openid;?>"},
            success: function (data) {
                if (data == 0) {
                    callpay();
                } else {
                    $(".p").fadeOut();
                    $(".p4").fadeIn();
                }
            }
        })
    }

</script>

<script src="../lib/jquery.parallax.js"></script>
<script src="../lib/touch.min.js"></script>
<script src="../lib/createjs-2014.12.12.min.js"></script>
<script src="../js/Ctl_utils.js"></script>
<script src="../js/CGfxButton.js"></script>
<script src="../js/CSpriteLibrary.js"></script>
<script src="../js/CPreloader.js"></script>
<script src="../js/CPage1.js?v=3"></script>
<script src="../js/CPage2.js?v=3"></script>
<script src="../js/CPage3.js"></script>
<script src="../js/CPage4.js"></script>
<script src="../js/CMain.js?v=3"></script>
<script>
    $(function () {
        s_oMain = new CMain();
    })
</script>
</body>
</html>