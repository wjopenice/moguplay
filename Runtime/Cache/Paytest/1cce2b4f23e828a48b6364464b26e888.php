<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>选择银行支付</title>
    <link rel="stylesheet" href="/moguplay/Public/Api/css/index.css">
    <style>
        .commonInfoReturn{width: 1200px;height:600px;line-height: 450px;margin:43px auto;font-size:20px;text-align: center;background: #FFF;}
    </style>
</head>
<body>
<!--  头部  -->
<div class="navHeight" >
    <!--  搜索栏  -->
    <div class="search cf">
        <a href="javascript:void(0)"><img src="/moguplay/Public/Api/image/logo.png" width="159" height="56" alt="" class="logo fl"></a>
    </div>
    <!--  分割线   -->
    <div class="cutRule"></div>
</div>
    <!--  付款信息内容  -->
    <div class="payInfoBoxWrap">
        <div class="payTit cf">
            <p class="payTitName fl">商品信息</p>
            <p class="payTitCon fl">订单信息来源：<span><?php echo $data['GoodsName']?></span></p>
        </div>
        <div class="goodsInfoBox">
            <table class="goodInfoTable" cellspacing = 0 cellpadding = 0>
                <thead>
                <tr>
                    <td>订单日期</td>
                    <td>订单号</td>
                    <td>商品名称</td>
                    <td>付款方</td>
                    <td>应付金额</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $data['Date']; ?></td>
                    <td><?php echo $data['MerBillNo']; ?></td>
                    <td><?php echo $data['GoodsName']; ?></td>
                    <td><?php echo $data['payerName']; ?></td>
                    <td><span><?php echo $data['Amount']; ?></span>元</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="payTit cf">
            <p class="payTitName fl">付款信息</p>
            <p class="payTitCon fl cf">
                <a class="payInfoType active" href="javascript:void(0)">个人网银</a>
                <!--<a class="payInfoType" href="javascript:void(0)">企业网银</a>-->
            </p>
        </div>
        <form name="form2" action="<?php echo $data['serverUrl'] ?>" method="post" id="form">
        <div class="payInfoBox">
            <div class="payInfoTit cf">
                <p class="fl subStep"><em>步骤1、</em>请选择银行卡种类！（例如：点击银行图标下面的企业网银）</p>
                <p class="fl subStep cf"><em class="fl">步骤2、</em><span class="fl">然后点击 </span><i class="payBtn fl"></i><span class="fl">去支付</span></p>
            </div>
            <div class="payInfoCon">

                <ul class="payInfoUl cf" id="BTC">
                    <li class="subPayBank fl cf" data-bankName="cmb">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/cmb.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf" data-bankName="icbc">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/icbc.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf" data-bankName="ccb">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/ccb.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf" data-bankName="abc">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/abc.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf" data-bankName="cmbc">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/cmbc.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="spdb">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/spdb.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="hxb">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/hxb.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="cgb">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/cgb.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="cib">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/cib.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="ceb">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/ceb.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="comm">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/comm.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="boc">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/boc.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="citic">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/citic.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="bos">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/bos.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="pingan">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/pingan.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="psbc">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/psbc.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="b1556">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/b1556.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="dalian">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/dalian.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="b1541">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/b1541.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="b1593">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/b1593.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="b1660">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/b1660.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="b1669">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/b1669.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="b1552">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/b1552.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="b1608">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/b1608.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="b1629">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/b1629.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="nb_unionpay">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/nb_unionpay.png" alt=""></div>
                    </li>

                </ul>
                <ul class="payInfoUl cf hide" id="BTB">
                    <li class="subPayBank fl cf"  data-bankName="cmb">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/cmb.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="icbc">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/icbc.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="ccb">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/ccb.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="abc">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/abc.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="cmbc">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/cmbc.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="spdb">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/spdb.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="ceb">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/ceb.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="comm">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/comm.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="boc">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/boc.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="cib">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/cib.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="pingan">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/pingan.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="psbc">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/psbc.png" alt=""></div>
                    </li>
                    <li class="subPayBank fl cf"  data-bankName="b1541">
                        <i class="fl isChoseBank"></i>
                        <div class="bankImgBox fl"><img src="/moguplay/Public/Api/image/bank/b1541.png" alt=""></div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="payMoney">
            <p class="shouldPay">应付人民币：<span class="money"><?php echo $data['Amount']; ?></span>元</p>
            <a class="bankPayBtn" href="javascript:void(0)"></a>
            <!--<input type="submit" value="提交表单，计算signMsg"/>-->
        </div>
            <input type="hidden" name="inputCharset" id="inputCharset" value="<?php echo $data['inputCharset']?>" />
            <input type="hidden" name="pickupUrl" id="pickupUrl" value="<?php echo $data['pickupUrl']?>"/>
            <input type="hidden" name="receiveUrl" id="receiveUrl" value="<?php echo $data['receiveUrl']?>" />
            <input type="hidden" name="version" id="version" value="<?php echo $data['version']?>"/>
            <input type="hidden" name="language" id="language" value="<?php echo $data['language']?>" />
            <input type="hidden" name="signType" id="signType" value="<?php echo $data['signType']?>"/>
            <input type="hidden" name="merchantId" id="merchantId" value="<?php echo $data['merchantId']?>" />
            <input type="hidden" name="payerName" id="payerName" value="<?php echo $data['payerName']?>"/>
            <input type="hidden" name="payerEmail" id="payerEmail" value="<?php echo $data['payerEmail']?>" />
            <input type="hidden" name="payerTelephone" id="payerTelephone" value="<?php echo $data['payerTelephone']?>" />
            <input type="hidden" name="payerIDCard" id="payerIDCard" value="<?php echo $data['payerIDCard']?>" />
            <input type="hidden" name="pid" id="pid" value="<?php echo $data['pid']?>"/>
            <input type="hidden" name="orderNo" id="orderNo" value="<?php echo $data['orderNo']?>" />
            <input type="hidden" name="orderAmount" id="orderAmount" value="<?php echo $data['orderAmount']*100 ?>"/>
            <input type="hidden" name="orderCurrency" id="orderCurrency" value="<?php echo $data['orderCurrency']?>" />
            <input type="hidden" name="orderDatetime" id="orderDatetime" value="<?php echo $data['orderDatetime']?>" />
            <input type="hidden" name="orderExpireDatetime" id="orderExpireDatetime" value="<?php echo $data['orderExpireDatetime']?>"/>
            <input type="hidden" name="productName" id="productName" value="<?php echo $data['productName']?>" />
            <input type="hidden" name="productPrice" id="productPrice" value="<?php echo $data['productPrice']?>" />
            <input type="hidden" name="productNum" id="productNum" value="<?php echo $data['productNum']?>"/>
            <input type="hidden" name="productId" id="productId" value="<?php echo $data['productId']?>" />
            <input type="hidden" name="productDesc" id="productDesc" value="<?php echo $data['productDesc']?>" />
            <input type="hidden" name="ext1" id="ext1" value="<?php echo $data['ext1']?>" />
            <input type="hidden" name="ext2" id="ext2" value="<?php echo $data['ext2']?>" />
            <input type="hidden" name="extTL" id="extTL" value="<?php echo $data['extTL']?>" />
            <input type="hidden" name="payType" id="payType" value="<?php echo $data['payType']?>" />
            <input type="hidden" name="pan" value="<?php echo $data['pan']?>" />
            <input type="hidden" name="tradeNature" value="<?php echo $data['tradeNature']?>" />
            <input type="hidden" name="customsExt" value="<?php echo $data['customsExt']?>" />
            <input type="hidden" name="signMsg" id="signMsg" value="<?php echo $data['signMsg']?>" />
            <input type="hidden" name="issuerId" id="issuerId" value="<?php echo $data['issuerId']?>">
        </form>
    </div>
</div>
<!--  底部版权信息   -->
<div class="copyBox">
    <div class="container cf">
        <div class="subCopy">
            <p>广州手上科技有限公司&nbsp;版权所有&nbsp;2018&nbsp;shoushangkeji.com</p>
        </div>
        <div class="subCopy">
            <p>网站备案：京ICP备17006373号</p>
        </div>
    </div>
</div>
<script src="/moguplay/Public/Api/js/jquery.js"></script>
<script src="/moguplay/Public/Api/js/index.js"></script>
<script>
    $(".subPayBank").on('click',function(){

        var hank = $(this).attr("data-bankName");
        document.getElementById("issuerId").value = hank;
    });

    $(".bankPayBtn").on('click',function(){
        var issuerId = $("#issuerId").val();
        if(!issuerId){
            alert('请选择银行');
            return false;
        }
        $.ajax({
            type:'post',
            url:"/moguplay/index.php?s=/Paytest/IpsOb/handle",
            data:$("#form").serialize(),
            dataType:'json',
            async: false,
            success:function(data){

                document.getElementById("payType").value = data.new_arr.payType;
                document.getElementById("signMsg").value = data.new_arr.signMsg;
                document.getElementById("merchantId").value = data.new_arr.merchantId;
                //console.log($("form").serialize());return false;
                $("form").submit();
            }
        })
    });

</script>
</body>
</html>