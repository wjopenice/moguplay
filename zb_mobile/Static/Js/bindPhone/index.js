/**
 * Created by ZB on 2018/3/9.
 */
var errorMsg = "";//错误信息
var wait = 60;

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
            //$.ajax  成功
            time(This);
        }
    });

    //点击绑定
    $(document).on("click",'#btn-bind',function(){

        var bindStatus = $(".buttons-tab .active").index();
        var verifyVal = true;
        if(bindStatus == 0){
            verifyVal = verifyPhone($.trim($("#phone").val()));
            verifyVal = verifyPwd($.trim($("#phonePwd").val())) && verifyVal;
            verifyVal = verifyCode() && verifyVal;
        }
        else if(bindStatus == 1){
            verifyVal = verifyEmail($.trim($("#email").val()));
            verifyVal = verifyPwd($.trim($("#bindMailPwd").val())) && verifyVal;
            verifyVal = ConfirmPwd($.trim($("#bindMailPwd").val()), $.trim($("#bindMailConfirmPwd").val())) && verifyVal;

            console.log(verifyEmail());
            console.log(verifyPwd($.trim($("#bindMailPwd").val())));
            console.log(ConfirmPwd($.trim($("#bindMailPwd").val()), $.trim($("#bindMailConfirmPwd").val())));

        }
        if(!verifyVal){
            $.toast(errorMsg);
            return false;
        }
    });
    
});

//验证短信验证码
function verifyCode(){
    var phoneCode = $.trim($("#input-code").val());
    //ajax 验证短信验证码  code
    var code = "123456";
    if(phoneCode !== code){
        errorMsg = "请填写正确的短信验证码";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}



