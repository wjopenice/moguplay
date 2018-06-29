<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/17
 * Time: 15:51
 */
namespace Api\Controller;
/**
 * Class IpsCodePayController
 * @package Api\Controller
 * IPS扫码支付
 */
class IpsCodePayController extends BaseController
{
     //IPS常用参数
    //版本号
    const Version = "v1.0.0";
    //商户号
    const MerCode = "207575";//"207973";
    //商户名
    const MerName = "广州手上科技有限公司";//"广州堡庆网络科技有限公司" 广州手上科技有限公司;
    //账号号
    //const Account = "2075750014";//"2079730012";2075750014
    public $account;
    //借口地址
    const ApiUrl = "https://thumbpay.e-years.com/psfp-webscan/services/scan?wsdl";
    //key
    const Key = "ykorm6Gh3UTcAeJZoBYUO2UApGYF25FHJRey42G6JY8kVwrY6LLKX20a0fsYC91YSWzG16e6OE3mNqXbSWAQa7Mykvz4kM38fPLL6u6w643LFw6Kd0zc2avua9HRhfEt";//"X12DYVzevDOVmFpYopdMQVwdG2pKg8MtycWHxTvZ5gNNlJe8AAeTP4X4t1NdZuOOrlDRDWHvy6FfH5cAcUF5dH15BESxdLRmQ8KQlNJN2TU4Oyvz8qXpds3hymjjJMSp"; 堡庆
    //"ykorm6Gh3UTcAeJZoBYUO2UApGYF25FHJRey42G6JY8kVwrY6LLKX20a0fsYC91YSWzG16e6OE3mNqXbSWAQa7Mykvz4kM38fPLL6u6w643LFw6Kd0zc2avua9HRhfEt"  手上
    //消息请求
    public function MsgReq(){}
    //消息响应
    public function MsgRep(){}
    public $payData;
    public $TotolPrice;
    public $ShopName;
    public $Signature;
    public $ShopNum;
    //初始化数据
    public function __construct()
    {
        $accountArr = array("2075750055","2075750030","2075750105","2075750089","2075750113","2075750048","2075750022","2075750097","2075750071","2075750014","2075750063");
        $i = rand(0,10);//随机生成一个0到10之间的整形数字，包括0和10

        $this->account =$accountArr[$i];
        $this->TotolPrice =session("TotolPrice");
        $this->ShopName = session("ShopName");
        $this->ShopNum = session("ShopNum");
    }
    //支付数据
    //public function GetPayData($TotolPrice,$ShopName){
    public function GetPayData(){

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
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }

        //字段校验
        $msgArr = $this->parameter($data);

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
            $deposit_data['pay_type'] = 2;

            $result = $deposit->add($deposit_data);
            if($result){

                if($data['paytype'] == 'W01'){
                    $GatewayType = 10;
                }
                if($data['paytype'] == 'A01'){
                    $GatewayType = 11;
                }
                $payData = [
                    "MsgId"=> "0001", //消息编号
                    "ReqDate"=>date("YmdHis",time()+0),//商户请求时间
                    "MerBillNo"=>$data['resqn'],//订单号
                    "GatewayType"=>$GatewayType,//注意：可以手动写死 10微信 11支付宝 12 手Q
                    "MerType"=>0,  //0：标准商户 1：平台商户
                    "SubMerCode"=>1,  //当商户类型为1：平台商户时，必填
                    "Date"=>date("Ymd",time()+0),//订单日期
                    "CurrencyType"=>156, //默认人民币156
                    "Amount"=>$data['pay_amount'],//订单金额
                    "Lang"=>"GB", //语言 GB中文
                    "SpbillCreateIp"=>$_SERVER["REMOTE_ADDR"],//终端机IP  必须传正确的用户端IP
                    //商户数据包存放商户自己的信息，随订单传送到IPS平台，当订单返回的时候原封不动的返回给商户，由“数字、字母或数字+字母”组成
                    "Attach"=>$this->Mer_shuffle(),
                    "RetEncodeType"=>17,//选择加密方式17为md5加密
                    "ServerUrl"=>"http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyIps/notify", //支付成功服务器后端通知地址
                    "BillEXP"=>2,//订单有效期默认为2小时
                    "GoodsName"=>$data['body'] ? $data['body'] : '渠道充值',
                ];
                foreach($payData as $k=>$v){
                    fwrite($logFile, $k."=".$v."\r\n");
                }
                fwrite($logFile, "\r\n\r\n");
                $html_text = $this->buildRequest($payData);
                fwrite($logFile, $html_text."\r\n");
                $arr = $this->xmlToArray($html_text);
                if($arr['GateWayRsp']['head']['RspCode'] === '000000'){
                    foreach($arr as $k=>$v){
                        fwrite($logFile, $k."=".$v."\r\n");
                    }
                    fwrite($logFile, "\r\n\r\n");
                    $json_data = array(
                        'status' => $arr['GateWayRsp']['head']['RspCode'],
                        'payinfo' => $arr['GateWayRsp']['body']['QrCode'],

                    );
                    foreach($json_data as $k=>$v){
                        fwrite($logFile, $k."=".$v."\r\n");
                    }
                    fwrite($logFile, "\r\n\r\n");
//                    echo "<pre>";
//                    print_r($json_data);exit;
                    $this->ajaxReturn($json_data);exit;
                }else{
                    $this->ajaxReturn(array("status"=>'40010',"msg"=>"请求接口失败"));
                    exit;
                }
            }else{
                $this->ajaxReturn(array("status"=>'0002',"msg"=>"充值记录添加失败"));
                exit;
            }

        }else{
            $this->ajaxReturn($msgArr);
            exit;
        }


    }

    function xmlToArray($xml){     //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $array = json_decode(json_encode($xmlstring),true);
        return $array;
    }

    //下单请求
    public function buildRequest($payData) {
        try {
            $para = $this->BuildXmlReq($payData);
            //发送的请求的报文
            //file_put_contents("./a.xml",$para);
            $wsdl = self::ApiUrl;
            $client=new \SoapClient($wsdl);
            //用$client->__getFunctions()得到两个方法
            //string scanPay(string $scanPayReq)' (length=34)
            //string barCodeScanPay(string $barCodeScanPay)' (length=45)
             $sReqXml = $client->scanPay($para);
            //响应的到的报文
             //file_put_contents("http://www.game-pk.com/pro.xml",$sReqXml);
           // $fileName =  fopen("http://www.game-pk.com/pro.xml","w+");
            //fwrite($fileName,"123");
            //fclose($fileName);
            return $sReqXml;
        } catch (Exception $e) {
            echo "扫码支付请求异常:" . $e;
        }
        return null;
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
            $sign = $this->Signature($sh_data,$key['paykey']);
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
                $this->GetPayData($data);
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
    //POST请求
    public function Curl_Post($data,$url){
        $this_header = array("content-type: application/x-www-form-urlencoded;charset=UTF-8");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER,$this_header);
        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST,1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);//如果不加验证,就设false,商户自行处理
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $Res_output = curl_exec($curl);
        curl_close($curl);
        return  $Res_output;
    }
    //数字签名
    public function Signature($PayData,$MerCode,$key){
        $signature = md5($PayData.$MerCode.$key);
        //file_put_contents("b.html",$signature);
        $this->Signature = $signature;
        return $signature;
    }
    //生成XML请求模板
    public function BuildXmlReq($PayData){
        $XmlContent = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        $XmlContent .= "<Ips>";
        $XmlContent .= "<GateWayReq>";
        $XmlContent .= $this->XmlHeader($PayData);
        $XmlContent .= $this->XmlBody($PayData);
        $XmlContent .= "</GateWayReq>";
        $XmlContent .= "</Ips>";
        //header("content-type:text/xml;charset=utf-8");
        return $XmlContent;
    }
    //XML头信息
    public function XmlHeader($PayData){
         $XmlContent = "";
         $XmlContent .= "<head>";
         $XmlContent .= "<Version>".self::Version."</Version>";
         $XmlContent .= "<MerCode>".self::MerCode."</MerCode>";
         $XmlContent .= "<MerName>".self::MerName."</MerName>";
         $XmlContent .= "<Account>".$this->account."</Account>";
         $XmlContent .= "<MsgId>{$PayData['MsgId']}</MsgId>";
         $XmlContent .= "<ReqDate>{$PayData['ReqDate']}</ReqDate>";
         $XmlContent .= "<Signature>{$this->Signature($this->XmlBody($PayData),self::MerCode,self::Key)}</Signature>";
         $XmlContent .= "</head>";
         return $XmlContent;
    }
    //XML主体信息
    public function XmlBody($PayData){
         $XmlContent = "";
         $XmlContent .= "<body>";
         $XmlContent .= "<MerBillNo>{$PayData['MerBillNo']}</MerBillNo>";
         $XmlContent .= "<GatewayType>{$PayData['GatewayType']}</GatewayType>";
         $XmlContent .= "<MerType>{$PayData['MerType']}</MerType>";
         $XmlContent .= "<SubMerCode>{$PayData['SubMerCode']}</SubMerCode>";
         $XmlContent .= "<Date>{$PayData['Date']}</Date>";
         $XmlContent .= "<CurrencyType>{$PayData['CurrencyType']}</CurrencyType>";
         $XmlContent .= "<Amount>{$PayData['Amount']}</Amount>";
         $XmlContent .= "<Lang>{$PayData['Lang']}</Lang>";
         $XmlContent .= "<SpbillCreateIp>{$PayData['SpbillCreateIp']}</SpbillCreateIp>";
         $XmlContent .= "<Attach>{$PayData['Attach']}</Attach>";
         $XmlContent .= "<RetEncodeType>{$PayData['RetEncodeType']}</RetEncodeType>";
         $XmlContent .= "<ServerUrl>{$PayData['ServerUrl']}</ServerUrl>";
         $XmlContent .= "<BillEXP>{$PayData['BillEXP']}</BillEXP>";
         $XmlContent .= "<GoodsName>{$PayData['GoodsName']}</GoodsName>";
         $XmlContent .= "</body>";
         return $XmlContent;
    }
    //随机字符串
    public function Mer_shuffle(){
        $int_arr = range(0,9);
        $str_arr = range("a","z");
        $str1 = $this->mb_splitchar(self::MerName);
        $new_arr = array_merge($int_arr,$str_arr);
        shuffle($new_arr);
        $strData = $str1.implode($new_arr);
        $new_str = substr($strData,0,32);
        //file_put_contents("./c.html",$new_str);
        return $new_str;
    }
    //订单生成
    public function build_order_no(){
        return date('Ymd').substr(implode(array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }
    //获取单个汉字拼音首字母。注意:此处不要纠结。汉字拼音是没有以U和V开头的
    public function getfirstchar($s0){
        $fchar = ord($s0{0});
        if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($s0{0});
        $s1 = iconv("UTF-8","gb2312", $s0);
        $s2 = iconv("gb2312","UTF-8", $s1);
        if($s2 == $s0){$s = $s1;}else{$s = $s0;}
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if($asc >= -20319 and $asc <= -20284) return "A";
        if($asc >= -20283 and $asc <= -19776) return "B";
        if($asc >= -19775 and $asc <= -19219) return "C";
        if($asc >= -19218 and $asc <= -18711) return "D";
        if($asc >= -18710 and $asc <= -18527) return "E";
        if($asc >= -18526 and $asc <= -18240) return "F";
        if($asc >= -18239 and $asc <= -17923) return "G";
        if($asc >= -17922 and $asc <= -17418) return "H";
        if($asc >= -17922 and $asc <= -17418) return "I";
        if($asc >= -17417 and $asc <= -16475) return "J";
        if($asc >= -16474 and $asc <= -16213) return "K";
        if($asc >= -16212 and $asc <= -15641) return "L";
        if($asc >= -15640 and $asc <= -15166) return "M";
        if($asc >= -15165 and $asc <= -14923) return "N";
        if($asc >= -14922 and $asc <= -14915) return "O";
        if($asc >= -14914 and $asc <= -14631) return "P";
        if($asc >= -14630 and $asc <= -14150) return "Q";
        if($asc >= -14149 and $asc <= -14091) return "R";
        if($asc >= -14090 and $asc <= -13319) return "S";
        if($asc >= -13318 and $asc <= -12839) return "T";
        if($asc >= -12838 and $asc <= -12557) return "W";
        if($asc >= -12556 and $asc <= -11848) return "X";
        if($asc >= -11847 and $asc <= -11056) return "Y";
        if($asc >= -11055 and $asc <= -10247) return "Z";
        return NULL;
    }
    //获取整条字符串汉字拼音首字母
    public function mb_splitchar($str){
        $strX = "";
        for($i=0;$i<mb_strlen($str);$i++){
            $strData = mb_substr($str,$i,1);
            if(ord($strData) > 160){
                $strX .= $this->getfirstchar($strData);
            }else{
                $strX .= $strData;
            }
        }
        return $strX;
    }

    public function returnWay($type){
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

    public function addSql()
    {
        $ipscodeorder['id'] = null;
        $ipscodeorder['shopName'] = $this->ShopName;
        $ipscodeorder['shopNum'] =$this->ShopNum;
        $ipscodeorder['shopPrice'] = $this->TotolPrice;
        $ipscodeorder['MsgId'] = $this->payData['MsgId'];
        $ipscodeorder['ReqDate'] = $this->payData['ReqDate'];
        $ipscodeorder['MerBillNo'] = $this->payData['MerBillNo'];
        $ipscodeorder['GatewayType'] = $this->payData['GatewayType'];
        $ipscodeorder['MerType'] = $this->payData['MerType'];
        $ipscodeorder['Date'] = $this->payData['Date'];
        $ipscodeorder['CurrencyType'] = $this->payData['CurrencyType'];
        $ipscodeorder['SpbillCreateIp'] = $this->payData['SpbillCreateIp'];
        $ipscodeorder['Attach'] = $this->payData['Attach'];
        $ipscodeorder['Signature'] = $this->Signature;
        $ipscodeorder['OrderStatus'] = "已下单，未支付";
        session("ipscodeorder",$ipscodeorder);
        file_put_contents("./sql.html",implode(",",$ipscodeorder));

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
        if(!$data['pay_ip']){
            return array("status"=>'40016',"msg"=>"IP为空");
            exit;
        }
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

        return array("status"=>'0',"promote"=>$promote);
    }
}