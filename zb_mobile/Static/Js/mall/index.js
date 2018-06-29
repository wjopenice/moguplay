/**
 * Created by wuhan on 2018/3/20.
 */
$(function(){

    // 点击tab切换
    $(document).on("click",'.mallTab .subTab',function(){

        var index = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $(".mallTabContentBox .subMallContent").eq(index).show();
        $(".mallTabContentBox .subMallContent").eq(index).siblings().hide();
    });


});