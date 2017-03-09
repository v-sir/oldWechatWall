<?php
/**
 * Created by HuangWei.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 14:44
 */
defined('IN_faeriesCMS') or exit('No permission resources.');
class index{
    public $wechat;
    public $shake;
    function __construct() {
        $this->wechat=faeriesCMS_base::load_app_class('wechat','wechat',1);

    }
    public function init() {
       // if(!isset($_GET['echostr']))
       // {
           // echo 0;
           // $this->wechat->init();

       // }
       // else
      //  {
            $this->wechat->responseMsg();
           // echo 1;

       // }


    }
    public function shake(){
        $this->shake=faeriesCMS_base::load_app_class('shake','wechat',1);
        $this->shake->getShakeUser();



    }
}
?>