<?php
namespace Callback\Controller;

/**
 * 支付回调控制器 PF
 * @author 小纯洁 
 */
class NotifyPFController extends BaseController {


    const APPKEY = '2018Z0303B';
    const PANAPPKEY = '1234567890';

    public function _initialize(){
        $pay_data = M('pay_interface','tab_')->where("status=1")->find();
        define('APPKEY', $pay_data['pay_appkey']);
    }
    /**
    *通知方法
    */
    public function notify(){

        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/notifypf.txt", "a+");
        fwrite($logFile, "回调进来\r\n");
        fwrite($logFile, "\r\n\r\n");

        $params = array();
        foreach($_POST as $key=>$val) {//动态遍历获取所有收到的参数,此步非常关键,因为收银宝以后可能会加字段,动态获取可以兼容由于收银宝加字段而引起的签名异常
            $params[$key] = $val;
            fwrite($logFile, $key."=".$val."\r\n");
        }
        if(count($params)<1){//如果参数为空,则不进行处理

            fwrite($logFile, "参数为空\r\n");

        }else {
            //
            $order_info['trade_no'] = $params['chnltrxid'];
            $order_info['out_trade_no'] = $params['cusorderid'];

            $key = APPKEY;
            ///判断是H5还是扫码
            /*$type = M('promote_deposit','tab_')->where("pay_order_number='".$params['cusorderid']."'")->getField('pay_way');
            if($type == 4){
                $key = C('vsp_H5.APPKEY');
            }*/
            if($this->ValidSign($params, $key)){//验签成功

                $pay_where = substr($order_info['out_trade_no'],0,2);
                //此处进行业务逻辑处理
                switch($params["trxstatus"]){
                    case 2008:
                        fwrite($logFile, "[".$params["cusorderid"]."]--->交易处理中\r\n");
                        break;
                    case 3008:
                        fwrite($logFile, "[".$params["cusorderid"]."]--->余额不足\r\n");
                        break;
                    case 0000:
                        fwrite($logFile, "[".$params["cusorderid"]."]--->支付成功\r\n");
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
                        break;
                    default:
                        fwrite($logFile, "[".$params["cusorderid"]."]--->支付失败-->状态码".$params["trxstatus"]."\r\n");
                        break;
                }
                
                if($pay_where != 'PF'){
                    //回调次数
                    M('promote_deposit',"tab_")->where(array('pay_order_number' => $order_info['out_trade_no']))->setInc('notify_nums',1);

                    //将返回结果返回到商户的回调地址上边
                    //fwrite($logFile, "商户回调请求前");
                    $notify_nums = M('promote_deposit',"tab_")->where(array('pay_order_number' => $order_info['out_trade_no']))->getField('notify_nums');
                    if($notify_nums <= 3){
                        $re = $this->request($params,$type);
                        if($re == 'success'){
                            fwrite($logFile, "商户有返回：".$re."\r\n\r\n");
                            fwrite($logFile, "\r\n\r\n");
                            fclose($logFile);
                            echo "success";
                        }
                        fwrite($logFile, "商户无返回\r\n\r\n");
                    }else{
                        fwrite($logFile, "商户的回调次数：".$notify_nums."\r\n\r\n");
                        fwrite($logFile, "\r\n\r\n");
                        fclose($logFile);
                        echo "success";
                    }
                }else{
                    echo "success";
                }
            }else{
                fwrite($logFile, "[".$params["cusorderid"]."]--->验签失败\r\n");
            }

            fwrite($logFile, "\r\n\r\n");

        }

        fclose($logFile);

    }

    //发送请求操作仅供参考,不为最佳实践
    function request($params,$type){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/notifypf.txt", "a+");

        fwrite($logFile, "\r\n\r\n");

        fwrite($logFile, "[".$params["cusorderid"]."]--->查询回调前\r\n");

        $notify_url = M('promote_deposit','tab_')->where("pay_order_number = '" . $params['cusorderid']."'")->getField('notify_url');

        $is_key = M('promote_deposit','tab_')->where("pay_order_number = '" . $params['cusorderid']."'")->getField('is_key');

        $id = M('promote_deposit','tab_')->where("pay_order_number='".$params['cusorderid']."'")->getField('promote_id');

        $key = M('promote','tab_')->where("id=".$id)->getField('paykey');

        $account = M('promote','tab_')->where("id=".$id)->getField('account');
            
        
            
        $customer = array(
            'status' => $params["trxstatus"] == 0000 ? 200 : 201,
            'account' => $account,
            'resqn' => $params["cusorderid"],
            'trade_no' => $params['chnltrxid'],
            'pay_amount' => $params['trxamt'],
            'remark' => $params['trxreserved'],
        );
        if($is_key == 1){
            fwrite($logFile, "[".$notify_url."]--->查询回调后（验证）\r\n\r\n\r\n");
            $customer['mer_sign'] = $this->SignArray($customer,$key);
        }
        foreach($customer as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }
        if($notify_url) {
            $re = $this->send_post($notify_url,$customer);
        }
        fclose($logFile);
        return $re;
        
        
    }

    /*
   * url:访问路径
   * array:要传递的数组
   * */
    public static function curl_post($url,$array){
        $curl = curl_init();
        //设置提交的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        $post_data = $array;
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //print_r($data);exit;
        //获得数据并返回
        return $data;

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
        //$logFile = fopen(dirname(__FILE__)."/notifypf.txt", "a+");
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
        $logFile = fopen(dirname(__FILE__)."/notifypf.txt", "a+");

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
            $order_info['trade_no'] = $params['paymentOrderId'];//san
            $order_info['out_trade_no'] = $params['orderNo'];//me

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