var errorMsg = "";
var wait = 60;

$(function(){

    //用户账号失焦
    $(document).on("blur",'#userAccount',function(){
        var verifyVal = verifyAccount($("#userAccount"));
        //verifyVal = isExistAccount() && verifyVal;

        if(!verifyVal){

            $("#correctAccount").text(errorMsg);
            $("#correctAccount").css("color","#ff3b2f");
            return false;
        }

        $("#accountRemark").html("");
        $("#accountNext").addClass('nextFinish');

    });

    //点击用户账号的下一步
    $(document).on("click",'#accountNext.nextFinish',function(){
        $(".inputInfo").hide();
        $(".backPwd").show();
        $(".forgetTwo").addClass('active');
    });

    //点击发送验证码
    $(document).on("click",'#btnSendCode',function(){

        var verifyVal = verifyPhone($("#userPwd"));
        if(!verifyVal){
            $("#bindPhone").text(errorMsg);
            $("#bindPhone").css("color","#ff3b2f");
            return false;
        }

        $("#phoneRemark").html("");

        //url  参数  tip   回调
        //sendReq("",{},'',function(data){
        //
        ////    如果成功    time(this);
        //
        //});

    });

    //验证码失焦
    $(document).on("blur",'#verificationCode',function(){
        var verifyVal = verifyCode($("#verificationCode"));

        if(!verifyVal){
            $("#bindSmsCode").text(errorMsg);
            $("#bindSmsCode").css("color","#ff3b2f");
            return false;
        }

        $("#codeRemark").html("");

        //验证验证码是否正确
        //sendReq("",{},'',function(data){
        //
        //    //    如果正确   $("#smsNext").addClass('nextFinish');
        //
        //});

        $("#smsNext").addClass('nextFinish');
    });

    //点击找回方式的下一步
    $(document).on("click",'#smsNext.nextFinish',function(){
        $(".inputInfo").hide();
        $(".backPwd").hide();
        $(".resetPwd").show();
        $(".forgetThree").addClass('active');
    });

    //重置密码失焦
    $(document).on("blur",'#resetPwd',function(){
        var verifyVal = verifyPwd($("#resetPwd"));
        //verifyVal = isSameLastPwd() && verifyVal;
        if(!verifyVal){
            $("#bindPwd").text(errorMsg);
            $("#bindPwd").css("color","#ff3b2f");
            return false;
        }
        $("#pwdRemark").html("");

    });

    //确认密码失焦
    $(document).on("blur",'#confirmPwd',function(){
        var verifyVal = verifyConfirmPwd($("#resetPwd"),$("#confirmPwd"));
        if(!verifyVal){
            $("#bindConfirmPwd").text(errorMsg);
            $("#bindConfirmPwd").css("color","#ff3b2f");
            return false;
        }

        $("#confirmPwdRemark").html("");
        $("#pwdNext").addClass('nextFinish');
    });

    //点击重置密码的下一步
    $(document).on("click",'#pwdNext',function(){
        $(".inputInfo").hide();
        $(".backPwd").hide();
        $(".resetPwd").hide();
        $(".complete").show();
        $(".forgetFour").addClass('active');
    });

});

//验证账号是否存在
function isExistAccount(){

    var account = $.trim($("#userAccount").val());

    //url  参数  tip   回调
    sendReq("",{},'',function(data){

        //    如果不存在   return false;
        //    如果存在     return true;

    });
}

//验证重置密码是否和之前的密码相同
function isSameLastPwd(){
    var pwd = $.trim($("#resetPwd").val());

    //sendReq("",{},'',function(){});
}



