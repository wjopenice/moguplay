<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/19
 * Time: 17:08
 */
namespace Paytest\Controller;
use Think\Controller;
use Api\Controller\IpsObPayController;

class IpsObController extends Controller
{
      public function index(){
              $this->display();
      }
      public function pay(){
          $shopName = I("post.productDesc");
          $TotolPrice = I("post.orderAmount");
          session("TotolPrice",$TotolPrice);
          session("ShopName",$shopName);
          $IpsObPay = new IpsObPayController();
          $data = $IpsObPay->BuildObData();
          $data['payerName'] = I("post.payerName");
          $this->assign("data",$data);
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
        $IpsObPay = new IpsObPayController();
        $key=$IpsObPay::Key;

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
}