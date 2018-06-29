<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta charset="UTF-8">
    <title>绑定平台币余额|溪谷软件管理平台</title>
    <link href="http://admin.vlcms.com/Public/icon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/blue_color.css" media="all">
        <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>

</head>
    <style>
body{ padding: 0px; }
    </style>
<body>  
    <div id="main" class="main" style="min-height: 342px;">       
    <!-- 标题栏 -->
    <div class="main-title">
        <h2>[绑定平台币余额] 列表</h2>
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
                                                
                        <th style="text-align:center">用户</th>
                        <th style="text-align:center">游戏名称</th>
                        <th style="text-align:center">游戏ID</th>
                        <th style="text-align:center">绑定平台币余额</th>
                        <th style="text-align:center">操作</th>
                    </tr>
                </thead>

                <!-- 列表 -->
                <tbody>
                   <?php if(is_array($list_data)): $i = 0; $__LIST__ = $list_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                            <td style="border-right:1px solid #DDDDDD;text-align:center"><?php echo ($data["user_account"]); ?></td>
                            <td style="border-right:1px solid #DDDDDD;text-align:center"><?php echo ($data["game_name"]); ?></td>
                            <td style="border-right:1px solid #DDDDDD;text-align:center"><?php echo ($data["game_id"]); ?></td>
                            <td style="border-right:1px solid #DDDDDD;text-align:center"><?php echo ($data["bind_balance"]); ?>元</td>
                            <td style="border-right:1px solid #DDDDDD;text-align:center"><a href="javascript:void(0);" onclick="che(<?php echo ($data['user_id']); ?>,<?php echo ($data['game_id']); ?>,<?php echo ($data['bind_balance']); ?>)">修改</a></td>

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
    <script src="/Public/static/layer/layer.js" type="text/javascript"></script>
    <script src="/Public/static/layer/extend/layer.ext.js" type="text/javascript"></script>
    <script>

function che(id,game_id,prev_money) {
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
        data: {id:id,game_id:game_id,bind_balance:pass,prev_money:prev_money},
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
}

    </script>