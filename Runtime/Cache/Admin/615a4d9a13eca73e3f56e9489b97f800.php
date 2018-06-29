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
            

            
<script src="/Public/static/layer/layer.js" type="text/javascript"></script>
<script src="/Public/static/layer/extend/layer.ext.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/admin_table.css" media="all">
<script type="text/javascript" src="/Public/static/uploadify/jquery.uploadify.min.js"></script>
    <div class="main-title cf">
        <h2>编辑 [用户信息]</h2>
    </div>
    <!-- 标签页导航 -->
<div class="tab-wrap">
    <ul class="tab-nav nav">
			<?php $_result=parse_config_attr($model['field_group']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?><li data-tab="tab<?php echo ($key); ?>" <?php if(($key) == "1"): ?>class="current"<?php endif; ?>><a href="javascript:void(0);"><?php echo ($group); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <div class="tab-content zc_for">
    <!-- 表单 -->
    <form id="form" action="<?php echo U('edit?model='.$model['id']);?>" method="post" class="form-horizontal">
        <!-- 基础文档模型 -->
		<div id="tab1" class="tab-pane in tab1 tab-look">
            <table  border="0" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                    <td class="l">用户账号：</td>
                    <td class="r">
                        <input type="text" class="txt" name="account" value="<?php echo ($data['account']); ?>" readonly="readonly">
                    </td>
                    <td class="l">登陆密码：</td>
                    <td class="r">
                        <input type="text" class="txt" name="password" value="">
                    </td>
                  </tr>
                  <tr>
                    <td class="l">用户昵称：</td>
                    <td class="r">
                        <input type="text" class="txt" name="nickname" value="<?php echo ($data['nickname']); ?>" disabled>
                    </td>
                    <td class="l">电子邮件：</td>
                    <td class="r">
                        <input type="text" class="txt" name="email" value="<?php echo ($data['email']); ?>" disabled>
                    </td>
                  </tr>
                  <tr>
                    <td class="l">真实姓名：</td>
                    <td class="r">
                        <input type="text" class="txt" name="real_name" value="<?php echo ($data['real_name']); ?>" disabled>
                    </td>
                    <td class="l">身份证号：</td>
                    <td class="r">
                        <input type="text" class="txt" name="idcard" value="<?php echo ($data['idcard']); ?>" disabled>
                    </td>
                  </tr>
                    
                  <tr>
                    <td class="l">防沉迷：</td>
                    <td class="r">
                        <label class="inp_radio">
                            <input type="radio" class="inp_radio" value="0" name="anti_addiction" <?php if(($data['anti_addiction']) == "0"): ?>checked="checked"<?php endif; ?>>关闭
                            <input type="radio" class="inp_radio" value="1" name="anti_addiction" <?php if(($data['anti_addiction']) == "1"): ?>checked="checked"<?php endif; ?>>开启
                        </label>
                    </td>
                    <td class="l">账号状态：</td>
                    <td class="r">
                        <label class="inp_radio">
                            <input type="radio" class="inp_radio" value="0" name="lock_status" <?php if(($data['lock_status']) == "0"): ?>checked="checked"<?php endif; ?>>锁&nbsp;&nbsp;&nbsp;定
                            <input type="radio" class="inp_radio" value="1" name="lock_status" <?php if(($data['lock_status']) == "1"): ?>checked="checked"<?php endif; ?>>开启
                        </label>
                    </td>
                  </tr>
                  <tr>
                    <td class="l">电话：</td>
                    <td class="r" >
                        <input type="text" class="txt" name="phone" value="<?php echo ($data['phone']); ?>" disabled>
                    </td>
                  </tr>
                  <tr>
                    <td class="l">平台币余额：</td>
                    <td class="r">
                        <input type="text" class="txt" name="balance" value="<?php echo ($data['balance']); ?>" disabled style="width: 100px;">
                        <span class="che">修改</span> 
                    </td>
                    <td class="l">绑定平台余额：</td>
                    <td class="r">
                    <span id="bind_balance">点击查看</span>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                        <!-- <span class="bind_che">修改</span> --> 
                    </td>
                  </tr>
                      <tr>
                    <td class="l">注册时间：</td>
                    <td class="r">
                        <input type="text" class="txt" name="register_time" value="<?php echo (date("Y-m-d H:i:s",$data['register_time'])); ?>" disabled>
                    </td>
                    <td class="l">注册ip：</td>
                    <td class="r">
                    <input type="text" class="txt" name="register_ip" value="<?php echo ($data['register_ip']); ?>" disabled>

                    </td>
                  </tr>
                  <tr>
                    <td class="l">充值记录：</td>
                    <td class="r">
                    <span id="chongzhi">点击查看</span>
                    </td>
                      <td class="l">游戏登陆记录：</td>
                    <td class="r">
                    <span id="denglu">点击查看</span>
                    </td>
                  </tr>
                </tbody>
            </table>
        </div>

        <div class="form-item cf">
            <input type="hidden" id="selfid" name="id" value="<?php echo ($data["id"]); ?>">
            <input type="hidden" id="url" name="urll" value="<?php echo ($url); ?>">
            <button class="btn submit-btn ajax-post hidden" id="submit" type="submit" target-form="form-horizontal">确 定</button>
            <a class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</a>
        </div>
    </form>
    </div>
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
    
<link href="/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
<?php if(C('COLOR_STYLE')=='blue_color') echo '<link href="/Public/static/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css">'; ?>
<link href="/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript">
//导航高亮
highlight_subnav('<?php echo U('Member/user_info');?>');
Think.setValue("prmoote_id_to", <?php echo ((isset($data["promote_id"]) && ($data["promote_id"] !== ""))?($data["promote_id"]): 0); ?>);
$('#submit').click(function(){
    $('#form').submit();
});

$(function(){
	$('.time').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language:"zh-CN",
        minView:2,
        autoclose:true
    });
    $('.date').datetimepicker({
        format: 'yyyy-mm-dd',
        language:"zh-CN",
        minView:2,
        autoclose:true
    });
    showTab();
var id=$("#selfid").val();
var url=$("#url").val();
$("#chongzhi").click(function() {
 layer.open({
  type: 2,
  title: '充值记录',
  shadeClose: true,
  shade: 0.8,
  area: ['70%', '80%'],
  content: url+'admin.php?s=/Member/chax/id/'+id+''//iframe的url
}); 
});

$("#denglu").click(function() {
 layer.open({
  type: 2,
  title: '游戏登陆记录',
  shadeClose: true,
  shade: 0.8,
  area: ['70%', '80%'],
  content: url+'admin.php?s=/Member/denglu/id/'+id+''//iframe的url
}); 
});
$("#bind_balance").click(function() {
 layer.open({
  type: 2,
  title: '绑定平台币余额',
  shadeClose: true,
  shade: 0.8,
  area: ['70%', '80%'],
  content: url+'admin.php?s=/Member/bind_balance/id/'+id+''//iframe的url
}); 
});

$(".che").click(function() {
  //prompt层
  var prev_money = <?php echo ($data['balance']); ?>;
  layer.prompt({
    title: '请设置账户余额，并确认',
    formType: 0 //prompt风格，支持0-2
  }, function(pass){
    layer.msg('确认操作？', {
    time: 0 //不自动关闭
    ,btn: ['确定', '取消']
    ,yes: function(index){
      if(isNaN(pass)){
         layer.alert('金额不正确', {icon: 5});
      }else if(pass<0){
        layer.alert('金额不能小于0',{icon: 5});
      }else{
      var che="<?php echo U('recall');?>";
      $.ajax({
        url: che,
        type: 'POST',
        dataType: 'json',
        data: {id:$("#selfid").val(),balance:pass,prev_money:prev_money},
        success:function(data){
         if(data.status==1){
          layer.alert('修改成功', {icon: 6});
         location.reload();

        }else{
          layer.alert('修改失败', {icon: 6});
         location.reload();
        }
        },
        error:function(){
        }
      })
      }
  }
});
  });
});
$(".bind_che").click(function() {
  //prompt层
  layer.prompt({
    title: '请设置账户余额，并确认',
    formType: 0 //prompt风格，支持0-2
  }, function(pass){
    layer.msg('确认操作？', {
    time: 0 //不自动关闭
    ,btn: ['确定', '取消']
    ,yes: function(index){
      if(isNaN(pass)){
          layer.alert('金额不正确', {icon: 5});
      }else{
      var che="<?php echo U('bind_recall');?>";
      $.ajax({
        url: che,
        type: 'POST',
        dataType: 'json',
        data: {id:$("#selfid").val(),bind_balance:pass},
        success:function(data){
         if(data.status==1){
          layer.alert('修改成功', {icon: 6});
         location.reload();

        }else{
          layer.alert('修改失败', {icon: 6});
         location.reload();
        }
        },
        error:function(){
        }
      })
      }
  }
});
  });
});

});
</script>

</body>
</html>