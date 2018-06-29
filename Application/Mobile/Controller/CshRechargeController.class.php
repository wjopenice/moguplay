<?php
namespace Mobile\Controller;
use Think\Controller;
use Admin\Model\GameModel;
use Common\Api\PayApi;
use Org\Itppay\itppay;
/**
 * 文档模型控制器
 * 文档模型列表和详情
 */
class CshRechargeController extends BaseController {


    public function chongzhi(){

        $wheresign['name']='ALIPAY_POINT_SIGN';
        $alipay_points_sign=M('config','sys_')->where($wheresign)->getfield('value');

        $this->assign('points',$alipay_points_sign);
        $this->assign('account',session('member_auth.account'));
        $this->display();
    }


    /**
     *充值
     *@author whh 
    */
    public function beginPay(){

        //account,apitype,amount:
        $user = get_user_entity($_POST['account'],true);
        #支付配置
        $data['bussOrderNum'] = 'PF_'.date('Ymd').date ( 'His' ).sp_random_string(4);
        $data["appKey"] = C('CSH.appKey');
        $data["payMoney"] = '0.01';//$_POST['amount'];//0.01;
        $data["orderName"] = "平台币";
        $data["notifyUrl"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyCSH/notify";
        $data['returnUrl'] = "http://".$_SERVER['HTTP_HOST']."/media.php?s=/Member/personalcenter.html";
        $data["appType"] = "1";
        $data["ip"] = get_client_ip();//$_SERVER['HTTP_HOST'];
        switch ($_POST['apitype']) {
            case 'alipay':
                $data["payPlatform"] = "1";
                $data["remark"] = "H5支付宝平台币充值";
                break;
            case 'weixin':
                $data["payPlatform"] = "2";
                $data["remark"] = "H5微信平台币充值";
                break;
            default:
                $json_data = array("status"=>0,"msg"=>"未选中充值方式");
                $this->ajaxReturn($json_data);
                break;
        }
        $data["sign"] = $this->SignArray($data,C('CSH.keyValue'));//签名
        
        ksort($data);
        $paramsStr = $this->ToUrlParams($data);
        $url = C('CSH.apiUrl');
        //$rsp = $this->request($url, array('paramStr'=>$paramsStr));
        //$json_data = array("paramsStr"=>array('paramStr'=>$paramsStr),"rsp"=>$rsp);
        $deposit_id = $this->add_deposit($data,$user);
        if($deposit_id){
            $json_data = array("status"=>1,"pay"=>$url."?paramStr=".urlencode($paramsStr));
        }else{
            $json_data = array("status"=>0,"msg"=>'服务器故障 请重试');
        }
        
        $this->ajaxReturn($json_data);
        
    }


    /**
     * 将参数数组签名
     */
    public function SignArray(array $array,$appkey){
        
        ksort($array);
        $blankStr = $rr = $this->ToUrlParams($array);
        $blankStr = "keyValue=".$appkey."&".$blankStr;// 将key放到数组中一起进行排序和组装
        $blankStr =  strtoupper($blankStr);//大写

        $sign = md5($blankStr);
        return $sign;
    }
    
    public function ToUrlParams(array $array)
    {
        $buff = "";
        foreach ($array as $k => $v)
        {
            if($v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        
        $buff = trim($buff, "&");
        return $buff;
    }
    

    //发送请求操作仅供参考,不为最佳实践
    function request($url,$params){
        $ch = curl_init();
        $this_header = array("content-type: application/x-www-form-urlencoded;charset=UTF-8");
        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
         
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//如果不加验证,就设false,商户自行处理
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
         
        $output = curl_exec($ch);
        curl_close($ch);
        return  $output;
    }


     /**
     *平台币充值记录
     */
    private function add_deposit($data,$user = array())
    {
        
        $deposit = M("deposit", "tab_");
        $deposit_data['order_number'] = "";
        $deposit_data['pay_order_number'] = $data['bussOrderNum'];
        $deposit_data['user_id'] = $user['id'];
        $deposit_data['user_account'] = $user['account'];
        $deposit_data['user_nickname'] = $user['nickname'];
        $deposit_data['promote_id'] = $user['promote_id'];
        $deposit_data['promote_account'] = $user['promote_account'];
        $deposit_data['pay_amount'] = $data['payMoney'];
        $deposit_data['pay_status'] = 0;
        $deposit_data['pay_way'] = 4;
        $deposit_data['pay_type'] = 4;
        $deposit_data['pay_source'] = 0;
        $deposit_data['pay_ip'] = get_client_ip();
        $deposit_data['pay_source'] = 0;
        $deposit_data['create_time'] = NOW_TIME;
        $result = $deposit->add($deposit_data);
        return $result;
        
    }

  



}
