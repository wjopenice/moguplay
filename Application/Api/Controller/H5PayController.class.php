<?php
namespace Api\Controller;

class H5PayController extends BaseController
{

    //微信H5支付
    public function h5_Pay(){

        $data = $_POST;
        
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }
        //字段校验
        $msgArr = $this->parameter($data);

        //暂时强制转通道
        if($data['pay_way'] == 4){
        	//1
        	/*$test = array(5,6,8);//对这5个数建立数字索引数组，则索引值为0到4
			$i = rand(0,2);//随机生成一个0，到4之间的整形数字，包括0和4
        	$data['pay_type'] = $test[$i];	*/
            //$data['pay_type'] = 1;
            return array("status"=>'40018',"msg"=>"H5微信通道关闭!!!!");
            exit;
        }else if($data['pay_way'] == 5){
            $data['pay_type'] = 8;
        }
        
        if($msgArr['status'] == 0){
            $data['pay_ip'] = isset($data['pay_ip']) && $data['pay_ip'] ? $data['pay_ip'] :get_client_ip();
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

            $result = $deposit->add($deposit_data);
            //$result = ture;
            if($result){
                switch ($data['pay_type']) {
                    case 1:
                        $res = $this->beginVspPay($data);//通联
                        break;
                    case 4:
                        $res = $this->beginCshPay($data);//爱加密
                        break;
                    case 5:
                        $res = $this->beginOrnamentPay($data);//点缀
                        break;
                    case 6:
                        $res = $this->beginSwiftPay($data);//兴业
                        break;
                    case 8:
                        $res = $this->beginKjPay($data);//快接
                        break;
                    default:
                        $res = array("status"=>'40018',"msg"=>"支付通道错误");
                        break;
                }
                $this->assign('msgArr',$res);
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
        /*if(!$data['pay_ip']){
            return array("status"=>'40016',"msg"=>"IP为空");
            exit;
        }*/
        /*if(!$data['pay_type']){
            return array("status"=>'40018',"msg"=>"支付通道为空");
            exit;
        }
        if($data['pay_type'] != 4 && $data['pay_type'] != 1 && $data['pay_type'] != 5 && $data['pay_type'] != 6 && $data['pay_type'] != 8){
            return array("status"=>'40018',"msg"=>"支付通道错误");
            exit;
        }

        if($data['pay_type'] == 4 || $data['pay_type'] == 8){
            if($data['pay_way'] !=4 && $data['pay_way'] != 5){
                return array("status"=>'40017',"msg"=>"H5支付方式错误");
                exit;
            }
        } else {
            if($data['pay_way'] !=4){
                return array("status"=>'40017',"msg"=>"H5支付方式错误");
                exit;
            }
        }  
        */
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


    public function beginCshPay($data){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }
        fwrite($logFile, "\r\n\r\n");

        #支付配置
        $config["appKey"] = C('CSH.appKey');
        $config['bussOrderNum'] = $data['resqn'];
        $config["orderName"] = $data['body'] ? $data['body'] : "充值";
        $config["notifyUrl"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyCSH/notify";
        $config['returnUrl'] = isset($data['return_url']) ? $data['return_url'] : '';//"http://".$_SERVER['HTTP_HOST']."/media.php?s=/Member/personalcenter.html";
        $config["payMoney"] = $data['pay_amount'];
        $config["appType"] = isset($data['apptype']) && $data['apptype'] ? $data['apptype'] : "1";
        //$config["appType"] = $this->get_device_type();
        $config["ip"] = $data['pay_ip'];//get_client_ip();
        $config["payPlatform"] = $data['pay_way'] == 4 ? "2" : "1";
        if(isset($data['remark'])){
            $config["remark"] = $data['remark'];
        }       
        $config["sign"] = $this->SignH5Array($config,C('CSH.keyValue'));//签名
        
        ksort($config);
        $paramsStr = $this->ToUrlParams($config);
        $url = $data['pay_way'] == 4 ? C('CSH.apiUrl') : C('CSH.alipayApiUrl');

        return array("status"=>'0001',"url"=>$url."?paramStr=".urlencode($paramsStr));
        
    }

    public function beginVspPay($array)
    {
        //通道切换
        $pay_data = M('pay_interface','tab_')->where("pay_type=1 and wetch_status=1")->find();

        if($pay_data){
            $APPID = $pay_data['pay_appid'];
            $CUSID = $pay_data['pay_cusid'];
            $key = $pay_data['pay_appkey'];
        }else{
            return array("status"=>'40018',"msg"=>"暂未开通");
            exit;
        }

        #支付配置
        $data['reqsn'] = $array['resqn'];
        $data["cusid"] = $CUSID;
        $data["appid"] = $APPID;
        $data["version"] = C('vsp_H5.APIVERSION');
        $data["trxamt"] = $array['pay_amount']*100;//0.01*100;
        $data["randomstr"] = $this->getRandom();//
        $data["body"] = $array['body'] ? $array['body'] : "充值";
        $data["limit_pay"] = "no_credit";
        $data["notify_url"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyPF/notify";
        $data["apptype"] = $array['apptype'] ? $array['apptype'] : "Wap";
        $data["appname"] = $array['appname'] ? $array['appname'] : "手上支付";
        $data["apppackage"] = $array['apppackage'] ? $array['apppackage'] : "www.game-pk.com";
        $data["cusip"] = $array['pay_ip'];//$_SERVER['HTTP_HOST'];
        $data["paytype"] = 'W05';
                
        $data["sign"] = $this->SignArray($data,$key);//签名
        

        $paramsStr = $this->ToUrlParams($data);
        $url = C('vsp_H5.APIURL') . "/h5pay";
        $rsp = $this->request($url, $paramsStr);
        $rspArray = json_decode($rsp, true); 
        /*$rspArray = array(
            'appid' => "00018930",
            'cusid' => "55059304816M71R",
            'payinfo' => "https://wx.tenpay.com/cgi-bin/mmpayweb-bin/checkmweb?prepay_id=wx131144352244712f3d3b7c332601212275&package=3851110557",
            'reqsn' => "QD_20180413114420W3P5",
            'retcode' => "SUCCESS",
            'sign' => "1756CAD7E4B9CC9C7DCF81C3C750E295",
            'trxid' => "111804210000229023",
            'trxstatus' => "0000",
        );*/
        
        if($this->validSign($rspArray,$key)){
            return array("status"=>'0001',"url"=>$rspArray['payinfo']);
            /*$json_data = array(
                'resqn' => $rspArray['reqsn'],
                'payinfo' => $rspArray['payinfo'],
                'trxid' => $rspArray['trxid'],
                'status' => '0001',
                //'sign'      => isset($data['sign']) ? $data['sign'] : ''
            );
            $this->ajaxReturn($json_data);
            exit;*/
        }else{
            return array("status"=>'40010',"msg"=>"请求接口失败");
        }
    }

    public function beginSwiftPay($data){
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
        $config["device_info"] = isset($data['apptype']) && $data['apptype'] ? $data['apptype'] : "AND_WAP";
        $config["mch_app_name"] = isset($data['appname']) && $data['appname'] ? $data['appname'] : "手上科技";
        $config["mch_app_id"] = isset($data['apppackage']) && $data['apppackage'] ? $data['apppackage'] : "www.game-pk.com";
        $config["mch_create_ip"] = $data['pay_ip'];//get_client_ip();
        $config["nonce_str"] = $this->getRandom(32);     
        $config["sign"] = $this->SignSwiftArray($config,C('Swift.key'));//签名

        $paramsStr = $this->toXml($config);
        $url = C('Swift.url');
        $html_text = self::request($url, $paramsStr);

        //解析返回的xml
        /*$html_text = '<xml><charset><![CDATA[UTF-8]]></charset>
                      <mch_id><![CDATA[101500543265]]></mch_id>
                      <nonce_str><![CDATA[w686g4tk4vwsturbti922m61g35o6l0q]]></nonce_str>
                      <pay_info><![CDATA[https://statecheck.swiftpass.cn/pay/wappay?token_id=27639ffb423153e1c7b72ee793c3e9735&service=pay.weixin.wappayv2]]></pay_info>
                      <result_code><![CDATA[0]]></result_code>
                      <sign><![CDATA[D50ECF11616E5FD4868A9557A39A926C]]></sign>
                      <sign_type><![CDATA[MD5]]></sign_type>
                      <status><![CDATA[0]]></status>
                      <version><![CDATA[2.0]]></version>
                      </xml>';*/
        $rspArray = $this->xmlToArray($html_text);
        //验签
        if($this->SwiftvalidSign($rspArray)){
            return array("status"=>'0001',"url"=>$rspArray['pay_info']);

        }else{
            return array("status"=>'40010',"msg"=>"请求接口失败");
            exit;
        }

        
    }

    public function beginOrnamentPay($data){
        #支付配置
        $config['MerchantOrderNo'] = $data['resqn'];
        $config["AppId"] = C('Ornament.APPID');
        $config["Amount"] = $data['pay_amount'];
        $config["ProductName"] = $data['body'] ? $data['body'] : "充值";
        $config["NotifyUrl"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyOrnament/notify";
        $config['PayChannel'] = 1201;

        //$apptype = isset($data['apptype']) && $data['apptype'] ? $data['apptype'] : 'Wap';  
        //$appname = isset($data['appname']) && $data['appname'] ? $data['apptype'] : '手上科技';
        //$apppackage = isset($data['apppackage']) && $data['apppackage'] ? $data['apppackage'] : 'game-pk.com';
        
        $config['SceneInfo'] = "{\"h5_info\":{\"type\":\"Wap\",\"wap_url\":\"game-pk.com\",\"wap_name\":\"手上科技\"}}";
        $config["ReqDate"] = date("YmdHis");
        $config["ProductDescription"] = isset($data['remark']) && $data['remark'] ? $data['remark'] : '渠道充值';
              
        $config["Sign"] = $this->SignSwiftArray($config,C('Ornament.APPSECRET'),'Key');//签名

        $paramsStr = $this->ToUrlParams($config);
        $url = C('Ornament.APIURL').'/Order/ToPay';
        $response = self::request($url, $paramsStr);
        $rspArray = json_decode($response, true);
        /*$rspArray = array(
            'ToPayData' =>  'http://api.0592pay.com/WeChat/H5?ticket=e69d0c758a324d60aae75aca52710e53',
            'Status' =>  2,           
            'RespType' =>  0,           
            'RespCode' =>  '00',            
            'MerchantOrderNo' =>  'QD_20180416185142BMbJ',
            'PlatformOrderNo' =>  '0180416185202612887801',
            'ReqDate' =>  '20180416185202',
            'RespDate' =>  '20180416185203',
            'Sign' =>  '66963335CAE68CD52592441B91AB0181',
            'RespMessage' =>  '支付接口调用成功'
        );*/

        //验签
        if($this->OrnamentvalidSign($rspArray)){

            return array("status"=>'0001',"url"=>$rspArray['ToPayData']);

        }else{
            return array("status"=>'40010',"msg"=>"请求接口失败");
            exit;
        }
          
    }

    public function beginKjPay($data){

        //通道切换
        $where = "pay_type=8 and alipay_status=1";
        if($data['pay_way'] == 4){
            $where = "pay_type=8 and wetch_status=1";
        }
        $pay_data = M('pay_interface','tab_')->where($where)->find();

        if($pay_data){
            $APPID = $pay_data['pay_appid'];
            $key = $pay_data['pay_appkey'];
        }else{
            return array("status"=>'40018',"msg"=>"暂未开通");
            exit;
        }

        #支付配置
        $config['merchant_order_no'] = $data['resqn'];
        $config["merchant_no"] = $APPID;
        $config['start_time'] = date("YmdHis");
        $config["trade_amount"] = $data['pay_amount'];
        $config["goods_name"] = $data['body'] ? $data['body'] : "充值";
        $config["goods_desc"] = $data['body'] ? $data['body'] : "充值";
        $config["notify_url"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyKj/notify";
        $config['sign_type'] = '1';
        if($data['pay_way'] == 4){
            $config["user_ip"] = $data['pay_ip'];
            $config['pay_sence'] = "{\"h5_info\":{\"type\":\"Wap\",\"wap_url\":\"game-pk.com\",\"wap_name\":\"手上科技\"}}";
        }
              
        $config["sign"] = $this->SignKjArray($config,$key);//签名

        $paramsStr = $this->ToUrlParams($config);
        $url = C('Kj.url');
        $url = $data['pay_way'] == 4 ? $url."/wechar/wap_pay" : $url."/alipay/wap_pay";
        $response = self::request($url, $paramsStr);
        $rspArray = json_decode($response, true);
      
        /*$rspArray = array(
            'data' => array(
                'trade_no' => 'K201804251550084346294700',
                'pay_url' => 'http://api.kj-pay.com/gateway/index.html?sign=SzIwMTgwNDI1MTU1MDA4NDM0NjI5NDcwMA==',
                'sign' => '3a58d5012f5a61151d3a29b0edd94411',
            ),
            'info' => '支付请求完成',
            'status' => '1', 
        );*/

        //验签
        if($this->KjvalidSign($rspArray,$key)){

            return array("status"=>'0001',"url"=>$rspArray['data']['pay_url']);

        }else{
            return array("status"=>'40010',"msg"=>"请求接口失败");
            exit;
        }
          
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

    //验签
    function validSign($array,$key){
        if("SUCCESS"==$array["retcode"] && $array['trxstatus'] == '0000'){
            $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
            foreach ($array as $k => $val) {
               fwrite($logFile, $k."=".$val."\r\n");
            }
            $signRsp = strtolower($array["sign"]);
            $array["sign"] = "";
            $sign =  strtolower($this->SignArray($array, $key));
            fwrite($logFile, "\r\n\r\n");
            fclose($logFile);
            if($sign==$signRsp){
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        else{
            return FALSE;
        }

        return FALSE;
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

    //Swift验签
    function SwiftvalidSign($array){
        if("0" == $array["result_code"] && $array['status'] == '0'){
            $signRsp = $array["sign"];
            $array["sign"] = "";
            $sign = $this->SignSwiftArray($array,C('Swift.key'));

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

    //点缀验签
    function OrnamentvalidSign($array){
        if("0" == $array["RespType"] && $array['RespCode'] == '00'){
            $signRsp = $array["Sign"];
            $array["Sign"] = "";
            $sign = $this->SignSwiftArray($array,C('Ornament.APPSECRET'),'Key');

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

    /**
     * 将参数数组签名 H5组装
     */
    public function SignSwiftArray(array $array,$appkey,$key = 'key'){
        
        ksort($array);
        $blankStr = $this->ToUrlParams($array);
        $blankStr = $blankStr."&".$key."=".$appkey;// 将key放到数组中一起进行排序和组装

        $sign =  strtoupper(md5($blankStr));//大写
        return $sign;
    }

    /**
     * 将参数数组签名 H5组装
     */
    public function SignKjArray(array $array,$appkey){
        
        ksort($array);
        $blankStr = $this->ToUrlParams($array);
        $blankStr = $blankStr."&key=".$appkey;// 将key放到数组中一起进行排序和组装
        $sign =  md5($blankStr);
        return $sign;
    }

    //快接验签
    function KjvalidSign($array,$key){
        if($array['status'] == '1'){
            $signRsp = $array['data']["sign"];
            $array['data']["sign"] = "";
            $sign = $this->SignKjArray($array['data'],$key);
            
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

    /**
     * 将XML转为数组
     */
    function xmlToArray($xml){     //禁止引用外部xml实体    
        libxml_disable_entity_loader(true);    
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);    
        $array = json_decode(json_encode($xmlstring),true);    
        return $array;    
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

    function get_device_type() {  
        //全部变成小写字母  
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);  
        $type = '1'; 
        //分别进行判断  
        if(strpos($agent, 'iphone') || strpos($agent, 'ipad')) {  
            $type = '2';  
        }      
        if(strpos($agent, 'android')) {  
            $type = '1';  
        }  
        return $type; 
    } 


}