/**
 * Created by wuhan on 2018/3/8.
 */
$(function(){


    var errorMsg = "";//错误信息

    //tab切换
    $(".tabBox").on("click",'.eachTab',function(){
        var index = $(this).index();
        $(this).addClass('active').siblings(".eachTab").removeClass('active');
        $(".formBox .formWrapBox").eq(index).show();
        $(".formBox .formWrapBox").eq(index).siblings(".formWrapBox").hide();
    });

    //勾选同意协议
    $(".ChoseClick").on("click",function(){

        var verify = $(this).parents(".agreementBox").hasClass('active');
        if(!verify){
            $(this).parents(".agreementBox").addClass('active');
        }else{
            $(this).parents(".agreementBox").removeClass('active');
        }

    });

    //点击获取验证码
    $(document).on("click",'#btn-code',function(){
        var This = this;
        var verify = verifyPhone();
        if(!verify){
            $.toast(errorMsg);
            return false;
        }else{
            var phone = $.trim($("#phone .formInput").val());//手机号
            //$.ajax  成功
            time(This);
        }
    });

    //点击注册
    $("#btnReg").on("click",function(){
        var status = $(".tabBox .eachTab").eq(0).hasClass('active') ? 1 : 2;
        var verifyVal = false;
        if(status == 1){
            verifyVal = verifyAccount($.trim($("#account .formInput").val()));
            verifyVal = verifyPwd($.trim($("#pwd .formInput").val())) && verifyVal;
            verifyVal = verifyRealName($.trim($("#realName .formInput").val())) && verifyVal;
            verifyVal = verifyCardID($.trim($("#cardId .formInput").val())) && verifyVal;
            verifyVal = verifyIsAgree($(".agreementBox").hasClass('active')) && verifyVal;
        }
        else if(status == 2){
            verifyVal = verifyPhone($.trim($("#phone .formInput").val()));
            verifyVal = verifyPwd($.trim($("#phonePwd .formInput").val())) && verifyVal;
            verifyVal = verifyRealName( $.trim($("#phoneRealName .formInput").val())) && verifyVal;
            verifyVal = verifyPhoneCode() && verifyVal;
            verifyVal = verifyIsAgree($(".agreementBox").hasClass('active')) && verifyVal;
        }

        if(!verifyVal){
            $.toast(errorMsg);
            return false;
        }else{
            if(status == 1){
                var account = $.trim($("#account .formInput").val());
                var pwd = $.trim($("#pwd .formInput").val());
                var realName = $.trim($("#realName .formInput").val());
                var cardId = $.trim($("#cardId .formInput").val());

            //    ajax


            }else if(status == 2){

                var phone = $.trim($("#phone .formInput").val());
                var phonePwd = $.trim($("#phonePwd .formInput").val());
                var phoneRealName = $.trim($("#phoneRealName .formInput").val());
                var phoneCode = $.trim($("#phoneCode .formInput").val());

                //    ajax
            }



        }

    });

});


//验证短信验证码
function verifyPhoneCode(){
    var phoneCode = $.trim($("#phoneCode .formInput").val());
    //ajax 验证短信验证码  code
    var code = "123456";
    if(!phoneCode.equal(code)){
        errorMsg = "请填写正确的短信验证码";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}

// 倒计时
var wait = 60;
function time(o) {
    if (wait == 0) {
        o.removeAttribute("disabled");
        o.value = "获取验证码";
        wait = 60;
    } else {
        o.setAttribute("disabled", true);
        o.value = "重新发送(" + wait + ")";
        wait--;
        setTimeout(function () {
            time(o)
        }, 1000)
    }
}
