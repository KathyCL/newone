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


//接收参数

$data=json_decode(file_get_contents('php://input'),true);

//var_dump($data);exit;

if(isset($data['orderId'])){

    $orderId=$data['orderId'];

}else{

    apiJson(1,'请输入订单号');

};

$lastModifyTime='';

if(isset($data['lastModifyTime'])){

    $lastModifyTime=strtotime($data['lastModifyTime']);

    if($lastModifyTime==false){

        apiJson(1,'最后修改时间参数错误');
    }

};

if(isset($data['logisticInfos'])){

    $logisticInfos=$data['logisticInfos'][0];

    if(is_array($logisticInfos)){

        // var_dump($logisticInfos);exit;

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

//查询物流公司
$expresscom=pdo_fetch('select * from ' . tablename('ewei_shop_express') . 'where express=:express',array(':express'=>$logisticsId) );

$order_data=array(
    'status'=>2,
    'sendtime'=>time(),
    'express'=>$logisticsId,
    'expresssn'=>$waybill,
    'expresscom'=>$expresscom['name']
);

//查询订单状态

$order=pdo_fetch('select * from ' . tablename('ewei_shop_order') . 'where ordersn=:ordersn',array(':ordersn'=>$orderId));

if($order['status']==1){
//更新订单状态
    $re=pdo_update('ewei_shop_order', $order_data, array('ordersn' => $orderId));

    $insert=pdo_insert("ewei_shop_logistic_send_reback", $data);

    if($insert && $re){

        apiJson();

    }else{

        apiJson(2,'数据异常');

    };


}elseif($order['status']==2){

    apiJson();
}else{

    apiJson(2,'订单状态异常');
}


