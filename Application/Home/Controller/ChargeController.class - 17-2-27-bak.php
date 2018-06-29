<?php

namespace Home\Controller;
use OT\DataDictionary;
use User\Api\PromoteApi;
use Common\Api\PayApi;
use User\Api\UserApi;
/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class ChargeController extends BaseController {

    
    public function checkpwd(){
        $pid=session("promote_auth.pid");
        $user=new PromoteApi();
        $res = $user->verifyUser($pid,$_POST['pwd']);
        if($res){
            $this->ajaxReturn(array("status"=>1,"msg"=>"成功"));
        }
        else{
            $this->ajaxReturn(array("status"=>0,"msg"=>"失败"));
        }
    }

    public function checkAccount(){
       $game_id = $_POST['game_id'];
       $user_account = $_POST['user_account'];
       $map['game_id'] = $game_id;
       $map['user_account'] = $user_account;
       $map["promote_id"]   = session("promote_auth.pid");
       $data = M("UserPlay","tab_")->where($map)->find();
       if(empty($data)){
            $this->ajaxReturn(array("status"=>0));
       }else{
            $this->ajaxReturn(array("status"=>1));
       }
    }
    

    public function agent_pay()
    {
        if(IS_POST){
            $data = array();
            if($_POST['game_ratio']==0){
            $real_amount=$_POST['amount'];
            }else{
            $real_amount = $_POST['amount'] * ($_POST['game_ratio']/100)*10;#计算折扣后的价格
            $order_no    = "AG_".date('Ymd').date ( 'His' ).sp_random_string(4);
            $user = get_user_entity($_POST['user_account'],true);
            $data['options']    = "agent";
            $data['pay_type']   = $_POST['pay_type'];
            $data['order_no']   = $order_no;
            $data['fee']        = $real_amount;
            $data['notice_url'] ='';
            $data["user_id"]         = $user['id'];
            $data["user_account"]    = $user['account'];
            $data["user_nickname"]   = $user['nickname'];
            $data["game_id"]         = $_POST['game_id'];
            $data["game_appid"]      = $_POST['game_appid'];
            $data["game_name"]       = $_POST['game_name'];
            $data["promote_id"]      = session("promote_auth.pid");
            $data["promote_account"] = session('promote_auth.account');
            $data["title"]           = "代充记录";
            $data["amount"]          = $_POST['amount'];
            $data["real_amount"]     = $real_amount;
            $data["pay_way_num"]     = 0;
            $data['zhekou']=$_POST['game_ratio'];
            //页面上通过表单选择在线支付类型，支付宝为alipay 财付通为tenpay
            $vo = new \Think\Pay\PayVo();
            $vo->setBody("会长代充")
                ->setFee($real_amount)//支付金额
                ->setTitle("平台币")
                ->setOrderNo($order_no)
                ->setSignType("MD5")
                ->setPayMethod("direct")
                ->setTable("agent")
                ->setGameId($_POST['game_id'])
                ->setGameName($_POST['game_name'])
                ->setGameAppid($_POST['game_appid'])
                ->setUserId($user['id'])
                ->setAccount($user['account'])
                ->setUserNickName($user['nickname'])
                ->setPromoteId(session("promote_auth.pid"))
                ->setPromoteName(session('promote_auth.account'))
                ->setMoney($_POST['amount'])
                ->setParam($_POST['game_ratio']);
            switch ($_POST['pay_type']) {
                case 'swiftpass':
                    //判断是否开启支付宝充值
                    if(pay_set_status('weixin')==0){
                        $this->error("网站未开启支付宝充值",'',1);
                        exit();
                    }
                    $vo->setService("pay.weixin.native")
                       ->setPayWay(2);
                    $pay = new \Think\Pay('swiftpass',C('weixin'));
                    $all = $pay->buildRequestForm($vo);
                    $all['amount'] = $vo->getMoney();
                    $this->display();//
                    echo "<script> img_qrcode(".json_encode($all).") </script>";
                    break;
	        	case 'pingtai':
                    $this->add_agent($data);
                    break;
                default:
                    //判断是否开启支付宝充值
                    if(pay_set_status('alipay')==0){
                        $this->error("网站未开启支付宝充值",'',1);
                        exit();
                    }
                    $vo->setService("create_direct_pay_by_user")
                       ->setPayWay(1);
                    $pay = new \Think\Pay('alipay',C('alipay'));
                    echo $pay->buildRequestForm($vo);
                    break;
            }
        }    
        }
        else{
            $this->meta_title = "会长代充";
            $pro=M('Promote','tab_')->where(array('id'=>get_pid()))->find();
            $this->assign('pro',$pro);
            $this->display();
        }
      
    }

    /**
    *添加代充记录
    */
    public function add_agent($data){
        $ise=$this->is_promote_blance($data['promote_id'],$data['real_amount']);
        if($ise){
        $agnet_data['pay_status']       = 1;
        $agnet_data['pay_type']       = 3;
        $map['promote_id']=$data['promote_id'];
        $map['game_id']=$data['game_id'];
        $map['user_id']=$data['user_id'];
        $user_p=M('UserPlay','tab_')->where($map)->setInc('bind_balance',$data['amount']);
        $pro_map['id']=$data['promote_id'];
        $pro=M('promote','tab_')->where($pro_map)->setDec('balance_coin',$data['real_amount']);
        }else{
        $agnet_data['pay_status']       = 0;
        $agnet_data['pay_type']       = 3;
        }
        $agnet_data['order_number']     = "";
        $agnet_data['pay_order_number'] = $data["order_no"];
        $agnet_data['game_id']          = $data["game_id"];
        $agnet_data['game_appid']       = $data["game_appid"];
        $agnet_data['game_name']        = $data["game_name"];
        $agnet_data['promote_id']       = $data["promote_id"];
        $agnet_data['promote_account']  = $data["promote_account"];
        $agnet_data['user_id']          = $data["user_id"];
        $agnet_data['user_account']     = $data["user_account"];
        $agnet_data['user_nickname']    = $data["user_nickname"];
        $agnet_data['amount']           = $data["amount"];
        $agnet_data['real_amount']      = $data["real_amount"];
        $agnet_data['create_time']      = time();
        $agnet_data['zhekou']           =$data['zhekou'];
        $agent = M("agent","tab_");
        $resutl = $agent->add($agnet_data);
        if($resutl&&$agnet_data['pay_status']==1){
            $this->success("充值成功",U("agent_pay_list"));
        }else{
            $this->error("充值失败",U("agent_pay_list"));
        }
    }

    //判断金额
    public function is_promote_blance($id,$amount){
        $map['id']=$id;
         $pro=M('promote','tab_')->where($map)->find();
         if($pro['balance_coin']==0||$pro['balance_coin']<$amount){
            return false;
         }else{
            return true;
         }
    }
    public function agency(){        
        if(IS_POST){
             $map2['account']=session("promote_auth.account");            
             $balance_coinarray=M('promote','tab_')->where($map2)->field('balance_coin')->find();
             $balance_coin=$balance_coinarray['balance_coin'];
             //print_r($balance_coin);exit;
             $money=$_REQUEST['amount'];
             //print_r($money);exit;
             if($money>$balance_coin){
                $this->error("余额不足",U('Charge/agency_list'),1);exit;
             }else{

             $where1['agents_name']=$_REQUEST['promote_id']?$_REQUEST['promote_id']:$_REQUEST['user_id'];
             $where1['promote_account']=session("promote_auth.account");
             //print_r($_REQUEST);exit;
             $lastTimearray=M('pay_agents','tab_')->where($where1)->order('create_time desc')->field('create_time')->find();
             $lastTime=$lastTimearray['create_time']+5;
             //print_r($lastTime);exit;
             $nowTime=time();
             //print_r($nowTime);exit;
             if($lastTime>$nowTime){
                $this->error("系统繁忙",U('Charge/agency_list'),1);exit;
             }else{

             $promote=M("promote","tab_");
            if($_REQUEST['account_number']==0){
                $whereAccount['account']=$_REQUEST['promote_id'];
                $accounts=M("promote","tab_")->where($whereAccount)->find();
                if(!$accounts){
                $this->error("转移失败，渠道不存在",U('Charge/agency'),1);exit;
                }
                $pro_maps['account']   = $_REQUEST['promote_id'];
                $pro_maps['parent_id'] = session("promote_auth.pid");
                $pro = $promote->where($pro_maps)->find();
                if (empty($pro)) {$this->error("此渠道不在本渠道下",U('Charge/agency'),1);exit;}
                $add['agents_id']     =$accounts['id'];
                $add['agents_name']   =$_REQUEST['promote_id'];
                $add['type']=0;
                $map['id']=$add['agents_id'];
                $promote->where($map)->setInc("balance_coin",$_REQUEST['amount']);
            }else{
                $whereAccount['account']=$_REQUEST['user_id'];
                $whereAccount['promote_id']=session("promote_auth.pid");
                $accounts=M("user","tab_")->where($whereAccount)->find();
                if(!$accounts){
                    $this->error("转移失败，用户不属于本渠道！",U('Charge/agency'),1);exit;
                }
                $add['agents_id']     =$accounts['id'];
                $add['agents_name']   =$_REQUEST['user_id'];
                $add['type']=1;
                $map['id']=$add['agents_id'];
                M('user','tab_')->where($map)->setInc('balance',$_REQUEST['amount']);
            }
            $pro_map['id']=session("promote_auth.pid");
            $promote->where($pro_map)->setDec("balance_coin",$_REQUEST['amount']);
            $add['order_number']     =build_order_no();
            $add['promote_id']       =get_pid();
            $add["promote_account"]  = get_promote_name(get_pid());
            $add['amount']           =$_REQUEST['amount'];
            $add['create_time']      =time();
            M("PayAgents","tab_")->add($add);
            //unset($_REQUEST);
            //print_r($_REQUEST);exit;
            //$this->success("转移成功",U("agency_list"));
            echo "<meta charset='UTF-8'><script>alert('转移成功');location.href='index.php?s=/Home/Charge/agency_list.html'</script>";
            }
        }
        }else{
            $probla=M("Promote","tab_")->where(array("id"=>get_pid()))->find();
            $this->assign("balance",$probla['balance_coin']<=0?0:$probla['balance_coin']);  
            $this->assign("balance_status",$probla['balance']);
            $this->display();        
        }
    }
     public function agency_bang(){
        if(IS_POST){
             $map2['promote_account']=session("promote_auth.account");
             $map2['game_id']=$_REQUEST['game_id'];
             $bind_balancearray=M('promote_game','tab_')->where($map2)->field('bind_balance')->find();
             $bind_balance=$bind_balancearray['bind_balance'];
             //print_r($bind_balance);exit;
             $money=$_REQUEST['amount'];
             //print_r($money);exit;
             if($money>$bind_balance){
                $this->error("余额不足",U('Charge/agency_bang_list'),1);exit;
             }else{

             $where1['agents_name']=$_REQUEST['promote_id']?$_REQUEST['promote_id']:$_REQUEST['user_id'];
             $where1['promote_account']=session("promote_auth.account");
             //print_r($_REQUEST);exit;
             $lastTimearray=M('movebang','tab_')->where($where1)->order('create_time desc')->field('create_time')->find();
             $lastTime=$lastTimearray['create_time']+5;
             //print_r($lastTime);exit;
             $nowTime=time();
             //print_r($nowTime);exit;
             if($lastTime>$nowTime){
                $this->error("系统繁忙",U('Charge/agency_bang_list'),1);exit;
             }else{
             $promote=M("promote","tab_");
            if($_REQUEST['account_number']==0){//二级渠道
                $whereAccount['account']=$_REQUEST['promote_id'];
                $accounts=M("promote","tab_")->where($whereAccount)->find();
                if(!$accounts){
                $this->error("转移失败，此渠道不存在",U('Charge/agency_bang'),1);exit;
                }
                $pro_maps['account']   = $_REQUEST['promote_id'];
                $pro_maps['parent_id'] = session("promote_auth.pid");
                $pro = $promote->where($pro_maps)->find();
                if (empty($pro)) {$this->error("此渠道不在本渠道下",U('Charge/agency_bang'),1);exit;}
                $add['agents_id']     = $accounts['id'];
                $add['agents_name']   = $_REQUEST['promote_id'];
                $add['type']=0;
                $user_map['promote_id']=$add['agents_id'];
                $user_map['game_id']=$_REQUEST['game_id'];
                $map1['promote_id'] =$accounts['id'];
                $map1['game_id']    =$_REQUEST['game_id'];
                $progame=M('promote_game','tab_')->where($map1)->find();
                if ($progame) {
                    $user=M('promote_game','tab_')->where($user_map)->setInc('bind_balance',$_REQUEST['amount']);
                }else{
                    $pmap['id'] = $accounts['id'];
                    $p = M('promote','tab_')->field('nickname')->where($pmap)->find();
                    $data=array(
                        'promote_id'       =>  $accounts['id'],
                        'promote_account'  =>  get_promote_name($accounts['id']),
                        'promote_nickname' =>  $p['nickname'],
                        'game_id'          =>  $_REQUEST['game_id'],
                        'game_name'        =>  get_game_name($_REQUEST['game_id']),
                        'bind_balance'     =>  $_REQUEST['amount']
                     );
                    $user=M('promote_game','tab_')->add($data);
                }

            }else{
               
                $chaxun['user_account']=$_REQUEST['user_id'];
                $chaxun['game_id']=$_REQUEST['game_id'];
                $user_play=M('user_play','tab_')->where($chaxun)->find();
                if (empty($user_play)) {
                    $this->error('此用户没有玩过这个游戏',U('Charge/agency_bang'),1);exit;
                }
                $whereAccount['account']=$_REQUEST['user_id'];
                $whereAccount['promote_id']=session("promote_auth.pid");//推广员id
                $accounts=M("user","tab_")->where($whereAccount)->find();
                if(!$accounts){
                    $this->error("转移失败，用户不属于本渠道！",U('Charge/agency_bang'),1);exit;
                }
                $add['agents_id']     =$accounts['id'];
                $add['agents_name']   =$_REQUEST['user_id'];
                $add['type']=1;
                $map['user_id']=get_user_id($_REQUEST['user_id']);
                $map['game_id']=$_REQUEST['game_id'];
                $res=M('user_play','tab_')->where($map)->setInc('bind_balance',$_REQUEST['amount']);
            }
                $user_map['promote_id']=session("promote_auth.pid");
                $user_map['game_id']   =$_REQUEST['game_id'];
                $res=M('promote_game','tab_')->where($user_map)->setDec("bind_balance",$_REQUEST['amount']);
                $add['promote_id']       =get_pid();
                $add["promote_account"]  = get_promote_name(get_pid());
                $add['amount']           =$_REQUEST['amount'];
                $add['create_time']      =time();
                $add['game_name']        =get_game_name($_REQUEST['game_id']);
                $add['game_id']          =$_REQUEST['game_id'];
                M("Movebang","tab_")->add($add);


                //$this->success("转移成功",U("agency_bang_list"));
               echo "<meta charset='UTF-8'><script>alert('转移成功');location.href='index.php?s=/Home/Charge/agency_bang_list.html'</script>";

             }

            }
        }else{
            $this->display();  
        }
    }
    public function agency_bang_list(){
            $map=array();
            if($_REQUEST['game_id']>0){
                $map['game_id']=$_REQUEST['game_id'];
            }
                    
            if(!empty($_REQUEST['time-start']) && !empty($_REQUEST['time-end'])){
                $map['create_time']=array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
            }
            if(isset($_REQUEST['start'])&&isset($_REQUEST['end'])){
                $map['create_time']=array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));
            } 
        $map['promote_id']=get_pid();
        $p = I('get.p');
      $this->lists('Movebang',$p,$map);
    }
    public function checkmoney_bind()
    {
        $game_id=$_POST['game_id'];
        if($_POST['money']>get_yi_bind_balance($game_id)){
            echo json_encode(array("status"=>0,"msg"=>"余额不足"));
        }else{
            echo json_encode(array("status"=>1,"msg"=>"转移成功"));
        }
    }
    public function checkmoney()
    {
        if($_POST['money']>get_yi_balance()){
            echo json_encode(array("status"=>0,"msg"=>"余额不足"));
        }else{
            echo json_encode(array("status"=>1,"msg"=>"转移成功"));
        }
    }

    public function agency_list($p=0)
    {      
        if(isset($_REQUEST['promote_account'])&&$_REQUEST['promote_account']!==""){
            $map['promote_account']=array("like","%".$_REQUEST['promote_account']."%");
            unset($_REQUEST['promote_account']);
        }
        $map['promote_id']=get_pid();
        $p = I('get.p');
      $this->lists('PayAgents',$p,$map);
    }
    
    
    
    public function agent_pay_list($p=0){
        $map=array();
        if($_REQUEST['game_id']>0){
            $map['game_id']=$_REQUEST['game_id'];
        }
        $map['promote_id']=get_pid();
        $total = M("agent","tab_")->where(array('promote_id'=>get_pid(),'pay_status'=>1))->sum('amount');
        $this->assign("total_amount",$total==null?0:$total);
        $this->lists('agent',$p,$map);
    }
        public function promote_game_list(){
            $map=array();
        if($_REQUEST['game_id']>0){
            $map['game_id']=$_REQUEST['game_id'];
        }
        $map['promote_account']=session("promote_auth.account");
        parent::lists("promote_game",$_GET["p"],$map);
    }

    public function money(){
        $map['game_id']=$_REQUEST['id'];
        $map['promote_id']=get_pid();
        $bind_balance=M('promote_game','tab_')->field('bind_balance')->where($map)->find();
        if (empty($bind_balance['bind_balance'])) {
            $bind_balance['bind_balance']=0;
        }
       echo json_encode(array('status'=>1,'money'=>$bind_balance['bind_balance']));
    }
}
