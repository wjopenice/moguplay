<?php
namespace Api\Controller;

class GlobPayController extends BaseController
{
    //环讯
    const VERSION = 'v1.0.0';
    const MSGID = '0001';
    const MERCODE = '207575';
    const MERNAME = '广州手上科技有限公司';
    const ACCOUNT = '2075750014';
    const LANG = 'GB';
    const APIURL = "https://thumbpay.e-years.com/psfp-webscan/services/scan?wsdl";
    const MERCERT = 'ykorm6Gh3UTcAeJZoBYUO2UApGYF25FHJRey42G6JY8kVwrY6LLKX20a0fsYC91YSWzG16e6OE3mNqXbSWAQa7Mykvz4kM38fPLL6u6w643LFw6Kd0zc2avua9HRhfEt';

    /**
     *充值接口请求
     *@author whh
     */
    public function beginPay(){
        //打开日志log
//        $logFile = fopen(dirname(__FILE__)."/log.txt", "a+");
//        foreach($data as $k=>$v){
//            fwrite($logFile, $k."=".$v."\r\n");
//        }
//
//        fwrite($logFile, "\r\n\r\n");
        $parameter = array(
            "MsgId"	    => self::MSGID,//消息编号
            "ReqDate"	    => date("YmdHis"),
            "MerCode"	    => self::MERCODE,//商户号
            "MerName"	    => self::MERNAME,//商户名
            "Account"	    => self::ACCOUNT,//交易帐号
            "MerBillNo"	    => 'HX_'.date('Ymd').date ( 'His' ).sp_random_string(4),
            "GatewayType"	    => 11,
            "Date"	        => date('Ymd'),
            "RetEncodeType"	        => 17,
            "CurrencyType"	        => 156,
            "Amount"	    => 0.01,
            "BillEXP"	=> 2,
            "GoodsName"	    => '测试',
            "ServerUrl"	    => "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/Glob/notify",
            "Lang"	    => self::LANG,
            "Attach"	    => $this->getRandom(),//随机字符
            "MerType"   => 0,
            "SubMerCode" => 1
        );

        $html_text = $this->buildRequest($parameter);

        header("Content-type:text/xml;charset=utf-8");
        echo  $html_text;
        exit;

        #支付配置
        $config['reqsn'] = $data['resqn'];
        $config["cusid"] = CUSID;
        $config["appid"] = APPID;
        $config["version"] = self::VERSION;
        $config["trxamt"] = $data['pay_amount']*100;
        $config["randomstr"] = $this->getRandom();//随机字符串
        $config["body"] = $data['body'] ? $data['body'] : "平台币";
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
                'retcode' => $rspArray['retcode'],
                'payinfo' => $rspArray['payinfo'],
                'trxid' => $rspArray['trxid'],
                'body' => $data['body'] ? $data['body'] : "平台币",
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
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @return 提交表单HTML文本
     */
    function buildRequest($para_temp) {
        try {
            $para = $this->buildRequestPara($para_temp);

            $wsdl = self::APIURL;

            $client=new \SoapClient($wsdl);

            $sReqXml = $client->scanPay($para);

            //echo "扫码支付请求返回报文:" . $sReqXml;
           // Log::DEBUG("扫码支付请求返回报文:" . $sReqXml);

            return $sReqXml;
        } catch (Exception $e) {
            echo "扫码支付请求异常:" . $e;
            //Log::ERROR("扫码支付请求异常:" . $e);
        }
        return null;
    }

    /**
     * 生成要请求给IPS的参数XMl
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数XMl
     */
    function buildRequestPara($para_temp) {
        $sReqXml = "<Ips>";
        $sReqXml .= "<GateWayReq>";
        $sReqXml .= $this->buildHead($para_temp);
        $sReqXml .= $this->buildBody($para_temp);
        $sReqXml .= "</GateWayReq>";
        $sReqXml .= "</Ips>";
        //Log::DEBUG("扫码支付请求报文:" . $sReqXml);
        header("Content-type:text/xml;charset=utf-8");
        echo $sReqXml;exit;
        return $sReqXml;
    }

    /**
     * 请求报文头
     * @param   $para_temp 请求前的参数数组
     * @return 要请求的报文头
     */
    function buildHead($para_temp){
        $sReqXmlHead = "<head>";
        $sReqXmlHead .= "<Version>".self::VERSION."</Version>";
        $sReqXmlHead .= "<MerCode>".$para_temp["MerCode"]."</MerCode>";
        $sReqXmlHead .= "<MerName>".$para_temp["MerName"]."</MerName>";
        $sReqXmlHead .= "<Account>".$para_temp["Account"]."</Account>";
        $sReqXmlHead .= "<MsgId>".$para_temp["MsgId"]."</MsgId>";
        $sReqXmlHead .= "<ReqDate>".$para_temp["ReqDate"]."</ReqDate>";
        $sReqXmlHead .= "<Signature>".$this->md5Sign($this->buildBody($para_temp),$para_temp["MerCode"],self::MERCERT)."</Signature>";
        $sReqXmlHead .= "</head>";
        return $sReqXmlHead;
    }

    /**
     *  请求报文体
     * @param  $para_temp 请求前的参数数组
     * @return 要请求的报文体
     */
    function buildBody($para_temp){
        $sReqXmlBody = "<body>";
        $sReqXmlBody .= "<MerBillNo>".$para_temp["MerBillNo"]."</MerBillNo>";
        $sReqXmlBody .= "<GatewayType>".$para_temp["GatewayType"]."</GatewayType>";
        $sReqXmlBody .= "<Date>".$para_temp["Date"]."</Date>";
        $sReqXmlBody .= "<CurrencyType>".$para_temp["CurrencyType"]."</CurrencyType>";
        $sReqXmlBody .= "<Amount>".$para_temp["Amount"]."</Amount>";
        $sReqXmlBody .= "<Lang>".$para_temp["Lang"]."</Lang>";
        $sReqXmlBody .= "<Attach>".$para_temp["Attach"]."</Attach>";
        $sReqXmlBody .= "<RetEncodeType>".$para_temp["RetEncodeType"]."</RetEncodeType>";
        $sReqXmlBody .= "<ServerUrl>".$para_temp["ServerUrl"]."</ServerUrl>";
        $sReqXmlBody .= "<BillEXP>".$para_temp["BillEXP"]."</BillEXP>";
        $sReqXmlBody .= "<GoodsName>".$para_temp["GoodsName"]."</GoodsName>";
        $sReqXmlBody .= "<MerType>".$para_temp["MerType"]."</MerType>";
        $sReqXmlBody .= "<SubMerCode>".$para_temp["SubMerCode"]."</SubMerCode>";
        $sReqXmlBody .= "</body>";
        return $sReqXmlBody;
    }

    /**
     * 签名字符串
     * @param $prestr 需要签名的字符串
     * @param $key 私钥
     * @param $merCode 商戶號
     * return 签名结果
     */
    function md5Sign($prestr,$merCode, $key) {
        $prestr = $prestr . $merCode . $key;
        return md5($prestr);
    }


    //平台币充值记录
    public function begin_Pay(){
        $data = $_POST;
//        $resqn = 'QD_'.date('Ymd').date ( 'His' ).sp_random_string(4);
//        $data = [
//            'account' => 'a287077236',
//            'resqn' => $resqn,
//            'pay_amount' => 100,
//            'paytype' => 'W01',
//            'body' => '平台账号测试',
//            'notify_url' => 'http://119.23.34.87/api.php?s=/Pay/beginPay.html',
//        ];
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/glob.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }

        $account = $data['account'];
        if(count($data) == 0){
            $this->ajaxReturn(array("status"=>'4006',"msg"=>"参数为空"));
            exit;
        }
        if(!$account){
            $this->ajaxReturn(array("status"=>'4007',"msg"=>"商户号为空"));
            exit;
        }
        $status = M('promote','tab_')->where("account='".$account."'")->find();
        if($status['status'] != 1){
            $this->ajaxReturn(array("status"=>'40012',"msg"=>"商户号已禁用!!!!"));
            exit;
        }
        if(!$data['notify_url']){
            $this->ajaxReturn(array("status"=>'40011',"msg"=>"回调地址为空"));
            exit;
        }
        $key = M('promote','tab_')->where("account='".$account."'")->find();
        if($key['paykey']){
            $sh_data = [
                'resqn'   => $data['resqn'],
                'account' => $data['account'],
                'pay_amount' => $data['pay_amount'],
                'paytype' => $data['paytype'],
                'notify_url' => $data['notify_url']
            ];
            $sign = $this->SignArray($sh_data,$key['paykey']);

            if($sign != $data['sign']){//商户在我方验签
                $this->ajaxReturn(array("status"=>'40013',"msg"=>"验签失败"));
                exit;
            }else{
                $data['sign']  = $sign;
            }
        }else{
            $this->ajaxReturn(array("status"=>'40014',"msg"=>"APPKEY为空"));
            exit;
        }

        $or_map['pay_order_number'] = $data['resqn'];
        $order = M('promote_deposit','tab_')->where("pay_order_number = '".$data['resqn']."'")->find();

        if($order){
            $this->ajaxReturn(array("status"=>'4009',"msg"=>"订单号重复"));
            exit;
        }
        $map['account'] = $account;
        $user = M('promote','tab_')->where($map)->find();
        if($user){
            $deposit = M("promote_deposit", "tab_");
            $deposit_data['order_number'] = "";
            $deposit_data['pay_order_number'] = $data['resqn'];
            $deposit_data['promote_id'] = $user['id'];
            $deposit_data['promote_account'] = $account;
            $deposit_data['pay_amount'] = $data['pay_amount'];
            $deposit_data['pay_status'] = 0;
            $deposit_data['pay_way'] = $this->returnWay($data['paytype']);
            $deposit_data['pay_source'] = 0;
            $deposit_data['provider'] = '环讯';
            $deposit_data['is_key'] = 1;
            $deposit_data['pay_ip'] = $data['pay_id'] ? $data['pay_id'] : '';
            $deposit_data['create_time'] = NOW_TIME;
            $deposit_data['notify_url'] = $data['notify_url'];
            $result = $deposit->add($deposit_data);
            if($result){
                $this->beginPay($data);
                $this->ajaxReturn(array("status"=>'0001',"msg"=>"充值记录添加成功"));
                exit;
            }else{
                $this->ajaxReturn(array("status"=>'0002',"msg"=>"充值记录添加失败"));
                exit;
            }
        }else{
            $this->ajaxReturn(array("status"=>'4008',"msg"=>"商户不存在"));
            exit;
        }
    }

    function returnWay($type){
        if($type == '10'){
            return 2;
        }
        if($type == '11'){
            return 1;
        }
        if($type == '12'){
            return 5;
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
        $logFile = fopen(dirname(__FILE__)."/log2.txt", "a+");
        $array['key'] = $appkey;// 将key放到数组中一起进行排序和组装
        ksort($array);
        $blankStr = $this->ToUrlParams($array);
        fwrite($logFile, "签名链接".$blankStr."\r\n");
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


    //验签
    function verifyReturn($array)
    {
        if("SUCCESS"==$array["retcode"]){
            $logFile = fopen(dirname(__FILE__)."/log.txt", "a+");
            fwrite($logFile, "请求支付接口验签成功"."\r\n");
            $signRsp = strtolower($array["sign"]);
            $array["sign"] = "";
            $sign =  strtolower($this->SignArray($array, APPKEY));
            fwrite($logFile, "\r\n\r\n");
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

}