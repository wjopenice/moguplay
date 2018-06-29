/**
 * Created by wuhan on 2018/3/20.
 */

$(function(){

    //jQuery("#fileUpLoad").fileupload({
    //    dataType: 'json',
    //    url: uploadPicture,
    //    formData: { name: 'fileUpLoad'},
    //    add: function (e, data) {
    //        console.log(data);
    //        data.submit();
    //    },
    //    done: function (e, data) {
    //        console.log(data);
    //       if (data.code) {
    //            console.log(data.result);
    //            var param = data.result;
    //            TicketIMG = "./Uploads/" + param.savepath + param.savename;
    //           //$(".refund-upload.clearfix").append('<div class="refund-upload-input upload-ok"><img src="' + param.imgPath + '"></div>');
    //           $('img').on("error", function () {
    //               $(this).attr('src', deImg);
    //           });
    //           $("#centerHeadImg").attr('src', TicketIMG);
    //
    //       } else {
    //        console.log(data);
    //           $.toast(data.msg);
    //       }
    //
    //    }
    //});

    //点击选择性别
    $(document).on("click",'.sexChoose',function(){

        var sex =  $.trim($(".sex").text());
        var anotherSex = sex === "男" ? "女" : "男";

        var buttons1 = [
            {
                text: '请选择',
                label: true
            },
            {
                text: sex,
                bold: true,
                color: 'danger',
                onClick: function() {
                    $(".sex").text(sex);
                }
            },
            {
                text: anotherSex,
                onClick: function() {
                    $(".sex").text(anotherSex);
                }
            }
        ];
        var buttons2 = [
            {
                text: '取消',
                bg: 'danger'
            }
        ];
        var groups = [buttons1, buttons2];
        $.actions(groups);
    });

    //点击保存
    $(document).on("click",'.btnSave',function(){

        var imgSrc = $.trim($(".centerHeadImg").attr("src")[0]);
        var nickName = $.trim($(".nickNameInput").val());
        var sex = $.trim($(".sex").text()) === "男" ? 0 : 1;
        var realName = $.trim($(".realName").val());
        var cardId = $.trim($(".cardId").val());

        var verifyVal = verifyImgSrc(imgSrc);
        verifyVal ? verifyVal = verifyNickName(nickName) : verifyVal;
        
        var data = 'nickname='+nickName+'&sex='+sex;
        if(deIdcard == '')
        {
            verifyVal ? verifyVal = verifyRealName(realName) : verifyVal;
            verifyVal ? verifyVal = verifyCardID(cardId) : verifyVal;
            data = data + '&real_name='+realName+'&idcard='+cardId;
        }
        
        if(!verifyVal){
            $.toast(errorMsg);
            return false;
        }
        
        sendReq(cardurl,data,'',function(data){
            console.log(data);
            if (parseInt(data.status) == 1 ) {
                // 成功状态下
                $.toast(data.msg);
                window.location.href= url;
            } else {
                $.toast(data.msg);
            }
        });

    });

    //图片上传
    ajax_FileUpload({
        btn: jQuery("#changeBox"),
        acceptFileTypes: "gif|jpeg|jpg|png",
        url: uploadPicture,
        callback: function (data,btn) {
            var src = "Uploads/"+data.result.savepath +"/"+ data.result.savename;
            $("#centerHeadImg").attr("src",src);
        }
    });

});





