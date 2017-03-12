<?php

$openid = $_GET['openid'];
$pwd = $_GET['pwd'];
if($pwd!="1620"){
    echo 0;
    exit();
}
$con = mysql_connect("123.57.237.121", "root", "lihb123456");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("games", $con);
$result = mysql_query("SELECT * FROM zz_users WHERE openid='" . $openid . "'");
$row = mysql_fetch_array($result);
if (!empty($row)) {
    mysql_query("update  zz_users  set state=1 where openid='" . $openid . "'");
}
mysql_close($con);

echo 1;

?>