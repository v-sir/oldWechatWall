<?php
/**
 * Created by HuangWei.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 9:39
 */
defined('IN_faeriesCMS') or exit('No permission resources.');
class getToken{
    public $Token;
    public $db_result;
    public $db_conn;
    function __construct() {

        $sql="select*from token ";
        $this->db_conn =new mysqli('localhost','root','');
        if ($this->db_conn) {
             $this->db_result = $this->db_conn->query($sql);

        }
    }


    public function get_Token(){

        return $row=$this->db_result->fetch_assoc();



    }

}