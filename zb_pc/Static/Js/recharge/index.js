var errorMsg = "";
$(function(){

    $('.tapTitle').find('li').click(function(){
        var index = $(this).index();
        $(".tapTitle li").eq(index).addClass('active').siblings().removeClass('active');
        $(".tapBoxLi").eq(index).addClass('cur').siblings().removeClass('cur');
    });

    //充值金额点击切换
    $(".rechargeMoneyUL li").click(function(){
        $(this).addClass("active").siblings().removeClass("active");
    })

    //支付宝微信弹出充值确认的弹窗
    $(document).on("click",'.zAW',function(){
        $('<div id="rechargeConfirmBox">' +
            '<div class="rechargeConfirmTit">请确认您的充值信息</div>' +
            '<div class="rechargeConfirmCon"><img src="" alt="" class="erCode">' +
            '<p>充值账号：17012341234</p>' +
            '<p>充值方式：支付宝支付</p>' +
            '<p>充值金额：100元</p>' +
            '</div>' +
            '<div class="rechargeConfirmOperation cf">' +
            '<a href="javascript:void(0)" class="confirmSubmit fl">确认提交</a>' +
            '<a href="javascript:void(0)" class="updateBack fl">返回修改</a>' +
            '</div>' +
            '</div>').hbyPopShow({
            width: "530",
            height: "330",
            isHideTitle: true
        });
    });

    //银联弹出充值确认的弹窗
    $(document).on("click",'.union',function(){
        $('<div id="rechargeConfirmBox">' +
            '<div class="rechargeConfirmTit">请确认您的充值信息</div>' +
            '<div class="rechargeConfirmCon">' +
            '<p>充值账号：17012341234</p>' +
            '<p>充值方式：支付宝支付</p>' +
            '<p>充值金额：100元</p>' +
            '</div>' +
            '<div class="rechargeConfirmOperation cf">' +
            '<a href="javascript:void(0)" class="confirmSubmit fl">确认提交</a>' +
            '<a href="javascript:void(0)" class="updateBack fl">返回修改</a>' +
            '</div>' +
            '</div>').hbyPopShow({
            width: "530",
            height: "330",
            isHideTitle: true
        });
    });

    //点击确认提交
    $(document).on("click",'.confirmSubmit',function(){
        //ajax
        $(".sys-pop-wrap").remove();
    });

    //点击返回修改
    $(document).on("click",'.updateBack',function(){
        $(".sys-pop-wrap").remove();
    });


});
