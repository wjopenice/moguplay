<?php
namespace Home\Controller;
use Think\Controller;
use Api\Controller\IpsCodePayController;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/18
 * Time: 10:35
 */
class IpsController extends Controller
{
    public function index(){
       $this->display();
    }
    public function Ajaxindex(){

        $IpsCodePay = new IpsCodePayController();
           $ShopName = I("post.ShopName");
           $ShopNum = I("post.ShopNum");
           $ShopPrice = I("post.ShopPrice");
           $TotolPrice = $ShopNum * $ShopPrice;
           session("TotolPrice",$TotolPrice);
           session("ShopName",$ShopName);
           $ArrPayData = $IpsCodePay->GetPayData();

    }
    public function qrcode($url="weixin://wxpay/bizpayurl?pr=QXlvejY",$level=3,$size=4)
    {
        Vendor('phpqrcode.phpqrcode');
        $errorCorrectionLevel =intval($level) ;//容错级别
        $matrixPointSize = intval($size);//生成图片大小
        //生成二维码图片
        $object = new \QRcode();
        $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);
    }
    public function validCode(){
        sleep(3);
        session_start();
        $xml = simplexml_load_file("./b.xml");

        if(!empty($xml->GateWayRsp->body->QrCode)){
            $code = $xml->GateWayRsp->body->QrCode;
            $this->qrcode($code);
        }else{
            edirect('/Paytest/Ips/index', 5, '下单失败,页面跳转中...');
        };
    }

}