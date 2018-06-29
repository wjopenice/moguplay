<?php
namespace Api\Controller;

class PayController extends BaseController
{
    //const APPID = '00018339';
    //const APPID = '00018876';
    //const CUSID = '55059304816K14U';
   // const CUSID = '55059304816K9C0';
    const APPKEY = '2018Z0303B';
    const APIURL = "https://vsp.allinpay.com/apiweb/unitorder";//生产环境
    const APIVERSION = '11';


    /**
     *充值接口请求
     *@author whh
     */
    public function beginPay($data){
        //打开日志log
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }

        fwrite($logFile, "\r\n\r\n");

        $pay_data = M('pay_interface','tab_')->where("status=1 and wetch_status=1 and alipay_status=1")->find();
        if($pay_data){
            $APPID = $pay_data['pay_appid'];
            $CUSID = $pay_data['pay_cusid'];
        }else{
            if($data['paytype'] == 'W01'){
                $pay_data = M('pay_interface','tab_')->where("status=1 and wetch_status=1")->find();
                $APPID = $pay_data['pay_appid'];
                $CUSID = $pay_data['pay_cusid'];
            }
            if($data['paytype'] == 'A01'){
                $pay_data = M('pay_interface','tab_')->where("status=1 and alipay_status=1")->find();
                $APPID = $pay_data['pay_appid'];
                $CUSID = $pay_data['pay_cusid'];
            }
        }


        #支付配置
        $config['reqsn'] = $data['resqn'];
        $config["cusid"] = $CUSID;
        $config["appid"] = $APPID;
        $config["version"] = self::APIVERSION;
        $config["trxamt"] = $data['pay_amount']*100;
        $config["randomstr"] = $this->getRandom();//随机字符串
        $config["body"] = $data['body'] ? $data['body'] : "平台币";
        $config['validtime'] = 10;
        $config['paytype'] = $data['paytype'];
        $config["acct"] = "";
        $config["limit_pay"] = "no_credit";
        $config["notify_url"] = "http://" . $_SERVER['HTTP_HOST'] . "/callback.php?s=/NotifyPF/notify";

        $config["sign"] = $this->SignArray($config,self::APPKEY);//签名
        $paramsStr = $this->ToUrlParams($config);
        $url = self::APIURL . "/pay";

        $rsp = $this->request($url, $paramsStr);
        $rspArray = json_decode($rsp, true);
        if($this->validSign($rspArray)){
            $json_data = array(
                'resqn' => $rspArray['reqsn'],
                'retcode' => $rspArray['retcode'],
                'payinfo' => $rspArray['payinfo'],
                'trxid' => $rspArray['trxid'],
                'body' => $data['body'] ? $data['body'] : "平台币",
                'trxstatus' => $rspArray['trxstatus'],
                'sign'      => isset($data['sign']) ? $data['sign'] : ''
            );
            $this->ajaxReturn($json_data);
            exit;
        }else{
            $this->ajaxReturn(array("status"=>'40010',"msg"=>"请求接口失败"));
            exit;
        }
    }

    //平台币充值记录
    public function begin_Pay(){
        $data = $_POST;
//        $resqn = 'QD_'.date('Ymd').date ( 'His' ).sp_random_string(4);
//        $data = [
//            'account' => 'a287077236',
//            'resqn' => $resqn,
//            'pay_amount' => 100,
//            'paytype' => 'W01',
//            'body' => '平台账号测试',
//            'notify_url' => 'http://119.23.34.87/api.php?s=/Pay/beginPay.html',
//        ];
        //打开日志log
        $this->ajaxReturn(array("status"=>'50001',"msg"=>"当前通道已关闭"));
        exit;
        $data['is_key'] = isset($data['is_key']) ? $data['is_key'] : '';
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        foreach($data as $k=>$v){
            fwrite($logFile, $k."=".$v."\r\n");
        }

        $account = $data['account'];
        if(count($data) == 0){
            $this->ajaxReturn(array("status"=>'4006',"msg"=>"参数为空"));
            exit;
        }
        if(!$account){
            $this->ajaxReturn(array("status"=>'4007',"msg"=>"商户号为空"));
            exit;
        }
        $status = M('promote','tab_')->where("account='".$account."'")->find();
        if($status['status'] != 1){
            $this->ajaxReturn(array("status"=>'40012',"msg"=>"商户号已禁用!!!!"));
            exit;
        }
        if(!$data['notify_url']){
            $this->ajaxReturn(array("status"=>'40011',"msg"=>"回调地址为空"));
            exit;
        }
        if($data['is_key']){
            if($data['is_key'] == 1){
                $key = M('promote','tab_')->where("account='".$account."'")->find();
                if($key['paykey']){
                    $sh_data = [
                        'resqn'   => $data['resqn'],
                        'account' => $data['account'],
                        'pay_amount' => $data['pay_amount'],
                        'paytype' => $data['paytype'],
                        'notify_url' => $data['notify_url']
                    ];
                    $sign = $this->SignArray($sh_data,$key['paykey']);
                    fwrite($logFile, "本地签名=".$sign."\r\n"."用户传过来的".$data['sign']."\r\n");
                    if($sign != $data['sign']){
                        $this->ajaxReturn(array("status"=>'40013',"msg"=>"验签失败"));
                        exit;
                    }else{
                        $data['sign']  = $sign;
                    }
                }else{
                    $this->ajaxReturn(array("status"=>'40014',"msg"=>"APPKEY为空"));
                    exit;
                }
            }
        }



        $or_map['pay_order_number'] = $data['resqn'];
        $order = M('promote_deposit','tab_')->where("pay_order_number = '".$data['resqn']."'")->find();

        if($order){
            $this->ajaxReturn(array("status"=>'4009',"msg"=>"订单号重复"));
            exit;
        }
        $map['account'] = $account;
        $user = M('promote','tab_')->where($map)->find();
        if($user){
            $deposit = M("promote_deposit", "tab_");
            $deposit_data['order_number'] = "";
            $deposit_data['pay_order_number'] = $data['resqn'];
            $deposit_data['promote_id'] = $user['id'];
            $deposit_data['promote_account'] = $account;
            $deposit_data['pay_amount'] = $data['pay_amount'];
            $deposit_data['pay_status'] = 0;
            $deposit_data['pay_way'] = $data['paytype'] == 'A01' ? 1 : 2 ;
            $deposit_data['pay_source'] = 0;
            $deposit_data['is_key'] = $data['is_key'];
            $deposit_data['pay_ip'] = isset($data['pay_id']) ? $data['pay_id'] : '';
            $deposit_data['create_time'] = NOW_TIME;
            $deposit_data['notify_url'] = $data['notify_url'];

            $result = $deposit->add($deposit_data);
            if($result){
                $this->beginPay($data);
                $this->ajaxReturn(array("status"=>'0001',"msg"=>"充值记录添加成功"));
                exit;
            }else{
                $this->ajaxReturn(array("status"=>'0002',"msg"=>"充值记录添加失败"));
                exit;
            }

        }else{
            $this->ajaxReturn(array("status"=>'4008',"msg"=>"商户不存在"));
            exit;
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
     * 将参数数组签名
     */
    public function SignArray(array $array,$appkey){
        $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
        $array['key'] = $appkey;// 将key放到数组中一起进行排序和组装
        ksort($array);
        $blankStr = $this->ToUrlParams($array);
        fwrite($logFile, "签名链接".$blankStr."\r\n");
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

    //验签
    function validSign($array){
        if("SUCCESS"==$array["retcode"] && $array['trxstatus'] == '0000'){
            $logFile = fopen(dirname(__FILE__)."/pay.txt", "a+");
            foreach ($array as $k => $val) {
               fwrite($logFile, $k."=".$val."\r\n");
            }
            $signRsp = strtolower($array["sign"]);
            $array["sign"] = "";
            $sign =  strtolower($this->SignArray($array, self::APPKEY));
            fwrite($logFile, "\r\n\r\n");
            fclose($logFile);
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
    function getRandom($param=100){
        $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $key = "";
        for($i=0;$i<$param;$i++)
        {
            $key .= $str{mt_rand(0,32)};    //生成php随机数
        }
        return $key;
    }

    
   
}