/**
 * Created by ZB on 2018/3/13.
 */

var errorMsg = "";
$(function(){

    //tab切换
    $(".registerTitle ul li").click(function(){
        var index = $(this).index();
        $(this).addClass("on").siblings().removeClass("on");
        $(".tap .tapBox").eq(index).show().siblings().hide();
    });

    //勾选同意协议
    $(".selected").on("click",function(){
        var verify = $(this).parents(".agreement").hasClass('active');
        if(!verify){
            $(this).parents(".agreement").addClass('active');
        }else{
            $(this).parents(".agreement").removeClass('active');
        }
    });

    //用户名 失去焦点的验证
    inputBlur('#userAccount',verifyAccount);
    inputBlur('#setPwd',verifyPwd);
    $(document).on("blur",'#confirmPwd',function(){
        verifyConfirmPwd($("#setPwd"),$("#confirmPwd"));
    });
    inputBlur('#imgCode',verifyImgCode);
    inputBlur('#mailbox',verifyHasEmail);
    inputBlur('#name',verifyRealName);
    inputBlur('#numberID',verifyCardID);

    //手机号 失去焦点的验证
    inputBlur('#phone',verifyPhone);
    inputBlur('#code',verifyCode);
    inputBlur('#setPassW',verifyPwd);
    inputBlur('#commonMailbox',verifyHasEmail);
    inputBlur('#realName',verifyRealName);
    inputBlur('#number',verifyCardID);

    //点击发送短信验证码
    $(document).on("click",'#sendCode',function(){
        var verifyVal = verifyPhone($("#phone"));
        if(!verifyVal){
            return false;
        }

        //sendReq();
    });

    //点击注册
    $(document).on("click",'#btnReg',function(){

        var regStatus = $(".regTab.on").index() == 0 ? 1 :2;
        var verifyVal = true;
        if(regStatus == 1){

            verifyVal = verifyAccount($("#userAccount"));
            verifyVal = verifyPwd($("#setPwd")) && verifyVal;
            verifyVal = verifyConfirmPwd($("#setPwd"), $("#confirmPwd")) && verifyVal;
            verifyVal = verifyImgCode($("#imgCode")) && verifyVal;
            verifyVal = verifyHasEmail($("#mailbox")) && verifyVal;
            verifyVal = verifyRealName($("#name")) && verifyVal;
            verifyVal = verifyCardID($("#numberID")) && verifyVal;
            verifyVal = verifyIsAgree($(".agreement").hasClass('active')) && verifyVal;

        }else if(regStatus == 2){

            verifyVal = verifyPhone($("#phone"));
            verifyVal = verifyCode($("#code")) && verifyVal;
            verifyVal = verifyPwd($("#setPassW")) && verifyVal;
            verifyVal = verifyHasEmail($("#commonMailbox")) && verifyVal;
            verifyVal = verifyRealName($("#realName")) && verifyVal;
            verifyVal = verifyCardID($("#number")) && verifyVal;
            verifyVal = verifyIsAgree($(".agreement").hasClass('active')) && verifyVal;

        }

        if(!verifyVal){
            return false;
        }

        //sendReq();

    });


});

