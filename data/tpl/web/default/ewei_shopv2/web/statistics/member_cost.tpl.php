<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-heading"> <h2>会员消费排行</h2></div>

<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
    <input type="hidden" name="c" value="site" />
    <input type="hidden" name="a" value="entry" />
    <input type="hidden" name="m" value="ewei_shopv2" />
    <input type="hidden" name="do" value="web" />
    <input type="hidden" name="r" value="statistics.member_cost" />
    <div class="page-toolbar row m-b-sm m-t-sm">
        <div class="col-sm-4">

            <div class="input-group-btn">
                <button class="btn btn-default btn-sm"  type="button" data-toggle='refresh'><i class='fa fa-refresh'></i></button>
            </div>
        </div>


        <div class="col-sm-8 pull-right">

            <select name="orderby" class='form-control input-sm select-sm' style="width: 120px;">
                <option value="" <?php  if($_GPC['orderby'] == '') { ?> selected<?php  } ?>>排序</option>
                <option value="ordercount" <?php  if($_GPC['orderby']== 'ordercount') { ?> selected<?php  } ?>>订单数</option>
                <option value="ordermoney" <?php  if($_GPC['orderby'] == 'ordermoney') { ?> selected<?php  } ?>>消费金额</option>
            </select>
            <div class="input-group">
                <input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="会员名/手机号"> <span class="input-group-btn">
                <button class="btn btn-sm btn-primary" type="submit"> 搜索</button>
                <?php if(cv('statistics.member_cost.export')) { ?>
                	<button type="submit" name="export" value='1' class="btn btn-success btn-sm">导出 Excel</button> </span>
                <?php  } ?>
            </div>

        </div>
    </div>
</form>

<table class="table table-hover">
    <thead>
    <tr>
        <th style='width:80px;'>排行</th>
        <th>粉丝</th>
        <th>姓名</th>
        <th>手机号</th>
        <th>等级</th>
        <th>消费金额</th>
        <th>订单数</th>
    </tr>
    </thead>
    <tbody>
    <?php  if(is_array($list)) { foreach($list as $key => $item) { ?>
    <tr>
        <td><?php  if(($pindex -1)* $psize + $key + 1<=3) { ?>
            <labe class='label label-danger' style='padding:8px;'>&nbsp;<?php  echo ($pindex -1)* $psize + $key + 1?>&nbsp;</labe>
            <?php  } else { ?>
            <labe class='label label-default'  style='padding:8px;'>&nbsp;<?php  echo ($pindex -1)* $psize + $key + 1?>&nbsp;</labe>
            <?php  } ?>
        </td>
        <td><img src="<?php  echo tomedia($item['avatar'])?>" style='padding:1px;width:30px;height:30px;border:1px solid #ccc' />
            <?php  echo $item['nickname'];?></td>
        <td><?php  echo $item['realname'];?></td>
        <td><?php  echo $item['mobile'];?></td>
        <td><?php  if(empty($item['levelname'])) { ?> <?php echo empty($shop['levelname'])?'普通会员':$shop['levelname']?> <?php  } else { ?><?php  echo $item['levelname'];?><?php  } ?></td>
        <td><?php  echo $item['ordermoney'];?></td>
        <td><?php  echo $item['ordercount'];?></td>
    </tr>
    <?php  } } ?>
</table>
<?php  echo $pager;?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--NDAwMDA5NzgyNw==-->