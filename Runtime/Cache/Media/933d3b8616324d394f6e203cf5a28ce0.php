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


    var ACTION_STR = '/media.php?s=/Service/kfzh';
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
        <p>当前位置： <a href="<?php echo U('kefu');?>">客服中心 </a> > <a href="javascript:;">账户问题</a></p>
    </div>
    <div class="kf-b clearfix">


        <div class="tabItemContainer">
            <li><a href="<?php echo U('Service/kfmm');?>"><span class="icon-mmwt"></span>密码问题</a></li>
            <li><a href="<?php echo U('Service/kfcz');?>"><span class="icon-cz"></span>充值问题</a></li>
            <li class="tabItemCurrent"><a href="<?php echo U('Service/kfzh');?>"><span class="icon-zh"></span>账户问题</a></li>
            <li><a href="<?php echo U('Service/kflb');?>"><span class="icon-lb"></span>礼包问题</a></li>
            <li><a href="<?php echo U('Service/kfzj');?>"><span class="icon-cj"></span>常见问题</a></li>
        </div>

        <div class="tabBodyContainer">
            <div class="content" id="19">

                <div class="content-t">
                    <p class="question">Q: 
                     一个手机号码可以绑定几个账号？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                      亲爱的玩家：您好！目前一个手机号码最多只能绑定一个账号。
                    </span></p>
                </div>

                <div class="content-t" id="20">
                    <p class="question">Q: 
                    在手上科技注册的账号可以在别的平台登录吗?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好!不同平台账号数据是不互通的,所以不能在别的平台上进行登录。
                    </span></p>
                </div>

                <div class="content-t" id="21">
                    <p class="question">Q: 
                   游戏账号忘记了,怎么找回?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                     亲爱的玩家：您好!您可以通过以下方式找回:
                     </span>
                     <span class="zwt">
                    ①通过绑定信息找回，绑定了密保手机或者登录邮箱，可以直接通过手机或者邮箱作为账号登录游戏。
                     </span>
                     <span class="zwt">
                    ②通过充值记录，如：支付宝账号，支付宝商户订单号(请使用电脑查询)，充值订单号，银行卡充值订单号等提供给客服查询。
                     </span>
                     <span class="zwt">
                    ③如未绑定手机或邮箱,请将账号其他信息尽量完整提供给客服查询您对应的手上科技账号。
                     </span>
                     <span class="zwt">
                     联系客服QQ：106778379,客服电话:0755-25113016 。
                    </span>
                    </p>
                </div>

                <div class="content-t"  id="22">
                    <p class="question">Q: 
                    我的账号在另一个手机登录不了？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好!可能是因为您两台手机下载的安装包不是同一平台的,建议查询您原手机上的安装包所属平台,再重新下载所属平台的安装包.
                    </span></p>
                </div>

                <div class="content-t"  id="23">
                    <p class="question">Q: 
                    你们平台的帐号可以注销吗？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好!目前已注册的账号是不可以注销的哦。
                    </span></p>
                </div>

                <div class="content-t" id="24">
                    <p class="question">Q: 
                    我换了手机号，我想要换绑手机号，该怎么操作？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    您好，请登陆手上科技官网，右上角登录，登录后再次点击进入个人中心，选择更换绑定手机，输入手机号验证即可。
                    </span></p>
                </div>

                <div class="content-t" id="25">
                    <p class="question">Q: 
                    没有绑定过手机或邮箱,怎么找回密码?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好!如您的账号没有绑定手机号或邮箱,请您到我们的官网上联系客服,相关工作人员会在1-3个工作日给您审核,审核结果将以电话的形式通知您,请您留意并耐心等候.您也可以到我们手上科技游戏官网联系在线QQ客服:106778379进行找回!
                    </span></p>
                </div>

                <div class="content-t" id="26">
                    <p class="question">Q: 
                    为什么我在你们平台登陆显示“该用户未注册”？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                     您好，因为您登陆的账号并未注册哦，您使用的是其他平台的账号所以无法登陆手上科技的端口。
                    </span></p>
                </div>

                <div class="content-t" id="27">
                    <p class="question">Q: 
                    你们平台支持哪几种作为帐号登录游戏
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好!目前没有开通第三方登陆，建议您使用手机号或自定义号码进行账号注册。
                    </span></p>
                </div>

                <div class="content-t" id="28">
                    <p class="question">Q: 
                    我该怎么注册你们平台的账号
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好！在游戏内有一键注册的哦~输入手机号或自定义账号即可注册的。
                    </span></p>
                </div>

                <div class="content-t" id="29">
                    <p class="question">Q: 
                    我该怎么下载你们平台的游戏？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    您好,点击官网进入手上科技游戏平台，搜索需要的游戏选择下载即可。
                    </span></p>
                </div>

                <div class="content-t" id="30">
                    <p class="question">Q: 
                     游戏账号忘记了,怎么办?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                     您好，账号找回的方法很多，请您择优选用：
                    </span>
                     <span class="zwt">
                    1.通过绑定信息找回，绑定了密保手机，可以直接通过手机作为账号登录游戏。
                    </span>
                     <span class="zwt">
                    2.通过充值记录，如：支付宝账号，支付宝商户订单号(请使用电脑查询)，充值订单号，银行卡充值订单号等提供给客服查询。
                    </span></p>
                </div>

                <div class="content-t" id="31">
                    <p class="question">Q: 
                    账号在登陆时系统提示“账号被冻结或被锁定”怎么办?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    PS：联系在线客服或者电话客服进行解锁!
                    客服电话：0755-25113016， QQ：106778379
                    </span></p>
                </div>

                <div class="content-t" id="32">
                    <p class="question">Q: 
                    游戏闪退和无法登录解决方法？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    1、服务器问题
                    </span>
                    <span class="zwt">
                    解决方法：服务器出现故障，官方会给出相应补偿。
                    </span>
                    <span class="zwt">
                    2、游戏版本问题
                    </span>
                    <span class="zwt">
                    解决方法：检查游戏是否为最新版本。
                    </span>
                    <span class="zwt">
                    3、内存不足
                    </span>
                    <span class="zwt">
                    解决方法：手机内存不足时，建议退出游戏，先清理手机内存在进入游戏，关闭不必要的后台应用。
                    </span>
                    <span class="zwt">
                    4、手机网络不通畅
                    </span>
                    <span class="zwt">
                    解决方法：最好在网络信号好的地方玩游戏，或者使用wifi网络玩游戏，就不会出现无法连接服务器的情况。
                    </span>
                    <span class="zwt">
                    5、客户端不正常
                    </span>
                    <span class="zwt">
                    解决方法：建议在手上科技官网下载最新的客户端：点击下载
                    </span>
                    <span class="zwt">
                    6、输入了账号和密码然后点登陆，提示登陆失败。
                    </span>
                    <span class="zwt">
                    解决方法：SDK登陆密码不能有特殊字符的，而且系统时间也得符合。
                    </span>
                    <span class="zwt">
                    7、安装失败
                    </span>
                    <span class="zwt">
                    解决方法：用手上科技助手下载游戏在安装。
                    </span>
                    <span class="zwt">
                    8、卡登陆界面进不去在解压档案中，然后无限循环登陆的
                    </span>
                    <span class="zwt">
                    解决方法：重新登录下，进去别切出来。
                    </span>
                    </p>
                </div>

                <div class="content-t" id="33">
                    <p class="question">Q: 
                    手上科技游戏账号问题?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                     手上科技官网下载的游戏账号用手机号码注册成功后是通用的，比如：在手上科技下载《去吧皮卡丘》注册账号成功后，在《阴阳师》中是可以直接登陆的。
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