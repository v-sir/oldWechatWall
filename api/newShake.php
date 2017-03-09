<?php
/**
 * Created by HuangWei.
 * User: Administrator
 * Date: 2016/5/20
 * Time: 19:38
 */

$sql="truncate table shake";
$db_conn =new mysqli('localhost','root','','new_wechat');
if ($db_conn) {
    $db_result = $db_conn->query($sql);

}


?>