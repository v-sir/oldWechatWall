/**
 * Created by Jarvis on 4/9/2016.
 */
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
document.getElementById("control").onmouseover=function(){
    stop()
}
document.getElementById("control").onmouseout=function(){
    if(document.getElementById("shadow").style.display!="block")play();
}
show(0);
play();
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
    for(var b=0;b<num;b++){
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
function startGetAward(){
    getAwardData=false;
    getDataStop();
    $.ajax({
        url:"http://new.weixin.sky31.com/api/index.php?action=setAwardInfo&tp_id="+topicid,
        type:"GET",
        success:function(data){
            json=JSON.parse(data);
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
    });
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
            },Math.random()*1000+3000);
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
        url:"http://new.weixin.sky31.com/api/index.php?action=getWallInfo&tp_id="+topicid,
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

