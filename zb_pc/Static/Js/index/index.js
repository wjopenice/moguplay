/**
 * Created by wuhan on 2018/3/13.
 */

$(function(){

    //banner
    $(".slide-box").hbySlide();

    //全部游戏切换
    $(document).on("click",'.subLinkGame',function(){
        $(this).addClass('active').siblings().removeClass("active");
    });

    // 推荐游戏鼠标移入移除
    $(document).on("hover",'.subRecommend',function(){
        $(this).find(".scanRecommendBox").show();
    });
    $(document).on("mouseleave",'.subRecommend',function(){
        $(this).find(".scanRecommendBox").hide();
    });

    //游戏排行鼠标移入移除
    $(document).on("hover",'.subActiveRankLi',function(){
        $(this).find(".subRankName").hide();
        $(this).find(".rankInfo").show();
    });
    $(document).on("mouseleave",'.subActiveRankLi',function(){
        $(this).find(".subRankName").show();
        $(this).find(".rankInfo").hide();
    });

    //点击忘记密码
    $(document).on("click",'.isChose',function(){
        if($(this).hasClass('active')){
            $(this).removeClass('active');
        }else{
            $(this).addClass('active');
        }
    });

    addBarActive(0);

});
