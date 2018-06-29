var errorMsg = "";

$(function(){

    //点击记住密码
    $(document).on("click",".chose",function(){
        if($(this).hasClass('active')){
            $(this).removeClass('active');
        }else{
            $(this).addClass('active');
        }
    });

    //点击登录
    $(document).on("click",'#btnLogin',function(){
        var verifyVal = verifyAccount($("#loginAccount"));
             verifyVal = verifyPwd($("#pwd")) && verifyVal;

        console.log(errorMsg);
        if(!verifyVal){
            $(".errorMsg").show().text(errorMsg);
            return false;
        }
        else{
            $(".errorMsg").hide().text("");
            //sendReq();
        }

    });

});
