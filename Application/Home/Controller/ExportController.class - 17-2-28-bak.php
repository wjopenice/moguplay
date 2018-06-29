<?php
namespace Home\Controller;
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
            $xlsName  = "转移绑定平台币记录";
            $xlsCell  = array(
                    array('id','编号'),
                    array('agents_name','充值账号'),
                    array('game_name','游戏名称'), 
                    array('amount','充值金额'),
                    array('type','用户类型'),
                    array('create_time','充值时间')  
            ); 
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
           $xlsData=M('movebang','tab_')
           ->field("id,agents_name,game_name,type,amount,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time,game_id")
             ->where($map) 
             ->order("create_time")
             ->select(); 
             foreach ($xlsData as &$value) {
                    $value['game_name']=get_game_name($value['game_id']);
                    $value['type'] = get_type_move($value['type']);
                }
        break; 
             case 2:
                $xlsName  = "游戏绑定平台币记录";
                $xlsCell  = array(
                    array('id','编号'),
                    array('agents_name','充值账号'),
                    array('type','账号类型'),
                    array('amount','充值金额'),  
                    array('create_time','充值时间')    
                );
            $map['promote_id']=get_pid();
                $xlsData=M('PayAgents','tab_')
                ->field("id,agents_name,type,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time,amount")
                ->where($map) 
                ->order("id")
                ->select(); 
                foreach ($xlsData as &$value) {
                    $value['type'] =get_typo($value['type']);
                }
            break; 
         case 3:
            $xlsName  = "游戏绑定平台币余额记录";
            $xlsCell  = array(
                    array('id','编号'),
                    array('promote_account','用户账号'),
                    array('promote_nickname','用户昵称'), 
                    array('game_name','游戏名称'),
                    array('bind_balance','游戏余额'), 
            ); 
            if($_REQUEST['game_id']>0){
            $map['game_id']=$_REQUEST['game_id'];
        }
        $map['promote_account']=session("promote_auth.account");   
           $xlsData=M('promote_game','tab_')
           ->field("id,promote_account,promote_nickname,game_name,bind_balance")
             ->where($map) 
             ->select(); 
        break; 
     	}
     	   $this->exportExcel($xlsName,$xlsCell,$xlsData);

     }
	
}


