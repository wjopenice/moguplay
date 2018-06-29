<?php
namespace Callback\Controller;

/**
 * 支付回调控制器 GLOB
 * @author
 */
class GlobController extends BaseController {


    const MSGID = '0001';
    const MERCODE = '207575';
    const MERNAME = '广州手上科技有限公司';
    const ACCOUNT = '2075750014';
    const LANG = 'GB';
    const APIURL = "https://thumbpay.e-years.com/psfp-webscan/services/scan?wsdl";
    const MERCERT = 'ykorm6Gh3UTcAeJZoBYUO2UApGYF25FHJRey42G6JY8kVwrY6LLKX20a0fsYC91YSWzG16e6OE3mNqXbSWAQa7Mykvz4kM38fPLL6u6w643LFw6Kd0zc2avua9HRhfEt';
//
//    public function _initialize(){
//        $pay_data = M('pay_interface','tab_')->where("status=1")->find();
//        define('APPKEY', $pay_data['pay_appkey']);
//    }
    /**
    *环讯通知方法
    */
    public function notify(){

        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/glob.txt", "a+");
        fwrite($logFile, "回调进来\r\n");

        $params = $_REQUEST['paymentResult'];
        $order_info['trade_no'] = $params['IpsBillNo'];//在环讯的唯一编号
        $order_info['out_trade_no'] = $params['MerBillNo'];//商户订单号

        if($this->verifyReturn()){//验签成功
            //此处进行业务逻辑处理
            switch($params["Status"]){
                case 'P':
                    fwrite($logFile, "[".$params["MerBillNo"]."]--->交易处理中\r\n");
                    break;
                case 'Y':
                    fwrite($logFile, "[".$params["MerBillNo"]."]--->支付成功\r\n");
                    $result = $this->set_promoteDeposit($order_info);
                    break;
                default:
                    fwrite($logFile, "[".$params["MerBillNo"]."]--->支付失败-->状态码".$params["Status"]."\r\n");
                    break;
            }

            foreach($params as $k=>$v){
                fwrite($logFile, $k."=".$v."\r\n");
            }

            //将返回结果返回到商户的回调地址上边
            //fwrite($logFile, "商户回调请求前");
            $this->request($params);

            fclose($logFile);
            echo "ipscheckok";
        }else{
            fwrite($logFile, "[".$params["MerBillNo"]."]--->验签失败\r\n");
        }
        fwrite($logFile, "\r\n\r\n");
    }

    //发送请求操作仅供参考,不为最佳实践
    function request($params){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/glob.txt", "a+");

        fwrite($logFile, "[".$params["cusorderid"]."]--->查询回调前\r\n");

        $notify_url = M('promote_deposit','tab_')->where("pay_order_number = '" . $params['cusorderid']."'")->getField('notify_url');

        $id = M('promote_deposit','tab_')->where("pay_order_number='".$params['cusorderid']."'")->getField('promote_id');

        $key = M('promote','tab_')->where("id=".$id)->getField('paykey');

        $account = M('promote','tab_')->where("id=".$id)->getField('account');
            

        fwrite($logFile, "[".$notify_url."]--->查询回调后（验证）\r\n");

        $params['account'] = $account;
        $params['mer_sign'] = $this->SignArray($params,$key);
        foreach($params as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }
        if($notify_url) {
            $this->send_post($notify_url,$params);
            fclose($logFile);
        }else{
            fclose($logFile);
        }
    }

    /**
     * 发送post请求
     * @param string $url 请求地址
     * @param array $post_data post键值对数据
     * @return string
     */
    function send_post($url, $post_data){

        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }

    //环讯验签
    public function verifyReturn(){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/glob.txt", "a+");
        try {
            if(empty($_REQUEST)) {
                return false;
            }
            else {
                $paymentResult = $_REQUEST['paymentResult'];
                fwrite($logFile, "扫码支付成功返回报文\r\n". $paymentResult);

                $xmlResult = new \SimpleXMLElement($paymentResult);
                $strSignature = $xmlResult->GateWayRsp->head->Signature;

                $strRspCode = $xmlResult->GateWayRsp->head->RspCode;

                if($strRspCode == "000000"){
                    $strStatus = $xmlResult->GateWayRsp->body->Status;
                    if($strStatus == "Y"){
                        $strBody = $this->subStrXml("<body>","</body>",$paymentResult);
                        if($this->md5Verify($strBody,$strSignature,self::MERCODE,self::MERCERT)){
                            return true;
                        }else{
                            fwrite($logFile, "扫码支付返回报文验签失败\r\n");
                            return false;
                        }
                    }else{
                        $strRspMsg = $xmlResult->GateWayRsp->head->RspMsg;
                        fwrite($logFile, "扫码支付失败\r\n". $strRspMsg);
                        return false;
                    }
                }else{
                    return false;
                }
            }
        } catch (Exception $e) {
            fwrite($logFile, "异常\r\n". $e);
        }
        return false;
    }

    /**
     * 验证签名
     * @param $prestr 需要签名的字符串
     * @param $sign 签名结果
     * @param $merCode 商戶號
     * @param $key 私钥
     * return 签名结果
     */
    public function md5Verify($prestr, $sign,$merCode, $key) {
        $prestr = $prestr .$merCode. $key;
        $mysgin = md5($prestr);

        if($mysgin == $sign) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * php截取<body>和</body>之間字符串
     * @param string $begin 开始字符串
     * @param string $end 结束字符串
     * @param string $str 需要截取的字符串
     * @return string
     */
    public function subStrXml($begin,$end,$str){
        $b= (strpos($str,$begin));
        $c= (strpos($str,$end));

        return substr($str,$b,$c-$b + strlen($end));
    }

    /**
     * 校验签名
     * @param array 参数
     * @param unknown_type appkey
     */
    public function ValidSign(array $array,$appkey){
        $sign = $array['sign'];
        unset($array['sign']);
        $array['key'] = $appkey;
        $mySign = $this->SignArray($array, $appkey);
        //打开日志log
        //$logFile = fopen(dirname(__FILE__)."/log3.txt", "a+");
        //fwrite($logFile, "回调时签名:".$mySign."\r\n"."原来的签名".$sign."\r\n");

        return strtolower($sign) == strtolower($mySign);
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

    public function PanValidSign(array $array,$appkey){
        $sign = $array['signMsg'];
        unset($array['signMsg']);
        //新的key
        $array['key'] = $appkey;
        $blankStr = $this->ToUrlParams($array);
        $mySign = strtoupper(md5($blankStr));  
        
        //return $mySign;
        return strtolower($sign) == strtolower($mySign);
    }

    public function PanValidSignKey(array $array){
        $sign = $array['signMsg'];
        unset($array['signMsg']);
        //新的key
        $blankStr = $this->ToUrlParams($array);

        //Vendor('phpseclib.File.X509');
        $certfile = file_get_contents(VENDOR_PATH.'phpseclib/TLCert-test.cer');
        $x509 = new \File_X509();
        $cert = $x509->loadX509($certfile);
        $pubkey = $x509->getPublicKey();
        $rsa = new \Crypt_RSA();
        $rsa->loadKey($pubkey); // public key
        $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
        
        return $rsa->verify($blankStr, base64_decode(trim($sign)));

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


    function wite_text($txt,$name){
        $myfile = fopen($name, "w") or die("Unable to open file!");
        fwrite($myfile, $txt);
        fclose($myfile);
    }



    //网银的回调
    function pan_notify(){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/log.txt", "a+");

        $params = array();
        fwrite($logFile, json_encode($_POST)."\r\n");
        //顺序
        $_POST["merchantId"] != "" ? $params['merchantId'] = $_POST["merchantId"] : '';
        $_POST['version'] != "" ? $params['version'] = $_POST['version'] : '';
        $_POST['language'] != "" ? $params['language'] = $_POST['language'] : '';
        $_POST['signType'] != "" ? $params['signType'] = $_POST['signType'] : '';
        $_POST['payType'] != "" ? $params['payType'] = $_POST['payType'] : '';
        $_POST['issuerId'] != "" ? $params['issuerId'] = $_POST['issuerId'] : '';
        $_POST['paymentOrderId'] != "" ? $params['paymentOrderId'] = $_POST['paymentOrderId'] : '';
        $_POST['orderNo'] != "" ? $params['orderNo'] = $_POST['orderNo'] : '';
        $_POST['orderDatetime'] != "" ? $params['orderDatetime'] = $_POST['orderDatetime'] : '';
        $_POST['orderAmount'] != "" ? $params['orderAmount'] = $_POST['orderAmount'] : '';
        $_POST['payDatetime'] != "" ? $params['payDatetime'] = $_POST['payDatetime'] : '';
        $_POST['payAmount'] != "" ? $params['payAmount'] = $_POST['payAmount'] : '';
        $_POST['ext1'] != "" ? $params['ext1'] = $_POST['ext1'] : '';
        $_POST['ext2'] != "" ? $params['ext2'] = $_POST['ext2'] : '';
        $_POST['payResult'] != "" ? $params['payResult'] = $_POST['payResult'] : '';
        $_POST['errorCode'] != "" ? $params['errorCode'] = $_POST['errorCode'] : '';
        $_POST['returnDatetime'] != "" ? $params['returnDatetime'] = $_POST['returnDatetime'] : '';
        $_POST["signMsg"] != "" ? $params['signMsg'] = $_POST["signMsg"] : '';
            
        
        /*$u = '{"payResult":"1","orderNo":"PF_20180315165437zUjk","version":"v1.0","returnDatetime":"20180315165330","orderDatetime":"20180315103703","payAmount":"1","orderAmount":"1","payType":"0","merchantId":"100020091218001","paymentOrderId":"201803151649092687","signType":"0","signMsg":"B72D9264FF3FAA63106F0B6F9218DF70","payDatetime":"20180315164927"}';
        $u = '{"merchantId":"100020091218001","version":"v1.0","signType":"1","payType":"0","paymentOrderId":"201803161510323022","orderNo":"PF_20180316151555GFu1","orderDatetime":"20180316031555","orderAmount":"1","payDatetime":"20180316151056","payAmount":"1","payResult":"1","returnDatetime":"20180316151459","signMsg":"HM2hT20vuZUGSJUv+OXXxT2xHUA4NAY68uQk+VSs1KD9L6qodLvA1h\/7SdIWYzjBZNRZu+SZgDO0pbu+Ej+IJosXUGTM3iOOlOov3UmVTdnveJ9OjVZqFchgTfRDUSr07Wd7SoEufgDDrNbXVGJ0x5jl5azRaFentkTg7soE7sc="}';
        $params = json_decode($u,ture);*/
        
        fwrite($logFile, json_encode($params)."\r\n");
        if(count($params)<1){//如果参数为空,则不进行处理

            fwrite($logFile, "参数为空\r\n");

        }else {
            //
            $order_info['trade_no'] = $params['paymentOrderId'];
            $order_info['out_trade_no'] = $params['orderNo'];

            //var_dump($this->PanValidSignKey($params));exit;
            if($params['signType'] == 1){
                $re = $this->PanValidSignKey($params);
            }else{
                $re = $this->PanValidSign($params, self::PANAPPKEY);
            }
            if($re){//验签成功
                $pay_where = substr($order_info['out_trade_no'],0,2);

                if ($params["payResult"] == 1) {
                    fwrite($logFile, "[".$params["merchantId"]."]--->支付成功\r\n");
                    switch ($pay_where) {
                        case 'SP':
                            $result = $this->set_spend($order_info);
                            break;
                        case 'PF':
                            $result = $this->set_deposit($order_info);
                            break;
                        case 'AG':
                            $result = $this->set_agent($order_info); 
                            break;
                        case 'QD':
                            $result = $this->set_promoteDeposit($order_info);
                            break;
                        default:
                            exit('accident order data');
                            break;
                    }
                }else{
                    fwrite($logFile, "[".$params["merchantId"]."]--->支付失败"."\r\n");
                }
            
                foreach($params as $k=>$v){
                    fwrite($logFile, $k."=".$v."\r\n");
                }
            }else{
                fwrite($logFile, "[".$params["merchantId"]."]--->验签失败\r\n");
            }
        }

        fwrite($logFile, "\r\n\r\n");
        fclose($logFile);
        echo "success";
    }


}