<?php
namespace Callback\Controller;

/**
 * 支付回调控制器 Reapal 融宝
 * @author 小纯洁 
 */
class NotifyReapalController extends BaseController {


    /**
    *通知方法
    */
    public function notify(){

        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/log.txt", "a+");
        fwrite($logFile, "NotifyReapal-->回调进来\r\n\r\n\r\n");
        
        //加密数据
        //$merchantId = $_REQUEST['merchant_id'];
        $data = $_REQUEST['data'];//"seSr/N0ju3QcujTv9ovL0Ko6DYvYG8a+mJLYsVf0Z6JBjp6JkRmJN7grLOnXjHELPQ9pdMS/FPjEjdRcrF2YyOKd+AQMMZE1fSeFt07r0M1quibigUnZW5b8Hf0VeEz+k8NQ6QHVM1NgYBooI6hRy4dbshDCQFZgKL9ftc1FcUv87G2zzd2bScCCJxVA9fqSEcx1vr1AqYkQeeDdMBqCCRsGXEpHqInOmVswHdV/4CNJ3nDbykVB60mUSHx1ZIwNJVGUZVWFB0bX0CkXwuXpeg==";
        //$_REQUEST['encryptkey'] = "bqtxNE66xe3AyyLqedylVm+LMEw2OdTSrwfXb5F1LSC21B4Ff9cht0CSCPxj6MUGWc4cATH0EQVe3JZ2Vl6lW6z5YLvlyQmT81bKrz58fCD2Tg9DWyMXCv1R8tciK5OhPz7fexkTDwlM8/OqYlCp4wWPgpRDn1TrUK86LxhebqKN8fCK3W+0O2N4e2XsQfC1TwenGfR0gOUuiWdfk5dxxxOyrMUsaiQNPrwhaQaiOZdpbdN7Jh7i3hODX/VCkiyxJkGLfCF3NUKWlWcpEzsHftIHrj+dN8wepzSoo6d+C76vSbhBCk8HakCQiI1SLlAz3Uabvl+BpJG5rDMbFXT8bg==";
        
        $encryptkey = $this->RSADecryptkey($_REQUEST['encryptkey'],"./Public/Api/cert/itrus001_pri.pem");
        $decryData = $this->aes_decode($data,$encryptkey);
        
        //赋值->数组
        $jsonObject = json_decode($decryData,true);
        $params = array();
        foreach($jsonObject as $key=>$val) {
        //动态遍历获取所有收到的参数,此步非常关键,因为收银宝以后可能会加字段,动态获取可以兼容由于收银宝加字段而引起的签名异常
            $params[$key] = $val;
            fwrite($logFile, $key."=".$val."\r\n");
        }
        /*$params = [
            "order_no" => "QD_20180423113841WJL2",
            "total_fee" => "1",
            "sign" => "a5ca22f071dc094df1be555902bf280c",
            "trade_no" => "10180423000160728",
            "notify_id" => "1b303f7095c84a859467d1824d67d0e7",
            "status" => "TRADE_FINISHED",
        ];*/

        if(count($params)<1){//如果参数为空,则不进行处理

            fwrite($logFile, "参数为空\r\n");

        }else {
            //
            $order_info['trade_no'] = $params['trade_no'];
            $order_info['out_trade_no'] = $params['order_no'];

            if($this->ValidSign($params, C('Reapal.key'))){//验签成功
                //回调次数
                M('promote_deposit',"tab_")->where(array('pay_order_number' => $order_info['out_trade_no']))->setInc('notify_nums',1);
                $pay_where = substr($order_info['out_trade_no'],0,2);
                //此处进行业务逻辑处理
                switch($params["status"]){
                    case "TRADE_FINISHED":
                        fwrite($logFile, "[".$params["order_no"]."]--->支付成功\r\n");
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
                        fwrite($logFile, "[".$params["order_no"]."]--->支付失败-->状态码".$params["status"]."\r\n");
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
                fwrite($logFile, "[".$params["order_no"]."]--->验签失败\r\n");
            }
        }

        fwrite($logFile, "\r\n\r\n");
        fclose($logFile);

    }

    function RSADecryptkey($encryptKey,$merchantPrivateKey){
        $private_key= file_get_contents($merchantPrivateKey); 
        $pi_key =  openssl_pkey_get_private($private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
        openssl_private_decrypt(base64_decode($encryptKey),$decrypted,$pi_key);//私钥解密
        
        return $decrypted;

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

        return $sign == $mySign;
    }

    /**
     * 将参数数组签名
     */
    public function SignArray(array $array,$appkey){
        ksort($array);
        reset($array);
        $blankStr = $this->ToUrlParams($array);
        $blankStr = $blankStr.$appkey;// 将key放到数组中一起进行排序和组装

        $sign = md5($blankStr);
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
        fwrite($logFile, "[".$params["order_no"]."]--->查询回调前\r\n");

        $notify_url = M('promote_deposit','tab_')->where("pay_order_number = '" . $params['order_no']."'")->getField('notify_url');
        $is_key = M('promote_deposit','tab_')->where("pay_order_number = '" . $params['order_no']."'")->getField('is_key');
        $id = M('promote_deposit','tab_')->where("pay_order_number='".$params['order_no']."'")->getField('promote_id');
        $key = M('promote','tab_')->where("id=".$id)->getField('paykey');
        $account = M('promote','tab_')->where("id=".$id)->getField('account');
           
        $customer = array(
            'status' => $params["status"] == "TRADE_FINISHED" ? 200 : 201,
            'account' => $account,
            'resqn' => $params["order_no"],
            'trade_no' => $params['trade_no'],
            'pay_amount' => $params['total_fee'],
            'remark' => '',
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