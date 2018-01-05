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
//1.接收订单code
if(isset($_POST['ids'])){
    $ids=explode(',',$_POST['ids']);//批量订单code转数组
}
//2.起始时间
if(isset($_POST['startTime'])){
    $starttime=strtotime($_POST['startTime']);//起始时间转时间戳
    if($starttime==false){
        apiJson(0,'',1,'时间格式错误');
    }
};
//3.结束时间
if(isset($_POST['endTime'])){
    $endtime=strtotime($_POST['endTime']);//起始时间转时间戳
    if($endtime==false){
        apiJson(0,'',1,'时间格式错误');
    }
};
//6.排序
//$orderBy=isset($_POST['orderBy'])?$_POST['orderBy']:'createTime';
//7.显示页数 必须
if(!isset($_POST['page'])){
    apiJson(0,'',1,'显示页数参数错误');
}else{
    if(is_int($_POST['page']+0)){

        if($_POST['page']<1 or $_POST['page']>1000){
            apiJson(0,'',1,'每页显示条数请输入1~1000的整数');
        }
        $page=$_POST['page'];
    }else{
        apiJson(0,'',1,'请输入0~1000整数页码');
    }

}

//$page=isset($_POST['page'])?$_POST['page']:1;//1~1000
//if($page<1 or $page>1000){
//    apiJson(0,'',1,'显示页数请输入1~1000的整数');
//}
//8.每页显示条数 必须
if(!isset($_POST['pageSize'])){
    apiJson(0,'',1,'每页显示条数参数错误');

}else{
    if(is_int($_POST['pageSize']+0)){
        if($_POST['pageSize']<1 or $_POST['pageSize']>500){
            apiJson(0,'',1,'每页显示条数请输入1~500的整数');
        }
        $pageSize=$_POST['pageSize'];
    }else{
        apiJson(0,'',1,'请输入整数页码');
    }
}
//拼接条件
$where='';
if(isset($_POST['ids']) or isset($_POST['startTime']) or isset($_POST['endTime'])){
    $where.='where ';
}
$sn='';
if(isset($_POST['ids'])){
    foreach ($ids as $k=>$v){
        $sn.='"'.$v.'",';
    }
    $sn = substr($sn,0,strlen($sn)-1);
    $where.='ordersn in ('.$sn.')';
}
if(isset($starttime)){
    if(isset($_POST['ids'])){
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
}elseif(isset($_POST['endTime'])){

    if($_POST['ids']){
        $where.=' and';
    }

    if(!$starttime){
        $where.='createtime < '.$endtime;
    }

}

//查询订单数据
$orders = pdo_fetchall('select * from ' . tablename('ewei_shop_order') . $where.' order by createtime limit '.($page-1)*$pageSize .','.$pageSize);

$count=pdo_fetch('select count(*) from ' . tablename('ewei_shop_order') . $where.' order by createtime');

$num=$count["count(*)"];

$orderinfo=array();

foreach($orders as $k=>$v){
    $address=pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . 'where id=:addressid ',array(':addressid'=>$v['addressid']));
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
        'orderTotalPrice'=>(string)($v['goodsprice']+$v["dispatchprice"]),//总金额
        'orderSellerPrice'=>$v['goodsprice'],//货款金额
        'freightPrice'=>$v["dispatchprice"],//运费
        'orderState'=>$v["status"]==-1?4:$v["status"],//订单状态
        'orderRemark'=>$v['remark'],//客户备注
        'createTime'=>$v['createtime'],//下单时间
        'finishTime'=>$v['finishtime'],//订单结束时间
        'consigneeInfo'=>$userinfo,
    ];
}
apiJson($num,$orderinfo,0,'ok');



