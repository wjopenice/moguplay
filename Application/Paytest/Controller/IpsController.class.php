<?php
namespace Paytest\Controller;
use Think\Controller;
use Api\Controller\IpsCodePayController;
use Api\Controller\IpsCodePayGetController;
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
           session("ShopNum",$ShopNum);
           session("ShopName",$ShopName);
           //下单请求
           $IpsCodePay->GetPayData();

    }
    public function qrcode($url="",$outpic="",$level=3,$size=4)
    {
        Vendor('phpqrcode.phpqrcode');
        $errorCorrectionLevel =intval($level) ;//容错级别
        $matrixPointSize = intval($size);//生成图片大小
        //生成二维码图片
        $object = new \QRcode();
        $object->png($url, $outpic, $errorCorrectionLevel, $matrixPointSize, 2);
    }
    public function validCode(){
        sleep(3);
        $xml = simplexml_load_file("http://www.game-pk.com/pro.xml");
        if(!empty($xml->GateWayRsp->body->QrCode)){
            $code = $xml->GateWayRsp->body->QrCode;
            $pic = "a.png";
            $this->qrcode($code,"./Public/".$pic);
            $this->assign('pic',$pic);
            $this->display();
        }else{
            redirect('/Paytest/Ips/index', 5, '下单失败,页面跳转中...');
        };
    }
    public function IpsCodePay(){

        $ipscodeorder = M("code_order","ips_");
        $data = $_SESSION['ipscodeorder'];
        //查询订单是否重复
        $arrData = $ipscodeorder->where("MerBillNo='{$data['MerBillNo']}'")->select();
        if(empty($arrData)){
            //写入数据库
            $ipscodeorder->data($data)->add();
        }

        //echo $ipscodeorder->getLastSql();
        //查询支付状态
        /**
         * ************************请求参数*************************
         */
//        sleep(5);
//        $ipscodepayget = new IpsCodePayGetController();
//        $selQueryType = 1;// 查询方式1和2
//        $merName = $data['MerName'];// 商戶名称
//        $merBillNo = $data['MerBillNo'];// 商戶订单号
//        $date = $data['Date'];// 订单日期
//        $amount = $data['Amount'];// 支付金额
//        $bankBillNo = $data['BankBillNo'];  // 銀行订单号
//        $selTradeType = '';// 交易类型
//        // 构造要请求的参数数组
//        $parameter = array(
//            "Version" => $ipscodepayget::Version,
//            "MerCode" => $ipscodepayget::MerCode,
//            "Account" => $ipscodepayget::Account,
//            "MerCert" => $ipscodepayget::Key,
//            "PostUrl" => $ipscodepayget::ApiUrl,
//            "ReqDate" => date("YmdHis"),
//            "QueryType" => $selQueryType,
//            "MerName" => $merName,
//            "MerBillNo" => $merBillNo,
//            "Date" => $date,
//            "Amount" => $amount,
//            "BankBillNo" => $bankBillNo,
//            "TradeType" => $selTradeType,
//            "PageSize" => 100
//        );
        //$getData = $ipscodepayget->IpsPayGet($parameter);
        //print_r($getData);
//        $xmlResult = new \SimpleXMLElement($getData);
//        $strRspCode = $xmlResult->OrderQueryRsp->head->RspCode;
//       // echo    $strRspCode;
//        if(!empty($xmlResult->OrderQueryRsp->head->RspCode)){
//            $strRspCode = $xmlResult->OrderQueryRsp->head->RspCode;
//            $this->ajaxRrturn(['code'=>"ok",'msg'=>"成功"]);
//        }else{
//            redirect('/Paytest/Ips/index', 5, '系统繁忙，稍后再试,页面跳转中...');
//        };

    }
}