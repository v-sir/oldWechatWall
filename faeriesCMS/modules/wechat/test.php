<?php
/**
 * Created by HuangWei.
 * User: Administrator
 * Date: 2016/3/30
 * Time: 21:17
 */
defined('IN_faeriesCMS') or exit('No permission resources.');
class test{
    public $topic;

    function a(){
        $this->topic= faeriesCMS_base::load_app_class('walltopic','wechat',1);
         $this->topic=$this->topic->get_topic();


       echo $total= count($this->topic);

        $keyword='#测试#放的地方都';
       for($num=0;$num<$total;$num++){
             $topic=$this->topic["$num"]['topic'];
             $tp_id=$this->topic["$num"]['tp_id'];
             $topic="#$topic#";
             if(substr_count($keyword,$topic)){
                 echo $topic;
                 echo $tp_id;


            }

         }


    }
    function b()

    {
        $topic = '#测试#';
        $keyword='#测试#测试';

        if (substr_count($keyword, $topic)) {
            echo $this->msg = $keyword;


        }
    }
    function c(){

        $sql="";
        $db_conn = new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
        $db_result = $db_conn->query($sql);
        $row=$db_result->fetch_assoc();
        print_r($row);

    }
    function d()
    {
        $this->db_conn = new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
        $this->sql = "insert into message(msg,tp_id,msg_type,create_at) values('$this->msg','$tp_id',0,'$time')";
        if($this->db_result = $this->db_conn->query($this->sql))

            echo  $contentStr = "发送信息成功！成功上墙还有机会获奖！";


    }





}




?>