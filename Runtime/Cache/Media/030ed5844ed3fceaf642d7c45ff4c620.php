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


    var ACTION_STR = '/media.php?s=/Member/pcaccountyue';
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
    <link rel="stylesheet" href="/Public/Media/css/pcaccountyue.css">
    <style>
    #pagation{text-align:center;margin:40px 0 0 40px;}      
    #pagation .aBtns{float:left; padding-left:115px;}
    #pagation .aBtns a{text-decoration: none;font-size:14px;color:#666;display: inline-block;padding:5px 10px;background:#fff;margin:0 5px;float:left;cursor: pointer;}
    #pagation .aBtns a.active{color:#fff;background:#f6c15b;}
    #pagation .jump{float:right; font-size:14px;color:#666;
        line-height:20px;padding-right:150px;}
    #pagation .jump input{width:40px;height:20px;border:1px solid #ccc;font-size:14px;margin:3px 3px 0 10px;}
    #pagation .jump span{display: inline-block;font-size:14px;padding:5px 10px;}
    
    </style>
    <div id="pc_main_con" >
        <!--个人中心/账户余额-->
        <div class="account_yue" >
            <div class="title">
                 <span style="background: url(/Public/Media/image/personalcenter/pcsprits.png) no-repeat  -166px 0;"></span>账户余额
            </div>
            <div class="content clearfix">
                <div class="con_l" id="account_tab">
                    <ul>
                        <li class="current" id="0"><a href="javascript:;"><span style="background: url(/Public/Media/image/personalcenter/pcsprits.png) no-repeat -167px -70px;"></span>平台币余额</a></li>
                        <li id="1"><a href="javascript:;"><span style="background: url(/Public/Media/image/personalcenter/pcsprits.png) no-repeat -168px -108px;"></span>绑定平台币余额</a></li>
                    </ul>
                </div>
                <div class="con_r" id="account_con">
                    <!--个人中心/账户余额/平台币余额-->
                    <div class="con_r_plat  com_r" >
                        <h2>您的手上科技平台币余额是&nbsp;:<span id="plat_yue"><?php echo ($balance); ?></span></h2>
                        <p class="msg">使用手上科技现金账户会让您在手上科技SDK游戏购买各种虚拟物品平台币余额。</p>
                        <ul class="clearfix">
                            <li>
                                <p><img src="/Public/Media/image/personalcenter/account/anquan.png"></p>
                                <p class="text">采用顶级数据加密方案，保障新建账户。出入帐记录绝对安全，您可以放心使用。</p>
                            </li>
                            <li>
                                <p><img src="/Public/Media/image/personalcenter/account/xiaofei.png"></p>
                                <p class="text">补偿等服务可以在通过审核后立即到账您的现金账户，免去等待。</p>
                            </li>
                            <li>
                                <p><img src="/Public/Media/image/personalcenter/account/jilu.png"></p>
                                <p class="text">账户中记录您的每一笔入账和支出，方便查找和管理日常交易。</p>
                            </li>
                        </ul>
                    </div>
                    <!--个人中心/账户余额/绑定平台币余额-->
                    <div class="con_r_bind_yue com_r" style="display: none;">
                        <table>
                            <thead>
                            <tr>
                                <th  class="fir" style="color:#333;">游戏名称</th>
                                <th class="sec" style="color:#333;">余额</th></tr>
                            </thead>
                            <tbody>
                               <?php if(is_array($list_data)): $i = 0; $__LIST__ = $list_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr><td  class="fir"><?php echo msubstr($vo['game_name'],0,7,'UTF-8',false);?></td><td class="sec"><?php echo ($vo["bind_balance"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?> 
                            </tbody>
                        </table>
                       <div id="pagation"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





</body>
<script src="/Public/Media/js/jquery-1.11.1.min.js"></script>
<script src="/Public/Media/js/pagation.js"></script> 

<script>
    $(function(){
    var l=($(window).width()-$("#pc_main_title").outerWidth())/2;
    $("#pc_main_title").css("left",l);

    var type = <?php echo ((isset($_GET['type']) && ($_GET['type'] !== ""))?($_GET['type']):0); ?>;
    var p =<?php echo ((isset($_GET['p']) && ($_GET['p'] !== ""))?($_GET['p']):1); ?>;
    var aLi=document.getElementById("account_tab").getElementsByTagName('li');
        for(var i=0;i<aLi.length;i++){
                for(var j=0;j<aLi.length;j++){                   
                    aLi[j].className = "";
                }        
        }
        $("#account_tab").find('#'+type).addClass('current');  

        if($('#account_tab').find('li').eq(0).hasClass('current')){
            $('#account_tab').find('li').eq(0).find('span').css('background-position','  -167px -70px')
        }else{
           $('#account_tab').find('li').eq(0).find('span').css('background-position','  -167px -34px')

        }
        if($('#account_tab').find('li').eq(1).hasClass('current')){
            $('#account_tab').find('li').eq(1).find('span').css('background-position','  -168px -144px')
        }else{
           $('#account_tab').find('li').eq(1).find('span').css('background-position','  -168px -108px')

        }
        
        aLi[0].onclick=function () {
            var type= aLi[0].getAttribute('id');            
            window.location.href='http://<?php echo ($_SERVER['HTTP_HOST']); ?>/media.php?s=/Member/pcaccountyue/type/'+type+'.html';        
        };
        aLi[1].onclick=function () {
            var type= aLi[1].getAttribute('id');            
            window.location.href='http://<?php echo ($_SERVER['HTTP_HOST']); ?>/media.php?s=/Member/pcaccountyue/type/'+type+'/p/'+p+'/pagesize/10.html';        
        };
   


    if(type==0){
        $("#account_con").find(".com_r").hide();
        $("#account_con").find(".com_r").eq(0).show();
    } 
    if(type==1){
       $("#account_con").find(".com_r").hide();
       $("#account_con").find(".com_r").eq(1).show();

        var dataLength="<?php echo ((isset($count) && ($count !== ""))?($count):0); ?>";
        var pageSize=10;
        var allPageNum=dataLength%pageSize==0 ? parseInt(dataLength/pageSize):(parseInt(dataLength/pageSize)+1);       
        
        var p =<?php echo ((isset($_GET['p']) && ($_GET['p'] !== ""))?($_GET['p']):0); ?>;
        if(dataLength>pageSize){
            page({
                id : 'pagation',
                nowNum : p,
                allNum : allPageNum,
                callBack : function(now,all){
                     window.location.href='http://<?php echo ($_SERVER['HTTP_HOST']); ?>/media.php?s=/Member/pcaccountyue/type/'+type+'/p/'+now+'/pagesize/'+pageSize+'.html';
                }
            });
        }else{
            $("#pagation").css("display","none");
        };

    } 


    })
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