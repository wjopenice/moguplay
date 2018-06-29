$(function(){

    //选择不同网银
    $(document).on("click",'.payInfoType',function(){
        var index = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $(".payInfoUl").eq(index).show();
        $(".payInfoUl").eq(index).siblings().hide();
    });

    //选择不同的银行
    $(document).on("click",'.subPayBank',function(){
        var isActive = $(this).hasClass('active');
        if(!isActive){
            $(this).addClass('active');
            $(this).siblings().removeClass('active');
        }else{
            $(this).removeClass('active');
        }
    });

});
