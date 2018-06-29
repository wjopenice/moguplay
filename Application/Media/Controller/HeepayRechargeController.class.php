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
class HeepayRechargeController extends BaseController {

    /**
     *充值
     *@author hxh
    */
    public function beginPay(){
    	//file_put_contents('E:/sssssss.html',json_encode($_POST));
    	$user = get_user_entity($_POST['account'],true);
        #支付配置
        $data["version"] = C('Heepay.version');
        $data["agent_id"] = C('Heepay.agent_id');
		$data['agent_bill_id'] = 'PF_'.date('Ymd').date ( 'His' ).sp_random_string(4);
        $data['agent_bill_time'] = date("YmdHis");
        switch ($_POST['apitype']) {
            case 'alipay':
                $data["pay_type"] = 22;
                break;
            case 'weixin':
                $data["pay_type"] = 30;
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
        $data["pay_amt"] = $_POST['money'];//单位：元
        $data["notify_url"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyHeepay/notify";
        $data["return_url"] = "http://".$_SERVER['HTTP_HOST']."/media.php?s=/Index/index.html";
        $data['user_ip'] = strtr(get_client_ip(),".","_");

        $data["sign"] = $this->SignArray($data,C('Heepay.key'));//签名
        $data['goods_name'] = $data['remark'] = 'recharge';

        $paramsStr = $this->ToUrlParams($data);
        $url = C('Heepay.api_url'); 
        //$rsp = $this->request($url, $paramsStr);
        //$rspArray = json_decode($rsp, true);
        $this->add_deposit($data,$user);
        $this->ajaxReturn(array('pay'=>$url."?".$paramsStr));exit; 
        /*$rspArray = array(
            'code' => '0000',
            'qr_code_url' => 'https://qr.alipay.com/upx03087paad0wynobuh205c',
            'message' =>'success',
        );*/
        if($this->validSign($rspArray)){
            //添加充值记录
            //$this->add_deposit($data,$user);
            if($_POST['apitype'] == "alipay"){
                $png_img = "/Public/Media/image/zfb_pay_tips.png";
            }else{
                $png_img = "/Public/Media/image/wx_pay_tips.png";
            }

            $trxamt = $data["pay_amt"];

            $html ='<div class="d_body" style="height:px;">
                    <div class="d_content">
                        <div class="text_center">
                            <table class="list" width="100%">
                                <tbody>
                                <tr>
                                    <td class="text_right">订单号</td>
                                    <td class="text_left">'.$data["agent_bill_id"].'</td>
                                </tr>
                                <tr>
                                    <td class="text_right">充值金额</td>
                                    <td class="text_left">本次充值'.$trxamt.'元，实际付款'.$trxamt.'元</td>
                                </tr>
                                </tbody>
                            </table>
                            <img src="' . __MODULE__ . '/Recharge/qrcode/url/'.base64_encode($rspArray['qr_code_url']).'"  height="301" width="301" >
                            <img src="'.$png_img.'">
                        </div>
                    </div>
                </div>';
            $json_data = array("status"=>1,"html"=>$html);

            $this->ajaxReturn($json_data);

        }else{
            \Think\Log::record($rspArray["retmsg"]);
            $html ='<div class="d_body" style="height:px;">
                    <div class="d_content">
                        <div class="text_center">respMsg:'.$rspArray["message"].'</div>
                        <div class="text_center">respCode:'.$rspArray["code"].'</div>
                    </div>
                    </div>';
            $json_data = array("status"=>1,"html"=>$html);
            $this->ajaxReturn($json_data);
        }

		
    }


    /**
     * 将参数数组签名
     */
    public function SignArray(array $array,$appkey){
        $array['key'] = $appkey;// 将key放到数组中一起进行排序和组装
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


    //验签
    function validSign($array){
        if( "success" == $array["message"] && $array["code"] == '0000'){
            /*$signRsp = strtolower($array["sign"]);
            $array["sign"] = "";
            $sign =  strtolower($this->SignArray($array, self::APPKEY));
            if($sign==$signRsp){*/
                return TRUE;
            //}
            //else {
               // return FALSE;
            //}
        }
        else{
            return FALSE;
        }
        
        return FALSE;
    }

    /**
     * 随机字符串
     */
    function getRandom(){
        $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
         $key = $str{mt_rand(0,32)};    //生成php随机数
         return $key;
    }


     /**
     *平台币充值记录
     */
    private function add_deposit($data,$user = array())
    {
        
        $deposit = M("deposit", "tab_");
        $deposit_data['order_number'] = "";
        $deposit_data['pay_order_number'] = $data['agent_bill_id'];
        $deposit_data['user_id'] = $user['id'];
        $deposit_data['user_account'] = $user['account'];
        $deposit_data['user_nickname'] = $user['nickname'];
        $deposit_data['promote_id'] = $user['promote_id'];
        $deposit_data['promote_account'] = $user['promote_account'];
        $deposit_data['pay_amount'] = $data['pay_amt'];
        $deposit_data['pay_status'] = 0;
        $deposit_data['pay_way'] = $data['pay_type'] == 22 ? 1 : 2 ;
        $deposit_data['pay_type'] = 3;
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
        $deposit_data['pay_order_number'] = $data['orderNo'];
        $deposit_data['user_id'] = $user['id'];
        $deposit_data['user_account'] = $user['account'];
        $deposit_data['user_nickname'] = $user['nickname'];
        $deposit_data['promote_id'] = $user['promote_id'];
        $deposit_data['promote_account'] = $user['promote_account'];
        $deposit_data['pay_amount'] = $data['orderAmount']/100;
        $deposit_data['pay_status'] = 0;
        $deposit_data['pay_type'] = 3;
        $deposit_data['pay_way'] = 3 ;
        $deposit_data['pay_source'] = 0;
        $deposit_data['pay_ip'] = get_client_ip();
        $deposit_data['pay_source'] = 0;
        $deposit_data['create_time'] = NOW_TIME;
        $result = $deposit->add($deposit_data);
        return $result;
        
    }

    
    /**
     * 网银支付
    */
    public function panPay(){
        
        $user = get_user_entity($_POST['account'],true);
        #支付配置
        $data["version"] = C('Heepay.version');
        $data["agent_id"] = C('Heepay.agent_id');
        $data['agent_bill_id'] = 'PF_'.date('Ymd').date ( 'His' ).sp_random_string(4);
        $data['agent_bill_time'] = date("YmdHis");
        $data["pay_type"] = 19;
        $data["pay_amt"] = $_POST['money'];//单位：元
        $data["notify_url"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyHeepay/notify";
        $data["return_url"] = "http://".$_SERVER['HTTP_HOST']."/media.php?s=/Index/index.html";
        $data['user_ip'] = strtr(get_client_ip(),".","_");

        $data["sign"] = $this->SignArray($data,C('Heepay.key'));//签名
        $data['goods_name'] = $data['remark'] = 'recharge';

        $paramsStr = $this->ToUrlParams($data);
        $url = C('Heepay.api_url'); 

        $re = $this->add_pan_deposit($data,$user);
        if($re){
            $json_data = array("status"=>1,'pay'=>$url."?".$paramsStr);
        }else{
            $json_data = array("status"=>0);
        }
        $this->ajaxReturn($json_data);
        //$paramsStr = $this->ToUrlParams($data);
        
        //$this->redirect($url, $data);
        //$rsp = $this->file_get_contents_post($url, $data);
       //var_dump($rsp);exit;


        
    }


    function get_total_millisecond(){  
        $date =  date("Y:m:d h:i:s",time()); 
        $time = strtr($date, array(":" => ''," " => ''));

        return $time;  
    }


    function panSignArray(array $array,$appkey){

        $array['key'] = $appkey;// 将key放到数组中一起进行排序和组装
        //ksort($array);
        $blankStr = $this->ToUrlParams($array);
        $sign = strtoupper(md5($blankStr));    
        return $sign;
    } 


    /**
     * 发送post请求
     * @param string $url 请求地址
     * @param array $post_data post键值对数据
     * @return string
     */
    function file_get_contents_post($url, $post_data){
     
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
    



     /*
      *  充值页广告图
      *  @author   whh
      */
   
   public function adv_recharge(){
        $adv = M("Adv","tab_");
        $map['status'] = 1;
        $map['pos_id'] = 12; #充值页广告图id
        $adv_recharg = $adv->where($map)->order('sort ASC')->select();
        $adv_data=$adv_recharg['0'];
        $this->assign("adv_recharg",$adv_data);
    }



}
