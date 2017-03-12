<?php

$openid=$_GET['openid'];
$con = mysql_connect("123.57.237.121", "root", "lihb123456");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("games", $con);
$result = mysql_query("SELECT * FROM zz_users WHERE openid='" . $openid . "'");
$row = mysql_fetch_array($result);
if (!empty($row)) {
    $s=$row['sharenum']+1;
    mysql_query("update  zz_users  set sharenum=".$s." where openid='" . $openid . "'");
}
    mysql_close($con);

echo "success"

?>