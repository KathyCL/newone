<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    .multi-img-details .multi-item img{height:100px;}
    .table > thead > tr > th,
    .table > tbody > tr > th,
    .table > tfoot > tr > th,
    .table > thead > tr > td,
    .table > tbody > tr > td,
    .table > tfoot > tr > td {
        border-top: none;
    }.refund-group{display: none;}
</style>
<div class="page-header">

    当前位置：<span class="text-primary"> <?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>商品 <small><?php  if(!empty($item['id'])) { ?>修改【<?php  echo $item['titles'];?>】<?php  } ?></small></span>
</div>

<div class="page-content">
    <div class="page-sub-toolbar">
         <span class=''>
            <?php if(cv('sale.fullback.add')) { ?>
                <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('sale/fullback/add')?>"><i class='fa fa-plus'></i> 添加商品</a>
            <?php  } ?>
        </span>
    </div>
    <form <?php if( ce('sale.fullback' ,$item) ) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
    <input type="hidden" name="goodsid" value="<?php  echo $item['goodsid'];?>">
    <div class="tab-content ">
        <div class="tab-pane active">
            <div class="panel-body">

                <div class="form-group">
                    <label class="col-lg control-label">排序</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if( ce('sale.fullback' ,$item) ) { ?>
                        <input type='text' class='form-control' name='displayorder' value="<?php  echo $item['displayorder'];?>" />
                        <span class="help-block">数字越大，排名越靠前,如果为空，默认排序方式为创建时间</span>
                        <?php  } else { ?>
                        <div class='form-control-static'><?php  echo $item['displayorder'];?></div>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg control-label must">商品标题</label>
                    <div class="col-sm-9 col-xs-12 ">
                        <?php if( ce('sale.fullback' ,$item) ) { ?>
                        <input type="text" id='titles' name="titles" class="form-control" value="<?php  echo $item['titles'];?>" data-rule-required="true"/>
                        <?php  } else { ?>
                        <div class='form-control-static'><?php  echo $item['titles'];?></div>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg control-label">全返类型</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if( ce('sale.fullback' ,$item) ) { ?>
                        <label class="radio-inline">
                            <input type="radio" name="type" value="0" <?php  if(empty($item['type']) || $item['type'] == 0) { ?>checked="true"<?php  } ?>  />
                            指定金额
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type" value="1"  <?php  if($item['type'] == 1) { ?>checked="true"<?php  } ?> />
                            金额比例
                        </label>
                        <?php  } else { ?>
                        <div class='form-control-static'>
                            <?php  if($item['type'] == 0) { ?>
                            指定金额
                            <?php  } else if($item['type']==1) { ?>
                            金额比例
                            <?php  } ?></div>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg control-label must">选择商品</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if( ce('sale.fullback' ,$item) ) { ?>
                            <?php  if(empty($item)) { ?>
                            <div>
                                <?php  echo tpl_selector_new('goodsid',array('preview'=>true,
                                'readonly'=>true,
                                'required'=>true,
                                'type'=>'fullback',
                                'value'=>$item['title'],
                                'url'=>webUrl('sale/fullback/query'),
                                'optionurl'=>'sale.fullback.hasoption',
                                'items'=>$item,
                                'nokeywords'=>1,
                                'autosearch'=>1,
                                'buttontext'=>'选择商品',
                                'placeholder'=>'请选择商品')
                                )
                                ?>
                            </div>
                            <?php  } else { ?>
                                <div class="">
                                    <input type="text" id="goodsid_text" name="goodsid_text" value="<?php  echo $item['title'];?>" class="form-control text valid" readonly="" data-rule-required="true" aria-required="true" aria-invalid="false" aria-describedby="goodsid_text-error">
                                </div>
                                <div class="input-group multi-audio-details container">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th style='width:80px;'>商品名称</th>
                                            <th style='width:220px;'></th>
                                            <th>全返金额</th>
                                        </tr>
                                        </thead>
                                        <tbody id="param-items" class="ui-sortable">
                                        <?php  if(!empty($item)) { ?>
                                        <tr class="multi-product-item" data-id="<?php  echo $item['goodsid'];?>">
                                            <input type="hidden" class="form-control img-textname" readonly="" value="<?php  echo $item['title'];?>">
                                            <input type="hidden" value="<?php  echo $item['goodsid'];?>" name="goodsid[]">
                                            <td style="width:80px;">
                                                <img src="<?php  echo tomedia($item['thumb'])?>" style="width:70px;border:1px solid #ccc;padding:1px">
                                            </td>
                                            <td style="width:220px;"><?php  echo $item['title'];?></td>
                                            <td>
                                                <?php  if($item['hasoption']>0) { ?>
                                                    <a class="btn btn-default btn-sm" data-toggle="ajaxModal"
                                                       href="<?php  echo webUrl('sale/fullback/hasoption',array('goodsid'=>$item['goodsid'],'id'=>$item['id']))?>" id="optiontitle<?php  echo $item['goodsid'];?>">&yen;<?php  echo price_format($item['minallfullbackallprice'],2)?> ~ &yen;<?php  echo price_format($item['maxallfullbackallprice'],2)?></a>
                                                    <input type="hidden" id="fullbackgoods<?php  echo $item['goodsid'];?>" value="<?php  echo $optionid;?>" name="fullbackgoods[<?php  echo $item['goodsid'];?>]">
                                                    <?php  if(is_array($item['option'])) { foreach($item['option'] as $op) { ?>
                                                        <input type="hidden" value="<?php  echo $op['allfullbackprice'];?>,<?php  echo $op['fullbackprice'];?>,<?php  echo $op['allfullbackratio'];?>,<?php  echo $op['fullbackratio'];?>,<?php  echo $op['day'];?>" name="fullbackgoodsoption<?php  echo $op['id'];?>">
                                                    <?php  } } ?>
                                                <?php  } else { ?>
                                                <a class="btn btn-default btn-sm" data-toggle="ajaxModal"
                                                   href="<?php  echo webUrl('sale/fullback/hasoption',array('goodsid'=>$item['goodsid'],'id'=>$item['id']))?>" id="optiontitle<?php  echo $item['goodsid'];?>">&yen;<?php  echo price_format($item['minallfullbackallprice'],2)?></a>
                                                <input type="hidden" id="fullbackgoods<?php  echo $item['goodsid'];?>" value="" name="fullbackgoods[<?php  echo $item['goodsid'];?>]">
                                                <input type="hidden" value="<?php  echo $item['minallfullbackallprice'];?>,<?php  echo $item['fullbackprice'];?>,<?php  echo $item['minallfullbackallratio'];?>,<?php  echo $item['fullbackratio'];?>,<?php  echo $item['day'];?>" name="goods<?php  echo $item['goodsid'];?>">
                                                <?php  } ?>
                                            </td>
                                        </tr>
                                        <?php  } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php  } ?>
                        <?php  } else { ?>
                        <?php  if(!empty($item)) { ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th style='width:80px;'>商品名称</th>
                                <th style='width:220px;'></th>
                                <th>全返金额</th>
                            </tr>
                            </thead>
                            <tbody id="param-items" class="ui-sortable">
                            <?php  if(!empty($item)) { ?>
                            <tr class="multi-product-item" data-id="<?php  echo $item['goodsid'];?>">
                                <input type="hidden" class="form-control img-textname" readonly="" value="<?php  echo $item['title'];?>">
                                <input type="hidden" value="<?php  echo $item['goodsid'];?>" name="goodsid[]">
                                <td style="width:80px;">
                                    <img src="<?php  echo tomedia($item['thumb'])?>" style="width:70px;border:1px solid #ccc;padding:1px">
                                </td>
                                <td style="width:220px;"><?php  echo $item['title'];?></td>
                                <td>
                                    <?php  if($item['hasoption']>0) { ?>
                                        <a class="btn btn-default btn-sm" data-toggle="ajaxModal"
                                           href="javascript:void(0);" id="optiontitle<?php  echo $item['goodsid'];?>">&yen;<?php  echo price_format($item['minallfullbackallprice'],2)?> ~ &yen;<?php  echo price_format($item['maxallfullbackallprice'],2)?></a>
                                        <input type="hidden" id="fullbackgoods<?php  echo $item['goodsid'];?>" value="<?php  echo $optionid;?>" name="fullbackgoods[<?php  echo $item['goodsid'];?>]">
                                        <?php  if(is_array($item['option'])) { foreach($item['option'] as $op) { ?>
                                        <input type="hidden" value="<?php  echo $op['allfullbackprice'];?>,<?php  echo $op['fullbackprice'];?>,<?php  echo $op['allfullbackratio'];?>,<?php  echo $op['fullbackratio'];?>,<?php  echo $op['day'];?>" name="fullbackgoodsoption<?php  echo $op['id'];?>">
                                        <?php  } } ?>
                                    <?php  } else { ?>
                                        <a class="btn btn-default btn-sm" data-toggle="ajaxModal"
                                           href="javascript:void(0);" id="optiontitle<?php  echo $item['goodsid'];?>">&yen;<?php  echo price_format($item['minallfullbackallprice'],2)?></a>
                                        <input type="hidden" id="fullbackgoods<?php  echo $item['goodsid'];?>" value="" name="fullbackgoods[<?php  echo $item['goodsid'];?>]">
                                        <input type="hidden" value="<?php  echo $item['minallfullbackallprice'];?>,<?php  echo $item['fullbackprice'];?>,<?php  echo $item['minallfullbackallratio'];?>,<?php  echo $item['fullbackratio'];?>,<?php  echo $item['day'];?>" name="goods<?php  echo $item['goodsid'];?>">
                                    <?php  } ?>
                                </td>
                            </tr>
                            <?php  } ?>
                            </tbody>
                        </table>
                        <?php  } else { ?>
                        暂无商品
                        <?php  } ?>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group cgt cgt-3">
                    <label class="col-lg control-label">全返时间</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if( ce('sale.fullback' ,$item) ) { ?>
                        <div class="input-group fixsingle-input-group">
                            <span class="input-group-addon">确认收货</span>
                            <input type="number" class="form-control" name="startday" value="<?php  echo $item['startday'];?>">
                            <span class="input-group-addon">天后，开始全返</span>
                        </div>
                        <span class="help-block">全返的时间尽量设置超过系统允许【确认收货】->【申请退款】的时间</span>
                        <?php  } else { ?>
                        <div class='form-control-static'>确认收货：<?php  echo $coupon['startday'];?>天后，开始全返</div>
                        <?php  } ?>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-lg control-label">全返开始后支持退款</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if( ce('sale.fullback' ,$item) ) { ?>
                        <label class="radio-inline">
                            <input type="radio" name="refund" value="1"  <?php  if($item['refund'] == 1) { ?>checked="true"<?php  } ?> />
                            是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="refund" value="0" <?php  if(empty($item['refund']) || $item['refund'] == 0) { ?>checked="true"<?php  } ?>  />
                            否
                        </label>
                        <div class="input-group refund-group-click <?php  if($item['refund'] == 0) { ?>refund-group<?php  } ?>" style="padding-top:10px;">
                            <div class="alert alert-danger">
                                如果您选择全返商品支持退款，会员在全返开始后发起【退款】请求，可退款金额将减去已返金额，已返金额不会退款；如果全返金额大于商品实际价格，不能退款。
                            </div>
                        </div>
                        <?php  } else { ?>
                        <div class='form-control-static'>
                            <?php  if($item['refund'] == 0) { ?>
                            不支持退款
                            <?php  } else if($item['refund']==1) { ?>
                            支持退款
                            <?php  } ?></div>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class=" col-lg control-label">状态</label>
                    <div class="col-xs-12 col-sm-9">
                        <div class="input-group">
                            <?php if( ce('sale.fullback' ,$item) ) { ?>
                            <label class="radio radio-inline">
                                <input type="radio" name="status" value="1" <?php  if(intval($item['status']) ==1 ) { ?>checked="checked"<?php  } ?>> 开启
                            </label>
                            <label class="radio radio-inline">
                                <input type="radio" name="status" value="0" <?php  if(intval($item['status']) ==0) { ?>checked="checked"<?php  } ?>> 关闭
                            </label>
                            <?php  } else { ?>
                            <div class='form-control-static'><?php  if(intval($item['status']) ==1 ) { ?>开启<?php  } else { ?>关闭<?php  } ?></div>
                            <?php  } ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <?php if( ce('sale.fullback' ,$item) ) { ?>
    <div class="form-group">
        <label class="col-lg control-label"></label>
        <div class="col-sm-9 col-xs-12">
            <input type="submit"  value="提交" class="btn btn-primary" />
            <a class="btn btn-default" href="<?php  echo webUrl('sale/fullback')?>">返回列表</a>
        </div>
    </div>
    <?php  } ?>

    </form>
</div>
<script>
    $(function () {
        $(":radio[name=refund]").off("click").on("click",function () {
            if($(this).val()==1){
                $(".refund-group-click").show();
            }else{
                $(".refund-group-click").hide();
            }
        })
    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--NDAwMDA5NzgyNw==-->