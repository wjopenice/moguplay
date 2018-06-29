<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>-<?php echo C('WEB_SITE_TITLE');?></title>
    <!-- <link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon"> -->
    <link href="<?php echo get_cover(C('SITE_ICO'),'path');?>" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/jquery.mousewheel.js"></script>
     <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "https://hm.baidu.com/hm.js?bc19aa51515f215def6b091f540c83ea";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
        })();
    </script>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- Logo -->
        <span class="logo" ><img src="<?php echo get_cover(C('HT_LOGO'),'path');?>" width="100%" height="100%" /></span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__MENU__["main"])): $key = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($key % 2 );++$key;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (U($menu["url"])); ?>"><i class="menu_<?php echo ($key); ?>"></i><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <span style="display:block;float:left;margin:0 10px;color:#fff;">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></span>
            <a href="javascript:;" style="float:left;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li><i  class="man_modify"></i><a href="/media.php" target="_blank">网站首页</a></li>
                <li><i  class="man_modify"></i><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><i  class="man_quit"></i><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>   
        </div>
    </div>
    <!-- /头部 -->
    <!-- 边栏 -->
    <div class="sidebar">
        <div class="user_nav">
           <span><img src="/Public/Admin/images/tx.jpg"></span>
           <p><?php echo session('user_auth.username');?></p>
           <p style="margin-top:0px;"><!-- 管理员 --><?php echo ($quanxian); ?></p>
        </div>
        <div  class="fgx">功能菜单</div>
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                <?php if(!empty($_extra_menu)): ?>
                    <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?>
                <?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
                        <ul class="side-sub-menu">
                            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                                    <a class="item" href="<?php echo (U($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
    <!-- 标题栏 -->
    <div class="main-title">
        <h2>[游戏状态列表]</h2>
    </div>
    <div class="cf top_nav_list">
        <div class="fl button_list">
            <?php if(empty($model["extend"])): ?><div class="tools">

                </div><?php endif; ?>
        </div>
        <!-- 高级搜索 -->
        <div class="search-form fr cf" style="margin-bottom:-15px;">
        游戏搜索
            <div class="chose_game"  id="sel_game" style="float:left;width:172px;height:28px;line-height:28px;margin:0 5px 0 5px;">
                <select>
                        <option value="" >请选择游戏</option>
                        <option value="全部">全部</option>
                        <?php $_result=get_game_list();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(I('get.game_id') == $vo.id): ?><option value="<?php echo ($vo["id"]); ?>" checked="checked" ><?php echo ($vo["game_name"]); ?></option>  
                        <?php else: ?>
                            <option value="<?php echo ($vo["id"]); ?>" ><?php echo ($vo["game_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>                           
                </select>
            </div> 
            <!-- 游戏推荐状态搜索 -->
            <div class="d_list">
                <div class="drop-down drop-down13" style="width:100px">
                    <span id="sort-txt" class="sort-txt" data="{I('app_recommend_status')}" style="width:65px">
                        <?php if(I('app_recommend_status') == ''): ?>推荐状态
                        <?php elseif(I('app_recommend_status') == 0): ?>不推荐
                        <?php elseif(I('app_recommend_status') == 1): ?>推荐
                         <?php elseif(I('app_recommend_status') == 2): ?>热门
                          <?php elseif(I('app_recommend_status') == 3): ?>最新<?php endif; ?>
                    </span>
                    <i class="arrow arrow-down"></i>
                    <ul  class="nav-list hidden">
                        <li><a href="javascript:;" value="" style="width:80px">全部</a></li>
                        <li><a href="javascript:;" value="0" style="width:80px">不推荐</a></li>
                        <li><a href="javascript:;" value="1" style="width:80px">推荐</a></li>
                        <li><a href="javascript:;" value="2" style="width:80px">热门</a></li>
                        <li><a href="javascript:;" value="3" style="width:80px">最新</a></li>
                    </ul>
                </div>
                <input type='hidden' id='app_recommend_status' name="app_recommend_status" class="hiddenvalue" value="<?php echo I('app_recommend_status');?>"></input>
            </div>
            <!-- 游戏类型搜索 -->
            <div class="d_list" id="gt">
                <div class="drop-down" style="width:100px" id="game_type">
                    <span  class="sort-txt" data="<?php echo I('game_type_name');?>" style="width:65px">
                        <?php if(I('game_type_name') == ''): ?>游戏类型
                        <?php else: ?>
                            <?php echo I('game_type_name'); endif; ?>
                    </span>
                    <i class="arrow arrow-down"></i>
                    <ul  class="nav-list hidden">
                        <li><a href="javascript:;" value="" style="width:80px">全部</a></li>
                        <?php $_result=get_game_type_all();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="javascript:;" value="<?php echo ($vo["id"]); ?>" style="width:80px"><?php echo ($vo["type_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <input type="hidden" class="hiddenvalue" id="game_type_id" name="game_type_name" value="<?php echo I('game_type_name');?>"></input>
            </div>

            <div class="input-list">
                <a class="sch-btn" href="javascript:;" id="search" url="<?php echo U('APP/game_status_lists','model='.$model['name'],false);?>">搜索</a>
            </div>
        </div>
        
    </div>

    <!-- 数据列表 -->
    <div class="data-table">
        <div class="data-table table-striped">
            <table>
                <!-- 表头 -->
                <thead>
                <tr>
                    <th class="row-selected row-selected">
                        <input class="check-all" type="checkbox">
                    </th>
                    <th style="text-align:center">游戏id</th>
                    <th style="text-align:center">游戏名称</th>
                    <th style="text-align:center">游戏类型</th>
                    <th style="text-align:center">游戏显示状态</th>
                    <th style="text-align:center">排序</th>
                    <th style="text-align:center">时间</th>
                    <th style="text-align:center">操作</th>
                </tr>
                </thead>
                <!-- 列表 -->
                <tbody>
                <?php if(is_array($list_data)): $i = 0; $__LIST__ = $list_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr style="height:44px;">                   
                        <td style="border-right:1px solid #DDDDDD;text-align:center"><input class="ids" type="checkbox" value="<?php echo ($data['id']); ?>" name="ids[]"></td>
                        <td style="border-right:1px solid #DDDDDD;text-align:center;width:10%;" class='getId'>
                        <input type="text" name="id" value="<?php echo ($data["id"]); ?>" disabled="disabled"  style="outline: none;border:none;text-align:center;background: #fff;">
                        </td>
                        <td style="border-right:1px solid #DDDDDD;text-align:center"><?php echo ($data["game_name"]); ?></td>
                        <td style="border-right:1px solid #DDDDDD;text-align:center"><?php echo ($data["game_type_name"]); ?></td>
                        <td style="border-right:1px solid #DDDDDD;text-align:center;padding:0;" class='tuijian'>
                           <!--  <?php switch($data["app_recommend_status"]): case "1": ?>推荐<?php break;?>
                               <?php case "2": ?>热门<?php break;?>
                               <?php case "3": ?>最新<?php break;?>
                               <?php default: ?>不推荐<?php endswitch;?>  -->
                           <span style="width:100%;text-align: center;display:block;" >
                               <?php switch($data["app_recommend_status"]): case "1": ?>推荐<?php break;?>
                                   <?php case "2": ?>热门<?php break;?>
                                   <?php case "3": ?>最新<?php break;?>
                                   <?php default: ?>不推荐<?php endswitch;?> 
                           </span>
                           <select name="status" style="display: none;width:100%;text-align:center;border:none;outline: none;">
                                <option value="0">不推荐</option>
                                <option value="1">推荐</option>
                                <option value="2">热门</option>
                                <option value="3">最新</option>
                           </select>                      
                        </td>
                        <td style="border-right:1px solid #DDDDDD;text-align:center;width:10%;" class='paiXu'>
                         <input type="text" name="sort" value="<?php echo ($data["app_sort"]); ?>" readonly="readonly" style="outline: none;border:none;text-align:center;background: #fff;" >

                        </td>


                        <td style="border-right:1px solid #DDDDDD;text-align:center"><?php echo set_show_time($data['create_time']);?></td>
                        <td style="border-right:1px solid #DDDDDD;text-align:center">                          
                            <input type="button" value="编辑" class="edit" style="display: inline-block;text-align: center;outline: none;border:none;color:#145ccd;background: #fff;cursor: pointer;">
                            <input type="button" value="保存" class="tijao" style="display: inline-block;text-align: center;outline: none;border:none;color:#145ccd;background: #fff;cursor: pointer;">
                        </td>                     
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="page">
        <?php echo ((isset($_page) && ($_page !== ""))?($_page):''); ?>
    </div>
   


        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl">感谢使用<a href="http://www.game-pk.com">手上科技</a>游戏运营平台</div>
                <div class="fr"></div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "", //当前网站地址
            "APP"    : "/admin.php?s=", //当前项目地址
            "PUBLIC" : "/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/Public/static/think.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /*初始化导航菜单*/
             $subnav.find(".icon").addClass("icon-fold");
             $subnav.find(".side-sub-menu").siblings(".side-sub-menu").hide();
            
            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");
            //显示选中的菜单
            $subnav.find("a[href='" + url + "']").parent().parent().prev("h3").find("i").removeClass("icon-fold");
            $subnav.find("a[href='" + url + "']").parent().parent().show();

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });
            $("#subnav h3 a").click(function(e){e.stopPropagation()});
            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

            /* 表单获取焦点变色 */
            $("form").on("focus", "input", function(){
                $(this).addClass('focus');
            }).on("blur","input",function(){
                        $(this).removeClass('focus');
                    });
            $("form").on("focus", "textarea", function(){
                $(this).closest('label').addClass('focus');
            }).on("blur","textarea",function(){
                $(this).closest('label').removeClass('focus');
            });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>
    
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/combo.select.css" media="all">
<script src="/Public/Admin/js/jquery.combo.select.js"></script>
<style>
   #sel_game .combo-select {width:172px;border: 1px #fff solid;}
   #sel_game .text-input{height:28px;}
   #sel_game .combo-input{padding:0 0 0 12px;}
</style>
<script type="text/javascript">
$(function(){
    var gameBh="<?php echo ((isset($_GET['game_id']) && ($_GET['game_id'] !== ""))?($_GET['game_id']):""); ?>";   
    $("#sel_game").find('select option[value='+gameBh+']').attr("selected","selected");
    $("#sel_game").find('select').comboSelect();     
})
</script>
    <script src="/Public/static/layer/layer.js"></script>
    <script type="text/javascript">
        //导航高亮
        highlight_subnav('<?php echo U('APP/game_status_lists');?>');
        $(function(){
            //搜索功能
            $("#search").click(function(){
                var url = $(this).attr('url');               
                var query  = $.param({
                 'game_id':$.trim($("#sel_game select").val()),
                 'app_recommend_status':$.trim($("#app_recommend_status").val()),
                 'game_type_name':$.trim($("#game_type_id").val())

                });
                query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
                query = query.replace(/^&/g,'');
                if( url.indexOf('?')>0 ){
                    url += '&' + query;
                }else{
                    url += '?' + query;
                }
                window.location.href = url;
            });

            //回车自动提交
            $('.search-form').find('input').keyup(function(event){
                if(event.keyCode===13){
                    $("#search").click();
                }
            });

            //点击排序
            $('.list_sort').click(function(){
                var url = $(this).attr('url');
                var ids = $('.ids:checked');
                var param = '';
                if(ids.length > 0){
                    var str = new Array();
                    ids.each(function(){
                        str.push($(this).val());
                    });
                    param = str.join(',');
                }

                if(url != undefined && url != ''){

                    window.location.href = url.replace(".html","") + '/ids/' + param;
                }
            });

            // layer.confirm('您是如何看待前端开发？', {
            //   btn: ['重要','奇葩'] //按钮
            // }, function(){
            //   layer.msg('的确很重要', {icon: 1});
            // }, function(){
            //   layer.msg('也可以这样', {
            //     time: 20000, //20s后自动关闭
            //     btn: ['明白了', '知道了']
            //   });
            // });

            $("#gt").find("#game_type").hover(function(){
                $(this).find(".nav-list").removeClass("hidden");
            },function(){
                $(this).find(".nav-list").addClass("hidden");
            });

            $("#game_type .nav-list li").find("a").each(function(){
                var that = $("#game_type");
                $(this).click(function(){
                    var text = $(this).text();
                    that.find(".sort-txt").text(text).attr("data",$(this).attr("value"));
                    that.find(".nav-list").addClass("hidden");
                    that.siblings('.hiddenvalue').val(text);
                })
            });

            $(".drop-down22").on('click',function(event) {
                var navlist = $(this).find('.i_list_li');
                if (navlist.hasClass('hidden')) {
                    navlist.removeClass('hidden');
                    $('#i_list_id').focus().val('');
                } else {
                    navlist.addClass('hidden');
                }
                $(document).one("click", function(){
                    navlist.addClass('hidden');
                });
                event.stopPropagation();
            });

            $('#i_list_id').on('keyup',function(event) {
                var val  = $.trim($(this).val()).toLowerCase();
                $('#i_list_idh').val(val);
            });

            $("#i_list_li").find("a").each(function(){
                $(this).click(function(){
                    var text = $.trim($(this).text()).toLowerCase();
                    $("#i_list_id").val(text);
                    $('#i_list_idh').val(text);
                })
            });

            //显示状态
            $(".d_list").find(".drop-down12").hover(function(){
                $(this).find(".nav-list").removeClass("hidden");
            },function(){
                $(this).find(".nav-list").addClass("hidden");
            });

            $(".drop-down12 .nav-list li").find("a").each(function(){
                var that = $(".drop-down12");
                $(this).click(function(){
                    var text = $(this).text(),val = $(this).attr("value");
                    that.find(".sort-txt").text(text).attr("data",val);
                    that.find(".nav-list").addClass("hidden");
                    that.siblings('.hiddenvalue').val(val);
                })
            });


            //推荐状态
            $(".d_list").find(".drop-down13").hover(function(){
                $(this).find(".nav-list").removeClass("hidden");
            },function(){
                $(this).find(".nav-list").addClass("hidden");
            });

            $(".drop-down13 .nav-list li").find("a").each(function(){
                var that = $(".drop-down13");
                $(this).click(function(){
                    var text = $(this).text(),val = $(this).attr("value");
                    that.find(".sort-txt").text(text).attr("data",val);
                    that.find(".nav-list").addClass("hidden");
                    that.siblings('.hiddenvalue').val(val);
                })
            });
        })

    </script>

<script>
$(function(){
    $('table tbody').find('tr').each(function(){
        var selValue=$.trim($(this).find(".tuijian").find('span').html());
        var selBh=0;
        if(selValue=='不推荐'){
            selBh=0;
        }else if(selValue=='推荐'){
            selBh=1;
        }else if(selValue=='热门'){
            selBh=2;
        }else if(selValue=='最新'){
            selBh=3;
        }
        $(this).find('select option[value='+selBh+']').attr("selected","selected");
        $(this).find('.edit').click(function(){               
            $(this).parents('tr').eq($(this).index()).find(".tuijian").find('span').hide().siblings('select').show();                       
            $(this).parents('tr').eq($(this).index()).find(".paiXu").find('input').prop('readonly',false);
        });
        var ogstatus=$(this).find(".tuijian").find('select').val();
        var ogsort=$(this).find(".paiXu").find('input').val();
        $(this).find('.tijao').click(function(){
            var gid=$.trim( $(this).parents('tr').eq($(this).index()-1).find(".getId").find('input').val());
            var gstatus=$.trim( $(this).parents('tr').eq($(this).index()-1).find(".tuijian").find('select').val());
            var gsort=$.trim( $(this).parents('tr').eq($(this).index()-1).find(".paiXu").find('input').val());  
         if(ogstatus==gstatus && ogsort==gsort){
           $(this).parents('tr').eq($(this).index()-1).find(".tuijian").find('span').show().siblings('select').hide();                        
           $(this).parents('tr').eq($(this).index()-1).find(".paiXu").find('input').prop('readonly',true);
            return false;}
            else{             
                $.ajax({
                    type:'post',
                    dataType:'json',
                    async:false,
                    data:{
                        id:gid,
                        status:gstatus,
                        sort:gsort
                    },
                    url:"<?php echo U('APP/game_status_edit');?>",
                    success:function(data){                        
                        if(parseInt(data.status)==1){
                            window.location.reload();
                        }else{
                            alert('编辑失败');
                        }
                    },
                    error:function(){
                        alert('服务器错误，请稍后再试！')
                    }
                })
            }
        })
    })
})
</script>

</body>
</html>