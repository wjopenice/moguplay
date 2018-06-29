/**
 * Created by wuhan on 2018/3/19.
 */
$(function(){

    $(".slide-box").hbySlide();

    $(document).on("click",'.eachGameTab',function(){
        var index = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $(".gameDetailBox").eq(index).show();
        $(".gameDetailBox").eq(index).siblings().hide();
    });

    //热门游戏鼠标移入移除
    $(document).on("hover",'.subActiveRankLi',function(){
        $(this).find(".subRankName").hide();
        $(this).find(".rankInfo").show();
    });
    $(document).on("mouseleave",'.subActiveRankLi',function(){
        $(this).find(".subRankName").show();
        $(this).find(".rankInfo").hide();
    });



});