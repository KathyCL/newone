<?php
/**
 * Created by PhpStorm.
 * User: kathy
 * Date: 2018/1/4
 * Time: 11:53
 */
function apiJson($code=0,$errorMsg='ok'){

    $msg=[
        'code'=>$code,
        'errorMsg'=>$errorMsg
    ];

   exit(json_encode($msg));

}

if(isset($_POST['orderId'])){

    $orderId=$_POST['orderId'];

}else{

    apiJson(1,'请输入订单号');

};

$lastModifyTime='';

if(isset($_POST['lastModifyTime'])){

    $lastModifyTime=strtotime($_POST['lastModifyTime']);

    if($lastModifyTime==false){

        apiJson(1,'最后修改时间参数错误');
    }

};

if(isset($_POST['logisticInfos'])){

    $logisticInfos=$_POST['logisticInfos'];

    if(is_array($logisticInfos)){

        if(!isset($logisticInfos['logisticsId']) || !isset($logisticInfos['waybill'])){

            apiJson(1,'物流信息参数错误');
        }

    $logisticsId=$logisticInfos['logisticsId'];//物流公司id

    $waybill=$logisticInfos['waybill'];//运单号

    }else{

        apiJson(1,'物流信息格式错误');

    }
}else{

    apiJson(1,'物流信息参数错误');
}

//信息入库logistic_send_reback 订单发货回执

$data=array('ordersn'=>$orderId,'lastModifyTime'=>$lastModifyTime,'logisticsId'=>$logisticsId,'waybill'=>$waybill);

if(pdo_insert("ewei_shop_logistic_send_reback", $data)){

    apiJson();

}else{

    apiJson(2,'数据异常');

};




