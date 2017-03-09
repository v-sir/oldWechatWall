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
                $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
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
            $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
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
            $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
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
            $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
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
            $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
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
            $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
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
            $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
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
                    $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
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
            $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
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
                $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
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
                $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
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
            $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
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

        $max_file_size=2000000;     //�ϴ��ļ���С����, ��λBYTE
        $destination_folder="uploadimg/"; //�ϴ��ļ�·��
        $watermark=0;      //�Ƿ񸽼�ˮӡ(1Ϊ��ˮӡ,����Ϊ����ˮӡ);
        $watertype=1;      //ˮӡ����(1Ϊ����,2ΪͼƬ)
        $waterposition=1;     //ˮӡλ��(1Ϊ���½�,2Ϊ���½�,3Ϊ���Ͻ�,4Ϊ���Ͻ�,5Ϊ����);
        $waterstring="http://www.xplore.cn/";  //ˮӡ�ַ���
        $waterimg="xplore.gif";    //ˮӡͼƬ
        $imgpreview=0;      //�Ƿ�����Ԥ��ͼ(1Ϊ����,����Ϊ������);
        $imgpreviewsize=1/2;    //����ͼ����
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (!is_uploaded_file($_FILES["upfile"]['tmp_name']))
                //�Ƿ�����ļ�
            {
                echo "ͼƬ������!";
                exit;
            }

            $file = $_FILES["upfile"];
            if($max_file_size < $file["size"])
                //����ļ���С
            {
                echo "�ļ�̫��!";
                exit;
            }

            if(!in_array($file["type"], $uptypes))
                //����ļ�����
            {
                echo "�ļ����Ͳ���!".$file["type"];
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
                echo "ͬ���ļ��Ѿ�������";
                exit;
            }

            if(!move_uploaded_file ($filename, $destination))
            {
                echo "�ƶ��ļ�����";
                exit;
            }

            $pinfo=pathinfo($destination);
            $fname=$pinfo['basename'];
            echo " <script>alert('�Ѿ��ɹ��ϴ�')</script>";


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
                        die("��֧�ֵ��ļ�����");
                        exit;
                }

                imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);
                imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);

                switch($watertype)
                {
                    case 1:   //��ˮӡ�ַ���
                        imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);
                        break;
                    case 2:   //��ˮӡͼƬ
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

                //����ԭ�ϴ��ļ�
                imagedestroy($nimage);
                imagedestroy($simage);
            }

          // if($imgpreview==1)
         //   {
            //    echo "<br>ͼƬԤ��:<br>";
            //    echo "<img src=\"".$destination."\" width=".($image_size[0]*$imgpreviewsize)." height=".($image_size[1]*$imgpreviewsize);
           // //    echo " alt=\"ͼƬԤ��:\r�ļ���:".$destination."\r�ϴ�ʱ��:\">";
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