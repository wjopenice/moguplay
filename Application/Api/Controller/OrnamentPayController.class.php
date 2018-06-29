<?php
namespace Api\Controller;

class OrnamentPayController extends BaseController
{

    //微信H5支付
    public function toPay(){

        $data = $_POST;
        $data = [
           'account' => 'ZB1520821677',
           'resqn' => 'QD_'.date('Ymd').date ( 'His' ).sp_random_string(4),
           'pay_amount' => 0.01,
           'pay_type' => 5,
           'pay_way' => $_REQUEST['way'],
           'body' => '平台账号测试',
           'pay_ip'=> get_client_ip(),
           'notify_url' => "http://" . $_SERVER['HTTP_HOST'] . "/api.php/Index/notify",
        ];
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
            $deposit_data['pay_type'] = $data['pay_type'];//点缀
            $deposit_data['pay_way'] = $data['pay_way']; //1支付宝，2微信，3网银，4H5
            $deposit_data['pay_source'] = 0;
            $deposit_data['is_key'] = $data['is_key'];
            $deposit_data['pay_ip'] = isset($data['pay_ip']) ? $data['pay_ip'] : '';
            $deposit_data['create_time'] = NOW_TIME;
            $deposit_data['notify_url'] = $data['notify_url'];

            $result = $deposit->add($deposit_data);
            //$result = true;
            if($result){
                $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
                foreach($data as $k=>$v){
                    fwrite($logFile, $k."=".$v."\r\n");
                }
                fwrite($logFile, "\r\n\r\n");

                if($data['pay_way'] == 4){
                    $url = $this->beginH5Pay($data);
                }else if($data['pay_way'] == 2){
                    $url = $this->beginSweepPay($data);//扫码
                }
                fclose($logFile);
                $this->ajaxReturn(array("status"=>'0001',"payinfo"=>$url));
            
            }else{
                $this->ajaxReturn(array("status"=>'0002',"msg"=>"充值记录添加失败"));
            }
            
        }else{
            $this->ajaxReturn($msgArr);
        }
        exit;

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
        if(!$data['pay_type']){
            return array("status"=>'40016',"msg"=>"请选择支付方式");
            exit;
        }
        if($data['pay_way'] != 2 && $data['pay_way'] != 4){
            return array("status"=>'40017',"msg"=>"请选择正确的支付方式");
            exit;
        }
        $data['is_key'] = isset($data['is_key']) ? $data['is_key'] : '';
        if($data['is_key'] && $data['is_key'] == 1){
            if($promote['paykey']){
                $sh_data = [
                    'resqn'   => $data['resqn'],
                    'account' => $data['account'],
                    'pay_amount' => $data['pay_amount'],
                    'pay_type' => $data['pay_type'],
                    'pay_way' => $data['pay_way'],
                    'notify_url' => $data['notify_url']
                ];
                $sign = $this->SignArray($sh_data,$promote['paykey']);
                if($sign != $data['sign']){
                    return array("status"=>'40013',"msg"=>"验签失败",'sign' => $sign);
                    exit;
                }
            }else{
                return array("status"=>'40014',"msg"=>"APPKEY为空");
                exit;
            }
        }

        return array("status"=>'0',"promote"=>$promote);
    }


    public function beginH5Pay($data,$timeOut = 30){
        #支付配置
        $config['MerchantOrderNo'] = $data['resqn'];
        $config["AppId"] = C('Ornament.APPID');
        $config["Amount"] = $data['pay_amount'];
        $config["ProductName"] = $data['body'] ? $data['body'] : "充值";
        $config["NotifyUrl"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyOrnament/notify";
        $config['PayChannel'] = 1201;
        $config['SceneInfo'] = "{\"h5_info\":{\"type\":\"Wap\",\"wap_url\":\"game-pk.com\",\"wap_name\":\"手上科技\"}}";
        $config["ReqDate"] = date("YmdHis");
        $config["ProductDescription"] = isset($data['remark']) && $data['remark'] ? $data['remark'] : '渠道充值';
              
        $config["Sign"] = $this->SignH5Array($config,C('Ornament.APPSECRET'));//签名

        $paramsStr = $this->ToUrlParams($config);
        $url = C('Ornament.APIURL').'/Order/ToPay';
        $response = self::request($url, $paramsStr, $timeOut);
        $rspArray = json_decode($response, true);

        //验签
        if($this->validSign($rspArray)){
            
            return $rspArray['ToPayData'];

        }else{
            $this->ajaxReturn(array("status"=>'0002',"msg"=>"充值记录添加失败"));
            exit;
        }
          
    }

    public function beginSweepPay($data,$timeOut = 30){

        #支付配置
        $config['MerchantOrderNo'] = $data['resqn'];
        $config["AppId"] = C('Ornament.APPID');
        $config["Amount"] = $data['pay_amount'];
        $config["ProductName"] = $data['body'] ? $data['body'] : "充值";
        $config["NotifyUrl"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyOrnament/notify";
        $config['PayChannel'] = 1202;
        $config["ReqDate"] = date("YmdHis");
        $config["ProductDescription"] = isset($data['remark']) && $data['remark'] ? $data['remark'] : '渠道充值';
              
        $config["Sign"] = $this->SignH5Array($config,C('Ornament.APPSECRET'));//签名

        $paramsStr = $this->ToUrlParams($config);
        $url = C('Ornament.APIURL').'/Order/ToPay';
        $response = self::request($url, $paramsStr, $timeOut);
        $rspArray = json_decode($response, true);

        //验签
        if($this->validSign($rspArray)){
            return $rspArray['QRCodeUrl'];

        }else{
            $this->ajaxReturn(array("status"=>'40010',"msg"=>"请求接口失败"));
            exit;
        }
          
    }
    

    //发送请求操作仅供参考,不为最佳实践
    function request($url,$params,$timeOut = 30){
        $ch = curl_init();
        $this_header = array("content-type: application/x-www-form-urlencoded;charset=UTF-8");
        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);

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
        $array['key'] = $appkey;// 将key放到数组中一起进行排序和组装
        ksort($array);
        $blankStr = $this->ToUrlParams($array);
        $sign = md5($blankStr);
        return $sign;
    }

    /**
     * 将参数数组签名 H5组装
     */
    public function SignH5Array(array $array,$appkey){
        
        //签名步骤一：按字典序排序参数
        ksort($array);
        $blankStr = $this->ToUrlParams($array);
        //签名步骤二：在string后加入KEY 将key放到数组中一起进行排序和组装
        $blankStr = $blankStr."&Key=".$appkey;
        //签名步骤三：MD5加密
        $blankStr = md5($blankStr);
        //签名步骤四：所有字符转为大写
        $sign = strtoupper($blankStr);
        return $sign;
    }

    public function ToUrlParams(array $array)
    {
        $buff = "";
        foreach ($array as $k => $v)
        {
            if($v !== "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }

    //验签
    function validSign($array){
        if("0" == $array["RespType"] && $array['RespCode'] == '00'){
            $signRsp = $array["Sign"];
            $array["Sign"] = "";
            $sign = $this->SignH5Array($array,C('Ornament.APPSECRET'));

            if($sign == $signRsp){
                return TRUE;
            }
            else {
                return FALSE;
            }
        }else{
            return FALSE;
        }
        return FALSE;
    }

}