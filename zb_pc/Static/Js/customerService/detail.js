/**
 * Created by ZB on 2018/3/29.
 */
var errorMsg = "";
$(function(){

    //tab切换
    $(".guideUl li").click(function(){
        var index = $(this).index();
        $(this).addClass("on").siblings().removeClass("on");
        $(".tap .tapBox").eq(index).show().siblings().hide();

        var activeProblem = $(".guideUl .on").text();
        //console.log(activeProblem);
        $("#activeProblem").text(activeProblem);

    });







});