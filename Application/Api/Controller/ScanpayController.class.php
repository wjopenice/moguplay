<?php
/**
 * Created by PhpStorm.
 * User: adminn
 * Date: 2018/4/13
 * Time: 17:05
 */
namespace Api\Controller;

class ScanpayController extends BaseController
{
    //const APPID = '00018339';
    //const APPID = '00018876';
    //const CUSID = '55059304816K14U';
    // const CUSID = '55059304816K9C0';
    const APPKEY = '2018Z0303B';
    const APIURL = "https://vsp.allinpay.com/apiweb/unitorder";//生产环境
    const APIVERSION = '11';

    //平台币充值记录
    public function begin_Pay(){
        $data = $_POST;
        /*$resqn = 'QD_'.date('Ymd').date ( 'His' ).sp_random_string(4);
        $data = [
           'account' => 'ZB1520821677',
           'resqn' => $resqn,
           'pay_amount' => 0.02,
           'paytype' => 'W01',
           'pay_type' => 9,
           'body' => '平台账号测试',
           'notify_url' => 'http://119.23.34.87/api.php?s=/Pay/beginPay.html',
        ];*/

        //打开日志log
        $data['is_key'] = isset($data['is_key']) ? $data['is_key'] : '';
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }

        //字段校验
        $msgArr = $this->parameter($data);
        //随机取通道
        $data = $this->randomType($data);

        if($msgArr['status'] == 0){
            $promote = $msgArr['promote'];

            $deposit = M("promote_deposit", "tab_");
            $deposit_data['order_number'] = "";
            $deposit_data['pay_order_number'] = $data['resqn'];
            $deposit_data['promote_id'] = $promote['id'];
            $deposit_data['promote_account'] = $data['account'];
            $deposit_data['pay_amount'] = $data['pay_amount'];
            $deposit_data['pay_status'] = 0;
            $deposit_data['pay_way'] = $data['paytype'] == 'A01' ? 1 : 2 ;
            $deposit_data['pay_source'] = 0;
            $deposit_data['is_key'] = $data['is_key'];
            $deposit_data['pay_ip'] = isset($data['pay_ip']) ? $data['pay_ip'] : '';
            $deposit_data['create_time'] = NOW_TIME;
            $deposit_data['notify_url'] = $data['notify_url'];
            $deposit_data['pay_type'] = $data['pay_type'];
            $result = $deposit->add($deposit_data);
            if($result){
                switch ($deposit_data['pay_type']) {
                    case 1:
                        $this->beginPay($data);
                        break;
                    case 2:
                        $this->ipsPay($data);
                        break;
                    case 5:
                        $this->OrnamentPay($data);
                        break;
                    case 6:
                        $this->SwiftPay($data);
                        break;
                   case 9:
                       $this->NowPay($data);
                       break;
                }
                //$this->ajaxReturn(array("status"=>'0001',"msg"=>"充值记录添加成功"));
                exit;
            }else{
                $this->ajaxReturn(array("status"=>'0002',"msg"=>"充值记录添加失败"));
                exit;
            }

        }else{
            $this->ajaxReturn($msgArr);
            exit;
        }
    }

    public function randomType($data){
        if($data['paytype'] == 'W01'){
            $pay_data = M('pay_interface','tab_')->where("status=1 and wetch_status=1")->group('pay_type')->select();
        }
        if($data['paytype'] == 'A01'){
            $pay_data = M('pay_interface','tab_')->where("status=1 and alipay_status=1")->group('pay_type')->select();
        }

        $arr_id = [];
        foreach($pay_data as $key=>$val){
            $arr_id[] = $val['pay_type'];
        }
        if(count($arr_id) <= 0){
            $data['pay_type'] = $arr_id[0];
        }else{
            $max = count($arr_id) - 1;

            $i = rand(0,$max);
            $data['pay_type'] = $arr_id[$i];
        }
        return $data;
    }

    /**
     *通联充值接口请求
     *@author whh
     */
    public function beginPay($data){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }

        fwrite($logFile, "\r\n\r\n");

        $pay_data = M('pay_interface','tab_')->where("status=1 and wetch_status=1 and alipay_status=1")->find();
        if($pay_data){
            $APPID = $pay_data['pay_appid'];
            $CUSID = $pay_data['pay_cusid'];
        }else{
            if($data['paytype'] == 'W01'){
                $pay_data = M('pay_interface','tab_')->where("status=1 and wetch_status=1")->find();
                $APPID = $pay_data['pay_appid'];
                $CUSID = $pay_data['pay_cusid'];
            }
            if($data['paytype'] == 'A01'){
                $pay_data = M('pay_interface','tab_')->where("status=1 and alipay_status=1")->find();
                $APPID = $pay_data['pay_appid'];
                $CUSID = $pay_data['pay_cusid'];
            }
        }

        #支付配置
        $config['reqsn'] = $data['resqn'];
        $config["cusid"] = $CUSID;
        $config["appid"] = $APPID;
        $config["version"] = self::APIVERSION;
        $config["trxamt"] = $data['pay_amount']*100;
        $config["randomstr"] = $this->getRandom();//随机字符串
        $config["body"] = $data['body'] ? $data['body'] : "渠道充值";
        $config['validtime'] = 10;
        $config['paytype'] = $data['paytype'];
        $config["acct"] = "";
        $config["limit_pay"] = "no_credit";
        $config["notify_url"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyPF/notify";

        $config["sign"] = $this->SignArray($config,self::APPKEY);//签名
        $paramsStr = $this->ToUrlParams($config);
        $url = self::APIURL . "/pay";

        $rsp = $this->request($url, $paramsStr);
        $rspArray = json_decode($rsp, true);
        if($this->validSign($rspArray)){
            $json_data = array(
                'resqn' => $rspArray['reqsn'],
                //'retcode' => $rspArray['retcode'],
                'payinfo' => $rspArray['payinfo'],
                'trxid' => $rspArray['trxid'],
                'body' => $data['body'] ? $data['body'] : "渠道充值",
                'trxstatus' => $rspArray['trxstatus'],
                'sign'      => isset($data['sign']) ? $data['sign'] : ''
            );
            $this->ajaxReturn($json_data);
            exit;
        }else{
            $this->ajaxReturn(array("status"=>'40010',"msg"=>"请求接口失败"));
            exit;
        }
    }

    /**
     *环讯充值接口请求
     *@author whh
     */
    public function ipsPay($data){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }

        fwrite($logFile, "\r\n\r\n");

        #支付配置
        $config['MsgId'] = "0001";//消息编号

        $config["ReqDate"] = date("YmdHis",time()+0);
        $config["appid"] = APPID;
        $config["version"] = self::APIVERSION;
        $config["trxamt"] = $data['pay_amount']*100;
        $config["randomstr"] = $this->getRandom();//随机字符串
        $config["body"] = $data['body'] ? $data['body'] : "渠道充值";
        $config['validtime'] = 10;
        $config['paytype'] = $data['paytype'];
        $config["acct"] = "";
        $config["limit_pay"] = "no_credit";
        $config["notify_url"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyPF/notify";

        $config["sign"] = $this->SignArray($config,APPKEY);//签名
        $paramsStr = $this->ToUrlParams($config);
        $url = self::APIURL . "/pay";

        $rsp = $this->request($url, $paramsStr);
        $rspArray = json_decode($rsp, true);
        if($this->validSign($rspArray)){
            $json_data = array(
                'resqn' => $rspArray['reqsn'],
                //'retcode' => $rspArray['retcode'],
                'payinfo' => $rspArray['payinfo'],
                'trxid' => $rspArray['trxid'],
                'body' => $data['body'] ? $data['body'] : "渠道充值",
                'trxstatus' => $rspArray['trxstatus'],
                'sign'      => isset($data['sign']) ? $data['sign'] : ''
            );
            $this->ajaxReturn($json_data);
            exit;
        }else{
            $this->ajaxReturn(array("status"=>'40010',"msg"=>"请求接口失败"));
            exit;
        }
    }

    //（威富通）扫码支付
    public function SwiftPay($data,$timeOut = 30){

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
        $config["sign"] = $this->SwiftSignArray($config,C('SwiftScan.key'),1);//签名

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
        foreach($rspArray as $key=>$val) {
            fwrite($logFile, $key."=".$val."\r\n");
        }
        //验签
        if($this->SwiftValidSign($rspArray)){
            $json_data = array(
                'resqn' => $rspArray['transaction_id'],
                //'retcode' => $rspArray['retcode'],
                'payinfo' => $rspArray['code_url'],
                'trxid' => $rspArray['out_transaction_id'],
                'body' => $data['body'] ? $data['body'] : "渠道充值",
                'trxstatus' => $rspArray['status'] == '0' ? '0000' : '10001',
                'sign'      => isset($data['sign']) ? $data['sign'] : ''
            );
            return $this->ajaxReturn($json_data);

        }else{
            $this->ajaxReturn(array("status"=>'40010',"msg"=>"请求接口失败"));
            exit;
        }

    }

    //点缀支付
    public function OrnamentPay($data,$timeOut = 30){
        if($data['paytype'] == 'W01'){
            $PayChannel = 1202;
        }
        if($data['paytype'] == 'A01'){
            $this->ajaxReturn(array("status"=>'40017',"msg"=>"请选择正确的支付方式"));
            exit;
        }
        #支付配置
        $config['MerchantOrderNo'] = $data['resqn'];
        $config["AppId"] = C('Ornament.APPID');
        $config["Amount"] = $data['pay_amount'];
        $config["ProductName"] = $data['body'] ? $data['body'] : "充值";
        $config["NotifyUrl"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyOrnament/notify";
        $config['PayChannel'] = $PayChannel;
        $config["ReqDate"] = date("YmdHis");
        $config["ProductDescription"] = isset($data['remark']) && $data['remark'] ? $data['remark'] : '渠道充值';

        $config["Sign"] = $this->SwiftSignArray($config,C('Ornament.APPSECRET'),2);//签名

        $paramsStr = $this->ToUrlParams($config);
        $url = C('Ornament.APIURL').'/Order/ToPay';
        $response = self::request($url, $paramsStr);
        $rspArray = json_decode($response, true);

        //验签
        if($this->OrnamentValidSign($rspArray)){
            $json_data = array(
                'resqn' => $rspArray['MerchantOrderNo'],
                //'retcode' => $rspArray['RespCode'],
                'payinfo' => $rspArray['QRCodeUrl'],
                'trxid' => $rspArray['PlatformOrderNo'],
                'body' => $data['body'] ? $data['body'] : "渠道充值",
                'trxstatus' => $rspArray['RespCode'] == '00' ? '0000' : '10001',
                'sign'      => isset($data['sign']) ? $data['sign'] : ''
            );
            return $this->ajaxReturn($json_data);
            //return $rspArray['QRCodeUrl'];
        }else{
            $this->ajaxReturn(array("status"=>'40010',"msg"=>"请求接口失败"));
            exit;
        }

    }

    //现在支付
    public function NowPay($data,$timeOut = 30){
        if($data['paytype'] == 'W01'){
            $PayChannel = 13;
        }
        if($data['paytype'] == 'A01'){
            $PayChannel = 12;
        }
        $AppId = C('Now.appid');
        $AppKey = C('Now.appkey');
        #支付配置
        $config["appId"] = $AppId;
        $config['funcode'] = 'WP001';
        $config['mhtOrderNo'] = $data['resqn'];
        $config['mhtOrderName'] = $data['body'] ? $data['body'] : "充值";
        $config['mhtOrderType'] = '01';
        $config['mhtCurrencyType'] = '156';
        $config["mhtOrderAmt"] = $data['pay_amount'] * 100;
        $config["mhtOrderDetail"] = isset($data['remark']) && $data['remark'] ? $data['remark'] : '渠道充值';
        $config["mhtOrderStartTime"] = date("YmdHis");
        $config["notifyUrl"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php";
        //$config['frontNotifyUrl'] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyNow/notify";
        //$config["notifyUrl"] ='www.baidu.com'; 
        $config['mhtCharset'] = 'UTF-8';
        $config['deviceType'] = '08';
        $config['payChannelType'] = $PayChannel;
        $config['mhtReserved'] = 'test';
        $config['mhtSignType'] = 'MD5';
        $config['version'] = '1.0.0';
        $config['outputType'] = '1';

        $config["mhtSignature"] = $this->NowSignArray($config,$AppKey);//签名
        ksort($config);
        $paramsStr = $this->ToUrlParams($config);

        $url = C('Now.url');
        $response = self::request($url, $paramsStr);
        //$response = "responseCode=A001&tn=weixin%3A%2F%2Fwxpay%2Fbizpayurl%3Fpr%3DW0QpgSb&appId=151385022206629&mhtOrderNo=QD_201805021715460frs&signType=MD5&nowPayOrderNo=200301201805021716509166942&responseMsg=E000%23%E6%88%90%E5%8A%9F%5B%E6%88%90%E5%8A%9F%5D&funcode=WP001&signature=30dfeecacca3a25b4f9e28a41a7d92d9&responseTime=20180502171651&version=1.0.0";
        if($response){
            $response = explode('&', $response);
            foreach ($response as $key => $value) {
                $rsparr = explode('=', $value);
                $rspArray[$rsparr[0]] = urldecode($rsparr[1]);
            }

            //验签
            if($this->NowValidSign($rspArray,$AppKey)){
                $json_data = array(
                    'resqn' => $rspArray['mhtOrderNo'],
                    //'retcode' => $rspArray['RespCode'],
                    'payinfo' => $rspArray['tn'],
                    'trxid' => $rspArray['nowPayOrderNo'],
                    'body' => "渠道充值",
                    'trxstatus' => $rspArray['responseCode'] == 'A001' ? '0000' : '10001',
                    'sign'      => isset($data['sign']) ? $data['sign'] : ''
                );
                return $this->ajaxReturn($json_data);
            }else{
                $this->ajaxReturn(array("status"=>'40010',"msg"=>"请求接口失败"));
                exit;
            }

        }else{
            $this->ajaxReturn(array("status"=>'40010',"msg"=>"请求接口失败 返回为空"));
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

    /**
     * 兴业(威富通)和点缀 将参数数组签名
     */
    public function SwiftSignArray(array $array,$appkey,$class){
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        fwrite($logFile,"将参数数组签名");
        foreach ($array as $k => $val) {
            fwrite($logFile, $k."=".$val."\r\n");
        }
        //签名步骤一：按字典序排序参数
        ksort($array);
        if($class == 1){
            $blankStr = $rr = $this->ToUrlParams($array);
            $blankStr = $blankStr."&key=".$appkey;// 将key放到数组中一起进行排序和组装

            $sign =  strtoupper(md5($blankStr));//大写
        }
        if($class == 2){
            $blankStr = $this->ToUrlParams($array);
            //签名步骤二：在string后加入KEY 将key放到数组中一起进行排序和组装
            $blankStr = $blankStr."&Key=".$appkey;
            //签名步骤三：MD5加密
            $blankStr = md5($blankStr);
            //签名步骤四：所有字符转为大写
            $sign = strtoupper($blankStr);
        }
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

    //通联验签
    function validSign($array){
        if("SUCCESS"==$array["retcode"] && $array['trxstatus'] == '0000'){
            $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
            foreach ($array as $k => $val) {
                fwrite($logFile, $k."=".$val."\r\n");
            }
            $signRsp = strtolower($array["sign"]);
            $array["sign"] = "";
            $sign =  strtolower($this->SignArray($array, self::APPKEY));
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

    //兴业(威富通)验签
    function SwiftValidSign($array){
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach ($array as $k => $val) {
            fwrite($logFile, $k."=".$val."\r\n");
        }
        if("0" == $array["result_code"] && $array['status'] == '0'){
            $signRsp = $array["sign"];
            $array["sign"] = "";
            $sign = $this->SwiftSignArray($array,C('SwiftScan.key'),1);

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
    function OrnamentValidSign($array){
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        fwrite($logFile,"回调后参数");
        foreach ($array as $k => $val) {
            fwrite($logFile, $k."=".$val."\r\n");
        }
        if("0" == $array["RespType"] && $array['RespCode'] == '00'){
            $signRsp = $array["Sign"];
            unset($array["Sign"]);
            fwrite($logFile,"回调后验签参数");
            foreach ($array as $k => $val) {
                fwrite($logFile, $k."=".$val."\r\n");
            }
            $sign = $this->SwiftSignArray($array,C('Ornament.APPSECRET'),2);
            fwrite($logFile, "sign = ".$sign."\r\n");
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
     * 现在支付
     */
    public function NowSignArray(array $array,$appkey){
        if( !empty($array) ) {
            ksort($array);    
            $str = '';
            foreach( $array as $k => $v) {
                if( $v == '' || $k == 'signature') {
                    continue;
                }
                $str .= $k.'='.$v.'&';
            }
            return strtolower(md5($str.md5($appkey)));
            
        }
        return false;
    }


    //现在支付 验签
    function NowValidSign($array,$key){
        if($array['responseCode'] == 'A001') {
            $signRsp = $array["signature"];

            $sign = $this->NowSignArray($array,$key);

            if($sign == $signRsp){
                return TRUE;
            }
            else {
                return FALSE;
            }
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

    //环讯验签
    function verifyGlobReturn($param)
    {
        try {

            $xmlResult = new SimpleXMLElement($param);
            $strSignature = $xmlResult->GateWayRsp->head->Signature;

            $strBody = subStrXml("<body>", "</body>", $param);

            if (md5Verify($strBody, $strSignature, self::MERCODE, self::MERCERT)) {
                return true;
            } else {
                echo "扫码支付返回报文验签失败:" . $param;
                //Log::DEBUG("扫码支付返回报文验签失败:" . $param);
                return false;
            }
        } catch (Exception $e) {
            echo "异常:" . $e;
            //Log::ERROR("异常:" . $e);
        }
        return false;
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
//        if(!$data['pay_ip']){
//            return array("status"=>'40016',"msg"=>"IP为空");
//            exit;
//        }
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




}
