/**
 * Created by wuhan on 2018/3/7.
 */
$(function () {
    //轮播图
    $(".swiper-container").swiper({
        speed: 3000,
        autoplay: true,
        pagination: '.swiper-pagination',
        loop: true,
        autoplayDisableOnInteraction: false//用户操作后，禁止停止autoplay
    });

    $(document).on("click",'.btn-game',function(){
        $.alert("游戏下载暂未开通", function(){})
    });

    $("#userinfo").on('click',function(){
        alert('请先登录');
        return false;
    })

    
});


