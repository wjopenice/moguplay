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


    var ACTION_STR = '/media.php?s=/Index/wjmm';
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


<link rel="stylesheet" href="/Public/Media/css/wjmm.css">
<?php switch($m): case "1": ?><div id="forget1" style="display: block;">
    <div class="mm container clearfix">
        <div class="mm-t">
            当前位置 ： <a href="javascript:;"> 登录 > </a> <a href="javascript:;">找回密码</a>
        </div>
        <div class="mm-c">
            <span class="one">1.账号信息  </span>
            <span class="two">2.找回方式</span>
            <span class="three">3.重置密码</span>
            <span class="four">4.完成</span>
        </div>
        <div class="mm-b">
            <div class="mm-b-l" style='margin-top:10px'>
                <div><span class="h">用户账号：</span> <input type="text" class="shuru" id="in"> <span id="tips" class="tip"><i class="star">* </i><span class="zi"> 正确填写账号信息</span></span> </div>               
                <input type="button" class="next" id="net" value="下一步" />
            </div>
            <div class="mm-b-r">
                <div class="youce">
                    <p><i>*</i> 请正确填写您要找回的账号信息</p>
                    <p><i>*</i> 按操作提示依次完成找回</p>
                    <p><i>*</i> 如您所有的找回方式均不可用，请联系客服</p>
                </div>
            </div>
        </div>
    </div>
</div><?php break;?>

<?php case "2": if(($data['phone'] != '') or ($data['email'] != '')): ?><!-- 第二步之手机找回 -->
<div id="forget2" style="display: none;">    
    <div class="mm container clearfix">
        <div class="mm-t">
            当前位置 ： <a href="javascript:;"> 登录 > </a> <a href="javascript:;">找回密码</a>
        </div>
        <div class="mm-c">
            <span class="one">1.账号信息  </span>
            <span class="two">2.找回方式</span>
            <span class="three">3.重置密码</span>
            <span class="four">4.完成</span>
        </div>
        <div class="mm-b">
            <div class="mm-b-t">
                <a href="javascript:;" class="iphonefindway"><img src="/Public/Media/image/wjmm/shoujizhaohui_1.png" alt=""></a>
                <a href="javascript:;" class="emailfindway"><img src="/Public/Media/image/wjmm/youxiangzhaohui_2.png" alt=""></a>
                <a href="<?php echo U('Service/kefu');?>"><img src="/Public/Media/image/wjmm/kefuzhaohui_2.png" alt=""></a>
            </div>
            <div class="mm-b-b">
                <div class="mm-b-l">
                    <div class="iphone">
                        <span class="h">手机号：</span><input type="text" class="shuru" id="in2"/><input type="button" class="ck" id="fsyzm" value="发送验证码"  style="width:100px;height:30px;cursor: pointer;<span class="tips"><i class="star"> </i><span class="zi"></span></span>
                    </div>
                    <div class="ma"><span class="h">验证码：</span> <input type="text" class="shuru" id="code">  <span id="tiped"><i class="star">* </i><span class="msg">请输入短信验证码</span></span></div>
                </div>
                <div class="mm-b-r">
                    <div class="youce">
                        <p><i>*</i> 请正确填写您要找回的账号信息</p>
                        <p><i>*</i> 按操作提示依次完成找回</p>
                        <p><i>*</i> 如您所有的找回方式均不可用，请联系客服</p>
                    </div>
                </div>               
                <input type="button" class="next" id="net2" value="下一步" />
            </div>
        </div>
    </div>    
    <div class="nobinding" id="nobind">
        <div class="win-box">
            <div class="mess-t">
                <p class="first">未绑定邮箱</p>
            </div>
            <div class="mess-t" style=""><p class="next">请前往 <a href="javascript:;" class="find" id="emailfind">手机找回</a> 或 <a
                    href="<?php echo U('Service/kefu');?>" class="find">联系客服</a></p>
            </div>
            <div class="mess-b">
                <a href="javascript:;" class="closed" id="shut">关&nbsp;闭</a>
            </div>
        </div>
    </div>
</div>
<!--第二步之邮箱找回-->
<div id="hb_email" style="display: none;">
    <div id="forgetemail1" >
        <!--中间部分-->
        <div class="mm container clearfix">
            <div class="mm-t">
                当前位置 ： <a href="javascript:;"> 登录 > </a> <a href="javascript:;">找回密码</a>
            </div>
            <div class="mm-c">
                <span class="one">1.账号信息  </span>
                <span class="two">2.找回方式</span>
                <span class="three">3.重置密码</span>
                <span class="four">4.完成</span>
            </div>
            <div class="mm-b">

                <div class="mm-b-t">
                    <a href="javascript:;" class="iphonefindway"><img src="/Public/Media/image/wjmm/shoujizhaohui_2.png" alt=""></a>
                    <a href="javascript:;" class="emailfindway"><img src="/Public/Media/image/wjmm/youxiangzhaohui_1.png" alt=""></a>
                    <a href="<?php echo U('Service/kefu');?>"><img src="/Public/Media/image/wjmm/kefuzhaohui_2.png" alt=""></a>
                </div>
                <div class="mm-b-b">
                    <div class="mm-b-l">
                        <div class="ma"><span class="h">邮箱：</span> <input type="text" class="shuru" id="email" value="">  <span id="tips4"><i class="star"> </i><span class="msg"></span></span></div>
                         <input type="button" class="color" id="net4" value="下一步" />

                    </div>
                    <div class="mm-b-r">
                        <div class="youce">
                            <p><i>*</i> 请正确填写您要找回的账号信息</p>
                            <p><i>*</i> 按操作提示依次完成找回</p>
                            <p><i>*</i> 如您所有的找回方式均不可用，请联系客服</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!--未绑邮箱的弹出框-->
        <div class="nobindemil" id="nobindemils" style="display: none;">
            <div class="win-box">
                <div class="mess-t">
                    <p class="first">未绑定手机</p>
                    <p class="next">请前往 <a href="#" class="find" id="email_click">邮箱找回</a> 或 <a href="<?php echo U('Service/kefu');?>" class="find">联系客服</a>  </p>
                </div>
                <div class="mess-b">
                    <a href="javascript:;" class="closed" id="shuted">关&nbsp;闭</a>
                </div>
            </div>
        </div>
    </div>
    <div id="forgetemail2" style="display:none;">
        <!--中间部分-->
        <div class="mm container clearfix">
            <div class="mm-t">
                当前位置 ： <a href="javascript:;"> 登录 ></a> <a href="javascript:;">找回密码</a>
            </div>
            <div class="mm-c">
                <span class="one">1.账号信息  </span>
                <span class="two">2.找回方式</span>
                <span class="three">3.重置密码</span>
                <span class="four">4.完成</span>
            </div>
            <div class="mm-b">
                <div class="mm-b-t">
                    <a href="javascript:;"><img src="/Public/Media/image/wjmm/shoujizhaohui_2.png" alt=""></a>
                    <a href="javascript:;"><img src="/Public/Media/image/wjmm/youxiangzhaohui_1.png" alt=""></a>
                    <a href="<?php echo U('Service/kefu');?>"><img src="/Public/Media/image/wjmm/kefuzhaohui_2.png" alt=""></a>
                </div>
                <div class="mm-b-b">
                    <div class="mm-b-b-t">
                        <p>验证链接已发送至邮箱 <span class="red" id="get_email"><?php echo ((isset($em) && ($em !== ""))?($em):1); ?></span> ,请在24小时内查收验证</p>
                        <p>登录邮箱并按邮箱提示操作即可</p>
                        <a href="javascript:;" class="rightnow" id="atonce">立即登录邮箱</a>
                    </div>
                    <div class="mm-b-b-b">
                        <p><span></span> 请查看您邮箱的垃圾邮件或者广告箱，手上科技验证邮件可能被误放入</p>
                        <p><span></span> 如果超过2分钟还没有收到手上科技验证邮箱，可 <input type="button" value="再次发送邮箱" id="resend" class="red" style="cursor: pointer;"></p>
                        <p><span></span> 旧邮箱丢失请 <a href="<?php echo U('Service/kefu');?>" class="red">联系客服</a></p>
                    </div>

                </div>


            </div>
        </div>
    </div>    
</div>


<?php else: ?>

 <div class="nobindemil" id="nobindemils" style="display: block;">
        <div class="win-box">
            <div class="mess-t">
                <p class="first">未绑定手机和邮箱</p>
                <p class="next">
               
                <a href="<?php echo U('Service/kefu');?>" class="find">联系客服</a>  </p>
            </div>
            <div class="mess-b">
                <a href="<?php echo U('Index/wjmm');?>" class="closed" id="shuted">关&nbsp;闭</a>
                
            </div>
        </div>
    </div><?php endif; ?>

<div class="noreceive" id="resendsuc" style="display: none;z-index: 999;">
    <div class="win-box" >     
        <p class="ni-c" style="width:464px;height:30px;font-size:20px;line-height:30px;text-align: center;margin:60px 0px;color:#ed6557;">
           再次发送邮箱成功
        </p>   
        <p  style="width:464px;height:40px;text-align: center;">
            <input type="button" id="sureBtn" value="确&nbsp;&nbsp;定" style="width: 100px;height:40px;background:#ed6557;color:#fff;cursor: pointer;font-size:20px;" />
        </p>    
    </div>
</div><?php break;?>

<?php case "3": ?><!--第三步 重置密码-->
<div id="forget3" >
    
    <div class="mm container clearfix">
        <div class="mm-t">
            当前位置 ： <a href="javascript:;"> 登录 > </a> <a href="javascript:;">找回密码</a>
        </div>
        <div class="mm-c">
            <span class="one">1.账号信息  </span>
            <span class="two">2.找回方式</span>
            <span class="three">3.重置密码</span>
            <span class="four">4.完成</span>
        </div>
        <div class="mm-b">
            <div class="mm-b-l">                  
                    <div class="reset"><span class="h">重置密码：</span> <input type="password" class="shuru" id="reset" name="password"><span id="password"><i class="star">* </i><span class="zi"> 请输入 6-15 位数字、字母</span></span></div>
                    <div class="affirm"><span class="h">确认密码：</span> <input type="password" class="shuru" id="confirm"><span id="password2"><i class="star">* </i><span class="zi"> 请再次输入密码</span></span></div>
                    <input type="hidden" name="user_id" value="<?php echo ($_GET['user_id']); ?>">
                    <input type="submit" value="下一步" class="next" id="net3">
            </div>
            <div class="mm-b-r">
                <div class="youce">
                    <p><i>*</i> 请正确填写您要找回的账号信息</p>
                    <p><i>*</i> 按操作提示依次完成找回</p>
                    <p><i>*</i> 如您所有的找回方式均不可用，请联系客服</p>
                </div>
            </div>
        </div>
    </div>
</div><?php break;?>

<?php case "4": ?><!--第四步 完成密码-->
<div id="finishend" >
        <div class="mm container clearfix">
            <div class="mm-t">
                当前位置 ： <a href="javascript:;"> 登录 > </a> <a href="javascript:;">找回密码</a>
            </div>
            <div class="mm-c">
                <span class="one">1.账号信息  </span>
                <span class="two">2.找回方式</span>
                <span class="three">3.重置密码</span>
                <span class="four">4.完成</span>
            </div>
            <div class="mm-b">
                <img src="/Public/Media/image/wjmm/wancheng.png" alt="">
                <p class="reset">重置密码成功</p>
                <p id="daojishi" class="dj"></p> &nbsp; &nbsp; &nbsp; &nbsp;<p class="dj">点击 <a href="<?php echo U('Public/login');?>">立即登录</a></p>
            </div>
        </div>
</div><?php break; endswitch;?>
</body>
<script src="/Public/Media/js/jquery-1.11.1.min.js"></script>
<script>
        var zqimg="/Public/Media/image/wjmm/quanbuzhengquan.png";//图片引入路径
        var usernameverify ="<?php echo U('Index/wjmm');?>";
        var phoneverifyurl ="<?php echo U('Index/phone_verify');?>";        //获取当前玩家手机号
        var sendvcodeurl ="<?php echo U('Index/sendvcode');?>";       //获取当前玩家手机验证码
        var verifyvcodeurl ="<?php echo U('Index/verifyvcode');?>"; //手机号手机验证码验证
        var tosendemailurl="<?php echo U('Index/tosendemail');?>";
        var reseturl="<?php echo U('Index/reset');?>";
       // 用来
        var ph="<?php echo ((isset($ph) && ($ph !== ""))?($ph):1); ?>";
        var em="<?php echo ((isset($em) && ($em !== ""))?($em):1); ?>";
        window.myemail="<?php echo ((isset($data['email']) && ($data['email'] !== ""))?($data['email']):1); ?>";
        window.myphone="<?php echo ((isset($data['phone']) && ($data['phone'] !== ""))?($data['phone']):1); ?>";
        var account = "<?php echo ($_GET['account']); ?>";               //获取当前玩家名称
        
        
       
        var wjreset_url ="<?php echo U('Index/phonemodify');?>";         //密码重置
        var wjemail_url ="<?php echo U('Index/email_verify');?>";   //查询当前玩家邮箱
        var sendmail_url ="<?php echo U('Index/sendTest');?>";      //重置密码接口至当前玩家邮箱
        var skip_url='/media.php?s=/Index/wjemail2/email/';   //wjmail2显示玩家绑定邮箱号码
</script>
<script src="/Public/Media/js/wjmm.js"></script>
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