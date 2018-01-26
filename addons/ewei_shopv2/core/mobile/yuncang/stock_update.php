<?php
/**
 * Created by PhpStorm.
 * User: kathy
 * Date: 2018/1/4
 * Time: 14:47
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

if(isset($data['productId'])){
    $goodsid=$data['productId'];
}else{
    apiJson(1,'请输入商品id');
};

if(isset($data['quantity'])){

    if(is_int($data['quantity']-0) && ($data['quantity']-0)>0){

//        var_dump($data['quantity']-0);exit;
        if($data['quantity']<0){

            apiJson(1,'商品库存数为正整数');
        }else{

            $goodsnum=$data['quantity']-0;

            //  var_dump($goodsnum);
        }
    }else{
        apiJson(1,'商品库存数为正整数');
    }

}else{
    apiJson(1,'请输入商品库存数');
};

$shopCode='0';
if(isset($data['shopCode'])){
    $shopCode=$data['shopCode'];
}

//更新数据库
if(pdo_update('ewei_shop_goods', array('total'=>$goodsnum), array('id' => $goodsid))){
    apiJson();
}else{
    apiJson(2,'数据错误');
};



