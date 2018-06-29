/**
 * Created by wuhan on 2018/3/8.
 */
$(function(){

    var errorMsg = "";

    //点击登录
    $("#btnLogin").on("click",function(){
        login();
    });

});

//点击登录
function login(){

    var verifyVal = verifyAccount();
    verifyVal = verifyPwd($.trim($("#pwd input").val())) && verifyVal;

    if(!verifyVal){
        $.toast(errorMsg);
        return false;
    }

    var account = $.trim($("#account input").val());
    var pwd = $.trim($("#pwd input").val());

}

//验证账号
function verifyAccount(){
    var account = $.trim($("#account input").val());
    var accountReg = /^[a-zA-Z]+[0-9a-zA-Z_]{5,14}$/;
    var phoneReg = /^(13|14|15|17|18)[0-9]{9}$/;
    if(!account){
        errorMsg = "请输入您的账号";
        return false;
    }else if(!accountReg.test(account)&&!phoneReg.test(account)){
        errorMsg = "请填写正确的账号";
        return false;
    }
    else{
        errorMsg = "";
        return true;
    }
}
