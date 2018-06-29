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


    var ACTION_STR = '/media.php?s=/Gift/index';
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


    <link rel="stylesheet" href="/Public/Media/css/libao.css">
    <style>
        #pagation{text-align:center;padding:40px 30px;width:800px;}
        #pagation .aBtns{
            float:left;
            padding-left:40px;
        }
        #pagation .aBtns a{
            text-decoration: none;
            font-size:14px;color:#4c4c4c;
            display: inline-block;padding:5px 10px;
            background:#fff;margin:0 5px;float:left;
            cursor: pointer;
        }
        #pagation .aBtns a.active{
            color:#fff;
            background:#00C9E1;
        }
        #pagation .jump{
            float:right; font-size:14px;color:#4c4c4c;
            line-height:20px;
            padding-right:72px;
        }
        #pagation .jump input{
            width:40px;height:20px;border:1px solid #999;
            font-size:14px;margin:3px 3px 0 10px;
        }
        #pagation .jump span{
            display: inline-block;cursor: pointer;color:#4c4c4c;
            font-size:14px;padding:5px 10px;
        }

    </style>
    <!--推荐礼包-->
    <div class="youxilb clearfix">
        <div class="container">
            <div class="youxi-t">
                <a href="javascript:;" class="one"><span class="icon-youxi"></span>推荐礼包</a>
            </div>
            <div class="youxi-b">
                <ul>
                    <?php if(is_array($recommend_gift)): $i = 0; $__LIST__ = $recommend_gift;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                            <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>" class="one">
                                <img src="<?php echo (get_cover($vo["gift_icon"],'path')); ?>">
                            </a>
                            <div class="show">
                                <p class="first" id="<?php echo ($vo["gift_id"]); ?>"><?php echo ($vo["giftbag_name"]); ?></p>
                                <p ><?php echo ($vo["game_name"]); ?></p>
                                <p class="two"><?php echo ($vo["desribe"]); ?></p>
                                <a href="javascript:;" class="goandget">领&nbsp;取</a>
                            </div>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <!--最新礼包-->
    <div class="new container clearfix">
        <div class="new-t">
            <a href="javascript:;" class="one"><span class="icon-libao"></span>最新礼包</a>
        </div>
        <div class="new-b">
            <ul>
                <?php if(is_array($gift)): $i = 0; $__LIST__ = $gift;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                        <a href="<?php echo U('Game/yxchildren?id='.$vo['game_id'].'&type=1');?>" class="giftmore">
                            <img src="<?php echo (get_cover($vo["icon"],'path')); ?>">   </a>
                        <div class="wenzi">
                            <a href="<?php echo U('Game/yxchildren?id='.$vo['game_id'].'&type=2');?>"><p class="first" id="<?php echo ($vo["gift_id"]); ?>"><?php echo ($vo["giftbag_name"]); ?>-<?php echo ($vo["game_name"]); ?></p></a><br>
                            <p class="next"><?php echo msubstr($vo['desribe'],0,20,'UTF-8',false);?></p>
                        </div>
                        <div class="load"> 领 &nbsp;取</div>

                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
    <!--图片墙-->
    <div class="pic container" id='allGift'>

        <ul>
            <?php if(is_array($libao_gift)): $i = 0; $__LIST__ = $libao_gift;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gf): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($gf["url"]); ?>" target="<?php echo ($gf["target"]); ?>"><img src="<?php echo (get_cover($gf["data"],'path')); ?>" alt="<?php echo ($gf["title"]); ?>"></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>

    </div>
    <!--中间部分-->
    <div class="game container clearfix">
        <div class="game-l">
            <!--全部礼包-->
            <div class="category">
                <div class="category-t" >
                    <a href="javascript:;"><span class="icon_fenlei"></span>全部礼包</a>
                </div>
                <div class="category-b" id="box1">
                    <div class="category-b-t">
                        <a href="javascript:;">游戏题材</a>
                    </div>
                    <div class="hd">
                <span class="current" id="0">
                      不 &nbsp;限
                </span>
                        <?php $_result=get_game_type_all_show();if(is_array($_result)): $k = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><span id="<?php echo ($vo['id']); ?>" >
                        <?php echo ($vo["type_name"]); ?>
                    </span><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <div class="bd">
                        <ul>
                            <li class="show">
                                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="one_category">
                                        <a href="<?php echo U('Game/yxchildren?id='.$v['id'].'');?>" class="pic">
                                            <img src="<?php echo (get_cover($v["icon"],'path')); ?>" alt="">
                                        </a>
                                        <div class="right">
                                            <a href="<?php echo U('Game/yxchildren?id='.$v['id'].'&type=2');?>" class="title" id="<?php echo ($v["gift_id"]); ?>"><?php echo msubstr($v['giftbag_name'],0,4,'UTF-8',false);?></a>
                                            <p class="next"><?php echo ($v["game_name"]); ?></p>
                                            <a class="lq" href="javascript:;">领&nbsp;取</a>
                                        </div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--分页器-->
            <div id="pagation" class="clearfix" >  </div>
        </div>
        <div class="game-r">
            <!--游戏排行-->
            <div class=" paihang clearfix">
                <div class="paihang-t">
                    <a href="javascript:;"  class="one"><span class="icon-libao"></span>游戏排行</a>
                </div>
                <div class="paihang-b ">
                    <ul class="weekly-list">
                        <?php if(is_array($rank)): $i = 0; $__LIST__ = $rank;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li >
                                <div class="app-show-title clearfix">
                                    <?php if($num < 4): ?><span class="num s-index-org" style="background-color:#f19ec2;color: #fff;"><?php echo ($num++); ?></span>
                                        <?php elseif($num < 7): ?><span class="num s-index-org" style="background-color:pink;color: #fff;"><?php echo ($num++); ?></span>
                                        <?php else: ?> <span class="num s-index-org" style=";background-color:gray;color: #fff;"><?php echo ($num++); ?></span><?php endif; ?>
                                    <a href="<?php echo U('Game/yxchildren',array('id'=>$vo['id'],'type'=>1));?>"  class="bl"><?php echo ($vo["game_name"]); ?></a>
                                    <a href="javascript:;" class="hh"><?php echo ($vo["game_type_name"]); ?></a>
                                </div>

                                <div class="app-show-block">
                                    <?php if($num < 5): ?><span class="num s-index-org" style="background-color:#f19ec2;color: #fff;"></span>
                                        <?php elseif($num < 8): ?><span class="num s-index-org" style="background-color:pink;color: #fff;"></span>
                                        <?php else: ?> <span class="num s-index-org" style=";background-color:gray;color: #fff;"></span><?php endif; ?>

                                    <a href="<?php echo U('Game/yxchildren',array('id'=>$vo['id'],'type'=>1));?>" class="pic phPic"><img src="<?php echo (get_cover($vo["icon"],'path')); ?>" alt="<?php echo ($vo["game_name"]); ?>"></a>
                                    <div class='xzandli clearfix'>
                                        <div class='title clearfix'>
                                            <a href="<?php echo U('Game/yxchildren',array('id'=>$vo['id'],'type'=>1));?>"  class="name"><?php echo ($vo["game_name"]); ?></a>
                                            <a href="javascript:;" class="jiaose"><?php echo ($vo["game_type_name"]); ?></a>
                                        </div>
                                        <div class='picandtxt'>
                                            <a  class="xz" href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>" class="down">下&nbsp;载</a>
                                            <!-- <a  class="xz" href="javascript:void(0)" class="down" onclick="alert('该功能暂未下载')">下&nbsp;载</a> -->
                                            <a href="<?php echo U('Game/yxchildren',array('id'=>$vo['id'],'type'=>2));?>" class="lb">礼&nbsp;包</a>
                                        </div>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--尾巴部分-->
    </body>
    <script src="/Public/Media/js/jquery.min.js"></script>
    <script src="/Public/Media/js/js.js"></script>
    <script src="/Public/Media/js/pop.js"></script>
    <script src="/Public/Media/js/pagation.js"></script>
    <script type="text/javascript" src="/Public/Media/js/query.js"></script>
    <script>
        var num = <?php echo ((isset($_GET['type']) && ($_GET['type'] !== ""))?($_GET['type']):0); ?>;
        var spans=document.getElementById("box1").getElementsByTagName('span');

        for(var i=0;i<spans.length;i++){
            for(var j=0;j<spans.length;j++){
                spans[j].className = "";
            }

        }
        $('#'+num).addClass('current');

    </script>
    <script>
        var spans=document.querySelector('.hd');
        var options=spans.getElementsByTagName('span');
        var dataLength=<?php echo ((isset($count) && ($count !== ""))?($count):0); ?>;
        //后台的数据总条目条目
        var pageSize=12;
        var allPageNum=dataLength%pageSize==0 ? parseInt(dataLength/pageSize):(parseInt(dataLength/pageSize)+1);
        var p =<?php echo ((isset($_GET['p']) && ($_GET['p'] !== ""))?($_GET['p']):1); ?>;
        type = <?php echo ((isset($_GET['type']) && ($_GET['type'] !== ""))?($_GET['type']):0); ?>;
        if(dataLength>pageSize){
            page({
                id : 'pagation',
                nowNum : p,
                allNum : allPageNum,
                callBack : function(now,all){
                    window.location.href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/media.php?s=/Gift/index/type/"+type+"/p/"+now+"/pagesize/"+pageSize+'.html#allGift';
                }
            });
        }else{
            $("#pagation").css("display","none");
        }
        // tab 点击切换页面
        for(var i=0;i<options.length;i++){
            options[i].index=i;
            options[i].onclick=function () {
                var type2= options[this.index].getAttribute('id');
                if(type != type2){
                    p=1;
                }
                window.location.href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/media.php?s=/Gift/index/type/"+type2+"/p/"+p+"/pagesize/"+pageSize+'.html#allGift';
            };
        }

    if($("#pagation").find(".jump").length>0){
        $("#pagation").find(".aBtns").css('padding-left',"0 0 0 40px");
    }else{
        $("#pagation").find(".aBtns").css('padding',"0 0 0 240px");
    }
    </script>
    <script>

        $('.new-b').find('li').each(function () {
            $(this).find('.load').click(function () {
                $.ajax({
                    type:'post',
                    dataType:'json',
                    data:{
                        gift:$(this).parent("li").find('.first').html(),
                        giftid:$(this).parent("li").find('.first').attr('id')
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
        })


        $('.one_category').find('.right').each(function () {
            $(this).find('.lq').click(function () {
                $.ajax({
                    type:'post',
                    dataType:'json',
                    data:{
                        gift: $(this).parent(".right").find('.title').html(),
                        giftid:$(this).parent(".right").find('.title').attr('id')
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
        $('.youxi-b').find('.show').each(function (){
            $(this).find('.goandget').click(function (){
                $.ajax({
                    type:'post',
                    dataType:'json',
                    data:{
                        gift: $(this).parent(".show").find('.first').html(),
                        giftid:$(this).parent(".show").find('.first').attr('id')
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