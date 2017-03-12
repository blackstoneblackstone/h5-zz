<?php

$openid = $_GET['openid'];

$con = mysql_connect("123.57.237.121", "root", "lihb123456");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("games", $con);
$result = mysql_query("SELECT count(*) FROM zz_transaction WHERE openid='" . $openid . "'");
$row = mysql_fetch_array($result);

$result2 = mysql_query("SELECT * FROM zz_users WHERE openid='" . $openid . "'");
$row2 = mysql_fetch_array($result2);
if (!empty($row2)) {
    $s = $row2['sharenum'];
}
if ($row[0] == 0) {
    echo 0;
}
if ($row[0] == 1) {
    if($s>0){
        echo 0;
    }else{
        echo 1;
    }
}
if ($row[0] == 2) {
    echo 1;
}
if ($row[0] >2) {
    echo 1;
}


mysql_close($con);

exit();

?>