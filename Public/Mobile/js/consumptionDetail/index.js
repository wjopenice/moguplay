$(function(){

    var loading = false;// 加载flag
    var lastIndex = 1;// 上次加载的页数
    var itemsPerLoad = 10;// 每次加载添加多少条目
    var maxItems = 0;// 最多可加载的页数

    addItems();//预加载

    function addItems() {//加载产品
        sendReq("",{ pageIndex: lastIndex, pageSize: itemsPerLoad },'',function(result){
            if (result.Count > 0) {
                maxItems = result.Mum;
                $.each(t, function (index, data) {


                    //追加每条列表
                    $(".infinite-scroll-bottom .list-container").append('<li class="eachConsumption fl">' +
                        '<div class="consumptionLeft fl">' +
                        '<p class="payType fl">微信充值</p>' +
                        '<p class="payTime fl">2018-03-06 13:03:45</p>' +
                        '</div>' +
                        '<div class="consumptionRight fr">' +
                        '<p class="a_org">+3000.00</p>' +
                        '</div>' +
                        '</li>');

                });
                if (result.Count < itemsPerLoad)
                    $(".infinite-scroll-preloader").addClass("hide");
            } else {
                $(".infinite-scroll-preloader").addClass("hide");
            }
        });
    }

    // 注册'infinite'事件处理函数
    $(document).on('infinite', '.infinite-scroll-bottom', function () {

        // 如果正在加载，则退出
        if (loading) return;

        // 设置flag
        loading = true;

        // 模拟1s的加载过程
        setTimeout(function () {
            // 重置加载flag
            loading = false;

            if (lastIndex >= maxItems) {
                // 加载完毕，则注销无限加载事件，以防不必要的加载
                $.detachInfiniteScroll($('.infinite-scroll'));
                // 删除加载提示符
                $('.infinite-scroll-preloader').remove();
                return;
            }

            // 添加新条目
            lastIndex++;
            addItems();

            //容器发生改变,如果是js滚动，需要刷新滚动
            $.refreshScroller();
        }, 1000);
    });

});