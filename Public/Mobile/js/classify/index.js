/**
 * Created by wuhan on 2018/3/20.
 */
$(function(){

    $(document).on("click",'.classifyLink',function(){

        //var index = $(this).index();
        //$(this).addClass('active').siblings().removeClass('active');
        //$(".classifyInfo .eachClassify").eq(index).show();
       // $(".classifyInfo .eachClassify").eq(index).siblings().hide();

        var type =  $(this).attr("data-id");
        if (type) {
        	url = url + "/type/"+type+".html"
        }else{
        	url = url + ".html"
        }
        console.log(url);
        window.location.href= url;

    });


});