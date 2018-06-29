<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script type="text/javascript" src="/moguplay/Public/Api/js/jquery.js"></script>
</head>
<body>
    <div style="width:164px;text-align: center;"><img src="/moguplay/Public/<?php echo ($pic); ?>"  /><p>请扫码支付</p></div>

   <script>
   window.setTimeout(function () {
       IpsCodePay();
   },1500);
   var IpsCodePay = function () {
       $.post("/moguplay/index.php?s=/Paytest/Ips/IpsCodePay",{},function (msg) {
          console.log("1");
       },"json");
   }

   </script>
</body>
</html>