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


    var ACTION_STR = '/media.php?s=/Category/zxchildren';
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



    <link rel="stylesheet" href="/Public/Media/css/zxchildren.css">

<!--中间新闻-->
<div class="center container clearfix">
    <div class="center-t">
        <span>当前位置：<a href="<?php echo U('Category/zixun');?>">资讯中心</a> ><?php echo ($vo["title"]); ?></span>
    </div>
    <div class="center-l">
        <div class="center-l-t">
            <div class='center-l-tit'>
            <h1><?php echo ($vo["title"]); ?></h1>
            <p class="auther">作者: <?php echo get_admin_name($vo['admin']);?> &nbsp;  &nbsp;  &nbsp;时间：<?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></p>
            </div>
          <!--<div class="title">
                <p><?php echo ($vo["title"]); ?></p>
              </div>-->
            <div class="article">
              <p><?php echo ($vo["content"]); ?></p>
               <!-- <img src="/Public/Media/image/zixun/zxchildren/zixun_xiangqing.png" alt="">-->
              <p></p>
            </div>
            <?php $prev = D('Document')->prev($info); if(!empty($prev)): ?><a href="<?php echo U('?id='.$prev['id']);?>" class="before">上一篇</a><?php endif; ?>
                    <?php $next = D('Document')->next($info); if(!empty($next)): ?><a href="<?php echo U('?id='.$next['id']);?>" class="after">下一篇</a><?php endif; ?>

           <!--  <a href="javascript:;" class="before">上一篇</a>
           <a href="javascript:;" class="after">下一篇</a> -->


            <!-- <div class="appp">
                <img src="/Public/Media/image/zixun/zxchildren/xiazai.jpg" alt="">
            </div> -->
            <!--<div class="appp" style="position: relative;">
                <img src="/Public/Media/image/zixun/zxchildren/xiazai.jpg" alt="">
                <img src="/Public/Media/image/zixun/zxchildren/erweima.gif" alt="" style="position: absolute;top:20px;left:20px;">
            </div>-->
        </div>
    </div>

    <div class="center-r">
        <div class="center-r-t">
            <div class="banner">
            
               <ul class="img">
                   <?php if(is_array($slider_zxchild)): $i = 0; $__LIST__ = $slider_zxchild;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lun): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($lun["url"]); ?>" target="<?php echo ($lun["target"]); ?>"><img src="<?php echo (get_cover($lun["data"],'path')); ?>" alt="<?php echo ($lun["title"]); ?>"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>

                <div class="jb"><img src="/Public/Media/image/zixun/zxchildren/lunbojianbian.png" alt=""></div>
                <ul class="num"></ul>
            </div>
        </div>

        <div class="center-r-c">
            <!--推荐礼包-->
            <div class="libao">
                <div class="libao-t">
                    <a href="javascript:;"  class="one"><span class="icon-libao"></span>游戏礼包</a>
                </div>
                <div class="libao-b ">
                    <ul>
                        <?php if(is_array($gift)): $i = 0; $__LIST__ = $gift;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                            <a href="<?php echo U('Game/yxchildren?id='.$vo['game_id'].'&type=2');?>"><p class="fengbao" id="<?php echo ($vo["gift_id"]); ?>"><?php echo ($vo["game_name"]); ?></p> <p><?php echo ($vo["giftbag_name"]); ?></p></a>
                                <div class="lingqu">领 &nbsp;取</div>
                        
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>

            <!--热门游戏-->
            <div class="hot-game">
                <div class="hot-game-t">
                    <a href="javascript:;" class="two"><span class="icon-hot"></span>热门游戏</a>
                    <a href="<?php echo U('Game/youxi');?>" class="gengduo">更多> ></a>
                </div>
                <div class="hot-game-b">
                    <ul class="clearfix">
                        <?php if(is_array($hot)): $i = 0; $__LIST__ = $hot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                <div class="hot">
                                    <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>"><img src="<?php echo (get_cover($vo["icon"],'path')); ?>"></a>
                                    <div class="wenzi">
                                        <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>" class="first"><?php echo msubstr($vo['game_name'],0,7,'UTF-8',false);?></a>
                                        <p href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>" class="next"><?php echo ($vo["game_type_name"]); ?></p>
                                        <!--<a href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="load">下 &nbsp;载</a>-->
                                        <a href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="load">下 &nbsp;载</a>
                                    </div>
                                </div>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="xian"></div>


<!--底部-->
<!--尾巴部分-->
</body>
<script src="/Public/Media/js/jquery-1.11.1.min.js"></script>
<script>
$('.libao-b ').find('li').each(function () {
        $(this).find('.lingqu').click(function () {
            $.ajax({
                type:'post',
                dataType:'json',
                data:{
                    gift:$(this).parent("li").find('.fengbao').html(),
                    giftid:$(this).parent("li").find('.fengbao').attr('id')
                },
                url:"<?php echo U('Member/getGameGift');?>",
                success:function(data) {
                    if (parseInt(data.status) == 1 ) {
//                    登录成功时候的状态
                        if(data.msg=='ok'){
                            login_ok(data);
                        }
                        if(data.msg=='no'){
//                        您已领取过该礼包
                            login_no(data)
                        }
                        if(data.msg=='noc'){
//                        该礼包已领取完，下次请早
                            login_noc(data)
                        }
                    }
                    if (parseInt(data.status) == 0 ) {
                        //登录失败的时候
                        nologin_box();
                    }
                },
                error:function() {
                    alert('服务器故障，请稍候再试。。。。');
                }
            });
        })
    });

    $(function(){
        var i=0;
        var timer=null;
        for (var j = 0; j < $('.img li').length; j++) { //创建圆点
            $('.num').append('<li></li>')
        }
        $('.num li').first().addClass('active'); //给第一个圆点添加样式
        var firstimg=$('.img li').first().clone(); //复制第一张图片
        $('.img').append(firstimg).width($('.img li').length*($('.banner').width())); //将第一张图片放到最后一张图片后，设置ul的宽度为图片张数*图片宽度
        // 下一个按钮
        $('.next').click(function(){
            i++;
            if (i==$('.img li').length) {
                i=1; //这里不是i=0
                $('.img').css({left:0}); //保证无缝轮播，设置left值
            };
            $('.img').stop().animate({left:-i*375},300);
            if (i==$('.img li').length-1) {  //设置小圆点指示
                $('.num li').eq(0).addClass('active').siblings().removeClass('active');
            }else{
                $('.num li').eq(i).addClass('active').siblings().removeClass('active');
            }
        })
        // 上一个按钮
        $('.prev').click(function(){
            i--;
            if (i==-1) {
                i=$('.img li').length-2;
                $('.img').css({left:-($('.img li').length-1)*375});
            }
            $('.img').stop().animate({left:-i*375},300);
            $('.num li').eq(i).addClass('active').siblings().removeClass('active');
        })

        //设置按钮的显示和隐藏
        $('.banner').hover(function(){
            $('.btn').show();
        },function(){
            $('.btn').hide();
        })

        //鼠标划入圆点
        $('.num li').mouseover(function(){
            var _index=$(this).index();
            $('.img').stop().animate({left:-_index*375},150);
            $('.num li').eq(_index).addClass('active').siblings().removeClass('active');
        })
        //定时器自动播放
        timer=setInterval(function(){
            i++;
            if (i==$('.img li').length) {
                i=1;
                $('.img').css({left:0});
            };

            $('.img').stop().animate({left:-i*375},300);
            if (i==$('.img li').length-1) {
                $('.num li').eq(0).addClass('active').siblings().removeClass('active');
            }else{
                $('.num li').eq(i).addClass('active').siblings().removeClass('active');
            }
        },1500)
        //鼠标移入，暂停自动播放，移出，开始自动播放
        $('.banner').hover(function(){
            clearInterval(timer);
        },function(){
            timer=setInterval(function(){
                i++;
                if (i==$('.img li').length) {
                    i=1;
                    $('.img').css({left:0});
                };

                $('.img').stop().animate({left:-i*375},300);
                if (i==$('.img li').length-1) {
                    $('.num li').eq(0).addClass('active').siblings().removeClass('active');
                }else{
                    $('.num li').eq(i).addClass('active').siblings().removeClass('active');
                }
            },1000)
        })
    })
</script>
<!-- <script src="/Public/Media/js/src/IE8.js"></script>
<script src="/Public/Media/js/src/IE9.js"></script> -->
<script>
window.onload=function(){
    var mWidth=600;
    $('.center .center-l .center-l-t .article').find('img').each(function(){
        var oWidth=$(this).width();
        var oHeight=$(this).height();
        var nHeight=mWidth/oWidth*oHeight;
        if(oWidth>mWidth){
            $(this).css({width:mWidth,height:nHeight});
        }else{
            $(this).css({width:oWidth,height:oHeight});           
        }
    })

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