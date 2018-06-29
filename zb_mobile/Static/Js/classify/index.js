/**
 * Created by wuhan on 2018/3/20.
 */
$(function(){

    $(document).on("click",'.classifyLink',function(){

        var index = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $(".classifyInfo .eachClassify").eq(index).show();
        $(".classifyInfo .eachClassify").eq(index).siblings().hide();

    });


});