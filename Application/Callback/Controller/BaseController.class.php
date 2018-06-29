<?php

namespace Callback\Controller;
use Common\Api\GameApi;
/**
 * 支付回调控制器
 * @author 小纯洁 
 */
class BaseController extends EncryptController{

    /**
    *充值到游戏成功后修改充值状态和设置游戏币
    */
    protected function set_spend($data){
        $spend = M('Spend',"tab_");
        $map['pay_order_number'] = $data['out_trade_no'];
        $d = $spend->where($map)->find();
        if(empty($d)){$this->record_logs("数据异常");return false;}
        if($d['pay_status'] == 0){
            $data_save['pay_status'] = 1;
            $data_save['order_number'] = $data['trade_no'];
            $map_s['pay_order_number'] = $data['out_trade_no']; 
            $r = $spend->where($map_s)->save($data_save);
            $this->set_ratio($d['pay_order_number']);
            if($r!== false){
                $game = new GameApi();
                $game->game_pay_notify($data,1);
                return true;
            }else{
                $this->record_logs("修改数据失败");
            }
        }
        else{
            return true;
        }
    }

    /**
    *充值平台币成功后的设置
    */
    protected function set_deposit($data){
        $deposit = M('deposit',"tab_");
        $map['pay_order_number'] = $data['out_trade_no'];
        $d = $deposit->where($map)->find();
        if(empty($d)){return false;}
        if($d['pay_status'] == 0){
            $data_save['pay_status'] = 1;
            $data_save['order_number'] = $data['trade_no'];
            $map_s['pay_order_number'] = $data['out_trade_no'];
            $r = $deposit->where($map_s)->save($data_save);
            if($r !== false){
                //积分获取记录
                $wheresign['name']='ALIPAY_POINT_SIGN';
                $alipay_points_sign=M('config','sys_')->where($wheresign)->getfield('value');
                $datasave['user_id']=$d['user_id'];
                $datasave['user_account']=$d['user_account'];
                $datasave['amount']=$d['pay_amount'];
                $datasave['pay_way']=$d['pay_way'];
                $datasave['create_time']=time();
                $points=(int)($d['pay_amount'] * $alipay_points_sign);
                $datasave['points']=$points;
                M('points_record','tab_')->add($datasave);
                $user = M("user","tab_");
                $user->where("id=".$d['user_id'])->setInc("balance",$d['pay_amount']);
                $user->where("id=".$d['user_id'])->setInc("cumulative",$d['pay_amount']);
                //把用户的积分加上
                $user->where("id=".$d['user_id'])->setInc("points",$points);
            }else{
                $this->record_logs("修改数据失败");
            }
            return true;
        }
        else{
            return true;
        }
    }
    /**
     *渠道充值平台币成功后的设置
     */
    protected function set_promoteDeposit($data){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/log.txt", "a+");
        fwrite($logFile, "回调修改参数进来了"."\r\n");
        $promote_deposit = M('promote_deposit',"tab_");
        $where =  "pay_order_number='".$data['out_trade_no']."'";
        fwrite($logFile, "修改条件".$where."\r\n");
        $map['pay_order_number'] = $data['out_trade_no'];//商户订单号
        $d = $promote_deposit->where($where)->find();
        fwrite($logFile, "回调修改参数的sql语句\r\n"."为:".$promote_deposit->getLastSql()."\r\n");
        if(empty($d)){return false;}
        if($d['pay_status'] == 0){
            fwrite($logFile, "回调修改参数进来了\r\n"."订单号".$data['out_trade_no']."\r\n");
            $data_save['pay_status'] = 1;
            $data_save['order_number'] = $data['trade_no'];
            $map_s['pay_order_number'] = $data['out_trade_no'];
            $r = $promote_deposit->where($where)->save($data_save);
            if($r !== false){
                $this->SingleSett($d);
                fwrite($logFile, "回调修改参数完成\r\n"."订单号".$data['out_trade_no']."\r\n");
                $promote = M("promote","tab_");
                $promote->where("id=".$d['promote_id'])->setDec("alipay_limit",$d['pay_amount']);
                $promote->where("id=".$d['promote_id'])->setInc("balance_coin",$d['pay_amount']);

            }else{
                fwrite($logFile, "回调修改参数失败\r\n"."订单号".$data['out_trade_no']."\r\n");
                $this->record_logs("修改数据失败");
            }
            return true;
        }
        else{
            return true;
        }
    }

    //单笔结算
    public function SingleSett($order){
        if($order['status'] == 0) {
            //查询用户档位
            $level_id = db('promote')->where('id', $order['promote_id'])->value('level_id');
            $rete = db('promote_level')->where('id', $level_id)->find();
            $promote = M('promote',"tab_");
            if ($order['pay_way'] == 1 || $order['pay_way'] == 2 || $order['pay_way'] == 3) {
                $commission = number_format($order['pay_amount'] * $rete['revenue'], 2);
                $rate = $rete['revenue'];
                $re = $promote->where('id',$order['promote_id'])->setInc('money',$commission);
                $re = $promote->where('id',$order['promote_id'])->setInc('total_money',$commission);
            }
            if ($order['pay_way'] == 4) {
                $commission = number_format($order['pay_amount'] * $rete['h5_wetch_revenue'], 2);
                $rate = $rete['h5_wetch_revenue'];
                $re = $promote->where('id',$order['promote_id'])->setInc('h5_wetch_money',$commission);
                $re = $promote->where('id',$order['promote_id'])->setInc('wetch_money',$commission);
            }
            if ($order['pay_way'] == 5) {
                $commission = number_format($order['pay_amount'] * $rete['h5_alipay_revenue'], 2);
                $rate = $rete['h5_alipay_revenue'];
                $re = $promote->where('id',$order['promote_id'])->setInc('h5_alipay_money',$commission);
                $re = $promote->where('id',$order['promote_id'])->setInc('alipay_money',$commission);
            }

            if($re){
                $where =  "pay_order_number='".$order['pay_order_number']."'";
                $promote_deposit = M('promote_deposit',"tab_");
                $data_save['status'] = 1;
                $data_save['rate'] = $rate;
                $data_save['commission'] = $commission;
                $promote_deposit->where($where)->save($data_save);
            }


        }
    }

    /**
    *设置代充数据信息
    */
    protected function set_agent($data){
        $agent = M("agent","tab_");
        $map['pay_order_number'] = $data['out_trade_no'];
        $d = $agent->where($map)->find();
        if(empty($d)){return false;}
        if($d['pay_status'] == 0){
            $data_save['pay_status'] = 1;
            $data_save['order_number'] = $data['trade_no'];
            $map_s['pay_order_number'] = $data['out_trade_no'];
            $r = $agent->where($map_s)->save($data_save);
            if($r!== false){
               
                $map_play['game_id'] = $d['game_id'];
                if($d['account_type'] == 1){
                     $user = M("UserPlay","tab_");
                     $map_play['user_id'] = $d['user_id'];
                    $user->where($map_play)->setInc("bind_balance",$d['amount']);
                }else{
                    //如果渠道无游戏记录数据则添加数据后在转移
                    $promotegame = M('PromoteGame','tab_');
                    $map_play['promote_id'] = $d['user_id'];
                    $select_res = $promotegame->where($map_play)->getfield('id');
                    if($select_res){
                        $promotegame->where($map_play)->setInc("bind_balance",$d['amount']);
                    }else{
                        $map_promote['id'] = $map_play['promote_id'];
                        $promote_info = M('Promote','tab_')->where($map_promote)->find();
                        $map_game['id'] = $map_play['game_id'];
                        $game_info = M('Promote','tab_')->where($map_game)->find();
                        $promote_game_data['game_id'] = $map_play['game_id'];
                        $promote_game_data['game_name'] = $game_info['game_name'];
                        $promote_game_data['promote_id'] = $map_play['promote_id'];
                        $promote_game_data['promote_account'] = $promote_info['account'];
                        $promote_game_data['promote_nickname'] = $promote_info['nickname'];
                        $add_res = $promotegame->add(promote_game_data);
                        if($add_res){
                           $promotegame->where($map_play)->setInc("bind_balance",$d['amount']); 
                       }else{
                             $this->record_logs("修改数据失败");
                       }

                    }
                    
                }
               
                //$user->where("id=".$d['user_id'])->secInt("cumulative",$d['pay_amount']);
                $pro_l=M('Promote','tab_')->where(array('id'=>$d['promote_id']))->setDec("pay_limit",$d['amount']);
            }else{
                $this->record_logs("修改数据失败");
            }
            return true;
        }
        else{
            return true;
        }
    }

    /**
    *游戏返利
    */
    protected function set_ratio($data){
        $map['pay_order_number']=$data;
        $spend=M("Spend","tab_")->where($map)->find();
        $reb_map['game_id']=$spend['game_id'];
        $rebate=M("Rebate","tab_")->where($reb_map)->find();
        if($rebate['ratio']==0||null==$rebate){
            return false;
        }else{
            if($rebate['money']>0&&$rebate['status']==1){
                if($spend['pay_amount']>=$rebate['money']){
                    $this->compute($spend,$rebate);
                }else{
                    return false;
                }
            }else{
                $this->compute($spend,$rebate);
            }
        }
    }

    //计算返利
    protected function compute($spend,$rebate){
        $user_map['user_id']=$spend['user_id'];
        $user_map['game_id']=$spend['game_id'];            
        $bind_balance=$spend['pay_amount']*($rebate['ratio']/100);
        $spend['ratio']=$rebate['ratio'];
        $spend['ratio_amount']=$bind_balance;
        M("rebate_list","tab_")->add($this->add_rebate_list($spend));
        $re=M("UserPlay","tab_")->where($user_map)->setInc("bind_balance",$bind_balance);
        return $re;
    }
    /**
    *返利记录
    */
    protected function add_rebate_list($data){
        $add['pay_order_number']=$data['pay_order_number'];
        $add['game_id']=$data['game_id'];
        $add['game_name']=$data['game_name'];
        $add['user_id']=$data['user_id'];
        $add['pay_amount']=$data['pay_amount'];
        $add['ratio']=$data['ratio'];
        $add['ratio_amount']=$data['ratio_amount'];
        $add['promote_id']=$data['promote_id'];
        $add['promote_name']=$data['promote_account'];
        $add['create_time']=time();
        return $add;
    }

    /**
    *日志记录
    */
    protected function record_logs($msg=""){
        \Think\Log::record($msg);
    }

}