/**
 * Created by wuhan on 2018/3/8.
 */

$(function(){

    var errorMsg = "";

    //充值金额的选择
    $(".rechargeMoneyUL").on("click",".rechargeMoneyLi",function(){
        $(this).addClass('active').siblings().removeClass('active');
    });

    //选择充值方式
    $(".eachPayBox").on("click",'.choseType',function(){
        var isChoose = $(this).hasClass('active');
        if(!isChoose){
            $(this).addClass('active');
            $(this).parents(".eachPayBox").siblings(".eachPayBox").find(".choseType").removeClass('active');

            $(this).parents(".eachPayBox").hasClass('zep-wxPay')
            ? $(".payBox").attr("data-payType",'1')
            : $(".payBox").attr("data-payType",'2');

        }else{
            $(this).removeClass('active');
            $(".payBox").attr("data-payType",'0');
        }
    });

    //填写其他金额时清空充值金额
    $(document).on("keydown",'#otherMoney',function(){
        $(".rechargeMoneyLi").removeClass('active');
    });

    //点击充值金额时清空其他金额
    $(document).on("click",'.rechargeMoneyLi',function(){
        $("#otherMoney").val("");
    });

    //点击立即支付
    $(document).on("click",'#btn-pay',function(){

        var verifyVal = verifyRechargeAccount();
        verifyVal = verifyConfirmAccount() && verifyVal;
        verifyVal = verifyIsRechargeMoney() && verifyVal;
        verifyVal = verifyIsPayType() && verifyVal;

        if(!verifyVal){
            $.toast(errorMsg);
            return false;
        }
        var rechargeAccount = $.trim($("#rechargeAccount").val());//充值账号
        var rechargeMoney = $(".rechargeMoneyLi").hasClass('active')
                           ? parseInt($(".rechargeMoneyLi.active").text().replace("元,",""))
                           : $("#otherMoney").val();//充值金额
        var payType = $(".payBox").attr("data-payType");//微信支付

        //ajax




    });

});

//验证充值账号
function verifyRechargeAccount(){
    var rechargeAccount = $.trim($("#rechargeAccount").val());
    var accountReg = /^[a-zA-Z]+[0-9a-zA-Z_]{5,14}$/;
    var phoneReg = /^(13|14|15|17|18)[0-9]{9}$/;
    if(!rechargeAccount){
        errorMsg = "请填写您的充值账号";
        return false;
    }else if(!accountReg.test(rechargeAccount) && !phoneReg.test(rechargeAccount)){
        errorMsg = "请填写正确的充值账号";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}

//验证确认账号
function verifyConfirmAccount(){
    var confirmAccount = $.trim($("#confirmAccount").val());
    var rechargeAccount = $.trim($("#rechargeAccount").val());
    if(!confirmAccount){
        errorMsg = "请填写确认账号";
        return false;
    }else if(confirmAccount !== rechargeAccount){
        errorMsg = "请保证确认账号与充值账号一致";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}

//验证充值金额
function verifyIsRechargeMoney(){
    var rechargeMoney = $(".rechargeMoneyLi").hasClass('active')
        ? parseInt($(".rechargeMoneyLi.active").text().replace("元,",""))
        : $("#otherMoney").val();
    if(!rechargeMoney){
        errorMsg = "请选择或填写充值金额";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}

//验证支付方式
function verifyIsPayType(){
    var payType = $(".payBox").attr("data-payType");
    if(payType == 0){
        errorMsg = "请选择支付方式";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}


