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


    var ACTION_STR = '/media.php?s=/Public/login';
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


    <link rel="stylesheet" href="/Public/Media/css/login.css">

    <!--登录部分-->

    <div class="dl">
        <div style="width:1200px;margin:0 auto;position: relative;">
        <div class="login">
            <div class="login-t">
                <p>账号登录</p>
            </div>
            <div class="login-b">
                <form action="" method="post" id="submit" style="position: relative;">
                    <div class="ajax_tips" style="font-size:11px;color:#ed6557;position: absolute;top:10px;left:92px;"></div>

                    <div class="login-zh">
                        <input  class="zh" id="account" type="text" name="account" placeholder="账号"  />
                        <span class="icon-zh"></span>
                    </div>
                    <div class="zh_tips" style="font-size:11px;color:#FA1618;position: absolute;top:78px;left:92px;"></div>

                    <div class="login-mima">
                        <input  class="mima"  id="password" type="password" name="password" placeholder="密码"  />
                        <span class="icon-mima"></span>
                    </div>
                    <div class="mima_tips" style="font-size:11px;color:#FA1618;position: absolute;top:144px;left:92px;"></div>

                    <div class="login-code" style="display:none;">
                        <input  class="code"  id="identify" type="text" name="verify" placeholder="验证码" />
                        <span class="icon-code"></span>
                        <span id="identifying"> <img src="/media.php?s=/Public/verify" alt="" class="checkcode"> </span>
                    </div>

                    <div class="code_tips" style="font-size:11px;color:#ed6557;position: absolute;top:210px;left:92px;display:none"></div>

                    <div class="userOperation">
                        <a href="javascript:;" class="fl rememberPwd"><i class="chose active"></i>记住密码</a>
                        <a href="<?php echo U('Index/wjmm');?>" class="forgetPwd fr">忘记密码？</a>
                    </div>
                    <input type="button" value="登 &nbsp;录" class="denglu" id="login">
                    <div class="jzmm">
                        还没有账号?
                        <a href="<?php echo U('Public/register');?>">立即注册</a>
                    </div>

                </form>
            </div>
        </div>
        </div>
    </div>

    <!--友情链接-->
    <div class="lianjie clearfix ">
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
    <!--尾巴部分-->

</body>

<script src="/Public/Media/js/jquery-1.11.1.min.js"></script>
<script src="/Public/Media/js/jquery.cookie.js"></script>
<script>
$(function(){

    // 记住密码功能
    var remFlag=false;
    $(".jzmm").click(function(){
        remFlag=!remFlag;
        if(remFlag){
            $("#remember").attr("src", "/Public/Media/image/login/jizhumima.png");
        }else{
            $("#remember").attr("src", "/Public/Media/image/login/jizhumima-2.png");
        }
    });
    if ($.cookie("remFlag") == "true") {
        $("#remember").attr("src", "/Public/Media/image/login/jizhumima.png");
        remFlag=true;
        $.cookie("username")[0].type = 'password';
        $("#account").val($.cookie("username"));
        $("#password").val($.cookie("password"));
    }

    //点击记住密码
    $(document).on("click",'.chose',function(){
        if($(this).hasClass('active')){
            $(this).removeClass('active');
        }else{
            $(this).addClass('active');
        }
    });

    //验证账号
    $("#account").blur(function(){
        var $txt= $.trim($(this).val());
        if($txt==""){
            $(".zh_tips").html("*请输入账号");
            return false;
        }

        if(!/[a-zA-Z][a-zA-Z0-9]{5,14}/.test($txt)&& !/^[1][3,4,5,7,8][0-9]{9}$/.test($txt)){
            $(".zh_tips").html("*用户名格式不正确");
            return false;
        }else{
            $(".zh_tips").html("");
        }
    });
    //验证密码
    $("#password").blur(function(){
        var $psd= $.trim($(this).val());
        if($psd==''){
            $(".mima_tips").html("*请输入密码");
            return false;
        }

        if(!/^(?![0-9]+$)[0-9A-Za-z]{6,15}$/.test($psd)){
            $(".mima_tips").html("*密码格式不正确");
            return false;
        }else{
            $(".mima_tips").html("");
        }
    });    

        
    // 点击图片验证码进行切换       
    $('.checkcode').on('click',function(){
         var e = (new Date).getTime();
        $(this).attr('src', MODULE+'/Public/verify/t/'+e);
    })   

    // 验证验证码
    $("#identify").blur(function(){
        var $code= $.trim($('#identify').val());
        if($code==''){
            $(".code_tips").html("*验证码不能为空");
            return false;
        }
        if(!(/^[a-zA-Z0-9]{4}$/.test($code))){
            $(".code_tips").html("*验证码格式错误");
            return false;
        }else{
            $(".code_tips").html("");
        }
    });

    // 显示隐藏的验证码；
    function showcode(){
        $('.login-code').show();
        $('.code_tips').show();        
    }

    $("#login").click(function() {

        // 记住密码功能
        if (remFlag) {
            var str_username = $("#account").val();
            var str_password = $("#password").val();
            $("#remember").attr("src", "/Public/Media/image/login/jizhumima.png");
            $.cookie("remFlag", "true", { expires: 7 }); //存储一个带7天期限的cookie
            $.cookie("username", str_username, { expires: 7 });
            $.cookie("password", str_password, { expires: 7 });
        }
        else {
            $("#remember").attr("src", "/Public/Media/image/login/jizhumima-2.png");
            $.cookie("remFlag", "false", { expire: -1 });
            $.cookie("username", "", { expires: -1 });
            $.cookie("password", "", { expires: -1 });
        }


        //账号和密码验证// 账号
        $(".ajax_tips").html('') ;        
        var $txt= $.trim($("#account").val());
        if($txt==""){
            $(".zh_tips").html("*请输入账号");
            return false;
        };
        if(!/^[a-zA-Z0-9_]{6,30}$/.test($txt)){
            $(".zh_tips").html("*用户名格式不正确");
            return false;
        }else{
            $(".zh_tips").html("");
        }


        //密码
        var $psd= $.trim($("#password").val());
        if($psd==''){
            $(".mima_tips").html("*请输入密码");
            return false;
        }
        if(!/^[a-zA-Z0-9_]{6,16}$/.test($psd)){
            $(".mima_tips").html("*密码格式不正确");
            return false;
        }else{
            $(".mima_tips").html("");
        }


        // 验证验证码
        if($('.login-code').is(':visible')){
            var $code= $.trim($('#identify').val());
            if($code==''){
                $(".code_tips").html("*验证码不能为空");
                return false;
            }
            if(!(/^[a-zA-Z0-9]{4}$/.test($code))){
                $(".code_tips").html("*验证码格式错误");
                return false;
            }else{
                $(".code_tips").html("");
            }
            
        }

        // return;
        // ajax提交
        $.ajax({
                type: 'POST',
                async: true,
                dataType: 'json',
                url: "<?php echo U('Member/login');?>",//提交给后台的地址
                data: $('#submit').serialize(),
                beforeSend: function () {
                    $('#login').val('登录中').attr('disabled', true);
                },
                success: function (data) {
                    switch (parseInt(data['status'])) {
                        case 0:
                            $(".ajax_tips").html('*'+data['msg']);
                            $('#login').val('登录').attr('disabled', false);
                            break;
                        case 1:
                            $(".ajax_tips").html('');
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
                            $(".ajax_tips").html('*'+data['msg']);
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
                    alert('服务器故障，稍后再试');
                    $('#login').val('登录').attr('disabled', false);
                },
                cache: false
        });
        
    });
    

    $("#password").keydown(function (e) {
        if (e.which == 13) {
            $('#login').trigger("click");
            //触发搜索按钮的点击事件
        }
    });

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