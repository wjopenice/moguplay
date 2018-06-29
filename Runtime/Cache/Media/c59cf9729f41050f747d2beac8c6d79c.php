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


    var ACTION_STR = '/media.php?s=/Recharge/chongzhi';
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


    <link rel="stylesheet" href="/Public/Media/css/cz.css">
<link rel="stylesheet" href="/Public/Media/css/dialog_base.css" />

<script src="/Public/Media/js/layer/layer.js" type="text/javascript"></script>

<!-- <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script> -->
<script type="text/javascript" src="/Public/Media/js/jquery-1.7.2.min.js"></script>



<!--banner-->
<!--<div class="bannner container" style="width:1200px;height: 120px;overflow: hidden ;margin:0 auto;">-->
   <!--<img src="<?php echo (get_cover($adv_recharg['data'],'path')); ?>" alt="" style="width:100%;"/>-->
<!--</div>-->

<!--充值部分-->
<div id="TabMain"  style="margin-top: 60px;margin-bottom: 80px;">
    <div class="tabItemContainer">
        <li><a class="tabItemCurrent">支付宝充值</a></li>
        <li><a>微信充值</a></li>
        <li><a>银联充值</a></li>
    </div>
    <div class="tabBodyContainer">
        <!--    支付宝充值      -->
        <div class="tabBodyItem tabBodyCurrent">
            <form action="" method="post" id="form_alipay_zl">
                <div class="content">
                    <div class="content-t">
                        <p class="title">充值到<span class="state">平台币</span>
                            <span style="color:#666;font-size:12px;padding-left:25px;display:none;">平台币是手上科技手机游戏平台统一支付的虚拟货币。玩家可以使用平台币兑换手上科技手机游戏平台旗下绝大部分游戏的游戏币。</span>
                        </p>
                        <p class="left">充值账号：</p> <input type="text" id="toaccount2" value="<?php echo ($account); ?>">
                        <p class="right">确认账号：</p> <input type="text" name="account" id="retoaccount2" value="<?php echo ($account); ?>" >
                    </div>
                    <div class="content-b">
                        <p class="content-b-t">充值金额</p>
                        <div class="money" id="mon">
                            <a href="javascript:;">10元</a>
                            <a href="javascript:;">20元</a>
                            <a href="javascript:;" >30元</a>
                            <a href="javascript:;">50元</a>
                            <a href="javascript:;" class="dj">100元</a>
                            <a href="javascript:;">200元</a>
                            <a href="javascript:;">300元</a>
                            <a href="javascript:;">500元</a>
                            <a href="javascript:;">1000元</a>
                            <a href="javascript:;">2000元</a>
                            <a href="javascript:;">3000元</a>
                            <a href="javascript:;">5000元</a>
                            <a href="javascript:;">10000元</a>
                        </div>
                        <div class="jinbi">
                            <p class="left">其它金额：</p> <input type="text" maxlength="10" size="10" name="money2" id="money3" class="money2 otherMoney" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" style="display: inline-block"><p class="right"> &nbsp;元</p>
                            <input type="hidden" id="alipay_amount" name="amount" value="" />
                            <input type="hidden" name="apitype" value="alipay" />
                            <span style="font-size:14px;">*比例&nbsp;:&nbsp;1元=1平台币=<?php echo ($points); ?>积分 </span>
                            <span style="font-size:14px;">获得平台币：<span class="stateMoney" id="game_coin">100</span> </span>
                            <span style="font-size:14px;">获得积分：<span class="getScore">1000</span> </span>
                        </div>

                        <a class="now" href="javascript:;" id="action">立即充值</a>
                    </div>
                    <div class="content-f">
                        <p>支付宝余额支付说明：</p>
                        <p>1、您必须拥有支付宝账户。</p>
                        <p>2、充值时请确认好您的充值金额准确无误后再充值，避免输错金额导致错误，如因未仔细确认金额造成的充值问题，我们将一律不予处理此类退款申诉。</p>
                        <p>3、在线客服咨询QQ ：<?php echo C('CH_SET_SERVER_QQ');?>&nbsp;&nbsp;&nbsp; <?php echo C('CH_SET_SERVER_QQ1');?></p>
                        <p>4、客服电话：<?php echo C('CH_SET_ZUOJI_PHONE');?>&nbsp;&nbsp;&nbsp;<?php echo C('CH_SET_SERVER_PHONE');?></p>
                    </div>
                </div>
            </form>
        </div>
        <!--    微信充值     -->
        <div class="tabBodyItem ">
            <form action="<?php echo U('Recharge/beginPay');?>" method="post" id="form_weixin_zl">
                <div class="content">
                    <div class="content-t">
                        <p class="title">充值到<span class="state">平台币</span>
                        <span style="color:#666;font-size:12px;padding-left:25px;display:none;">平台币是手上科技手机游戏平台统一支付的虚拟货币。玩家可以使用平台币兑换手上科技手机游戏平台旗下绝大部分游戏的游戏币。</span>
                        </p>
                        <p class="left">充值账号：</p> <input type="text" id="toaccount2_" value="<?php echo ($account); ?>">
                        <p class="right">确认账号：</p> <input type="text" name="uname2_" id="retoaccount2_" value="<?php echo ($account); ?>" >
                    </div>
                    <div class="content-b">
                        <p class="content-b-t">充值金额</p>
                        <div class="money" id="mon_">
                            <a href="javascript:;">10元</a> 
                            <a href="javascript:;">20元</a>
                            <a href="javascript:;" >30元</a>
                            <a href="javascript:;">50元</a>
                            <a href="javascript:;" class="dj">100元</a>
                            <a href="javascript:;">200元</a>
                            <a href="javascript:;">300元</a>
                            <a href="javascript:;">500元</a>
                            <a href="javascript:;">1000元</a>
                            <a href="javascript:;">2000元</a>
                            <a href="javascript:;">3000元</a>
                            <a href="javascript:;">5000元</a>
                            <a href="javascript:;">10000元</a>
                        </div>
                        <div class="jinbi">
                            <p class="left">其它金额：</p> <input type="text" maxlength="10" size="10" name="money2" id="money4" class="money2 otherMoney" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" style="display: inline-block"><p class="right"> &nbsp;元</p>
                            <input type="hidden" id="weixin_zl_amount" name="amount" value="" />
                            <input type="hidden" id="weixin_zl_user" name="account" value="" />
                            <input type="hidden" name="apitype" value="weixin" />
                            <span style="font-size:14px;">*比例&nbsp;:&nbsp;1元=1平台币=<?php echo ($points); ?>积分 </span>
                            <span  style="font-size:14px;">获得平台币：<span class="stateMoney"  id="game_coin2">100</span> </span>
                            <span style="font-size:14px;">获得积分：<span class="getScore">1000</a> </span>
                        </div>

                        <a class="now" href="javascript:;" id="action_">立即充值</a>
                    </div>
                    <div class="content-f">
                        <p>微信支付说明：</p>
                        <p>1、您必须拥有微信账户。</p>
                        <p>2、充值时请确认好您的充值金额准确无误后再充值，避免输错金额导致错误，如因未仔细确认金额造成的充值问题，我们将一律不予处理此类退款申诉。</p>
                        <p>3、在线客服咨询QQ ：<?php echo C('CH_SET_SERVER_QQ');?>&nbsp;&nbsp;&nbsp; <?php echo C('CH_SET_SERVER_QQ1');?></p>
                        <p>4、客服电话：<?php echo C('CH_SET_ZUOJI_PHONE');?>&nbsp;&nbsp;&nbsp;<?php echo C('CH_SET_SERVER_PHONE');?></p>
                    </div>
                </div>
            </form>
        </div>
        <!--    银联充值       -->
        <div class="tabBodyItem">
            <!--   银联充值表单     -->
            <form action="<?php echo U('Recharge/beginPay');?>" method="post" id="form_yinlian_zl">
                <div class="content">

                    <div class="content-t">
                        <p class="title">充值到<span class="state">平台币</span>
                            <span style="color:#666;font-size:12px;padding-left:25px;display:none;">平台币是手上科技手机游戏平台统一支付的虚拟货币。玩家可以使用平台币兑换手上科技手机游戏平台旗下绝大部分游戏的游戏币。</span>
                        </p>
                        <p class="left">充值账号：</p> <input type="text" id="unionPayAccount" value="<?php echo ($account); ?>">
                        <p class="right">确认账号：</p> <input type="text" name="orderAmount" id="unionPayConfirmAccount" value="<?php echo ($account); ?>" >
                    </div>
                    <input type="hidden" id="paytype" name="paytype" value="1" />
                    
                    <!--  银行卡类型   -->
                    <div class="cardType cf">
                        <p class="fl cardName">支付类型：</p>
                        <ul class="cf fl cardBox">
                            <li class="fl active">个人网银</li>
                            <li class="fl">企业网银</li>
                        </ul>
                    </div>
                    <div class="content-b">
                        <p class="content-b-t">充值金额</p>
                        <div class="money" id="unionPayMoneyBox">
                            <a href="javascript:;">10元</a>
                            <a href="javascript:;">20元</a>
                            <a href="javascript:;" >30元</a>
                            <a href="javascript:;">50元</a>
                            <a href="javascript:;" class="dj">100元</a>
                            <a href="javascript:;">200元</a>
                            <a href="javascript:;">300元</a>
                            <a href="javascript:;">500元</a>
                            <a href="javascript:;">1000元</a>
                            <a href="javascript:;">2000元</a>
                            <a href="javascript:;">3000元</a>
                            <a href="javascript:;">5000元</a>
                            <a href="javascript:;">10000元</a>
                        </div>
                        <div class="jinbi">
                            <p class="left">其它金额：</p> <input type="text" maxlength="10" size="10" name="money2" id="unionOtherMoney" class="money2 otherMoney" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" style="display: inline-block"><p class="right"> &nbsp;元</p>
                            <input type="hidden" id="yinLian_zl_amount" name="amount" value="" />
                            <input type="hidden" id="yinLian_zl_user" name="account" value="" />
                            <input type="hidden" name="apitype" value="yinLian" />
                            <span style="font-size:14px;">*比例&nbsp;:&nbsp;1元=1平台币=<?php echo ($points); ?>积分 </span>
                            <span  style="font-size:14px;">获得平台币：<span class="stateMoney" id="game_coin3">100</span> </span>
                            <span style="font-size:14px;">获得积分：<span class="getScore">1000</span> </span>
                        </div>

                        <a class="now" href="javascript:;" id="unionPayAction">立即充值</a>
                    </div>
                    <div class="content-f">
                        <p>银联支付说明：</p>
                        <p>1、您必须拥有银联账户。</p>
                        <p>2、充值时请确认好您的充值金额准确无误后再充值，避免输错金额导致错误，如因未仔细确认金额造成的充值问题，我们将一律不予处理此类退款申诉。</p>
                        <p>3、在线客服咨询QQ ：<?php echo C('CH_SET_SERVER_QQ');?>&nbsp;&nbsp;&nbsp; <?php echo C('CH_SET_SERVER_QQ1');?></p>
                        <p>4、客服电话：<?php echo C('CH_SET_ZUOJI_PHONE');?>&nbsp;&nbsp;&nbsp;<?php echo C('CH_SET_SERVER_PHONE');?></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 银联 弹出框-->
<div class="cart-win">
    <div class="win-box">
        <div class="mess-t">
            <p>请确认您的充值信息</p>
        </div>     
       <div class="mess-c">
            <form action="<?php echo ($url); ?>" method="POST" id="form_alipay" target="_blank">
                <p>充值账号 ：<input class="czzh" readonly="readonly"/></p>
                <p>充值方式 ：网银支付</p>
                <p>充值金额 ：<input name="amount" readonly="readonly" id="amount" maxlength="10" value="" />元</p>
                <input type="hidden" name="inputCharset" value="1" />
                <input type="hidden" name="pickupUrl" id="pickupUrl" value="<?php echo ($pickupUrl); ?>"/>
                <input type="hidden" name="receiveUrl" id="receiveUrl" value="<?php echo ($receiveUrl); ?>" />
                <input type="hidden" name="version" id="version" value="<?php echo ($version); ?>"/>
                <input type="hidden" name="signType" value="1" />
                <input type="hidden" name="merchantId" id="merchantId" value="" />
                <input type="hidden" name="orderNo" id="orderNo" value="" />
                <input type="hidden" name="orderAmount" id="orderAmount" value="" />
                <input type="hidden" name="orderDatetime" id="orderDatetime" value="" />
                <input type="hidden" name="payType" value="0" />
                <input type="hidden" name="tradeNature" value="GOODS" />
                <input type="hidden" name="signMsg" id="signMsg" value="" />
            </form>
        </div>

        <div class="mess-b">
            <a href="javascript:;" class="sure">确认提交</a>
            <a href="javascript:;" class="return">返回修改</a>
        </div>
    </div>
</div> 
<!-- <div class="cart-win">
    <div class="win-box">
        <div class="mess-t">
            <p>请确认您的充值信息</p>
        </div>     
       <div class="mess-c">
            <form action="<?php echo ($url); ?>" method="post" id="form_alipay" >
            <input type="hidden" name="inputCharset" value="1" />
            <input type="hidden" name="pickupUrl" id="pickupUrl" value="http://localhost:20081/demo/pickup.php"/>
            <input type="hidden" name="receiveUrl" id="receiveUrl" value="http://localhost:20081/demo/receive.php" />
            <input type="hidden" name="version" id="version" value="v1.0"/>
            <input type="hidden" name="signType" value="0" />
            <input type="hidden" name="merchantId" id="merchantId" value="100020091218001" />
            <input type="hidden" name="orderNo" id="orderNo" value="PF_20180315152030HrnN" />
            <input class="czje" name="orderAmount" value="1">
            <input type="hidden" name="orderDatetime" id="orderDatetime" value="20180315103703" />
            <input type="hidden" name="payType" value="0" />
            <input type="hidden" name="tradeNature" value="GOODS" />
            <input type="hidden" name="signMsg" id="signMsg" value="33FE8322F6D9C3F960C2BAF02A0300F6" />
            </form>
        </div>

        <div class="mess-b">
            <a href="javascript:;" class="sure">确认提交</a>
            <a href="javascript:;" class="return">返回修改</a>
        </div>
    </div>
</div> -->


<!--弹出框-->
<!-- <div class="cart-win">
    <div class="win-box">
        <div class="mess-t">
            <p>请确认您的充值信息</p>
        </div>     
       <div class="mess-c">
            <form action="<?php echo U('Recharge/beginPay');?>" method="post" id="form_alipay" >
            <p>充值账号 ：<input class="czzh" name="account" readonly="readonly"></p>
            <p>充值方式 ：<input class="czfs" value="支付宝支付" readonly="readonly"></p>
            <p>充值金额 ：<input class="czje" name="money" readonly="readonly" maxlength="10">元</p>
            <input type="hidden" name="apitype" value="alipay">
            </form>
        </div>

        <div class="mess-b">
            <a href="javascript:;" class="sure">确认提交</a>
            <a href="javascript:;" class="return">返回修改</a>
        </div>
    </div>
</div> -->
<!--弹出框第二步-->
<!-- <div class="bounce">
    <div class="box">
        <div class="bounce-t"><p>请确认您的充值信息</p></div>
        <div class="bounce-c">
            <p>付款完成前请不要关闭或者刷新此窗口</p>
            <p>完成付款后根据您的情况点击下面的按钮</p>
        </div>
        <div class="bounce-b">
            <a href="zfsuccess.html" class="check">查看充值结果</a>
            <a href="javascript:;" class="back">返回</a>
        </div>
    </div>

</div> -->

<!--尾巴部分-->

</body>
<script type="text/javascript" src="/Public/Media/js/jquery.min.js"></script>
<script src="/Public/Media/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">

    var verify=1;
    var errorMsg = "";//错误信息

    $(function(){
        //三种支付方式的切换
        $(document).on("click",'.tabItemContainer li',function(){
            var index = $(this).index();
            $(this).find("a").addClass('tabItemCurrent');
            $(this).siblings("li").find("a").removeClass('tabItemCurrent');
            $(".tabBodyContainer").find(".tabBodyItem").eq(index).show();
            $(".tabBodyContainer").find(".tabBodyItem").eq(index).siblings(".tabBodyItem").hide();
        });
        //点击平台币
        $(document).on("click",'.state',function(){
            $(this).next().toggle();
        });
        //充值金额的选择
        $(document).on("click",'.money a',function(){
            var otherMoney = $(this).parents(".tabBodyItem").find(".otherMoney").val();
            if(otherMoney){
                otherMoney = "";
            }
            var index = $(this).parents(".tabBodyItem").index() + 1;
            $(this).addClass("dj").siblings().removeClass("dj");
            $(this).parents(".tabBodyItem").find(".otherMoney").val("");
            var money = parseInt($(this).text().replace("元",""));
       
            if(index == 1){
                $("#game_coin").html(money);
                $("#game_coin").parent().next().find(".getScore").text(money * 10);
            }else{
                var gameId = "#game_coin"+index;
                $(gameId).html(money);
                $(gameId).parent().next().find(".getScore").text(money * 10);
            }
            
            //addNum(index,money);
        });
        //验证账号是否存在
        $(document).on("blur",'#toaccount2',function(){
            verifyAccount($("#toaccount2"));
        });
        $(document).on("blur",'#toaccount2_',function(){
            verifyAccount($("#toaccount2_"));
        });
        $(document).on("blur",'#unionPayAccount',function(){
            verifyAccount($("#unionPayAccount"));
        });
        //其他金额得到焦点去掉充值金额的选择状态
        $(document).on("focus",'.otherMoney',function(){
            var parent = $(this).parents(".tabBodyItem");
            if(parent.find(".money a").hasClass("dj")){
                parent.find(".money a").removeClass("dj");
            }
        });
        //其他金额键入
        $(document).on("keyup",'.otherMoney',function(){
            var parent = $(this).parents(".tabBodyItem");
            var index = parent.index() + 1;
            var money = $(this).val();

            if(index == 1){
                $("#game_coin").html(money);
                $("#game_coin").parent().next().find(".getScore").text(money * 10);
            }else{
                var gameId = "#game_coin"+index;
                $(gameId).html(money);
                $(gameId).parent().next().find(".getScore").text(money * 10);
            }
            //addNum(index,money);
        });

        //银行卡类型的切换
        $(document).on("click",'.cardBox li',function(){
            $(this).addClass('active').siblings().removeClass('active');
            console.log($(this).index());
            $("#paytype").attr("value",$(this).index() + 1);
        });

        //支付宝支付
        $("#action").on("click", function(){
            if($.trim($("#toaccount2").val()).length == 0){
                alert("充值账号不能为空!");
                return false;
            }
            if($.trim($("#retoaccount2").val()).length != $.trim($("#toaccount2").val()).length){
                alert("两次账号不相同!");
                return false;
            }
            if($("#game_coin").html() == 0){
                alert("请输入充值金额");
                return false;
            }

            if($.trim($("#toaccount2").val()).length !== 0){
                $.ajax({
                    url:"<?php echo U('Recharge/checkUser');?>", 
                    async:false,
                    data:{username:$("#toaccount2").val()},
                    type:"post",
                    dataType:"json",
                    success:function(data) {
                        alert(data);
                        verify=0;
                    },
                    error:function () {
                        return false;
                    }
                });

            }
            var alipay_data = $("#form_alipay_zl").serialize();
            alipay_data = alipay_data + "&money=" + $("#game_coin").html();
            $.post("/media.php?s=/Recharge/beginPay",alipay_data, function(json){
                //console.log(json);return ;
               // win.style.display='none';
                layer.open({
                    id:'iframe',
                    type:1,
                    title:'订单确认',
                    btn:['充值完成','返回'],
                    skin:'lay_pop',
                    style: ' background-color:#78BA32; color:#fff;',
                    content:json.html,
                    yes:function(index,layero) {
                        var lay = $(layero.selector);
                        window.location.reload();
                    },
                    cancel:function(index) {
                        layer.closeAll();
                    }
                });
            });   

        });
        //微信支付
        $("#action_").on("click", function(){
            var that = $('#form_weixin_zl');
            if($.trim($("#toaccount2_").val()).length == 0){
                alert("充值账号不能为空!");
                return false;
            }
            if($.trim($("#retoaccount2_").val()).length != $.trim($("#toaccount2_").val()).length){
                alert("两次账号不相同!");
                return false;
            }
            if($("#game_coin2").html() == 0){
                alert("请输入充值金额");
                return false;
            }

            var $amount=$("#game_coin4").html();
            var $account=$("#toaccount2_").val();
            $("#weixin_zl_amount").val($amount);
            $("#weixin_zl_user").val($account);

            // var loading = new Cute.ui.dialog().loading('加载中...',{mask:true});
            var wexin_data = that.serialize();
            wexin_data = wexin_data + "&money=" + $("#game_coin2").html();
            $.post("/media.php?s=/Recharge/beginPay",wexin_data, function(json){
                //console.log(json.payUrl);
                layer.open({
                    id:'iframe',
                    type:1,
                    title:'订单确认',
                    btn:['充值完成','返回'],
                    skin:'lay_pop',
                    style: ' background-color:#78BA32; color:#fff;',
                    content:json.html,
                    yes:function(index,layero) {
                        var lay = $(layero.selector);
                        window.location.reload();
                    },
                    cancel:function(index) {
                        layer.closeAll();
                    }
                });
            });

        });
        //银联支付
        $("#unionPayAction").on('click',function(){

            var that = $('#form_yinlian_zl');
            var money = $("#unionPayMoneyBox a").hasClass("dj")
                    ? parseInt($("#unionPayMoneyBox .dj").text().replace("元",""))
                    : $("#unionOtherMoney").val();//充值金额

            var verifyVal = verifyAcc($("#unionPayAccount"));
            verifyVal = verifyConfirmAcc($("#unionPayAccount"),$("#unionPayConfirmAccount")) && verifyVal;
            verifyVal = verifyMoney(money) && verifyVal;

            if(!verifyVal){
                alert(errorMsg);
                return false;
            }

            var $account = $("#unionPayAccount").val();//充值账号
            $("#yinLian_zl_amount").val(money);
            $("#yinLian_zl_user").val($account);

            var win=document.querySelector('.cart-win');
            var yinlian = $("#form_yinlian_zl").serialize();
            yinlian = yinlian + "&money=" + $("#game_coin3").html() ;
        
            $.post("/media.php?s=/Recharge/panPay",yinlian, function(json){
                console.log(json);
                if(json.status == 1){
                    $("#orderNo").val(json.data.orderNo); 
                    $("#signMsg").val(json.data.signMsg); 
                    $("#orderDatetime").val(json.data.orderDatetime); 
                    $("#amount").val(json.data.orderAmount/100);
                    $("#orderAmount").val(json.data.orderAmount);
                    $("#merchantId").val(json.data.merchantId);
                    var bounce=document.querySelector('.bounce');
                    var back=document.querySelector('.back');
                    var game=document.getElementById('game_coin2').innerHTML;
                    var zh=document.getElementById('unionPayAccount').value;
                  
                    var czzh=document.querySelector('.czzh');
                    //var czje=document.querySelector('.czje');
                    //czje.value=game*100;
                    czzh.value=zh;
                    win.style.display='block';
                }
               
            });

            var sure=document.querySelector('.sure');
            var ret =document.querySelector(".return");
            sure.onclick=function(){
                console.log($("#form_alipay").serialize());
                $("#form_alipay").submit();
                win.style.display='none';
            };
            //
            ret.onclick=function(){
                win.style.display='none';
            };

        });

    });

    //获得平台币和积分的变换  index为充值方式的索引
    function addNum(index,money){
        var parent = $(".tabBodyContainer").find(".tabBodyItem").eq(index);
        var score = money * 10;
        console.log(parent);
        // parent.find(".stateMoney").html(money);
        // parent.find(".getScore").text(score);

        parent.find(".stateMoney").remove();
        parent.find(".getScore").text(score);
    }
    //表单验证
    function verifyAccount(account){
        var account = $.trim(account.val());
        if(!account){
            alert("请填写您的充值账号");
            return false;
        }else{
            $.ajax({
                url:"<?php echo U('Recharge/checkUser');?>",
                data:{username:account},
                type:"post",
                dataType:"json",
                success:function(data) {
                    alert(data);
                    return false;
                },
                error:function () {
                    return false;
                }
            });
        }
    }
    function verifyAcc(account){
        var account = $.trim(account.val());
        if(!account){
            errorMsg = "充值账号不能为空";
            return false;
        }else{
            return true;
        }
    }
    function verifyConfirmAcc(account,confirmAcc){
        var account = $.trim(account.val());
        var confirmAcc = $.trim(confirmAcc.val());
        if(!confirmAcc){
            errorMsg = "请填写确认账号";
            return false;
        }else if(confirmAcc !== account){
            errorMsg = "请保持确认账号与充值账号一致";
            return false;
        }else{
            return true;
        }
    }
    function verifyMoney(money){
        var money = money;
        if(!money){
            errorMsg = "请填写或选择充值金额";
            return false;
        }else{
            return true;
        }
    }

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