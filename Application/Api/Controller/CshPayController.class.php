<?php
namespace Api\Controller;

class CshPayController extends BaseController
{

    //微信H5支付
    public function h5_Pay(){

        $data = $_POST;
        /*$data = [
           'account' => 'ZB1520821677',
           'resqn' => 'QD_'.date('Ymd').date ( 'His' ).sp_random_string(4),
           'pay_amount' => 0.01,
           'paytype' => 2,
           'body' => '平台账号测试',
           'pay_ip'=> '127.0.0.1',
           'notify_url' => "http://" . $_SERVER['HTTP_HOST'] . "/api.php/Index/notify",
        ];*/
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }
        //字段校验
        $msgArr = $this->parameter($data);

        if($msgArr['status'] == 0){
            $promote = $msgArr['promote'];

            $deposit = M("promote_deposit", "tab_");
            $deposit_data['order_number'] = "";
            $deposit_data['pay_order_number'] = $data['resqn'];
            $deposit_data['promote_id'] = $promote['id'];
            $deposit_data['promote_account'] = $data['account'];
            $deposit_data['pay_amount'] = $data['pay_amount'];
            $deposit_data['pay_status'] = 0;
            $deposit_data['pay_type'] = 4;
            $deposit_data['pay_way'] = 4 ;
            $deposit_data['pay_source'] = 0;
            $deposit_data['is_key'] = $data['is_key'];
            $deposit_data['pay_ip'] = $data['pay_ip'];
            $deposit_data['create_time'] = NOW_TIME;
            $deposit_data['notify_url'] = $data['notify_url'];

            $result = $deposit->add($deposit_data);
            if($result){
                $paramsStr = $this->beginH5Pay($data);
                $url = C('CSH.apiUrl');
                $this->assign('msgArr',array("status"=>'0001',"url"=>$url."?paramStr=".$paramsStr));
            }else{
                $this->assign('msgArr',array("status"=>'0002',"msg"=>"充值记录添加失败"));
            }
            
        }else{
            $this->assign('msgArr',$msgArr);
        }

        $this->display();

    }

    //参数校验
    private function parameter($data){

        if(count($data) == 0){
            return array("status"=>'4006',"msg"=>"参数为空");
            exit;
        }
        
        $account = $data['account'];
        if(!$account){
            return array("status"=>'4007',"msg"=>"商户号为空");
            exit;
        }
        $promote = M('promote','tab_')->where("account='".$account."'")->find();
        if(!$promote){
            return array("status"=>'4008',"msg"=>"商户不存在");
            exit;
        }
        if($promote['status'] != 1){
            return array("status"=>'40012',"msg"=>"商户已被禁用!!!!");
            exit;
        }
        if(!$data['notify_url']){
            return array("status"=>'40011',"msg"=>"回调地址为空");
            exit;
        }
        $order = M('promote_deposit','tab_')->where("pay_order_number = '".$data['resqn']."'")->find();
        if($order){
            return array("status"=>'4009',"msg"=>"订单号重复");
            exit;
        }
        if(!$data['pay_amount']){
            return array("status"=>'40015',"msg"=>"支付金额为空");
            exit;
        }
        if(!$data['pay_ip']){
            return array("status"=>'40016',"msg"=>"IP为空");
            exit;
        }
        $data['is_key'] = isset($data['is_key']) ? $data['is_key'] : '';
        if($data['is_key'] && $data['is_key'] == 1){
            if($promote['paykey']){
                $sh_data = [
                    'resqn'   => $data['resqn'],
                    'account' => $data['account'],
                    'pay_amount' => $data['pay_amount'],
                    'paytype' => $data['paytype'],
                    'notify_url' => $data['notify_url']
                ];
                $sign = $this->SignArray($sh_data,$promote['paykey']);
                if($sign != $data['sign']){
                    return array("status"=>'40013',"msg"=>"验签失败");
                    exit;
                }
            }else{
                return array("status"=>'40014',"msg"=>"APPKEY为空");
                exit;
            }
        }

        return array("status"=>'0',"promote"=>$promote);
    }


    public function beginH5Pay($data){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }
        fwrite($logFile, "\r\n\r\n");

        #支付配置
        $config['bussOrderNum'] = $data['resqn'];
        $config["appKey"] = C('CSH.appKey');
        $config["payMoney"] = $data['pay_amount'];
        $config["orderName"] = $data['body'] ? $data['body'] : "充值";
        $config["notifyUrl"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyCSH/notify";
        $config['returnUrl'] = "";//"http://".$_SERVER['HTTP_HOST']."/media.php?s=/Member/personalcenter.html";
        $config["appType"] = isset($data['app_type']) && $data['app_type'] ? $data['app_type'] : "1";
        $config["ip"] = $data['pay_ip'];//get_client_ip();
        $config["payPlatform"] = "2";
        if(isset($data['remark'])){
            $config["remark"] = $data['remark'];
        }       
        $config["sign"] = $this->SignH5Array($config,C('CSH.keyValue'));//签名
        
        ksort($config);
        $paramsStr = $this->ToUrlParams($config);
        //$url = C('CSH.apiUrl');

        return urlencode($paramsStr);
        
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
     * 将参数数组签名
     */
    public function SignArray(array $array,$appkey){
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        $array['key'] = $appkey;// 将key放到数组中一起进行排序和组装
        ksort($array);
        $blankStr = $this->ToUrlParams($array);
        fwrite($logFile, "签名链接".$blankStr."\r\n");
        $sign = md5($blankStr);
        return $sign;
    }

    /**
     * 将参数数组签名 H5组装
     */
    public function SignH5Array(array $array,$appkey){
        
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

}