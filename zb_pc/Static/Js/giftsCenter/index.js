/**
 * Created by ZB on 2018/3/19.
 */
$(function(){

    // 最新推荐鼠标移入移除
    $(document).on("hover",'.activeImg',function(){
        $(this).find(".activeDescriptionBox").show();
    });
    $(document).on("mouseleave",'.activeImg',function(){
        $(this).find(".activeDescriptionBox").hide();
    });

    //全部礼包切换
    $(".linkList a").click(function(){
        var now = $(this).index();
        $(".linkList a").eq(now).addClass('active').siblings().removeClass('active');
        $(".giftsContent ul").eq(now).addClass('cur').siblings().removeClass('cur');
    });

});
