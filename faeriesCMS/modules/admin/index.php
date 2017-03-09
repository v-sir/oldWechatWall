<?php
/**
 * Created by HuangWei.
 * User: Administrator
 * Date: 2016/4/2
 * Time: 10:10
 */
defined('IN_faeriesCMS') or exit('No permission resources.');
faeriesCMS_base::load_app_class('admin','admin',0);
class index extends admin {
    public $username;
    public $password;


    public function __construct() {
        parent::__construct();







    }
    function index(){

    }
    function init(){
        session_start();
        if(isset($_SESSION['loginstatus'])){
            $tpl=@$_GET['tpl'];
            if(isset($tpl)){

           include $this->admin_tpl($tpl);
            }
            else{
                include $this->admin_tpl('index');
            }
        }
        else{
            include $this->admin_tpl('login');
        }




    }
    function login(){
        $username=$_POST['UserName'];
        $password=$_POST['PassWord'];
        if($username=="" && $password==""){


           // include $this->admin_tpl('login');
            echo"<script>alert('error:Please enter username or password!')</script>";



        }
        else{

                $sql="select* from admin where UserName='$username'";
                $db_conn=new mysqli('localhost','root','','new_wechat');
                if ($db_conn->connect_error) {
                    include $this->admin_tpl('login');
                    echo"<script>alert('error:Database connection failed!')</script>";


                }
                $db_conn->query("set names UTF8");
                $db_result = $db_conn->query($sql);
                $row=$db_result->fetch_assoc();
                if($row['id']!=""){
                    if($row['PassWord']==$password){
                        session_start();
                        $_SESSION['loginstatus']=md5('23wqea#$%DS'.$password.$username);
                        $_SESSION['username']=$row['UserName'];
                        header('location:index.php?m=admin&c=index');



                    }
                    else{

                        echo"<script>alert('error:Incorrect password!')</script>";
                       include $this->admin_tpl('login');





                    }
                 }

                else {




                    echo"<script>alert( 'error:The user does not exist!')</script>";
                    include $this->admin_tpl('login');





                     }

        }




    }
    function logout(){
        session_start();
        session_destroy();
        header('index.php?m=admin&c=index');
        include $this->admin_tpl('login');

    }
    //topic
    function topic_del($tp_id=''){
        $tp_id=@$_GET['tp_id'];
        session_start();
        if(isset($_SESSION['loginstatus'])){

            $sql="delete from topic where tp_id='$tp_id'";
            $db_conn=new mysqli('localhost','root',','new_wechat');
            if ($db_conn->connect_error) {
                echo"<script>alert('error:Database connection failed!')</script>";


            }
            $db_conn->query("set names UTF8");
            $db_result = $db_conn->query($sql);
            header('location:index.php?m=admin&c=index&tpl=topic');
            include $this->admin_tpl('topic');

        }
    }
    function topic_add(){
        session_start();
        if(isset($_SESSION['loginstatus'])){


            $topic=$_POST['topic'];
            $imgURL=$_POST['imgURL'];
            $logoURL=$_POST['logoURL'];
            if($logoURL=='') {
                $logoURL="logo.png";
            }


            $ad=$_POST['ad'];
            $time=time();
            $sql="insert into topic(topic,imgURL,logoURL,create_at,announcer,ad,status)
            value('$topic','$imgURL','$logoURL','$time','$_SESSION[username]','$ad',1)";
            $db_conn=new mysqli('localhost','root','','new_wechat');
            if ($db_conn->connect_error) {
                echo"<script>alert('error:Database connection failed!')</script>";


            }
            $db_conn->query("set names UTF8");
            $db_result = $db_conn->query($sql);
            header('location:index.php?m=admin&c=index&tpl=topic');
            include $this->admin_tpl('topic');

    }
    }
    function topic_update(){

    }
    function topic_close(){
    $tp_id=@$_GET['tp_id'];
    session_start();
    if(isset($_SESSION['loginstatus'])){
        if(isset( $tp_id) && $tp_id!=''){
            $sql="update topic set status=0 where tp_id='$tp_id'";
            $db_conn=new mysqli('localhost','root','','new_wechat');
            if ($db_conn->connect_error) {
                echo"<script>alert('error:Database connection failed!')</script>";


            }
            $db_conn->query("set names UTF8");
            $db_result = $db_conn->query($sql);
              header('location:index.php?m=admin&c=index&tpl=topic');
             include $this->admin_tpl('topic');
            if($db_result){
                $data=array(
                    'code'=>0,
                    'msg'=>'OK!'


                );
            }
            else{
                $data=array(
                    'code'=>-1,
                    'msg'=>'unknown mistake!'


                );
            }
            echo json_encode($data);

        }
        else{
            $data=array(
                'code'=>-1,
                'msg'=>'error:Missing Parameters!'


            );
            echo json_encode($data);
        }





    }

}
    function topic_open(){
        $tp_id=@$_GET['tp_id'];
        session_start();
        if(isset($_SESSION['loginstatus'])){

            $sql="update topic set status=1 where tp_id='$tp_id'";
            $db_conn=new mysqli('localhost','root','','new_wechat');
            if ($db_conn->connect_error) {
                echo"<script>alert('error:Database connection failed!')</script>";


            }
            $db_conn->query("set names UTF8");
            $db_result = $db_conn->query($sql);
            header('location:index.php?m=admin&c=index&tpl=topic');
            include $this->admin_tpl('topic');

        }

    }
    //wechat msg
    function wcMsg_del($id=''){
        $id=@$_GET['id'];
        $page=@$_GET['page'];
        $tp_id=@$_GET['tp_id'];
        session_start();
        if(isset($_SESSION['loginstatus'])){

            $sql="delete from message where id='$id'";
            $db_conn=new mysqli('localhost','root','','new_wechat');
            if ($db_conn->connect_error) {
                echo"<script>alert('error:Database connection failed!')</script>";


            }
            $db_conn->query("set names UTF8");
            $db_result = $db_conn->query($sql);
            if(isset($page)){
                header('location:index.php?m=admin&c=index&tpl=wechat&tp_id='.$tp_id.'&page='.$page);
            }
            else{
                header('location:index.php?m=admin&c=index&tpl=wechat&tp_id='.$tp_id.'&page=1');

            }



            include $this->admin_tpl('wechat');

        }
    }
    function wc_onWall(){
        $id=@$_GET['id'];
        $tp_id=@$_GET['tp_id'];
        $page=@$_GET['page'];
        session_start();
        if(isset($_SESSION['loginstatus'])){

            $sql="update message set display=1 where id='$id'";
            $db_conn=new mysqli('localhost','root','','new_wechat');
            if ($db_conn->connect_error) {
                echo"<script>alert('error:Database connection failed!')</script>";


            }
            $db_conn->query("set names UTF8");
            $db_result = $db_conn->query($sql);
            if(isset($page)){
                header('location:index.php?m=admin&c=index&tpl=wechat&tp_id='.$tp_id.'&page='.$page);
            }
            else{
                header('location:index.php?m=admin&c=index&tpl=wechat&tp_id='.$tp_id.'&page=1');

            }

            include $this->admin_tpl('wechat');

        }

    }
    function wc_AutoOnWall(){
        $tp_id=@$_GET['tp_id'];
        $auto=@$_GET['auto'];
        session_start();
        if(isset($_SESSION['loginstatus'])){
            if($auto==1){
                for($i=1; ;$i++){
                    $sql="select *from message where display=0 && tp_id='$tp_id'";
                    $db_conn=new mysqli('localhost','root','','new_wechat');
                    if ($db_conn->connect_error) {
                        echo"<script>alert('error:Database connection failed!')</script>";


                    }
                    $db_conn->query("set names UTF8");
                    $db_result = $db_conn->query($sql);
                    $row=$db_result->fetch_assoc();
                    $id=rand(1,count($row));
                    $sql="update message set display=1 where id='$id'";
                    $db_conn->query("set names UTF8");
                    $db_result = $db_conn->query($sql);


                    if(isset($page)){
                        header('location:index.php?m=admin&c=index&tpl=wechat&tp_id='.$tp_id.'&page='.$page);
                    }
                    else{
                        header('location:index.php?m=admin&c=index&tpl=wechat&tp_id='.$tp_id.'&page=1');

                    }
                }


            }


        }

    }
    function wc_NotOnWall(){
        $tp_id=@$_GET['tp_id'];
        $id=@$_GET['id'];
        $page=@$_GET['page'];
        session_start();
        if(isset($_SESSION['loginstatus'])){

            $sql="update message set display=0 where id='$id'";
            $db_conn=new mysqli('localhost','root','','new_wechat');
            if ($db_conn->connect_error) {
                echo"<script>alert('error:Database connection failed!')</script>";


            }
            $db_conn->query("set names UTF8");
            $db_result = $db_conn->query($sql);
            if(isset($page)){
                header('location:index.php?m=admin&c=index&tpl=wechat&tp_id='.$tp_id.'&page='.$page);
            }
            else{
                header('location:index.php?m=admin&c=index&tpl=wechat&tp_id='.$tp_id.'&page=1');

            }

            include $this->admin_tpl('wechat');

        }

    }
//batch
    function wc_onWallIds(){
        $tp_id=@$_GET['tp_id'];
        $id=@$_POST['batchID'];
        $page=@$_GET['page'];
        $tpl=@$_GET['tpl'];
        //print_r($id);

        session_start();
        if(isset($_SESSION['loginstatus'])){
            for($num=0;$num<count($id);$num++){
               $sql="update message set display=1 where id='$id[$num]'";
                $db_conn=new mysqli('localhost','root','','new_wechat');
                if ($db_conn->connect_error) {
                    echo"<script>alert('error:Database connection failed!')</script>";


                }
                $db_conn->query("set names UTF8");
                $db_result = $db_conn->query($sql);

            }


            if(isset($page)){
             header('location:index.php?m=admin&c=index&tpl=wechat&tp_id='.$tp_id.'&page='.$page);
            }
            else{
            header('location:index.php?m=admin&c=index&tpl=wechat&tp_id='.$tp_id.'&page=1');

            }
            if(isset($tpl)){
                include $this->admin_tpl($tpl);
            }
            else{
                include $this->admin_tpl('wechat');
            }



        }
    }
    function wc_NotOnWallIds(){
        $tp_id=@$_GET['tp_id'];
        $id=@$_POST['batchID'];
        $page=@$_GET['page'];
        // print_r($id);

        session_start();
        if(isset($_SESSION['loginstatus'])){
            for($num=0;$num<count($id);$num++){
                $sql="update message set display=0 where id='$id[$num]'";
                $db_conn=new mysqli('localhost','root','','new_wechat');
                if ($db_conn->connect_error) {
                    echo"<script>alert('error:Database connection failed!')</script>";


                }
                $db_conn->query("set names UTF8");
                $db_result = $db_conn->query($sql);

            }


            if(isset($page)){
                header('location:index.php?m=admin&c=index&tpl=wechat&tp_id='.$tp_id.'&page='.$page);
            }
            else{
                header('location:index.php?m=admin&c=index&tpl=wechat&tp_id='.$tp_id.'&page=1');

            }

            include $this->admin_tpl('wechat');

        }
    }
    //award
    function award_del($id=''){
        $id=@$_GET['id'];
        $tp_id=@$_GET['tp_id'];
        $page=@$_GET['page'];
        session_start();
        if(isset($_SESSION['loginstatus'])){

            $sql="delete from Awards where id='$id'";
            $db_conn=new mysqli('localhost','root','','new_wechat');
            if ($db_conn->connect_error) {
                echo"<script>alert('error:Database connection failed!')</script>";


            }
            $db_conn->query("set names UTF8");
            $db_result = $db_conn->query($sql);
            if(isset($page)){
                header('location:index.php?m=admin&c=index&tpl=awardt&tp_id='.$tp_id.'&page='.$page);
            }
            else{
                header('location:index.php?m=admin&c=index&tpl=awardt&tp_id='.$tp_id.'&page=1');
            }
            include $this->admin_tpl('award');

        }
    }
    function upload_img(){
        $uptypes=array(
            'image/jpg',
            'image/jpeg',
            'image/png',
            'image/pjpeg',
            'image/gif',
            'image/bmp',
            'image/x-png'
        );

        $max_file_size=2000000;     //上传文件大小限制, 单位BYTE
        $destination_folder="uploadimg/"; //上传文件路径
        $watermark=0;      //是否附加水印(1为加水印,其他为不加水印);
        $watertype=1;      //水印类型(1为文字,2为图片)
        $waterposition=1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);
        $waterstring="http://www.xplore.cn/";  //水印字符串
        $waterimg="xplore.gif";    //水印图片
        $imgpreview=0;      //是否生成预览图(1为生成,其他为不生成);
        $imgpreviewsize=1/2;    //缩略图比例
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (!is_uploaded_file($_FILES["upfile"]['tmp_name']))
                //是否存在文件
            {
                echo "图片不存在!";
                exit;
            }

            $file = $_FILES["upfile"];
            if($max_file_size < $file["size"])
                //检查文件大小
            {
                echo "文件太大!";
                exit;
            }

            if(!in_array($file["type"], $uptypes))
                //检查文件类型
            {
                echo "文件类型不符!".$file["type"];
                exit;
            }

            if(!file_exists($destination_folder))
            {
                mkdir($destination_folder);
            }

            $filename=$file["tmp_name"];
            $image_size = getimagesize($filename);
            $pinfo=pathinfo($file["name"]);
            $ftype=$pinfo['extension'];
            $destination = $destination_folder.time().".".$ftype;
            if (file_exists($destination) && $overwrite != true)
            {
                echo "同名文件已经存在了";
                exit;
            }

            if(!move_uploaded_file ($filename, $destination))
            {
                echo "移动文件出错";
                exit;
            }

            $pinfo=pathinfo($destination);
            $fname=$pinfo['basename'];
            echo " <script>alert('已经成功上传')</script>";


            if($watermark==1)
            {
                $iinfo=getimagesize($destination,$iinfo);
                $nimage=imagecreatetruecolor($image_size[0],$image_size[1]);
                $white=imagecolorallocate($nimage,255,255,255);
                $black=imagecolorallocate($nimage,0,0,0);
                $red=imagecolorallocate($nimage,255,0,0);
                imagefill($nimage,0,0,$white);
                switch ($iinfo[2])
                {
                    case 1:
                        $simage =imagecreatefromgif($destination);
                        break;
                    case 2:
                        $simage =imagecreatefromjpeg($destination);
                        break;
                    case 3:
                        $simage =imagecreatefrompng($destination);
                        break;
                    case 6:
                        $simage =imagecreatefromwbmp($destination);
                        break;
                    default:
                        die("不支持的文件类型");
                        exit;
                }

                imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);
                imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);

                switch($watertype)
                {
                    case 1:   //加水印字符串
                        imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);
                        break;
                    case 2:   //加水印图片
                        $simage1 =imagecreatefromgif("xplore.gif");
                        imagecopy($nimage,$simage1,0,0,0,0,85,15);
                        imagedestroy($simage1);
                        break;
                }

                switch ($iinfo[2])
                {
                    case 1:
                        //imagegif($nimage, $destination);
                        imagejpeg($nimage, $destination);
                        break;
                    case 2:
                        imagejpeg($nimage, $destination);
                        break;
                    case 3:
                        imagepng($nimage, $destination);
                        break;
                    case 6:
                        imagewbmp($nimage, $destination);
                        //imagejpeg($nimage, $destination);
                        break;
                }

                //覆盖原上传文件
                imagedestroy($nimage);
                imagedestroy($simage);
            }

          // if($imgpreview==1)
         //   {
            //    echo "<br>图片预览:<br>";
            //    echo "<img src=\"".$destination."\" width=".($image_size[0]*$imgpreviewsize)." height=".($image_size[1]*$imgpreviewsize);
           // //    echo " alt=\"图片预览:\r文件名:".$destination."\r上传时间:\">";
            //}
        }
    }
    function load_Tpl(){


      include  $this->admin_tpl('award');

    }
    function b(){

    }


}
?>
