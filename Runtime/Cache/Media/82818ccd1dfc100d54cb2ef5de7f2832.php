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


    var ACTION_STR = '/media.php?s=/Public/register';
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


    <link rel="stylesheet" href="/Public/Media/css/register.css">

<!--中间部分-->
<div class="kf container clearfix">
   
    <div class="kf-b clearfix">
        <div id="TabMain">
            <div class="tabItemContainer">
                <li  class="tabItemCurrent"><span class="icon-mmwt"></span><a >用户名注册</a></li>
                <li><span class="icon-ip"></span><a>手机号注册</a></li>
                <div class="list3">
                    <p class="have">已有游戏账号？</p> <br>
                    <a class="rlogin" href="<?php echo U('Public/login');?>">立即登录</a>
                </div>
            </div>
            <div class="tabBodyContainer">
                <div class="tabBodyItem tabBodyCurrent">
                    <div class="content-t">
                     <p class="rep1">您当前选择的是 <a href="javascript:;">用户名注册</a> 方式</p>
                      <p class="rep2">以下内容我们承诺您的安全信息，不会透露给第三方</p>
                        <div class="reset"><span class="h">用户账号：</span> <input type="text" class="shuru" id="reaccount"> <span id="reacctips"> <i class="star">* </i><span class="zi"> 请输入 6-15 位由字母和数字组成 , 以字母开头</span></span></div>
                        <div class="reset"><span class="h">设置密码：</span> <input type="password" class="shuru" id="repassword">  <span id="repasstips"><i class="star">* </i><span class="zi"> 请输入 6-15 位数字、字母组成</span></span></div>
                        <div class="reset"><span class="h">确认密码：</span> <input type="password" class="shuru" id="resurepassword"> <span id="resuretips"> <i class="star">* </i><span class="zi"> 请再次输入密码</span></span> </div>
                        <div class="reset"><span class="h" style="text-indent: 1em">验证码：</span> <input type="text" class="shuru" id="identify" maxlength="4"><span id="identifying"> <img src="/media.php?s=/Public/verify" alt="" class="checkcode"> </span> <span id="reidentifytips"> <i class="star"></i><span class="zi"></span></span> </div>
                        <div class="reset"><span class="h">常用邮箱：</span> <input type="text" class="shuru" id="reemail">  <span id="reemailtips"><i class="star"></i>&nbsp;<span class="zi"> 请输入常用邮箱 ，该邮箱可用于找回账号密码</span></span></div>
                    </div>
                    <div class="content-b">
                        <p class="basis">根据2010年8月1日实施的《网络游戏管理暂行办法》，网络游戏用户需使用有效身份证件进行实名注册。为保证流畅游戏体验，享受健康游戏生活，请广大游戏玩家尽快实名注册，且实名信息将不可更改。</p>
                        <div class="reset"><span class="h">真实姓名：</span> <input type="text" class="shuru" id="rename"> <span id="rerelname"> <i class="star">* </i><span class="zi"> 请输入您的真实姓名</span></span></div>
                        <div class="reset"><span class="h">身份证号：</span> <input type="text" class="shuru" id="reid">  <span id="reidcard"><i class="star">* </i><span class="zi"> 请输入您的身份证号</span></span></div>
                        <p class="read" id="rem"><span id="pics"><img src="/Public/Media/image/wjmm/tongyixieyi_2.png" alt="" class="remember"><span id="agree" class="red">我已阅读并同意</span> </span> <a href="javascript:;" id="xieyi">《手上科技手游用户注册协议》</a></p>
                        <input type="submit" class="registerfin" id="finished" value="完成注册" style="cursor: pointer;">
                    </div>

                </div>
                <div class="tabBodyItem">
                    <form action="" method="post" id="iphoneregister">
                    <div class="content-t">
                        <p class="rep1">您当前选择的是 <a href="javascript:;">手机注册</a> 方式</p>
                        <p class="rep2">以下内容我们承诺您的安全信息，不会透露给第三方。<span>* 该手机号将是您唯一的登录账号</span></p>
                        <div class="iphone"><span class="h">&nbsp;&nbsp;&nbsp;手机号：</span> <input type="text"  id="reaccount2"><a href="javascript:;" class="send" id="ident">发送验证码</a> <span id="iptel"><i class="star">* </i><span class="zi">请输入您的手机号</span></span></div>
                        <div class="reset"><span class="h">&nbsp;&nbsp;&nbsp;验证码：</span> <input type="text"  id="repassword2">  <span id="ipcode"><i class="star">* </i><span class="zi"> 请输入您的验证码</span></span></div>
                        <div class="reset"><span class="h">设置密码：</span> <input type="password"  id="resurepassword2">  <span id="ippassword"><i class="star">* </i><span class="zi"> 请输入 6-30 位数字、字母组成</span></span></div>
                        <div class="reset"><span class="h">常用邮箱：</span> <input type="text" id="reemail2"> <span id="ipsureemail"> <i class="star"></i>&nbsp;<span class="zi"> 请输入常用邮箱 ，该邮箱可用于找回账号密码</span></span></div>
                    </div>
                    <div class="content-b">
                        <p class="basis">根据2010年8月1日实施的《网络游戏管理暂行办法》，网络游戏用户需使用有效身份证件进行实名注册。为保证流畅游戏体验，享受健康游戏生活，请广大游戏玩家尽快实名注册，且实名信息将不可更改。</p>
                        <div class="reset"><span class="h">真实姓名：</span> <input type="text" class="shuru" id="rename2"> <span id="ipname"> <i class="star">* </i><span class="zi"> 请输入您的真实姓名</span></span></div>
                        <div class="reset"><span class="h">身份证号：</span> <input type="text" class="shuru" id="reid2"> <span id="ipcard"><i class="star">* </i><span class="zi"> 请输入您的身份证号</span></span> </div>
                        <p class="read"><span id="prints"><img src="/Public/Media/image/wjmm/tongyixieyi_2.png" alt="" class="remember2"><span id="agree2" class="red">我已阅读并同意</span></span>  <a href="javascript:;" id="phxieyi">《手上科技手游用户注册协议》</a></p>
                        <input type="button" class="registerfin" id="finished2" value="完成注册" style="cursor: pointer;" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--协议部分弹窗-->
<div class="protocolpop" id="tc">
    <div class="agreement">
        <div class="agree-top"><h1>手上科技游戏平台网站服务使用协议</h1></div>
        <div class="box" id="box">
            <div class="content" id="content">
                <div class="content-main">
                    <h1 class="all">一、总则</h1>
                    <p>您注册成为手上科技游戏平台手机游戏平台注册用户之前，应仔细阅读本服务协议及免责声明和隐私条款。北京手上科技科技有限公司作为手上科技游戏平台手机游戏平台的经营者，根据本服务协议及随时对其的修改向您提供基于互联网以及移动网的相关服务（下称"网络服务"）。如您不同意本服务协议、免责声明、隐私条款、或随时对该等内容的修改等，您可以主动取消手上科技游戏平台手机游戏平台提供的网络服务。您一旦使用手上科技游戏平台手机游戏平台网络服务，即视为您已了解并完全同意本服务协议各项内容、免责声明和隐私条款，包括手上科技游戏平台手机游戏平台对本服务协议随时所做的任何修改，并成为手上科技游戏平台手机游戏平台注册用户（以下简称"用户"）。</p>
                    <p>1.1 用户应当同意本协议的条款并按照页面上的提示完成全部的注册程序。用户在进行注册程序过程中点击"同意"按钮即表示用户与手上科技游戏平台手机游戏平台达成协议，完全接受本协议项下的全部条款。</p>
                    <p>1.2 用户注册成功后，手上科技游戏平台手机游戏平台将给予每个用户一个用户账号及相应的密码，该用户账号和密码由用户负责保管。用户应当对以其用户账号进行的所有活动和事件负法律责任。</p>
                    <p>1.3 用户使用手上科技游戏平台手机游戏平台网络服务中包含的各个单项服务的，应当遵守本服务协议的规定。如该单项服务具有单独的服务条款、公告等单项服务协议的，此单项服务协议与本协议一同构成双方协议的整体。</p>
                    <p>1.4 本服务协议、免责声明、隐私条款、单项服务协议等可由手上科技游戏平台手机游戏平台随时更新、发布，且无需另行通知。您在使用相关服务时，应关注并遵守您所适用的相关条款。</p>
                    <h2 class="all">二、注册信息和隐私保护</h2>
                    <p>2.1 手上科技游戏平台手机游戏平台账号（即手上科技游戏平台手机游戏平台用户ID）的所有权归手上科技游戏平台手机游戏平台，用户完成注册申请手续后，获得手上科技游戏平台手机游戏平台账号的使用权。用户应提供及时、详尽及准确的个人资料，并不断更新注册资料，符合及时、详尽准确的要求。所有原始键入的资料将作为注册资料。如果因用户注册信息不真实而引起的问题及其产生的后果，手上科技游戏平台手机游戏平台不负任何责任。</p>
                    <p>2.2 用户不得将其账号、密码转让或出借予他人使用。如用户发现其账号遭他人非法使用，应立即通知手上科技游戏平台手机游戏平台。因黑客行为或用户的保管疏忽导致账号、密码遭他人非法使用，手上科技游戏平台手机游戏平台不承担任何责任。</p>
                    <p>2.3 手上科技游戏平台手机游戏平台不对外公开或向第三方提供单个用户的注册资料，除非：</p>
                    <p>1) 事先获得用户的明确授权；</p>
                    <p>2) 只有透露您的个人资料，才能提供您所要求的产品和服务；</p>
                    <p>3) 根据有关的法律法规要求；</p>
                    <p>4) 按照相关政府主管部门的要求</p>
                    <p>5) 为维护手上科技游戏平台的合法权益。</p>
                    <p>2.4 在您注册手上科技游戏平台手机游戏平台账户，使用其他手上科技游戏平台手机游戏平台产品或服务，访问手上科技游戏平台手机游戏平台网页或参加促销和有奖游戏时，手上科技游戏平台手机游戏平台会收集您的个人身份识别资料（请参见隐私条款），并会将这些资料用于为您提供的服务及网页内容。</p>
                    <p>2.5 用户的手上科技游戏平台手机游戏平台帐号在任何连续180日内未实际使用，则手上科技游戏平台手机游戏平台有权删除该帐号并停止为您提供相关的网络服务，但单项服务协议有特殊规定的除外。</p>

                    <h2 class="all">三、使用规则</h2>
                    <p>3.1 用户在使用手上科技游戏平台手机游戏平台网络服务时，必须遵守中华人民共和国相关法律法规的规定，用户应同意将不会利用本服务进行任何违法或不正当的活动，包括但不限于下列行为：</p>
                    <p>3.1.1 上载、展示、张贴、传播或以其它方式传送含有下列内容之一的信息：</p>
                    <p>1) 反对宪法所确定的基本原则的；</p>
                    <p>2) 危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；</p>
                    <p>3) 损害国家荣誉和利益的；</p>
                    <p>4) 煽动民族仇恨、民族歧视、破坏民族团结的；</p>
                    <p>5) 破坏国家宗教政策，宣扬邪教和封建迷信的；</p>
                    <p>6) 散布谣言，扰乱社会秩序，破坏社会稳定的；</p>
                    <p>7) 散布淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的；</p>
                    <p>8) 侮辱或者诽谤他人，侵害他人合法权利的； </p>
                    <p>9) 含有虚假、有害、胁迫、侵害他人隐私、骚扰、侵害、中伤、粗俗、猥亵、或其它道德上令人反感的内容；</p>
                    <p>10) 含有中国法律、法规、规章、条例以及任何具有法律效力之规范所限制或禁止的其它内容的。</p>
                    <p>3.1.2 不得为任何非法目的而使用网络服务系统。</p>
                    <p>3.1.3 不利用本公司服务从事以下活动：</p>
                    <p>1) 未经允许，进入计算机信息网络或者使用计算机信息网络资源的；</p>
                    <p>2) 未经允许，对计算机信息网络功能进行删除、修改或者增加的；</p>
                    <p>3) 未经允许，对进入计算机信息网络中存储、处理或者传输的数据和应用程序进行删除、修改或者增加的；</p>
                    <p>4) 故意制作、传播计算机病毒等破坏性程序的；</p>
                    <p>5) 其他危害计算机信息网络安全的行为。</p>
                    <p>3.2 用户违反本服务协议，导致或产生的任何第三方主张的任何索赔、要求或损失，包括合理的律师费，您同意赔偿手上科技游戏平台与合作公司、关联公司，并使之免受损害。对此，手上科技游戏平台有权视用户的行为性质，采取包括但不限于删除用户发布信息内容、暂停使用许可、终止服务、限制使用、回收手上科技游戏平台账号、追究法律责任等措施。对恶意注册手上科技游戏平台账号或利用手上科技游戏平台账号进行违法活动、捣乱、骚扰、欺骗、其他用户以及其他违反本协议的行为，手上科技游戏平台有权回收其账号。同时，手上科技游戏平台会视司法部门的要求，协助调查。</p>
                    <p>3.3 用户须对自己在使用手上科技游戏平台手机游戏平台网络服务过程中的行为承担法律责任。用户承担法律责任的形式包括但不限于：对受到侵害者进行赔偿，以及在手上科技游戏平台手机游戏平台在先承担了因用户行为导致的行政处罚或侵权损害赔偿责任后，用户应给予手上科技游戏平台手机游戏平台等额的赔偿。</p>

                    <h2 class="all">四、服务内容</h2>
                    <p>4.1 手上科技游戏平台手机游戏平台网络服务的具体内容由手上科技游戏平台手机游戏平台根据实际情况提供，手上科技游戏平台手机游戏平台对其提供之服务拥有最终解释权。</p>
                    <p>4.2 除非本服务协议另有其它明确规定，手上科技游戏平台手机游戏平台在用户注册后所推出的新产品、新功能、新服务，均受到本服务协议之规范。</p>
                    <p>4.3 为使用本网络服务，您必须能够自行经有法律资格对您提供互联网接入服务的第三方，进入国际互联网，并应自行支付相关服务费用。此外，您必须自行配备及负责与国际联网连线所需之一切必要装备，包括计算机、数据机或其它存取装置。</p>
                    <p>4.4 手上科技游戏平台手机游戏平台会根据您的搜索需求提供与其它国际互联网上之网站或资源之链接。由于手上科技游戏平台手机游戏平台无法控制这些网站及资源，您了解并同意，此类网站或资源是否可供利用，手上科技游戏平台手机游戏平台不予负责，存在或源于此类网站或资源之任何内容、广告、产品或其它资料，手上科技游戏平台手机游戏平台亦不予保证或负责。因使用或依赖任何此类网站或资源发布的或经由此类网站或资源获得的任何内容、商品或服务所产生的任何损害或损失，手上科技游戏平台手机游戏平台对其合法性不负责，亦不承担任何责任。</p>
                    <p>4.5 用户完全理解并同意，任何原因下，用户使用网路服务储存的信息或数据等全部或部分发生毁损、灭失或无法恢复的风险，均由用户须自行承担，手上科技游戏平台手机游戏平台不承担任何责任。</p>
                    <p>4.6 用户了解并理解，任何经由本服务发布的图形、图片或个人言论等，均表示了内容提供者、服务使用者个人的观点、观念和思想，并不代表手上科技游戏平台手机游戏平台的观点或主张，对于在享受网络服务的过程中可能会接触到令人不快、不适当等内容的，由用户个人自行加以判断并承担所有风险，手上科技游戏平台手机游戏平台不承担任何责任。</p>
                    <p>4.7 用户完全理解并同意，用户通过手上科技游戏平台手机游戏平台服务购买酒店或此后新的产品和服务，将按照网络服务中展示的说明、规定或政策等合理、及时维护自身合法权益，履行相关义务，该等说明、规定或政策等与本服务协议共同构成用户与手上科技游戏平台手机游戏平台的整体协议，用户必须严格遵守。</p>
                    <p>4.8 用户完全理解并同意，手上科技游戏平台手机游戏平台将会通过邮件、短信、电话等形式，向您发送订单信息、促销活动等告知信息服务。如您不同意该等信息服务，可以按照手上科技游戏平台手机游戏平台提供的方式取消该等服务。</p>

                    <h2 class="all">五、服务的变更、中断或终止</h2>
                    <p>5.1 用户完全理解并同意，本服务涉及到互联网及移动通讯等服务，可能会受到各个环节不稳定因素的影响。因此任何因不可抗力、计算机病毒或黑客攻击、系统不稳定、用户所在位置、用户关机、GSM网络、互联网络、通信线路原因等造成的服务中断或可能造成服务取消或终止的风险，使用本服务的用户须自行承担以上风险，手上科技游戏平台手机游戏平台对服务之及时性、安全性、准确性不做任何保证。</p>
                    <p>5.2 手上科技游戏平台手机游戏平台需要定期或不定期地对提供网络服务的平台或相关的设备进行检修或者维护，如因此类情况而造成网络服务（包括收费网络服务）在合理时间内的中断，手上科技游戏平台手机游戏平台无需为此承担任何责任。手上科技游戏平台手机游戏平台保留不经事先通知为维修保养、升级或其它目的暂停全部或部分的网络服务的权利。</p>
                    <p>5.3 用户完全理解并同意，除本服务协议另有规定外，鉴于网络服务的特殊性，手上科技游戏平台手机游戏平台有权随时变更、中断或终止部分或全部的网络服务，且无需通知用户，也无需对任何用户或任何第三方承担任何责任。</p>

                    <h2 class="all">六、知识产权和其他合法权益</h2>
                    <p>6.1 用户专属权利</p>
                    <p>6.1.1 手上科技游戏平台手机游戏平台尊重他人知识产权和合法权益，呼吁用户也要同样尊重知识产权和他人合法权益。若您认为您的知识产权或其他合法权益被侵犯，可以向手上科技游戏平台手机游戏平台发出权利通知。为有效处理您的投诉，请按照以下说明向手上科技游戏平台手机游戏平台提供资料：和礼仪的规范，用户将自行承担用户所发布的信息内容的责任。用户发布的各类信息，不得包含以下内容：</p>
                    <p>1) 权利人对涉嫌侵权内容拥有知识产权或其他合法权益和/或依法可以行使知识产权或其他合法权益的权属证明；</p>
                    <p>2) 请充分、明确地描述被侵犯知识产权或其他合法权益的情况；</p>
                    <p>3) 请指明涉嫌侵权网页的哪些内容侵犯了2)中列明的权利；</p>
                    <p>4) 请提供权利人具体的联络信息，包括姓名、身份证或护照复印件（对自然人）、单位登记证明复印件（对单位）、通信地址、电话号码、传真和电子邮件；</p>
                    <p>5) 请提供涉嫌侵权内容在信息网络上的位置（如指明您举报的含有侵权内容的出处，即：指网页地址或网页内的位置）以便我们与您举报的含有侵权内容的网页的所有权人或管理人联系；</p>
                    <p>6) 请在权利通知中加入如下关于通知内容真实性的声明："我保证，本通知中所述信息是充分、真实、准确的，如果本权利通知内容不完全属实，本人将承担由此产生的一切法律责任。"手上科技游戏平台手机游戏平台一旦收到符合上述要求之通知，手上科技游戏平台手机游戏平台将采取包括删除等相应措施。如不符合上述条件，手上科技游戏平台手机游戏平台会请您提供相应信息，且暂不采取包括删除等相应措施。手上科技游戏平台手机游戏平台提请您注意：如果您的权利通知的陈述失实，权利通知提交者将承担对由此造成的全部法律责任（包括但不限于赔偿各种费用及律师费）。如果上述个人或单位不确定网络上可获取的资料是否侵犯了其知识产权和其他合法权益，手上科技游戏平台手机游戏平台建议该个人或单位首先咨询专业人士。</p>
                    <p>6.1.2 对于用户通过网络服务上传的任何在公开区域可获取的并受著作权保护的内容，用户应对该等内容的真实性、合法性负责，保证对该等内容拥有完整的、无瑕疵的所有权和知识产权或拥有完整的授权，并不存在任何侵犯或足以侵犯任何第三方的合法权益，包括但不限于著作权、肖像权、商标权、专利权、企业名称权、商号权、商业秘密、个人隐私、合同权利等权利。所有因用户非法上传内容而给任何第三方或手上科技游戏平台手机游戏平台造成的损害均由用户个人承当全部的责任，手上科技游戏平台手机游戏平台不承担任何责任，且手上科技游戏平台手机游戏平台有义务配合第三方、司法机关或行政机关完成相关的取证，并根据法律、主管部门或司法部门的要求将用户注册信息给予披露。用户完全理解并同意，就前款内容上附有的所有著作权财产权权利，授予手上科技游戏平台手机游戏平台在全世界范围内具有免费的、永久性的、不可撤销的、非独家的的许可以及再许可的权利。用户同时授予手上科技游戏平台手机游戏平台就任何主体侵犯该等内容的知识产权的行为而单独采用法律救济手段包括诉讼，并获得全部赔偿的权利。用户浏览、复制、打印和传播手上科技游戏平台手机游戏平台其他用户上传到手上科技游戏平台手机游戏平台网站的内容，应保证仅用于个人欣赏之目的，不得用于商业目的，不得侵犯权利人的合法权益以及手上科技游戏平台手机游戏平台的合法权益和商业利益。任何用户违反此条规定的，手上科技游戏平台手机游戏平台均有权以自身名义利用法律手段寻求权利救济或据本协议追究您的违约责任。</p>
                    <p>6.2 手上科技游戏平台手机游戏平台专属权利</p>
                    <p>6.2.1 除用户上传内容以及明显归属于合作伙伴、第三方所有的信息资料外，手上科技游戏平台手机游戏平台拥有网路服务内所有内容，包括但不限于文字、图片、图形、表格、动画、程序、软件等单独或组合的版权。任何被授权的浏览、复制、打印和传播属于本网站内的内容必须符合以下条件：</p>
                    <p>1) 所有的资料和图象均以获得信息为目的；</p>
                    <p>2) 所有的资料和图象均不得用于商业目的；</p>
                    <p>3) 所有的资料、图象及其任何部分都必须包括此版权声明。未经手上科技游戏平台手机游戏平台许可，任何人不得擅自，包括但不限于以非法的方式复制、传播、展示、镜像、上载、下载使用。否则，手上科技游戏平台手机游戏平台将依法追究法律责任。</p>
                    <p>6.2.2 手上科技游戏平台手机游戏平台为提供网络服务而自行开发的软件，包括无线客户端应用等，拥有完整的知识产权。手上科技游戏平台手机游戏平台在此授予您个人非独家、不可转让、可撤销的，并通过一个手上科技游戏平台手机游戏平台注册账户且在一部拥有所有权或使用权的手机或计算机上使用手上科技游戏平台手机游戏平台软件的权利，且该使用仅限于个人非商业性使用之合法目的。手上科技游戏平台手机游戏平台有权对该等软件进行时不时的修订、扩展、升级等更新措施，而无需提前通知用户，但您有权选择是否使用更新后的软件。您应当保证合法使用该等软件，任何用户不得对该等软件进行如下违法行为：</p>
                    <p>1) 开展反向工程、反向编译或反汇编，或以其他方式发现其原始编码，以及实施任何涉嫌侵害著作权的行为；</p>
                    <p>2) 以出租、租赁、销售、转授权、分配或其他任何方式向第三方转让该等软件或利用该等软件为任何第三方提供相似服务；</p>
                    <p>3) 任何复制该等软件的行为；</p>
                    <p>4) 以移除、规避、破坏、损害或其他任何方式干扰该等软件的安全功能；</p>
                    <p>5) 以不正当手段取消该等软件上权利声明或权利通知的；</p>
                    <p>6) 其他违反法律规定的行为。</p>
                    <p>6.2.3 "手上科技游戏平台手机游戏平台"、手上科技游戏平台手机游戏平台网络服务LOGO等为手上科技游戏平台手机游戏平台的注册商标，受法律的保护。任何用户不得侵犯手上科技游戏平台手机游戏平台注册商标权。</p>

                    <h2 class="all">七、其他</h2>
                    <p>7.1 本协议的订立、执行和解释及争议的解决均应适用中华人民共和国法律。</p>
                    <p>7.2 如双方就本协议内容或其执行发生任何争议，双方应尽量友好协商解决；协商不成时，任何一方均可向手上科技游戏平台所在地的人民法院提起诉讼。</p>
                    <p>7.3 手上科技游戏平台手机游戏平台未行使或执行本服务协议任何权利或规定，不构成对前述权利或权利之放弃。</p>
                    <p>7.4 如本协议中的任何条款无论因何种原因完全或部分无效或不具有执行力，本协议的其余条款仍应有效并且有约束力。请您在发现任何违反本服务协议情形时，通知手上科技游戏平台手机游戏平台。您可以通过在线反馈方式提交您的意见。</p>
                </div>
                <div class="content-footer">
                    <p>为用户营造舒适、公平、富有人情味的游戏环境是我们的目的。手上科技游戏平台关注用户需求，随时敞开心扉接纳不同地域、年龄和文化背景的用户。不论是在各自工作岗位上行使着自己使命的手上科技游戏工作人员，或是数以万计在手上科技游戏平台游戏中扮演不同角色的用户，都对网游抱怀着许多的期待和梦想。我们对尊重游戏规则和尊重他人的用户满怀感激和敬意，让我们携手创造一个绿色的游戏环境！</p>
                    <p>青少年用户必须遵守全国青少年网络文明公约：要善于网上学习，不浏览不良信息；要诚实友好交流，不侮辱欺诈他人；要增强自护意识，不随意约会网友；要维护网络安全，不破坏网络秩序；要有益身心健康，不沉溺虚拟时空。</p>
                </div>
            </div>
            <div id="scroll" class="scroll">
                <div class="bar" id="bar"></div>
            </div>
        </div>
        <div class="agree-bottom"><a href="javascript:;" class="consent" id="agreed">同意并关闭</a></div>

    </div>
</div>
</body>
<script type="text/javascript" src="/Public/Media/js/jquery.min.js"></script>
<script type="text/javascript">
    var IMG = "/Public/Media/image";
    var MODULE = "/media.php?s=";
    var emailbangcheck="<?php echo U('Public/emailbangcheck');?>";
</script>
<script src="/Public/Media/js/register3.js"></script>
<script>

    $(document).ready(function(e) {
        SidebarTabHandler.Init();
    });
    var SidebarTabHandler={
        Init:function(){
            $(".tabItemContainer>li").click(function(){
                $(".tabItemContainer>li").removeClass("tabItemCurrent");
                $(".tabBodyItem").removeClass("tabBodyCurrent");
                $(this).addClass("tabItemCurrent");
                $($(".tabBodyItem")[$(this).index()]).addClass("tabBodyCurrent");

            });
        }
    };
</script>

<script>
// 用户名注册同意协议的弹框
    var xy=document.getElementById('xieyi');
    var pro=document.getElementById('tc');
    var agree=document.getElementById('ty');
    xy.onclick=function () {        
        pro.style.display='block';
    var box = document.getElementById("box");
    var content = document.getElementById("content");
    var scroll = box.children[1];
    var bar = scroll.children[0];
    var bili = content.offsetHeight / box.offsetHeight;
    //1.1 使用scroll的高除以比例
    bar.style.height = scroll.offsetHeight / bili + "px";
    bar.onmousedown = function (e) {
        var e = e || window.event;
        var y = getPY(e) - box.offsetTop - bar.offsetTop;
        document.onmousemove = function (e) {
            var e = e || window.event;
            var currentY = getPY(e) - y - box.offsetTop;
            currentY = currentY < 0 ? 0 : currentY;

            var tar = scroll.offsetHeight - bar.offsetHeight;

            currentY = currentY > tar ? tar : currentY;
            bar.style.top = currentY + "px";
            window.getSelection ? window.getSelection().removeAllRanges() : document.selection.empty();
            content.style.marginTop = -bili * currentY + "px";

        }
    };
    document.onmouseup = function () {
        document.onmousemove = null;
    }

    function getEvent(e) {
        return e || window.event;
    }

    function winS() {
        return {
            left: window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft || 0,
            top: window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0
        };
    }

    function getPX(e) {
        //组成是clientX + scrollX
        return e.clientX + winS().left;
    }

    function getPY(e) {
        return e.clientY + winS().top;
    }
    };
    agreed.onclick=function () {
        pro.style.display='none';
    }
    // 注册协议手机注册
    $("#phxieyi").click(function () {       
       $('#xieyi').trigger("click");//在手机       
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