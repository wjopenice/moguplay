<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta charset="UTF-8">
    <title>游戏登陆列表|溪谷软件管理平台</title>
    <link href="http://admin.vlcms.com/Public/icon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/blue_color.css" media="all">
</head>
	<style>
body{ padding: 0px; }
	</style>
<body>  
    <div id="main" class="main" style="min-height: 342px;">       
    <!-- 标题栏 -->
    <div class="main-title">
        <h2>[游戏登陆] 列表</h2>
    </div>
	<div class="cf">
	
	</div>

    <!-- 数据列表 -->
    <div class="data-table">
        <div class="data-table table-striped">
            <table>
                <!-- 表头 -->
                <thead>
                    <tr>
                                                
                        <th style="text-align:center">用户名</th>
                        <th style="text-align:center">登陆游戏</th>
                        <th style="text-align:center">登陆时间</th>
                    </tr>
                </thead>

                <!-- 列表 -->
                <tbody>
                	<?php if(is_array($list_data)): $i = 0; $__LIST__ = $list_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                            <td style="border-right:1px solid #DDDDDD;text-align:center"><?php echo get_user_account($data['user_id']);?></td>
                            <td style="border-right:1px solid #DDDDDD;text-align:center"><?php echo get_game_name($data['game_id']);?></td>
                            <td style="border-right:1px solid #DDDDDD;text-align:center"><?php echo (date("Y-m-d H:i:s",$data["login_time"])); ?></td>                           
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                          </tbody>
            </table>
        </div>
    </div>
    <div class="page">
    <?php echo ($_page); ?>
            </div>
    ﻿         
        </div>
  
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "", //当前网站地址
            "APP"    : "/admin.php?s=", //当前项目地址
            "PUBLIC" : "/Public", //项目公共目录地址
            "DEEP"   : "/", //PATHINFO分割符
            "MODEL"  : ["3", "", "html"],
            "VAR"    : ["m", "c", "a"]
        }
    })();
    </script>
<link href="/Public/Admin/css/datetimepicker.css" rel="stylesheet" type="text/css">
<link href="/Public/Admin/css/datetimepicker_blue.css" rel="stylesheet" type="text/css"><link href="/Public/Admin/css/dropdown.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
</script>