/**
 * Created by wuhan on 2018/3/7.
 */
$(function () {
    //轮播图
    $(".swiper-container").swiper({
        speed: 1000,
        autoplay: true,
        pagination: '.swiper-pagination',
        loop: true,
        autoplayDisableOnInteraction: false//用户操作后，禁止停止autoplay
    });

});


