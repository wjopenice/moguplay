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
    verifyVal = verifyPwd() && verifyVal;

    /*if(!verifyVal){
        $.toast(errorMsg);
        return false;
    }*/

    var account = $.trim($("#account input").val());
    var pwd = $.trim($("#pwd input").val());
    var url = $.trim($("#url").val());

    console.log(url);
    /*sendReq(url,{account:account,password:pwd},'',function(data){
        console.log(data);return;
        //成功
        //window.location.href = "/";
    });*/

    $.ajax({
        type: 'POST',
        async: true,
        dataType: 'json',
        url: url,//提交给后台的地址
        data: {account:account,password:pwd},
        beforeSend: function () {
            $('#btnLogin').val('登录中').attr('disabled', true);
        },
        success: function (data) {
            //console.log(data);return;
            switch (parseInt(data['status'])) {
                case 0:
                    $.toast(data['msg']);
                    $('#btnLogin').val('登录').attr('disabled', false);
                    break;
                case 1:
                    setTimeout(function (){
                        var reurl = data['reurl'];//跳转的地址
                        if (reurl) {
                            location.href = reurl;//跳转的地址
                        } else {
                            location.reload();
                        }
                    }, 1000); break;
                case -999:
                    showcode();
                    $.toast(data['msg']);
                    $('#btnLogin').val('登录').attr('disabled', false);
                    $('.checkcode').click();
                    break;
                default:
                    $('#btnLogin').val('登录').attr('disabled', false);
                    break;
            }
            return false;
        },
        error: function () {
            $.toast('服务器故障，稍后再试');
            $('#btnLogin').val('登录').attr('disabled', false);
        },
        cache: false
    });


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

//验证密码
function verifyPwd(){

    var pwd = $.trim($("#pwd input").val());
    var pwdReg = /^(?![0-9]+$)[0-9A-Za-z]{6,15}$/;

    if(!pwd){
        errorMsg = "请填写您的密码";
        return false;
    }
    else if(!pwdReg.test(pwd)){
        errorMsg = "请填写正确的密码";
        return false;
    }
    else{
        return true;
    }

}