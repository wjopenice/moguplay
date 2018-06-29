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
            var account = $.trim($("#account .formInput").val());

            sendReq(usernameverify,{account:account},'',function(data){
                if (parseInt(data.status) == 1 ) {
                    if(data.msg == phone){
                        //$.ajax  成功
                        sendReq(sendvcodeurl,{phone:phone,name:account},'',function(data){
                            $.toast(data.msg);
                            if(data.status == 1){
                                time(This);
                            }
                        });

                    }else{
                        $.toast('账号与手机号码不匹配');
                    }

                }else{
                    $.toast(data.msg);
                    return false;
                }
            });
        }
    });

    //点击确定
    $("#btnConfirm").on("click",function(){

        var verifyVal = verifyAccount() ;
        verifyVal ? verifyVal = verifyPhone() : verifyVal;
        verifyVal ? verifyVal = verifyPhoneCode() : verifyVal;
        verifyVal ? verifyVal = verifyPwd() : verifyVal;

        //console.log(verifyPhoneCode());console.log(errorMsg);
        if(!verifyVal){
            $.toast(errorMsg);
            return false;
            
        }else{
            var account = $.trim($("#account .formInput").val());
            var pwd = $.trim($("#pwd .formInput").val());

            sendReq(reseturl,{account:account,pwd: pwd,repwd: pwd},'',function(data){
                if (parseInt(data.status) == 1 ){
                    window.location.href = newurl;
                } else {
                    $.toast(data.msg);
                    return false;
                }
            });
        }



    });

});

//验证注册账号
function verifyAccount(){
    var account = $.trim($("#account .formInput").val());
    //var accountReg = /^[a-zA-Z]+[0-9a-zA-Z_]{5,14}$/;
    if(!account){
        errorMsg = "请填写您的账号";
        return false;
    }
    return true;
    
    
}

//验证手机号
function verifyPhone(){

    var phone = $.trim($("#phone .formInput").val());
    var phoneReg = /^(13|14|15|17|18)[0-9]{9}$/;

    if(!phone){
        errorMsg = "请填写您的手机号码";
        return false;
    }else if(!phoneReg.test(phone)){
        errorMsg = "请填写正确的手机号码";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}

//验证短信验证码
function verifyPhoneCode(){
    var verifyIsRegVal = true;
    var phoneCode = $.trim($("#phoneCode .formInput").val());
    var phone = $.trim($("#phone .formInput").val());
    var account = $.trim($("#account .formInput").val());
    //ajax 验证短信验证码  code
    if(!phoneCode){
        errorMsg = "请填写短信验证码";
        verifyIsRegVal = false;
        return false;
    }else{
        sendReq(verifyvcodeurl,{phone:phone,vcode:phoneCode,account:account},'',function(data){
            if (parseInt(data.status) != 1 ){
                errorMsg = data.msg;
                verifyIsRegVal = false;
                return false;
            }
        });
    }

    return verifyIsRegVal;
    
}

//验证密码
function verifyPwd(){

    var pwd = $.trim($("#pwd .formInput").val());
    var pwdReg = /^(?![0-9]+$)[0-9A-Za-z]{6,15}$/;
    if(!pwd){
        errorMsg = "请填写您的密码";
        return false;
    }else if(!pwdReg.test(pwd)){
        pwd = "请填写正确的密码";
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









