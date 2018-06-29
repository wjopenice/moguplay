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
            

            
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/admin_table.css" media="all">
<script type="text/javascript" src="/Public/static/uploadify/jquery.uploadify.min.js"></script>
    <div class="main-title cf">
        <h2>编辑 [APP图片]</h2>
    </div>
    <!-- 标签页导航 -->
<div class="tab-wrap">
    <div class="tab-content zc_for">
    <!-- 表单 -->
    <form id="form" action="<?php echo U('img_edit');?>" method="post" class="form-horizontal" onsubmit="return kong()">
        <!-- 基础 -->
        <div id="tab1" class="tab-pane in tab1 tab-look">
    		<table  border="0" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                    <td class="l">标题：</td>
                    <td class="r">
                        <input type="text" class="txt" name="title" id="title" value="<?php echo ($edit_data["title"]); ?>" placeholder="请输入图片标题">
                        <span id="title1" style="color:red;"></span>
                    </td>
                  </tr>
                  
                  <tr>
                    <td class="l">游戏名称：</td>
                    <td class="">
                        <!-- <select id="game_id" name="game_id">
                                               <option value="">请选择游戏</option>
                                               <?php $_result=get_game_list();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo[id] == $edit_data[game_id]): ?><option value="<?php echo ($vo["id"]); ?>" selected><?php echo ($vo["game_name"]); ?></option>
                                               <?php else: ?>
                                                    <option value="<?php echo ($vo["id"]); ?>" ><?php echo ($vo["game_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                               </select>
                                              <span id="game_id1" style="color:red;"></span> -->
                    <div class="chose_game"  id="sel_game" style="float:left;height: 35px;width: 260px;font-size: 14px;margin:0 5px 0 0px;">
                                    <select name="game_id">
                                        <option value="" >请选择游戏</option>
                                        <option value="全部">全部</option>
                                        <?php $_result=get_game_list();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo[id] == $edit_data[game_id]): ?><option value="<?php echo ($vo["id"]); ?>" selected><?php echo ($vo["game_name"]); ?></option>
                                               <?php else: ?>
                                                    <option value="<?php echo ($vo["id"]); ?>" ><?php echo ($vo["game_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                    </td>  
                  </tr>
             

                  
                  <tr>
                    <td class="l">生成链接地址：</td>
                    <td class="r">
                        <select name="adv_type">
                            <?php $_result=get_adv_type_list();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo[adv_type] == $edit_data[adv_type]): ?><option value="<?php echo ($vo["adv_type"]); ?>" selected><?php echo ($vo["adv_msg"]); ?></option>
                                               <?php else: ?>
                                                    <option value="<?php echo ($vo["adv_type"]); ?>" ><?php echo ($vo["adv_msg"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <!-- <input type="radio"  value="0" class="inp_radio"/>
                        <input type="radio" name="adv_type" value="1" class="inp_radio"/>游戏
                        <input type="radio" name="adv_type" value="2" class="inp_radio"/>资讯 -->
                        <input type="text" name="adv_jump_id" placeholder="请输入链接id参数" class="txt" value="<?php echo ($edit_data["adv_jump_id"]); ?>">
                    </td>
                  </tr>
                  <tr>
                    <td class="l">链接地址：</td>
                    <td class="r">
                        <input type="text" class="txt txt_title" name="adv_url" id="adv_url" value="<?php echo ($edit_data["adv_url"]); ?>" placeholder="请输入图片的链接地址" style="width:650px;">
                        <span id="adv_url1" style="color:red;"></span>
                    </td>
                  </tr>
             
                 
                  <tr>
                    <td class="l">游戏排序：</td>
                    <td class="r">
                        <input type="text" class="txt" name="sort" id="sort" value="<?php echo ($edit_data["sort"]); ?>">
                        <span id="sort1" style="color:red;"></span>
                    </td>
                  
                  </tr>
                    <td class="l">显示状态：</td>
                    <td class="r">
                        <label class="inp_radio">
                            <input type="radio" class="inp_radio" value="0" name="status" <?php if(($edit_data['status']) == "0"): ?>checked="checked"<?php endif; ?> >关闭
                            <input type="radio" class="inp_radio" value="1" name="status" <?php if(($edit_data['status']) == "1"): ?>checked="checked"<?php endif; ?> >开启
                        </label>
                    </td>
                  <tr>
                      
                  </tr>
                  <tr>
                    <td class="l">图片位置：</td>
                    <td class="r">
                        <select id="location" name="pos_id">  
                            <option value="">请选择图片位置</option>                          
                            <?php $_result=get_applocation_list();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if($v[location] == $edit_data['location']): ?><option value="<?php echo ($v["pos_id"]); ?>" selected><?php echo ($v["location"]); ?></option>
                            <?php else: ?>
                            <option value="<?php echo ($v["pos_id"]); ?>" `><?php echo ($v["location"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                       <span id="location1" style="color:red;"></span>
                      <input type="hidden" name="location" value="" id='loc_pos'>
                    </td>  
                  </tr>
                  <tr>
                    <td class="l">图片尺寸：</td>
                    <td class="r">                      
                      <input type="text" name="size" value="<?php echo ($edit_data["size"]); ?>" class="txt" />
                    </td>  
                  </tr>
                  <tr>
                      <td class="l">选择上传图片
                      <!-- ：<span class="infonotice2">(尺寸：<?php echo ($edit_data['size']); ?>px)</span>  -->
                        </td>
                      <td class="r">
                          <?php echo hook('UploadImages', array('name'=>'image_url','value'=>$edit_data['image_url']));?>
                      
                      </td>
                  </tr>
                    <input type="hidden" name="id" value="<?php echo ($edit_data["id"]); ?>">

                </tbody>
            </table>
        </div>
     

                </tbody>
            </table>
        </div>
        <!-- <button type="submit">确定</button> -->
        <!-- <div class="form-item cf">
            <button class="btn submit-btn ajax-post hidden" id="submit" type="submit" target-form="form-horizontal">确 定</button>
            <a class="btn btn-return" href="javascript:history.back(-1);">返 回</a>
        </div> -->
        <div class="form-item">
            <input  type="submit" name="submit" value="确 定" style="border:none;width:70px;height: 40px;color:#fff; background-color: #2062b0;   margin: 30px 10px;padding: 10px;line-height: 20px;cursor: pointer;" id='subBtn'>
            <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
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
    
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/combo.select.css" media="all">
<script src="/Public/Admin/js/jquery.combo.select.js"></script>
<style>
   #sel_game .combo-select {width:260px;border: 1px #fff solid;}
   #sel_game .text-input {height:35px;}
   #sel_game .combo-input{padding:0 0 0 12px;}
  .zc_for input{width: 260px;margin-left:0;}
  .option-hover span{color: #fff!important; }
  .option-item span{color:#404040;} 
  .option-item:hover span{color:#fff;} 
  </style>
<script type="text/javascript">
$(function(){
    $("#sel_game").find('select').comboSelect(); 

    $('#sel_game').find('.combo-select').on('click',function(){
     var gameBh=$('.option-selected').attr('data-value');
     $('input[name=adv_jump_id]').val(gameBh);    
    })



 

    var txt=$('#location').find('option:selected').text();
    $('#loc_pos').val(txt);
    $('#location').on('change',function(){
    var txt=$('#location').find('option:selected').text();
    $('#loc_pos').val(txt);
   })
})
</script>
<script type="text/javascript" src="/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
//alert($("#cover_id_icon").parent().find('.upload-img-box').html());
//导航高亮
highlight_subnav('<?php echo U('APP/index');?>');
$('#subBtn').click(function(){ 
    $('#form').submit();
});

$(function(){
    $("input[name='game_appid']").val("<?php echo generate_game_appid();?>");
    $("#game_type_name").val($("#game_type_id option:selected").text());
    
    $('.date').datetimepicker({
        format: 'yyyy-mm-dd',
        language:"zh-CN",
        minView:2,
        autoclose:true
    });
    $('.time').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language:"zh-CN",
        minView:2,
        autoclose:true
    });
    showTab();

});



//上传游戏图标
/* 初始化上传插件 */
$("#upload_picture_icon").uploadify({
    "height"          : 30,
    "swf"             : "/Public/static/uploadify/uploadify.swf",
    "fileObjName"     : "download",
    "buttonText"      : "上传图标",
    "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
    "width"           : 120,
    'removeTimeout'   : 1,
    'fileTypeExts'    : '*.jpg; *.png; *.gif;',
    "onUploadSuccess" : upload_picture_icon<?php echo ($field["name"]); ?>,
    'onFallback' : function() {
        alert('未检测到兼容版本的Flash.');
    }
});
function upload_picture_icon<?php echo ($field["name"]); ?>(file, data){
    var data = $.parseJSON(data);
    var src = '';
    if(data.status){
        $("#cover_id_icon").val(data.id);
        src = data.url || '' + data.path;
        $("#cover_id_icon").parent().find('.upload-img-box').html(
            '<div class="upload-pre-item"><img src="' + src + '"/></div>'
        );
    } else {
        updateAlert(data.info);
        setTimeout(function(){
            $('#top-alert').find('button').click();
            $(that).removeClass('disabled').prop('disabled',false);
        },1500);
    }
}


//上传游戏封面
/* 初始化上传插件 */
$("#upload_picture_cover").uploadify({
    "height"          : 30,
    "swf"             : "/Public/static/uploadify/uploadify.swf",
    "fileObjName"     : "download",
    "buttonText"      : "上传封面",
    "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
    "width"           : 120,
    'removeTimeout'   : 1,
    'fileTypeExts'    : '*.jpg; *.png; *.gif;',
    "onUploadSuccess" : upload_picture_cover<?php echo ($field["name"]); ?>,
    'onFallback' : function() {
        alert('未检测到兼容版本的Flash.');
    }
});
function upload_picture_cover<?php echo ($field["name"]); ?>(file, data){
    var data = $.parseJSON(data);
    var src = '';
    if(data.status){
        $("#cover_id_cover").val(data.id);
        src = data.url || '' + data.path;
        $("#cover_id_cover").parent().find('.upload-img-box').html(
            '<div class="upload-pre-item"><img src="' + src + '"/></div>'
        );
    } else {
        updateAlert(data.info);
        setTimeout(function(){
            $('#top-alert').find('button').click();
            $(that).removeClass('disabled').prop('disabled',false);
        },1500);
    }
}
// window.onload=function(){

// }
  $('body').on('click','.btn-close-image_url',function(){
      event.preventDefault();
      $(this).parent().remove();
  });

function kong(){
            if(document.getElementById('title').value==''){
               /*alert('标题不能为空');*/
               $('#title1').text('标题不能为空！！！');
               return false;
            }

           if(document.getElementById('game_id').value==''){
               $('#game_id1').text('请选择游戏！！！');
               return false;
           }
            if(document.getElementById('location').value==''){
               $('#location1').text('请选择图片位置！！！');
               return false;
           }
            if(document.getElementById('sort').value==''){
               $('#sort1').text('排序不能为空！！！');
               return false;
           }
           
       }
</script>

</body>
</html>