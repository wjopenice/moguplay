/**
 * Created by ZB on 2018/3/30.
 */
$(function(){
    // 最新推荐鼠标移入移除
    $(document).on("hover",'.infoImg',function(){
        $(this).find(".activeDescriptionBox").show();
    });
    $(document).on("mouseleave",'.infoImg',function(){
        $(this).find(".activeDescriptionBox").hide();
    });

    //全部资讯tap
    $(".allInfoTitleLi").click(function(){
        var index = $(this).index();
        $(".allInfoTitleLi").eq(index).addClass('on').siblings().removeClass('on');
        $(".allInfoNotice").eq(index).addClass('cur').siblings().removeClass('cur');
    });



});