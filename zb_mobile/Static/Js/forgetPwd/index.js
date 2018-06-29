/**
 * Created by wuhan on 2018/3/8.
 */

var errorMsg = "";//错误信息
$(function(){

    //tab切换
    $(".tabBox").on("click",'.eachTab',function(){
        var index = $(this).index();
        $(this).addClass('active').siblings(".eachTab").removeClass('active');
        $(".formBox .formWrapBox").eq(index).show();
        $(".formBox .formWrapBox").eq(index).siblings(".formWrapBox").hide();
    });

    //点击获取验证码
    $(document).on("click",'#btn-code',function(){
        var This = this;
        var verify = verifyPhone();
        if(!verify){
            $.toast("请填写正确的手机号");
            return false;
        }else{
            var phone = $.trim($("#phone .formInput").val());//手机号
            //$.ajax  成功
            time(This);
        }
    });

    //点击确定
    $("#btnConfirm").on("click",function(){

        var verifyVal = verifyPhone($.trim($("#phone .formInput").val()));
        verifyVal = verifyPhoneCode() && verifyPwd();
        verifyVal = verifyPwd($.trim($("#pwd .formInput").val())) && verifyVal;

        if(!verifyVal){
            $.toast(errorMsg);
            return false;
        }

    });

});


//验证短信验证码
function verifyPhoneCode(){
    var phoneCode = $.trim($("#phoneCode .formInput").val());
    //ajax 验证短信验证码  code
    var code = "123456";
    if(phoneCode!==code){
        errorMsg = "请填写正确的短信验证码";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}

// 倒计时
var wait = 60;










