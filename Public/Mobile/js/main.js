/**
 * Created by wuhan on 2018/3/7.
 */

$(function(){

    //tab切换
    $(".bar-tab").on("click",'.tab-item',function(){
        $(this).addClass('active').siblings(".tab-item").removeClass('active');
    });

    //$(document).on("click",'input',function(){
    //    var target = this;
    //    setTimeout(function(){
    //        target.scrollIntoView(true);
    //    },100);
    //});

    //隐藏加载中...
    $('#loader').fadeOut();

});

//发送请求
function sendReq(url,param,tip,callback){
    $.ajax({
        type:'post',
        dataType:'json',
        data:param,
        async:false,
        url:url,
        success:function(result) {
            callback && callback(result);
        },
        error:function() {}
    });
}

//验证注册账号
function verifyAccount(account){
    var account = account;
    var accountReg = /^[a-zA-Z]+[0-9a-zA-Z_]{5,14}$/;
    if(!account){
        errorMsg = "请填写您的账号";
        return false;
    }
    else if(!accountReg.test(account)){
        errorMsg = "请填写正确的账号";
        return false;
    }
    else {
        errorMsg = "";
        return true;
    }
}

//验证注册密码
function verifyPwd(pwd){
    var pwd = pwd;
    var pwdReg = /^(?![0-9]+$)[0-9A-Za-z]{6,15}$/;
    if(!pwd){
        errorMsg = "请填写您的密码";
        return false;
    }else if(!pwdReg.test(pwd)){
        errorMsg = "请填写正确的密码";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}

//验证确认密码
function verifyConfirmPwd(pwd,confirmPwd){
    var confirmPwd = confirmPwd;
    var pwd = pwd;
    if(!confirmPwd){
        errorMsg = "请填写您的确认密码";
        return false;
    }else if(confirmPwd !== pwd){
        errorMsg = "请填写正确的确认密码";
        return false;
    }else{
        return true;
    }
}

//验证真实姓名
function verifyRealName(realName){

    var realName = realName;
    var realNameReg = /^([\u4e00-\u9fa5]{1,20}|[a-zA-Z\.\s]{1,20})$/;
    if(!realName){
        errorMsg = "请填写您的真实姓名";
        return false;
    }else if(!realNameReg.test(realName)){
        errorMsg = "请填写您的真实姓名";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}

//验证身份证号码
function verifyCardID(cardId){

    var cardId = cardId;
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

//验证是否同意协议
function verifyIsAgree(agree){
    var isAgree = agree;
    if(!isAgree){
        errorMsg = "请同意我们的协议";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}

//验证手机号
function verifyPhone(phone){

    var phone = phone;
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

//验证邮箱是否正确
function verifyEmail(email){
    var email = email;
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

//验证图片路径
function verifyImgSrc(imgSrc){
    var imgSrc = imgSrc;
    if(!imgSrc){
        errorMsg = "请选择您的头像";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}

//验证昵称
function verifyNickName(nickName){
    var nickName = nickName;
    if(!nickName){
        errorMsg = "请填写您的昵称";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}

//礼包领取弹窗
function alertHtml(giftNum,gameName,gameCard,giftDetail){
    var alertHtml = '<div class="giftSuccessBoxWrap cf">' +
        '<div class="giftSuccess fl cf">' +
        '<p class="successTit fl">'+giftNum+'</p>' +
        '<p class="successContent fl">'+gameName+'</p>' +
        '</div>' +
        '<div class="giftBox fl cf">' +
        '<p class="giftBoxName fl">'+gameCard+'</p>' +
        '<p class="giftBoxContent fl">'+giftDetail+'</p>' +
        '</div>' +
        '</div>';

    $.alert(alertHtml, function(){});
}

//倒计时
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


