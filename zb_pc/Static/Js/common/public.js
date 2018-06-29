/**
 * Created by wuhan on 2018/3/13.
 */

$(function(){

    $("body").prepend('<div class="header" id="header"></div>');
    $("body").append('<div class="footer cf" id="footer"></div>');

    //引入头文件和底文件
    ajaxHtml("header","../../View/share/header.html");
    ajaxHtml("footer","../../View/share/footer.html");

    console.log($("body").width());
    console.log($(window).width());
    // 导航栏切换
    $(document).on("click",'.tabTopWrap li',function(){
        $(this).addClass('active');
        $(this).siblings("li").removeClass('active');
    });

    //侧边固定栏的出现隐藏
    $(window).scroll(function(){
        var fixHtml = '<div class="fixBox">' +
            '<div class="btnCodeBox subFixBox"><i class="code fixIcon"></i><div class="scanCode hide"><i class="scanBg"></i><p class="scanIn">扫描关注手上科技</p></div></div>' +
            '<div class="btnReturnTop subFixBox"><i class="returnTop fixIcon"></i></div>' +
            '</div>';

        if ($(document).scrollTop() > 200){
            $("body").append(fixHtml);
        }else{
            $(".fixBox").remove();
        }
    });

    //移入移除二维码
    $(document).on("hover",'.btnCodeBox',function(){
        $(".scanCode").removeClass('hide');
    });
    $(document).on("mouseleave",'.btnCodeBox',function(){
        $(".scanCode").addClass('hide');
    });

    //点击返回顶部
    $(document).on("click",'.btnReturnTop',function(){
        $("html,body").animate({scrollTop:0}, 500);
    });

    //用于copy
    $('.copy').each(function(i, item) {
        //定义该值是为了省略后面程序的的字符数，并且取copy的第一个
        var that = $('.copy').eq(0);
        //获得当前copy标签的data-num的值，即要复制的次数
        var num = that.attr("data-num");
        //获得包括当前节点的html代码
        var obj = that.clone().prop("outerHTML");
        //将获得到的html代码中的copy字符串去除，以免js出现死循环或错误循环，并存为变量
        var newObj = obj.replace('copy', '');

        for (i = 1; i < num; i++) {
            //在当前节点后插入html代码
            that.after(newObj);
        }
        //移除当前节点的copy的class,避免对页面第二个copy标签的复制影响
        that.removeClass('copy');
    });

    //滚动导航时让导航定位
    $(document).scroll(function () {

        //滚动时获取高度
        var h = $(this).scrollTop();

        //获取头部的高度
        var topHead = $("#topHead").height();
        if (h > topHead) {
            //让导航部定位
            $("#navHeight").addClass("fixed");
            $("#topHead").addClass("topHeadMargin")
        } else {
            $("#navHeight").removeClass("fixed");
            $("#topHead").removeClass("topHeadMargin");
        }
    });

});

//引入公共模块
function ajaxHtml(element,url) {
    if (element != "" && url != '') {
        $.ajax({
            url : url,
            type : 'GET',
            cache: false,
            success : function(data) {
                $('#'+element).html(data);
            }
        });
    }
}

//导航栏增加选中状态
function addBarActive(index){
    $(".tabTopWrap li").eq(index).find(".eachTabLink").addClass('active');
    $(".tabTopWrap li").eq(index).siblings("li").find(".eachTabLink").removeClass('active');
}

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

//input框失去焦点
function inputBlur(obj,callback){
    $(document).on("blur",obj,function(){
        callback($(obj));
    });
}

//显示错误信息
function addErrorMsg($obj,errorMsg){
    if($obj.parent().hasClass('common')){
        var parent = $obj.parent(".common");
        parent.find(".correct").remove();
        parent.find(".remarks").hide();
        parent.find(".error").show().text(errorMsg);
    }
}

//验证正确显示正确
function showCorrect($obj){
    if($obj.parent().hasClass('common')){
        var parent = $obj.parent(".common");
            parent.find(".remarks").hide();
        if(!parent.find("span").hasClass("correct")){
            parent.append('<span class="correct"></span>');
        }
            parent.find(".error").hide().text("");
    }
}

//验证注册账号
function verifyAccount($obj){
    var account = $.trim($obj.val());
    var accountReg = /^[a-zA-Z]+[0-9a-zA-Z_]{5,14}$/;
    if(!account){
        errorMsg = "请填写您的账号";
        addErrorMsg($obj,errorMsg);
        return false;
    }else if(!accountReg.test(account)){
        errorMsg = "请填写正确的账号";
        addErrorMsg($obj,errorMsg);
        return false;
    }else {
        showCorrect($obj);
        return true;
    }
}

//验证注册密码
function verifyPwd($obj){
    var pwd = $.trim($obj.val());
    var pwdReg = /^(?![0-9]+$)[0-9A-Za-z]{6,15}$/;
    if(!pwd){
        errorMsg = "请填写您的密码";
        addErrorMsg($obj,errorMsg);
        return false;
    }else if(!pwdReg.test(pwd)){
        errorMsg = "请填写正确的密码";
        addErrorMsg($obj,errorMsg);
        return false;
    }else{
        showCorrect($obj);
        return true;
    }
}

//验证确认密码
function verifyConfirmPwd($objPwd,$objcConfirmPwd){
    var confirmPwd = $.trim($objcConfirmPwd.val());
    var pwd = $.trim($objPwd.val());
    if(!confirmPwd){
        errorMsg = "请填写您的确认密码";
        addErrorMsg($objcConfirmPwd,errorMsg);
        return false;
    }else if(confirmPwd !== pwd){
        errorMsg = "请填写正确的确认密码";
        addErrorMsg($objcConfirmPwd,errorMsg);
        return false;
    }else{
        showCorrect($objcConfirmPwd);
        return true;
    }
}

//验证图形验证码
function verifyImgCode($obj){
    var imgCode = $.trim($obj.val());
    if(!imgCode){
        errorMsg = "请填写图形验证码";
        addErrorMsg($obj,errorMsg);
        return false;
    }else if(imgCode.length != 4){
        errorMsg = "请填写正确的图形验证码";
        addErrorMsg($obj,errorMsg);
        return false;
    }else{
        showCorrect($obj);
        return true;
    }
}

//验证短信验证码
function verifyCode($obj){
    var code = $.trim($obj.val());
    if(!code){
        errorMsg = "请填写短信验证码";
        addErrorMsg($obj,errorMsg);
        return false;
    }else if(code.length != 6){
        errorMsg = "请填写正确的短信验证码";
        addErrorMsg($obj,errorMsg);
        return false;
    }else{
        showCorrect($obj);
        return true;
    }
}

//验证真实姓名
function verifyRealName($obj){

    var realName = $.trim($obj.val());
    var realNameReg = /^([\u4e00-\u9fa5]{1,20}|[a-zA-Z\.\s]{1,20})$/;
    if(!realName){
        errorMsg = "请填写您的真实姓名";
        addErrorMsg($obj,errorMsg);
        return false;
    }else if(!realNameReg.test(realName)){
        errorMsg = "请填写您的真实姓名";
        addErrorMsg($obj,errorMsg);
        return false;
    }else{
        showCorrect($obj);
        return true;
    }
}

//验证身份证号码
function verifyCardID($obj){

    var cardId = $.trim($obj.val());
    var cardReg = /^(\d{6})()?(\d{4})(\d{2})(\d{2})(\d{3})(\w)$/;

    if(!cardId){
        errorMsg = "请填写您的身份证号码";
        addErrorMsg($obj,errorMsg);
        return false;
    }else if(!cardReg.test(cardId)){
        errorMsg = "请填写正确的身份证号码";
        addErrorMsg($obj,errorMsg);
        return false;
    }else{
        showCorrect($obj);
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
        return true;
    }
}

//验证手机号
function verifyPhone($obj){

    var phone = $.trim($obj.val());
    var phoneReg = /^(13|14|15|17|18)[0-9]{9}$/;

    if(!phone){
        errorMsg = "请填写您的手机号码";
        addErrorMsg($obj,errorMsg);
        return false;
    }else if(!phoneReg.test(phone)){
        errorMsg = "请填写正确的手机号码";
        addErrorMsg($obj,errorMsg);
        return false;
    }else{
        showCorrect($obj);
        return true;
    }
}

//验证邮箱是否正确
function verifyEmail($obj){
    var email = $.trim($obj.val());
    var emailReg = /^[a-zA-Z0-9_-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/;

    if(!email){
        errorMsg ="请填写邮箱账号";
        addErrorMsg($obj,errorMsg);
        return false;
    }else if(!emailReg.test(email)){
        errorMsg = "请填写正确的邮箱";
        addErrorMsg($obj,errorMsg);
        return false;
    }else{
        showCorrect($obj);
        return true;
    }
}

//验证如果有邮箱是否正确
function verifyHasEmail($obj){
    var email = $.trim($obj.val());
    var emailReg = /^[a-zA-Z0-9_-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/;

    if(email && !emailReg.test(email)){
        errorMsg = "请填写正确的邮箱";
        addErrorMsg($obj,errorMsg);
        return false;
    }else{
        showCorrect($obj);
        return true;
    }
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




