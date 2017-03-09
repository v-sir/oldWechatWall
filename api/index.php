<?php
/**
 * Created by HuangWei.
 * User: Administrator
 * Date: 2016/4/5
 * Time: 21:50
 *
 **/
header("Access-Control-Allow-Origin:*");
include "biaoqing.php";

class index {
    public $action;
    public $tp_id;
    public $limit;
    public $start;
    public function __construct() {
        $this->action=@$_GET['action'];
        $this->tp_id=@$_GET['tp_id'];
        $this->limit=@$_GET['limit'];
        $this->start=@$_GET['start'];
        if(empty($this->action) ){
            $data=array(
                'code'=>'-1',
                'msg'=>'error:Missing Parameters!'
            );
            echo json_encode($data);

        }
        else{
            if(isset($this->action) && $this->action=='getWallInfo'){
                $this->getWallInfo();

            }
            else if(isset($this->action) && $this->action=='setAwardInfo'){
                $this->setAwardInfo();

            }
            else if(isset($this->action) && $this->action=='addShakeInfo'){
                $this->addShakeInfo();

            }
            else if(isset($this->action) && $this->action=='showShakeInfo'){
                $this->showShakeInfo();

            }

        }



    }
    public function showShakeInfo(){
        $time=time()-60;
        $sql="select* from shake_user left join  shake on shake_user.openid=shake.openid where shake.updatetime>$time order by shake.allshake  desc" ;
        $db_conn=new mysqli('localhost','root','','new_wechat');
        if ($db_conn->connect_error) {
            $data=array(
                'code'=>1,
                'msg'=>'error:Database connection failed!'

            );
            echo json_encode($data);


        }


        $db_conn->query("set names UTF8");
        $db_result = $db_conn->query($sql);
        while($row=$db_result->fetch_assoc()){

            $data[]=$row;
        }
        $data=array(
            'code'=>0,
            'msg'=>'OK!',
            'data'=>$data

        );
        $tmpStr = json_encode($data);
        echo get_emoji($tmpStr,true);


    }
    public function addShakeInfo(){
        $openid=@$_GET['openid'];
        $fastestaver=@$_GET['fastestaver'];
        $avershake=@$_GET['avershake'];
        $allshake=@$_GET['allshake'];
        if( empty($openid)){
            $data=array(
                'code'=>'-1',
                'msg'=>'error:Missing Parameters!'
            );
            echo json_encode($data);

        }
        else{
            $time=time();
            $sql="select* from  shake where openid='$openid'";
            $db_conn=new mysqli('localhost','root','','new_wechat');
            if ($db_conn->connect_error) {
                $data=array(
                    'code'=>1,
                    'msg'=>'error:Database connection failed!'

                );
                echo json_encode($data);


            }

            $db_result = $db_conn->query($sql);
            $row=$db_result->fetch_assoc();
            if(isset($row) ){
                $sql="update shake set fastestaver='$fastestaver' ,avershake='$avershake' ,allshake='$allshake' ,updatetime='$time' where openid='$openid'";

                $db_conn=new mysqli('localhost','root','','new_wechat');
                if ($db_conn->connect_error) {
                    $data=array(
                        'code'=>1,
                        'msg'=>'error:Database connection failed!'

                    );
                    echo json_encode($data);


                }
                $db_conn->query("set names UTF8");
                $db_result = $db_conn->query($sql);

                if( $db_result){
                    $data=array(
                        'code'=>0,
                        'msg'=>'OK!'

                    );
                    echo json_encode($data);

                }

            }
            else{
                $sql="insert into shake(openid,fastestaver,avershake,allshake,updatetime) values('$openid','$fastestaver','$avershake','$allshake','$time')";
                $db_conn=new mysqli('localhost','root','','new_wechat');
                if ($db_conn->connect_error) {
                    $data=array(
                        'code'=>1,
                        'msg'=>'error:Database connection failed!'

                    );
                    echo json_encode($data);


                }
                $db_conn->query("set names UTF8");
                $db_result = $db_conn->query($sql);

                if( $db_result){
                    $data=array(
                        'code'=>0,
                        'msg'=>'OK!'

                    );
                    echo json_encode($data);

                }


            }


        }



    }
   
    public function getWallInfo(){
        $sql="select * from topic where tp_id='$this->tp_id'";
        $db_conn=new mysqli('localhost','root','','new_wechat');
        if ($db_conn->connect_error) {
            $data=array(
                'code'=>1,
                'msg'=>'error:Database connection failed!'

            );
            echo json_encode($data);


        }
        $db_conn->query("set names UTF8");
        $db_result = $db_conn->query($sql);
        $row=$db_result->fetch_assoc();
        if(isset($row) && $row['status']==1){
            if(isset($this->limit)){
                $sql="select * from user left join message on user.openid=message.openid where message.display=1 &&  message.tp_id='$this->tp_id' limit $this->limit";

            }
            else{
                $sql="select * from user left join message on user.openid=message.openid where message.display=1 &&  message.tp_id='$this->tp_id'";
            }

            $db_conn=new mysqli('localhost','root','','new_wechat');
            if ($db_conn->connect_error) {
                $data=array(
                    'code'=>1,
                    'msg'=>'error:Database connection failed!'

                );
                echo json_encode($data);


            }
            $db_conn->query("set names UTF8");
            $db_result = $db_conn->query($sql);
            while($row=$db_result->fetch_assoc()){
                //$row['msg']=get_emoji($row['msg']);
                $row['msg']=biaoqing($row['msg']);
                $row['msg']=get_qqface($row['msg']);
                $data[]=$row;
            }
            $data=array(
                'code'=>0,
                'msg'=>'OK!',
                'total'=>count($data),
                'data'=>$data

            );
            $tmpStr = json_encode($data);
            echo get_emoji($tmpStr,true);
            // print_r($data);


        }
        else{
            $data=array(
                'code'=>"-1",
                'msg'=>'error:this topic is over!',

            );
            echo json_encode($data);
        }

    }

    public function getAwardInfo(){

    }
    public function getTopicInfo(){
        $sql="select * from topic where tp_id='$this->tp_id'";
        $db_conn=new mysqli('localhost','root','','new_wechat');
        if ($db_conn->connect_error) {
            $data=array(
                'code'=>1,
                'msg'=>'error:Database connection failed!'

            );
            echo json_encode($data);


        }
        $db_conn->query("set names UTF8");
        $db_result = $db_conn->query($sql);
        $row=$db_result->fetch_assoc();
        if(isset($row) && $row['status']==1){


            while($row=$db_result->fetch_assoc()){
                
                $data[]=$row;
            }
            $data=array(
                'code'=>0,
                'msg'=>'OK!',
                'total'=>count($data),
                'data'=>$data

            );
            echo json_encode($data);
            // print_r($data);


        }
        else{
            $data=array(
                'code'=>"-1",
                'msg'=>'error:this topic is over!',

            );
            echo json_encode($data);
        }


    }
    public function setAwardinfo(){
        $sql="select * from topic where tp_id='$this->tp_id'";
        $db_conn=new mysqli('localhost','root','','new_wechat');
        if ($db_conn->connect_error) {
            $data=array(
                'code'=>1,
                'msg'=>'error:Database connection failed!'

            );
            echo json_encode($data);


        }
        $db_conn->query("set names UTF8");
        $db_result = $db_conn->query($sql);
        $row=$db_result->fetch_assoc();
        if(isset($row) && $row['status']==1){


                $sql="select * from user left join message on user.openid=message.openid where message.display=1 &&  message.tp_id='$this->tp_id'";


            $db_conn=new mysqli('localhost','root','','new_wechat');
            if ($db_conn->connect_error) {
                $data=array(
                    'code'=>1,
                    'msg'=>'error:Database connection failed!',
                    'data'=>$db_conn->connect_error,

                );
                echo json_encode($data);


            }
            $db_conn->query("set names UTF8");
            $db_result = $db_conn->query($sql);
            while($row=$db_result->fetch_assoc()){
                $data[]=$row;

            }


            $total=count($data);
            $a= rand(0, $total-1);
            $openid=$data[$a]['openid'];

                $data=array(
                    'code'=>0,
                    'msg'=>'OK!',
                    'data'=>array(
                                'nickname'=>$data[$a]['nickname'],
                                'headimgurl'=>$data[$a]['headimgurl']


                                ),

                        );
            $sql="select * from Awards where tp_id='$this->tp_id'";
            $db_conn=new mysqli('localhost','root','','new_wechat');
            $db_conn->query("set names UTF8");
            $db_result = $db_conn->query($sql);
            $row=$db_result->fetch_assoc();
          //  while($row=$db_result->fetch_assoc()){


                if(isset($row) && $row['openid']== $openid){

                    $this->setAwardinfo();
                   // break;


                }
            else{
                $time=time();

                $sql="insert into Awards(openid,tp_id,create_at) values('$openid','$this->tp_id','$time')";
                $db_conn=new mysqli('localhost','root','','new_wechat');
                $db_conn->query("set names UTF8");
                $db_result = $db_conn->query($sql);
            // echo  $tmpStr = json_encode($data);
              //  echo get_emoji($tmpStr,true);
                echo 1;

            }
           // }








        }
        else{
            $data=array(
                'code'=>"-1",
                'msg'=>'error:this topic is over!',

            );
            echo json_encode($data);
        }



    }
}
function get_emoji($text,$isJson=false){
    $tempstr=$text;
    if(!$isJson)$tempstr=json_encode($text);
    $tempstr=preg_replace("#(\\\ue[0-9a-f]{3})#ie","addslashes('$1')",$tempstr);
    $tempstr=preg_replace("/\\\\\\\\u(e[0-9a-f]{3})/","",$tempstr);
    if(!$isJson)$tempstr=json_decode($tempstr);
    return $tempstr;
}
function get_qqface($text){
    $tempstr=$text;
    $dataArray=array("微笑","撇嘴","色","发呆","得意","流泪","害羞","闭嘴","睡","大哭","尴尬","发怒","调皮","呲牙","惊讶","难过","酷","冷汗","抓狂","吐","偷笑","可爱","白眼","傲慢","饥饿","困","惊恐","流汗","憨笑","大兵","奋斗","咒骂","疑问","嘘","晕","折磨","衰","骷髅","敲打","再见","擦汗","抠鼻","鼓掌","糗大了","坏笑","左哼哼","右哼哼","哈欠","鄙视","委屈","快哭了","阴险","亲亲","吓","可怜","菜刀","西瓜","啤酒","篮球","乒乓","咖啡","饭","猪头","玫瑰","凋谢","示爱","爱心","心碎","蛋糕","闪电","炸弹","刀","足球","瓢虫","便便","月亮","太阳","礼物","拥抱","强","弱","握手","胜利","抱拳","勾引","拳头","差劲","爱你","No","Ok","爱情","飞吻","跳跳","发抖","怄火","转圈","磕头","回头","跳绳","挥手","激动","街舞","献吻","左太极","右太极");
    for($a=0;$a<count($dataArray);$a++){
        $tempstr=preg_replace("/\/".$dataArray[$a]."/","<img src='http://rescdn.qqmail.com/zh_CN/images/mo/DEFAULT2/".$a.".gif' width=25px hight=25px />",$tempstr);
    }
    return $tempstr;
}
new index;

?>