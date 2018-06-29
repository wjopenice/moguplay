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


    var ACTION_STR = '/media.php?s=/Service/kfcz';
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
        <p>当前位置： <a href="<?php echo U('kefu');?>">客服中心 </a> > <a href="javascript:;">充值问题</a></p>
    </div>
    <div class="kf-b clearfix">

        <div class="tabItemContainer">
            <li ><span class="icon-mmwt"></span><a href="<?php echo U('Service/kfmm');?>">密码问题</a></li>
            <li class="tabItemCurrent"><span class="icon-cz"></span><a href="<?php echo U('Service/kfcz');?>">充值问题</a></li>
            <li><span class="icon-zh"></span><a href="<?php echo U('Service/kfzh');?>">账户问题</a></li>
            <li><span class="icon-lb"></span><a href="<?php echo U('Service/kflb');?>">礼包问题</a></li>
            <li><span class="icon-cj"></span><a href="<?php echo U('Service/kfzj');?>">常见问题</a></li>
        </div>

        <div class="tabBodyContainer">
            <div class="content">

                <div class="content-t" id="5">
                    <p class="question">Q: 
                    支付宝/微信充值扣费了，没到帐怎么办？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好!充值未能即时到账，可能是因为充值延迟所造成，如果较长时间仍未到帐，建议您到我们手上科技游戏官网联系QQ客服，提供相关账号信息以及扣费截图进行查询，感谢您对手上科技游戏平台的支持，祝您游戏愉快!
                    </span></p>
                </div>
                
                <div class="content-t" id="6">
                    <p class="question">Q: 
                    充值后没有给奖励
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好!请您确认您充值的时间是否在活动时间内，充值的金额是否符合活动要求。若还有疑问，请拨打我们的客服电话：0755-25113016 进行咨询，或者到我们手上科技游戏平台官网联系QQ客服：106778379反馈
                    </span></p>
                </div>

                <div class="content-t" id="7">
                    <p class="question">Q: 
                    点击充值无反应
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好!建议您可以先清除游戏数据的缓存，并确保网络良好后再进行充值。如果仍然无法充值，请到我们手上科技游戏官网重新下载安装游戏，在尝试充值。
                    </span></p>
                </div>

                <div class="content-t" id="8">
                    <p class="question">Q: 
                      充值后缺少道具、金币、钻石、元宝，怎么办?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好!建议您到我们手上科技游戏官网客服中心联系QQ客服，提供相关账号信息和充值信息进行查询
                    </span></p>
                </div>

                <div class="content-t" id="9">
                    <p class="question">Q: 
                    如何在游戏中进行充值？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好!在游戏的主界面中有“充值”选项(部分在“商城”中)点击进入金额选择界面，选择金额和支付方式后进入付费界面。
                    </span></p>
                </div>

                <div class="content-t" id="10">
                    <p class="question">Q: 
                     Q币能充值游戏吗?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                     亲爱的玩家：您好!目前手上科技游戏不支持Q币充值，请您登录我们的充值中心，选择适合您的充值方式进行充值。感谢您对手上科技游戏平台的支持，祝您游戏愉快!
                    </span></p>
                </div>

                <div class="content-t" id="11">
                    <p class="question">Q: 
                      手机话费是否可以充值?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    亲爱的玩家：您好!目前手上科技游戏暂不支持使用手机话费进行充值。
                    </span></p>
                </div>

                <div class="content-t" id="12">
                    <p class="question">Q: 
                    在充值返利活动中，你们平台为什么要在平台官方网站上充值平台币才行，直充不行？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                   您好，因为返利是我们平台币哦，不是游戏的返利呢，所以在游戏内直充是不能参与活动的。
                    </span>
                     <span class="zwt">
                   您好，可以充值未平台币以后使用平台币支付哦。平台币是可以输入金额的。
                    </span>
                    </p>
                </div>

                <div class="content-t" id="13">
                    <p class="question">Q: 
                    我不小心点错了，但没付款，导致消费记录里面显示“支付中”，该怎么办？会扣费吗？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    您好，没有完成支付是不会扣费的。
                    </span></p>
                </div>

                <div class="content-t" id="14">
                    <p class="question">Q: 
                    我想在游戏里面充值，但我不知道怎么充值，具体步骤是什么？
                    </p>
                    <p class="question">Q: 
                    如何取消支付宝快速支付？
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    您好!您可以进入浏览器，选择“工具”-“清除记录”，再选择“Cookies”，即可取消。
                    </span></p>
                </div>

                <div class="content-t" id="15">
                    <p class="question">Q: 
                     支付宝充值失败了，钱会扣除吗?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                    您好，充值失败一般是不会扣除您的钱的。但如果出现充值失败钱也扣除情况，请马上联系客服，客服会为您核实处理的。客服联系电话：010-85655922， 
                    温馨提示：一般出现充值失败有可能是游戏厂商内部更新问题，小编建议采取人工充值。
                    </span></p>
                </div>

                <div class="content-t" id="16">
                    <p class="question">Q: 
                     扣费成功但没收到游戏币，怎么办?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                      亲爱的玩家：您好!如果您支付完成扣款成功，但您的游戏账号里没有收到游戏币，这时可能是由于网络延迟而造成的，请您耐心等待几分钟即可!如果较长时间仍未到帐，可能是系统出现问题，这时候您可以联系【QQ客服】提交给我们的客服进行处理。感谢您对手上科技游戏平台的支持，祝您游戏愉快!
                     客服电话：0755-25113016, QQ：106778379
                    </span></p>
                </div>

                <div class="content-t" id="17">
                    <p class="question">Q: 
                    如何选择合适的充值方式?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                     如果您拥有支付宝帐号，我们建议您采用支付宝方式支付;
                     如果您开通了网上银行，我们建议您采用支付宝支付；
                     注：可以联系客服，进行人工充值，省心省力态度好。
                    </span></p>
                </div>

                <div class="content-t" id="18">
                    <p class="question">Q: 
                    充值中心提供了哪些充值方式?
                    </p>
                    <p class="answer"><span class="an">A:</span>
                    <span class="zwt">
                     亲爱的玩家：您好!手上科技游戏为您提供快捷、便利、多样化的充值方式，具体如下：支付宝、人工充值(联系客服)。感谢您对手上科技游戏平台的支持，祝您游戏愉快!
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