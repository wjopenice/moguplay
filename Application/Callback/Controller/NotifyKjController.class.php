<?php
namespace Callback\Controller;

/**
 * 支付回调控制器 快接
 * @author 小纯洁 
 */
class NotifyKjController extends BaseController {


    /**
    *通知方法
    */
    public function notify(){

        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/log.txt", "a+");
        fwrite($logFile, "快接 type = 8 回调进来\r\n\r\n\r\n");

        $params = array();
        foreach($_REQUEST as $key=>$val) {//动态遍历获取所有收到的参数,此步非常关键,因为收银宝以后可能会加字段,动态获取可以兼容由于收银宝加字段而引起的签名异常
            $params[$key] = $val;
            fwrite($logFile, $key."=".$val."\r\n");
        }
        /*$params = [
           'status' => 'Success',
           'trade_no' => '5211185152125',
           'merchant_order_no' => 'QD_20180320032213F7l3',
           'Amount' => 0.01,
           'Sign' => '3D343a51497792588a9ce7deb0ec947613',
        ];*/
        if(count($params)<1){//如果参数为空,则不进行处理

            fwrite($logFile, "参数为空\r\n");

        }else {
            //
            $order_info['trade_no'] = $params['trade_no'];
            $order_info['out_trade_no'] = $params['merchant_order_no'];

            $type = M('promote_deposit','tab_')->where("pay_order_number='".$params['merchant_order_no']."'")->getField('pay_way');
            $where = "pay_type=8 and alipay_status=1";
            if($type == 4){
                $where = "pay_type=8 and wetch_status=1";
            }
            $pay_data = M('pay_interface','tab_')->where($where)->find();

            if($pay_data){
                $key = $pay_data['pay_appkey'];
            }
            
            if($this->ValidSign($params, $key)){//验签成功
                //回调次数
                M('promote_deposit',"tab_")->where(array('pay_order_number' => $order_info['out_trade_no']))->setInc('notify_nums',1);
                $pay_where = substr($order_info['out_trade_no'],0,2);
                //此处进行业务逻辑处理
                switch($params["status"]){
                    case "Success":
                        fwrite($logFile, "[".$params["merchant_order_no"]."]--->支付成功\r\n");
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
                        fwrite($logFile, "[".$params["merchant_order_no"]."]--->交易处理中\r\n");
                        break;
                    default:
                        fwrite($logFile, "[".$params["merchant_order_no"]."]--->支付失败-->状态码".$params["status"]."\r\n");
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
                fwrite($logFile, "[".$params["merchant_order_no"]."]--->验签失败\r\n");
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
    public function ValidSign(array $array,$keyValue){
        $sign = $array['sign'];
        unset($array['sign']);
        
        $mySign = $this->SignArray($array, $keyValue);

        return $sign == $mySign;
    }

    /**
     * 将参数数组签名
     */
    public function SignArray(array $array,$Key){
        ksort($array);
        $blankStr = $this->ToUrlParams($array);
        $blankStr = $blankStr."&key=".$Key;// 将key放到数组中一起进行排序和组装
        $sign =  md5($blankStr);
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
        fwrite($logFile, "[".$params["merchant_order_no"]."]--->查询回调前\r\n");

        $notify_url = M('promote_deposit','tab_')->where("pay_order_number = '" . $params['merchant_order_no']."'")->getField('notify_url');
        $is_key = M('promote_deposit','tab_')->where("pay_order_number = '" . $params['merchant_order_no']."'")->getField('is_key');
        $id = M('promote_deposit','tab_')->where("pay_order_number='".$params['merchant_order_no']."'")->getField('promote_id');
        $key = M('promote','tab_')->where("id=".$id)->getField('paykey');
        $account = M('promote','tab_')->where("id=".$id)->getField('account');
           
        $customer = array(
            'status' => $params["status"] == "Success" ? 200 : 201,
            'account' => $account,
            'resqn' => $params["merchant_order_no"],
            'trade_no' => $params['trade_no'],
            'pay_amount' => $params['amount']*100,
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



}