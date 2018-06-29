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


    var ACTION_STR = '/media.php?s=/Index/index';
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



<!--轮播图-->
<div style='position:relative;width:100%;min-width: 1200px;height:500px;overflow: hidden;'>
    <div id="box" style="width: 1920px;position: relative;left:50%;margin-left:-960px;z-index: 98;">
       <div id="slider" style="min-width: 1200px;background-size:100% 500px; ">
       <?php if(is_array($carousel)): $i = 0; $__LIST__ = $carousel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lun): $mod = ($i % 2 );++$i;?><!--<a href="<?php echo ($lun["url"]); ?>" target="<?php echo ($lun["target"]); ?>" title="<?php echo ($lun["title"]); ?>"><img src="<?php echo (get_cover($lun["data"],'path')); ?>" alt="<?php echo ($lun["title"]); ?>" title="" /></a>-->
        <a href="javascript:void(0)" target="<?php echo ($lun["target"]); ?>" title="<?php echo ($lun["title"]); ?>"><img src="<?php echo (get_cover($lun["data"],'path')); ?>" alt="<?php echo ($lun["title"]); ?>" title="" /></a><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>

        <!--<div class="slide-box">-->
            <!--<ul class="slide-content">-->
                <!--<li style="background: url('../../Static/Image/index/banner1.png') 100% 500px;"><a href="javascript:void(0)" target="_blank"></a></li>-->
            <!--</ul>-->
            <!--<ol class="slide-triggers">-->
                <!--<li></li>-->
                <!--<li></li>-->
                <!--<li></li>-->
                <!--<li></li>-->
            <!--</ol>-->

            <!---->
        <!--</div>-->

    </div>

    <!--  登录框   -->
    <?php if(empty($user)): ?><div class="loginBox cf">
            <div class="loginTit fl">账号登录</div>
            <form action="" class="formBox cf fl" style="position: relative;" id="submit" >
                <div class="errorMsg" style="color: #ff3b2f;"></div>
                <div class="eachInput fl accountBox cf" id="accountBox">
                    <i></i>
                    <input type="text" id="account" class="fl" placeholder="账号">
                </div>
                <div class="eachInput fl pwdBox cf">
                    <i></i>
                    <input type="password" id="pwd" class="fl" placeholder="密码">
                </div>
                <div class="operateLogin fl">
                    <i class="isChose fl active"></i>
                    <a class="rememberPwd fl">记住密码</a>
                    <a class="forgetPwd fr" href="<?php echo U('Index/wjmm');?>">忘记密码?</a>
                </div>
                <a href="javascript:void(0)" class="btnLogin fl" id="login">登录</a>
                <a href="<?php echo U('Public/register');?>" class="btnReg fl">立即注册</a>
            </form>
        </div><?php endif; ?>

</div>
<!--推荐游戏-->
<div class="tjyouxi clearfix">
    <div class="container">
        <div class="youxi-t">
            <a href="<?php echo U('Game/youxi');?>" class="one"><span class="icon-youxi"></span>推荐游戏</a>
            <a href="<?php echo U('Game/youxi');?>" class="more">更多> ></a>
        </div>
        <div class="youxi-b">
            <ul>

                <?php if(is_array($recommend)): $i = 0; $__LIST__ = $recommend;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                    <a href="<?php echo U('Game/game_detail?id='.$vo['id'].'');?>" class="one">
                        <img src="<?php echo (get_cover($vo["cover"],'path')); ?>" class="gpic">
                        <div class="fbbl"><?php echo ($vo["game_name"]); ?></div>
                    </a>
                    <!-- <div class="show">
                        <div class="show-t">
                            <p><?php echo ($vo["game_name"]); ?></p>
                        </div>
                        <div class="show-b">
                            <img src="<?php echo U('Game/dow_url_generate?game_id='.$vo['id']);?>" alt="">
                            <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>" class="tj">推荐 <br/> &nbsp;<img src="/Public/Media/image/main/tuijian_wujiaoxing.png" alt=""></a>
                            <a href="<?php if($v["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$v['id'].'&type=1'); endif; ?>" class="xz">下 &nbsp;载</a>
                        </div>
                    </div> -->
                    <div class="show">
                        <div class="show-t">
                            <p><?php echo ($vo["game_name"]); ?></p>
                        </div>
                        <div class="show-b">
                            <img src="<?php echo U('Game/dow_url_generate?game_id='.$vo['id']);?>" alt="">
                            <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>" class="tj">推荐 <br/> &nbsp;<img src="/Public/Media/image/main/tuijian_wujiaoxing.png" alt=""></a>
                            <a href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="xz">下 &nbsp;载</a>
                        </div>
                        <!-- <p class="saoma">QQ扫码</p> -->
                    </div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>

            </ul>
        </div>
    </div>
</div>

<!--游戏部分-->
<div class="game">
    <div class="container clearfix" style="margin-bottom: 80px;">

        <!--游戏部分左侧-->
        <div class="game-left clearfix">

                <!--热门游戏-->
            <div class="hot-game">
                <div class="hot-game-t">
                    <a href="javascript:;" class="two"><span class="icon-hot"></span>热门游戏</a>
                    <a href="<?php echo U('Game/youxi');?>" class="gengduo">更多> ></a>
                </div>
                <div class="hot-game-b">
                    <ul class="clearfix">
                        <?php if(is_array($hot)): $i = 0; $__LIST__ = $hot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                <div class="hot">
                                    <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>"><img src="<?php echo (get_cover($vo["icon"],'path')); ?>"></a>
                                    <div class="wenzi">
                                        <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>" class="first"><?php echo msubstr($vo['game_name'],0,7,'UTF-8',false);?></a>
                                        <p href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>" class="next"><?php echo ($vo["game_type_name"]); ?></p>
                                        <!--<a href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="load">下 &nbsp;载</a>-->
                                        <a href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="load jq-downLoad" >下 &nbsp;载</a>
                                    </div>
                                </div>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>


            <!--游戏资讯-->
            <div class="zixun clearfix">
                <div class="zixun-t">
                    <div class="zixun-t">
                        <a href="javascript:;" class="two"><span class="icon-zixun"></span>游戏资讯</a>
                        <a href="<?php echo U('Category/zixun');?>" class="gengduo">更多> ></a>
                    </div>
                </div>
                <div class="zixun-b clearfix">

                    <div class="zixun-b-l">
                        <ul>
                            <?php if(is_array($data_zxadv)): $i = 0; $__LIST__ = $data_zxadv;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$zxadv): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($zxadv["url"]); ?>" target="<?php echo ($zxadv["target"]); ?>"><img src="<?php echo (get_cover($zxadv["data"],'path')); ?>" alt="<?php echo ($zxadv["title"]); ?>"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>

                    <div class="zixun-b-r">
                        <ul>
                            <!-- 公告 -->
                        <?php $__CATE__ = D('Category')->getChildrenId(44);$__LIST__ = D('Document')->lists_limit($__CATE__, '`level` DESC,`id` DESC', 1,true,3); if(is_array($__LIST__)): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li>
                                <span class="gonggao"></span>
                                <a href="<?php echo U('Category/zxchildren?id='.$list['id']);?>"><?php echo ($list["title"]); ?></a><span class="data"><?php echo (date("m/d",$list["create_time"])); ?></span>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>

                        <!-- 资讯 -->
                            <?php $__CATE__ = D('Category')->getChildrenId(43);$__LIST__ = D('Document')->lists_limit($__CATE__, '`level` DESC,`id` DESC', 1,true,3); if(is_array($__LIST__)): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li>

                                <span class="zx"></span><a href="<?php echo U('Category/zxchildren?id='.$list['id']);?>"><?php echo ($list["title"]); ?></a><span class="data"><?php echo (date("m/d",$list["create_time"])); ?></span>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        <!-- 活动 -->
                        <?php $__CATE__ = D('Category')->getChildrenId(42);$__LIST__ = D('Document')->lists_limit($__CATE__, '`level` DESC,`id` DESC', 1,true,3); if(is_array($__LIST__)): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li>
                                <span class="huodong"></span><a href="<?php echo U('Category/zxchildren?id='.$list['id']);?>"><?php echo ($list["title"]); ?></a><span class="data"><?php echo (date("m/d",$list["create_time"])); ?></span>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!--新游推荐-->
            <div class="xinyou clearfix">
                <div class="xinyou-t">
                    <a href="<?php echo U('Game/youxi');?>" class="two"><span class="icon-hot"></span>新游推荐</a>
                    <a href="<?php echo U('Game/youxi');?>" class="gengduo">更多> ></a>
                </div>
                <div class="xinyou-b">
                    <ul>
                        <?php if(is_array($xin)): $i = 0; $__LIST__ = $xin;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                            <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>"><img src="<?php echo (get_cover($vo["cover"],'path')); ?>" >
                                <div class="fbbl">
                                    <?php echo ($vo["game_name"]); ?>
                                </div>
                            </a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>

            <!--角色扮演-->
            <div class="cosplay clearfix">
                <div class="tab">
                    <a href="javascript:;" class="tab1"><span class="icon-cosplay"></span>角色扮演 &nbsp;</a>
                    <a href="javascript:;" class="tab2"> / &nbsp; <span class="icon-kapai"></span>卡牌游戏 &nbsp;&nbsp;</a>
                    <a href="javascript:;" class="tab2"> / &nbsp; <span class="icon-celue"></span>策略养成 &nbsp;&nbsp;</a>
                    <a href="javascript:;" class="tab2"> / &nbsp; <span class="icon-yizhi"></span>休闲益智</a>
                </div>
                <div class="content" >
                    <ul>
                        <li style="display: block">
                            <div class="box">
                                <?php if(is_array($juese)): $i = 0; $__LIST__ = $juese;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="hot">
                                        <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>"><img src="<?php echo (get_cover($vo["icon"],'path')); ?>"></a>
                                        <div class="wenzi">
                                            <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>" class="first"><?php echo ($vo["game_name"]); ?></a>
                                            <p class="next"><?php echo ($vo["game_type_name"]); ?></p>
                                            <!--<a href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="load"> 下 &nbsp;载</a>-->
                                            <a href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="load" > 下 &nbsp;载</a>
                                        </div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                             </div>
                         </li>

                        <li>
                            <div class="box">
                                <?php if(is_array($kapai)): $i = 0; $__LIST__ = $kapai;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="hot">
                                       <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>"><img src="<?php echo (get_cover($vo["icon"],'path')); ?>"></a>
                                    <div class="wenzi">
                                        <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>" class="first"><?php echo ($vo["game_name"]); ?></a>
                                        <p class="next"><?php echo ($vo["game_type_name"]); ?></p>
                                        <!--<a href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="load"> 下 &nbsp;载</a>-->
                                        <a href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="load"> 下 &nbsp;载</a>
                                        </div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                        </li>
                        <li>
                            <div class="box">
                                <?php if(is_array($celue)): $i = 0; $__LIST__ = $celue;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="hot">
                                        <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>"><img src="<?php echo (get_cover($vo["icon"],'path')); ?>"></a>
                                        <div class="wenzi">
                                            <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>" class="first"><?php echo ($vo["game_name"]); ?></a>
                                            <p class="next"><?php echo ($vo["game_type_name"]); ?></p>
                                            <!--<a href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="load"> 下 &nbsp;载</a>-->
                                            <a href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>"  class="load"> 下 &nbsp;载</a>
                                        </div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                             </div>
                         </li>

                        <li>
                            <div class="box">
                                <?php if(is_array($xiuxian)): $i = 0; $__LIST__ = $xiuxian;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="hot">
                                       <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>"><img src="<?php echo (get_cover($vo["icon"],'path')); ?>"></a>
                                    <div class="wenzi">
                                        <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>" class="first"><?php echo ($vo["game_name"]); ?></a>
                                        <p class="next"><?php echo ($vo["game_type_name"]); ?></p>
                                        <!--<a href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="load"> 下 &nbsp;载</a>-->
                                        <a href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>"  class="load"> 下 &nbsp;载</a>
                                        </div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!--游戏部分右侧-->
        <div class="game-right clearfix">
            <!--游戏礼包-->
            <div class="libao clearfix">
                <div class="libao-t">
                    <a href="javascript:;" class="one"><span class="icon-libao"></span>游戏礼包</a>
                    <a href="<?php echo U('Gift/index');?>" class="more">更多> ></a>
                </div>
                <div class="libao-b" >
                     <ul id="getGift">
                        <?php if(is_array($gift)): $i = 0; $__LIST__ = $gift;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                            <div class="draw">
                            <a href="<?php echo U('Game/yxchildren?id='.$vo['game_id'].'&type=2');?>" target="_blank"><p class="fengbao"><?php echo ($vo["game_name"]); ?></p> <p class="gifts" id="<?php echo ($vo["gift_id"]); ?>"><?php echo ($vo["giftbag_name"]); ?></p></a>
                                <div class="lingqu">领 &nbsp;取</div>
                            </div>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
            <!--游戏排行-->
            <div class=" paihang clearfix">
                <div class="paihang-t">
                    <a href="javascript:;"  class="one"><span class="icon-libao"></span>游戏排行</a>
                </div>
                <div class="paihang-b ">
                    <ul class="weekly-list">
                    <?php if(is_array($rank)): $i = 0; $__LIST__ = $rank;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li >
                                <div class="app-show-title clearfix">
                                    <?php if($num < 4): ?><span class="num s-index-org" style="background-color:#f19ec2;color: #fff;"><?php echo ($num++); ?></span>
                                        <?php elseif($num < 7): ?><span class="num s-index-org" style="background-color:pink;color: #fff;"><?php echo ($num++); ?></span>
                                        <?php else: ?> 
                                        <span class="num s-index-org" style=";background-color:gray;color: #fff;"><?php echo ($num++); ?></span><?php endif; ?>                                    
                                    <a href="<?php echo U('Game/yxchildren',array('id'=>$vo['id'],'type'=>1));?>"  class="bl"><?php echo ($vo["game_name"]); ?></a>
                                    <a href="javascript:;" class="hh"><?php echo ($vo["game_type_name"]); ?></a>
                                </div>

                                <div class="app-show-block"> 
                                <?php if($num < 5): ?><span class="num s-index-org" style="background-color:#f19ec2;color: #fff;"></span>
                                        <?php elseif($num < 8): ?><span class="num s-index-org" style="background-color:pink;color: #fff;"></span>
                                        <?php else: ?> <span class="num s-index-org" style=";background-color:gray;color: #fff;"></span><?php endif; ?>   

                                <a href="<?php echo U('Game/yxchildren',array('id'=>$vo['id'],'type'=>1));?>" class="pic"><img src="<?php echo (get_cover($vo["icon"],'path')); ?>" alt="<?php echo ($vo["game_name"]); ?>"></a>
                                <div class='xzandli clearfix'>      
                                    <div class='title clearfix'>
                                    <a href="<?php echo U('Game/yxchildren',array('id'=>$vo['id'],'type'=>1));?>"  class="name"><?php echo ($vo["game_name"]); ?></a>
                                    <a href="javascript:;" class="jiaose"><?php echo ($vo["game_type_name"]); ?></a>
                                    </div>
                                    <div class='picandtxt'>   
                                    <!--<a  class="xz" href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="down">下&nbsp;载</a>                                  -->
                                    <a  class="xz" href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="down" >下&nbsp;载</a>
                                    <a href="<?php echo U('Game/yxchildren',array('id'=>$vo['id'],'type'=>2));?>" class="lb">礼&nbsp;包</a>
                                    </div>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?> 
                        
                        </ul>
                </div>
            </div>
            <!--活动和客服-->
            <div class="last clearfix">
                <div class="last-l">
                    <!--游戏活动-->
                    <div class="yxactive">
                        <div class="yxactive-t">
                            <a href="javascript:;" class="two"><span class="icon-hot"></span>游戏活动</a>
                            <a href="<?php echo U('Category/zixun');?>" class="gengduo">更多 > ></a>
                        </div>
                        <div class="yxactive-b">
                            <ul>
                                <?php $__CATE__ = D('Category')->getChildrenId(44);$__LIST__ = D('Document')->lists_limit($__CATE__, '`level` DESC,`id` DESC', 1,true,3); if(is_array($__LIST__)): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li>
                                        <a href="<?php echo U('Category/zxchildren?id='.$list['id']);?>" class="tj"><img src="<?php echo (get_cover($list["cover_id"],'path')); ?>" alt="">
                                            <div class="fbbl">
                                                <?php echo ($list["title"]); ?>
                                            </div>
                                        </a>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!--游戏开服-->
            <!--<div class="kaifu clearfix" style="position: relative;">-->
                <!--<div class="kaifu-t">-->
                    <!--<a href="javascript:;"  class="one"><span class="icon-libao"></span>游戏开服</a>-->
                <!--</div>-->
                <!--<div class="kaifu-b">-->
                    <!--<ul style="height: 385px;overflow: hidden;">-->
                        <!--<?php if(is_array($area)): $i = 0; $__LIST__ = $area;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->
                        <!--<li>-->
                            <!--<a href="<?php echo U('Game/yxchildren?id='.$vo['game_id'].'');?>"><p class="fengbao"><?php echo (date("m/d",$vo["start_time"])); ?> <span class="dian"></span><?php echo ($vo["game_name"]); ?></p> <p class="fuqu_kaifu"><?php echo ($vo["server_name"]); ?></p>-->
                                <!--<div class="lingqu">查 &nbsp;看</div></a>-->
                        <!--</li>-->
                        <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                    <!--</ul>-->
                <!--</div>-->
                <!--<p class="circle_div">-->
                    <!---->
                <!--</p>-->
            <!--</div>-->
            <!--游戏客服-->
        </div>


    </div>
    <!--友情连接-->
    <div class="lianjie clearfix">
        <div class="container">
            <div class="friendShipLink">
                <i class="linkIcon"></i>
                <p class="linkName">友情链接</p>
            </div>
            <div class="lianjie-b">
                <ul>
                    <?php $_result=get_links();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li><a target="_blank" href="<?php echo ($data["link_url"]); ?>" title="<?php echo ($data["title"]); ?>" ><?php echo ($data["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>

            </div>
        </div>
    </div>
</div>

<!--尾巴固定-->
<div class="app" style="display:none">
    <div class="box-text">
        <img src='/Public/Media/image/dibu/banner.png' class='mainPic' style="width: 1200px;">
        <div class="app-code" >
            <img  class="c" src="/Public/Media/image/dibu/appwx.png" alt="" style="width: 125px;">
        </div>
        <span class="app-cha" id="shift"></span>
        <div class='mogu'><img src="/Public/Media/image/dibu/mogu.png"></div>
    </div>
</div>

</body>
<script type="text/javascript">
    var gift_url = "<?php echo U('Member/getGameGift');?>";
    var MODULE = "/media.php?s=";
</script>

<script src="/Public/Media/js/jquery.min.js"></script>
<script src="/Public/Media/js/jquery-1.11.1.min.js"></script>
<script src="/Public/Media/js/pop.js"></script>
<script src="/Public/Media/js/slider.jquery.js"></script>
<script src="/Public/Media/js/jquery.cookie.js"></script>

<script>




    $('#box').css('width','$(window).clientWidth()');
    $( '#slider' ).lateralSlider( {
        captionPadding: '0',
        captionHeight: 45
    } );

    // 官方玩家群
    var wjQQ=$.trim($(".kefu-b").find('.four').find(".gfwjq").html());
    if(wjQQ==""){
        $(".kefu-b").find('.four').html("");
    }

   var del=document.getElementById("shift");
   del.onclick=function () {
         this.parentNode.parentNode.style.display = "none";
     };
    $('#getGift').find('li').each(function () {
        $(this).find('.lingqu').click(function () {
            $.ajax({
                type:'post',
                dataType:'json',
                data:{
                    gift:$(this).parent(".draw").find('.gifts').html(),
                    giftid:$(this).parent(".draw").find('.gifts').attr('id')
                },
                url:"<?php echo U('Member/getGameGift');?>",
                success:function(data) {
                    if (parseInt(data.status) == 1 ) {
                        //登录成功时候的状态
                      if(data.msg=='ok'){
                          login_ok(data);
                      }
                      if(data.msg=='no'){
                            //您已领取过该礼包
                          login_no(data)
                      }
                      if(data.msg=='noc'){
                            //该礼包已领取完，下次请早
                            login_noc(data)
                        }
                    }
                    if (parseInt(data.status) == 0 ) {
                        //登录失败的时候
                        nologin_box();
                    }
                },
                error:function() {
                    alert('服务器故障，请稍候再试。。。。');
                }
            });
        })
    })

</script>

<script>
$(function(){

    $(document).on("click",'.isChose',function(){
        
        if($(this).hasClass('active')){
            $(this).removeClass('active');
        }else{
            $(this).addClass('active');
        }
    });

    // 记住密码功能
    var remFlag=false;
    $(".rememberPwd").click(function(){
        remFlag=!remFlag;
    });
    if ($.cookie("remFlag") == "true") {
        remFlag=true;
        $.cookie("username")[0].type = 'password';
        $("#account").val($.cookie("username"));
        $("#pwd").val($.cookie("password"));
    }
  

    $("#login").click(function() {
        var str_username = $("#account").val();
        var str_password = $("#pwd").val();

        //账号和密码验证// 账号
        var verifyVal = verifyAccountPhone(str_username);
        verifyVal ? verifyVal = verifyPwd(str_password) : verifyVal;

        if(!verifyVal){
            $(".errorMsg").show().text(errorMsg);
            return false;
        }
        $(".errorMsg").hide().text("");

        // 记住密码功能
        if (remFlag) {
            $.cookie("remFlag", "true", { expires: 7 }); //存储一个带7天期限的cookie
            $.cookie("username", str_username, { expires: 7 });
            $.cookie("password", str_password, { expires: 7 });
        }
        else {
            $.cookie("remFlag", "false", { expire: -1 });
            $.cookie("username", "", { expires: -1 });
            $.cookie("password", "", { expires: -1 });
        }

        // ajax提交
        $.ajax({
                type: 'POST',
                async: true,
                dataType: 'json',
                url: "<?php echo U('Member/login');?>",//提交给后台的地址
                data: {account:str_username,password:str_password},
                beforeSend: function () {
                    $('#login').val('登录中').attr('disabled', true);
                },
                success: function (data) {
                    switch (parseInt(data['status'])) {
                        case 0:
                            $(".errorMsg").show().text(data['msg']);
                            $('#login').val('登录').attr('disabled', false);
                            break;
                        case 1:
                            setTimeout(function (){
                                var reurl = data['reurl'];//跳转的地址
                                if (reurl) {
                                    location.href = reurl;//跳转的地址
                                } else {
                                    location.reload();
                                }
                            }, 1000); break;
                        case -999:
                            showcode();
                            $(".errorMsg").show().text(data['msg']);
                            $('#login').val('登录').attr('disabled', false);
                            $('.checkcode').click();
                            break;
                        default:
                            $('#login').val('登录').attr('disabled', false);
                            break;
                    }
                    return false;
                },
                error: function () {
                    $(".errorMsg").show().text('服务器故障，稍后再试');
                    $('#login').val('登录').attr('disabled', false);
                },
                cache: false
        });
        
    });
    

    $("#pwd").keydown(function (e) {
        if (e.which == 13) {
            $('#login').trigger("click");
            //触发搜索按钮的点击事件
        }
    });

    //验证登录账号
    function verifyAccountPhone(account){
        var account = $.trim(account);
        var accountReg = /^[a-zA-Z]+[0-9a-zA-Z_]{5,14}$/;
        var phoneReg = /^(13|14|15|17|18)[0-9]{9}$/;
        if(!account){
            errorMsg = "请输入您的账号";
            return false;
        }else if(!accountReg.test(account) && !phoneReg.test(account)){
            errorMsg = "请填写正确的账号";
            return false;
        }
        else{
            errorMsg = "";
            return true;
        }
    }

    //验证注册密码
    function verifyPwd(pwd){
        var pwd = pwd;
        var pwdReg = /^(?![0-9]+$)[0-9A-Za-z]{6,15}$/;
        
        if(!pwd){
            errorMsg = "请填写您的密码";
            return false;
        }else if(!pwdReg.test(pwd)){
            errorMsg = "请填写正确的密码";
            return false;
        }else{
            errorMsg = "";
            return true;
        }
    }

});
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