<?php
namespace Callback\Controller;

/**
 * 支付回调控制器 Swift
 * @author 小纯洁 
 */
class NotifySwiftController extends BaseController {


    /**
    *H5通知方法
    */
    public function notify(){

        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/log.txt", "a+");
        fwrite($logFile, "回调进来\r\n\r\n\r\n");

        $xml = file_get_contents('php://input');
        fwrite($logFile, "xml".$xml."\r\n\r\n\r\n");
        $params = $this->xmlToArray($xml);
        foreach($params as $key=>$val) {
            fwrite($logFile, $key."=".$val."\r\n");
        }
        /*$params = [
            'bank_type' => 'CFT',
            'charset' => 'UTF-8',
            'fee_type' => 'CNY',
            'is_subscribe' => 'N',
            'mch_id' => '7551000001',
            'nonce_str' => '1466604235945',
            'openid' => 'osMSktyXBAh-UsWAqzjgBwzkjA3E',
            'out_trade_no' => '004942637492556',
            'out_transaction_id' => '400045200120160622772118533',
            'pay_result' => '0',
            'result_code' => '0',
            'sign' => 'C19E81F49F253D60A76345CAD62D0616',
            'sign_type' => 'MD5',
            'status' => '0',
            'time_end' => '20160622220355',
            'total_fee' => '1',
            'trade_type' => 'pay.weixin.wappay',
            'transaction_id' => '7551000001201606222468412137',
            'version' => '2.0',
        ];*/
        if(count($params)<1){//如果参数为空,则不进行处理

            fwrite($logFile, "参数为空\r\n");

        }else {
            //
            $order_info['trade_no'] = $params['out_transaction_id'];
            $order_info['out_trade_no'] = $params['out_trade_no'];

            if( $params['result_code'] == 0 && $this->ValidSign($params, C('Swift.key'))){//验签成功
                //回调次数
                M('promote_deposit',"tab_")->where(array('pay_order_number' => $order_info['out_trade_no']))->setInc('notify_nums',1);
                $pay_where = substr($order_info['out_trade_no'],0,2);
                //此处进行业务逻辑处理
                switch($params["pay_result"]){
                    case 0:
                        fwrite($logFile, "[".$params["out_trade_no"]."]--->支付成功\r\n");
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
                        fwrite($logFile, "[".$params["out_trade_no"]."]--->支付失败-->状态码".$params["pay_result"]."\r\n");
                        break;
                }
                
                //将返回结果返回到商户的回调地址上边
                //fwrite($logFile, "商户回调请求前");
                $notify_nums = M('promote_deposit',"tab_")->where(array('pay_order_number' => $order_info['out_trade_no']))->field('notify_nums')->find();
                if($notify_nums['notify_nums'] <= 3){
                    $re = $this->request($params);
                    if($re == 'success'){
                        fwrite($logFile, "商户有返回：".$re."\r\n\r\n");
                        fwrite($logFile, "\r\n\r\n");
                        fclose($logFile);
                        echo "success";
                    }
                    fwrite($logFile, "商户无返回\r\n\r\n");
                }else{
                    fwrite($logFile, "商户的回调次数：".$notify_nums['notify_nums']."\r\n\r\n");
                    fwrite($logFile, "\r\n\r\n");
                    fclose($logFile);
                    echo "success";
                }
                

            }else{
                fwrite($logFile, "[".$params["out_trade_no"]."]--->验签失败\r\n");
            }
        }

        fwrite($logFile, "\r\n\r\n");
        fclose($logFile);

    }

    /**
     *通知方法
     */
    public function scanNotify(){

        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/scanlog.txt", "a+");
        fwrite($logFile, "回调进来\r\n\r\n\r\n");

        $xml = file_get_contents('php://input');
        fwrite($logFile, "xml".$xml."\r\n\r\n\r\n");
        $params = $this->xmlToArray($xml);
        foreach($params as $key=>$val) {
            fwrite($logFile, $key."=".$val."\r\n");
        }
        /*$params = [
            'bank_type' => 'CFT',
            'charset' => 'UTF-8',
            'fee_type' => 'CNY',
            'is_subscribe' => 'N',
            'mch_id' => '7551000001',
            'nonce_str' => '1466604235945',
            'openid' => 'osMSktyXBAh-UsWAqzjgBwzkjA3E',
            'out_trade_no' => '004942637492556',
            'out_transaction_id' => '400045200120160622772118533',
            'pay_result' => '0',
            'result_code' => '0',
            'sign' => 'C19E81F49F253D60A76345CAD62D0616',
            'sign_type' => 'MD5',
            'status' => '0',
            'time_end' => '20160622220355',
            'total_fee' => '1',
            'trade_type' => 'pay.weixin.wappay',
            'transaction_id' => '7551000001201606222468412137',
            'version' => '2.0',
        ];*/
        if(count($params)<1){//如果参数为空,则不进行处理

            fwrite($logFile, "参数为空\r\n");

            fwrite($logFile, "\r\n\r\n");
            fclose($logFile);

        }else {
            //
            $order_info['trade_no'] = $params['out_transaction_id'];
            $order_info['out_trade_no'] = $params['out_trade_no'];

            if( $params['result_code'] == 0 && $this->ValidSign($params, C('SwiftScan.key'))){//验签成功
                //回调次数
                M('promote_deposit',"tab_")->where(array('pay_order_number' => $order_info['out_trade_no']))->setInc('notify_nums',1);
                $pay_where = substr($order_info['out_trade_no'],0,2);
                //此处进行业务逻辑处理
                switch($params["pay_result"]){
                    case 0:
                        fwrite($logFile, "[".$params["out_trade_no"]."]--->支付成功\r\n");
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
                        fwrite($logFile, "[".$params["out_trade_no"]."]--->支付失败-->状态码".$params["pay_result"]."\r\n");
                        break;
                }

                //将返回结果返回到商户的回调地址上边
                //fwrite($logFile, "商户回调请求前");
                $notify_nums = M('promote_deposit',"tab_")->where(array('pay_order_number' => $order_info['out_trade_no']))->field('notify_nums')->find();
                if($notify_nums['notify_nums'] <= 3){
                    unset($params['mch_id']);
                    $re = $this->request($params);
                    if($re == 'success'){
                        fwrite($logFile, "商户有返回：".$re."\r\n\r\n");
                        fwrite($logFile, "\r\n\r\n");
                        fclose($logFile);
                        echo "success";
                    }
                    fwrite($logFile, "商户无返回\r\n\r\n");
                }else{
                    fwrite($logFile, "商户的回调次数：".$notify_nums['notify_nums']."\r\n\r\n");
                    fwrite($logFile, "\r\n\r\n");
                    fclose($logFile);
                    echo "success";
                }


            }else{
                fwrite($logFile, "[".$params["out_trade_no"]."]--->验签失败\r\n");
                fclose($logFile);
            }
        }
    }



    /**
     * 校验签名
     * @param array 参数
     * @param unknown_type keyValue
     */
    public function ValidSign(array $array,$keyValue){
        $sign = $array['sign'];
        unset($array['sign']);
        
        $mySign = $this->SignArray($array, $keyValue);

        return strtolower($sign) == strtolower($mySign);
    }

    /**
     * 将参数数组签名
     */
    public function SignArray(array $array,$keyValue){
        ksort($array);
        $blankStr = $rr = $this->ToUrlParams($array);
        $blankStr = $blankStr."&key=".$keyValue;// 将key放到数组中一起进行排序和组装

        $sign =  strtoupper(md5($blankStr));//大写
        return $sign;
    }
    
    public function MerSignArray(array $array,$appkey){
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

    function request($params){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/notifypf.txt", "a+");
        fwrite($logFile, "\r\n\r\n");
        fwrite($logFile, "[".$params["out_trade_no"]."]--->查询回调前\r\n");
        foreach($params as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }

        $notify_url = M('promote_deposit','tab_')->where("pay_order_number = '" . $params['out_trade_no']."'")->getField('notify_url');
        $is_key = M('promote_deposit','tab_')->where("pay_order_number = '" . $params['out_trade_no']."'")->getField('is_key');
        $id = M('promote_deposit','tab_')->where("pay_order_number='".$params['out_trade_no']."'")->getField('promote_id');
        $key = M('promote','tab_')->where("id=".$id)->getField('paykey');
        $account = M('promote','tab_')->where("id=".$id)->getField('account');
        
        $customer = array(
            'status' => $params["pay_result"] == 0 ? 200 : 201,
            'account' => $account,
            'resqn' => $params["out_trade_no"],
            'trade_no' => $params['out_transaction_id'],
            'pay_amount' => $params['total_fee'],
            'remark' => $params['attach'],
        );

        if($is_key == 1){
            fwrite($logFile, "[".$notify_url."]--->查询回调后（验证）\r\n\r\n\r\n");
            $customer['mer_sign'] = $this->MerSignArray($customer,$key);
            foreach($customer as $k=>$v){
                fwrite($logFile, $k."=".$v."\r\n");
            }
        }
        if($notify_url) {
            $re = $this->send_post($notify_url,$customer);
        }
        fclose($logFile);
        return $re;
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
     * 将XML转为数组
     */
    function xmlToArray($xml){     //禁止引用外部xml实体    
        libxml_disable_entity_loader(true);    
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);    
        $array = json_decode(json_encode($xmlstring),true);    
        return $array;    
    } 

}