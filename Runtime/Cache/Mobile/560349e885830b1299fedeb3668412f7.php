<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo C('PC_SET_TITLE');?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="keywords" content="<?php echo C('WEB_SITE_KEYWORD');?>">
    <meta name="description" content="<?php echo C('WEB_SITE_DESCRIPTION');?>">
    <link rel="icon" href="/moguplay/Public/Mobile/image/favicon.ico"/>
    <link rel="stylesheet" href="/moguplay/Public/Mobile/css/sm.min.css">
    <link rel="stylesheet" href="/moguplay/Public/Mobile/css/sm-extend.min.css">
    <link rel="stylesheet" href="/moguplay/Public/Mobile/css/public.css">
    <link rel="stylesheet" href="/moguplay/Public/Mobile/css/index/index.css">
</head>
<body class="mHome">
    <!--  加载层   -->
    <div id="loader">
        <div class="loaderInner">
            <img src="/moguplay/Public/Mobile/images/index/logo.png">
        </div>
    </div>
    <div class="page-group">

        <!--   导航栏   -->
        <div class="topBar cf">
            <div class="logoLeft fl cf">
                <img class="logoImg fl" src="/moguplay/Public/Mobile/images/index/logo.png"/>
                <p class="fl">手上科技</p>
            </div>
            <div class="logoRight fr">
                <?php if($is_login == 0): ?><!--  未登录   -->
                <div class="status-unLogin">
                    <a class="btn-login" href="<?php echo U('Public/login');?>">登录</a>
                    <a class="btn-register" href="<?php echo U('Public/register');?>">注册</a>
                </div>
                <?php else: ?>
                <!--  已登录  -->
                <div class="status-login cf">
                    <img class="headImg fl"  src="/Uploads/<?php echo ($user["user_img"]); ?>" onerror="this.onerror = null; this.src ='/moguplay/Public/Media/image/personalcenter/baseinfo/touxiang.png';"/>
                    <p class="headName fl"><?php echo ($user["account"]); ?></p>
                </div><?php endif; ?>
            </div>
        </div>

        <!--  banner  -->
        <!-- <div class="swiper-container" data-space-between='10'>
            <div class="swiper-wrapper slide-banner_uc">
                <?php if(is_array($carousel)): $i = 0; $__LIST__ = $carousel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lun): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
                        <a href=<?php echo ($lun["url"]); ?> class="external" target="<?php echo ($lun["target"]); ?>" title="<?php echo ($lun["title"]); ?>"><img alt="" src="/moguplay<?php echo (get_cover($lun["data"],'path')); ?>" onerror="this.onerror = null; this.src ='';"></a>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?> 
            </div>
            <div class="swiper-pagination"></div>
        </div> -->
        <div class="swiper-container" data-space-between='10'>
            <div class="swiper-wrapper slide-banner_uc">
                <div class="swiper-slide"><a href="javascript:void(0)"><img src="/moguplay/Public/Mobile/images/index/banner_1.jpg" onerror="this.onerror = null; this.src ='./moguplay/Public/Mobile/images/personalCenter/personal-bg.png';"></a></div>
                <div class="swiper-slide"><a href="javascript:void(0)"><img src="/moguplay/Public/Mobile/images/index/banner_2.jpg" onerror="this.onerror = null; this.src ='./moguplay/Public/Mobile/images/personalCenter/personal-bg.png';"></a></div>
                <div class="swiper-slide"><a href="javascript:void(0)"><img src="/moguplay/Public/Mobile/images/index/banner_3.jpg" onerror="this.onerror = null; this.src ='./moguplay/Public/Mobile/images/personalCenter/personal-bg.png';"></a></div>
                <div class="swiper-slide"><a href="javascript:void(0)"><img src="/moguplay/Public/Mobile/images/index/banner_4.jpg" onerror="this.onerror = null; this.src ='./moguplay/Public/Mobile/images/personalCenter/personal-bg.png';"></a></div>
                <div class="swiper-slide"><a href="javascript:void(0)"><img src="/moguplay/Public/Mobile/images/index/banner_5.jpg" onerror="this.onerror = null; this.src ='./moguplay/Public/Mobile/images/personalCenter/personal-bg.png';"></a></div>
                <div class="swiper-slide"><a href="javascript:void(0)"><img src="/moguplay/Public/Mobile/images/index/banner_6.jpg" onerror="this.onerror = null; this.src ='./moguplay/Public/Mobile/images/personalCenter/personal-bg.png';"></a></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <!--  小导航  -->
        <div class="subNavBox container">
            <ul class="cf">
                <li class="subNav fl giftLi"><a href="<?php echo U('Gift/index');?>" class="cf"><img class="icon" src="/moguplay/Public/Mobile/images/index/giftIcon.png"><p class="navName fl">礼包</p></a></li>
                <li class="subNav fl infoLi"><a href="<?php echo U('Category/zixun');?>" class="cf"><img class="icon" src="/moguplay/Public/Mobile/images/index/infoIcon.png"><p class="navName fl">资讯</p></a></li>
                <li class="subNav fl searchLi"><a href="<?php echo U('Game/search');?>" class="cf"><img class="icon" src="/moguplay/Public/Mobile/images/index/searchIcon.png"><p class="navName fl">搜索</p></a></li>
                <li class="subNav fl allLi"><a href="<?php echo U('Game/yx_fenlei');?>" class="cf"><img class="icon" src="/moguplay/Public/Mobile/images/index/allIcon.png"><p class="navName fl">全部</p></a></li>
            </ul>
        </div>

        <!--  最近在玩   -->
        <div class="playBox container">
            <ul class="cf">
                <li class="subPlay fl playFirst">最近在玩</li>
                <?php if(is_array($recommend)): $i = 0; $__LIST__ = $recommend;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="subPlay fl">
                        <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>">
                            <img src="/moguplay<?php echo (get_cover($vo["icon"],'path')); ?>" class="playIcon">
                            <p class="fl playName"><?php echo msubstr($vo['game_name'],0,7,'UTF-8',false);?></p>
                        </a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>

        <!--  新上架游戏  -->
        <div class="newestGame">
            <div class="tit cf"><i class="titIcon fl"></i><p class="titName fl">新上架游戏</p><i class="titIcon fl"></i></div>
            <div class="newestGameContent">
                <ul class="cf">
                    <?php if(is_array($xin)): $i = 0; $__LIST__ = $xin;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="subRankGame fl cf">
                            <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>">
                                <i class="icon fl rank<?php echo ($i); ?>"><?php echo ($i); ?></i>
                                <img class="newestImg fl"  src="/moguplay<?php echo (get_cover($vo["icon"],'path')); ?>" onerror="this.onerror = null; this.src ='./moguplay/Public/Mobile/images/index/recommend-head.png';"/>
                                <div class="newestDetail fl cf">
                                    <p class="fl cf">
                                        <span class="newestName fl"><?php echo msubstr($vo['game_name'],0,7,'UTF-8',false);?></span>
                                        <span class="tag fl">热门</span>
                                        <span class="tag fl">新游</span>
                                    </p>
                                    <p class="fl newestType"><?php echo ($vo["game_type_name"]); ?></p>
                                    <p class="fl num played"><?php echo ($vo["dow_num"]); ?>人玩过</p>
                                </div>
                            </a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>

        <!--   精品热门     -->
        <div class="hotBox">
            <div class="tit cf"><i class="titIcon fl"></i><p class="titName fl">精品热门</p><i class="titIcon fl"></i></div>
            <div class="hotContent container">
                <ul class="cf">
                    <?php if(is_array($hot)): $i = 0; $__LIST__ = $hot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="subHot fl">
                            <img src="/moguplay<?php echo (get_cover($vo["icon"],'path')); ?>" onerror="this.onerror = null; this.src ='./moguplay/Public/Mobile/images/index/recommend-head.png';" class="hotImg">
                            <p class="hotName"><?php echo msubstr($vo['game_name'],0,7,'UTF-8',false);?></p>
                            <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>" class="enter">进入</a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>

        <!--  全部游戏    -->
        <div class="allGamesBox">
            <div class="tit cf"><i class="titIcon fl"></i><p class="titName fl">全部游戏</p><i class="titIcon fl"></i></div>
            <div class="allGamesContent">
                <ul class="cf">
                    <?php if(is_array($rank)): $i = 0; $__LIST__ = $rank;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="subAllGames fl cf">
                            <img src="/moguplay<?php echo (get_cover($vo["icon"],'path')); ?>" onerror="this.onerror = null; this.src ='./moguplay/Public/Mobile/images/index/recommend-head.png';" class="allGameImg fl">
                            <div class="gameSome fl cf">
                                <p class="fl gameNameBox">
                                    <span class="gameName fl"><?php echo msubstr($vo['game_name'],0,10,'UTF-8',false);?></span>
                                    <span class="gameTag fl">热门</span>
                                    <?php if($vo["short"] != 0): ?><span class="gameTag fl"><?php echo ($vo["short"]); ?></span><?php endif; ?>
                                    
                                </p>
                                <p class="fl gameType"><?php echo ($vo["game_type_name"]); ?></p>
                            </div>
                            <a href="<?php echo U('Game/yxchildren?id='.$vo['id'].'');?>" class="btnGameEnter fr">进入</a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
        <!-- 热门推荐  -->
        <!-- <div class="hotRecommend cf">
            <div class="tit fl">热门推荐</div>
            <ul class="cf fl recommendList">
                <?php if(is_array($hot)): $i = 0; $__LIST__ = $hot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="eachGame fl cf">
                    <div class="gameImgBox fl"><img src="/moguplay<?php echo (get_cover($vo["icon"],'path')); ?>" onerror="this.onerror = null; this.src ='./moguplay/Public/Mobile/images/index/recommend-head.png';"/></div>
                    <div class="gameInfo fl cf">
                        <p class="gameName fl"><?php echo msubstr($vo['game_name'],0,7,'UTF-8',false);?></p>
                        <p class="gameType fl"><?php echo ($vo["game_type_name"]); ?></p>
                        <div class="gameTags fl">
                            <a href="javascript:void(0)" class="eachHotTag fl">热门</a>
                            <a href="javascript:void(0)" class="eachHotTag fl">新游</a>
                        </div>
                    </div>
                     <a class="btn-game" href="<?php if($vo["dow_status"] == 0): ?>#<?php else: echo U('Down/down_file?game_id='.$vo['id'].'&type=1'); endif; ?>">游戏下载</a> 
                    <a class="btn-game" href="javascript:;">游戏下载</a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>

            </ul>
        </div> -->

        <!--  到底   -->
        <div class="foot">已经到底了</div>

        <!--   底部导航栏   -->
        <nav class="bar bar-tab">
            <a class="tab-item external footTap-game active" href="<?php echo U('Index/index');?>">
                <span class="icon"></span>
                <span class="tab-label">游戏</span>
            </a>
            <a class="tab-item external footTap-mall" href="<?php echo U('Mall/index');?>">
                <span class="icon"></span>
                <span class="tab-label">商城</span>
            </a>
            <a class="tab-item external footTap-center" href="<?php echo U('Member/personalcenter');?>">
                <span class="icon"></span>
                <span class="tab-label">我</span>
            </a>
        </nav>

    </div>

<script src="/moguplay/Public/Mobile/js/zepto.min.js"></script>
<script src="/moguplay/Public/Mobile/js/sm.min.js"></script>
<script src="/moguplay/Public/Mobile/js/sm-extend.min.js"></script>
<script src="/moguplay/Public/Mobile/js/main.js"></script>
<script src="/moguplay/Public/Mobile/js/index/index.js"></script>
</body>
</html>