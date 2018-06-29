<?php
namespace Api\Controller;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/19
 * Time: 14:32
 */

class IpsObPayController extends BaseController{
    //版本号
    const Version = "v1.0.0";
    //商户号
    const MerCode = "207973";
    //商户名
    const MerName = "广州堡庆网络科技有限公司";
    //账号号
    const Account = "2079730012";
    //借口地址
    const ApiUrl = "https://newpay.ips.com.cn/psfp-entry/gateway/payment.do";
    //key
    const Key = "X12DYVzevDOVmFpYopdMQVwdG2pKg8MtycWHxTvZ5gNNlJe8AAeTP4X4t1NdZuOOrlDRDWHvy6FfH5cAcUF5dH15BESxdLRmQ8KQlNJN2TU4Oyvz8qXpds3hymjjJMSp";
    public $payData;
    public $TotolPrice;
    public $ShopName;
    public function index(){
        echo "xxxx";
    }
    //初始化数据
    public function __construct()
    {
        $this->TotolPrice =session("TotolPrice");
        $this->ShopName = session("ShopName");
    }
    public function BuildObData(){
        $obdata = [
            "MsgId"=>"001",//消息编号
            "ReqDate"=>date("YmdHis",time()+0),//商户请求时间
            "MerBillNo"=>"IPS".$this->build_order_no(), //订单号
            "Amount"=>$this->TotolPrice,//订单金额
            "Date"=>date("Ymd",time()+0),//订单日期
            "CurrencyType"=>156,//人民币
            "GatewayType"=>01,  //01借记卡 02信用卡 03 IPS账户支付
            "Lang"=>"GB", //GB中文
            "Merchanturl"=>"http://119.23.34.87/callback.php?s=/NotifyIps/pan_notify", //成功回调
            "FailUrl"=>"",//失败回调
            //商户数据包存放商户自己的信息，随订单传送到IPS平台，当订单返回的时候原封不动的返回给商户，由“数字、字母或数字+字母”组成
            "Attach"=>$this->Mer_shuffle(),
            "OrderEncodeType"=>5, //5#订单支付采用Md5的摘要认证方式
            "RetEncodeType"=>17, //17#交易返回采用Md5的摘要认证方式
            "RetType"=>1, //Server to Server返回。
            //商户使用异步方式返回时可将返回地址存于此字段当 RetType#1 时,本字段有效
            "ServerUrl"=>"http://119.23.34.87/callback.php?s=/NotifyIps/pan_notify",
            "BillEXP"=>2,//订单有效期(以小时计算，必须是整数)
            "GoodsName"=>$this->ShopName,//商品名称
            "IsCredit"=>1,//决定商户是否参用直连方式
            "BankCode"=>"",//唯一标识指定支付银行的编号
            "ProductType"=>1//1#个人网银  2#企业网银
        ];
        return $obdata;
    }
    public function BuildXml($obdata){
        $XmlContent = "<?xml version='1.0' charset='utf-8' ?>";
        $XmlContent .="<Ips>";
        $XmlContent .="<GateWayReq>";
        $XmlContent .=$this->BuildXmlHead($obdata);
        $XmlContent .=$this->BuildXmlBody($obdata);
        $XmlContent .="</GateWayReq>";
        $XmlContent .="</Ips>";
        return $XmlContent;
    }
    public function BuildXmlHead($obdata){
        $XmlContent = "<head>";
            $XmlContent .= "<Version>".self::Version."</Version>";
            $XmlContent .= "<MerCode>".self::MerCode."</MerCode>";
            $XmlContent .= "<MerName>".self::MerName."</MerName>";
            $XmlContent .= "<Account>".self::Account."</Account>";
            $XmlContent .= "<MsgId>{$obdata['MsgId']}</MsgId>";
            $XmlContent .= "<ReqDate>{$obdata['ReqDate']}</ReqDate>";
            $XmlContent .= "<Signature>{$this->Signature($this->BuildXmlBody($obdata),self::MerCode,self::Key)}</Signature>";
        $XmlContent .= "</head>";
        return $XmlContent;
    }
    public function BuildXmlBody($obdata){
        $XmlContent = "<body>";
            $XmlContent .= "<MerBillNo>{$obdata['MerBillNo']}</MerBillNo>";
            $XmlContent .= "<Amount>{$obdata['Amount']}</Amount>";
            $XmlContent .= "<Date>{$obdata['Date']}</Date>";
            $XmlContent .= "<CurrencyType>{$obdata['CurrencyType']}</CurrencyType>";
            $XmlContent .= "<GatewayType>{$obdata['GatewayType']}</GatewayType>";
            $XmlContent .= "<Lang>{$obdata['Lang']}</Lang>";
            $XmlContent .= "<Merchanturl>{$obdata['Merchanturl']}</Merchanturl>";
            $XmlContent .= "<FailUrl>{$obdata['FailUrl']}</FailUrl>";
            $XmlContent .= "<Attach>{$obdata['Attach']}</Attach>";
            $XmlContent .= "<OrderEncodeType>{$obdata['OrderEncodeType']}</OrderEncodeType>";
            $XmlContent .= "<RetEncodeType>{$obdata['RetEncodeType']}</RetEncodeType>";
            $XmlContent .= "<RetType>{$obdata['RetType']}</RetType>";
            $XmlContent .= "<ServerUrl>{$obdata['ServerUrl']}</ServerUrl>";
            $XmlContent .= "<BillEXP>{$obdata['BillEXP']}</BillEXP>";
            $XmlContent .= "<GoodsName>{$obdata['GoodsName']}</GoodsName>";
            $XmlContent .= "<IsCredit>{$obdata['IsCredit']}</IsCredit>";
            $XmlContent .= "<BankCode>{$obdata['BankCode']}</BankCode>";
            $XmlContent .= "<ProductType>{$obdata['ProductType']}</ProductType>";
        $XmlContent .= "</body>";
        return $XmlContent;
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
    //订单生成
    public function build_order_no(){
        return date('Ymd').substr(implode(array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }
    //订单号生成
    public function build_order_noX($len = 5){
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );
        $charsLen = count($chars) - 1;
        shuffle($chars);    // 将数组打乱
        $output = "";
        for ($i = 0; $i < $len; $i++) {
            $output .= $chars[mt_rand(0, $charsLen)];
        };
        $resqn = 'QD_'.date('Ymd').date ( 'His' ).$output;
        echo json_encode(array('resqn' => $resqn));
    }
    //生成签名
    public function addSign(){
       $payData = $this->BuildObData();
       $signData = $this->Signature($this->BuildXmlBody($payData),self::MerCode,self::Key);
       echo json_encode(array("resqn"=>$signData));
    }
    //数字签名
    public function Signature($PayData,$MerCode,$key){
        $signature = md5($PayData.$MerCode.$key);
        return $signature;
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
    //随机字符串
    public function Mer_shuffle(){
        $int_arr = range(0,9);
        $str_arr = range("a","z");
        $str1 = $this->mb_splitchar(self::MerName);
        $new_arr = array_merge($int_arr,$str_arr);
        shuffle($new_arr);
        $strData = $str1.implode($new_arr);
        $new_str = substr($strData,0,32);
        return $new_str;
    }


}