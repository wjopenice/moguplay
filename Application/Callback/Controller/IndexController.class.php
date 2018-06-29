<?php
namespace Callback\Controller;

/**
 * 支付回调控制器 Now现在支付
 * @author 小黑
 */
class IndexController extends BaseController {


    /**
    *通知方法
    */
    public function index(){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/log.txt", "a+");
        fwrite($logFile, "现在支付回调进来\r\n\r\n\r\n");

        $res = file_get_contents('php://input');
        $params = array();
        $res = explode('&', $res);
        foreach($res as $v) {
            $value = explode('=', $v);
            fwrite($logFile, $value[0]."=".$value[1]."\r\n");
            $params[$value[0]] = urldecode($value[1]);
        }
        /*$params = [
            "appId" => "151385022206629",
            "channelOrderNo" => "4200000119201805021176633097",
            "deviceType" => "08",
            "discountAmt" => "0",
            "funcode" => "N001",
            "mhtCharset" => "UTF-8",
            "mhtCurrencyType" => "156",
            "mhtOrderAmt" => "2",
            "mhtOrderName" => urldecode("%E5%B9%B3%E5%8F%B0%E8%B4%A6%E5%8F%B7%E6%B5%8B%E8%AF%95"),
            "mhtOrderNo" => "QD_201805021808446AG3",
            "mhtOrderStartTime" => "20180502180844",
            "mhtOrderTimeOut" => "3600",
            "mhtOrderType" => "01",
            "mhtReserved" => "test",
            "nowPayOrderNo" => "200301201805021808449169925",
            "oriMhtOrderAmt" => "2",
            "payChannelType" => "13",
            "payConsumerId" => urldecode("%5B%5D"),
            "payTime" => "20180502181017",
            "signType" => "MD5",
            "signature" => "52853cc364831d2d7ef7375788d5877f",
            "transStatus" => "A001",
            "version" => "1.0.0",
        ];*/

        if(count($params)<1){//如果参数为空,则不进行处理

            fwrite($logFile, "参数为空\r\n");

        }else {
            //
            $order_info['trade_no'] = $params['nowPayOrderNo'];
            $order_info['out_trade_no'] = $params['mhtOrderNo'];

            $key = C('Now.appkey');
            if($this->ValidSign($params, $key)){//验签成功
                //回调次数
                M('promote_deposit',"tab_")->where(array('pay_order_number' => $order_info['out_trade_no']))->setInc('notify_nums',1);
                $pay_where = substr($order_info['out_trade_no'],0,2);
                //此处进行业务逻辑处理
                switch($params["transStatus"]){
                    case 'A001':
                        fwrite($logFile, "[".$params["mhtOrderNo"]."]--->支付成功\r\n");
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
                    case 2:
                        fwrite($logFile, "[".$params["mhtOrderNo"]."]--->交易处理中\r\n");
                        break;
                    default:
                        fwrite($logFile, "[".$params["mhtOrderNo"]."]--->支付失败-->状态码".$params["transStatus"]."\r\n");
                        break;
                }
                //将返回结果返回到商户的回调地址上边
                //fwrite($logFile, "商户回调请求前");
                $notify_nums = M('promote_deposit',"tab_")->where(array('pay_order_number' => $order_info['out_trade_no']))->getField('notify_nums');
                if($notify_nums <= 3){
                    $re = $this->request($params);
                    if($re == 'success'){
                        fwrite($logFile, "商户有返回：".$re."\r\n\r\n");
                        fwrite($logFile, "\r\n\r\n");
                        fclose($logFile);
                        echo "success=Y";
                    }
                    fwrite($logFile, "商户无返回\r\n\r\n");
                }else{
                    fwrite($logFile, "商户的回调次数：".$notify_nums."\r\n\r\n");
                    fwrite($logFile, "\r\n\r\n");
                    fclose($logFile);
                    echo "success=Y";
                }
                

            }else{
                fwrite($logFile, "[".$params["mhtOrderNo"]."]--->验签失败\r\n");
            }
        }

        fwrite($logFile, "\r\n\r\n");
        fclose($logFile);

    }



    /**
     * 校验签名
     * @param array 参数
     * @param unknown_type keyValue
     */
    public function ValidSign(array $array,$key){
        if($array['transStatus'] == 'A001') {
            $signRsp = $array["signature"];

            $sign = $this->SignArray($array,$key);

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
     * 将参数数组签名
     */
    public function SignArray(array $array,$appkey){
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
        fwrite($logFile, "[".$params["mhtOrderNo"]."]--->查询回调前\r\n");

        $notify_url = M('promote_deposit','tab_')->where("pay_order_number = '" . $params['mhtOrderNo']."'")->getField('notify_url');
        $is_key = M('promote_deposit','tab_')->where("pay_order_number = '" . $params['mhtOrderNo']."'")->getField('is_key');
        $id = M('promote_deposit','tab_')->where("pay_order_number='".$params['mhtOrderNo']."'")->getField('promote_id');
        $key = M('promote','tab_')->where("id=".$id)->getField('paykey');
        $account = M('promote','tab_')->where("id=".$id)->getField('account');
           
        $customer = array(
            'status' => $params["transStatus"] == 'A001' ? 200 : 201,
            'account' => $account,
            'resqn' => $params["mhtOrderNo"],
            'trade_no' => $params['nowPayOrderNo'],
            'pay_amount' => $params['mhtOrderAmt'],
            'remark' => $params['mhtReserved'],
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



}