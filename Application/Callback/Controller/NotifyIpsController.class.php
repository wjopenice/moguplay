<?php
namespace Callback\Controller;

/**
 * 支付回调控制器 PF
 * @author 
 */
class NotifyIpsController extends BaseController {
    //商户号
    const MerCode = "207575";//207973   207575
    //key
    const Key = "ykorm6Gh3UTcAeJZoBYUO2UApGYF25FHJRey42G6JY8kVwrY6LLKX20a0fsYC91YSWzG16e6OE3mNqXbSWAQa7Mykvz4kM38fPLL6u6w643LFw6Kd0zc2avua9HRhfEt";
    //X12DYVzevDOVmFpYopdMQVwdG2pKg8MtycWHxTvZ5gNNlJe8AAeTP4X4t1NdZuOOrlDRDWHvy6FfH5cAcUF5dH15BESxdLRmQ8KQlNJN2TU4Oyvz8qXpds3hymjjJMSp 堡庆
    //ykorm6Gh3UTcAeJZoBYUO2UApGYF25FHJRey42G6JY8kVwrY6LLKX20a0fsYC91YSWzG16e6OE3mNqXbSWAQa7Mykvz4kM38fPLL6u6w643LFw6Kd0zc2avua9HRhfEt  手上

    /**
    *通知方法
    */
    public function notify(){

        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/glob.txt", "a+");
        fwrite($logFile, "IPS------------\r\n");
        fwrite($logFile, json_encode($_REQUEST)."\r\n");
        

        if(!empty($_REQUEST)){
            $paymentResult = $_REQUEST['paymentResult'];
            $payment = $this->xmlToArray($paymentResult);

            $xmlResult = new \SimpleXMLElement($paymentResult);
            $strSignature = $xmlResult->GateWayRsp->head->Signature;

            $strRspCode = $xmlResult->GateWayRsp->head->RspCode;

            if($strRspCode == "000000")
            {
                //订单号
                $order_info['trade_no'] = $payment['GateWayRsp']['body']['IpsBillNo'];
                $order_info['out_trade_no'] = $payment['GateWayRsp']['body']['MerBillNo'];
                $order_info['status'] = $payment['GateWayRsp']['body']['Status'];
                $order_info['amount'] = $payment['GateWayRsp']['body']['Amount'];
                foreach ($order_info as $k=>$v){
                    fwrite($logFile, $k."=".$v."\r\n");
                    fwrite($logFile, "\r\n\r\n");
                }
                fwrite($logFile, "\r\n\r\n");
                //订单状态
                $strStatus = $xmlResult->GateWayRsp->body->Status;
                if ($strStatus == "Y") {
                    fwrite($logFile, "[".$order_info['out_trade_no']."]--->支付成功\r\n");

//                    $strSignature = $xmlResult->GateWayRsp->head->Signature;
//                    $strBody = $this->subStrXml("<body>","</body>",$params);
                    $strBody = $this->subStrXml("<body>","</body>",$paymentResult);
                    if(md5Verify($strBody,$strSignature,self::MerCode,self::Key)){
                        $pay_where = substr($order_info['out_trade_no'],0,2);
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

                        //回调次数
                        $where =  "pay_order_number='".$order_info['out_trade_no']."'";
                        M('promote_deposit',"tab_")->where($where)->setInc('notify_nums',1);

                        //将返回结果返回到商户的回调地址上边
                        //fwrite($logFile, "商户回调请求前");
                        $notify_nums = M('promote_deposit',"tab_")->where($where)->getField('notify_nums');
                        if($notify_nums <= 3){
                            $re = $this->request($order_info);
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
                        fclose($logFile);
                        echo "ipscheckok";
                    }else{
                        fwrite($logFile, "扫码支付返回报文验签失败"."\r\n\r\n");
                        return false;
                    }
                }else{
                    fwrite($logFile, "[".$order_info['out_trade_no']."]--->交易状态：".$strStatus."\r\n");
                    fclose($logFile);
                }
            }else{
                fwrite($logFile, "请求异常：rspCode：".$strRspCode."\r\n\r\n");
            }
        }else{
            fwrite($logFile, "参数为空\r\n\r\n");
        }
    }

    //发送请求操作仅供参考,不为最佳实践
    function request($params){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/glob.txt", "a+");

        fwrite($logFile, "\r\n\r\n");

        fwrite($logFile, "[".$params["out_trade_no"]."]--->查询回调前\r\n");

        $notify_url = M('promote_deposit','tab_')->where("pay_order_number = '" . $params['out_trade_no']."'")->getField('notify_url');

        $id = M('promote_deposit','tab_')->where("pay_order_number='".$params['out_trade_no']."'")->getField('promote_id');

        $key = M('promote','tab_')->where("id=".$id)->getField('paykey');

        $account = M('promote','tab_')->where("id=".$id)->getField('account');

        fwrite($logFile, "[".$notify_url."]--->查询回调后（不验证）\r\n");
        fwrite($logFile, "\r\n\r\n");
        $customer = array(
            'status' => $params["status"] == 'Y' ? 200 : 201,
            'account' => $account,
            'resqn' => $params["out_trade_no"],
            'trade_no' => $params['trade_no'],
            'pay_amount' => $params['amount'],
            'remark' => '渠道充值',
        );
        $customer['mer_sign'] = $this->SignArray($customer,$key);
        if($notify_url) {
            $re = $this->send_post($notify_url,$customer);
            fclose($logFile);
        }else{
            fclose($logFile);
        }
            return $re;

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
     * 发送post请求
     * @param string $url 请求地址
     * @param array $post_data post键值对数据
     * @return string
     */
    function send_post($url, $post_data){
        $logFile = fopen(dirname(__FILE__)."/glob.txt", "a+");
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
        foreach ($post_data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
            fwrite($logFile, "\r\n\r\n");
        }
        $result = file_get_contents($url, false, $context);

        return $result;
    }


    /**
     * php截取<body>和</body>之間字符串
     * @param string $begin 开始字符串
     * @param string $end 结束字符串
     * @param string $str 需要截取的字符串
     * @return string
     */
    function subStrXml($begin,$end,$str){
        $b= (strpos($str,$begin));
        $c= (strpos($str,$end));

        return substr($str,$b,$c-$b + strlen($end));
    }


    //网银的回调
    function pan_notify(){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/log.txt", "a+");
        fwrite($logFile, json_encode($_REQUEST)."\r\n");
        
        //
        if($params = $_REQUEST){
            foreach($params as $k=>$v){
                fwrite($logFile, $k."=".$v."\r\n");
            }
            //$xmlResult = new \SimpleXMLElement($params);
            $rspCode = $params['GateWayRsp']['heda']['RspCode'];
            //$rspCode = $xmlResult->GateWayRsp->head->RspCode;

            if($rspCode == "000000")
            {
                $strSignature = $params['GateWayRsp']['heda']['Signature'];
                $strBody = $this->subStrXml("<body>","</body>",$params);

                //订单号
                $order_info['trade_no'] = $params['GateWayRsp']['body']['IpsBillNo'];
                $order_info['out_trade_no'] = $params['GateWayRsp']['body']['MerBillNo'];

                if(md5Verify($strBody,$strSignature,C('Ips.MerCode'),C('Ips.MerCert'))){
                    //订单状态
                    $status = $params['GateWayRsp']['body']['Status'];

                    $pay_where = substr($order_info['out_trade_no'],0,2);
                    if ($status == "Y") {
                        fwrite($logFile, "[".$order_info['out_trade_no']."]--->支付成功\r\n");
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
                        fclose($logFile);
                        echo "ipscheckok";
                    }else{
                        fwrite($logFile, "[".$order_info['out_trade_no']."]--->交易状态：".$status."\r\n");
                        fclose($logFile);
                    }
                    
                }else{
                    fwrite($logFile, "[".$order_info['out_trade_no']."]--->支付返回报文验签失败\r\n\r\n");
                }
            }else{
                fwrite($logFile, "请求异常：rspCode：".$rspCode."\r\n\r\n");
            }
            
        }else{
            fwrite($logFile, "参数为空\r\n\r\n");
        }
        fclose($logFile);
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


}