<?php
/**
 * Created by HuangWei.
 * User: Administrator
 * Date: 2016/3/30
 * Time: 20:45
 */
defined('IN_faeriesCMS') or exit('No permission resources.');
class walltopic {
    public $topic;
    public $db_result;
    public $db_conn;
    function __construct() {

        $this->status=1;

    }


    public function get_topic(){

        $sql="select*from topic where status='$this->status'";
        $db_conn = new  mysqli('localhost','root','','new_wechat');

        if ($db_conn->connect_error) {
            $data=array(
                'code'=>1002,
                'msg'=>'error:Database connection failed!',
            );

            echo json_encode($data);


        }
        $db_conn->query("set names UTF8");
        $db_result = $db_conn->query($sql);
        while($row=$db_result->fetch_assoc()) {
            $this->topic[]=$row;





        }
        return $this->topic;



    }





}
?>