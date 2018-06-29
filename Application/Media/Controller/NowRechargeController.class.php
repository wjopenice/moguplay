<?php
namespace Media\Controller;
use Think\Controller;
use Admin\Model\GameModel;
use Common\Api\PayApi;
use Org\Itppay\itppay;
/**
 * 文档模型控制器
 * 文档模型列表和详情
 */
class NowRechargeController extends BaseController {

    /**
     *充值
     *@author hxh
    */
    public function beginPay(){
    	//file_put_contents('E:/sssssss.html',json_encode($_POST));
    	$user = get_user_entity($_POST['account'],true);
        #支付配置
        switch ($_POST['apitype']) {
            case 'alipay':
                $PayChannel = 12;
                $mhtOrderDetail = "支付宝平台币充值";
                break;
            case 'weixin':
                $PayChannel = 13;
                $mhtOrderDetail = "微信平台币充值";
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

        $AppId = C('Now.appid');
        $AppKey = C('Now.appkey');
        #支付配置
        $data["appId"] = $AppId;
        $data['funcode'] = 'WP001';
        $data['mhtOrderNo'] = 'PF_'.date('Ymd').date ( 'His' ).sp_random_string(4);
        $data['mhtOrderName'] = "充值";
        $data['mhtOrderType'] = '01';
        $data['mhtCurrencyType'] = '156';
        $data["mhtOrderAmt"] = '1';//$_POST['money'] * 100;
        $data["mhtOrderDetail"] = $mhtOrderDetail;
        $data["mhtOrderStartTime"] = date("YmdHis");
        $data["notifyUrl"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php";
        $data['mhtCharset'] = 'UTF-8';
        $data['deviceType'] = '08';
        $data['payChannelType'] = $PayChannel;
        $data['mhtReserved'] = 'test';
        $data['mhtSignType'] = 'MD5';
        $data['version'] = '1.0.0';
        $data['outputType'] = '1';

        $data["mhtSignature"] = $this->SignArray($data,$AppKey);//签名
        ksort($data);
        $paramsStr = $this->ToUrlParams($data);

        $url = C('Now.url');
        $response = self::request($url, $paramsStr);

        if($response){
            $response = explode('&', $response);
            foreach ($response as $key => $value) {
                $rsparr = explode('=', $value);
                $rspArray[$rsparr[0]] = urldecode($rsparr[1]);
            }

            if($this->ValidSign($rspArray,$AppKey)){
                //添加充值记录
                $this->add_deposit($data,$user);
                if($_POST['apitype'] == "alipay"){
                    $png_img = "/Public/Media/image/zfb_pay_tips.png";
                }else{
                    $png_img = "/Public/Media/image/wx_pay_tips.png";
                }

                $html ='<div class="d_body" style="height:px;">
                        <div class="d_content">
                            <div class="text_center">
                                <table class="list" width="100%">
                                    <tbody>
                                    <tr>
                                        <td class="text_right">订单号</td>
                                        <td class="text_left">'.$data["mhtOrderNo"].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text_right">充值金额</td>
                                        <td class="text_left">本次充值'.$_POST['money'].'元，实际付款'.$_POST['money'].'元</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <img src="' . __MODULE__ . '/Recharge/qrcode/url/'.base64_encode($rspArray['tn']).'"  height="301" width="301" >
                                <img src="'.$png_img.'">
                            </div>
                        </div>
                    </div>';
                $json_data = array("status"=>1,"html"=>$html);

                $this->ajaxReturn($json_data);

            }else{
                $html ='<div class="d_body" style="height:px;">
                        <div class="d_content">
                            <div class="text_center">respMsg:'.$rspArray["responseMsg"].'</div>
                            <div class="text_center">respCode:'.$rspArray["responseCode"].'</div>
                        </div>
                        </div>';
                $json_data = array("status"=>1,"html"=>$html);
                $this->ajaxReturn($json_data);
            }
        }else{
            $html ='<div class="d_body" style="height:px;">
                    <div class="d_content">
                        <div class="text_center">respMsg:请求异常！</div>
                    </div>
                    </div>';
            $json_data = array("status"=>1,"html"=>$html);
            $this->ajaxReturn($json_data);
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
     *平台币充值记录
     */
    private function add_deposit($data,$user = array())
    {
        
        $deposit = M("deposit", "tab_");
        $deposit_data['order_number'] = "";
        $deposit_data['pay_order_number'] = $data['mhtOrderNo'];
        $deposit_data['user_id'] = $user['id'];
        $deposit_data['user_account'] = $user['account'];
        $deposit_data['user_nickname'] = $user['nickname'];
        $deposit_data['promote_id'] = $user['promote_id'];
        $deposit_data['promote_account'] = $user['promote_account'];
        $deposit_data['pay_amount'] = $data['mhtOrderAmt'];
        $deposit_data['pay_status'] = 0;
        $deposit_data['pay_way'] = $data['payChannelType'] == 12 ? 1 : 2 ;
        $deposit_data['pay_type'] = 9;
        $deposit_data['pay_source'] = 0;
        $deposit_data['pay_ip'] = get_client_ip();
        $deposit_data['pay_source'] = 0;
        $deposit_data['create_time'] = NOW_TIME;
        $result = $deposit->add($deposit_data);
        return $result;
        
    }


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

    //验签
    function validSign($array,$key){
        if($array['responseCode'] == 'A001') {
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
