<?php
/**
 * Created by HuangWei.
 * User: Administrator
 * Date: 2016/4/2
 * Time: 10:41
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
class admin{
    public $userid;
    public $username;
    public $topic;

    public function __construct(){


    }
    function get_emoji($text,$isJson=false){
        $tempstr=$text;
        if(!$isJson)$tempstr=json_encode($text);
        $tempstr=preg_replace("#(\\\ue[0-9a-f]{3})#ie","addslashes('$1')",$tempstr);
        $tempstr=preg_replace("/\\\\\\\\u(e[0-9a-f]{3})/","<img src='http:\/\/www.easyapns.com\/emoji\/$1.png'  width='20' height='20'>",$tempstr);
        if(!$isJson)$tempstr=json_decode($tempstr);
        return $tempstr;
    }
    function get_qqface($text)
    {
        $tempstr = $text;
        $dataArray = array("΢Ц", "Ʋ��", "ɫ", "����", "����", "����", "����", "����", "˯", "���", "����", "��ŭ", "��Ƥ", "����", "����", "�ѹ�", "��", "�亹", "ץ��", "��", "͵Ц", "�ɰ�", "����", "����", "����", "��", "����", "����", "��Ц", "���", "�ܶ�", "����", "����", "��", "��", "��ĥ", "˥", "����", "�ô�", "�ټ�", "����", "�ٱ�", "����", "�ܴ���", "��Ц", "��ߺ�", "�Һߺ�", "��Ƿ", "����", "ί��", "�����", "����", "����", "��", "����", "�˵�", "����", "ơ��", "����", "ƹ��", "����", "��", "��ͷ", "õ��", "��л", "ʾ��", "����", "����", "����", "����", "ը��", "��", "����", "ư��", "���", "����", "̫��", "����", "ӵ��", "ǿ", "��", "����", "ʤ��", "��ȭ", "����", "ȭͷ", "�", "����", "No", "Ok", "����", "����", "����", "����", "���", "תȦ", "��ͷ", "��ͷ", "����", "����", "����", "����", "����", "��̫��", "��̫��");
        for ($a = 0; $a < count($dataArray); $a++) {
            $tempstr = preg_replace("/\/" . $dataArray[$a] . "/", "<img src='http://rescdn.qqmail.com/zh_CN/images/mo/DEFAULT2/" . $a . ".gif' width=25px hight=25px />", $tempstr);
        }
        return $tempstr;
    }






    /**
     * ���غ�̨ģ��
     * @param string $file �ļ���
     * @param string $m ģ����
     */
    final public static function admin_tpl($file, $m = '') {
        $m = empty($m) ? ROUTE_M : $m;
        if(empty($m)) return false;
        return FC_PATH.'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$file.'.tpl.php';
    }


}
?>