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

//接收参数

$data=json_decode(file_get_contents('php://input'),true);

//1.接收订单code
if(isset($data['ids'])){
    $ids=explode(',',$data['ids']);//批量订单code转数组
}

//7.显示页数 必须
if(!isset($data['page'])){
    apiJson(0,'',1,'显示页数参数错误');
}else{
    if(is_int($data['page']+0) && ($data['page']+0)>0){
        $page=$data['page'];
    }else{
        apiJson(0,'',1,'请输入整数页码');
    }

}

//8.每页显示条数 必须
if(!isset($data['pageSize'])){
    apiJson(0,'',1,'每页显示条数参数错误');

}else{
    if(is_int($data['pageSize']+0)){
        if($data['pageSize']<1 or $data['pageSize']>100){
            apiJson(0,'',1,'每页显示条数请输入1~100的整数');
        }
        $pageSize=$data['pageSize'];
    }else{
        apiJson(0,'',1,'请输入整数页码');
    }
}

//2.起始时间
if(isset($data['startTime'])){
    $starttime=strtotime($data['startTime']);//起始时间转时间戳
    if($starttime==false){
        apiJson(0,'',1,'时间格式错误');
    }
}

//3.结束时间
if(isset($data['endTime'])){
    $endtime=strtotime($data['endTime']);//起始时间转时间戳
    if($endtime==false){
        apiJson(0,'',1,'时间格式错误');
    }
};

//2.更新起始时间
if(isset($data['startModified'])){
    $startModified=strtotime($data['startModified']);//起始时间转时间戳
    if($startModified==false){
        apiJson(0,'',1,'时间格式错误');
    }
}

//3.更新结束时间
if(isset($data['endModified'])){
    $endModified=strtotime($data['endModified']);//起始时间转时间戳

    if($endModified==false){
        apiJson(0,'',1,'时间格式错误');
    }
};


if(isset($data['status'])){
    $status=$data['status']==2?0:$data['status'];
}

if(isset($data['name'])){
    $name=$data['name'];
}

//拼条件

$where='';
if(isset($data['ids']) or isset($data['startTime']) or isset($data['endTime']) or isset($data['name']) or isset($data['status']) or isset($data['startModified']) or isset($data['endModified'])){
    $where.='where ';
}
$sn='';
if(isset($data['ids'])){
    foreach ($ids as $k=>$v){
        $sn.='"'.$v.'",';
    }
    $sn = substr($sn,0,strlen($sn)-1);
    $where.='goodssn in ('.$sn.')';
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

}


if(isset($startModified)){
    if(isset($data['ids']) || isset($data['startTime']) || isset($data['endTime'])){
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
}elseif(isset($data['endModified'])){

    if(isset($data['ids']) || isset($data['startTime']) || isset($data['endTime'])){
        $where.=' and';
    }

    if(!$startModified){
        $where.='updatetime < '.$endModified;
    }

}


if(isset($data['name'])){

    if(isset($data['ids']) || isset($data['startTime']) || isset($data['endTime']) || isset($data['startModified']) || isset($data['endModified'])){

        $where.=' and title="'.$name.'"';
    }else{

        $where.=' title="'.$name.'"';
    }

}

if(isset($data['status'])) {

    if (isset($data['ids']) || isset($data['startTime']) || isset($data['endTime']) || isset($data['startModified']) || isset($data['endModified']) || isset($data['name'])) {

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

    $sku=[
        'skuId'=>$v['id'],
        'skuCode'=>$v['goodssn'],
        'stockNum'=>$v['total'],
        'name'=>$v['title'],
        'createdTime'=>date('Y-m-d H:i:s',$v['createtime']),
        'modifiedTime'=>$v['updatetime']==0?'':date('Y-m-d H:i:s',$v['updatetime'])
    ];

    $product[$k]=[

        'productId'=>$v['id'],
        'productCode'=>$v['goodssn'],
        'skus'=>$sku,
        'status'=>$v['status']==0?'DOWN':'ON_SALE',
        'name'=>$v['title'],
        'createdTime'=>date('Y-m-d H:i:s',$v['createtime']),
        'modifiedTime'=>$v['updatetime']==0?'':date('Y-m-d H:i:s',$v['updatetime'])

    ];
}

//var_dump($goods);

apiJson($num,$product,0,'ok');


