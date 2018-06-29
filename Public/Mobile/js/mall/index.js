/**
 * Created by wuhan on 2018/3/20.
 */
$(function(){
    //轮播图
    $(".swiper-container").swiper({
        speed: 5000,
        autoplay: true,
        pagination: '.swiper-pagination',
        loop: false,
        autoplayDisableOnInteraction: false//用户操作后，禁止停止autoplay
    });

    $(document).on("click",'.btn-game',function(){
        $.alert("游戏下载暂未开通", function(){})
    });

    $("#userinfo").on('click',function(){
        alert('请先登录');
        return false;
    });

    // 点击tab切换
    $(document).on("click",'.mallTab .subTab',function(){

        var index = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $(".mallTabContentBox .subMallContent").eq(index).show();
        $(".mallTabContentBox .subMallContent").eq(index).siblings().hide();
    });


});