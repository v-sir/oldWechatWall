<?
defined('IN_faeriesCMS') or exit('No permission resources.');


include  $this->admin_tpl('header'); ?>
<div><!--在这里改  -->
    <div class="row show-it">
        <div class="col-md-12 column">
            <center><div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><? echo L('wechat_wall_wcmsg')?></h3>
                    </div>
                    <div class="panel-body">
                        <a href="index.php?m=admin&c=index&tpl=wechat&page=1&tp_id=<?=@$_GET['tp_id']?>" class="btn btn-primary"><? echo L('AllMessage')?></a>&nbsp;&nbsp;&nbsp;<a href="index.php?m=admin&c=index&tpl=wechat_active&page=1&tp_id=<?=@$_GET['tp_id']?>" class="btn btn-info"><? echo L('activeMessage')?></a>&nbsp;&nbsp;&nbsp;<a href="index.php?m=admin&c=index&tpl=wechat_inactive&page=1&tp_id=<?=@$_GET['tp_id']?>" class="btn btn-warning"><? echo L('closeMessage')?></a>
                    </div>
                </div></center>
            <table class="table table-striped table-bordered white-bg">

                <tr>
                    <th><?echo L('option')?></th>
                    <th><?echo L('tp_id')?></th>
                    <th><?echo L('msg')?></th>
                    <th><?echo L('msg_type')?></th>
                    <th><?echo L('nickname')?></th>
                    <th><?echo L('headimgurl')?></th>
                    <th><?echo L('status')?></th>
                    <th><?echo L('create_at')?></th>
                    <th><?echo L('operating')?></th>

                    <?
                    session_start();
                    if(isset($_SESSION['loginstatus'])){
                    $page=@$_GET['page'];
                    $tp_id=@$_GET['tp_id'];
                    if(isset($tp_id)){
                        $sql="select* from user left join message on user.openid=message.openid  where message.tp_id='$tp_id' && message.display=1 ";
                    }
                    else{
                        $sql="select* from user left join message on user.openid=message.openid   where message.display=1 ";
                    }
                    $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
                    if ($db_conn->connect_error) {
                        echo"<script>alert('error:Database connection failed!')</script>";


                    }
                    $db_conn->query("set names UTF8");
                    $db_result = $db_conn->query($sql);
                    $num=$db_result->num_rows;
                    $pages=ceil($num/20);
                    if($pages==0){
                        $pages=1;
                    }
                    if(isset($page) && $page!=''){
                        $i=20*($page-1);
                        $j=20;
                        $limit="$i,$j";



                    }
                    else{
                        $limit='0,20';

                    }
                    if(isset($tp_id)){
                        $sql="select* from user left join message on user.openid=message.openid  where message.tp_id='$tp_id' && message.display=1 order by message.create_at desc limit $limit ";
                    }
                    else{
                        $sql="select* from user left join message on user.openid=message.openid   where message.display=1 order by message.create_at desc limit $limit ";
                    }
                    $db_conn=new mysqli('localhost','root','NIUBSky3!.comr720','new_wechat');
                    if ($db_conn->connect_error) {
                        echo"<script>alert('error:Database connection failed!')</script>";


                    }
                    $db_conn->query("set names UTF8");
                    $db_result = $db_conn->query($sql);?>

                    <form id="batch2" method="post"  action="index.php?m=admin&a=wc_NotOnWallIds&tp_id=<?=$tp_id?>">
                   <? while($info=$db_result->fetch_assoc()){






                    ?>
                <tr>
                    <td><input type=checkbox name=batchID[] value="<?= $info['id']?>"></td>
                    <td><?=$info['tp_id']?></td>
                    <td><?=$info['msg']?></td>
                    <td><?=$info['msg_type']?></td>
                    <td><?=$info['nickname']?></td>
                    <td><img src="<?=$info['headimgurl']?>" width="50px" height="50px"/></td>
                    <td><?php if($info['display']==1){
                            ?> <a class="btn btn-success btn-xs"><?echo L('On_the_wall')?></a>

                        <?}else{?>
                            <a class="btn  btn-danger btn-xs"><?echo L('Not_on_the_wall')?></a>

                        <?php }?></td>
                    <td><?=date('Y-m-d H:i:s',$info['create_at'])?></td>
                    <td>
                        <a href="index.php?m=admin&a=wcMsg_del&tp_id=<?=$tp_id?>&id=<?=$info['id']?>" class="btn btn-danger btn-xs"><? echo L('delete')?></a>&nbsp;&nbsp;&nbsp;
                        <?php if($info['display']==0){
                            ?> <a href="index.php?m=admin&a=wc_onWall&tp_id=<?=$tp_id?>&id=<?=$info['id']?>" class="btn btn-success btn-xs"><?echo L('do_on')?></a>

                        <?}else{?>
                            <a href="index.php?m=admin&a=wc_NotOnWall&tp_id=<?=$tp_id?>&id=<?=$info['id']?>" class="btn  btn-danger btn-xs"><?echo L('cancel')?></a>

                        <? }?></td>
                </tr>
                <?}
                }

                ?>
                <tr><?

                    $prev=$page-1;
                    $next=$page+1;
                    $last=$pages;
                    if($page>1) {

                        ?>
                        <a href="index.php?m=admin&c=index&tpl=wechat_active&page=1&tp_id=<?=$tp_id?>" class="btn btn-success btn-xs" ><? echo L('FirstPage')?></a>
                        <a href="index.php?m=admin&c=index&tpl=wechat_active&page=<? echo $page-1;?>&tp_id=<?=$tp_id?>" class="btn btn-success btn-xs" ><? echo L('Previous')?></a>

                    <?}
                    if($page<$last){?>
                    <a href="index.php?m=admin&c=index&tpl=wechat_active&page=<? echo $page+1;?>&tp_id=<?=$tp_id?>" class="btn  btn-danger btn-xs"><? echo L('NextPage')?><a/>
                        <a href="index.php?m=admin&c=index&tpl=wechat_active&page=<? echo $last?>&tp_id=<?=$tp_id?>" class="btn  btn-danger btn-xs"><? echo L('LastPage')?><a/>
                            <?} ?>

                            &nbsp;&nbsp;&nbsp;<? echo L('currentPage'); if(isset($page) ){echo$page; }else{echo 1;}?>&nbsp;&nbsp;&nbsp;<?echo L('totalPage');echo $pages;?>&nbsp;&nbsp;&nbsp;<? echo L('batch')?>:&nbsp;&nbsp;&nbsp;
                            <!-- <a onclick="document.getElementById('batch1').submit()"  class="btn btn-success btn-xs"><?//echo L('do_on')?></a>-->

                            <a onclick="document.getElementById('batch2').submit()"  class="btn  btn-danger btn-xs"><?echo L('cancel')?></a>


                </tr>
                </form>


            </table>

        </div>
    </div>
</div><!-- 结束-->



<footer><? echo L('copyright')?></footer>






<!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.page-content -->
</div><!-- /.main-content -->

<div class="ace-settings-container" id="ace-settings-container">
    <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
        <i class="icon-cog bigger-150"></i>
    </div>

    <div class="ace-settings-box" id="ace-settings-box">
        <div>
            <div class="pull-left">
                <select id="skin-colorpicker" class="hide">
                    <option data-skin="default" value="#438EB9">#438EB9</option>
                    <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                    <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                    <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                </select>
            </div>
            <span>&nbsp; 选择皮肤</span>
        </div>

        <div>
            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
            <label class="lbl" for="ace-settings-navbar"> 固定导航条</label>
        </div>

        <div>
            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
            <label class="lbl" for="ace-settings-sidebar"> 固定滑动条</label>
        </div>

        <div>
            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
            <label class="lbl" for="ace-settings-breadcrumbs">固定面包屑</label>
        </div>

        <div>
            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
            <label class="lbl" for="ace-settings-rtl">切换到左边</label>
        </div>

        <div>
            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
            <label class="lbl" for="ace-settings-add-container">
                切换窄屏
                <b></b>
            </label>
        </div>
    </div>
</div><!-- /#ace-settings-container -->
</div><!-- /.main-container-inner -->

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->

<script src="./faeriesCMS/modules/admin/templates/assets/js/jquery.min.js"></script>

<!-- <![endif]-->

<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

<!--[if !IE]> -->

<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo adminSTATICS_PATH?>assets/js/jquery-2.0.3.min.js'>"+"<"+"script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='./faeriesCMS/modules/admin/templates/assets/js/jquery-1.10.2.min.js'>"+"<"+"script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='<?php echo adminSTATICS_PATH?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
</script>
<script src="<?php echo adminSTATICS_PATH?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo adminSTATICS_PATH?>assets/js/typeahead-bs2.min.js"></script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
<script src="./faeriesCMS/modules/admin/templates/assets/js/excanvas.min.js"></script>
<![endif]-->

<script src="<?php echo adminSTATICS_PATH?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo adminSTATICS_PATH?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo adminSTATICS_PATH?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo adminSTATICS_PATH?>assets/js/jquery.easy-pie-chart.min.js"></script>
<script src="<?php echo adminSTATICS_PATH?>assets/js/jquery.sparkline.min.js"></script>
<script src="<?php echo adminSTATICS_PATH?>assets/js/flot/jquery.flot.min.js"></script>
<script src="<?php echo adminSTATICS_PATH?>assets/js/flot/jquery.flot.pie.min.js"></script>
<script src="<?php echo adminSTATICS_PATH?>assets/js/flot/jquery.flot.resize.min.js"></script>

<!-- ace scripts -->

<script src="<?php echo adminSTATICS_PATH?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo adminSTATICS_PATH?>assets/js/ace.min.js"></script>

<!-- inline scripts related to this page -->

<script type="text/javascript">
    jQuery(function($) {
        $('.easy-pie-chart.percentage').each(function(){
            var $box = $(this).closest('.infobox');
            var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
            var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
            var size = parseInt($(this).data('size')) || 50;
            $(this).easyPieChart({
                barColor: barColor,
                trackColor: trackColor,
                scaleColor: false,
                lineCap: 'butt',
                lineWidth: parseInt(size/10),
                animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
                size: size
            });
        })

        $('.sparkline').each(function(){
            var $box = $(this).closest('.infobox');
            var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
            $(this).sparkline('html', {tagValuesAttribute:'data-values', type: 'bar', barColor: barColor , chartRangeMin:$(this).data('min') || 0} );
        });




        var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
        var data = [
            { label: "social networks",  data: 38.7, color: "#68BC31"},
            { label: "search engines",  data: 24.5, color: "#2091CF"},
            { label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
            { label: "direct traffic",  data: 18.6, color: "#DA5430"},
            { label: "other",  data: 10, color: "#FEE074"}
        ]
        function drawPieChart(placeholder, data, position) {
            $.plot(placeholder, data, {
                series: {
                    pie: {
                        show: true,
                        tilt:0.8,
                        highlight: {
                            opacity: 0.25
                        },
                        stroke: {
                            color: '#fff',
                            width: 2
                        },
                        startAngle: 2
                    }
                },
                legend: {
                    show: true,
                    position: position || "ne",
                    labelBoxBorderColor: null,
                    margin:[-30,15]
                }
                ,
                grid: {
                    hoverable: true,
                    clickable: true
                }
            })
        }
        drawPieChart(placeholder, data);

        /**
         we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
         so that's not needed actually.
         */
        placeholder.data('chart', data);
        placeholder.data('draw', drawPieChart);



        var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
        var previousPoint = null;

        placeholder.on('plothover', function (event, pos, item) {
            if(item) {
                if (previousPoint != item.seriesIndex) {
                    previousPoint = item.seriesIndex;
                    var tip = item.series['label'] + " : " + item.series['percent']+'%';
                    $tooltip.show().children(0).text(tip);
                }
                $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
            } else {
                $tooltip.hide();
                previousPoint = null;
            }

        });






        var d1 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.5) {
            d1.push([i, Math.sin(i)]);
        }

        var d2 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.5) {
            d2.push([i, Math.cos(i)]);
        }

        var d3 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.2) {
            d3.push([i, Math.tan(i)]);
        }


        var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
        $.plot("#sales-charts", [
            { label: "Domains", data: d1 },
            { label: "Hosting", data: d2 },
            { label: "Services", data: d3 }
        ], {
            hoverable: true,
            shadowSize: 0,
            series: {
                lines: { show: true },
                points: { show: true }
            },
            xaxis: {
                tickLength: 0
            },
            yaxis: {
                ticks: 10,
                min: -2,
                max: 2,
                tickDecimals: 3
            },
            grid: {
                backgroundColor: { colors: [ "#fff", "#fff" ] },
                borderWidth: 1,
                borderColor:'#555'
            }
        });


        $('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('.tab-content')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            var w2 = $source.width();

            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            return 'left';
        }


        $('.dialogs,.comments').slimScroll({
            height: '300px'
        });


        //Android's default browser somehow is confused when tapping on label which will lead to dragging the task
        //so disable dragging when clicking on label
        var agent = navigator.userAgent.toLowerCase();
        if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
            $('#tasks').on('touchstart', function(e){
                var li = $(e.target).closest('#tasks li');
                if(li.length == 0)return;
                var label = li.find('label.inline').get(0);
                if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
            });

        $('#tasks').sortable({
                opacity:0.8,
                revert:true,
                forceHelperSize:true,
                placeholder: 'draggable-placeholder',
                forcePlaceholderSize:true,
                tolerance:'pointer',
                stop: function( event, ui ) {//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
                    $(ui.item).css('z-index', 'auto');
                }
            }
        );
        $('#tasks').disableSelection();
        $('#tasks input:checkbox').removeAttr('checked').on('click', function(){
            if(this.checked) $(this).closest('li').addClass('selected');
            else $(this).closest('li').removeClass('selected');
        });


    })
</script>


</body>
</html>
