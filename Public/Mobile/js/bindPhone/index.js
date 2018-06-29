/**
 * Created by ZB on 2018/3/9.
 */

var errorMsg = "";//错误信息
$(function () {



    //点击获取验证码
    $(document).on("click",'#btn-code',function(){
        var This = this;
        var verify = verifyPhone();
        if(!verify){
            $.toast("请填写正确的手机号");
            return false;
        }else{
            var phone = $.trim($("#phone").val());//手机号
            var account = $.trim($("#account").val());

            sendReq(phonebangcheck,{phone:phone,in:'bindphone'},'',function(data){
                if (parseInt(data.status) == 1 ) {
                    // ajax请求成功后的逻辑处理  ,显示对号
                    sendReq(sendvcodeurl,{phone:phone,name:account},'',function(data){
                        $.toast(data.msg);
                        if (parseInt(data.status) == 1 ) {
                            time(This);
                        }
                    });
                }else{
                    $.toast(data.msg);
                    return false;
                }
            });

        }
    });


   //点击绑定
    $(document).on("click",'#btn-bind',function(){


        var bindStatus = $(".buttons-tab .active").index();
        var verifyVal = true;
        if(bindStatus == 0){
           verifyVal = verifyPhone();
           verifyVal ? verifyVal = verifyPwd($.trim($("#password").val())) : verifyVal;
           verifyVal ? verifyVal = verifyCode() : verifyVal;
        }
        else if(bindStatus == 1){
           verifyVal = verifyEmail();
           verifyVal = verifyPwd($.trim($("#bindMailPwd").val())) && verifyVal;
           //verifyVal ? verifyVal = ConfirmPwd($.trim($("#bindMailPwd").val()), $.trim($("#bindMailConfirmPwd").val())) : verifyVal;
        }

        if(!verifyVal){
           $.toast(errorMsg);
           return false;
        }else{
        
           if(bindStatus == 0){
               var phone=$.trim($('#phone').val());
               var scode=$.trim($('#input-code').val());

               sendReq(phoneurl,{in:'bindphone',vcode:scode,phone:phone},'',function(data){
                   if (parseInt(data.status) == 1 ) {
                       $.toast("绑定手机成功");

                   } else {
                       $.toast(data.msg);
                       return false;
                   }
               });
        
           }else if(bindStatus == 1){
        
               var email = $.trim($("#email").val());//手机号
               var account = $.trim($("#account").val());

               sendReq(tosendemailurl,{email:email, name:account,in:"bindemail"},'',function(data){
                   if (parseInt(data.status) == 1 ) {
                       // 发送邮箱链接
                       //        ajax请求成功后的逻辑处理
                       $.toast("验证链接已发送至邮箱，登录邮箱并按邮箱提示操作即可");
                   } else {
                       $.toast(data.msg);
                       return false;
                   }
               });
        
           }
        
        }

    });



    
});

//验证手机号
function verifyPhone(){

    var phone = $.trim($("#phone").val());
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

//验证绑定密码
function verifyPwd(pwd){
    var verifyIsRegVal = true;
    var pwd = pwd;
    var username = $.trim($("#account").val());

    if(!pwd){
        errorMsg = "请填写您的密码";
        verifyIsRegVal = false;
        return false;
    }else{
        sendReq(verifypwdurl,{iss:'mgw',in:'bindphone',name:username,password:pwd},'',function(data){
            if (parseInt(data.status) != 1 ) {
                // 失败
                errorMsg = data.msg;
                verifyIsRegVal = false;
                return false;
            }
        });
        return verifyIsRegVal;
    }

}

//验证短信验证码
function verifyCode(){
    var phoneCode = $.trim($("#input-code").val());

    if(!phoneCode){
        errorMsg = "请填写短信验证码";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}

//验证邮箱是否正确
function verifyEmail(){

    var verifyIsVal = true;
    var email = $.trim($("#email").val());
    var verifyVal = verifyEmailAccount(email);
    if(!verifyVal){
        $.toast(errorMsg);
        verifyIsVal = false;
        return false;
    }

    sendReq(emailbangcheck,{in:"bindemail",email:email},'',function(data){
        if (parseInt(data.status) != 1 ) {
            // 失败
            errorMsg = data.msg;
            $.toast(errorMsg);
            verifyIsVal = false;
            return false;
        }else{
            errorMsg = "";
            verifyIsVal = true;
            return true;
        }
    });
    return verifyIsVal;
}

function verifyEmailAccount(email){

    var emailReg = /^[a-zA-Z0-9_-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/;
    if(!email){
        errorMsg ="请填写邮箱账号";
        return false;
    }else if(!emailReg.test(email)){
        errorMsg = "请填写正确的邮箱";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}

//验证确认密码
function ConfirmPwd(pwd,confirmPwd){
    var confirmPwd = confirmPwd;
    var pwd = pwd;

    if(!confirmPwd){
        errorMsg = "请填写确认密码";
        return false;
    }else if(confirmPwd != pwd){
        errorMsg = "请填写正确的确认密码";
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
        o.value = "重试(" + wait + ")";
        wait--;
        setTimeout(function () {
            time(o)
        }, 1000)
    }
}