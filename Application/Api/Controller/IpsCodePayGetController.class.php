<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/19
 * Time: 9:33
 */

namespace Api\Controller;

class IpsCodePayGetController extends BaseController{
    //版本号
    const Version = "v1.0.0";
    //请求地址
    const ApiUrl = "https://newpay.ips.com.cn/psfp-entry/services/trade?wsdl";
    //商户号
    const MerCode = "207973";
    //商户名称
    const MerName = "广州堡庆网络科技有限公司";
    //商户账户
    const Account = "2079730012";
    //加密证书
    const Key = "X12DYVzevDOVmFpYopdMQVwdG2pKg8MtycWHxTvZ5gNNlJe8AAeTP4X4t1NdZuOOrlDRDWHvy6FfH5cAcUF5dH15BESxdLRmQ8KQlNJN2TU4Oyvz8qXpds3hymjjJMSp";
    //查询订单
    public function IpsPayGet($para_temp){
        try {
            $para = $this->buildRequestPara($para_temp);
            $wsdl = self::ApiUrl;
            $client=new \SoapClient($wsdl);
            if($para_temp['QueryType'] == "1"){
                $sReqXml = $client->getTradeByMerBillNo($para);
            }else if($para_temp['QueryType'] == "2"){//按银行订单号
                $sReqXml = $client->getOrderByBankNo($para);
            }
            return $sReqXml;
        } catch (Exception $e) {
            echo "订单查询请求异常:" . $e;
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
        $sReqXml .= "<OrderQueryReq>";
        $sReqXml .= $this->buildHead($para_temp);
        //按商户订单号
        if($para_temp['QueryType'] == "1"){
            $sReqXml .= $this->buildBody($para_temp);
        }elseif($para_temp['QueryType'] == "2"){//按银行订单号
            $sReqXml .= $this->buildBodyBank($para_temp);
        }else { //按商户订单时间
            $sReqXml .= $this->buildBodyTime($para_temp);
        }

        $sReqXml .= "</OrderQueryReq>";
        $sReqXml .= "</Ips>";
        //Log::DEBUG("订单查询请求报文:" . $sReqXml);
        return $sReqXml;
    }
    /**
     * 请求报文头
     * @param   $para_temp 请求前的参数数组
     * @return 要请求的报文头
     */
    public function buildHead($para_temp){
        $sReqXmlHead = "<head>";
        $sReqXmlHead .= "<Version>".self::Version."</Version>";
        $sReqXmlHead .= "<MerCode>".self::MerCode."</MerCode>";
        $sReqXmlHead .= "<MerName>".self::MerName."</MerName>";
        $sReqXmlHead .= "<Account>".self::Account."</Account>";
        $sReqXmlHead .= "<ReqDate>".$para_temp["ReqDate"]."</ReqDate>";
        //按商户订单号
        if($para_temp['QueryType'] == "1"){
            $sReqXmlHead .= "<Signature>".$this->md5Sign($this->buildBody($para_temp),self::MerCode,self::Key)."</Signature>";
        }elseif($para_temp['QueryType'] == "2"){//按银行订单号
            $sReqXmlHead .= "<Signature>".$this->md5Sign($this->buildBodyBank($para_temp),self::MerCode,self::Key)."</Signature>";
        }else { //按商户订单时间
            $sReqXmlHead .= "<Signature>".$this->md5Sign($this->buildBodyTime($para_temp),self::MerCode,self::Key)."</Signature>";
        }

        $sReqXmlHead .= "</head>";
        return $sReqXmlHead;
    }
    /**
     *  请求报文体
     * @param  $para_temp 请求前的参数数组
     * @return 要请求的报文体
     */
    public function buildBody($para_temp){
        $sReqXmlBody = "<body>";
        $sReqXmlBody .= "<MerBillNo>".$para_temp["MerBillNo"]."</MerBillNo>";
        $sReqXmlBody .= "<Date>".$para_temp["Date"]."</Date>";
        $sReqXmlBody .= "<Amount>".$para_temp["Amount"]."</Amount>";
        $sReqXmlBody .= "</body>";
        return $sReqXmlBody;
    }
    /**
     *  请求报文体
     * @param  $para_temp 请求前的参数数组
     * @return 要请求的报文体
     */
     public function buildBodyBank($para_temp){
        $sReqXmlBody = "<body>";
        $sReqXmlBody .= "<Status>".$para_temp["Status"]."</Status>";
        $sReqXmlBody .= "<TradeType>".$para_temp["TradeType"]."</TradeType>";
        $sReqXmlBody .= "<BankBillNo>".$para_temp["BankBillNo"]."</BankBillNo>";
        $sReqXmlBody .= "<Page>".$para_temp["Page"]."</Page>";
        $sReqXmlBody .= "<PageSize>".$para_temp["PageSize"]."</PageSize>";
        $sReqXmlBody .= "</body>";

        return $sReqXmlBody;
    }
    /**
     *  请求报文体
     * @param  $para_temp 请求前的参数数组
     * @return 要请求的报文体
     */
     public function buildBodyTime($para_temp){
        $sReqXmlBody = "<body>";
        $sReqXmlBody .= "<Status>".$para_temp["Status"]."</Status>";
        $sReqXmlBody .= "<TradeType>".$para_temp["TradeType"]."</TradeType>";
        $sReqXmlBody .= "<StartTime>".$para_temp["StartTime"]."</StartTime>";
        $sReqXmlBody .= "<EndTime>".$para_temp["EndTime"]."</EndTime>";
        $sReqXmlBody .= "<Page>".$para_temp["Page"]."</Page>";
        $sReqXmlBody .= "<PageSize>".$para_temp["PageSize"]."</PageSize>";
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
    public function md5Sign($prestr,$merCode, $key) {
        $prestr = $prestr . $merCode . $key;
        return md5($prestr);
    }

    /**
     * 验证签名
     * @param $prestr 需要签名的字符串
     * @param $sign 签名结果
     * @param $merCode 商戶號
     * @param $key 私钥
     * return 签名结果
     */
    public function md5Verify($prestr, $sign,$merCode, $key) {
        $prestr = $prestr .$merCode. $key;
        $mysgin = md5($prestr);

        if($mysgin == $sign) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * php截取<body>和</body>之間字符串
     * @param string $begin 开始字符串
     * @param string $end 结束字符串
     * @param string $str 需要截取的字符串
     * @return string
     */
    public function subStrXml($begin,$end,$str){
        $b= (strpos($str,$begin));
        $c= (strpos($str,$end));

        return substr($str,$b,$c-$b + strlen($end));
    }

}