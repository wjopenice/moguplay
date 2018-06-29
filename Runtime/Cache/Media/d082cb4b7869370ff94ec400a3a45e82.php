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


    var ACTION_STR = '/media.php?s=/Member/bindphone';
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
    <link rel="stylesheet" href="/Public/Media/css/centerperson.css">
    <style>      
        #pc_main_con{
            width:1200px;margin:0 auto;
        }
        #pc_main_con .safeCenter .title{
            font:16px/50px "Arial"; color:#8C97CB;
            border-bottom: 1px solid #8C97CB ; padding-top:30px;
        }
        #pc_main_con .safeCenter .title span{float: left;width:21px;height: 21px;margin:13px 20px 0 20px;background-image: url(/Public/Media/image/personalcenter/pcsprits.png) ; background-repeat:no-repeat ;}
        #pc_main_con .safeCenter .content .con_l{
            width:240px;padding-top:40px;float:left;
        }
        #pc_main_con .safeCenter .content .con_l li a{
            display: block;line-height:60px;
            font-size:14px;color:#333;
        }
        #pc_main_con .safeCenter .content .con_l li a span{
            float: left;width:21px;height: 21px;margin:20px 12px 0 73px;
            background-image:  url(/Public/Media/image/personalcenter/pcsprits.png) ; 
            background-repeat:no-repeat ;
        }
        #pc_main_con .safeCenter .content .con_l .current a{
            color:#fff;background:#8C97CB;
        }
        #pc_main_con .safeCenter .content .con_r{
            float:left;min-height: 400px;
            width: 960px;
            padding-top:40px;
        }
        #pc_main_con .safeCenter .content .con_r .reset{
            padding-left: 200px;
        }
        #pc_main_con .safeCenter .content .con_r .current{
            padding-left: 200px;
        }
        #pc_main_con .safeCenter .content .con_r .first{
            padding-left: 70px;
        }
        #pc_main_con .safeCenter .content .con_r .completeerror{
            margin-left: 285px;
        }
        #pc_main_con .safeCenter .content .con_r .completesuccess{
            margin-left: 285px;
        }

        #pc_main_con .safeCenter .content .con_r .iphone{
            padding-left: 200px;
        }

        #pc_main_con .safeCenter .content .con_r .wancheng {
            margin: 75px auto;
            text-align: center;

        }
        #pc_main_con .safeCenter .content .con_r .wancheng  p{
            margin-top: 30px;
        }

        #ident{
            width:90px;line-height:30px;text-align: center;padding-left:0!important;
        }

    </style>


    <div id="pc_main_con" >
      
        <div class="safeCenter" >
            <div class="title">
                <span style=" background-position: -42px 0;"></span>安全中心
            </div>
            <div class="content clearfix">
                <div class="con_l" id="safeCenter_l">
                      <ul>
                        <li><a href="<?php echo U('Member/pcsafecenter');?>"> <span style="background-position: 0 -34px;"></span>密码修改</a></li>

                        <?php if($user['phone'] == ''): ?><li class="current"><a href="<?php echo U('Member/bindphone');?>"> <span style="background-position: -45px -68px;"></span>绑定手机</a></li>
                        <?php else: ?>
                        <li class="current"><a href="<?php echo U('Member/nobindphone');?>"> <span style="background-position: -45px -68px"></span>绑定手机</a></li><?php endif; ?>

                       <?php if($user['email'] == ''): ?><li ><a href="<?php echo U('Member/bindemail');?>"> <span style="background-position: 0 -109px;margin-top:23px;"></span>绑定邮箱</a></li>
                       <?php else: ?>
                          <li ><a href="<?php echo U('Member/nobindemail');?>"> <span style="background-position: 0 -109px;margin-top:23px;"></span>绑定邮箱</a></li><?php endif; ?>

                       <?php if($user['idcard'] == ''): ?><li ><a href="<?php echo U('Member/noidcard');?>"> <span style="background-position: 0 -141px;"></span>实名认证</a></li>
                       <?php else: ?>
                          <li ><a href="<?php echo U('Member/idcard');?>"> <span style="background-position: 0 -141px"></span>实名认证</a></li><?php endif; ?>
                    </ul>
                </div>
                <div class="con_r" id="safeCenter_r">
                <!--绑定手机第一步-->
                    <?php switch($m): case "1": ?><div class="iphone1"  id="nobind1">
                            <!--绑定手机-->
                            <img src="/Public/Media/image/personalcenter/safecenter/bind_phone1.png" alt="" class="first">
                            <p class="current" style="margin-top: 45px">当前账号：<span class="account" id="uname"><?php echo ($user['account']); ?></span></p>
                            <div class="reset">
                                <span class="h" style="text-indent: 2em">密码：</span> 
                                    <input type="password" class="shuru" id="telpassword"> 
                                    <span id="teltips" class="teltipss"> <i class="star">* </i>
                                    <span class="zi"> 请输入密码</span>
                                </span>
                            </div>
                            <input type="submit" value="完&nbsp;成" class="completeerror" id="achieve">
                        </div><?php break;?>
                    
                    <?php case "2": ?><!-- <script>alert(123)</script> -->
                     <!--绑定手机第二步-->
                    <div class="iphone2"  id="nobind2">
                        <!--绑定手机-->
                    <img src="/Public/Media/image/personalcenter/safecenter/bind_phone2.png" alt="" class="first">
                    <p class="current" style="margin-top: 45px">当前账号：<span class="account"><?php echo ($user['account']); ?></span></p>
                    <div class="iphone clearfix"><span class="h">&nbsp;&nbsp;&nbsp;手机号：</span> <input type="text"  id="telnumber">
                    <input type="button" class="send" id="ident" value="发送验证码"/> 
                    <span id="numtips"><i class="star">* </i><span class="zi">请输入您的手机号</span></span></div>
                    <div class="reset"><span class="h">&nbsp;&nbsp;&nbsp;验证码：</span> <input type="text"  id="code"><span id="codetips"><i class="star">* </i><span class="zi"> 请输入您的验证码</span></span></div>
                    <input type="submit" value="完&nbsp;成" class="completeerror" id="achieve2">
                    </div><?php break;?>

                    <!--绑定手机第三步-->
                    <?php case "3": ?><div class="iphone3"  id="nobind3">
                          <img src="/Public/Media/image/personalcenter/safecenter/bind_phone3.png" alt="" class="first">
                          <div class="wancheng">
                              <img src="/Public/Media/image/personalcenter/safecenter/wancheng.png" alt="">
                              <p>绑定手机号成功!</p>
                          </div>
                    </div><?php break; endswitch;?>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
<script src="/Public/Media/js/jquery-1.11.1.min.js"></script>
<script src="/Public/Media/js/centerbindphone.js"></script>
<script>
    var zqimg="/Public/Media/image/wjmm/quanbuzhengquan.png";
    var account="<?php echo ($user['account']); ?>";
    var verifypwdurl="<?php echo U('Member/verifypwd');?>";
    var phonebangcheck="<?php echo U('Member/phonebangcheck');?>";
    var sendvcodeurl="<?php echo U('Member/sendvcode');?>"; 
    var phoneurl= "<?php echo U('Member/phone');?>";
    var nobindphoneurl="<?php echo U('Member/nobindphone');?>"; 
    var account = "<?php echo ($_GET['account']); ?>";  
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