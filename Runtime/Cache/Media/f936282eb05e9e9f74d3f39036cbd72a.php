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


    var ACTION_STR = '/media.php?s=/Service/kflb';
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


    <link rel="stylesheet" href="/Public/Media/css/kfmm.css">

<!--中间部分-->
<div class="kf container clearfix">
    <div class="kf-t">
        <p>当前位置： <a href="<?php echo U('kefu');?>">客服中心 </a> > <a href="javascript:;">礼包问题</a></p>
    </div>
    <div class="kf-b clearfix">

        <div class="tabItemContainer">
            <li><span class="icon-mmwt"></span><a href="<?php echo U('Service/kfmm');?>">密码问题</a></li>
            <li><span class="icon-cz"></span><a href="<?php echo U('Service/kfcz');?>">充值问题</a></li>
            <li><span class="icon-zh"></span><a href="<?php echo U('Service/kfzh');?>">账户问题</a></li>
            <li  class="tabItemCurrent"><span class="icon-lb"></span><a href="<?php echo U('Service/kflb');?>">礼包问题</a></li>
            <li><span class="icon-cj"></span><a href="<?php echo U('Service/kfzj');?>">常见问题</a></li>
        </div>

        <div class="tabBodyContainer">
            <div class="content">
                <div class="content-t" id="34">
                    <p class="question">Q: 
                     什么时候发放最新的礼包？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                     亲爱的玩家：您好！请您保持对手上科技游戏平台的持续关注，您登录游戏后在界面左边有一个隐藏的悬浮图标，点击账户中的礼包页面，就可以领取对应的礼包，礼包数量有限，请在领取后及时兑换。
                    </span></p>
                </div>
                
                <div class="content-t" id="35">
                    <p class="question">Q: 
                     如何查看是否已领取过同类型礼包？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                     亲爱的玩家：您好！获得兑换码后尝试在游戏内兑换，如已领取过同类型礼包，则游戏内系统会有相关提示。
                    </span></p>
                </div>

                <div class="content-t" id="36">
                    <p class="question">Q: 
                     不同渠道获得的礼包，都可以使用吗？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                       亲爱的玩家：您好！如果您是在不同的渠道获得的礼包，那么是无法在在手上科技平台使用的，建议您在手上科技平台领取对应礼包并使用
                    </span></p>
                </div>

                <div class="content-t" id="37">
                    <p class="question">Q: 
                    礼包兑换、领取方式
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                       亲爱的玩家：您好！请您在游戏中寻找礼包功能输入兑换码即可完成领取。
                    </span></p>
                </div>

                <div class="content-t" id="38">
                    <p class="question">Q: 
                    进入手上科技助手发现礼包领取完怎么办?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好！平台发现礼包没有会及时添加，你持续关注手上科技助手或者微信动态即可获得礼包。
                    </span></p>
                </div>

                <div class="content-t" id="39">
                    <p class="question">Q: 
                    平台游戏的新手卡激活码如何领取?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    1、下载手上科技助手，输入游戏名称即可领取礼包。
                    </span>
                    <span class="zwt">
                    2、关注（手上科技游戏）微信，回复游戏名称：“###”即可获取礼包回复码。
                    </span></p>
                </div>

                <div class="content-t" id="40">
                    <p class="question">Q: 
                     领取礼包兑换失效/过期等问题，怎么办?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好！一种礼包，一个角色只能兑换一次，礼包失效可能是玩家通过其他方式已经获得了该礼包。过期礼包是无法使用的，请您重新领取礼包并及时兑换。
                    </span></p>
                </div>
               
            </div>

        </div>
    </div>
</div>


<!--底部-->


</body>


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