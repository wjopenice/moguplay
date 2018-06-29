<?php
namespace Callback\Controller;

/**
 * 支付回调控制器 PF
 * @author 小纯洁 
 */
class NotifyceshiPFController extends BaseController {


    //const APPKEY = '2018Z0303B';
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
        $logFile = fopen(dirname(__FILE__)."/ceshi.txt", "a+");
        fwrite($logFile, "商户回调\r\n");
        //fwrite($logFile, json_encode($_REQUEST)."\r\n");

        $params = array();
        foreach($_POST as $key=>$val) {//动态遍历获取所有收到的参数,此步非常关键,因为收银宝以后可能会加字段,动态获取可以兼容由于收银宝加字段而引起的签名异常
            $params[$key] = $val;
        }
        if(count($params)<1){//如果参数为空,则不进行处理

            fwrite($logFile, "参数为空\r\n");

        }else {
        	$id = M('promote_deposit','tab_')->where("pay_order_number='".$params['resqn']."'")->getField('promote_id');
			$key = M('promote','tab_')->where("id=".$id)->getField('paykey');

            foreach($params as $k=>$v){
                fwrite($logFile, $k."=".$v."\r\n");
            }
			fwrite($logFile, "参数循环写入"."\r\n");
            $mer_sign = $this->SignArray($params,$key);
            fwrite($logFile, "签名mer_sign为：".$mer_sign."\r\n");
        }
        fwrite($logFile, "\r\n\r\n");

		
        fclose($logFile);
        echo "success";
    }

    public function tl_pan_notify(){

        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/ceshi.txt", "a+");
        fwrite($logFile, "商户回调\r\n");

        $params = array();
        foreach($_POST as $key=>$val) {//动态遍历获取所有收到的参数,此步非常关键,因为收银宝以后可能会加字段,动态获取可以兼容由于收银宝加字段而引起的签名异常
            $params[$key] = $val;
        }
        if(count($params)<1){//如果参数为空,则不进行处理

            fwrite($logFile, "参数为空\r\n");

        }else {
            $id = M('promote_deposit','tab_')->where("pay_order_number='".$params['orderNo']."'")->getField('promote_id');
            $key = M('promote','tab_')->where("id=".$id)->getField('paykey');

            foreach($params as $k=>$v){
                fwrite($logFile, $k."=".$v."\r\n");
            }
            fwrite($logFile, "参数循环写入"."\r\n");
            unset($params['mer_sign']);
            $mer_sign = $this->SignArray($params,$key);
            fwrite($logFile, "签名mer_sign为：".$mer_sign."\r\n");
        }
        fwrite($logFile, "\r\n\r\n");


        fclose($logFile);
        echo "success";
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
        $logFile = fopen(dirname(__FILE__)."/ceshi.txt", "a+");
        fwrite($logFile, "商户回调时签名:".$mySign."\r\n"."商户原来的签名".$sign."\r\n");

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
        $sign = $array['mer_sign'];
        unset($array['mer_sign']);
        //新的key
        $array['key'] = $appkey;
        $blankStr = $this->ToUrlParams($array);
        $mySign = strtoupper(md5($blankStr));  
        
        //return $mySign;
        return strtolower($sign) == strtolower($mySign);
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

}