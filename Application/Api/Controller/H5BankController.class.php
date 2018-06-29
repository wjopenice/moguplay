<?php
namespace Api\Controller;

class H5BankController extends BaseController
{

    //银联H5支付
    public function bank_pay(){

        $data = $_POST;
        /*$data = [
           'account' => 'ZB1520821677',
           'resqn' => 'QD_'.date('Ymd').date ( 'His' ).sp_random_string(4),
           'pay_amount' => 0.01,
           'pay_type' => 7,
           'pay_way' => 6,
           'body' => '平台账号测试',
           'title' => 'H5银联',
           'pay_ip'=> get_client_ip(),
           'notify_url' => "http://" . $_SERVER['HTTP_HOST'] . "/api.php/Index/notify",
           'return_url' => "http://".$_SERVER['HTTP_HOST']."/media.php?s=/Member/personalcenter.html",
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
            $deposit_data['pay_type'] = $data['pay_type'];
            $deposit_data['pay_way'] = $data['pay_way'];
            $deposit_data['pay_source'] = 0;
            $deposit_data['is_key'] = $data['is_key'];
            $deposit_data['pay_ip'] = $data['pay_ip'];
            $deposit_data['create_time'] = NOW_TIME;
            $deposit_data['notify_url'] = $data['notify_url'];

            //$result = $deposit->add($deposit_data);
            $result = ture;
            if($result){
                switch ($data['pay_type']) {
                    case 7:
                        $res = $this->beginReapalPay($data);//兴业
                        break;
                    default:
                        $res = array("status"=>'40018',"msg"=>"支付通道错误");
                        break;
                }
                $this->ajaxReturn($msgArr);
                //$this->assign('msgArr',$res);
            }else{
                $this->ajaxReturn(array("status"=>'0002',"msg"=>"充值记录添加失败"));
                //$this->assign('msgArr',array("status"=>'0002',"msg"=>"充值记录添加失败"));
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
        if(!$data['pay_ip']){
            return array("status"=>'40016',"msg"=>"IP为空");
            exit;
        }
        if(!$data['pay_type']){
            return array("status"=>'40018',"msg"=>"支付通道为空");
            exit;
        }
        if($data['pay_type'] != 7){
            return array("status"=>'40018',"msg"=>"支付通道错误");
            exit;
        }
        if( $data['pay_way'] !=6 ){
            return array("status"=>'40017',"msg"=>"H5支付方式错误");
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


    public function beginReapalPay($data){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }
        fwrite($logFile, "\r\n\r\n");

        #支付配置
        $config["merchant_id"] = C('Reapal.merchant_id');
        $config['order_no'] = $data['resqn'];
        $config['transtime'] = date("Y-m-d h:i:s");
        $config["total_fee"] = $data['pay_amount'] * 100;
        $config['title'] = $data['title'];
        $config['currency'] = '156';
        $config['terminal_type'] = 'mobile';
        $config["body"] = $data['body'] ? $data['body'] : "充值";
        $config['member_id'] = date('YmdHis');
        $config['terminal_info'] = 'terminal_info';
        $config["member_ip"] = $data['pay_ip'];//get_client_ip();
        $config['seller_email'] = C('Reapal.seller_email');
        $config["notify_url"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyReapal/notify";
        $config['return_url'] = "http://".$_SERVER['HTTP_HOST']."/media.php?s=/Member/personalcenter.html";
        $config["payment_type"] = "2";
        $config['pay_method'] = "bankPay";
        $config['default_bank'] = "LITEPAY";
        ksort($config);
        reset($config);
        $config["sign"] = $this->SignH5Array($config,C('Reapal.key'));//签名
        
        $key = $this->getRandom(16);

        $paramsStr = $this->aes_encode(json_encode($config),$key);
        $encryptkey = $this->getEncryptkey($key,"./Public/Api/cert/itrus001.pem");

        $request = array(
            'data' => $paramsStr,
            'merchant_id' => C('Reapal.merchant_id'),
            'encryptkey' => $encryptkey,
        );
        $this->sendHttpRequest($request,C('Reapal.url'));
        
        /*$this->assign('paramsStr',$paramsStr);
        $this->assign('merchant_id',C('Reapal.merchant_id'));
        $this->assign('encryptkey',$encryptkey);
        $this->assign('url',C('Reapal.url'));
        return array("status"=>'0001');*/
        
    }

    //证书加密
    public function getEncryptkey($key,$cert_path)
    {
        # code...
        $public_key= file_get_contents($cert_path);

        $pu_key = openssl_pkey_get_public($public_key);//这个函数可用来判断公钥是否是可用的  

        openssl_public_encrypt($key,$encrypted,$pu_key);//公钥加密  
        
        return base64_encode($encrypted); 

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
        
        $blankStr = $this->ToUrlParams($array);
        $blankStr = $blankStr.$appkey;// 将key放到数组中一起进行排序和组装

        $sign = md5($blankStr);
        return $sign;
    }

    
    /**
     * 随机字符串
     */
    function getRandom($length=100){
        $baseString = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $AESKey = '';
        $_len = strlen($baseString);
        for($i=1;$i<=$length;$i++){
            $AESKey .= $baseString[rand(0, $_len-1)];
        }
        return $AESKey;
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

    function sendHttpRequest($params, $url) {
        $opts = $this->getRequestParamString ( $params );
        //echo $opts;
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false);//不验证证书
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false);//不验证HOST
        curl_setopt ( $ch, CURLOPT_SSLVERSION, 3);
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, array ('Content-type:application/x-www-form-urlencoded;charset=UTF-8' 
        ) );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $opts );

        /**
        * 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
        */
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

        // 运行cURL，请求网页
        $html = curl_exec ( $ch );
        // close cURL resource, and free up system resources
        curl_close ( $ch );
        return $html;
    }

    /**
     * 组装报文
     *
     * @param unknown_type $params          
     * @return string
     */
    function getRequestParamString($params) {
        $params_str = '';
        foreach ( $params as $key => $value ) {
            $params_str .= ($key . '=' . (!isset ( $value ) ? '' : urlencode( $value )) . '&');
        }
        return substr ( $params_str, 0, strlen ( $params_str ) - 1 );
    }

}