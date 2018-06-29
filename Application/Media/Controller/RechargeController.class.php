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
class RechargeController extends BaseController {
    const APPID = '00018876';
    const CUSID = '55059304816K9C0';
    const APPKEY = '2018Z0303B';
    const APIURL = "https://vsp.allinpay.com/apiweb/unitorder";//生产环境
    const APIVERSION = '11';

    const PANURL = "http://ceshi.allinpay.com/gateway/index.do";//"https://service.allinpay.com/gateway/index.do";//网银url 
    const PANCUSID_1 = '100020091218001';//'109020201803038';
    const PANCUSID_2 = '100020091218001';//'109020201803038';
    const PANAPPKEY = '1234567890';

    public function chongzhi(){
        // $this->qrcode(base64_encode("https://qr.alipay.com/bax03628uqg7wzvji3hg6003"));exit;
        // $this->qrcode(base64_encode("weixin://wxpay/bizpayurl?pr=gKOK4Id"));exit;
    	$wheresign['name']='ALIPAY_POINT_SIGN';
        $alipay_points_sign=M('config','sys_')->where($wheresign)->getfield('value');
        //$sql=M('config','sys_')->getlastsql();
        //print_r($sql);exit;
        $this->assign('url',self::PANURL);
        $this->assign('version',"v1.0");
        $this->assign('pickupUrl',"http://".$_SERVER['HTTP_HOST']."/media.php?s=/Index/index.html");
        $this->assign('receiveUrl',"http://" . $_SERVER['HTTP_HOST'] . "/callback.php/NotifyPF/pan_notify");
        $this->assign('points',$alipay_points_sign);
        $this->assign('account',session('member_auth.account'));
        $this->adv_recharge();
        $this->display();
    }

    /**
     *支付宝充值判断用户是否存在
     *@author whh 
    */
    public function checkUser(){
    	//file_put_contents('E:/bbbbb.html',json_encode($_POST['username']));
        #判断账号是否存在
		$user = get_user_entity($_POST['username'],true);
		//file_put_contents('E:/bbbbb.html',json_encode($user));
		if(empty($user)){
			$msg="用户不存在";
			echo json_encode($msg);exit();
		}
		//判断是否开启支付宝充值
		if(pay_set_status('alipay')==0){
			$msg="网站未启用支付宝充值";
		    echo json_encode($msg);
			exit();
		}

    }

    /**
     *充值
     *@author whh 
    */
    public function beginPay(){
    	//file_put_contents('E:/sssssss.html',json_encode($_POST));
    	$user = get_user_entity($_POST['account'],true);
        #支付配置
		$data['reqsn'] = 'PF_'.date('Ymd').date ( 'His' ).sp_random_string(4);
		$data["cusid"] = self::CUSID;
        $data["appid"] = self::APPID;
        $data["version"] = self::APIVERSION;
        $data["trxamt"] = $_POST['money']*100;//0.01*100;
        $data["randomstr"] = $this->getRandom();//
        $data["body"] = "平台币";
        $data["acct"] = "";
        $data["limit_pay"] = "no_credit";
        $data["notify_url"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php/NotifyPF/notify";
		switch ($_POST['apitype']) {
			case 'alipay':
                $data["paytype"] = 'A01';
                $data["remark"] = "支付宝平台币充值";
				break;
			case 'weixin':
                $data["paytype"] = 'W01';
                $data["remark"] = "微信平台币充值";
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
        $t1 = microtime(true);
        $data["sign"] = $this->SignArray($data,self::APPKEY);//签名

        $paramsStr = $this->ToUrlParams($data);
        $url = self::APIURL . "/pay";
        $rsp = $this->request($url, $paramsStr);
        $t2 = microtime(true);
        $rspArray = json_decode($rsp, true);
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/time.txt", "a+");
        fwrite($logFile, '耗时'.round($t2-$t1,3).'秒');
        fwrite($logFile, "\r\n\r\n");
        if($this->validSign($rspArray)){
            //添加充值记录
            $this->add_deposit($data,$user);
            if($_POST['apitype'] == "alipay"){
                //$png_img = "/Public/Media/image/zfb_pay_tips.png";
                $payway = "支付宝支付";
            }else{
                //$png_img = "/Public/Media/image/wx_pay_tips.png";
                $payway = "微信支付";
            }

            $trxamt = $data["trxamt"]/100;
            $html = '<div id="rechargeConfirmBox">
                        <div class="rechargeConfirmTit">请确认您的充值信息</div>
                        <div class="rechargeConfirmCon">
                        <img src="' . __MODULE__ . '/Recharge/qrcode/url/'.base64_encode($rspArray['payinfo']).'" alt="" class="erCode">
                        <p>充值账号：'.$_POST['account'].'</p>
                        <p>充值方式：'.$payway.'</p>
                        <p>充值金额：'.$trxamt.'元</p>
                        </div>
                        <div class="rechargeConfirmOperation cf">
                        <a href="javascript:void(0)" class="confirmSubmit fl">确认提交</a>
                        <a href="javascript:void(0)" class="updateBack fl">返回修改</a>
                        </div>
                    </div>';
            $json_data = array("status"=>1,"html"=>$html);

            $this->ajaxReturn($json_data);

        }else{
            \Think\Log::record($rspArray["retmsg"]);
            $html ='<div  id="rechargeConfirmBox">
                    <div class="rechargeConfirmTit">请确认您的充值信息</div>
                    <div class="rechargeConfirmCon">
                        <p>respMsg:'.$rspArray["retmsg"].'</p>
                        <p>respCode:'.$rspArray["respCode"].'</p>
                    </div>
                    <div class="rechargeConfirmOperation cf">
                    <a href="javascript:void(0)" class="confirmSubmit fl">确认提交</a>
                    <a href="javascript:void(0)" class="updateBack fl">返回修改</a>
                    </div>
                    </div>';
            $json_data = array("status"=>1,"html"=>$html);
            $this->ajaxReturn($json_data);
        }

		
    }


    public function qrcode($url='pc.vlcms.com',$level=3,$size=4){
        Vendor('phpqrcode.phpqrcode');
        $errorCorrectionLevel =intval($level) ;//容错级别 
        $matrixPointSize = intval($size);//生成图片大小 
        $url = base64_decode($url);
        //生成二维码图片 
        //echo $_SERVER['REQUEST_URI'];
        $object = new \QRcode();
        echo $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2); 

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
        if("SUCCESS"==$array["retcode"]){
            $signRsp = strtolower($array["sign"]);
            $array["sign"] = "";
            $sign =  strtolower($this->SignArray($array, self::APPKEY));
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
        $deposit_data['pay_order_number'] = $data['reqsn'];
        $deposit_data['user_id'] = $user['id'];
        $deposit_data['user_account'] = $user['account'];
        $deposit_data['user_nickname'] = $user['nickname'];
        $deposit_data['promote_id'] = $user['promote_id'];
        $deposit_data['promote_account'] = $user['promote_account'];
        $deposit_data['pay_amount'] = $data['trxamt']/100;
        $deposit_data['pay_status'] = 0;
        $deposit_data['pay_way'] = $data['paytype'] == 'A01' ? 1 : 2 ;
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
        $data['inputCharset'] = 1;
        $data["pickupUrl"] = "http://".$_SERVER['HTTP_HOST']."/media.php?s=/Index/index.html";
        $data["receiveUrl"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php/NotifyPF/pan_notify";
        $data["version"] = 'v1.0';
        $data['signType'] = '1';
        if($_POST['paytype'] == 1){
            $data["merchantId"] = self::PANCUSID_1;
        }else{
            $data["merchantId"] = self::PANCUSID_2;
        }
        $data['orderNo'] = 'PF_'.date('Ymd').date ( 'His' ).sp_random_string(4);
        $data["orderAmount"] = $_POST['money']*100;//0.01*100;
        $data["orderDatetime"] = $this->get_total_millisecond();
        $data['payType'] = '0';
        $data['tradeNature'] = GOODS;
        $data["signMsg"] = $this->panSignArray($data,self::PANAPPKEY);//签名

        $re = $this->add_pan_deposit($data,$user);

        //$re = 1;
        if($re){
            $trxamt = $data["orderAmount"]/100;

            $html = '<div id="rechargeConfirmBox">
                        <div class="rechargeConfirmTit">请确认您的充值信息</div>
                        <div class="rechargeConfirmCon">
                        <form action="'.self::PANURL.'" method="POST" id="form_alipay" target="_blank">
                        <p>充值账号：'.$_POST['account'].'</p>
                        <p>充值方式：银联支付</p>
                        <p>充值金额：'.$trxamt.'元</p>
                        <input type="hidden" name="inputCharset" value="'.$data["inputCharset"].'" />
                        <input type="hidden" name="pickupUrl" id="pickupUrl" value="'.$data["pickupUrl"].'"/>
                        <input type="hidden" name="receiveUrl" id="receiveUrl" value="'.$data["receiveUrl"].'" />
                        <input type="hidden" name="version" id="version" value="'.$data["version"].'"/>
                        <input type="hidden" name="signType" value="'.$data["signType"].'" />
                        <input type="hidden" name="merchantId" id="merchantId" value="'.$data["merchantId"].'" />
                        <input type="hidden" name="orderNo" id="orderNo" value="'.$data["orderNo"].'" />
                        <input type="hidden" name="orderAmount" id="orderAmount" value="'.$data["orderAmount"].'"/>
                        <input type="hidden" name="orderDatetime" id="orderDatetime" value="'.$data["orderDatetime"].'" />
                        <input type="hidden" name="payType" value="'.$data["payType"].'" />
                        <input type="hidden" name="tradeNature" value="'.$data["tradeNature"].'" />
                        <input type="hidden" name="signMsg" id="signMsg" value="'.$data["signMsg"].'" />
                        </form>
                        </div>
                        <div class="rechargeConfirmOperation cf">
                        <a href="javascript:void(0)" class="confirmPinSubmit fl" >确认提交</a>
                        <a href="javascript:void(0)" class="updateBack fl">返回修改</a>
                        </div>
                    </div>';
            $json_data = array("status"=>1,"html"=>$html);

        }else{
            $html ='<div  id="rechargeConfirmBox">
                    <div class="rechargeConfirmTit">请确认您的充值信息</div>
                    <div class="rechargeConfirmCon">
                        <p>respMsg：数据错误 请稍后重试</p>
                    </div>
                    <div class="rechargeConfirmOperation cf">
                    <a href="javascript:void(0)" class="confirmSubmit fl">确认提交</a>
                    <a href="javascript:void(0)" class="updateBack fl">返回修改</a>
                    </div>
                    </div>';
            $json_data = array("status"=>1,"html"=>$html);
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
