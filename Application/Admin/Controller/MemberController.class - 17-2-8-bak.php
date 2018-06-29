<?php

namespace Admin\Controller;
use User\Api\MemberApi as MemberApi;

/**
 * 后台首页控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class MemberController extends ThinkController {

    /**
    *平台用户信息
    */
    public function user_info($p=0){
        $map = array();
		if(isset($_REQUEST['promote_name'])){
                if($_REQUEST['promote_name']=='全部'){
                    #unset($_REQUEST['promote_name']);
                }else if($_REQUEST['promote_name']=='自然注册'){
                    $map['promote_id']=array("elt",0);
                    #unset($_REQUEST['promote_name']);
                }else{
                    $map['promote_id']=get_promote_id($_REQUEST['promote_name']);
                   # unset($_REQUEST['promote_name']);
                }
        }
        if(isset($_REQUEST['account'])){
            $map['tab_user.account'] = array('like','%'.$_REQUEST['account'].'%');
            #unset($_REQUEST['account']);
        }
        if(isset($_REQUEST['game_id'])){
            $map['tab_game.id'] = $_REQUEST['game_id'];
            #unset($_REQUEST['game_id']);
        }
        if(isset($_REQUEST['register_way'])){
            $map['register_way'] = $_REQUEST['register_way'];
            #unset($_REQUEST['register_way']);
        }
        if(isset($_REQUEST['time-start']) && isset($_REQUEST['time-end'])){
            $map['register_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
            #unset($_REQUEST['time-start']);unset($_REQUEST['time-end']);
        }
        if(isset($_REQUEST['start']) && isset($_REQUEST['end'])){
            $map['register_time'] = array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));
            #unset($_REQUEST['start']);unset($_REQUEST['end']);
        }
        $extend=array();
        $extend['map']=$map;
        parent::lists("user",$p,$extend['map']);
    }

    /**
    *用户登陆记录
    */
    public function login_record($p=1){
        if(isset($_REQUEST['game_name'])){
            $map['game_id']=get_game_id($_REQUEST['game_name']);
            unset($_REQUEST['game_name']);
        }
        if(isset($_REQUEST['time-start'])&&isset($_REQUEST['time-end'])){
            $map['login_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
            unset($_REQUEST['time-start']);unset($_REQUEST['time-end']);
        }
        if(isset($_REQUEST['start'])&&isset($_REQUEST['end'])){
            $map['login_time'] =array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));
            unset($_REQUEST['start']);unset($_REQUEST['end']);
        }
        if(isset($_REQUEST['account'])){
            $map['user_account']=array('like','%'.$_REQUEST['account'].'%');
            unset($_REQUEST['account']);
        }
        $extend=array();
        $extend['map']=$map;
        parent::lists("UserLoginRecord",$p,$extend['map']);
    }

    
    public function del($model = null, $ids=null){
        $map=array();
        if(isset($_REQUEST['id'])){
            $map['id']=$_REQUEST['id'];
            $data=M('user_login_record','tab_')
            ->where($map)->delete();
            $this->success('删除成功！',U('login_record'),2);
        }else{
            $this->error('请选择要操作的数据！');
        }
    }
    public function delprovide($ids)
    {
      $list=M("user_login_record","tab_");
      $map['id']=array("in",$ids);
      $map['status']=0;
        $delete=$list->where($map)->delete();
        if($delete){
            $this->success("批量删除成功！",U("login_record"));
        }else{
        $this->error("批量删除失败！",U("login_record"));
        }
    }
    public function edit($id=null){
    	if(IS_POST){
            $member = new MemberApi();
            $data = $_REQUEST;
    		if(empty($data['password'])){unset($data['password']);}
            $res = $member->updateInfo($data);
            if($res !== false){
                $this->success('修改成功',U('user_info'));
            }
            else{
                $this->error('修改失败');
            }
    		
    	}
    	else{
    		$user = A('User','Event');
    		$data=$user->user_entity($id);
            $this->assign('data',$data);
    		$this->display();
    	}
    	
    }
    public function chax($p=1)
    {
        $map['user_account']=get_user_account($_REQUEST['id']);
        $page = intval($p);
        $page = $page ? $page : 1; //默认显示第一页数据
        $row    = 10;
        //$new_model = D($name);
        $data = M("spend","tab_")
            // 查询条件
            ->where($map)
            /* 默认通过id逆序排列 */
            /* 数据分页 */
            ->page($page, $row)
            /* 执行查询 */
            ->select();
        /* 查询记录总数 */
        $count =M("spend","tab_")->where($map)->count();
         //分页
        if($count > $row){
            $page = new \Think\Page($count, $row);
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            $this->assign('_page', $page->show());
        }
        $this->assign('list_data', $data);
        $this->display();
    }
    public function denglu($p=1){
        $map['user_id']=$_REQUEST['id'];
        $page = intval($p);
        $page = $page ? $page : 1; //默认显示第一页数据
        $row    = 10;
        //$new_model = D($name);
        $data = M("user_login_record","tab_")
            // 查询条件
            ->where($map)
            /* 默认通过id逆序排列 */
            /* 数据分页 */
            ->page($page, $row)
            /* 执行查询 */
            ->select();
        /* 查询记录总数 */
        $count =M("user_login_record","tab_")->where($map)->count();
         //分页
        if($count > $row){
            $page = new \Think\Page($count, $row);
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            $this->assign('_page', $page->show());
        }
        $this->assign('list_data', $data);
        $this->display();
    }
    public function bind_balance($p=1){
        $map['user_id']=$_REQUEST['id'];
        $data = M("user_play","tab_")
            // 查询条件
            ->where($map)
            ->group('user_account,game_name')
            /* 执行查询 */
            ->select();
        $this->assign('list_data', $data);
        $this->display();
    }
    public function recall()
    {   
        $map['id']=$_REQUEST['id'];
        $user=M("user","tab_")->where($map)->setField("balance",$_REQUEST['balance']);
        if($user>0){
            $add['cancel_id']=$_REQUEST['id'];
            $add['cancel_name']=get_user_account($_REQUEST['id']);
            $add['money']=$_REQUEST['balance'];
            $add['type']=0;
            $add['admin_id']=session('user_auth.uid');
            $add['admin_name']=session('user_auth.username');            
            $add['create_time']=time();
            M('cancel','tab_')->add($add);
          echo json_encode(array("status"=>1,"msg"=>"修改成功"));
        }else{
          echo json_encode(array("status"=>-1,"msg"=>"修改失败"));
        }
    }
    //撤销绑定平台币
    public function bind_recall(){
        $map['user_id']=$_REQUEST['id'];
        if(isset($_REQUEST['game_id'])){
        $map['game_id']=$_REQUEST['game_id'];
        }
        $user=M('user_play','tab_')->field('bind_balance')->where($map)->select();
        if(!empty($user)){
            $user=M("user_play","tab_")->where($map)->setField("bind_balance",$_REQUEST['bind_balance']);
            $add['user_id']=$_REQUEST['id'];
            $add['user_name']=get_user_account($_REQUEST['id']);
            $add['game_id']=$_REQUEST['game_id'];
            $add['game_name']=get_game_name($_REQUEST['game_id']);
            $add['money']=$_REQUEST['bind_balance'];
            $add['admin_id']=session('user_auth.uid');
            $add['admin_name']=session('user_auth.username');            
            $add['create_time']=time();
            M('UserCancel','tab_')->add($add);
            echo json_encode(array("status"=>1,"msg"=>"修改成功"));
        }else{
            echo json_encode(array("status"=>-1,"msg"=>"修改失败"));
        }
    }

    //平台币修改记录
    public function set_balancelist($p=0){
        if(isset($_REQUEST['cancel_name'])){
            $map['cancel_name']=array('like',"%".$_REQUEST['cancel_name']."%");
            unset($_REQUEST['cancel_name']);
        }
        if(isset($_REQUEST['time-start']) && isset($_REQUEST['time-end'])){
            $map['create_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
            unset($_REQUEST['time-start']);unset($_REQUEST['time-end']);
        }
        $map['type']=0;
         $extend=array();
        $extend['map']=$map;
        parent::lists("cancel",$p,$extend['map']);
    }

    //绑定平台币修改记录
     public function set_bindlist($p=0){
         if(isset($_REQUEST['game_name'])){
            if($_REQUEST['game_name']=="全部"){
             unset($_REQUEST['game_name']);
            }else{
            $map['game_id']=get_game_id($_REQUEST['game_name']);
            }
            unset($_REQUEST['game_name']);
        }
          if(isset($_REQUEST['user_name'])){
            $map['user_name']=array('like',"%".$_REQUEST['user_name']."%");
            unset($_REQUEST['user_name']);
        }
           
         if(isset($_REQUEST['time-start']) && isset($_REQUEST['time-end'])){
            $map['create_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
            unset($_REQUEST['time-start']);unset($_REQUEST['time-end']);
        }
        $extend=array();
        $extend['map']=$map;
        parent::lists("UserCancel",$p,$extend['map']);
    }

}
