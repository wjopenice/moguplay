<?php
/**
 * Created by PhpStorm.
 * User: adminn
 * Date: 2018/4/9
 * Time: 11:09
 */
namespace Api\Controller;

class TlbankController extends BaseController
{
    const PANURL = "https://service.allinpay.com/gateway/index.do";//"http://ceshi.allinpay.com/gateway/index.do";
    const PANCUSID_1 = '109020201803037';//'100020091218001';
    const PANCUSID_2 = '109020201803038';//'100020091218001';
    const PANAPPKEY = '1234567890';

    //银行选择页
    public function index(){
        $this->display();
    }

    //订单号生成
    public function sp_random_string($len = 5){
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

    //数据提交
    public function pay(){
        $account = $_POST['pid'];
        $map['account'] = $account;
        $user = M('promote','tab_')->where($map)->find();
        if(!$user){
            $msg = [
                'code'=>'10008',
                'msg'=>'商户号不存在'
            ];
            $this->assign('msg',$msg);
            $this->display();
            exit;
        }
        if(!$user['paykey']){
            $msg = [
                'code'=>'10009',
                'msg'=>'KEY值未设置'
            ];
            $this->assign('msg',$msg);
            $this->display();
            exit;
        }
        if(count($_POST) == 0){
            $msg = [
                'code'=>'10002',
                'msg'=>'参数为空'
            ];
            $this->assign('msg',$msg);
            $this->display();
            exit;
        }
        if(!$account){
            $msg = [
                'code'=>'10003',
                'msg'=>'商户号为空'
            ];
            $this->assign('msg',$msg);
            $this->display();
            exit;
        }
        $status = M('promote','tab_')->where("account='".$account."'")->find();
        if($status['status'] != 1){
            $msg = [
                'code'=>'10004',
                'msg'=>'商户号已禁用'
            ];
            $this->assign('msg',$msg);
            $this->display();
            exit;
        }
        if(!$_POST['notify_url']){
            $msg = [
                'code'=>'10005',
                'msg'=>'回调地址为空'
            ];
            $this->assign('msg',$msg);
            $this->display();
            exit;
        }
        if(!$_POST['orderNo']){
            $msg = [
                'code'=>'10006',
                'msg'=>'订单号为空'
            ];
            $this->assign('msg',$msg);
            $this->display();
            exit;
        }
        $order = M('promote_deposit','tab_')->where("pay_order_number = '".$_POST['orderNo']."'")->find();
        if($order){
            $msg = [
                'code'=>'10007',
                'msg'=>'订单号重复'
            ];
            $this->assign('msg',$msg);
            $this->display();
            exit;
        }
        if($this->ValidSign($_POST,$user['paykey'])){
            $data = $_POST;
            $data['serverUrl']=self::PANURL;
            $data['inputCharset']='1';
            $data['pickupUrl']="http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyPF/pan_success";
            $data['receiveUrl']="http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyPF/pan_notify";
            $data['version']='v1.0';
            $data['signType']='0';
            $data['merchantId']=self::PANCUSID_1;
            $data['payerIDCard']='';
            $data['orderAmount']=$_POST["orderAmount"];
            $data['orderDatetime']=date("YmdHis",time());
            $data['orderCurrency']='0';
            $data['orderExpireDatetime']='';
            $data['productName']=isset($_POST["productName"]) ? $_POST["productName"] : '';
            $data['productId']=isset($_POST["productId"]) ? $_POST["productId"] : '';
            $data['productPrice']=isset($_POST["productPrice"]) ? $_POST["productPrice"] : '';
            $data['productNum']=isset($_POST["productNum"]) ? $_POST["productNum"] : '';
            $data['productDesc']=isset($_POST["productDesc"]) ? $_POST["productDesc"] : '';
            $data['ext1']='';
            $data['ext2']='';
            $data['extTL']='';
            $data['payType']='1';
            $data['pan']='';
            $data['tradeNature']='GOODS';
            $data['customsExt']='';

            $deposit = M("promote_deposit", "tab_");
            $deposit_data['order_number'] = "";
            $deposit_data['pay_order_number'] = $_POST['orderNo'];
            $deposit_data['promote_id'] = $user['id'];
            $deposit_data['promote_account'] = $account;
            $deposit_data['pay_amount'] = $_POST['orderAmount'];
            $deposit_data['pay_status'] = 0;
            $deposit_data['pay_way'] = 3;
            $deposit_data['pay_source'] = 0;
            $deposit_data['is_key'] = 1;
            $deposit_data['remarks'] = isset($_POST['productDesc']) ? $_POST['productDesc'] : '充值';
            $deposit_data['create_time'] = NOW_TIME;
            $deposit_data['notify_url'] = $_POST['notify_url'];

            $deposit->add($deposit_data);
            $this->assign('data',$data);
        }else{

            $msg = [
                'code'=>'10001',
                'msg'=>'签名验证失败',
            ];
            $this->assign('msg',$msg);
        }
        $this->display();
    }

    //提交数据处理
    public function handle(){

        //页面编码要与参数inputCharset一致，否则服务器收到参数值中的汉字为乱码而导致验证签名失败。
        $serverUrl=$_POST["serverUrl"];
        $inputCharset=$_POST["inputCharset"];
        $pickupUrl=$_POST["pickupUrl"];
        $receiveUrl=$_POST["receiveUrl"];
        $version=$_POST["version"];
        $language=$_POST["language"];
        $signType=$_POST["signType"];
        $merchantId=$_POST["merchantId"];
        $payerName=$_POST["payerName"];
        $payerEmail=$_POST["payerEmail"];
        $payerTelephone=$_POST["payerTelephone"];
        $payerIDCard=$_POST["payerIDCard"];
        $pid=$_POST["pid"];
        $orderNo=$_POST["orderNo"];
        $orderAmount=$_POST["orderAmount"];
        $orderDatetime=$_POST["orderDatetime"];
        $orderCurrency=$_POST["orderCurrency"];
        $orderExpireDatetime=$_POST["orderExpireDatetime"];
        $productName=$_POST["productName"];
        $productId=$_POST["productId"];
        $productPrice=$_POST["productPrice"];
        $productNum=$_POST["productNum"];
        $productDesc=$_POST["productDesc"];
        $ext1=$_POST["ext1"];
        $ext2=$_POST["ext2"];
        $extTL=$_POST["extTL"];
        $payType=$_POST["payType"]; //payType   不能为空，必须放在表单中提交。
        $issuerId=$_POST["issuerId"]; //issueId 直联时不为空，必须放在表单中提交。
        $pan=$_POST["pan"];
        $tradeNature=$_POST["tradeNature"];
        $customsExt=$_POST["customsExt"];
        $key=self::PANAPPKEY;


        //报文参数有消息校验
        //if(preg_match("/\d/",$pickupUrl)){
        //echo "<script>alert('pickupUrl有误！！');history.back();</script>";
        //}

        // 生成签名字符串。
        $bufSignSrc="";
        if($inputCharset != "")
            $bufSignSrc=$bufSignSrc."inputCharset=".$inputCharset."&";
        if($pickupUrl != "")
            $bufSignSrc=$bufSignSrc."pickupUrl=".$pickupUrl."&";
        if($receiveUrl != "")
            $bufSignSrc=$bufSignSrc."receiveUrl=".$receiveUrl."&";
        if($version != "")
            $bufSignSrc=$bufSignSrc."version=".$version."&";
        if($language != "")
            $bufSignSrc=$bufSignSrc."language=".$language."&";
        if($signType != "")
            $bufSignSrc=$bufSignSrc."signType=".$signType."&";
        if($merchantId != "")
            $bufSignSrc=$bufSignSrc."merchantId=".$merchantId."&";
        if($payerName != "")
            $bufSignSrc=$bufSignSrc."payerName=".$payerName."&";
        if($payerEmail != "")
            $bufSignSrc=$bufSignSrc."payerEmail=".$payerEmail."&";
        if($payerTelephone != "")
            $bufSignSrc=$bufSignSrc."payerTelephone=".$payerTelephone."&";

        //需要加密付款人身份证信息
        if($payerIDCard != "")
        {
            /*
            //测身份证信息认证使用商户号：20150513442
            //加密函数从php_rsa.php 调用


            $publickeyfile = './publickey.txt';
            $publickeycontent = file_get_contents($publickeyfile);

            $publickeyarray = explode(PHP_EOL, $publickeycontent);
            $publickey_arr = explode('=',$publickeyarray[0]);
            $modulus_arr = explode('=',$publickeyarray[1]);
            $publickey = trim($publickey_arr[1]);
            $modulus = trim($modulus_arr[1]);
            $keylength = 1024;
            $ciphertext = base64_encode(rsa_encrypt($payerIDCard, $publickey, $modulus, $keylength));
            */


            //测身份证信息认证使用商户号：20150513442
            //加密函数从phpseclib调用
            $certfile = file_get_contents('TLCert-test.cer');
            $x509 = new File_X509();
            $cert = $x509->loadX509($certfile);
            $pubkey = $x509->getPublicKey();

            $rsa = new Crypt_RSA();
            $rsa->loadKey($pubkey);
            $rsa->setPublicKey();
            $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
            $ciphertext = $rsa->encrypt($payerIDCard);
            $ciphertext = base64_encode($ciphertext);


            $payerIDCard = $ciphertext;
            $bufSignSrc=$bufSignSrc."payerIDCard=".$payerIDCard."&";

        }

        if($pid != "")
            $bufSignSrc=$bufSignSrc."pid=".$pid."&";
        if($orderNo != "")
            $bufSignSrc=$bufSignSrc."orderNo=".$orderNo."&";
        if($orderAmount != "")
            $bufSignSrc=$bufSignSrc."orderAmount=".$orderAmount."&";
        if($orderCurrency != "")
            $bufSignSrc=$bufSignSrc."orderCurrency=".$orderCurrency."&";
        if($orderDatetime != "")
            $bufSignSrc=$bufSignSrc."orderDatetime=".$orderDatetime."&";
        if($orderExpireDatetime != "")
            $bufSignSrc=$bufSignSrc."orderExpireDatetime=".$orderExpireDatetime."&";
        if($productName != "")
            $bufSignSrc=$bufSignSrc."productName=".$productName."&";
        if($productPrice != "")
            $bufSignSrc=$bufSignSrc."productPrice=".$productPrice."&";
        if($productNum != "")
            $bufSignSrc=$bufSignSrc."productNum=".$productNum."&";
        if($productId != "")
            $bufSignSrc=$bufSignSrc."productId=".$productId."&";
        if($productDesc != "")
            $bufSignSrc=$bufSignSrc."productDesc=".$productDesc."&";
        if($ext1 != "")
            $bufSignSrc=$bufSignSrc."ext1=".$ext1."&";

        //如果海关扩展字段不为空，需要做个MD5填写到ext2里
        if($ext2 == "" && $customsExt != "")
        {
            $ext2 = strtoupper(md5($customsExt));
            $bufSignSrc=$bufSignSrc."ext2=".$ext2."&";
        }
        else if($ext2 != "")
        {
            $bufSignSrc=$bufSignSrc."ext2=".$ext2."&";
        }

        if($extTL != "")
            $bufSignSrc=$bufSignSrc."extTL".$extTL."&";
        if($payType != "")
            $bufSignSrc=$bufSignSrc."payType=".$payType."&";
        if($issuerId != "")
            $bufSignSrc=$bufSignSrc."issuerId=".$issuerId."&";
        if($pan != "")
            $bufSignSrc=$bufSignSrc."pan=".$pan."&";
        if($tradeNature != "")
            $bufSignSrc=$bufSignSrc."tradeNature=".$tradeNature."&";
        $bufSignSrc=$bufSignSrc."key=".$key; //key为MD5密钥，密钥是在通联支付网关商户服务网站上设置。
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        fwrite($logFile, $bufSignSrc."\r\n");
        //签名，设为signMsg字段值。
        $signMsg = strtoupper(md5($bufSignSrc));

        $new_data = array(
            'serverUrl' => $serverUrl,
            'inputCharset'=>$inputCharset,
            'pickupUrl'=>$pickupUrl,
            'receiveUrl'=>$receiveUrl,
            'version'=>$version,
            'language'=>$language,
            'signType'=>$signType,
            'merchantId'=>$merchantId,
            'payerName'=>$payerName,
            'payerEmail'=>$payerEmail,
            'payerTelephone'=>$payerTelephone,
            'payerIDCard'=>$payerIDCard,
            'pid'=>$pid,
            'orderNo'=>$orderNo,
            'orderAmount'=>$orderAmount,
            'orderDatetime'=>$orderDatetime,
            'orderCurrency'=>$orderCurrency,
            'orderExpireDatetime'=>$orderExpireDatetime,
            'productName'=>$productName,
            'productId'=>$productId,
            'productPrice'=>$productPrice,
            'productNum'=>$productNum,
            'productDesc'=>$productDesc,
            'ext1'=>$ext1,
            'ext2'=>$ext2,
            'extTL'=>$extTL,
            'payType'=>$payType,
            'issuerId'=>$issuerId,
            'pan'=>$pan,
            'tradeNature'=>$tradeNature,
            'customsExt'=>$customsExt,
            'signMsg' => $signMsg
        );
        echo json_encode(array('new_arr'=>$new_data));
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
        //$logFile = fopen(dirname(__FILE__)."/notifypf.txt", "a+");
        //fwrite($logFile, "回调时签名:".$mySign."\r\n"."原来的签名".$sign."\r\n");
        return strtolower($sign) == strtolower($mySign);
    }

    //生成签名
    public function createSign(){
        $account = $_POST['pid'];
        $map['account'] = $account;
        $user = M('promote','tab_')->where($map)->find();
        unset($_POST['sign']);
        $mySign = $this->SignArray($_POST, $user['paykey']);
        echo json_encode(array('resqn' => $mySign));
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
}
