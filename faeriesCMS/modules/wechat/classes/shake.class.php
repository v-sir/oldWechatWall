<?php
/**
 * Created by HuangWei.
 * User: Administrator
 * Date: 2016/4/16
 * Time: 12:03
 */

class shake{
    public $db_result;
    public $db_conn;
    public $sql;
    public $openid;
    public $topic;
    public $Token;
    public $db_table;
    public $msg;
    public $db_data;
    public $ticket;
    function __construct() {

        $sql="select*from token ";
        $this->db_conn =new mysqli('localhost','root','','card');
        if ($this->db_conn) {
            $this->db_result = $this->db_conn->query($sql);
            $row=$this->db_result->fetch_assoc();
            $this->Token=$row;


        }
        $this->ticket=@$_GET['ticket'];





    }
    public function getShakeUser(){
        $url = "https://api.weixin.qq.com/shakearound/user/getshakeinfo?access_token=".$this->Token['token'];
        $this->ticket;
        $post_string = array(
            'ticket'=>$this->ticket
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_string));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $a = curl_exec($ch);
        $strjson=json_decode($a);
       $this->openid=$strjson->data->openid;

        $this->is_existUserinfo();
        if ($this->db_data == ''){
           $this->save_userinfo();
        }
        $this->is_existUserinfo();


        header('location:/show/shake/index.php?openid='.$this->openid);
//

    }
    public function is_existUserinfo(){
        $this->db_conn = new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
        $this->sql="select*from shake_user where openid='$this->openid'";
        if ($this->db_conn) {
            $this->db_result = $this->db_conn->query($this->sql);

            $this->db_data= $this->db_result->fetch_assoc();

        }


    }
    public function save_userinfo(){
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->Token['token']."&openid={$this->openid}&lang=zh_CN";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $a = curl_exec($ch);
        $strjson=json_decode($a);
        $this->sql="insert into shake_user(openid,nickname,headimgurl,sex) values('$strjson->openid','$strjson->nickname','$strjson->headimgurl','$strjson->sex')";

        $this->db_conn = new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
        $this->db_conn->query("set names UTF8");
        if ($this->db_conn) {
            if($this->db_result = $this->db_conn->query($this->sql)){
                return true;
            }
            else{
                return false;
            }

        }

    }

}


?>