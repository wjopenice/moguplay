<?php if (!defined('THINK_PATH')) exit();?><!--公共头部-->
<!DOCTYPE html>
<html lang="en">
<head>
     <title><?php echo C('PC_SET_TITLE');?></title>   
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="renderer" content="webkit">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
   <meta name="keywords" content="<?php echo C('WEB_SITE_KEYWORD');?>">   
   <meta name="description" content="<?php echo C('WEB_SITE_DESCRIPTION');?>">  
    <link rel="stylesheet" href="/Public/Media/css/base.css">
    <link rel="stylesheet" href="/Public/Media/css/index.css">
    <link rel="stylesheet" href="/Public/Media/css/bannercss/slider.css">
    <link rel="icon" href="/Public/Media/image/favicon.ico"/>
    <script src="/Public/Media/js/jquery-1.11.1.min.js"></script>
    <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "https://hm.baidu.com/hm.js?bc19aa51515f215def6b091f540c83ea";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
        })();
    </script>
    <!-- 如果是个人中心则显示个人中心的导航 -->
</head>
<body>
<!--头部-->
<div class="top " id="topPart">
    <div class="container">
        <div class="top-r">
            <a href="<?php echo U('Public/login');?>" id="entry">登录 &nbsp;|&nbsp;</a>
            <a href="<?php echo U('Public/register');?>" id="enroll">注册</a>
        </div>
    </div>
</div>

<!--导航-->
<div class="header clearfix" id="navBar">
    <div class="center cf">
        <div class="logoBar fl cf">
            <h1 class="header-l">
                <a href="<?php echo U('Index/index');?>" class="logo"><img src="/Public/Media/image/header/logo.png" alt="手上科技"></a>
            </h1>
            <div class="header-r">
                <input  class="sousuo" type="text" placeholder="请输入关键词" id="com_input" />
                <span class="icon-search" id="com_search"></span>
            </div>
        </div>
        <div class="header-c fl">
            <ul class="list cf">
                <li class="active"><a href="<?php echo U('Index/index');?>" >首页</a> </li>
                <li><a href="<?php echo U('Game/youxi');?>">游戏中心</a></li>
                <li><a href="<?php echo U('Gift/index');?>">礼包中心</a></li>
                <li><a href="<?php echo U('Exchange/index');?>">兑换中心</a></li>
                <li><a href="<?php echo U('Category/zixun');?>">资讯中心</a></li>
                <li><a href="<?php echo U('Recharge/chongzhi');?>">充值中心</a></li>
                <li><a href="<?php echo U('Service/kefu');?>">客服中心</a></li>
            </ul>
        </div>
    </div>
</div>


<?php if(CONTROLLER_NAME == Member): ?><!--banner 区域-->
<div class="pc_banner">
    <div class="container">
      <!--   <p>当前位置：个人中心</p> -->
    </div>
</div>

<!--个人中心的内容部分-->

<div class="pc_main">
        <div id="pc_main_title_bg">
        <div id="pc_main_title">
            <ul class="container" >
                <li><a href="<?php echo U('Member/personalcenter');?>"><img src="/Public/Media/image/personalcenter/baseinfo/jibenxinxi_1.png"/></a></li>
                <li><a href="<?php echo U('Member/pcsafecenter');?>"><img src="/Public/Media/image/personalcenter/baseinfo/anquanzhongxin_2.png"/></a></li>
                <li><a href="<?php echo U('Member/pcmessage');?>"><img src="/Public/Media/image/personalcenter/baseinfo/xinxizhongxin_2.png"/></a></li>
                <li><a href="<?php echo U('Member/pctrade');?>"><img src="/Public/Media/image/personalcenter/baseinfo/jiaoyijilv_1.png"/></a></li>
                <li class="last"><a href="<?php echo U('Member/pcaccountyue');?>"><img src="/Public/Media/image/personalcenter/baseinfo/zhanghuyue_1.png"/></a></li>
            </ul>
        </div>
    </div>
    <?php else: endif; ?>

    <script>

        $(document).on("click",'.header-c li',function(){
            $(this).addClass('active').siblings().removeClass('active');
        });


    var ACTION_STR = '/media.php?s=/Member/pctrade';
    var MODULE = "/media.php?s=";
    var letter_number = "<?php echo ($letter_number); ?>";
    
    var navItem =  ACTION_STR.substring(ACTION_STR.lastIndexOf('/')+1);
    if(navItem == 'yxchildren'){
        navItem ='youxi';
    }
    var pcImgArr=[
            ["/Public/Media/image/personalcenter/baseinfo/jibenxinxi_1.png","/Public/Media/image/personalcenter/baseinfo/jibenxinxi_2.png"],
            ["/Public/Media/image/personalcenter/baseinfo/anquanzhongxin_1.png","/Public/Media/image/personalcenter/baseinfo/anquanzhongxin_2.png"],
            ["/Public/Media/image/personalcenter/baseinfo/xinxizhongxi_1.png","/Public/Media/image/personalcenter/baseinfo/xinxizhongxin_2.png"],
            ["/Public/Media/image/personalcenter/baseinfo/jiaoyijilv_2.png","/Public/Media/image/personalcenter/baseinfo/jiaoyijilv_1.png"],
            ["/Public/Media/image/personalcenter/baseinfo/zhanghuyue_2.png","/Public/Media/image/personalcenter/baseinfo/zhanghuyue_1.png"]
    ];
    pcUrlArr=[
            ["personalcenter"],
            ["pcsafecenter","bindphone","bindemail","noidcard","nobindphone","nobindemail","idcard","bindemailfinish"],
            ["pcmessage","pcmsgunread","pcmsghasread","detail"],
            ["pctrade","pctradexf"],
            ["pcaccountyue"]
    ];   
    for(var i=0;i<pcUrlArr.length;i++){
        $("#pc_main_title").find("li").eq(i).find("img").attr("src",pcImgArr[i][1]);

        if($.inArray(navItem, pcUrlArr[i])!=-1){
            $("#pc_main_title").find("li").eq(i).find("img").attr("src",pcImgArr[i][0]);
        }
    }

</script>

<script src="/Public/Media/js/pop.js"></script>
<script src="/Public/Media/js/js.js"></script>


    <link rel="stylesheet" href="/Public/Media/css/personalcenter.css">
    <link rel="stylesheet" href="/Public/Media/css/comboselect.css">
    <link rel="stylesheet" href="/Public/Media/css/pctrade.css">
    <link rel="stylesheet" type="text/css" href="/Public/Media/css/jquery.datetimepicker.css"/>
    <style>
        #dowebok2,#dowebok3,#dowebok4{ width: 140px;height:30px; font-size:12px;color:#ccc;  }
        #pc_main_con .trade_record .title span{float: left;width:21px;height: 21px;margin:15px 20px 0 20px;background-image: url(/Public/Media/image/personalcenter/pcsprits.png) ; background-repeat:no-repeat ;
        }
       
    </style>
    <div id="pc_main_con" >       
        <div class="trade_record">
            <div class="title">
                  <span style=" background-position:  -124px 0;"></span>交易记录
            </div>
            <div class="content clearfix">
                <div class="con_l" id="trade_tab">
                    <ul>
                        <li class="current"><a href="#" name="czjl"><span style="background: url(/Public/Media/image/personalcenter/pcsprits.png) no-repeat -126px -34px;"></span>充值记录</a></li>
                        <li><a href="<?php echo U('pctradexf');?>"><span style="background: url(/Public/Media/image/personalcenter/pcsprits.png) no-repeat -85px -70px;"></span>消费记录</a></li> 
                        <li><a href="<?php echo U('points');?>"><span style="background: url(/Public/Media/image/personalcenter/pcsprits.png) no-repeat -84px -107px;"></span>积分记录</a></li>
                    </ul>
                </div>
                <div class="con_r  clearfix" id="trade_con" >
                    <div class="con_r_cz">
                        <ul class="trade_con_tab clearfix" id="change">
                            <li class="current" id="0"><a href="javascript:;">平台币</a></li>
                            <li id="1"><a href="javascript:;">绑定平台币</a></li>
                        </ul>
                        <div class="trade_con_item" >
                            <div class="clearfix search" id="option1">
                                <div class="time">
                                    <span class="cz_time"> 充值时间&nbsp;:</span>
                                    <input type="text"  value="开始时间" class="start"/>
                                    <span>—</span>
                                    <input type="text"  value="结束时间" class="end"/>
                                </div>
                                <div class="chose_game"  style="background: url(/Public/Media/image/personalcenter/trade/jiantou.png) no-repeat right center">
                                    选择游戏                        
                                </div>
                                <div  id="dowebok2" class="pay">
                                    <select >
                                        <option value="6">充值方式</option>
                                        <option value="1">支付宝</option>
                                        <option value="2">微信</option>
                                        <option value="4">渠道代充</option>
                                        
                                    </select>
                                </div>
                               <div class="search_btn" id="cz_search">
                                   <input type="button" value="搜索"/>
                               </div>
                            </div>



                            <table id="table1">
                                 <thead><tr><th class="t_1">序号</th><th class="t_2">金额(元)</th><th class="t_3">充值方式</th><th class="t_4">充值时间</th></tr></thead>
                                <tbody>


                               <?php if(is_array($data)): $i = 0; $__LIST__ = array_slice($data,$off,10,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v4): $mod = ($i % 2 );++$i;?><tr >
                                            <th class="t_1">1</th>
                                            <td class="t_2"><?php echo ($v4["pay_amount"]); ?></td>
                                            <td class="t_3">
                                           
                                            <?php if($v3['pay_way'] == 1): ?>支付宝
                                                <?php elseif($v3['pay_way'] == 2): ?>
                                                微信
                                                <?php else: ?>
                                                渠道代充<?php endif; ?>
                                                
                                            </td>
                                            <td class="t_4"><?php echo (date('Y-m-d H:i:s',$v4["create_time"])); ?></td>
                                            
                                            
                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>




                                </tbody>

                            </table>                           
            
                        </div>
                        <div class="trade_con_item">
                            <div class="clearfix search" id="option2">
                                <div class="time">
                                    <span class="cz_time"> 充值时间&nbsp;:</span>
                                    <input type="text"  value="开始时间" class="start"/>
                                    <span>—</span>
                                    <input type="text"  value="结束时间" class="end"/>
                                </div>
                                <div class="chose_game1"  id="dowebok3">
                                   
                                    <select>
                                        <option value="0">选择游戏</option>

                                        <?php if(is_array($game_list)): $i = 0; $__LIST__ = $game_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v0): $mod = ($i % 2 );++$i; if($_GET['game']== $v0.game_id): ?><option value="<?php echo ($v0["game_id"]); ?>" selected="selected"><?php echo ($v0["game_name"]); ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo ($v0["game_id"]); ?>"><?php echo ($v0["game_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                                <div  id="dowebok4" class="pay">
                                    <select >
                                        <option value="6">充值方式</option>
                                        <option value="4">渠道代充</option>
                                        <option value="5">平台代充</option>
                                    </select>
                                </div>
                               <div class="search_btn" id="cz_search2">
                                   <input type="button" value="搜索"/>
                               </div>
                            </div>



                            <table id="table2">
                                <thead><tr><th class="t_1">游戏名称</th><th class="t_2">金额</th><th class="t_3">充值方式</th><th class="t_4">充值时间</th></thead>
                                <tbody>

                                 <?php if(is_array($movebang_data)): $i = 0; $__LIST__ = $movebang_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v3): $mod = ($i % 2 );++$i;?><tr class=>
                                            <td class="t_1"><?php echo ($v3["game_name"]); ?></td>
                                            <td class="t_2"><?php echo ($v3["pay_amount"]); ?></td>
                                            
                                            <td class="t_3">
                                            
                                            <?php if($v3['pay_way'] == 1): ?>支付宝
                                                <?php elseif($v3['pay_way'] == 4): ?>
                                                渠道代充
                                                <?php elseif($v3['pay_way'] == 5): ?>
                                                平台代充<?php endif; ?>
                                                
                                                
                                            </td>
                                            
                                            <td class="t_4"><?php echo (date('Y-m-d H:i:s',$v3["create_time"])); ?></td>
                                            
                                            
                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                
                                </tbody>
                            </table>

                           
                           
                        </div>
                        <div id="pagation" class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

</div>
<div style="display: none;" id="rocket-to-top">
    <div style="opacity:0;display: block;" class="level-2"></div>
    <div class="level-3"></div>
</div>
</body>
<script src="/Public/Media/js/jquery-1.11.1.min.js"></script>
<script src="/Public/Media/js/jquery.datetimepicker.full.js"></script>
<script src="/Public/Media/js/jquery.combo.select.js"></script>
<script src="/Public/Media/js/pagation.js"></script>
<script>
    $("#table1").find("tbody").find("tr").each(function(){
        $(this).find(".t_1").html($(this).index()+1);
    })
</script>

<script>
    $(function() {       
         $("#dowebok3").find('select').comboSelect();
    });
</script>
<script>
$(function(){  

    

	function get_unix_time(dateStr){
		    var newstr = dateStr.replace(/-/g,'/'); 
		    var date =  new Date(newstr); 
		    var time_str = date.getTime().toString();
		    return time_str.substr(0, 10);
	}  
    function showDateTime(time){
            $.datetimepicker.setLocale('ch');
            $('.'+time).datetimepicker({
                'format': 'Y-m-d',
                'timepicker':false,
                'maxDate':0,
                'scrollInput':false,
                'validateOnBlur':false
            })
    }   
    var type = <?php echo ((isset($_GET['type']) && ($_GET['type'] !== ""))?($_GET['type']):0); ?>;
    var ksTime="<?php echo ((isset($_GET['startTime']) && ($_GET['startTime'] !== ""))?($_GET['startTime']):'开始时间'); ?>";
    var jsTime="<?php echo ((isset($_GET['endTime']) && ($_GET['endTime'] !== ""))?($_GET['endTime']):'结束时间'); ?>"; 
    var gameBh="<?php echo ((isset($_GET['game']) && ($_GET['game'] !== ""))?($_GET['game']):0); ?>";
    var zfBh="<?php echo ((isset($_GET['payStyles']) && ($_GET['payStyles'] !== ""))?($_GET['payStyles']):6); ?>";

  
    var aLi=document.getElementById("change").getElementsByTagName('li');
        for(var i=0;i<aLi.length;i++){
                for(var j=0;j<aLi.length;j++){                   
                    aLi[j].className = "";
                }        
        }
        $('#'+type).addClass('current');    

    function znTime(id){   	
        $("#"+id).find('.start').click(function(){
        	 var sTime= $("#"+id).find('.start').val() == "开始时间" ? "" :$("#"+id).find('.start').val();
        	 var eTime= $("#"+id).find('.end').val() == "结束时间" ? "" :$("#"+id).find('.end').val();
        	 if(eTime!=""){  
        	 	 $.datetimepicker.setLocale('ch');
           		 $("#"+id).find('.start').datetimepicker({
	                'format': 'Y-m-d',
	                'timepicker':false,
	                'maxDate':eTime
           		 })
        	 	}       	 	
        }) 

        $("#"+id).find('.end').click(function(){
        	 var sTime= $("#"+id).find('.start').val() == "开始时间" ? "" :$("#"+id).find('.start').val();
        	 var eTime= $("#"+id).find('.end').val() == "结束时间" ? "" :$("#"+id).find('.end').val();        	
        	 if(sTime!=""){
        	 	 $.datetimepicker.setLocale('ch');
           		 $("#"+id).find('.end').datetimepicker({
	                'format': 'Y-m-d',
	                'timepicker':false,
	                'minDate':sTime
           		 })
    	 	 }      	 	
        })

   }
    if(type==0){
    	znTime("option1");
        $("#trade_con").find(".trade_con_item").hide();
        $("#trade_con").find(".trade_con_item").eq(0).show();       
        showDateTime('start')
        showDateTime('end');
        $("#option1").find(".start").val(ksTime);
        $("#option1").find(".end").val(jsTime);
        $("#dowebok2").find('select option[value='+zfBh+']').attr("selected","selected");
        $("#dowebok2").find('select').comboSelect();      
        var dataLength=<?php echo ((isset($count) && ($count !== ""))?($count):0); ?>;
        var pageSize=10;
        var allPageNum=dataLength%pageSize==0 ? parseInt(dataLength/pageSize):(parseInt(dataLength/pageSize)+1);
        var p =<?php echo ((isset($_GET['p']) && ($_GET['p'] !== ""))?($_GET['p']):1); ?>;  
        if(dataLength>pageSize){        
            page({
                id : 'pagation',
                nowNum : p,
                allNum : allPageNum,
                callBack : function(now,all){       
                    var sTime= $("#option1").find('.start').val() == "开始时间" ? "" :$("#option1").find('.start').val();
                    var eTime= $("#option1").find('.end').val() == "结束时间" ? "" :$("#option1").find('.end').val();
                    var pay_way_num = parseInt($("#dowebok2").find("select").val());
                    window.location.href='/media.php?s=/Member/pctrade/type/'+type+'/p/'+now+'/pagesize/'+pageSize+'/startTime/'+sTime+'/endTime/'+eTime+'/payStyles/'+pay_way_num+'.html';            
                }
            });
        }else{
            $("#pagation").css("display","none");
        }
        if($("#pagation").find(".jump").length>0){
        $("#pagation").find(".aBtns").css('padding',"0 0 0 150px");
        }else{
            $("#pagation").find(".aBtns").css('padding',"0 0 0 260px");
        }

        $("#cz_search").find("input").bind('click', function () {
            var sTime= $("#option1").find('.start').val() == "开始时间" ? "" :$("#option1").find('.start').val();
            var eTime= $("#option1").find('.end').val() == "结束时间" ? "" :$("#option1").find('.end').val();
            var pay_way_num = parseInt($("#dowebok2").find("select").val()); 
            window.location.href='/media.php?s=/Member/pctrade/type/'+type+'/p/1/pagesize/'+pageSize+'/startTime/'+sTime+'/endTime/'+eTime+'/payStyles/'+pay_way_num+'.html';
        });

    }

    if(type==1){  
       znTime("option2");   
       $("#trade_con").find(".trade_con_item").hide();
       $("#trade_con").find(".trade_con_item").eq(1).show();
        showDateTime('start');
        showDateTime('end');        
        $("#option2").find(".start").val(ksTime);        
        $("#option2").find(".end").val(jsTime);       
        $("#dowebok4").find('select option[value='+zfBh+']').attr("selected","selected");
        $("#dowebok4").find('select').comboSelect();       
        $("#dowebok3").find('select option[value='+gameBh+']').attr("selected","selected");
        $("#dowebok3").find('select').comboSelect();
        var dataLength=<?php echo ((isset($count) && ($count !== ""))?($count):0); ?>;
        var pageSize=10;
        var allPageNum=dataLength%pageSize==0 ? parseInt(dataLength/pageSize):(parseInt(dataLength/pageSize)+1);
        var p =<?php echo ((isset($_GET['p']) && ($_GET['p'] !== ""))?($_GET['p']):1); ?>;  
        if(dataLength>pageSize){        
            page({
                id : 'pagation',
                nowNum : p,
                allNum : allPageNum,
                callBack : function(now,all){    
                    var sTime= $("#option2").find('.start').val() == "开始时间" ? "" :$("#option2").find('.start').val();
                    var eTime= $("#option2").find('.end').val() == "结束时间" ? "" :$("#option2").find('.end').val();
                    var pay_way_num = parseInt($("#dowebok4").find("select").val());
                    var game = parseInt($("#dowebok3").find("select").val());
                    window.location.href='/media.php?s=/Member/pctrade/type/'+type+'/p/'+now+'/pagesize/'+pageSize+'/startTime/'+sTime+'/endTime/'+eTime+'/game/'+game+'/payStyles/'+pay_way_num+'.html';              
                }
            });
        }else{
            $("#pagation").css("display","none");
        }
        if($("#pagation").find(".jump").length>0){
        $("#pagation").find(".aBtns").css('padding',"0 0 0 150px");
        }else{
            $("#pagation").find(".aBtns").css('padding',"0 0 0 260px");
        }
          $("#cz_search2").find("input").bind('click', function () {
            var sTime= $("#option2").find('.start').val() == "开始时间" ? "" :$("#option2").find('.start').val();
            var eTime= $("#option2").find('.end').val() == "结束时间" ? "" :$("#option2").find('.end').val();
            var pay_way_num = parseInt($("#dowebok4").find("select").val());
           var game = parseInt($("#dowebok3").find("select").val());
            window.location.href='/media.php?s=/Member/pctrade/type/'+type+'/p/1/pagesize/'+pageSize+'/startTime/'+sTime+'/endTime/'+eTime+'/game/'+game+'/payStyles/'+pay_way_num+'.html';
        });
    }  
     for(var i=0;i<aLi.length;i++){
        aLi[i].index=i;
        aLi[i].onclick=function () {
            var type2= aLi[this.index].getAttribute('id');           
            if(type != type2){
                p=1;
            }            
            window.location.href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/media.php?s=/Member/pctrade/type/"+type2+"/p/"+p+"/pagesize/"+pageSize+'.html';        
        };
    }

})

</script>

</html>




<!--尾巴部分-->
<div class="footer clearfix"> 
    <div class="banxin cf">
        <div class="bannerLogo"></div>
        <div class="footer-t fl">
            <p>
                <a href="<?php echo U('Category/zxchildren/id/35');?>" target="_blank">关于我们 ｜  </a>
                <a href="<?php echo U('Category/zxchildren/id/36');?>" target="_blank">商务合作 ｜  </a>
                <a href="<?php echo U('Category/zxchildren/id/37');?>" target="_blank">合作伙伴 ｜  </a>
                <a href="<?php echo U('Service/kefu');?>" target="_blank">客服帮助</a>
            </p>
            <p>
                <a href="<?php echo U('Index/regareement');?>" target="_blank">注册协议｜ </a>
                <a href="<?php echo U('Public/register');?>" target="_blank">防沉迷系统 ｜ </a>
                <a href="<?php echo U('Category/zxchildren/id/38');?>" target="_blank">未成年家长监护工程 ｜ </a>
                <a href="<?php echo U('Index/interareement');?>" target="_blank">《网络游戏服务格式化协议必备条款》 </a>
            </p>
            <p>
                <a href="javascript:;">
                    广州手上科技有限公司 版权所有 2016 game-pk.com
                </a>
            </p>
            <p><a href="javascript:;">网站备案：粤ICP备17125681号</a></p>
        </div>
        <div class="workTime cf">
            <p class="eachWork fl"><span class="workTit">工作时间：</span><span class="workCon">10:00 -- 21:00</span></p>
            <p class="eachWork fl"><span class="workTit">服务时间：</span><span class="workCon">010-85655922</span></p>
            <p class="eachWork fl"><span class="workTit">&nbsp;</span><span class="workCon">18301467532</span></p>
            <p class="eachWork fl"><span class="workTit">客服 QQ：</span><span class="workCon">2305194405</span></p>
        </div>
    </div>
</div>

<script>
    $(function(){
        function placeholder(input,text){
            input.value=text;
            input.onfocus=function(){
                if(this.value==text){
                    this.value='';
                }
            };
            input.onblur=function(){
                if(this.value==''){
                    this.value=text;
                }
            };
        };
        var ocom_input=document.getElementById("com_input");
        var $input=$("#com_input");
        var $search=$("#com_search");

        $search.click(function(){
            var txt= $.trim($input.val());
            if(txt == ''){
                window.location.href="<?php echo U('Game/yx_fenlei');?>";
            }else{
                // window.location.href="yxfenli.html?keyword="+txt;
                window.location.href="/media.php?s=/"+"Game/yx_fenlei/keyword/"+txt;
            }
            /*$.ajax({
             type: 'POST',
             async: true,
             dataType: 'json',
             url: "<?php echo U('search_keyword');?>",//提交给后台的地址
             data: {
             keyword:txt
             },
             success: function (data) {

             },
             error: function () {
             alert('服务器故障，稍后再试');


             }
             });*/
        });
        $("#com_input").keydown(function (e) {
            if (e.which == 13) {
                $('#com_search').trigger("click");//触发搜索按钮的点击事件
            }
        });

    })
</script>
<script type="text/javascript">
    
     
    var CON = "<?php echo (CONTROLLER_NAME); ?>";
    var navArr=["Index","Game","Gift","Exchange","Category","Recharge","Service"];
    var navImg=[       
        [
            "url(/Public/Media/image/header/navbar.png) no-repeat -124px -16px",
            "url(/Public/Media/image/header/navbar.png) no-repeat -124px -45px"
        ],
        [
            "url(/Public/Media/image/header/navbar.png) no-repeat -12px  -17px",
            "url(/Public/Media/image/header/navbar.png) no-repeat -12px -45px"
        ],
        [
            "url(/Public/Media/image/header/navbar.png) no-repeat -161px -15px",
            "url(/Public/Media/image/header/navbar.png) no-repeat -161px -43px"
        ],
        [
            "url(/Public/Media/image/header/navbar.png) no-repeat -261px  -15px",
            "url(/Public/Media/image/header/navbar.png) no-repeat -261px -45px"
        ],
        [
            "url(/Public/Media/image/header/navbar.png) no-repeat -53px  -14px",
            "url(/Public/Media/image/header/navbar.png) no-repeat -53px -45px"
        ],
        [
            "url(/Public/Media/image/header/navbar.png) no-repeat -198px -17px",
            "url(/Public/Media/image/header/navbar.png) no-repeat -198px -46px"
        ],
        [
            "url(/Public/Media/image/header/navbar.png) no-repeat -94px  -15px",
            "url(/Public/Media/image/header/navbar.png) no-repeat -94px -45px"
        ]
        
    ];

    for(var i=0;i<navArr.length;i++){
        $(".header-c").find("ul").find("li").eq(i).removeClass('active');
//        $(".header-c").find("ul").find("li").css("color","#666");
//        $(".header-c").find("li").eq(i).find("span").css("background",navImg[i][0]);

        if(CON == $.trim(navArr[i])){
            $(".header-c").find("li").eq(i).addClass('active');
//            $(".header-c").find("li").eq(i).find("a").css("color","#ED6557");
//            $(".header-c").find("li").eq(i).find("span").css("background",navImg[i][1]);
        }
    }

//    $(".header-c").find("ul").find("li").each(function(){
//        var index=$(this).index();
//        $(this).hover(function(){
//            $(this).find("span").css("background",'url('+navImg[index][1]+')');
//
//        },function(){
//             if(CON == $.trim(navArr[index])){
//            $(".header-c").find("li").eq(index).find("a").css("color","#ED6557");
//            $(this).find("span").css("background",'url('+navImg[index][1]+')');
//        }else{
//            $(this).find("span").css("background",'url('+navImg[index][0]+')');
//        }
//        })
//    });
</script>

<script>
    $(function(){
        $(window).scroll(function () {
    //1 页面滚动时获取卷曲高度
            var h = $(this).scrollTop();
    //获取头部的高度
            var tophead = $("#topPart").height();
            var navHeight = $("#navBar").height();
            if (h > tophead) {
    //让导航部定位
                $("#navBar").addClass("fixed");
            } else {
                $("#navBar").removeClass("fixed");
            }
        })

    });
</script>