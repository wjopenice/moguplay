
$(function(){
    $(window).scroll(function () {
        //1 页面滚动时获取卷曲高度
        var h = $(this).scrollTop();
        //获取头部的高度
        var tophead = $("#topPart").height();
        var navHeight = $("#navBar").height();
        if (h > tophead) {
            //让导航部定位
            $("#navBar").addClass("fixed");
        } else {
            $("#navBar").removeClass("fixed");
        }
    })

    var fixHtml = '<div class="fixBar cf">' +
        '<div class="fixCode">' +
        '<div class="secondCode"></div>' +
        '<p class="scan">扫描关注手上科技</p>' +
        '</div>' +
        '<div class="code">' +
        '<i class="codeIcon"></i>' +
        '</div>' +
        '<div class="returnTop">' +
        '<i class="returnTopIcon"></i>' +
        '</div>' +
        '</div>';

    $(window).scroll(function(){
        if ($(document).scrollTop() > 200){
            $("body").append(fixHtml);
        }else{
            $(".fixBar").remove();
        }
    });
});

$(document).on("mouseenter",'.code',function(){
    $(".fixCode").show();
});
$(document).on("mouseleave",'.code',function(){
    $(".fixCode").hide();
});
$(document).on("click",'.returnTop',function(){
    $("html,body").animate({scrollTop:0}, 500);
});



// 排行榜

$(function(){
     var $gameOrder= $(".weekly-list");
            $gameOrder.find("li").eq(0).addClass('current');
            $gameOrder.find("li").each(function(){
                var num=$(this).find('.app-show-title').find('span').html();
                $(this).find('.app-show-block').find('span').html(num);
            });
            $gameOrder.find("li").mouseover(function(){
                $(this).addClass('current').siblings('li').removeClass('current');
            })
});

// 角色扮演
$(function(){
    $(".cosplay .tab a").mouseover(function(){
        $(this).addClass('on').siblings().removeClass('on');
        var index = $(this).index();
        number = index;
        $('.cosplay .content li').hide();
        $('.cosplay .content li:eq('+index+')').show();
    });

    var auto = 1;  //等于1则自动切换，其他任意数字则不自动切换
    if(auto ==1){
        var number = 0;
        var maxNumber = $('.cosplay .tab a').length;
        function autotab(){
            number++;
            number == maxNumber? number = 0 : number;
            $('.cosplay .tab a:eq('+number+')').addClass('on').siblings().removeClass('on');
            $('.cosplay .content ul li:eq('+number+')').show().siblings().hide();
        }
        var tabChange = setInterval(autotab,3000);
        //鼠标悬停暂停切换
        $('.cosplay').mouseover(function(){
            clearInterval(tabChange);
        });
        $('.cosplay').mouseout(function(){
            tabChange = setInterval(autotab,3000);
        });
    }
     //游戏开服自动切换
    var kf_allAmount = Math.ceil($('.kaifu-b ul li').length/11);
    if( kf_allAmount == 1){
        return false;
    }
    for(var i = 0;i<kf_allAmount;i++){
        var o_span = '<span class="circle_kaifu" style=""></span>';
        var o_spanOn = '<span class="circle_kaifu on" style=""></span>'
        if( i==0 ){
            $('.circle_div').append(o_spanOn);
        }else{
            $('.circle_div').append(o_span);
        }
    }
    $(".circle_div span").bind('mouseover',function(){
        $(this).addClass('on').siblings().removeClass('on');
        var _index = $(this).index();
        number_kf = _index;
        var start = _index*11;
        var end = start + 10;
        resetLi();
        for(var i = start; i <= end ; i++){
            $('.kaifu-b ul li').eq(i).show();
        } 
    });
    function resetLi(){
        for(var i = 0;i<$('.kaifu-b ul li').length;i++){
             $('.kaifu-b ul li').eq(i).hide();
        }
    }
    if(1){
        var number_kf = 0;
        var maxNumber_kf = $('.circle_div span').length;
        function auto_kf(){
            number_kf++;
            number_kf == maxNumber_kf? number_kf = 0 : number_kf;
            $('.circle_div span:eq('+number_kf+')').addClass('on').siblings().removeClass('on');
            start = number_kf*11;
            end = start + 10;
            resetLi();
            for(var i = start; i <= end ; i++){
                $('.kaifu-b ul li').eq(i).show();
            } 
        }
        var change_kf = setInterval(auto_kf,3500);
        //鼠标悬停暂停切换
        $('.kaifu').mouseover(function(){
            clearInterval(change_kf);
        });
        $('.kaifu').mouseout(function(){
            change_kf = setInterval(auto_kf,3500);
        });
    }
});


