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


    var ACTION_STR = '/media.php?s=/Member/pcmessage';
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
    <link rel="stylesheet" href="/Public/Media/css/pcmessage.css">
 <style>
        .hasReadMsg a{color:#ccc!important;}
        #pagation{text-align:center;padding:40px 0;}       
        #pagation .aBtns{float:left;padding-left:250px;}
        #pagation .aBtns a{text-decoration: none;font-size:14px;color:#4c4c4c; display: inline-block;padding:5px 10px;  background:#fff;margin:0 5px;float:left;
            cursor: pointer;
        }
        #pagation .aBtns a.active{color:#fff;background:#f19ec2;}
        #pagation .jump{float:right; font-size:14px;color:#4c4c4c;line-height:20px;padding-right:220px;}
        #pagation .jump input{width:40px;height:20px;border:1px solid #999;font-size:14px;margin:3px 3px 0 10px;}
        #pagation .jump span{display: inline-block;font-size:14px;padding:5px 10px;cursor:pointer;}

        #pc_main_con .messageCenter .title span{float: left;width:21px;height: 21px;margin:15px 20px 0 20px;background-image: url(/Public/Media/image/personalcenter/pcsprits.png) ; background-repeat:no-repeat ;cursor:pointer;color:#4c4c4c;
        }

    </style>

    <div id="pc_main_con" >
        <div class="messageCenter" >
            <div class="title">
                <span style=" background-position: -82px 0;"></span>信息中心
            </div>
            <div class="content">
                <ul class="message_title clearfix">
                    <li class="current"><a href="<?php echo U('Member/pcmessage');?>">全部消息</a></li>
                    <li><a href="<?php echo U('Member/pcmsgunread');?>">未读消息</a></li>
                    <li><a href="<?php echo U('Member/pcmsghasread');?>">已读消息</a></li>
                </ul>
                <div class="showMessage">
                    <div class="chose clearfix">
                        <div class="label" id="choseAll">
                            <img src="/Public/Media/image/personalcenter/msgcenter/quanxuankuang_1.png"/>
                            <span>全选</span>
                        </div>
                        <div class="buttons clearfix">
                            <input type="button" id="hasRead" value="标记已读">
                            <input  type="button" id="delete" value="删除">
                        </div>
                    </div>
                    <div id="con_title" class="clearfix">                       
                        <div class="biaoti">标&nbsp;题</div>
                        <div class="leixing">类&nbsp;型</div>
                        <div class="account">发送者</div>
                        <div class="time">时&nbsp;间</div>                           
                    </div>
                    <ul class="items">
                         <?php if(is_array($list_data)): $i = 0; $__LIST__ = $list_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$alldata): $mod = ($i % 2 );++$i; if(in_array(($alldata["id"]), is_array($read_ids)?$read_ids:explode(',',$read_ids))): ?><li class="clearfix hasReadMsg" id="<?php echo ($alldata["id"]); ?>">
                            <div class="img">
                                <img src="/Public/Media/image/personalcenter/msgcenter/quanxuankuang_1.png"/>
                            </div>
                            <input type="hidden" value="1"/>
                            <a href="<?php echo U('Member/detail',array('mid'=>$alldata['id'],'type'=>1));?>"  class="clearfix">
                                <div class="biaoti"><?php echo msubstr($alldata['title'],0,10,'UTF-8',false);?></div>
                                <div class="leixing"><?php echo msubstr($alldata['type'],0,4,'UTF-8',false);?></div>
                                <div class="account"><?php echo ($alldata["send_account"]); ?></div>
                                <div class="time"><?php echo (date('Y-m-d H:i:s',$alldata["create_time"])); ?></div>
                            </a>
                        </li>
                        <?php else: ?>
                        <li class="clearfix" id="<?php echo ($alldata["id"]); ?>">
                            <div class="img">
                                <img src="/Public/Media/image/personalcenter/msgcenter/quanxuankuang_1.png"/>
                            </div>
                            <input type="hidden" value="0"/>
                            <a href="<?php echo U('Member/detail',array('mid'=>$alldata['id'],'type'=>1));?>"  class="clearfix">
                                <div class="biaoti"><?php echo msubstr($alldata['title'],0,10,'UTF-8',false);?></div>
                                <div class="leixing"><?php echo msubstr($alldata['type'],0,4,'UTF-8',false);?></div>
                                <div class="account"><?php echo ($alldata["send_account"]); ?></div>
                                <div class="time"><?php echo (date('Y-m-d H:i:s',$alldata["create_time"])); ?></div>
                            </a>
                        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <div id="pagation">                   
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display: none;" id="rocket-to-top">
    <div style="opacity:0;display: block;" class="level-2"></div>
    <div class="level-3"></div>
</div>
</body>
<script src="/Public/Media/js/jquery-1.11.1.min.js"></script>
<script src="/Public/Media/js/pagation.js"></script>
<script>
    var imgArr=[
        "/Public/Media/image/personalcenter/msgcenter/quanxuankuang_1.png",
        "/Public/Media/image/personalcenter/msgcenter/quanxuan_2.png"
    ];
    $(function() {
        var check_all_flag = false;
        var checkArr = [];
        for (var i = 0; i < $(".items").find("li").length; i++) {
            checkArr[i] = false;
        }
        var true_length = 0;
        $("#choseAll").click(function () {
            if (!check_all_flag) {
                $(this).find("img").attr("src", imgArr[1]);
                $(".items").find("li").each(function () {
                    $(this).find("img").attr("src", imgArr[1]);
                    checkArr[$(this).index()] = true;
                });
                check_all_flag = true;
                true_length=checkArr.length;
            } else {
                $(this).find("img").attr("src", imgArr[0]);
                $(".items").find("li").each(function () {
                    $(this).find("img").attr("src", imgArr[0]);
                    checkArr[$(this).index()] = false;
                });
                check_all_flag = false;
                true_length=0;
            }

        });
        $(".items").find("li").each(function () {
            $(this).find("img").click(function () {
                var $this_index=$(this).parent().parent("li").index();
                if (!checkArr[$this_index]) {
                    true_length++;
                    $(this).attr("src", imgArr[1]);
                    checkArr[$this_index] = true;
                }
                else {
                    true_length--;
                    $(this).attr("src", imgArr[0]);
                    checkArr[$this_index] = false;
                    check_all_flag = false;
                    $("#choseAll").find("img").attr("src", imgArr[0]);
                };
                if(true_length==checkArr.length){
                    $("#choseAll").find("img").attr("src", imgArr[1]);
                    check_all_flag = true;
                }

            })
        });

        $("#hasRead").click(function(){             
            var idArr=[];
            var send_acc=[];
            for(var i=0;i<checkArr.length;i++){
                var readFlag=parseInt( $(".items").find("li").eq(i).find("input[type=hidden]").val());
                if(readFlag==0){
                    if(checkArr[i]){
                        idArr.push($(".items").find("li").eq(i).attr("id"));
                        send_acc.push($(".items").find("li").eq(i).find("a").find(".account").html());
                    }
                }
            }
      
            if(idArr.length!=0){             
                var ids_json= JSON.stringify(idArr);
                var send_acc_json = JSON.stringify(send_acc);
                $.ajax({
                    type: 'POST',
                    async: true,
                    dataType: 'json',
                    url:"<?php echo U('allread_letter');?>",
                    data: {
                        ids:ids_json,
                        send_acc:send_acc_json
                    },
                    beforeSend: function () {
                        $('#hasRead').attr('disabled', true);
                    },
                    success: function (data) {                        
                           window.location.reload();
                    },
                    error: function () {
                        alert('服务器故障，稍后再试.............');
                        $('#hasRead').attr('disabled', false);
                    },
                    cache: false
                });
            }
        });
        $("#delete").click(function(){
            var idArr=[];
            var send_acc=[];
            if(check_all_flag){         
                for(var i=0;i<checkArr.length;i++){
                    if(checkArr[i]){                
                        idArr.push($(".items").find("li").eq(i).attr("id"));
                         send_acc.push($(".items").find("li").eq(i).find("a").find(".account").html());                     
                    }
                  }
            }else{          
                for(var i=0;i<checkArr.length;i++){
                    if(checkArr[i]){                  
                        idArr.push($(".items").find("li").eq(i).attr("id"));
                         send_acc.push($(".items").find("li").eq(i).find("a").find(".account").html());                      
                    }
                }
            }
            if(idArr.length!=0){
                var ids_json= JSON.stringify(idArr);
                var send_acc_json = JSON.stringify(send_acc);
                $.ajax({
                    type: 'POST',
                    async: true,
                    dataType: 'json',
                    url:"<?php echo U('Member/del_letter');?>",
                    data: {
                        ids:ids_json,
                        send_acc:send_acc_json
                    },
                    beforeSend: function () {
                        $('#delete').attr('disabled', true);
                        alert("你确定要删除吗？")
                    },
                    success: function (data) {
                        if(parseInt(data.status)==1){alert(data.msg);
                        }else{alert(data.msg);}
                        $('#delete').attr('disabled', false);                     
                        window.location.reload();
                    },
                    error: function () {
                        alert('服务器故障，稍后再试');
                        $('#delete').attr('disabled', false);
                    },
                    cache: false
                });

            }
        })


    })
</script>
<script>
   var dataLength="<?php echo ((isset($count) && ($count !== ""))?($count):0); ?>";   
   var pageSize=10;  
   var allPageNum=dataLength%pageSize==0 ? parseInt(dataLength/pageSize):(parseInt(dataLength/pageSize)+1); 
   var p =<?php echo ((isset($_GET['p']) && ($_GET['p'] !== ""))?($_GET['p']):1); ?>;   
       if(dataLength>pageSize){        
        page({
            id : 'pagation',
            nowNum : p,
            allNum : allPageNum,
            callBack : function(now,all){
                window.location.href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/media.php?s=/Member/pcmessage/p/"+now+'/pagesize/'+pageSize+'.html';
            }
        });
    }else{
        $("#pagation").css("display","none");
    }

    if($("#pagation").find(".jump").length>0){
        $("#pagation").find(".aBtns").css('padding',"0 0 0 250px");
    }else{
        $("#pagation").find(".aBtns").css('padding',"0 0 0 500px");
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