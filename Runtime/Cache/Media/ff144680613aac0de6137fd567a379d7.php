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
    <style>
        .marginBar{margin-bottom: 158px;}
    </style>
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
                <li><a href="<?php echo U('Recharge/chooseChongzhi');?>">充值中心</a></li>
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


    var ACTION_STR = '/media.php?s=/Category/zixun';
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


<link rel="stylesheet" href="/Public/Media/css/zixun.css">  
    <style>
        #pagation{text-align:center;width:1200px;margin: 0 auto ;position:relative;padding-bottom:80px;}

        #pagation .aBtns{
            float:left;
            padding-left:50px;
        }
        #pagation .aBtns a{
            text-decoration: none;
            font-size:14px;color:#4c4c4c;
            display: inline-block;padding:5px 10px;
            background:#fff;margin:0 5px;float:left;
            cursor: pointer;
        }
        #pagation .aBtns a.active{
            color:#fff;
            background:#00C9E1;
        }
        #pagation .jump{
            float:right; font-size:14px;color:#4c4c4c;
            line-height:20px;
            padding-right:500px;
        }
        #pagation .jump input{
            width:40px;height:20px;border:1px solid #999;
            font-size:14px;margin:3px 3px 0 10px;
        }
        #pagation .jump span{
            display: inline-block;color:#4c4c4c;
            font-size:14px;padding:5px 10px;cursor: pointer;
        }

    </style>
    <script type="text/javascript">
        var p ="<?php echo ($_GET['p']); ?>";
    </script>

<!--banner-->
<div class="pic clearfix">
        <div class="pic1">
            <a href="javascript:;"  target="<?php echo ($left_top['0']['target']); ?>"><img src="<?php echo (get_cover($left_top['0']['data'],'path')); ?>" alt=""></a>
            <div class="show">
                <div class="show-content">
                    <!--<a href="<?php echo ($left_top['0']['url']); ?>"><?php echo ($left_top['0']['title']); ?></a>-->
                    <a href="javascript:void(0)"><?php echo ($left_top['0']['title']); ?></a>
                </div>
            </div>
        </div>
        <div class="pic2">
            <div class="pic2-t">
                <a class="one" href="javascript:; "  target="<?php echo ($mid_top['0']['target']); ?>"><img src="<?php echo (get_cover($mid_top['0']['data'],'path')); ?>" alt=""></a>
                <div class="show">
                    <!--<a href="<?php echo ($mid_top['0']['url']); ?>"><?php echo ($mid_top['0']['title']); ?></a>-->
                    <a href="javascript:void(0)"><?php echo ($mid_top['0']['title']); ?></a>
                </div>
            </div>
           <div class="pic2-b">
               <a class="two" href="javascript:;"  target="<?php echo ($mid_top['1']['target']); ?>"><img src="<?php echo (get_cover($mid_top['1']['data'],'path')); ?>" alt=""></a>
               <div class="show">
                   <!--<a href="<?php echo ($mid_top['1']['url']); ?>"><?php echo ($mid_top['1']['title']); ?></a>-->
                   <a href="javascript:void(0)"><?php echo ($mid_top['1']['title']); ?></a>
               </div>
           </div>

        </div>
        <div class="pic3">
            <a href="javascript:;" target="<?php echo ($left_top['1']['target']); ?>"><img src="<?php echo (get_cover($left_top['1']['data'],'path')); ?>" alt=""></a>
            <div class="show">
                <div class="show-content">
                    <!--<a href="<?php echo ($left_top['1']['url']); ?> "><?php echo ($left_top['1']['title']); ?></a>-->
                    <a href="javascript:void(0) "><?php echo ($left_top['1']['title']); ?></a>
                </div>
            </div>
        </div>
       <div class="pic4">
           <a href="javascript:;" target="<?php echo ($rig_top['0']['target']); ?>"><img src="<?php echo (get_cover($rig_top['0']['data'],'path')); ?>" alt=""></a>
           <div class="show">
               <div class="show-content">
                   <!--<a href="<?php echo ($rig_top['0']['url']); ?>"><?php echo ($rig_top['0']['title']); ?></a>-->
                   <a href="javascript:void(0)"><?php echo ($rig_top['0']['title']); ?></a>
               </div>
           </div>
       </div>
</div>

<!--中间咨询部分-->
<div class="zixun  container clearfix">
    <div class="zixun-l">
      <!--游戏资讯  -->
        <div class="cosplay clearfix" >
            <div class="tab" id="zixunpage">
		<a href="javascript:;" class="tab3" id="42"><span class="icon-gonggao"></span>游戏公告 &nbsp;</a>
                <a href="javascript:;" class="tab1 " id="43"> / &nbsp; <span class="icon-cosplay"></span>游戏资讯 &nbsp;</a>
                <a href="javascript:;" class="tab2" id="44"> / &nbsp; <span class="icon-huodong"></span>游戏活动</a>
            </div>
            <div class="content">
                <ul>
					<!-- 公告 -->
                    <li style="display:block">
                        <div class="content-t">
                            <?php if(is_array($announcement)): $i = 0; $__LIST__ = array_slice($announcement,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v4): $mod = ($i % 2 );++$i;?><div class="content-t-t">
                                  <img src="/Public/Media/image/zixun/announcement.jpg" >
                                <div class="content-r">
                                    <a href="<?php echo U('Category/zxchildren?id='.$v4['id']);?>" title="<?php echo ($v4["title"]); ?>" target="_blank"><?php echo ($v4["title"]); ?></a>
                                    <p class="next">
                                    <!-- <?php echo msubstr($v4['content'],0,9);?>...&nbsp;&nbsp;&nbsp; -->
                                    </p>
                                    <div class="read clearfix">
                                        <a class="one" href="<?php echo U('Category/zxchildren?id='.$v4['id']);?>">阅读全文>></a>
                                        <span><?php echo (date("Y-m-d",$v4["create_time"])); ?></span>
                                    </div>
                                </div>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>

                        <div class="wenzi">
                            <?php if(is_array($announcement)): $i = 0; $__LIST__ = array_slice($announcement,3,7,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v5): $mod = ($i % 2 );++$i;?><div class="wenzi-1 clearfix">                                   
                                    <a href="<?php echo U('Category/zxchildren?id='.$v5['id']);?>" title="<?php echo ($v5["title"]); ?>" target="_blank"><?php echo ($v5["title"]); ?></a>
                                    <span><?php echo (date("Y-m-d",$v5["create_time"])); ?></span>
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </li>
                    <!-- 资讯 -->
                    <li>
                        <div class="content-t">
                            <?php if(is_array($notice)): $i = 0; $__LIST__ = array_slice($notice,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="content-t-t">
                                  <img src="/Public/Media/image/zixun/information.jpg" >
                                  <!-- <?php if(empty($vo["cover_id"])): ?><img src="/Public/Media/image/zixun/zixun_300x150.jpg" >
                                  <?php else: ?> 
                                    <img src="<?php echo (get_cover($vo["cover_id"],'path')); ?>" ><?php endif; ?>  -->
                                <div class="content-r">
                                    <a href="<?php echo U('Category/zxchildren?id='.$vo['id']);?>" title="<?php echo ($vo["title"]); ?>" target="_blank"><?php echo ($vo["title"]); ?></a>
                                    <p class="next">
                                   <!--  <?php echo msubstr($vo['content'],0,9);?>...&nbsp;&nbsp;&nbsp; -->
                                    </p>
                                    <div class="read clearfix">
                                        <a class="one" href="<?php echo U('Category/zxchildren?id='.$vo['id']);?>">阅读全文>></a>
                                        <span><?php echo (date("Y-m-d",$vo["create_time"])); ?></span>
                                    </div>
                                </div>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>

                        <div class="wenzi clearfix">
                            <?php if(is_array($notice)): $i = 0; $__LIST__ = array_slice($notice,3,7,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><div class="wenzi-1">                               
                                <a href="<?php echo U('Category/zxchildren?id='.$v1['id']);?>" title="<?php echo ($v1["title"]); ?>" target="_blank"><?php echo ($v1["title"]); ?></a>
                                <span><?php echo (date("Y-m-d",$v1["create_time"])); ?></span>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </li>

                    <!-- 活动 -->
                    <li>
                        <div class="content-t">
                            <?php if(is_array($activity)): $i = 0; $__LIST__ = array_slice($activity,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?><div class="content-t-t">
                                   <img src="/Public/Media/image/zixun/activity.jpg" >
                                  <!--  <?php if(empty($v2["cover_id"])): ?><img src="/Public/Media/image/zixun/zixun_300x150.jpg" >
                                                                    <?php else: ?> 
                                   <img src="<?php echo (get_cover($v2["cover_id"],'path')); ?>" ><?php endif; ?>  -->

                                <div class="content-r">
                                    <a href="<?php echo U('Category/zxchildren?id='.$v2['id']);?>" title="<?php echo ($v2["title"]); ?>" target="_blank"><?php echo ($v2["title"]); ?></a>
                                    <p class="next">
                                    <!-- <?php echo msubstr($v2['content'],0,9);?>...&nbsp;&nbsp;&nbsp; -->
                                    </p>
                                    <div class="read clearfix">
                                        <a class="one" href="<?php echo U('Category/zxchildren?id='.$v2['id']);?>">阅读全文>></a>
                                        <span><?php echo (date("Y-m-d",$v2["create_time"])); ?></span>
                                    </div>
                                </div>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>

                        <div class="wenzi">
                            <?php if(is_array($activity)): $i = 0; $__LIST__ = array_slice($activity,3,7,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v3): $mod = ($i % 2 );++$i;?><div class="wenzi-1">                                    
                                    <a href="<?php echo U('Category/zxchildren?id='.$v3['id']);?>" title="<?php echo ($v3["title"]); ?>" target="_blank"><?php echo ($v3["title"]); ?></a>
                                    <span><?php echo (date("Y-m-d",$v3["create_time"])); ?></span>
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="zixun-r ">
        <!--热门资讯-->
        <div class="hot">
            <div class="hot-t">
                <a href="javascript:;"><span class="icon-zixun"></span>热门资讯</a>
            </div>
            <div class="hot-b">
                <img src="<?php echo (get_cover($adv_zixun['0']['data'],'path')); ?>" alt="">
                <ul class="clearfix">                   
                    <?php $__CATE__ = D('Category')->getChildrenId(42);$__LIST__ = D('Document')->lists_limit($__CATE__, '`level` DESC,`id` DESC', 1,true,5); if(is_array($__LIST__)): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li>
                            <span class="zx"></span><a href="<?php echo U('Category/zxchildren?id='.$list['id']);?>"><?php echo ($list["title"]); ?>
                           </a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
        <!--平台资讯-->
        <div class="active clearfix">
            <div class="active-t">
                <a href="javascript:;"><span class="icon-zixun"></span>平台资讯</a>
            </div>
            <div class="active-b">
                <img src="<?php echo (get_cover($adv_zixun['1']['data'],'path')); ?>" alt="">
                <ul>
                    <?php $__CATE__ = D('Category')->getChildrenId(39);$__LIST__ = D('Document')->lists_limit($__CATE__, '`level` DESC,`id` DESC', 1,true,5); if(is_array($__LIST__)): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li>
                            <span class="zx"></span><a href="<?php echo U('Category/zxchildren?id='.$list['id']);?>"><?php echo ($list["title"]); ?></a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>


<!--分页器-->
<div id="pagation" ></div>
<!--尾巴部分-->

</body>
<script src="/Public/Media/js/jquery.min.js"></script>
<script src="/Public/Media/js/slider.jquery.js"></script>
<script type="text/javascript" src="/Public/Media/js/query.js"></script>
<script type="text/javascript" src="/Public/Media/js/pagation.js"></script>
<script>
   var  aId1= $("#zixunpage").find("a").eq(0).attr("id");//42
   var  aId2= $("#zixunpage").find("a").eq(1).attr("id");//44
   var  aId3= $("#zixunpage").find("a").eq(2).attr("id");//43
   
    var type = <?php echo ((isset($_GET['type']) && ($_GET['type'] !== ""))?($_GET['type']):aId1); ?>;
   
    // id 的值是 后台分配的  默认42,44,43
    var aA=document.getElementById("zixunpage").getElementsByTagName('a');
           // tab 当前的tab高亮
        for(var i=0;i<aA.length;i++){
                for(var j=0;j<aA.length;j++){                   
                   $("#zixunpage").find("a").eq(i).removeClass("on");
                }        
        }
        $('#'+type).addClass('on');    
// 当前table对应的内容显示
    if(type==aId1){
    //type =0 第一个显示 其他隐藏
       $("#zixunpage").siblings(".content").find("ul").find("li").hide();
       $("#zixunpage").siblings(".content").find("ul").find("li").eq(0).show();
      
    }
    if(type==aId2){
    //type =1 第2个显示 其他隐藏
       $("#zixunpage").siblings(".content").find("ul").find("li").hide();
       $("#zixunpage").siblings(".content").find("ul").find("li").eq(1).show();
        
    }
    if(type==aId3){
    //type =2 第3个显示 其他隐藏
       $("#zixunpage").siblings(".content").find("ul").find("li").hide();
       $("#zixunpage").siblings(".content").find("ul").find("li").eq(2).show();
       
    }

</script>

<script>
    var aA= document.getElementById("zixunpage").getElementsByTagName('a');  
    var dataLength = "<?php echo ((isset($count) && ($count !== ""))?($count):0); ?>";
    var p =<?php echo ((isset($_GET['p']) && ($_GET['p'] !== ""))?($_GET['p']):1); ?>;   
    var pageSize=10;
    var allPageNum=dataLength%pageSize==0 ? parseInt(dataLength/pageSize):(parseInt(dataLength/pageSize)+1);
    // 总计多少页
    type= <?php echo ((isset($_GET['type']) && ($_GET['type'] !== ""))?($_GET['type']):aId1); ?>;
    if(dataLength>pageSize){        
        page({
            id : 'pagation',
            nowNum : p,
            allNum : allPageNum,
            callBack : function(now,all){
                 window.location.href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/media.php?s=/Category/zixun/type/"+type+"/p/"+now+"/pagesize/"+pageSize+'.html';
            }
        });
    }else{
        $("#pagation").css("display","none");
    }
// 点击tab 切换页面
     for(var i=0;i<aA.length;i++){
        aA[i].index=i;
        aA[i].onclick=function () {
            var type2= aA[this.index].getAttribute('id');  
            if(type != type2){
                p=1;
            }
            window.location.href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/media.php?s=/Category/zixun/type/"+type2+"/p/"+p+"/pagesize/"+pageSize+'.html';        
        };
    }
  
    if($("#pagation").find(".jump").length>0){
        $("#pagation").find(".aBtns").css('padding',"0 0 0 50px");
    }else{
        $("#pagation").find(".aBtns").css('padding',"0 0 0 230px");
    }
</script>
<script>
    $( '#slider' ).lateralSlider( {
        captionPadding: '0',
        captionHeight: 45
    } );
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
            <p class="eachWork fl"><span class="workTit">联系客服：</span><span class="workCon">0755-25113016</span></p>
            <!-- <p class="eachWork fl"><span class="workTit">&nbsp;</span><span class="workCon">18600599334</span></p> -->
            <p class="eachWork fl"><span class="workTit">客服 QQ：</span><span class="workCon">106778379</span></p>
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
        if(CON == $.trim(navArr[i])){
            $(".header-c").find("li").eq(i).addClass('active');
        }
    }

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
                $("#topPart").addClass('marginBar');
            } else {
                $("#navBar").removeClass("fixed");
                $("#topPart").removeClass('marginBar');
            }
        })

    });
</script>