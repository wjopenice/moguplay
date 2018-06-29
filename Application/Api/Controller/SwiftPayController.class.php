<?php
namespace Api\Controller;

//威富通 兴业
class SwiftPayController extends BaseController
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
           'notify_url' => 'http://119.23.34.87/api.php?s=/Pay/beginPay.html',
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
            $deposit_data['pay_type'] = 6;
            $deposit_data['pay_way'] = 4 ;
            $deposit_data['pay_source'] = 0;
            $deposit_data['is_key'] = $data['is_key'];
            $deposit_data['pay_ip'] = $data['pay_ip'];
            $deposit_data['create_time'] = NOW_TIME;
            $deposit_data['notify_url'] = $data['notify_url'];

            $result = $deposit->add($deposit_data);

            if($result){
                $pay_info = $this->beginH5Pay($data);
                $this->ajaxReturn(array("status"=>'0001',"payinfo"=>$pay_info));
            }else{
                $this->ajaxReturn(array("status"=>'0002',"msg"=>"充值记录添加失败"));
            }
            
        }else{
            $this->ajaxReturn($msgArr);
        }

    }

    //扫码支付
    public function Pay(){

        $data = $_POST;
        $data = [
           'account' => 'ZB1520821677',
           'resqn' => 'QD_'.date('Ymd').date ( 'His' ).sp_random_string(4),
           'pay_amount' => 0.01,
           'paytype' => 'A01',
           'body' => '平台账号测试',
           'pay_ip'=> '127.0.0.1',
           'notify_url' => 'http://119.23.34.87/api.php?s=/Pay/beginPay.html',
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
            $deposit_data['pay_type'] = 6;
            $deposit_data['pay_way'] = $data['paytype'] == 'A01' ? 1 : 2 ;
            $deposit_data['pay_source'] = 0;
            $deposit_data['is_key'] = $data['is_key'];
            $deposit_data['pay_ip'] = $data['pay_ip'];
            $deposit_data['create_time'] = NOW_TIME;
            $deposit_data['notify_url'] = $data['notify_url'];

            $result = $deposit->add($deposit_data);

            if($result){
                $pay_info = $this->beginPay($data);
                $this->ajaxReturn(array("status"=>'0001',"payinfo"=>$pay_info));
            }else{
                $this->ajaxReturn(array("status"=>'0002',"msg"=>"充值记录添加失败"));
            }

        }else{
            $this->ajaxReturn($msgArr);
        }

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


    //扫码接口
    public function beginPay($data,$timeOut = 30){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }
        fwrite($logFile, "\r\n\r\n");
        if($data['paytype'] == 'W01'){
            $service = "pay.weixin.native";
        }
        if($data['paytype'] == 'A01'){
            $service = "pay.alipay.native";
        }
        #支付配置
        $config['service'] = $service;
        $config['mch_id'] = C('SwiftScan.mchId');
        $config['out_trade_no'] = $data['resqn'];
        $config["total_fee"] = $data['pay_amount'] * 100;//单位 分
        $config["body"] = $data['body'] ? $data['body'] : "充值";
        $config["notify_url"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifySwift/scanNotify";
        $config["device_info"] = isset($data['device_info']) && $data['device_info'] ? $data['device_info'] : "AND_WAP";
        $config["mch_app_name"] = isset($data['mch_app_name']) && $data['mch_app_name'] ? $data['mch_app_name'] : "手上科技";
        $config["mch_app_id"] = isset($data['mch_app_id']) && $data['mch_app_id'] ? $data['mch_app_id'] : "www.game-pk.com";
        $config["mch_create_ip"] = $data['pay_ip'];//get_client_ip();
        $config["nonce_str"] = $this->getRandom(32);     
        $config["sign"] = $this->SignH5Array($config,C('SwiftScan.key'));//签名

        $paramsStr = $this->toXml($config);

        $url = C('SwiftScan.url');
        $html_text = self::request($url, $paramsStr, $timeOut);
        //解析返回的xml
//        $html_text = '<xml><charset><![CDATA[UTF-8]]></charset>
//                        <mch_id><![CDATA[175510359638]]></mch_id>
//                        <nonce_str><![CDATA[oajqw44vvho4rpne9k7okfok0g8drtu1]]></nonce_str>
//                        <pay_info><![CDATA[https://statecheck.swiftpass.cn/pay/wappay?token_id=2d2c4fe26e7400515a51948aa06630b0d&service=pay.weixin.wappayv2]]></pay_info>
//                        <result_code><![CDATA[0]]></result_code>
//                        <sign><![CDATA[3597280A82F33C16D633EDDC96C757B3]]></sign>
//                        <sign_type><![CDATA[MD5]]></sign_type>
//                        <status><![CDATA[0]]></status>
//                        <version><![CDATA[2.0]]></version>
//                        </xml>';

        $rspArray = $this->xmlToArray($html_text);
        //验签
        if($this->validSign($rspArray)){
            return $rspArray['code_url'];

        }else{
            $this->ajaxReturn(array("status"=>'40010',"msg"=>"请求接口失败"));
            exit;
        }

        
    }

    //H5微信接口
    public function beginH5Pay($data,$timeOut = 30){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }
        fwrite($logFile, "\r\n\r\n");

        #支付配置
        $config['service'] = "pay.weixin.wappay";
        $config['mch_id'] = C('Swift.mchId');
        $config['out_trade_no'] = $data['resqn'];
        $config["total_fee"] = $data['pay_amount'] * 100;//单位 分
        $config["body"] = $data['body'] ? $data['body'] : "充值";
        $config["notify_url"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifySwift/notify";
        $config["device_info"] = isset($data['device_info']) && $data['device_info'] ? $data['device_info'] : "AND_WAP";
        $config["mch_app_name"] = isset($data['mch_app_name']) && $data['mch_app_name'] ? $data['mch_app_name'] : "手上科技";
        $config["mch_app_id"] = isset($data['mch_app_id']) && $data['mch_app_id'] ? $data['mch_app_id'] : "www.game-pk.com";
        $config["mch_create_ip"] = $data['pay_ip'];//get_client_ip();
        $config["nonce_str"] = $this->getRandom(32);
        $config["sign"] = $this->SignH5Array($config,C('Swift.key'));//签名

        $paramsStr = $this->toXml($config);
        $url = C('Swift.url');
        $html_text = self::request($url, $paramsStr, $timeOut);

        //解析返回的xml
//        $html_text = '<xml><charset><![CDATA[UTF-8]]></charset>
//                        <mch_id><![CDATA[175510359638]]></mch_id>
//                        <nonce_str><![CDATA[oajqw44vvho4rpne9k7okfok0g8drtu1]]></nonce_str>
//                        <pay_info><![CDATA[https://statecheck.swiftpass.cn/pay/wappay?token_id=2d2c4fe26e7400515a51948aa06630b0d&service=pay.weixin.wappayv2]]></pay_info>
//                        <result_code><![CDATA[0]]></result_code>
//                        <sign><![CDATA[3597280A82F33C16D633EDDC96C757B3]]></sign>
//                        <sign_type><![CDATA[MD5]]></sign_type>
//                        <status><![CDATA[0]]></status>
//                        <version><![CDATA[2.0]]></version>
//                        </xml>';
        $rspArray = $this->xmlToArray($html_text);
        //验签
        if($this->validSign($rspArray)){
            return $rspArray['pay_info'];

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
        $blankStr = $blankStr."&key=".$appkey;// 将key放到数组中一起进行排序和组装

        $sign =  strtoupper(md5($blankStr));//大写
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

    /**
     * 随机字符串
     */
    function getRandom($param=100){
        $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $key = "";
        for($i=0;$i<$param;$i++)
        {
            $key .= $str{mt_rand(0,32)};    //生成php随机数
        }
        return $key;
    }

    /**
     * 将数据转为XML
     */
    public static function toXml($array){
        $xml = '<xml>';
        forEach($array as $k=>$v){
            $xml.='<'.$k.'><![CDATA['.$v.']]></'.$k.'>';
        }
        $xml.='</xml>';
        return $xml;
    }

    /**
     * 将XML转为数组
     */
    function xmlToArray($xml){     //禁止引用外部xml实体    
        libxml_disable_entity_loader(true);    
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);    
        $array = json_decode(json_encode($xmlstring),true);    
        return $array;    
    } 

    //验签
    function validSign($array){
        if("0" == $array["result_code"] && $array['status'] == '0'){
            $signRsp = $array["sign"];
            $array["sign"] = "";
            $sign = $this->SignH5Array($array,C('SwiftScan.key'));

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