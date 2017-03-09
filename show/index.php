<?php
$topicId=@$_GET['id'];
if(is_numeric($topicId)){
    $sql="select * from topic where tp_id='$topicId'";
    $db_conn=new mysqli('localhost','api','','new_wechat');
    if ($db_conn->connect_error) {
        $data=array(
            'code'=>1,
            'msg'=>'error:Database connection failed!'

        );
        exit(json_encode($data));
    }
    $db_conn->query("set names UTF8");
    $db_result = $db_conn->query($sql);
    $row=$db_result->fetch_assoc();
    $huati=@$row["topic"];
    $ad=@$row['ad'];
    $logoURL=@$row['logoURL'];
}
else{
    exit();
}
//$topicId=3;
//$huati="hello"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>微信话题#<?=@$huati?>#</title>
    <link rel="stylesheet" type="text/css" href="wall.css">
    <script src="http://j.sky31.com/jQuery/jQuery.qrcode/TweenMax/"></script>
</head>
<body>
    <div id="bg"></div>
    <div id="container">
        <table cellspacing="0px" cellpadding="0px" style="width: 100%;height: 100%">
            <tr>
                <td height="130px">
                    <div id="header">
                        <table style="width: 100%;height: 100%;padding: 0px 20px" cellspacing="0px" >
                            <tr>
                                <td width="200px"><div id="logo"><img style="width:100px;height:100px; " src="<?=$logoURL?>"><?//if($logoURL=='')echo '<img src="logo.png">';else echo"<img src='$logoURL'>";?></div></td>
                                <td valign="top"  style="padding: 15px"><p id="desc"><span><?if (isset($ad)&& $ad!='')
                                            echo $ad;else echo '我是广告位，你还没设置呢！';?><br/>关注isky31参与话题<top style="color: #fff;">#<?=@$huati?>#</top></span></p></td>
                                <td width="120px">
                                    <div id="qrcode">
                                        <a href="javascript:openQrcode()"><img src="weixiner.png" width="90px" height="90px" style="margin: 5px"></a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <div id="main"></div>
                </td>
            </tr>
            <tr>
                <td height="80px" valign="top">
                    <div id="menu">
                        <a class="menu" id="award" href="javascript:openAward()"></a>
                        <a class="menu" id="shake" href="javascript:openShake()"></a>
                    </div>
                    <div id="control">
                        <a class="button" id="prev" href="javascript:show(-1)"><</a>
                        <a class="button" id="next" href="javascript:show(1)">></a>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div id="shadow" >
        <div id="shadowInfo">
            <div id="shadowBody">

            </div>
        </div>
    </div>
</body>
<script>
    var shakeTimer_Timer=0;
    var shakeTimer_=60;
    var shakeTimer=0;
    var shakeInfo={};
    var bgSize=1;
    var getAwardData=false;
    var dataTimer=0;
    var playTimer=0;
    var awardTimer=0;
    var wallPlay=true;
    var allMsg=[];
    var currentMsgId=0;
    var currentMsg={};
    var visibleNum=0;
    var awardInfo={};
    var bgimg = new Image();
    bgimg.src="bg.png";
    bgimg.onload=function(){
        bgSize=bgimg.width/bgimg.height;
        if($(window).width()/$(window).height()<bgSize){
            document.getElementById("bg").style.backgroundSize="auto 100%";
        }
        else{
            document.getElementById("bg").style.backgroundSize="100% auto";
        }
    };
    $(window).resize(function(){
        change(1);
        if($(window).width()/$(window).height()<bgSize){
            document.getElementById("bg").style.backgroundSize="auto 100%";
        }
        else{
            document.getElementById("bg").style.backgroundSize="100% auto";
        }
    });
    function change(type){
        var ele_main=document.getElementById("main");
        var height=$(window).height()-224;
        ele_main.style.height=height+"px";
        var num=parseInt(height/140);
        $("#main").html("");
        for(var b=0;b<num && b<allMsg.length;b++){
            var a=(currentMsgId+b)%allMsg.length;
            var ele='<div class="comment" onclick="openComment(this)" data-id="'+a+'"><table cellpadding="0px" cellspacing="0px"><tr><td align="center" style="width: 100px;padding: 20px;font-size: 0px" valign="top"><img src="'+allMsg[a].headimgurl+'" width="80" height="80" ></td><td width="100%" style="padding: 20px 20px 20px 0px"><div class="content"><div class="name">'+allMsg[a].nickname+'</div><div class="string">'+allMsg[a].msg+'</div></div></td></tr></table></div>';
            $("#main").append(ele);
            if(type==1){
                $("#main").children(".comment")[b].style.display="block";
                $("#main").children(".comment")[b].style.opacity=1;
            }
            else{
                $("#main").children(".comment")[b].style.display="block";
                TweenMax.to($("#main").children(".comment")[b],1.3,{opacity:1,delay:b*0.15});
            }
        }
        $("#main").find(".string").css("width",$("#main").width()-200+"px");
        visibleNum=num;
    }
    function closeShadow(type){
        clearInterval(awardTimer);
        stopShake();
        if(type==1){
            getDataStart();
        }
        play();
        TweenMax.fromTo(document.getElementById("container"),0.2,{"-webkit-filter":"blur(5px)","filter":"blur(5px)"},{"-webkit-filter":"blur(0px)","filter":"blur(0px)"});
        TweenMax.fromTo(document.getElementById("shadow"),0.2,{"display":"block","opacity":1},{"display":"none","opacity":0});
    }
    function openShadow(){
        stop()
        TweenMax.fromTo(document.getElementById("container"),0.4,{"-webkit-filter":"none","filter":"none"},{"-webkit-filter":"blur(5px)","filter":"blur(5px)"});
        TweenMax.fromTo(document.getElementById("shadow"),0.4,{"display":"none","opacity":0},{"display":"block","opacity":1});
    }
    function openQrcode(){
        var ele='<a id="shadowCloseButton" href="javascript:closeShadow()">X</a><div style="text-align: center;clear: both"><img src="weixiner.png" style="position: relative;top:-30px;"></div>';
        $("#shadowBody").html(ele);
        openShadow();
    }
    function openComment(ele){
        var id=ele.getAttribute("data-id");
        var ele='<div class="comment" style="opacity: 1"><table cellpadding="0px" cellspacing="0px"><tr><td align="center" style="width: 100px;padding: 20px;font-size: 0px" valign="top"><img src="'+allMsg[id].headimgurl+'" width="80" height="80" ></td><td width="100%" style="padding: 20px 20px 20px 0px"><div class="content"><div class="name">'+allMsg[id].nickname+'</div><div class="string">'+allMsg[id].msg+'</div></div></td></tr></table></div><a id="shadowClose" class="button" href="javascript:closeShadow()">返回</a>';
        $("#shadowBody").html(ele);
        openShadow();

    }
    function getAwardA(){
        $.ajax({
            url:"http://new.weixin.sky31.com/api/index.php?action=setAwardInfo&tp_id=<?=$topicId?>",
            type:"GET",
            complete:function(e,x){
                if(e.status==200){
                    json=JSON.parse(e.responseText);
                    if(json.code=="0"){
                        awardInfo.headimage=json.data.headimgurl;
                        awardInfo.name=json.data.nickname;
                        getAwardData=true;
                        console.log("get award");
                    }
                    else{
                        alert("发生错误，请稍候重试");
                    }
                }
                else{
                    getAwardA();
                }
            }
        });
    }
    function startGetAward(){
        getAwardData=false;
        getDataStop();
        getAwardA();
        var a=0;
        var all=false;
        awardTimer=setInterval(function(){
            if(document.getElementById("awardName").innerHTML!=allMsg[a].nickname){
                document.getElementById("headerImage").src=allMsg[a].headimgurl;
                document.getElementById("awardName").innerHTML=allMsg[a].nickname;
            }
            a++;
            if(a==allMsg.length && all==false && getAwardData){
                setTimeout(function(){
                    stopGetAward();
                },Math.random()*1000+2000);
                all=true;
            }
            a=a%allMsg.length;
        },50);

        document.getElementById("awardStart").style.display="none";
        document.getElementById("awardResult").innerHTML="正在抽奖...";
    }
    function stopGetAward(){
        clearInterval(awardTimer);
        document.getElementById("awardStart").style.display="block";
        document.getElementById("headerImage").src=awardInfo.headimage;
        document.getElementById("awardName").innerHTML=awardInfo.name;
        document.getElementById("awardResult").innerHTML="恭喜以上用户获得奖品！";
        document.getElementById("awardStart").innerHTML="再抽一次";
        getDataStart();
    }
    function openAward(){
        var ele='<a id="shadowCloseButton" href="javascript:closeShadow(1)">X</a><div id="getAward" align="center"><img  width="100px" height="100px" id="headerImage"><p align="center" style="font-size: 40px;line-height: 50px" id="awardName">？？？</p><p align="center" style="font-size: 20px;margin-top: 20px" id="awardResult">即将开始抽奖(ง •̀_•́)ง </p></div><a id="awardStart" class="button" href="javascript:startGetAward();">开始抽奖</a>';
        $("#shadowBody").html(ele);
        openShadow();
    }
    function show(direct){
        if(direct<0){
            currentMsgId-=visibleNum;
            currentMsgId=(currentMsgId+allMsg.length)%allMsg.length;
            change();
        }
        else if(direct>0){
            currentMsgId+=visibleNum;
            currentMsgId=(currentMsgId+allMsg.length)%allMsg.length;
            change();
        }
        else{
            currentMsgId=0;
            currentMsg={};
            loadMsg(1);
        }
    }
    function loadMsg(type){
        $.ajax({
            url:"http://new.weixin.sky31.com/api/index.php?action=getWallInfo&tp_id=<?=$topicId?>",
            type:"GET",
            success:function(data){
                json=JSON.parse(data);
                if(json.code=="0"){
                    allMsg=json.data;
                    if(type==1){
                        change();
                    }
                    console.log("get data");
                }
                else{
                    alert("发生错误，请重试");
                }
            }
        });
    }
    document.getElementById("control").onmouseover=function(){
        stop()
    }
    document.getElementById("control").onmouseout=function(){
        if(document.getElementById("shadow").style.display!="block")play();
    }
    show(0);
    play();
    getDataStart();
    function stop(){
        clearInterval(playTimer);
    }
    function play(){
        stop();
        playTimer=setInterval(function(){show(1);},8000);
    }
    function getDataStart(){
        dataTimer=setInterval(function(){
            loadMsg();
        },8000);
    }
    function getDataStop(){
        clearInterval(dataTimer);
    }
    function getShakeInfo(){
        $.ajax({
            url:"http://new.weixin.sky31.com/api/index.php?action=showShakeInfo",
            type:"GET",
            success:function(data){
                var json=JSON.parse(data);
                if(json.code=="0"){
                    shakeInfo=json;
                    updateShake();
                }
                else{
                    alert("发生错误，请重试");
                }
            }
        });
    }

    function openShake(){
        var ele='<a id="shadowCloseButton" href="javascript:closeShadow(1)">X</a><div style="line-height: 50px;height: 50px;font-size: 20px;padding-left: 20px">摇一摇吧</div><div style="display: inline-block;width: 100%;text-align: center;margin-bottom: 20px;font-size: 30px;" id="shakeTimer_str"><span id="shakeTimer_view">60</span><span style="font-size: 30px"> s</span></div><div style="padding: 20px;display: inline-block;width: 100%;margin-top: -20px"><table width="550" cellpadding="0px" cellspacing="0px"><tr><td width="100%" valign="top" id="shakeLeft"></td></tr><tr><td  valign="top" style="padding-top: 10px" id="shakeRight"></td></tr></table></div>';
        $("#shadowBody").html(ele);
        getShakeInfo();
        startShake();
        openShadow();
    }
    function startShake(){
        shakeTimer_Timer=setInterval(function(){
            if(shakeTimer_>0){
                shakeTimer_--;
                document.getElementById("shakeTimer_view").innerHTML=shakeTimer_;
            }
            if(shakeTimer_==0){
                stopShake();
                document.getElementById("shakeTimer_str").innerHTML="摇一摇时间到！";
            }
        },1000);
        shakeTimer=setInterval(function(){
            if(shakeTimer_>0){
                getShakeInfo();
            }
            else{
                stopShake();
            }

        },3000);
    }
    function stopShake(){
        clearInterval(shakeTimer_Timer);
        clearInterval(shakeTimer);
        shakeTimer_=60;
    }
    function updateShake(){
        var a=0;
        $("#shakeLeft").html("");
        $("#shakeRight").html("");
        for(a=0;a<shakeInfo.data.length && a<5;a++){
            var temp=shakeInfo.data[a];
            if(a<3){
                var ele='<div class="shakeList" ><div class="num num'+(a+1)+'">No.'+(a+1)+'</div><img src="'+temp.headimgurl+'" width="56" height="56" style="float: left"><div class="name" title="'+temp.nickname+'">'+temp.nickname+'</div><div class="shakes">'+temp.allshake+'次</div></div>';
                $("#shakeLeft").append(ele);
            }
            else{
                var ele='<div class="shakeList" ><img src="'+temp.headimgurl+'" width="32" height="32" style="float: left"><div class="name" title="'+temp.nickname+'">'+temp.nickname+'</div><div class="shakes">'+temp.allshake+'次</div></div>';
                $("#shakeRight").append(ele);
            }
        }
    }

</script>
</html>