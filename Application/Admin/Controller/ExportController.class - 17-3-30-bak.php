<?php
namespace admin\Controller;
use Think\Controller;
class ExportController extends Controller
{
	public function exportExcel($expTitle,$expCellName,$expTableData){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称  
        $fileName = session('user_auth.username').date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        Vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle);  
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]); 
        } 
        for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
          }             
        }  
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); 
        exit;   
    }

	//导出Excel
     function expUser($id){
     	switch ($id) {
          case 1:
            $xlsName  = "代充记录";
            $xlsCell  = array(
                    array('id','编号'),
                    array('user_account','账号'),
                    array('game_name','游戏名称'), 
                    array('amount','充值金额'),
                    array('real_amount','实扣金额'),
                    array('zhekou','折扣比例'),
                    array('pay_status','支付状态'),
                    array('create_time','充值时间'),  
                    array('promote_account','推广员账号'),    
            );
            print_r($xlsCell);exit;
            if(isset($_REQUEST['user_account'])){
            $map['user_account']=array('like','%'.$_REQUEST['user_account'].'%');
            }
            if(isset($_REQUEST['game_name'])){
                if($_REQUEST['game_name']=='全部'){
                    unset($_REQUEST['game_name']);
                }else{
                    $map['game_name']=$_REQUEST['game_name'];
                    unset($_REQUEST['game_name']);
                }
            }    
            if(isset($_REQUEST['time-start'])&&isset($_REQUEST['time-end'])){
                $map['create_time']=array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
            }
            if(isset($_REQUEST['start'])&&isset($_REQUEST['end'])){
                $map['create_time']=array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));
            }      
           $xlsData=M('agent','tab_')
           ->field("id,user_account,game_name,amount,real_amount,zhekou,pay_status,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time,promote_account")
             ->where($map) 
             ->order("create_time")
             ->select(); 
        break; 
             case 2:
                $xlsName  = "渠道充值";
                $xlsCell  = array(
                    array('id','编号'),
                    array('user_account','账号'),
                    array('game_name','游戏名称'),
                    array('server_name','区服名称'),  
                    array('pay_amount','充值金额'),
                    array('pay_way','充值方式(0平台币;1支付宝;2微信)'),
                    array('pay_time','充值时间'),  
                    array('promote_account','推广员账号'),    
                );
            if(isset($_REQUEST['pay_way'])){
                $map['pay_way']=$_REQUEST['pay_way'];
            }
            if(isset($_REQUEST['game_name'])){
                if($_REQUEST['game_name']=='全部'){
                    unset($_REQUEST['game_name']);
                }else{
                    $map['game_name']=$_REQUEST['game_name'];
                    unset($_REQUEST['game_name']);
                }
            }
            if(isset($_REQUEST['promote_name'])){
                if($_REQUEST['promote_name']=='全部'){
                    unset($_REQUEST['promote_name']);
                }else if($_REQUEST['promote_name']=='自然注册'){
                    $map['promote_id']=array("elt",0);
                    unset($_REQUEST['promote_name']);
                }else{
                    $map['promote_id']=get_promote_id($_REQUEST['promote_name']);
                    unset($_REQUEST['promote_name']);
                }
            }
            if(isset($_REQUEST['user_account'])){
                $map['user_account']=array('like','%'.$_REQUEST['user_account'].'%');
            }
            if(isset($_REQUEST['time-start'])&&isset($_REQUEST['time-end'])){
                $map['pay_time']=array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
            }
            if(isset($_REQUEST['start'])&&isset($_REQUEST['end'])){
                $map['pay_time']=array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));
            }
            $map['tab_spend.pay_status'] = 1;
                $xlsData=M('Spend','tab_')
                ->field("id,user_account,game_name,server_name,pay_amount,FROM_UNIXTIME(pay_time,'%Y-%m-%d %H:%i:%s') as pay_time,pay_way,promote_account")
                ->where($map) 
                ->order("id")
                ->select(); 
            break;

            case 3:
                //print_r($_REQUEST);exit;
                $xlsName  = "渠道注册";
                $xlsCell  = array(
                    array('account','账号'),
                    array('lock_status','状态(1正常，0锁定)'),
                    array('register_time','注册时间'),
                    array('game_name','注册游戏'),
                    array('register_ip','注册IP'),
                    array('promote_account','所属渠道'),
                    array('nickname','所属专员'),
                );
                if(isset($_REQUEST['account'])){
                    $map['tab_user.account']=$_REQUEST['account'];
                }
                /*if(isset($_REQUEST['promote_name'])){
                    $map['a.promote_account']=$_REQUEST['promote_name'];
                }*/
                if(isset($_REQUEST['time-start'])&&isset($_REQUEST['time-end'])){
                    $map['register_time']=array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                }


                if(isset($_REQUEST['promote_name'])){
                    if($_REQUEST['promote_name']=='全部'){
                        unset($_REQUEST['promote_name']);
                    }else if($_REQUEST['promote_name']=='自然注册'){
                        $map['a.promote_account']=$_REQUEST['promote_name'];
                        unset($_REQUEST['promote_name']);
                    }else{
                        $map['a.promote_id']=get_promote_id($_REQUEST['promote_name']);
                    }
                }


                if(isset($_REQUEST['game_name'])){
                    if($_REQUEST['game_name']=='全部'){
                        unset($_REQUEST['game_name']);
                    }else{
                        $map['c.game_name']=$_REQUEST['game_name'];
                        unset($_REQUEST['game_name']);
                    }
                }

                if(isset($_REQUEST['start'])&&isset($_REQUEST['end'])){
                    $map['register_time']=array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));
                }
                $xlsData=M('user','tab_')
                    ->alias('a')
                    ->field('a.id,a.account,a.lock_status,FROM_UNIXTIME(a.register_time,\'%Y-%m-%d %H:%i:%s\') as register_time,
                   c.game_name,a.register_ip,a.promote_account,m.nickname')
                    ->join('left join tab_user_play as b on a.id = b.user_id')
                    ->join('left join tab_game as c on b.game_name = c.game_name')
                    ->join('left join tab_promote as p on a.promote_id=p.id ')
                    ->join('left join sys_member  as m on m.uid=p.admin_id')
                    ->group('a.account')
                    ->where($map)
                    ->order("id")
                    ->select();
                /*echo "<pre>";
                print_r($xlsData);exit;
                echo "</pre>";*/
                break;

            case 4:
                $xlsName  = "渠道对账";
                $xlsCell  = array(
                    array('id','编号'),
                    array('game_name','充值游戏'),
                    array('pay_amount','充值金额'),
                    array('promote_account','推广员账号'),
                    // array('pay_time','充值时间'),  
                );
            if(isset($_REQUEST['game_name'])){
                if($_REQUEST['game_name']=='全部'){
                    unset($_REQUEST['game_name']);
                }else{
                    $map['game_name']=$_REQUEST['game_name'];
                    unset($_REQUEST['game_name']);
                }
            }
            if(isset($_REQUEST['promote_name'])){
                if($_REQUEST['promote_name']=='全部'){
                    unset($_REQUEST['promote_name']);
                }else if($_REQUEST['promote_name']=='自然注册'){
                    $map['promote_id']=array("elt",0);
                    unset($_REQUEST['promote_name']);
                }else{
                    $map['promote_id']=get_promote_id($_REQUEST['promote_name']);
                    unset($_REQUEST['promote_name']);
                }
            }
            if(isset($_REQUEST['time-start'])&&isset($_REQUEST['time-end'])){
                $map['pay_time']=array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
            }
            if(isset($_REQUEST['start'])&&isset($_REQUEST['end'])){
                $map['pay_time']=array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));
            }
                $xlsData=M('Spend','tab_')
                ->field('tab_spend.*,case parent_id  when 0 then promote_id else parent_id end AS parent_id,sum(pay_amount) AS total_amount,DATE_FORMAT( FROM_UNIXTIME(pay_time),"%Y-%m-%d %H:%i:%s") AS period')
                ->join('left join tab_promote ON tab_spend.promote_id = tab_promote.id') 
                // 查询条件
                ->where($map)
                ->order('pay_time')
                //根据字段分组
                ->group('case parent_id  when 0 then promote_id else parent_id end ,DATE_FORMAT( FROM_UNIXTIME(pay_time),"%Y-%m-%d %H:%i:%s"),game_id')
                ->where($map) 
                ->select();
                // var_dump(M('Spend','tab_')->getlastsql()); 
                // exit;
            break;
            case 5:
                $xlsName  = "渠道结算";
                $xlsCell  = array(
                    array('id','编号'),
                    array('game_name','充值游戏'),
                    array('money','充值金额'),
                    array('account','推广员账号'),
                    array('spend_time','充值时间'),   
                );
                if(isset($_REQUEST['game_name'])){
                $map['game_id']=get_game_id($_REQUEST['game_name']);
                }
                if(isset($_REQUEST['time-start'])&&isset($_REQUEST['time-end'])){
                $map['spend_time']=array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                }
                if(isset($_REQUEST['start'])&&isset($_REQUEST['end'])){
                    $map['spend_time']=array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));
                }
                $xlsData=M('Settlement as s','tab_')
                ->field("s.id,g.game_name,s.money,p.account,FROM_UNIXTIME(s.spend_time,'%Y-%m-%d %H:%i:%s') as spend_time")
                ->join('left join tab_game as g on s.game_id=g.id')
                ->join('left join tab_promote as p on s.promote_id=p.id')
                ->where($map) 
                ->order("spend_time")
                ->select(); 
            break;
            case 6:
                $xlsName  = "渠道提现";
                $xlsCell  = array(
                    array('id','编号'),
                    array('account','推广员账号'),
                    array('amount','提现金额'),
                    array('username','操作人'),
                    array('create_time','提现时间'),   
                );
        if(isset($_REQUEST['op_account'])){
            $map['op_account']=array('like','%'.$_REQUEST['op_account'].'%');
        }
        if(isset($_REQUEST['promote_name'])){
                if($_REQUEST['promote_name']=='全部'){
                    unset($_REQUEST['promote_name']);
                }else if($_REQUEST['promote_name']=='自然注册'){
                    $map['promote_id']=array("elt",0);
                    unset($_REQUEST['promote_name']);
                }else{
                    $map['promote_id']=get_promote_id($_REQUEST['promote_name']);
                    unset($_REQUEST['promote_name']);
                }
        }
        if(isset($_REQUEST['time-start'])&&isset($_REQUEST['time-end'])){
            $map['s.create_time']=array(
                'BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1)
            );
        }
        if(isset($_REQUEST['start'])&&isset($_REQUEST['end'])){
            $map['s.create_time']=array(
                'BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1)
            );
        }
                $xlsData=M('Withdraw as s','tab_')
                ->field("s.id,p.account,s.amount,m.username,FROM_UNIXTIME(s.create_time,'%Y-%m-%d %H:%i:%s') as create_time")
                ->join('left join tab_promote as p on s.promote_id=p.id')
                ->join('left join sys_ucenter_member as m on s.op_id=m.id')
                ->where($map) 
                ->order("create_time")
                ->select(); 
            break;
            case 7:
                $xlsName  = "游戏消费记录";
                $xlsCell  = array(
                    array('id','编号'),
                    array('pay_order_number','订单号'),
                    array('user_account','用户帐号'),
                    array('game_name','游戏名称'),
                    array('pay_amount','充值金额'),
                    array('pay_time','充值时间'),    
                    array('pay_way','充值方式(0平台币;1支付宝;2微信)'),
                    array('pay_status','充值状态(0未支付;1成功)'),
                );
                if(isset($_REQUEST['user_account'])){
                $map['user_account']=array('like','%'.$_REQUEST['user_account'].'%');
                }
                if(isset($_REQUEST['pay_way'])){
                    $map['pay_way']=$_REQUEST['pay_way'];
                }
                if(isset($_REQUEST['pay_status'])){
                    $map['pay_status']=$_REQUEST['pay_status'];
                }
                if(isset($_REQUEST['game_name'])){
                    if($_REQUEST['game_name']=='全部'){
                        unset($_REQUEST['game_name']);
                    }else{
                        $map['game_name']=$_REQUEST['game_name'];
                        unset($_REQUEST['game_name']);
                    }
                }
                if(isset($_REQUEST['time-start']) && isset($_REQUEST['time-end'])){
                    $map['pay_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                }
                if(isset($_REQUEST['start']) && isset($_REQUEST['end'])){
                    $map['pay_time'] = array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));;
                }
                $xlsData=M('Spend','tab_')
                ->field("id,pay_order_number,user_account,game_name,pay_amount,FROM_UNIXTIME(pay_time,'%Y-%m-%d %H:%i:%s') as pay_time,pay_way,pay_status")
                ->where($map) 
                ->order("pay_time")
                ->select(); 
            break;
            case 8:
                $xlsName  = "平台币充值记录";
                $xlsCell  = array(
                    array('id','编号'),
                    array('pay_order_number','订单号'),
                    array('user_nickname','用户昵称'),
                    array('pay_amount','支付金额'),
                    array('promote_account','所属渠道'),
                    array('create_time','充值时间'),    
                    array('pay_way','充值方式(0支付宝;1微信)'),
                    array('pay_status','充值状态(0失败;1成功)'),
                    array('pay_source','支付来源(1:PC;2:SDK;3APP)'),
                );
                if(isset($_REQUEST['user_nickname'])){
                $map['user_nickname']=array('like','%'.$_REQUEST['user_nickname'].'%');
                }
                if(isset($_REQUEST['pay_way'])){
                    $map['pay_way']=$_REQUEST['pay_way'];
                }
                if(isset($_REQUEST['pay_status'])){
                    $map['pay_status']=$_REQUEST['pay_status'];
                }
                if(!isset($_REQUEST['promote_id'])){

                }else if(isset($_REQUEST['promote_id']) && $_REQUEST['promote_id']==0){
                    $map['promote_id']=array('elt',0);
                }elseif(isset($_REQUEST['promote_name'])&&$_REQUEST['promote_id']==-1){
                    $map['promote_id']=get_promote_id($_REQUEST['promote_name']);
                }else{
                    $map['promote_id']=$_REQUEST['promote_id'];
                }
                if(isset($_REQUEST['time-start']) && isset($_REQUEST['time-end'])){
                    $map['create_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                }
                if(isset($_REQUEST['start']) && isset($_REQUEST['end'])){
                    $map['create_time'] = array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));;
                }
                $xlsData=M('Deposit','tab_')
                ->field("id,pay_order_number,user_nickname,pay_amount,promote_account,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time,pay_way,pay_status,pay_source")
                ->where($map) 
                ->order("create_time")
                ->select(); 
            break;
                
            case 9:
				$xlsName  = "渠道平台币发放";
                $xlsCell  = array(
                    array('id','编号'),
                    array('order_number','订单号'),
                    //array('user_nickname','用户昵称'),
                    //array('game_name','游戏名称'),
                    array('amount','金额'),
                    array('create_time','充值时间'),    
                    array('status','状态(0未充值;1已充值)'),
                    //array('op_account','操作人'),
					array('promote_account','所属渠道'),
                );
                if(isset($_REQUEST['user_nickname'])){
                $map['user_nickname']=array('like','%'.$_REQUEST['user_nickname'].'%');
                }
                if(isset($_REQUEST['time-start']) && isset($_REQUEST['time-end'])){
                    $map['create_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                }
                if(isset($_REQUEST['start']) && isset($_REQUEST['end'])){
                    $map['create_time'] = array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));;
                }
                $xlsData=M('Propay','tab_')
                ->field("id,order_number,amount,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time,status,promote_account")
                ->where($map) 
                ->order("id desc")
                ->select(); 
            break;
            case 10:
                $xlsName  = "平台币使用记录";
                $xlsCell  = array(
                    array('id','编号'),
                    array('pay_order_number','订单号'),
                    array('user_nickname','用户昵称'),
                    array('game_name','游戏'),
                    array('pay_amount','金额'),
                    array('props_name','游戏道具'),
                    array('pay_time','充值时间'),    
                    array('pay_status','状态(0下单未支付;1成功)'),
                );
                if(isset($_REQUEST['user_nickname'])){
                $map['user_nickname']=array('like','%'.$_REQUEST['user_nickname'].'%');
                }
                if(isset($_REQUEST['game_name'])){
                    if($_REQUEST['game_name']=='全部'){
                    }else{
                        $map['game_name']=$_REQUEST['game_name'];
                    }
                }
                if(isset($_REQUEST['time-start']) && isset($_REQUEST['time-end'])){
                    $map['pay_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                }
                if(isset($_REQUEST['start']) && isset($_REQUEST['end'])){
                    $map['pay_time'] = array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));;
                }
                if(!isset($_REQUEST['promote_id'])){

                }else if(isset($_REQUEST['promote_id']) && $_REQUEST['promote_id']==0){
                    $map['promote_id']=array('elt',0);
                    unset($_REQUEST['promote_id']);
                    unset($_REQUEST['promote_name']);
                }elseif(isset($_REQUEST['promote_name'])&&$_REQUEST['promote_id']==-1){
                    $map['promote_id']=get_promote_id($_REQUEST['promote_name']);
                }else{
                    $map['promote_id']=$_REQUEST['promote_id'];
                    unset($_REQUEST['promote_id']);
                    unset($_REQUEST['promote_name']);
                }
                if(isset($_REQUEST['game_name'])){
                    if($_REQUEST['game_name']=='全部'){
                        unset($_REQUEST['game_name']);
                    }else{
                        $map['game_name']=$_REQUEST['game_name'];
                    }
                    unset($_REQUEST['game_name']);
                }
                $xlsData=M('Bind_spend','tab_')
                ->field("id,pay_order_number,user_nickname,game_name,pay_amount,props_name,FROM_UNIXTIME(pay_time,'%Y-%m-%d %H:%i:%s') as pay_time,pay_status")
                ->where($map) 
                ->order("pay_time")
                ->select(); 
            break;
            case 11:
                $xlsName  = "礼包领取记录";
                $xlsCell  = array(
                    array('id','编号'),
                    array('game_name','游戏名称'),
                    array('gift_name','礼包名称'),
                    array('user_account','领取用户'),
                    array('novice','激活码'),    
                    array('create_time','领取时间'),
                );
                if(isset($_REQUEST['game_name'])){
                $map['game_name']=array('like','%'.$_REQUEST['game_name'].'%');
                }
                $xlsData=M('gift_record','tab_')
                ->field("id,game_name,gift_name,user_account,novice,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time")
                ->where($map) 
                ->order("create_time")
                ->select(); 
            break;
          case 12:
                $xlsName  = "平台用户";
                $xlsCell  = array(
                    array('id','用户id'),
                    array('account','用户账号'),
                    array('balance','平台币余额'),
                    array('register_way','注册方式(0:WEB;1:SDK;2:APP)'),
                    array('register_time','注册时间'),
					array('promote_account','所属渠道'),
                );
                if(isset($_REQUEST['account'])){
                    $map['tab_user.account'] = array('like','%'.$_REQUEST['account'].'%');
                }
                if(isset($_REQUEST['game_id'])){
                    $map['tab_game.id'] = $_REQUEST['game_id'];
                }
                if(isset($_REQUEST['register_way'])){
                    $map['register_way'] = $_REQUEST['register_way'];
                }
                if(isset($_REQUEST['time-start']) && isset($_REQUEST['time-end'])){
                    $map['register_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                }
                if(isset($_REQUEST['start']) && isset($_REQUEST['end'])){
                    $map['register_time'] = array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));;
                }
                $xlsData=M('User','tab_')
                ->field("id,account,balance,register_time,register_way,FROM_UNIXTIME(register_time,'%Y-%m-%d %H:%i:%s') as register_time,promote_account")
                ->where($map) 
                ->order("register_time")
                ->select(); 
            break;
            case 13:
                $xlsName  = "代充额度";
                $xlsCell  = array(
                    array('id','编号'),
                    array('account','渠道账号'),
                    array('pay_limit','代充上限'),
                    array('set_pay_time','更新时间'),
                );
            if(isset($_REQUEST['promote_name'])){
                if($_REQUEST['promote_name']=='全部'){
                    unset($_REQUEST['promote_name']);
                }else if($_REQUEST['promote_name']=='自然注册'){
                    $map['id']=array("elt",0);
                    unset($_REQUEST['promote_name']);
                }else{
                    $map['id']=get_promote_id($_REQUEST['promote_name']);
                    unset($_REQUEST['promote_name']);
                }
            }
            $map['pay_limit']=array('gt','0');
                $xlsData=M('Promote','tab_')
                ->field("id,account,pay_limit,FROM_UNIXTIME(set_pay_time,'%Y-%m-%d %H:%i:%s') as set_pay_time")
                ->where($map) 
                ->order("set_pay_time")
                ->select(); 
            break;
             case 14:
                $xlsName  = "游戏返利";
                $xlsCell  = array(
                    array('id','编号'),
                    array('pay_order_number','订单号'),
                    array('user_id','用户名'),
                    array('game_name','游戏名称'),
                    array('pay_amount','充值金额'),
                    array('ratio','返利比例'),
                    array('ratio_amount','返利金额'),
                    array('promote_name','所属推广员'),
                    array('create_time','添加时间'),
                );
            if(isset($_REQUEST['game_name'])){
                if($_REQUEST['game_name']=='全部'){
                    unset($_REQUEST['game_name']);
                }else if($_REQUEST['game_name']=='自然注册'){
                    $map['id']=array("elt",0);
                    unset($_REQUEST['game_name']);
                }else{
                    $map['id']=get_game_id($_REQUEST['game_name']);
                    unset($_REQUEST['game_name']);
                }
            }
            
                $xlsData=M('RebateList','tab_')
                ->field("id,pay_order_number,user_id,user_name,game_name,pay_amount,ratio,ratio_amount,promote_name,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time")
                ->where($map) 
                ->order("create_time")
                ->select(); 
            break;
			case 15:
                $xlsName  = "用户平台币发放";
                $xlsCell  = array(
                    array('id','编号'),
                    array('order_number','订单号'),
                    array('user_account','用户昵称'),
                    array('game_name','游戏名称'),
                    array('amount','金额'),
                    array('create_time','充值时间'),    
                    array('status','状态(0未充值;1已充值)'),
                    array('op_account','操作人'),
					//array('promote_account','所属渠道'),
                );
                if(isset($_REQUEST['user_account'])){
                $map['user_account']=array('like','%'.$_REQUEST['user_account'].'%');
                }
                if(isset($_REQUEST['time-start']) && isset($_REQUEST['time-end'])){
                    $map['create_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                }
                if(isset($_REQUEST['start']) && isset($_REQUEST['end'])){
                    $map['create_time'] = array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));;
                }
                $xlsData=M('Provide','tab_')
                ->field("id,order_number,user_account,game_name,amount,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time,status,op_account")
                ->where($map) 
                ->order("id desc")
                ->select(); 
            break;
            case 16:
                $xlsName  = "渠道绑定平台币发放";
                $xlsCell  = array(
                    array('id','编号'),
                    array('user_account','用户账号'),
                    array('user_nickname','用户昵称'),
                    array('game_name','游戏名称'),
                    array('amount','金额'),
                    array('create_time','充值时间'),    
                    array('status','状态(0未充值;1已充值)'),
                    array('op_account','操作人'),
                );
                if(isset($_REQUEST['promote_account'])){
                    $map['user_account']=array('like','%'.$_REQUEST['promote_account'].'%');
                    unset($_REQUEST['promote_account']);
                }
                if(isset($_REQUEST['time-start'])&&isset($_REQUEST['time-end'])){
                    $map['create_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                    unset($_REQUEST['time-start']);unset($_REQUEST['time-end']);
                }
                if(isset($_REQUEST['start']) && isset($_REQUEST['end'])){
                    $map['create_time'] = array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));
                    #unset($_REQUEST['start']);unset($_REQUEST['end']);
                }
                $xlsData=M('Bang_propay','tab_')
                ->field("id,user_account,user_nickname,game_name,amount,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time,status,op_account,promote_account")
                ->where($map) 
                ->order("id desc")
                ->select(); 
                foreach ($xlsData as &$value) {
                    $value['status'] = get_info_status($value['status'],9);
                }
            break;
            case 17:
                $xlsName  = "渠道-游戏余额记录";
                $xlsCell  = array(
                    array('id','编号'),
                    array('promote_account','渠道用户账号'),
                    array('promote_nickname','渠道用户昵称'),
                    array('game_name','游戏名称'),
                    array('bind_balance','游戏绑定平台币余额'),
                );
                 if(isset($_REQUEST['promote_account'])){
                    $map['promote_account']=array('like','%'.$_REQUEST['promote_account'].'%');
                    unset($_REQUEST['promote_account']);
                }
                if(isset($_REQUEST['time-start'])&&isset($_REQUEST['time-end'])){
                    $map['create_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                    unset($_REQUEST['time-start']);unset($_REQUEST['time-end']);
                }
            
                if(isset($_REQUEST['start']) && isset($_REQUEST['end'])){
                    $map['create_time'] = array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));
                    #unset($_REQUEST['start']);unset($_REQUEST['end']);
                }
                if(isset($_REQUEST['game_name'])){
                   if($_REQUEST['game_name']=='全部'){
                        unset($_REQUEST['game_name']);
                        }else{
                        $map['game_name']=$_REQUEST['game_name'];
                        }
                        unset($_REQUEST['game_name']);
                }
                $promote=M('promote','tab_')->field('id')->select();
                $pro=array_column($promote, 'id');
                $map['user_id']=array('in',implode(",",$pro));
                $xlsData=M('PromoteGame','tab_')
                ->field("id,game_name,promote_account,promote_nickname,bind_balance")
                ->where($map) 
                ->order("id desc")
                ->select(); 
            break;
            case 18:
                $xlsName  = "绑定平台币转移记录";
                $xlsCell  = array(
                    array('id','编号'),
                    array('agents_name','转入账户'),
                    array('game_name','游戏名称'),
                    array('amount','转入金额'),
                    array('promote_account','所属渠道'),
                    array('type','类型'),
                    array('create_time','发放时间'),
                );
                if(isset($_REQUEST['agents_name'])){
                $map['agents_name']=array('like','%'.$_REQUEST['agents_name'].'%');
                }
                if(isset($_REQUEST['promote_account'])){
                $map['promote_account']=array('like','%'.$_REQUEST['promote_account'].'%');
                }
                if(isset($_REQUEST['time-start']) && isset($_REQUEST['time-end'])){
                    $map['create_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                }
                if(isset($_REQUEST['start']) && isset($_REQUEST['end'])){
                    $map['create_time'] = array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));;
                }
                if(isset($_REQUEST['game_name'])){
                    if($_REQUEST['game_name']=='全部'){
                    unset($_REQUEST['game_name']);
                    }else{
                        $map['game_name']=$_REQUEST['game_name'];
                        unset($_REQUEST['game_name']);
                    }
                }
                $xlsData=M('Movebang','tab_')
                ->field("id,agents_name,game_name,amount,promote_account,type,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time,game_id")
                ->where($map) 
                ->order("id desc")
                ->select(); 
                foreach ($xlsData as &$value) {
                    $value['game_name']=get_game_name($value['game_id']);
                    $value['type'] = get_type_move($value['type']);
                }
            break;
            case 19:
                $xlsName  = "修改绑定平台币记录";
                $xlsCell  = array(
                    array('id','编号'),
                    array('game_name','游戏名称'),
                    array('promote_account','渠道账号'),
                    array('prev_amount','修改前金额'),
                    array('amount','修改后金额'),
                    array('status','状态'),
                    array('op_account','操作人'),
                    array('create_time','发放时间'),
                );
                if(isset($_REQUEST['user_nickname'])){
                $map['user_nickname']=array('like','%'.$_REQUEST['user_nickname'].'%');
                }
                if(isset($_REQUEST['time-start']) && isset($_REQUEST['time-end'])){
                    $map['create_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                }
                if(isset($_REQUEST['start']) && isset($_REQUEST['end'])){
                    $map['create_time'] = array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));;
                }
                $xlsData=M('promote_game_edit','tab_')
                ->field("id,game_name,amount,promote_account,prev_amount,status,op_account,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time")
                ->where($map) 
                ->order("id desc")
                ->select(); 
                foreach ($xlsData as &$value) {
                    $value['status'] = get_info_status($value['status'],13);
                }
            break;
            case 20:
                $xlsName  = "渠道支付宝充值记录";
                $xlsCell  = array(
                    array('id','编号'),
                    array('pay_order_number','支付订单号'),
                    array('promote_account','渠道账号'),
                    array('pay_amount','充值金额'),
                    array('pay_status','充值状态(0失败;1成功)'),
                    array('pay_way','充值方式(1支付宝;2微信;3平台币)'),
                    array('create_time','时间'),
                );
                if(isset($_REQUEST['pay_status'])){
                    $map['pay_status']=$_REQUEST['pay_status'];
                    unset($_REQUEST['pay_status']);
                }
                if(isset($_REQUEST['pay_way'])){
                    $map['pay_way']=$_REQUEST['pay_way'];
                    unset($_REQUEST['pay_way']);
                }
                if(isset($_REQUEST['promote_account'])){
                    if($_REQUEST['promote_account']=='全部'){
                    unset($_REQUEST['promote_account']);
                    }else if($_REQUEST['promote_account']=='自然注册'){
                    $map['promote_id']=array("elt",0);
                    unset($_REQUEST['promote_account']);
                   }else{
                   $map['promote_id']=get_promote_id($_REQUEST['promote_account']);
                   unset($_REQUEST['promote_account']);
                   }
                }
                if(isset($_REQUEST['time-start'])&&isset($_REQUEST['time-end'])){
                    $map['create_time']=array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                    unset($_REQUEST['time-start']);unset($_REQUEST['time_end']);
                }
                if(isset($_REQUEST['start'])&&isset($_REQUEST['end'])){
                    $map['create_time']=array('BETWEEN',array(strtotime($_REQUEST['start']),strtotime($_REQUEST['end'])+24*60*60-1));
                    unset($_REQUEST['start']);unset($_REQUEST['end']);
                }

                $xlsData=M('promote_deposit','tab_')
                ->field("id,pay_order_number,promote_account,pay_amount,pay_status,pay_way,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time")
                ->where($map) 
                ->order("id desc")
                ->select(); 
                /*foreach ($xlsData as &$value) {
                    $value['status'] = get_info_status($value['status'],13);
                }*/
            break;
            case 21:
                $xlsName  = "用户绑定平台币修改记录";
                $xlsCell  = array(
                    array('id','编号'),
                    array('user_name','用户账号'),
                    array('game_name','游戏名称'),
                    array('admin_name','操作人'),
                    array('money','修改后金额'),
                    array('create_time','时间'),
                );
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
                $xlsData=M('user_cancel','tab_')
                ->field("id,user_name,game_name,money,admin_name,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time")
                ->where($map) 
                ->order("id desc")
                ->select(); 
                /*foreach ($xlsData as &$value) {
                    $value['status'] = get_info_status($value['status'],13);
                }*/
            break;

            case 22:
                $xlsName  = "用户平台币修改记录";
                $xlsCell  = array(
                    array('id','编号'),
                    array('cancel_name','用户账号'),
                    array('admin_name','操作人'),
                    array('money','修改后金额'),
                    array('create_time','时间'),
                );
               
                    if(isset($_REQUEST['cancel_name'])){
                        $map['cancel_name']=array('like',"%".$_REQUEST['cancel_name']."%");
                        unset($_REQUEST['cancel_name']);
                    }
                       
                    if(isset($_REQUEST['time-start']) && isset($_REQUEST['time-end'])){
                        $map['create_time'] =array('BETWEEN',array(strtotime($_REQUEST['time-start']),strtotime($_REQUEST['time-end'])+24*60*60-1));
                        unset($_REQUEST['time-start']);unset($_REQUEST['time-end']);
                    }
                $map['type']=0;
                $xlsData=M('cancel','tab_')
                ->field("id,cancel_name,money,admin_name,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time")
                ->where($map) 
                ->order("id desc")
                ->select(); 
                /*foreach ($xlsData as &$value) {
                    $value['status'] = get_info_status($value['status'],13);
                }*/
            break;
     	}
     	   $this->exportExcel($xlsName,$xlsCell,$xlsData);

     }
	
}