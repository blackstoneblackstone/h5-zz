<?php

$openid = $_GET['openid'];
$un = $_GET['un'];
if ($openid == '' || $openid == null) {
    if ($_COOKIE['openid'] == null || $_COOKIE['openid'] == '') {
        $sourceUrl = "http://www.wexue.top/games/zz/rank.php";
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
//    $wxParams = curlGet("http://www.wexue.top/wfj-zz.php?url=" . urlencode('http://www.wexue.top/games/zz/rank.php?openid=' . $openid . "&un=") . urlencode($un));
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
$result = mysql_query("SELECT count(*) FROM zz_transaction WHERE openid='" . $openid . "'");
$row = mysql_fetch_array($result);

$user = mysql_query("SELECT * FROM zz_users WHERE openid='" . $openid . "'");
$userr = mysql_fetch_array($user);
if (!empty($userr)) {
    $state = $userr['state'];
}
mysql_close($con);

?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>郑州王府井熙地港店开业啦</title>
    <meta name="viewport" content="width=device-width,user-scalable=no"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="msapplication-tap-highlight" content="no"/>
    <meta name="viewport" content="width=750, target-densitydpi=device-dpi">
    <link href="css/weui.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'hx';
            src: url('css/hx.eot');
            src: url('css/hx.eot?#font-spider') format('embedded-opentype'),
            url('css/hx.woff') format('woff'),
            url('css/hx.ttf') format('truetype'),
            url('css/hx.svg') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #bdb4ab;
            font-family: 'hx';
        }
    </style>
    <script src="lib/jquery-2.0.3.min.js"></script>
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


    </script>
</head>
<body style="background: url(img/p3-success.jpg);text-align: center;">
<?php if ($row[0] != 0) {
    ?>
    <div style="text-align: center;font-size: 30px;color: #bc1a20;margin-top: 100px">
        <img src="img/rank-bg.png">
        <p style="color: #000000"><?php echo $un; ?>,您已经购买了<span
                style="color: #bc1a20;font-size: 100px;"><?php echo $row[0]; ?></span>张一元换购券,</p>
        <p style="color: #000000">请在活动期间,</p>
        <p style="color: #000000"> 凭此页面到郑州王府井熙地港店三楼会员中心</p>
        <p style="color: #000000"> 领取纸质券大礼包</p>
    </div>
    <img src="img/rank-play.png" onclick="play()" style="width: 45%">
    <?php if ($state == 0) {
        ?>
        <img src="img/rank-dh.png" onclick="dh()" style="width: 45%">
    <?php } ?>
    <?php if ($state != 0) {
        ?>
        <img src="img/rank-dh-h.png" style="width: 45%">
    <?php } ?>
<?php } else { ?>
    <div style="text-align: center;font-size: 30px;color: #bc1a20;margin-top: 100px">
        <img src="img/rank-bg.png">
        <p style="color: #000000;margin-top: 100px;margin-bottom: 100px"><?php echo $un; ?>,您还没有参加有活动.</p>
        <img src="img/rank-play.png" onclick="play()">
    </div>
<?php } ?>
<div style="text-align: center;font-size: 30px;color: #bc1a20;margin-top: 50px">
    <p>活动时间:3月10日--3月19日</p>
    <p>兑换时间:3月16日--3月19日</p>
    <p>本活动最终解释权归王府井百货所有</p>
</div>
<div class="js_dialog" id="androidDialog1" style="opacity: 1;display: none">
    <div class="weui-mask"></div>
    <div class="weui-dialog weui-skin_android">
        <div class="weui-dialog__hd"><strong class="weui-dialog__title">输入兑奖密码</strong></div>
        <div class="weui-dialog__bd">
            <input type="tel" class="weui-input" id="pwd"
                   style="height: 60px;border: solid #cccccc 1px;font-size: 30px">
        </div>
        <div class="weui-dialog__ft">
            <a href="javascript:;" id="cancel" class="weui-dialog__btn weui-dialog__btn_default">取消</a>
            <a href="javascript:;" id="confirm" class="weui-dialog__btn weui-dialog__btn_primary">确认</a>
        </div>
    </div>
</div>
<div id="toast" style="display: none;">
    <div class="weui-mask_transparent"></div>
    <div class="weui-toast">
        <i class="weui-icon-success-no-circle weui-icon_toast"></i>
        <p class="weui-toast__content">已完成</p>
    </div>
</div>
<img src="img/logo.png" style="width: 150px;margin: 100px auto 0px auto">
<script type="text/javascript" src="lib/weui.min.js"></script>
<script src="lib/jweixin-1.0.0.js"></script>
<script>
    function toast(text) {
        $(".weui-toast__content").text(text);
        var $toast = $('#toast');
        if ($toast.css('display') != 'none') return;
        $toast.fadeIn(100);
        setTimeout(function () {
            $toast.fadeOut(100);
        }, 2000);
    }
    function play() {
        window.location.href = "http://www.wexue.top/games/zz/wxPayApi/wx-public-pay.php";
    }
    function dh() {
        $("#androidDialog1").fadeIn(200);
    }
    $("#cancel").click(function () {
        $("#androidDialog1").fadeOut(200);
    });
    $("#confirm").click(function () {
        var pwd = $("#pwd").val();
        $.ajax({
            url: "wxPayApi/hexiao.php",
            type: 'get',
            data: {pwd: pwd, openid: "<?php echo $openid;?>"},
            success: function (data) {
                if (data == 0) {
                    toast("密码错误");
                } else {
                    window.location.reload();
                }
            }
        })
    });
    wx.config(
        <?php echo $wxParams;?>
    );
    wx.ready(function () {
        wx.onMenuShareTimeline({
            title: '1元换100元大礼包？！郑州新开业的王府井抢购大福利', // 分享标题
            link: 'http://www.wexue.top/games/zz/wxPayApi/wx-public-pay.php', // 分享链接
            imgUrl: 'http://www.wexue.top/games/zz/img/rank-bg.png', // 分享图标
            success: function () {
                //                MtaH5.clickStat('timelineshare');
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
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
    });

</script>
</body>
</html>