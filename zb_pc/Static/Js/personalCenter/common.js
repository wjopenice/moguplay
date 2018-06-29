var errorMsg = "";
$(function(){

    //公共导航栏切换
    $(document).on("click",'.subPersonalBar',function(){
        $(this).addClass('active').siblings().removeClass('active');
    });

    //安全中心导航栏的切换
    $(document).on("click",'.safeUl',function(){
        var index = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $(".subLinkContent").eq(index).show();
        $(".subLinkContent").eq(index).siblings().hide();
    });

    //交易记录导航栏的切换
    $(document).on("click",'.recordUl',function(){
        var index = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $(".subRecordContent").eq(index).show();
        $(".subRecordContent").eq(index).siblings().hide();
    });

    //平台币的切换
    $(document).on("click",'.platform',function(){
        $(this).addClass('active').siblings().removeClass('active');
    });

    //账户余额导航栏的切换
    $(document).on("click",'.balanceUl',function(){
        var index = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $(".subBalanceContent").eq(index).show();
        $(".subBalanceContent").eq(index).siblings().hide();
    });

    //点击修改昵称
    $(document).on("click",'#updateNick',function(){
        $('<div id="updateNickBox pr">' +
            '<input type="text" class="updateNickAfter"><span class="errorMsg a_red" style="position: absolute;left: 40px;top:160px;"></span>' +
            '<div class="operateNickBox cf">' +
            '<a href="javascript:void(0)" class="confirm fl">确认</a>' +
            '<a href="javascript:void(0)" class="cancel fr">取消</a>' +
            '</div>' +
            '</div>').hbyPopShow({
            width:'420',
            height:'280',
            title: "修改昵称",
            isHideTitle : false
        });
    });

    //点击确认
    $(document).on("click",'.confirm',function(){
        var verifyVal = verifyNickName($(".updateNickAfter"));
        if(!verifyVal){
            $(".errorMsg").show().text(errorMsg);
            return false;
        }
        $(".errorMsg").hide().text("");
        var nickName = $.trim($(".updateNickAfter").val());
        $(".sys-pop-wrap").remove();
        $(".nickNameSpan").text(nickName);
        $(".userNickInput").val(nickName);
    });

    //点击取消
    $(document).on("click",'.cancel',function(){
        $(".sys-pop-wrap").remove();
    });

});

//验证昵称
function verifyNickName(nickName){
    var nickName = $.trim(nickName.val());
    if(!nickName){
        errorMsg = "请填写您的昵称";
        return false;
    }else{
        errorMsg = "";
        return true;
    }
}