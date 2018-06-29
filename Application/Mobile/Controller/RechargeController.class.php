<?php
namespace Mobile\Controller;
use Think\Controller;
use Admin\Model\GameModel;
use Common\Api\PayApi;
use Org\Itppay\itppay;
/**
 * 文档模型控制器
 * 文档模型列表和详情
 */
class RechargeController extends BaseController {
    /*const APPID = '00000051';
    const CUSID = '990581007426001';
    const APPKEY = 'allinpay888';
    const APIURL = "http://113.108.182.3:10080/apiweb/unitorder";//生产环境
    const APIVERSION = '11';*/
    const APPID = '00018339';
    const CUSID = '55059304816K14U';
    const APPKEY = '55059304816K14U04';
    const APIURL = "https://vsp.allinpay.com/apiweb/unitorder";//生产环境
    const APIVERSION = '11';

    public function chongzhi(){
        // $this->qrcode(base64_encode("https://qr.alipay.com/bax03628uqg7wzvji3hg6003"));exit;
        // $this->qrcode(base64_encode("weixin://wxpay/bizpayurl?pr=gKOK4Id"));exit;
    	$wheresign['name']='ALIPAY_POINT_SIGN';
        $alipay_points_sign=M('config','sys_')->where($wheresign)->getfield('value');
        //$sql=M('config','sys_')->getlastsql();
        //print_r($sql);exit;
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

    public function ces(){

        $deposit_id = $_GET['id'];
        $deposit = M("deposit", "tab_");
        $map['id']= $deposit_id ;
        $data=$deposit->where($map)->find();

        $this->assign('payinfo',$_GET['pay']);
        $this->assign('data',$data);
        
        $this->display();

    }

    /**
     *充值
     *@author whh 
    */
    public function beginPay(){

    	//account,apitype,amount:
    	$user = get_user_entity($_POST['account'],true);
        #支付配置
		$data['reqsn'] = 'PF_'.date('Ymd').date ( 'His' ).sp_random_string(4);
		$data["cusid"] = self::CUSID;
        $data["appid"] = self::APPID;
        $data["version"] = self::APIVERSION;
        $data["trxamt"] = $_POST['amount']*100;//0.01*100;
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
				break;
		}
        $data["sign"] = $this->SignArray($data,self::APPKEY);//签名

        $paramsStr = $this->ToUrlParams($data);
        $url = self::APIURL . "/pay";
        $rsp = $this->request($url, $paramsStr);
        $rspArray = json_decode($rsp, true); 

        if($this->validSign($rspArray)){
            //添加充值记录
            $deposit_id = $this->add_deposit($data,$user);
            $json_data = array("status"=>1,"pay"=>base64_encode($rspArray['payinfo']),'id'=>$deposit_id);

            $this->ajaxReturn($json_data);
            /*if($_POST['apitype'] == "alipay"){
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
                                    <td class="text_left">'.$data["reqsn"].'</td>
                                </tr>
                                <tr>
                                    <td class="text_right">充值金额</td>
                                    <td class="text_left">本次充值'.$data["trxamt"].'元，实际付款'.$data["trxamt"].'元</td>
                                </tr>
                                </tbody>
                            </table>
                            <img src="' . __MODULE__ . '/Recharge/qrcode/url/'.base64_encode($rspArray['payinfo']).'"  height="301" width="301" >
                            <img src="'.$png_img.'">
                        </div>
                    </div>
                </div>';
            $json_data = array("status"=>1,"html"=>$html);

            $this->ajaxReturn($json_data);*/

        }else{
            \Think\Log::record($rspArray["retmsg"]);
            $html ='<div class="d_body" style="height:px;">
                    <div class="d_content">
                        <div class="text_center">respMsg:'.$rspArray["retmsg"].'</div>
                        <div class="text_center">respCode:'.$rspArray["respCode"].'</div>
                    </div>
                    </div>';
            $json_data = array("status"=>1,"html"=>$html);
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
        $key = "";
        for($i=0;$i<$param;$i++)
         {
             $key .= $str{mt_rand(0,32)};    //生成php随机数
         }
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
