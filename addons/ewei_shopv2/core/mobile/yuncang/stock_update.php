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

if(isset($_POST['id'])){
    $goodsid=$_POST['id'];
}else{
    apiJson(1,'请输入商品id');
};

if(isset($_POST['quantity'])){

    if(is_int($_POST['quantity']-0) && ($_POST['quantity']-0)>0){

//        var_dump($_POST['quantity']-0);exit;
        if($_POST['quantity']<0){

            apiJson(1,'商品库存数为正整数');
        }else{

            $goodsnum=$_POST['quantity']-0;

            var_dump($goodsnum);
        }
    }else{
        apiJson(1,'商品库存数为正整数');
    }

}else{
    apiJson(1,'请输入商品库存数');
};

$shopCode='0';
if(isset($_POST['shopCode'])){
    $shopCode=$_POST['shopCode'];
}

//更新数据库
if(pdo_update('ewei_shop_goods', array('total'=>$goodsnum), array('id' => $goodsid))){
    apiJson();
}else{
    apiJson(2,'数据错误');
};




