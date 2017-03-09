<?php
/**
 * Created by HuangWei.
 * User: Administrator
 * Date: 2016/3/30
 * Time: 16:32
 */


defined('IN_faeriesCMS') or exit('No permission resources.');
define("TOKEN", "nicaiheheda");
define("APPID","wxc5d217408956f8ea");//SKY31
define("SECRET","143ac50a4abb8a47c9ac8f330fc1972a");//SKY31
class wechat {
    public $db_result;
    public $db_conn;
    public $sql;
    public $openid;
    public $topic;
    public $Token;
    public $db_table;
    public $msg;
    public $db_data;


    function __construct() {
        $topic=faeriesCMS_base::load_app_class('walltopic','wechat',1);
        $Token=faeriesCMS_base::load_app_class('getToken','wechat',1);
        $this->topic=$topic->get_topic();
        $this->Token=$Token->get_Token();





    }
    public function init() {
        $echoStr = $_GET["echostr"];

        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }


    }


    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)){
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $MsgType = trim($postObj->MsgType);

            switch($MsgType){

                case 'event':
                    //接收事件推送
                    $this->responseEvent($postObj);
                    break;
                case 'text':
                    //接收文本消息
                    $this->responseText($postObj);
                    break;
                case 'images':
                    //接收图片消息
                    echo $this->responseImage($postObj);
                    break;
                case 'location':
                    //接收地理位置消息
                    echo $this->responseLocation($postObj);
                    break;
                case 'voice':
                    //接收语音消息
                    echo $this->responseVoice($postObj);
                    break;
                case 'video':
                    //接收视频消息
                    echo $this->responseVideo($postObj);
                    break;
                case  'link':
                    //接收链接消息
                    echo $this->responseLink($postObj);
                    break;

                default:
                    $resultStr = "Unknow message type: " . $MsgType;
                    break;
            }



            echo $resultStr;




        }else {
            echo "";
            exit;
        }
    }
    public function responseEvent($postObj){
        $fromUsername = $postObj->FromUserName;
        $this->openid=$fromUsername;
        $toUsername = $postObj->ToUserName;
        $uuid='FDA50693-A4E2-4FB1-AFCF-C6EB07647825';
        $major='10055';
        $minor='52097';
        $Distance=$postObj->Distance;

        $eventTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[event]]></MsgType>
                            <Event><![CDATA[ShakearoundUserShake]]></Event>
                                <ChosenBeacon>
                                    <Uuid><![CDATA[%s]]></Uuid>
                                    <Major>%s</Major>
                                    <Minor>%s</Minor>
                                    <Distance>%s</Distance>
                                </ChosenBeacon>
                                <AroundBeacons>
                                    <AroundBeacon>
                                        <Uuid><![CDATA[%s]]></Uuid>
                                        <Major>%s</Major>
                                        <Minor>%s</Minor>
                                        <Distance>%s</Distance>
                                    </AroundBeacon>
                                </AroundBeacons>

							</xml>";
       // $resultStr = sprintf($eventTpl, $fromUsername, $toUsername, time(), $uuid, $major,$minor,$Distance,$uuid, $major,$minor,$Distance);
       // echo $resultStr;
        $time=time();
        $this->db_conn = new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
        $this->db_conn->query("set names UTF8");
        $this->sql = "insert into shake(create_at,openid,distance) values('$time','$this->openid','$Distance')";
        $this->db_result = $this->db_conn->query($this->sql);




    }
    public  function responseText($postObj){
        $fromUsername = $postObj->FromUserName;
        $this->openid=$fromUsername;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        //$keyword ="#测试#哈啊啊啊";
        $msgType="text";

        $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";



        $total=count($this->topic) ;
         if($contentStr=="") {
            $this->is_existUserinfo();
            if ($this->db_data == '')
                    $this->save_userinfo();
                    for($num=0;$num<$total;$num++){
                        $topic=$this->topic["$num"]['topic'];
                        $tp_id=$this->topic["$num"]['tp_id'];
                        $topic="#$topic#";
                        $topic2="#$topic#";
                        //$topic='#测试#';

                         if(substr_count($keyword,$topic) ||substr_count($keyword,$topic2)){
                                $this->msg=$keyword;
                             $time=time();
                             $this->db_conn = new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
                             $this->db_conn->query("set names UTF8");
                             $this->sql = "insert into message(msg,tp_id,msg_type,create_at,openid) values('$this->msg','$tp_id',0,'$time','$this->openid')";
                             if($this->db_result = $this->db_conn->query($this->sql))

                                  $contentStr = true;


                            }
                   }

         }
        if($contentStr)
            $contentStr= "发送信息成功！成功上墙还有机会获奖！";
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
        echo $resultStr;











    }
    public function responseImage($postObj){
        $mediaID = trim($postObj->MediaId);
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$this->Token['token']."&media_id=$mediaID";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        $fileInfo = array_merge(array('header' => $httpinfo), array('body' => $package));
        $filecontent=$fileInfo["body"];
        $filename=$mediaID.".jpg";
        $dir=dirname(__FILE__)."/images/";
        if(!is_dir($dir)){
            mkdir($dir,0777);
        }
        $local_file = fopen($dir=dirname(__FILE__)."/images/".$filename, 'w'                                                                                        );
        if (false !== $local_file){
            if (false !== fwrite($local_file, $filecontent)) {
                fclose($local_file);
            }
        }
        $fromUsername = $postObj->FromUserName;
        $this->openid=$fromUsername;
        $toUsername = $postObj->ToUserName;
        $msgType="text";
        $imageUrl="http://new.weixin.sky31.com/faeriesCMS/modules/wechat/images/".$filename;

        $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";


                    $time=time();
                    $this->db_conn = new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
                    $this->db_conn->query("set names UTF8");
                    $this->sql = "insert into image(create_at,openid,imageUrl) values('$time','$this->openid')";
                    if($this->db_result = $this->db_conn->query($this->sql))

                        $contentStr = true;






        if($contentStr)
            $contentStr= "宝宝收到你的图片辣！";
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
        echo $resultStr;





    }
    public function is_existUserinfo(){
        $this->db_conn = new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
        $this->sql="select*from user where openid='$this->openid'";
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
        $this->sql="insert into user(openid,nickname,headimgurl,sex,display) values('$strjson->openid','$strjson->nickname','$strjson->headimgurl','$strjson->sex','F')";

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

    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

}
?>