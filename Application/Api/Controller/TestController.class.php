<?php
namespace Api\Controller;

class TestController extends BaseController 
{


    public function test(){
       $data = [
           'account' => 'ZB1520821677',
           'resqn' => 'QD_'.date('Ymd').date ( 'His' ).sp_random_string(4),
           'pay_amount' => isset($_REQUEST['amount']) ? $_REQUEST['amount'] : '0.01',
           'pay_type' => 1,
           'pay_way' => isset($_REQUEST['way']) ? $_REQUEST['way'] : 4,
           'body' => '平台账号测试',
           'pay_ip'=> get_client_ip(),
           'notify_url' => "http://" . $_SERVER['HTTP_HOST'] . "/api.php/Index/notify",
        ]; 
        //$url = "http://119.23.34.87/api.php?s=/H5Pay/h5_Pay.html";
        $url = "http://game-pk.com/api.php?s=/H5Pay/h5_Pay.html";

        $sh_data = [
            'resqn'   => $data['resqn'],
            'account' => $data['account'],
            'pay_amount' => $data['pay_amount'],
            'pay_type' => $data['pay_type'],
            'pay_way' => isset($_REQUEST['way']) ? $_REQUEST['way'] : 4,
            'notify_url' => $data['notify_url'],
            'key' => 'shoushang2018',
        ];
        ksort($sh_data);
        $buff = "";
        foreach ($sh_data as $k => $v)
        {
            if($v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");

        $data['sign'] = md5($buff);

        $this->assign('data',$data);
        $this->assign('url',$url);
        $this->display();

        /*var_dump($data);exit;
        $postdata = http_build_query($data);
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
        $output = json_decode($result,ture);*/
        

    }

    

    function http_request($url,$data=array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // 我们在POST数据哦！
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }



}