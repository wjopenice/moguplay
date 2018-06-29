/**
 * Created by wuhan on 2018/3/20.
 */

$(function(){

    jQuery("#fileUpLoad").fileupload({
        dataType: 'json',
        url: '',
        formData: { name: 'fileUpLoad' },
        //add: function (e, data) {
        //    if (TicketIMG.split(",").length < 3)
        //        data.submit();
        //    else
        //        $.toast("最多只能上传3张");
        //},
        done: function (e, data) {
            console.log(1111);
            console.log(data);
            var param = data.result;
            if (typeof (param.error) != 'undefined') {
                $.toast(param.error);
            } else {
                if (param.state) {
                    TicketIMG = TicketIMG != "" ? TicketIMG + "," + param.imgPath : param.imgPath;
                    //$(".refund-upload.clearfix").append('<div class="refund-upload-input upload-ok"><img src="' + param.imgPath + '"></div>');
                    $('img').on("error", function () {
                        $(this).attr('src', "../Static/images/personalData/head.png");
                    });

                } else {
                    $.toast(param.msg);
                }
            }
        }
    });

    //点击选择性别
    $(document).on("click",'.sexChoose',function(){

        var sex = $(".sex").text();
        var anotherSex = $(".sex").text() === "男" ? "女" : "男";

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
        var sex = $.trim($(".sex").text());
        var realName = $.trim($(".realName").val());
        var cardId = $.trim($(".cardId").val());

        var verifyVal = verifyImgSrc(imgSrc);
        verifyVal = verifyNickName(nickName) && verifyVal;
        verifyVal = verifyRealName(realName) && verifyVal;
        verifyVal = verifyCardID(cardId) && verifyVal;

        if(!verifyVal){
            $.toast(errorMsg);
            return false;
        }
        //sendReq("",{},'',function(data){});

    });

});





