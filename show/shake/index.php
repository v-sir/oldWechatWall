<?php
if(isset($_GET['openid'])){
    $openid=$_GET['openid'];
}
else{
    exit("");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1.0">
    <meta charset="UTF-8">
    <title>三翼摇一摇</title>
    <script src="http://j.sky31.com/jQuery"></script>
    <style>
        *{margin: 0px auto;padding: 0px auto;font-family: "微软雅黑"}
        html,body{width: 100%;height: 100%;overflow: hidden}
        body{
            background-image: url("bg.png");
            background-position: center;
            background-repeat: no-repeat;
            background-size: 100% auto;
        }
        .shaking{
            -webkit-animation: move infinite linear 0.3s;
            -moz-animation: move infinite linear 0.3s;
            -ms-animation: move infinite linear 0.3s;
            -o-animation: move infinite linear 0.3s;
            animation: move infinite linear 0.3s;
        }
        @-webkit-keyframes move {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg); }
            30% {
                -webkit-transform: rotate(-10deg);
                -moz-transform: rotate(-10deg);
                -ms-transform: rotate(-10deg);
                -o-transform: rotate(-10deg);
                transform: rotate(-10deg); }
            60% {
                -webkit-transform: rotate(10deg);
                -moz-transform: rotate(10deg);
                -ms-transform: rotate(10deg);
                -o-transform: rotate(10deg);
                transform: rotate(10deg); }
            100% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg); }
        }
    </style>
</head>
<body>

<div style="text-align: center;margin-top: 20px;height: 300px;position: relative;top: 50%;margin-top: -150px">
    <img src="hand2.png" width="100" id="shakeImg" />
    <p style="color: #FFF;margin-top: 40px;"><span style="font-size: 40px" id="shakeCountMin">0</span><span style="font-size: 24px;margin-left: 10px;" id="shakeCountEx">/min</span></p>
    <p id="shakeStr" style="color: #FFF;margin-top: 20px;font-size: 24px">开始摇吧，宝宝记着呢</p>
</div>
<p style="position: absolute;bottom: 15px;text-align: center;color: #fff;font-size: 12px;width: 100%">Copyright © 2004-2016 湘潭大学三翼工作室
</p>
<script>
    var fastAver=0;
    var hand_move=0;
    var SHAKE_THRESHOLD=120;
    var SHAKE_TIME_THRESHOLD=500;
    var startTime=new Date().getTime();
    var last_update=new Date().getTime();
    var last_shake=[0,0,0];
    var Count=0;
    var AllCount=0;
    if (window.DeviceMotionEvent) {
        window.addEventListener('devicemotion', function (eventData) {
            if(new Date().getTime()-startTime<60000) {
                var acceleration = eventData.accelerationIncludingGravity;
                var curTime = new Date().getTime();
                x = acceleration.x;
                y = acceleration.y;
                z = acceleration.z;
                var speed = Math.abs((x - last_shake[0]) * 0.5 + (y - last_shake[1]) * 0.3 + (z - last_shake[2]) * 0.2) * 10;
                if (speed > SHAKE_THRESHOLD) {
                    if ((curTime - last_update) > SHAKE_TIME_THRESHOLD) {
                        clearTimeout(hand_move);
                        document.getElementById("shakeImg").className = "shaking";
                        AllCount++;
                        Count++;
                        document.getElementById("shakeStr").innerHTML = "摇了 " + AllCount + " 次少侠好手力啊";
                        hand_move = setTimeout(function () {
                            document.getElementById("shakeImg").className = "";
                        }, 600);
                        last_update = curTime;
                    }
                }
                last_shake[0] = x;
                last_shake[1] = y;
                last_shake[2] = z;
            }
        }, false);
    } else {
        alert('本设备不支持devicemotion事件');
    }
    setInterval(function(){
        if(new Date().getTime()-startTime<60000){
            document.getElementById("shakeCountMin").innerHTML=(Count*12).toString();
            if((Count*12)>fastAver)fastAver=Count*12;
            document.getElementById("shakeCountEx").innerHTML="/min";
            $.ajax({
                url:"http://new.weixin.sky31.com/api/index.php?action=addShakeInfo&allshake="+AllCount+"&fastestaver="+fastAver+"&avershake="+(Count*12)+"&openid=<?=@$openid?>",
                type:"GET"
            });
            Count=0;
        }
        else{
            if(Count>0){
                $.ajax({
                    url:"http://new.weixin.sky31.com/api/index.php?action=addShakeInfo&allshake="+AllCount+"&fastestaver="+fastAver+"&avershake="+(Count*12)+"&openid=<?=@$openid?>",
                    type:"GET"
                });
            }
            Count=0;
            document.getElementById("shakeCountMin").innerHTML=(AllCount).toString();
            document.getElementById("shakeCountEx").innerHTML="次";
            document.getElementById("shakeStr").innerHTML="摇一摇抽奖时间到，请等待开奖";
        }

    },5000);
</script>
</body>
</html>