/**
 * Created by wuhan on 2018/3/20.
 */
$(function(){

    $(document).on("click",'.searchIcon',function(){

    	var txt= $.trim($("#key").val());

        if(txt == ''){
            url = url + ".html";
        }else{
        	url = url + "keyword/" + txt + ".html";
        }
        window.location.href = url

    });

});

