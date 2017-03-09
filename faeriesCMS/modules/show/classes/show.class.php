<?php
/**
 * Created by HuangWei.
 * User: Administrator
 * Date: 2016/4/5
 * Time: 19:48
 */
defined('IN_faeriesCMS') or exit('No permission resources.');
//if(param::get_cookie('sys_lang')) {
//  define('SYS_STYLE',param::get_cookie('sys_lang'));
//} else {

//define('SYS_STYLE','zh-cn');
if($_SESSION['lang']){

}else{
    $lang=@$_GET['lang'];
    session_start();
    $_SESSION['lang']=$lang;

}

if(isset($_SESSION['lang'])){

    define('SYS_STYLE',$_SESSION['lang']);

}
else{

    define('SYS_STYLE','zh-cn');

//}

}
define('IN_ADMIN',true);
class show{

    public function __construct(){


    }






    /**
     * 加载后台模板
     * @param string $file 文件名
     * @param string $m 模型名
     */
    final public static function show_tpl($file, $m = '') {
        $m = empty($m) ? ROUTE_M : $m;
        if(empty($m)) return false;
        return FC_PATH.'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$file.'.tpl.php';
    }


}
?>