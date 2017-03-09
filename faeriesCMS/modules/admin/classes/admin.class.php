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
        $dataArray = array("微笑", "撇嘴", "色", "发呆", "得意", "流泪", "害羞", "闭嘴", "睡", "大哭", "尴尬", "发怒", "调皮", "呲牙", "惊讶", "难过", "酷", "冷汗", "抓狂", "吐", "偷笑", "可爱", "白眼", "傲慢", "饥饿", "困", "惊恐", "流汗", "憨笑", "大兵", "奋斗", "咒骂", "疑问", "嘘", "晕", "折磨", "衰", "骷髅", "敲打", "再见", "擦汗", "抠鼻", "鼓掌", "糗大了", "坏笑", "左哼哼", "右哼哼", "哈欠", "鄙视", "委屈", "快哭了", "阴险", "亲亲", "吓", "可怜", "菜刀", "西瓜", "啤酒", "篮球", "乒乓", "咖啡", "饭", "猪头", "玫瑰", "凋谢", "示爱", "爱心", "心碎", "蛋糕", "闪电", "炸弹", "刀", "足球", "瓢虫", "便便", "月亮", "太阳", "礼物", "拥抱", "强", "弱", "握手", "胜利", "抱拳", "勾引", "拳头", "差劲", "爱你", "No", "Ok", "爱情", "飞吻", "跳跳", "发抖", "怄火", "转圈", "磕头", "回头", "跳绳", "挥手", "激动", "街舞", "献吻", "左太极", "右太极");
        for ($a = 0; $a < count($dataArray); $a++) {
            $tempstr = preg_replace("/\/" . $dataArray[$a] . "/", "<img src='http://rescdn.qqmail.com/zh_CN/images/mo/DEFAULT2/" . $a . ".gif' width=25px hight=25px />", $tempstr);
        }
        return $tempstr;
    }






    /**
     * 加载后台模板
     * @param string $file 文件名
     * @param string $m 模型名
     */
    final public static function admin_tpl($file, $m = '') {
        $m = empty($m) ? ROUTE_M : $m;
        if(empty($m)) return false;
        return FC_PATH.'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$file.'.tpl.php';
    }


}
?>