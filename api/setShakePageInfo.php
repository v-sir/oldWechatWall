<?php
/**
 * Created by HuangWei.
 * User: Administrator
 * Date: 2016/5/18
 * Time: 22:53
 */
$sql="select*from token ";
$db_conn =new mysqli('localhost','root','','card');
if ($db_conn) {
    $db_result = $db_conn->query($sql);
    $row=$db_result->fetch_assoc();
    $token=$row['token'];

}


$postdata=array(
    'page_id'=>2664331,
    'title'=>' 季忆留夏',
    'description'=>'雪花勇闯天涯',
    'page_url'=>'http://new.weixin.sky31.com/index.php?m=wechat&c=index&a=shake',
    'icon_url'=>'http://p.qpic.cn/ecc_merchant/0/w_pic_1460775397859/0'
);
$postdata=json_encode($postdata);
$url="https://api.weixin.qq.com/shakearound/page/update?access_token=$token";
$ch = curl_init();//新建curl
curl_setopt($ch, CURLOPT_URL, $url);//url
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书

curl_setopt($ch, CURLOPT_POST, 1);  //post
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);//post内容

curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$a = curl_exec($ch);
echo $a;
?>