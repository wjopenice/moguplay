/**
 * Created by ZB on 2018/3/16.
 */
$(function(){

    //全部游戏切换
    $(document).on("click",'.subLinkGame',function(){
        $(this).addClass('active').siblings().removeClass("active");
    });

    // 全部游戏鼠标移入移除
    $(document).on("hover",'.subRecommend',function(){
        $(this).find(".scanRecommendBox").show();
    });
    $(document).on("mouseleave",'.subRecommend',function(){
        $(this).find(".scanRecommendBox").hide();
    });

});