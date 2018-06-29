<?php
namespace Api\Controller;

class IndexController extends BaseController
{	
	
	
	/**
	 * 主页
	 * @author zdd
	 */
	public function index()
	{
		$game = D('Game');
		//推荐游戏
		$recommended = $game -> type_to_select('app_recommend_status',1);
		//新游推荐,暂定9条，等待安卓端完善后改活
		$new = $game -> type_to_select('app_recommend_status',3,9);
		//新游推荐
		$hot = $game -> type_to_select('app_recommend_status',2);
		//单机游戏
		//$area_game = $game -> type_to_select(1,'',6);
		//网络游戏
		//$online_game = $game -> type_to_select(2,'',6);

        //资讯
        $information = $this->zixun_adv();

		$data = array(
					'recommended' => $recommended,
					'new' => $new,
					'hot' => $hot,
					'information' => $information,
					//'area_game' => $area_game,
					//'online_game' => $online_game,
				);
		$this->output($data);
	}
	/**
	 * 根据关键字搜索游戏
	 * @param string keyword 用户输出的关键字
	 * @param int p 页数
	 * @param int size 每页显示的条数
	 * @author zdd
	 */
	public function search_by_keyword()
	{
		$keyword = trim(I('post.keyword'));
		$p = (int)I('post.p');
		$size = (int)I('post.size');
		if(!$keyword)
		{
			$this->output(-901);
		}else
		{
			$data = D('Game')->type_to_select(3,$keyword,$size,$p);
			$this->output($data);

		}
	}

    /*
      *  首页游戏资讯广告图
      *  @author   whh
      */

    public function zixun_adv(){
        $adv = M("Adv","tab_");
        $map['status'] = 1;
        $map['pos_id'] = 4; #首页游戏资讯广告图id
        $carousel = $adv->where($map)->order('sort ASC')->select();
        return $carousel;
    }

	/**
   	 * @author zdd
	 * APP欢迎页
     */
    public function welcome()
    {
    	//app欢迎页图片
    	$appimage = D('appimage');
    	$adv5 = $appimage -> where_to_select('pos_id',5);
	    $this->output($adv5);
  	}
  	/**
  	 * 广告详情展示页
  	 * @author zdd
  	 */
  	public function adv_detail()
  	{
  		$id = I('id');
  		$info = D('Document')->detail($id);
  		$this->assign('vo',$info);
  		$this->display('User/user_letter_detail');
  	}

  	//回调测试
  	public function notify(){
  		echo 'success';
  	}
}