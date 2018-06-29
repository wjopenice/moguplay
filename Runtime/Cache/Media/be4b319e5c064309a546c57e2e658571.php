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
        <div class="top-l">
            <a href="<?php echo U('Game/youxi');?>">游戏中心 ｜</a>
            <a href="<?php echo U('Gift/index');?>"> 礼包中心 </a>
            <!--<a href="<?php echo U('Index/appdown');?>">手上科技APP</a>-->
        </div>
        <div class="top-r">

            <a href="<?php echo U('Public/login');?>" id="entry">登录 &nbsp;|&nbsp;</a>
            <a href="<?php echo U('Public/register');?>" id="enroll">注册</a>

            
        </div>
    </div>
</div>
<!--导航-->

<div class="header clearfix" id="navBar">
    <div class="center">
        <h1 class="header-l">
             <a href="<?php echo U('Index/index');?>" class="logo"><img src="/Public/Media/image/header/logo.png" alt="手上科技"></a>
        </h1>
        <div class="header-c">
            <ul class="list">
                <li><span class="menu-1" ></span><a href="<?php echo U('Index/index');?>" >首页</a> </li>
                <li><span class="menu-2"></span><a href="<?php echo U('Game/youxi');?>">游戏中心</a></li>
                <li><span class="menu-3"></span><a href="<?php echo U('Gift/index');?>">礼包中心</a></li>
                <li><span class="menu-7"></span><a href="<?php echo U('Exchange/index');?>">兑换中心</a>
                </li>
                <li><span class="menu-4"></span><a href="<?php echo U('Category/zixun');?>">资讯中心</a></li>
                <li><span class="menu-5"></span><a href="<?php echo U('Recharge/chongzhi');?>">充值中心</a></li>
                <li><span class="menu-6"></span><a href="<?php echo U('Service/kefu');?>">客服中心</a></li>

            </ul>
        </div>
        <div class="header-r">
            <input  class="sousuo" type="text" placeholder="请输入关键词" id="com_input" />
            <span class="icon-search" id="com_search"></span></div>
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

    var ACTION_STR = '/media.php?s=/Exchange/record';
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


<style type="text/css">
.exwrap{width:1200px;margin:0 auto;min-height: 400px;}
.exwrap .location  {width:1200px;height: 120px;overflow: hidden ;margin-bottom: 40px;}
.exwrap .location  a{display:block;width:1200px;height: 120px;}
.exwrap .location  a img{width:100%;}
.exwrap .content{width:1200px;}
.exwrap .content .extab{width:240px;float:left;}
.exwrap .content .extab li{width:240px;height:60px;}        
.exwrap .content .extab li a{display:block;width:240px;height:60px;line-height: 60px;text-align: center;color:#333;}
.exwrap .content .extab li a span{float:left;width:18px;height:18px;background: url(/Public/Media/image/personalcenter/pcsprits.png) no-repeat ;margin: 22px -62px 0 73px;}
.exwrap .content .extab .two a:hover{background:#ed6557;color:#fff;}
.exwrap .content .extab .two a:hover span{background-position: -209px -73px!important;}
.exwrap .content .extab .current a{display:block;width:240px;height:60px;line-height: 60px;text-align: center;background:#ed6557;color:#fff;}
.exwrap .content .excon{width:960px;padding:0 20px; float:left;}
.exwrap .content .excon p{width:960px;padding:20px 20px;height:60px;line-height:20px;font-size:14px; text-align: left;}
.exwrap .content .excon table{margin-bottom: 20px;width: 100%;}
.exwrap .content .excon table tr{display: table-row; vertical-align: inherit; border-color: inherit;border-bottom:1px solid #cfd3d2; }
.exwrap .content .excon table tr td,.exwrap .content .excon table tr th{text-align: center;height: 38px;font-size:12px;}
</style>
    
<div class='exwrap'>
     <p class='location'>
        <a><img src="<?php echo (get_cover($adv_duihuan['data'],'path')); ?>" alt="" /></a>
    </p>       
    <div class='content clearfix'>
        <ul class='extab'>
            <li class='two'><a href="<?php echo U('index');?>"><span style="background-position: -209px -36px"></span>兑换</a></li>
            <li class='current'><a href="javascript:;"><span style="background-position: -209px -144px"></span>兑换记录</a></li>
        </ul>
       
        <div class='excon' id="member_r" >
          <p>最近10笔的兑换记录</p>
            <table>
              <thead>
                <tr>
                  <th>时间</th>
                  <th>兑换码</th>
                  <th>商品内容</th>
                  <th>状态</th>
                </tr>
              </thead>
              <tbody>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo set_show_time($v['create_time']);?></td>
                    <td><?php echo ($v["cdkey"]); ?></td>
                    <td><?php echo ($v["describe"]); ?>*<?php echo ($v["goods_num"]); ?></td>
                    <td>
                      <?php if($v["status"] == 0): ?>处理中
                      <?php else: ?>已成功<?php endif; ?>
                    </td>
                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
               
              </tbody>
            </table>
        </div>  
    </div>
</div>






</html>


<!--小火箭-->
<div style="display: none;" id="rocket-to-top">
    <div style="opacity:0;display: block;" class="level-2"></div>
    <div class="level-3"></div>
</div>
<!--尾巴部分-->
<div class="footer clearfix"> 
    <div class="banxin">
        <div class="footer-t">
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

        <!--<div class="footer-b clearfix">-->
            <!--<a class="one" href="javascript:;"><img src="/Public/Media/image/footer/logobt.png" alt=""></a>-->
            <!--<a class="two" href="javascript:;"><img src="/Public/Media/image/footer/erweima.png" alt=""></a>-->
            <!--<a class="wenzi" href="javascript:; ">手上科技 <br>手机助手APP</a>-->
        <!--</div>-->
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
        $(".header-c").find("ul").find("li").css("color","#666");
        $(".header-c").find("li").eq(i).find("span").css("background",navImg[i][0]);

        if(CON == $.trim(navArr[i])){
            $(".header-c").find("li").eq(i).find("a").css("color","#ED6557");
            $(".header-c").find("li").eq(i).find("span").css("background",navImg[i][1]);
        }
    }
    $(".header-c").find("ul").find("li").each(function(){
        var index=$(this).index();
        $(this).hover(function(){
            $(this).find("span").css("background",'url('+navImg[index][1]+')');
          
        },function(){
             if(CON == $.trim(navArr[index])){
            $(".header-c").find("li").eq(index).find("a").css("color","#ED6557");
            $(this).find("span").css("background",'url('+navImg[index][1]+')');
        }else{
            $(this).find("span").css("background",'url('+navImg[index][0]+')');
        }
        })
    });
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