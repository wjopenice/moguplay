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
        <h2>[<?php echo ($model['title']); ?>] 列表</h2>
    </div>
    <div class="cf top_nav_list">
        <!-- <div class="fl">
        <?php if(empty($model["extend"])): ?><div class="tools">
                <a class="btn" href="<?php echo U('add?model='.$model['id']);?>">新 增</a>
                <button class="btn ajax-post confirm" target-form="ids" url="<?php echo U('del?model='.$model['id']);?>">删 除</button>
            </div><?php endif; ?>
        </div> -->
        <!-- 高级搜索 -->
        <div class="search-form fr cf">
            <!-- <div class="input-list">
                <label>充值时间：</label>
                <input type="text" id="time-start" name="time-start" class="text input-2x" value="<?php echo I('time-start');?>" placeholder="起始时间" /> 
                -
                <div class="input-append date" id="datetimepicker"  style="display:inline-block">
                <input type="text" id="time-end" name="time-end" class="text input-2x" value="<?php echo I('time-end');?>" placeholder="结束时间" />
                <span class="add-on"><i class="icon-th"></i></span>
                </div>
            </div> -->
             <div class="input-list">
                <label>充值时间：</label>
                <input type="text" id="time-start" name="time-start" class="text input-2x" <?php if(I('time-start')!=''): ?>value="<?php echo I('time-start');?>" <?php else: ?>value="<?php echo I('start');?>"<?php endif; ?> placeholder="起始时间" /> 
                -
                <div class="input-append date" id="datetimepicker"  style="display:inline-block">
                <input type="text" id="time-end" name="time-end" class="text input-2x" <?php if(I('time-end')!=''): ?>value="<?php echo I('time-end');?>" <?php else: ?>value="<?php echo I('end');?>"<?php endif; ?> placeholder="结束时间" />
                <span class="add-on"><i class="icon-th"></i></span>
                </div>
            </div>
            <!-- <div class="i_list">
                <div class="drop-down drop-down2">
                    <?php if(I('promote_name') == ''): ?><input type="text" id="promoteid" class="sort-txt" name="promote_name" value="" placeholder="请选择所属渠道" />
                    <?php else: ?>
                    <input type="text" id="promoteid" class="sort-txt" name="promote_name" value="<?php echo I('promote_name');?>" placeholder="请选择所属渠道" /><?php endif; ?>
                    <input type="hidden" id="promoteidh" name="promote_id" value="<?php echo I('promote_id');?>" />
                    <i class="arrow arrow-down"></i>
                    <ul id="promoteidlist" class="nav-list hidden i_list_li">
                        <li><a href="javascript:;" value="" >全部</a></li>
                        <li><a href="javascript:;" value="0" >自然注册</a></li>
                        <?php $_result=get_promote_all();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="javascript:;" value="<?php echo ($vo["id"]); ?>" ><?php echo ($vo["account"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>                
            </div> -->
             <!-- 请选择所属渠道 2017/7/31 -->
            <div class="chose_game"  id="sel_qd" style="float:left;width:172px;height:28px;line-height:28px;margin:0 5px 0 5px;">
                <select>
                    <option value="" >请选择所属渠道</option>
                    <option value="全部">全部</option>
                    <option value="0">自然注册</option>
                    <?php $_result=get_promote_all();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(I('promote_name') == ''): ?><option value="<?php echo ($vo["id"]); ?>" checked="checked" ><?php echo ($vo["account"]); ?></option>
                            <?php else: ?>
                            <option value="<?php echo ($vo["id"]); ?>" ><?php echo ($vo["account"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <div class="d_list">
                <div class="drop-down drop-down12" style="width:100px">
                    <span  class="sort-txt" data="{I('pay_status')}" style="width:65px">
                        <?php if(I('pay_status') == ''): ?>支付状态
                        <?php elseif(I('pay_status') == 0): ?>未支付
                        <?php elseif(I('pay_status') == 1): ?>成功<?php endif; ?>
                    </span>
                    <i class="arrow arrow-down"></i>
                    <ul  class="nav-list hidden">
                        <li><a href="javascript:;" value="" style="width:80px">全部</a></li>
                        <li><a href="javascript:;" value="0" style="width:80px">未支付</a></li>
                        <li><a href="javascript:;" value="1" style="width:80px">成功</a></li>
                    </ul>
                </div>
                <input type="hidden" class="hiddenvalue" id="pay_status" name="pay_status" value="<?php echo I('pay_status');?>" />
            </div>
            <div class="d_list">
                <div class="drop-down drop-down11" style="width:100px">
                    <span  class="sort-txt" data="{I('pay_way')}" style="width:65px">
                        <?php if(I('pay_way') == ''): ?>支付方式
                        <?php elseif(I('pay_way') == 1): ?>支付宝
                        <?php else: ?>微信<?php endif; ?>
                    </span>
                    <i class="arrow arrow-down"></i>
                    <ul class="nav-list hidden">
                        <li><a href="javascript:;" value="" style="width:80px">全部</a></li>
                        <!-- <li><a href="javascript:;" value="0" style="width:80px">平台币</a></li> -->
                        <li><a href="javascript:;" value="1" style="width:80px">支付宝</a></li>
                        <li><a href="javascript:;" value="2" style="width:80px">微信</a></li>
                    </ul>
                </div>
                <input type="hidden" class="hiddenvalue" id="pay_way" name="pay_way" value="<?php echo I('pay_way');?>" />
            </div>
            <div class="sleft">
                <input type="text" name="<?php echo ((isset($model['search_key']) && ($model['search_key'] !== ""))?($model['search_key']):'user_account'); ?>" class="search-input" value="<?php echo I('user_account');?>" placeholder="请输入用户账号" id='user_account'>
            </div>
            <div class="input-list">
                <a class="sch-btn" href="javascript:;" id="search" url="<?php echo U('Deposit/lists','model='.$model['name'],false);?>">搜索</a>
            </div>
            <div class="input-list">
                <a class="sch-btn" href="<?php echo U('Export/expUser',array( 'id'=>8, 'user_nickname'=>I('user_nickname'), 'pay_way'=>I('pay_way'), 'promote_id'=>I('promote_id'), 'promote_name'=>I('promote_name'), 'pay_status'=>I('pay_status'), 'time-start'=>I('time-start'), 'time-end'=>I('time-end'), 'start'=>I('start'), 'end'=>I('end'),));?>">导出</a>
                <span class="totalvalue">(共计充值<i><?php echo ($total); ?></i>元)</span>
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
                        <?php if(is_array($list_grids)): $i = 0; $__LIST__ = $list_grids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i;?><th><?php echo ($field["title"]); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tr>
                </thead>

                <!-- 列表 -->
                <tbody>
                    <?php if(is_array($list_data)): $i = 0; $__LIST__ = $list_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                            <?php if(is_array($list_grids)): $i = 0; $__LIST__ = $list_grids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$grid): $mod = ($i % 2 );++$i;?><td><?php echo get_list_field($data,$grid);?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="page">
        <?php echo ((isset($_page) && ($_page !== ""))?($_page):''); ?>
    </div>
    <!-- <span><a href="<?php echo U('Export/expUser',array( 'id'=>8, 'user_nickname'=>I('user_nickname'), 'time-start'=>I('time-start'), 'time-end'=>I('time-end'), 'start'=>I('start'), 'end'=>I('end'), ));?>">导出数据(excel格式)</a></span> -->

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
    
<link href="/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
<?php if(C('COLOR_STYLE')=='blue_color') echo '<link href="/Public/static/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css">'; ?>
<link href="/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/combo.select.css" media="all">
<script src="/Public/Admin/js/jquery.combo.select.js"></script>
<style>
#sel_qd .combo-select {width:172px;border: 1px #fff solid;}
#sel_qd .text-input {height:28px;}
#sel_qd .combo-input {padding:0 0 0 12px;}
</style>
<script type="text/javascript">
    $(function(){
        var qdBh='<?php echo ((isset($_GET['promote_id']) && ($_GET['promote_id'] !== ""))?($_GET['promote_id']):""); ?>';      
        $("#sel_qd").find('select option[value='+qdBh+']').attr("selected","selected");
        $("#sel_qd").find('select').comboSelect();
    })
</script>
<script type="text/javascript">
//导航高亮
highlight_subnav('<?php echo U('Deposit/lists');?>');
$(function(){
    //搜索功能
    $("#search").click(function(){
        var url = $(this).attr('url');
        // var query  = $('.search-form').find('input').serialize();
         var query=$.param({
            'time-start': $.trim($("#time-start").val()),
            'time-end': $.trim($("#time-end").val()),
            'promote_id':$.trim( $("#sel_qd select").val()),
            'pay_status': $.trim($("#pay_status").val()),
            'pay_way': $.trim($("#pay_way").val()),
            'user_account': $.trim($("#user_account").val())
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
    
    
    $('#time-start').datetimepicker({
        format: 'yyyy-mm-dd',
        language:"zh-CN",
        minView:2,
        autoclose:true
    });

    $('#datetimepicker').datetimepicker({
       format: 'yyyy-mm-dd',
        language:"zh-CN",
        minView:2,
        autoclose:true,
        pickerPosition:'bottom-left'
    })

    
    $(".drop-down2").on('click',function(event) {
        var navlist = $(this).find('.i_list_li');
        if (navlist.hasClass('hidden')) {
            navlist.removeClass('hidden');
            $('#promoteid').focus().val('');            
        } else {
            navlist.addClass('hidden');
        }
        $(document).one("click", function(){
            navlist.addClass('hidden');
        });
        event.stopPropagation();
    });
    var a = $('.i_list_li li a');
    $('#promoteid').on('keyup',function(event) {
        var val  = $.trim($(this).val()).toLowerCase();
        $('#promoteid').val(val);
        $('#promoteidh').val(-1);
    });
    
    $('#promoteidlist').find("a").each(function(){
        $(this).click(function(){
            var text = $.trim($(this).text()).toLowerCase(),
                val = $(this).attr('value');
            $('#promoteid').val(text);
            $('#promoteidh').val(val);
        })
    });
    
    $(".d_list").find(".drop-down11").hover(function(){
        $(this).find(".nav-list").removeClass("hidden");
    },function(){
        $(this).find(".nav-list").addClass("hidden");
    });

    $(".drop-down11 .nav-list li").find("a").each(function(){
        var that = $(".drop-down11");
        $(this).click(function(){
            var text = $(this).text(),val = $(this).attr("value");
            that.find(".sort-txt").text(text).attr("data",val);
            that.find(".nav-list").addClass("hidden");
            that.siblings('.hiddenvalue').val(val);
        })
    });
    
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
})
</script>

</body>
</html>