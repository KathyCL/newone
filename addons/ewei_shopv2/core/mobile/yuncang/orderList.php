<?php
/**
 * Created by PhpStorm.
 * User: kathy
 * Date: 2018/1/3
 * Time: 15:51
 */


function apiJson($num,$orderinfo,$code=0,$error='ok'){

    $msg=[
        'totalCount'=>$num,
        'orderInfos'=>$orderinfo,
        'code'=>$code,
        'errorMsg'=>$error
    ];
    exit(json_encode($msg));
}
//接收参数

$data=json_decode(file_get_contents('php://input'),true);

//1.接收订单code
if(isset($data['ids'])){
    $ids=explode(',',$data['ids']);//批量订单code转数组
}
//2.起始时间
if(isset($data['startTime'])){
    $starttime=strtotime($data['startTime']);//起始时间转时间戳
    if($starttime==false){
        apiJson(0,'',1,'时间格式错误');
    }
};
//3.结束时间
if(isset($data['endTime'])){
    $endtime=strtotime($data['endTime']);//起始时间转时间戳
    if($endtime==false){
        apiJson(0,'',1,'时间格式错误');
    }
};


//4.修改起始时间
if(isset($data['startModified'])){
    $startupdatetime=strtotime($data['startModified']);//起始时间转时间戳
    if($startupdatetime==false){
        apiJson(0,'',1,'时间格式错误');
    }
};

//5.修改结束时间
if(isset($data['endModified'])){
    $endupdatetime=strtotime($data['endModified']);//结束时间转时间戳
    if($endupdatetime==false){
        apiJson(0,'',1,'时间格式错误');
    }
};




//6.排序
//$orderBy=isset($_POST['orderBy'])?$_POST['orderBy']:'createTime';
//7.显示页数 必须
if(!isset($data['page'])){

    apiJson(0,'',1,'显示页数参数错误');
}else{
    if(is_int($data['page']+0)){

        if($data['page']<1 or $data['page']>1000){
            apiJson(0,'',1,'每页显示条数请输入1~1000的整数');
        }
        $page=$data['page'];
    }else{
        apiJson(0,'',1,'请输入0~1000整数页码');
    }

}

//$page=isset($_POST['page'])?$_POST['page']:1;//1~1000
//if($page<1 or $page>1000){
//    apiJson(0,'',1,'显示页数请输入1~1000的整数');
//}
//8.每页显示条数 必须
if(!isset($data['pageSize'])){
    apiJson(0,'',1,'每页显示条数参数错误');

}else{
    if(is_int($data['pageSize']+0)){
        if($data['pageSize']<1 or $data['pageSize']>500){
            apiJson(0,'',1,'每页显示条数请输入1~500的整数');
        }
        $pageSize=$data['pageSize'];
    }else{
        apiJson(0,'',1,'请输入整数页码');
    }
}
//拼接条件
$where='';
if(isset($data['ids']) or isset($data['startTime']) or isset($data['startModified']) or isset($data['endModified']) or isset($data['endTime'])){
    $where.='where ';
}
$sn='';
if(isset($data['ids'])){
    foreach ($ids as $k=>$v){
        $sn.='"'.$v.'",';
    }
    $sn = substr($sn,0,strlen($sn)-1);
    $where.='ordersn in ('.$sn.')';
}


if(isset($starttime)){
    if(isset($data['ids'])){
        $where.=' and';
    }
    if(isset($endtime)){
        if($endtime<$starttime){

            apiJson(0,'',1,'时间参数错误');
        }
        $where.=' createtime between '.$starttime.' and '.$endtime;
    }else{
        $where.=' createtime between '.$starttime.' and '.time();
    }
}elseif(isset($data['endTime'])){

    if($data['ids']){
        $where.=' and';
    }

    if(!$starttime){
        $where.='createtime < '.$endtime;
    }

};


if(isset($startupdatetime)){
    if(isset($data['ids']) || isset($data['startTime']) || isset($data['endTime'])){
        $where.=' and';
    }
    if(isset($endupdatetime)){
        if($endupdatetime<$startupdatetime){

            apiJson(0,'',1,'时间参数错误');
        }

        $where.=' updatetime between '.$startupdatetime.' and '.$endupdatetime;
    }else{
        $where.=' updatetime between '.$startupdatetime.' and '.time();
    }
}elseif(isset($data['endModified'])){

    if(isset($data['ids']) || isset($data['startTime']) || isset($data['endTime'])){
        $where.=' and';
    }

    if(!$startupdatetime){
        $where.='updatetime < '.$endupdatetime;
    }

}

//查询订单数据
$orders = pdo_fetchall('select * from ' . tablename('ewei_shop_order') . $where.' order by createtime limit '.($page-1)*$pageSize .','.$pageSize);

$count=pdo_fetch('select count(*) from ' . tablename('ewei_shop_order') . $where.' order by createtime');

$num=$count["count(*)"];

$orderinfo=array();

foreach($orders as $k=>$v){
    $address=pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . 'where id=:addressid ',array(':addressid'=>$v['addressid']));
    $item=pdo_fetch('select * from ' . tablename('ewei_shop_order_goods') . 'where orderid=:id ',array(':id'=>$v['id']));

    $goods=pdo_fetch('select * from ' . tablename('ewei_shop_goods') . 'where id=:goodsid ',array(':goodsid'=>$item['goodsid']));

    $payType='';

    //var_dump($v['paytype']);

    if($v['paytype']=='1'){

        $payType="4";
    }elseif($v['paytype']=='11'){

        $payType="4";
    }elseif($v['paytype']=='21'){

        $payType='4';
    }elseif($v['paytype']=='22'){

        $payType='4';
    }elseif($v['paytype']=='23'){

        $payType='4';
    }elseif($v['paytype']=='3'){

        $payType='1';
    }elseif($v['paytype']=='0'){

        $payType='未支付';
    };


    $deliveryMethodType='';

    if(!empty($v['addressid'])){

        $deliveryMethodType='EXPRESS';
    }elseif(!empty($item['isvirtualsend']) || !empty($item['virtual'])){

        $deliveryMethodType='STORE_DELIVERY';
    }elseif($item['dispatchtype']){

        $deliveryMethodType='CUSTOMER_PICK';
    }


    $ItemInfo=[
        'skuId'=>$goods['id'],
        'skuCode'=>'',
        'skuName'=>$goods['title'],
        'price'=>$goods['marketprice'],
        'num'=>$item['total'],
        'amount'=>$item['price']
    ];

    $userinfo=[
        'fullname'=>$address['realname'],
        'mobile'=>$address['mobile'],
        'province'=>$address['province'],
        'city'=>$address['city'],
        'county'=>$address['area'],
        'fullAddress'=>$address['address']
    ];
    $orderinfo[$k]=[
        'orderId'=>$v['ordersn'],//订单号
        'payType'=> $payType,
        'orderTotalPrice'=>(string)($v['goodsprice']+$v["dispatchprice"]),//总金额
        'orderSellerPrice'=>$v['goodsprice'],//货款金额
        'freightPrice'=>$v["dispatchprice"],//运费
        'sellerDiscount'=>$v['goodsprice']+$v["dispatchprice"]-$v['price'],//优惠金额
        // 'orderPayment'=>$v['goodsprice']+$v["dispatchprice"]-$v['discountprice'],//用户应付金额 （总金额-优惠金额）
        'orderPayment'=>$v['price'],
        'orderState'=>$v["status"]==-1?4:$v["status"],//订单状态
        'orderRemark'=>$v['remark'],//客户备注
        'createTime'=>date('Y-m-d H:i:s',$v['createtime']),//下单时间
        'finishTime'=>$v['finishtime']==0?'':date('Y-m-d H:i:s',$v['finishtime']),//订单结束时间
        'modifiedTime'=>$v['updatetime']==0?'':date('Y-m-d H:i:s',$v['updatetime']),
        'consigneeInfo'=>$userinfo,
        'itemInfos'=>$ItemInfo,
        'paymentConfirmTime'=>date('Y-m-d H:i:s',$v['paytime']),
        'deliveryMethodType'=>$deliveryMethodType
    ];
}
apiJson($num,$orderinfo,0,'ok');









