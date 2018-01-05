<?php
/**
 * Created by PhpStorm.
 * User: kathy
 * Date: 2018/1/4
 * Time: 15:40
 */

function apiJson($num,$product,$code=0,$error='ok'){

    $msg=[
        'totalCount'=>$num,
        'products'=>$product,
        'code'=>$code,
        'errorMsg'=>$error
    ];
    exit(json_encode($msg));
}

//1.接收订单code
if(isset($_POST['ids'])){
    $ids=explode(',',$_POST['ids']);//批量订单code转数组
}

//7.显示页数 必须
if(!isset($_POST['page'])){
    apiJson(0,'',1,'显示页数参数错误');
}else{
    if(is_int($_POST['page']+0) && ($_POST['page']+0)>0){
        $page=$_POST['page'];
    }else{
        apiJson(0,'',1,'请输入整数页码');
    }

}

//8.每页显示条数 必须
if(!isset($_POST['pageSize'])){
    apiJson(0,'',1,'每页显示条数参数错误');

}else{
    if(is_int($_POST['pageSize']+0)){
        if($_POST['pageSize']<1 or $_POST['pageSize']>100){
            apiJson(0,'',1,'每页显示条数请输入1~100的整数');
        }
        $pageSize=$_POST['pageSize'];
    }else{
        apiJson(0,'',1,'请输入整数页码');
    }
}

//2.起始时间
if(isset($_POST['startTime'])){
    $starttime=strtotime($_POST['startTime']);//起始时间转时间戳
    if($starttime==false){
        apiJson(0,'',1,'时间格式错误');
    }
}

//3.结束时间
if(isset($_POST['endTime'])){
    $endtime=strtotime($_POST['endTime']);//起始时间转时间戳
    if($endtime==false){
        apiJson(0,'',1,'时间格式错误');
    }
};

//2.更新起始时间
if(isset($_POST['startModified'])){
    $startModified=strtotime($_POST['startModified']);//起始时间转时间戳
    if($startModified==false){
        apiJson(0,'',1,'时间格式错误');
    }
}

//3.更新结束时间
if(isset($_POST['endModified'])){
    $endModified=strtotime($_POST['endModified']);//起始时间转时间戳

    if($endModified==false){
        apiJson(0,'',1,'时间格式错误');
    }
};


if(isset($_POST['status'])){
    $status=$_POST['status']==2?0:$_POST['status'];
}

if(isset($_POST['name'])){
    $name=$_POST['name'];
}

//拼条件

$where='';
if(isset($_POST['ids']) or isset($_POST['startTime']) or isset($_POST['endTime']) or isset($_POST['name']) or isset($_POST['status'])){
    $where.='where ';
}
$sn='';
if(isset($_POST['ids'])){
    foreach ($ids as $k=>$v){
        $sn.='"'.$v.'",';
    }
    $sn = substr($sn,0,strlen($sn)-1);
    $where.='goodssn in ('.$sn.')';
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


if(isset($startModified)){
    if(isset($_POST['ids']) || isset($_POST['startTime']) || isset($_POST['endTime'])){
        $where.=' and';
    }
    if(isset($endModified)){
        if($endModified<$startModified ){

            apiJson(0,'',1,'时间参数错误');
        }

        $where.=' updatetime between '.$startModified.' and '.$endModified;
    }else{
        $where.=' updatetime between '.$startModified.' and '.time();
    }
}elseif(isset($_POST['endModified'])){

    if(isset($_POST['ids']) || isset($_POST['startTime']) || isset($_POST['endTime'])){
        $where.=' and';
    }

    if(!$startModified){
        $where.='createtime < '.$endModified;
    }

}


if(isset($_POST['name'])){

    if(isset($_POST['ids']) || isset($_POST['startTime']) || isset($_POST['endTime']) || isset($_POST['startModified']) || isset($_POST['endModified'])){

        $where.=' and title="'.$name.'"';
    }else{

        $where.=' title="'.$name.'"';
    }

}

if(isset($_POST['status'])) {

    if (isset($_POST['ids']) || isset($_POST['startTime']) || isset($_POST['endTime']) || isset($_POST['startModified']) || isset($_POST['endModified']) || isset($_POST['name'])) {

        $where .= ' and status=' .$status;
    }else{

        $where.=' status='.$status;
    }

}

//查询订单数据
$goods = pdo_fetchall('select * from ' . tablename('ewei_shop_goods') . $where.' order by createtime limit '.($page-1)*$pageSize .','.$pageSize);

$count=pdo_fetch('select count(*) from ' . tablename('ewei_shop_goods') . $where.' order by createtime');

$num=$count["count(*)"];

$product=array();

foreach ($goods as $k=>$v){

    $skuinfo=pdo_fetchall('select * from '.tablename('ewei_shop_goods_option').'where goodsid=:goodsid',array(':goodsid'=>$v['id']));

//    var_dump($skuinfo);exit;
    $sku=[
        'skuid'=> $skuinfo[0]['skuId'],
        'skuCode'=>$skuinfo[0]['productsn']
    ];

    $product[$k]=[

        'productId'=>$v['id'],
        'productCode'=>$v['goodssn'],
        'skus'=>$sku,
        'status'=>$v['status']==0?'DOWN':'ON_SALE',
        'name'=>$v['title'],
        'createdTime'=>date('Y-m-d H:i:s',$v['createtime']),
        'modifiedTime'=>$v['updatetime']==0?0:date('Y-m-d H:i:s',$v['updatetime']),

];
}

//var_dump($goods);

apiJson($num,$product,0,'ok');

