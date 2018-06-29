/**
 * Created by wuhan on 2018/3/8.
 */
$(function(){


    var errorMsg = "";//错误信息
    var MODULE = $("#url").val();//url
    $("#btn-code").attr("readonly",true);

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
            sendReq( MODULE+'Member/telsvcode',{phone:phone},'',function(data){
                $.toast(data.msg);
                if(data.status == 1){
                    time(This);
                }
            });
        }
    });

    //点击注册
    $("#btnReg").on("click",function(){
        var status = $(".tabBox .eachTab").eq(0).hasClass('active') ? 1 : 2;
        var verifyVal = false;
        if(status == 1){
            verifyVal = verifyAccount();
            verifyVal ? verifyVal = verifyPwd($.trim($("#pwd .formInput").val())) : verifyVal;
            verifyVal ? verifyVal = verifyRealName($.trim($("#realName .formInput").val())) : verifyVal;
            verifyVal ? verifyVal = verifyCardID() : verifyVal;
            verifyVal ? verifyVal = verifyIsAgree() : verifyVal;
        }
        else if(status == 2){
            verifyVal = verifyPhone();
            verifyVal ? verifyVal = verifyPwd($.trim($("#phonePwd .formInput").val())) : verifyVal;
            verifyVal ? verifyVal = verifyRealName($.trim($("#phoneRealName .formInput").val())) : verifyVal;
            //verifyVal ? verifyVal = verifyPhoneCode() : verifyVal;
            verifyVal ? verifyVal = verifyIsAgree() : verifyVal;
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

                // 新修改的ajax
                sendReq(MODULE+'/Member/user_register',{account:account,password:pwd,repass:pwd,truename:realName,card:cardId},'',function(data){
                    if (parseInt(data.status) == 1 ) {
                        setTimeout(function() {
                            $.ajax({
                                type: 'POST',
                                async: true,
                                dataType: 'json',
                                url: MODULE+'/Member/login.html',
                                beforeSend:function(){
                                    $("#btnReg").val('正在登陆').attr("disabled",true);
                                },
                                data: {account:account,password:pwd},
                                success: function(data) {
                                    if (parseInt(data.status) == 1 ) {
                                        window.location.href=MODULE+'/Member/personalcenter.html';
                                    }
                                },
                                error: function() {
                                    location.reload();
                                },
                                cache: false
                            });

                        },1000);
                    } else {
                        $.toast(data.msg);
                        $("#btnReg").val('完成注册').attr("disabled",false);
                    }
                });

            }else if(status == 2){

                var phone = $.trim($("#phone .formInput").val());
                var phonePwd = $.trim($("#phonePwd .formInput").val());
                var phoneRealName = $.trim($("#phoneRealName .formInput").val());
                var phoneCode = $.trim($("#phoneCode .formInput").val());

                $.ajax({
                    type: 'POST',
                    async: true,
                    dataType: 'json',
                    data:{account:phone,password:phonePwd,vcode:phoneCode,truename:phoneRealName},
                    url:MODULE+'Member/telregister',
                    beforeSend: function() {
                        $('#btnReg').val('注册中').attr("disabled",true);
                    },
                    success: function(data) {
                        if (parseInt(data.status) == 1 ) {
                            setTimeout(function() {                           
                                $.ajax({
                                    type: 'POST',
                                    async: true,
                                    dataType: 'json',
                                    url:MODULE+'Member/login.html',
                                    data: {account:phone,password:phonePwd},
                                    beforeSend:function(){
                                        $("#btnReg").val('正在登陆').attr("disabled",true);
                                    },
                                    success: function(data) {
                                      if (parseInt(data.status) == 1 ) {
                                          window.location.href=MODULE+'/Member/personalcenter.html';
                                      }
                                    },
                                    error: function() { 
                                        location.reload();                    
                                    },
                                    cache: false
                                }); 
                            },1000);
                        } else {
                            $.toast(data.msg);
                            $("#btnReg").val('完成注册').attr("disabled",false);
                        }                  
                    },
                    error: function() {
                        $.toast('服务器故障，稍后再试');
                        $("#btnReg").val('完成注册').attr("disabled",false);
                    },
                }); 
            }

        }

    });

    //验证注册账号
    function verifyAccount(){
        var verifyIsRegVal = true;
        var account = $.trim($("#account .formInput").val());
        var accountReg = /^[a-zA-Z]+[0-9a-zA-Z_]{5,14}$/;
        if(!account){
            errorMsg = "请填写您的账号";
            verifyIsRegVal = false;
            return false;
        }
        else if(!accountReg.test(account)){
            errorMsg = "请填写正确的注册账号";
            verifyIsRegVal = false;
            return false;
        }
        else{
            sendReq(MODULE+'Member/checkUser',{username:account},'',function(data){
                if (parseInt(data.status) != 1 ) {
                    errorMsg = "该帐号已被注册";
                    verifyIsRegVal = false;
                    return false;
                }
            });
        }
        return verifyIsRegVal;
    }

    //验证注册密码
    function verifyPwd(pwd){
        //var pwd = $.trim($("#pwd .formInput").val());
        var pwd = pwd;
        var pwdReg = /^(?![0-9]+$)[0-9A-Za-z]{6,15}$/;
        if(!pwd){
            errorMsg = "请填写您的注册密码";
            return false;
        }else if(!pwdReg.test(pwd)){
            errorMsg = "请填写正确的密码";
            return false;
        }else{
            errorMsg = "";
            return true;
        }
    }


    //验证真实姓名
    function verifyRealName(realName){

        //var realName = $.trim($("#realName .formInput").val());
        var realNameReg = /^([\u4e00-\u9fa5]{1,20}|[a-zA-Z\.\s]{1,20})$/;
        if(!realName){
            errorMsg = "请填写您的真实姓名";
            return false;
        }else if(!realNameReg.test(realName)){
            errorMsg = "请正确填写您的真实姓名";
            return false;
        }else{
            errorMsg = "";
            return true;
        }
    }

    //验证身份证号码
    function verifyCardID(){

        var cardId = $.trim($("#cardId .formInput").val());
        var cardReg = /^(\d{6})()?(\d{4})(\d{2})(\d{2})(\d{3})(\w)$/;

        if(!cardId){
            errorMsg = "请填写您的身份证号码";
            return false;
        }else if(!cardReg.test(cardId)){
            errorMsg = "请填写正确的身份证号码";
            return false;
        }else{
            errorMsg = "";
            return true;
        }
    }

    //验证手机号
    function verifyPhone(){
        var verifyIsRegVal = true;
        var phone = $.trim($("#phone .formInput").val());
        var phoneReg = /^(13|14|15|17|18)[0-9]{9}$/;

        if(!phone){
            errorMsg = "请填写您的手机号码";
            verifyIsRegVal = false;
            return false;
        }else if(!phoneReg.test(phone)){
            errorMsg = "请填写正确的手机号码";
            verifyIsRegVal = false;
            return false;
        }else{
            sendReq(MODULE+'Member/checkPhone',{username:phone},'',function(data){
                if (parseInt(data.status) != 1 ) {
                    errorMsg = "该手机号已被注册";
                    verifyIsRegVal = false;
                    return false;
                }
            });
        }
        return verifyIsRegVal;
    }


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

    //验证是否同意协议
    function verifyIsAgree(){

        var isAgree = $(".agreementBox").hasClass('active');
        if(!isAgree){
            errorMsg = "请同意我们的协议";
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

});











