<?php
namespace Media\Controller;
use Think\Controller;
use Admin\Model\GameModel;
use Common\Api\PayApi;
use Org\Itppay\itppay;
/**
 * 环迅文档模型控制器
 * 文档模型列表和详情
 */
class IpsRechargeController extends BaseController {

    /**
     *充值
     *@author whh 
    */
    public function beginPay(){
    	
    	$user = get_user_entity($_POST['account'],true);
        #支付配置
		$data['MerBillNo'] = 'PF_'.date('Ymd').date ( 'His' ).sp_random_string(4);
        $data['Version'] = 'v1.0.0';
        $data['MsgId'] = '00001';
		$data["MerCode"] = C('Ips.MerCode');
        $data["Account"] = C('Ips.Account');
        $data["MerName"] = C('Ips.MerName');
        $data["ReqDate"] = date("YmdHis");
        $data["Date"] = date("Ymd"); 
        $data["RetEncodeType"] = '17';
        $data["CurrencyType"] = '156';
        $data["Amount"] = 1;//$_POST['money'];//
        $data["GoodsName"] = "平台币";
        $data["ServerUrl"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyIps/notify";
        $data['Attach'] = '';
        $data['SpbillCreateIp'] = get_client_ip();
        $data["Lang"] = 'GB';
        $data["BillEXP"] = '2';
        $data["MerType"]   = '0';
		switch ($_POST['apitype']) {
			case 'alipay':
                $data["GatewayType"] = '11';
				break;
			case 'weixin':
                $data["GatewayType"] = '10';
                break;
			default:
				$html ='<div class="d_body" style="height:px;">
                            <div class="d_content">
                                <div class="text_center">请选择支付方式</div>
                            </div>
                            </div>';
                $json_data = array("status"=>1,"html"=>$html);
                $this->ajaxReturn($json_data);
				break;
		}
        
        $html_text = $this->buildRequest($data);
        $this->ajaxReturn($html_text);return;

        $xmlResult = new \SimpleXMLElement($html_text);
        $strRspCode = $xmlResult->GateWayRsp->head->RspCode;
        
        if($strRspCode == "000000")
        {
            $this->ajaxReturn($this->validSign($html_text));return;
            //返回报文验签
            if($this->validSign($html_text)){
                //添加充值记录
                //$this->add_deposit($data,$user);
                if($_POST['apitype'] == "alipay"){
                    $png_img = "/Public/Media/image/zfb_pay_tips.png";
                }else{
                    $png_img = "/Public/Media/image/wx_pay_tips.png";
                }

                $trxamt = $data["Amount"]/100;
                $strQrCodeUrl = $xmlResult->GateWayRsp->body->QrCode;

                $html ='<div class="d_body" style="height:px;">
                        <div class="d_content">
                            <div class="text_center">
                                <table class="list" width="100%">
                                    <tbody>
                                    <tr>
                                        <td class="text_right">订单号</td>
                                        <td class="text_left">'.$data["MerBillNo"].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text_right">充值金额</td>
                                        <td class="text_left">本次充值'.$trxamt.'元，实际付款'.$trxamt.'元</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <img src="' . __MODULE__ . '/Recharge/qrcode/url/'.base64_encode($strQrCodeUrl).'"  height="301" width="301" >
                                <img src="'.$png_img.'">
                            </div>
                        </div>
                    </div>';
                $json_data = array("status"=>1,"html"=>$html);

                $this->ajaxReturn($json_data);

            }

        }else{
            $message = $xmlResult->GateWayRsp->head->RspMsg;
            \Think\Log::record($message);
            $html ='<div class="d_body" style="height:px;">
                    <div class="d_content">
                        <div class="text_center">respMsg:'.$message.'</div>
                        <div class="text_center">respCode:'.$strRspCode.'</div>
                    </div>
                    </div>';
            $json_data = array("status"=>1,"html"=>$html);
            $this->ajaxReturn($json_data);
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

            $client=new \SoapClient(C('Ips.APIURL'));
            
            $sReqXml = $client->scanPay($para);

            return array($para,$sReqXml);
        } catch (Exception $e) {
            $this->ajaxReturn(array("status"=>1,"html"=>"扫码支付请求异常:" . $e));
        }
       return null;
    }
    
    /**
     * 生成要请求给IPS的参数XMl
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数XMl
     */
    function buildRequestPara($para_temp,$type = 1) {
        $sReqXml = "<Ips>";
        $sReqXml .= "<GateWayReq>";
        $sReqXml .= $this->buildHead($para_temp,$type);
        $sReqXml .= $this->buildBody($para_temp,$type);
        $sReqXml .= "</GateWayReq>";
        $sReqXml .= "</Ips>";
        return $sReqXml;
    }
    /**
     * 请求报文头
     * @param   $para_temp 请求前的参数数组
     * @return 要请求的报文头
     */
    function buildHead($para_temp,$type){
        $sReqXmlHead = "<head>";
        $sReqXmlHead .= "<Version>".$para_temp["Version"]."</Version>";
        $sReqXmlHead .= "<MerCode>".$para_temp["MerCode"]."</MerCode>";
        $sReqXmlHead .= "<MerName>".$para_temp["MerName"]."</MerName>";
        $sReqXmlHead .= "<Account>".$para_temp["Account"]."</Account>";
        $sReqXmlHead .= "<MsgId>".$para_temp["MsgId"]."</MsgId>";
        $sReqXmlHead .= "<ReqDate>".$para_temp["ReqDate"]."</ReqDate>";
        $sReqXmlHead .= "<Signature>".md5Sign($this->buildBody($para_temp,$type),$para_temp["MerCode"],C('Ips.MerCert'))."</Signature>";
        $sReqXmlHead .= "</head>";
        return $sReqXmlHead;
    }
    
    /**
     *  请求报文体
     * @param  $para_temp 请求前的参数数组
     * @return 要请求的报文体
     */
    function buildBody($para_temp,$type){
        $sReqXmlBody = "<body>";
        /*foreach ($value_array as $key=>$val)
        {
            if (is_numeric($val)){
                $sReqXmlBody.="<".$key.">".$val."</".$key.">";
            }
        }*/
        if ($type == 1) {
            $sReqXmlBody .= "<MerBillNo>".$para_temp["MerBillNo"]."</MerBillNo>";
            $sReqXmlBody .= "<GatewayType>".$para_temp["GatewayType"]."</GatewayType>";
            $sReqXmlBody .= "<Date>".$para_temp["Date"]."</Date>";
            $sReqXmlBody .= "<CurrencyType>".$para_temp["CurrencyType"]."</CurrencyType>";
            $sReqXmlBody .= "<Amount>".$para_temp["Amount"]."</Amount>";
            $sReqXmlBody .= "<Lang>".$para_temp["Lang"]."</Lang>";
            $sReqXmlBody .= "<SpbillCreateIp>".$para_temp["SpbillCreateIp"]."</SpbillCreateIp>";
            $sReqXmlBody .= "<Attach>".$para_temp["Attach"]."</Attach>";
            $sReqXmlBody .= "<RetEncodeType>".$para_temp["RetEncodeType"]."</RetEncodeType>";
            $sReqXmlBody .= "<ServerUrl>".$para_temp["ServerUrl"]."</ServerUrl>";
            $sReqXmlBody .= "<BillEXP>".$para_temp["BillEXP"]."</BillEXP>";
            $sReqXmlBody .= "<GoodsName>".$para_temp["GoodsName"]."</GoodsName>";
            $sReqXmlBody .= "<MerType>".$para_temp["MerType"]."</MerType>";
        }else{
            $sReqXmlBody .= "<MerBillNo>".$para_temp["MerBillNo"]."</MerBillNo>";
            $sReqXmlBody .= "<GatewayType>".$para_temp["GatewayType"]."</GatewayType>";
            $sReqXmlBody .= "<Date>".$para_temp["Date"]."</Date>";
            $sReqXmlBody .= "<CurrencyType>".$para_temp["CurrencyType"]."</CurrencyType>";
            $sReqXmlBody .= "<Amount>".$para_temp["Amount"]."</Amount>";
            $sReqXmlBody .= "<Lang>".$para_temp["Lang"]."</Lang>";
            $sReqXmlBody .= "<Merchanturl>".$para_temp["Merchanturl"]."></Merchanturl>";
            $sReqXmlBody .= "<FailUrl><![CDATA[".$para_temp["FailUrl"]."]]></FailUrl>";
            $sReqXmlBody .= "<Attach><![CDATA[".$para_temp["Attach"]."]]></Attach>";
            $sReqXmlBody .= "<OrderEncodeType>".$para_temp["OrderEncodeType"]."</OrderEncodeType>";
            $sReqXmlBody .= "<RetEncodeType>".$para_temp["RetEncodeType"]."</RetEncodeType>";
            $sReqXmlBody .= "<RetType>".$para_temp["RetType"]."</RetType>";
            $sReqXmlBody .= "<ServerUrl><![CDATA[".$para_temp["ServerUrl"]."]]></ServerUrl>";
            $sReqXmlBody .= "<BillEXP>".$para_temp["BillEXP"]."</BillEXP>";
            $sReqXmlBody .= "<GoodsName>".$para_temp["GoodsName"]."</GoodsName>";
            $sReqXmlBody .= "<IsCredit>".$para_temp["IsCredit"]."</IsCredit>";
            $sReqXmlBody .= "<BankCode>".$para_temp["BankCode"]."</BankCode>";
            $sReqXmlBody .= "<ProductType>".$para_temp["ProductType"]."</ProductType>";
        }
        
        $sReqXmlBody .= "</body>";
        return $sReqXmlBody;
    }



    //验签
    function validSign($param){
        try {
            
            $xmlResult = new \SimpleXMLElement($param);
            $strSignature = $xmlResult->GateWayRsp->head->Signature;
            
            $strBody = $this->subStrXml("<body>", "</body>", $param);
            
            if (md5Verify($strBody, $strSignature, C('Ips.MerCode'), C('Ips.MerCert'))) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

    function subStrXml($begin,$end,$str){
        $b= (strpos($str,$begin));
        $c= (strpos($str,$end));
        
        return substr($str,$b,$c-$b + 7);
    }


     /**
     *平台币充值记录
     */
    private function add_deposit($data,$user = array())
    {
        
        $deposit = M("deposit", "tab_");
        $deposit_data['order_number'] = "";
        $deposit_data['pay_order_number'] = $data['MerBillNo'];
        $deposit_data['user_id'] = $user['id'];
        $deposit_data['user_account'] = $user['account'];
        $deposit_data['user_nickname'] = $user['nickname'];
        $deposit_data['promote_id'] = $user['promote_id'];
        $deposit_data['promote_account'] = $user['promote_account'];
        $deposit_data['pay_amount'] = $data['Amount'];
        $deposit_data['pay_status'] = 0;
        $deposit_data['pay_type'] = 2;
        $deposit_data['pay_way'] = $data['GatewayType'] == '11' ? 1 : 2 ;
        $deposit_data['pay_source'] = 0;
        $deposit_data['pay_ip'] = get_client_ip();
        $deposit_data['pay_source'] = 0;
        $deposit_data['create_time'] = NOW_TIME;
        $result = $deposit->add($deposit_data);
        return $result;
        
    }

     /**
     *平台币充值记录
     */
    private function add_pan_deposit($data,$user = array())
    {
        
        $deposit = M("deposit", "tab_");
        $deposit_data['order_number'] = "";
        $deposit_data['pay_order_number'] = $data['MerBillNo'];
        $deposit_data['user_id'] = $user['id'];
        $deposit_data['user_account'] = $user['account'];
        $deposit_data['user_nickname'] = $user['nickname'];
        $deposit_data['promote_id'] = $user['promote_id'];
        $deposit_data['promote_account'] = $user['promote_account'];
        $deposit_data['pay_amount'] = $data['Amount'];
        $deposit_data['pay_status'] = 0;
        $deposit_data['pay_way'] = 3 ;
        $deposit_data['pay_type'] = 2;
        $deposit_data['pay_source'] = 0;
        $deposit_data['pay_ip'] = get_client_ip();
        $deposit_data['pay_source'] = 0;
        $deposit_data['create_time'] = NOW_TIME;
        $result = $deposit->add($deposit_data);
        return $result;
        
    }

    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @return 提交表单HTML文本
     */
    function panBuildRequest($para_temp) {
        try {
            $para = $this->buildRequestPara($para_temp,2);

            return $para;
        } catch (Exception $e) {
            $this->ajaxReturn(array("status"=>1,"html"=>"支付请求异常:" . $e));
        }
       return null;
    }

    /**
     * 网银支付
    */
    public function panPay($value='')
    {
        $user = get_user_entity($_POST['account'],true);
        #支付配置
        $data['MerBillNo'] = 'PF_'.date('Ymd').date ( 'His' ).sp_random_string(4);
        $data['Version'] = 'v1.0.0';
        $data['MsgId'] = '00001';
        $data["MerCode"] = C('Ips.MerCode');
        $data["Account"] = C('Ips.Account');
        $data["MerName"] = C('Ips.MerName');
        $data["ReqDate"] = date("YmdHis");
        $data["Date"] = date("Ymd"); 
        $data["RetEncodeType"] = '17';
        $data["CurrencyType"] = '156';
        $data["Amount"] = 0.01;//$_POST['money'];//
        $data["GoodsName"] = "平台币";
        $data["ServerUrl"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyIps/pan_notify";
        $data["Merchanturl "] = "http://".$_SERVER['HTTP_HOST']."/media.php?s=/Index/index.html";
        $data["FailUrl "] = "http://".$_SERVER['HTTP_HOST']."/media.php?s=/Recharge/chongzhi/type/2.html";
        $data['Attach'] = '商户数据包';
        $data["Lang"] = 'GB';
        $data["BillEXP"] = '2';
        $data["OrderEncodeType"] = '5';
        $data['RetType'] = "1";
        $data["MerType"]   = '0';
        $data["GatewayType"] = '01';
        $data['IsCredit'] = '';
        $data['BankCode'] = '';
        $data['ProductType'] = '';

        $html_text = $this->panBuildRequest($data);

        $re = $this->add_pan_deposit($data,$user);
        if($re){
            $json_data = array("status"=>1,"data"=>$html_text);
        }else{
            $json_data = array("status"=>0,'支付请求异常');
        }
        $this->ajaxReturn($json_data);
        
    }





}
