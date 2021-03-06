<?php defined('IN_IA') or exit('Access Denied');?><?php  $no_left=true?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .form-horizontal .form-group{margin-right: -50px;}
    .col-sm-9{padding-right: 0;}
	.tm .btn { margin-bottom:5px;}
</style>

<div class="page-heading"> 
	
	<span class='pull-right'>
		
		<?php if(cv('sysset.printer.printer_add')) { ?>
                            <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('sysset/printer/printer_add')?>">添加打印机</a>
		<?php  } ?>
                
		<a class="btn btn-default  btn-sm" href="<?php  echo webUrl('sysset/printer/printer_list')?>">返回列表</a>
	</span>
	<h2><?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>打印机 <small><?php  if(!empty($item['id'])) { ?>修改【<?php  echo $item['title'];?>】<?php  } ?></small></h2>
</div>

<div class="row">
	<div class="col-sm-9">
		
	 <form <?php if( ce('sysset.printer' ,$list) ) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2 control-label must" >打印机名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <input type="text" name="title" class="form-control" value="<?php  echo $list['title'];?>" placeholder="小票模版名称，例：订单打印小票" data-rule-required='true' />
                        <?php  } else { ?>
                        <div class='form-control-static'><?php  echo $list['title'];?></div>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">打印机类型</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <select class="form-control tpl-category-parent" name="type" id="type">
                            <?php  if(is_array($printer)) { foreach($printer as $key => $val) { ?>
                            <option value="<?php  echo $key;?>" <?php  if($list['type']==$key) { ?>selected="true"<?php  } ?>><?php  echo $val;?></option>
                            <?php  } } ?>
                        </select>
                        <?php  } else { ?>
                        <div class='form-control-static'><?php  echo $printer[$list['type']];?></div>
                        <?php  } ?>
                        <div class="help-block">选择打印机类型,目前已支持打印机 : 365的T58K -- 飞鹅的FP-58W -- 易联云的K3</div>
                    </div>
                </div>

                <!--365打印机-->
                <div id="printer_365" class="printer" <?php  if($list['type']!=0) { ?>style="display: none"<?php  } ?>>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >打印机编号</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_365[deviceNo]" class="form-control" value="<?php  echo $printer_365['deviceNo'];?>"/>
                            <span class='help-block'>打印机编号(ID)</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_365['deviceNo'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >打印机密钥</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_365[key]" class="form-control" value="<?php  echo $printer_365['key'];?>"/>
                            <span class='help-block'>打印机的KEY,打印机的密钥</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_365['key'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >打印联数</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_365[times]" class="form-control" value="<?php  echo $printer_365['times'];?>"/>
                            <span class='help-block'>同一订单，打印的次数</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_365['times'];?></div>
                        </div>
                        <?php  } ?>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" >URL</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_365[url]" class="form-control" value="<?php echo !empty($printer_365['url']) ? $printer_365['url'] : 'http://open.printcenter.cn:8080/addOrder'?>"/>
                            <span class='help-block'>打印机POST的地址,不填写的话,默认是这个!</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_365['times'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                </div>

                <!--365打印机s1-->
                <div id="printer_365_s1" class="printer" <?php  if($list['type']!=3) { ?>style="display: none"<?php  } ?>>
                <div class="form-group">
                    <label class="col-sm-2 control-label" >打印机编号</label>
                    <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                    <div class="col-sm-9 title" style='padding-right:0' >
                        <input type="text" name="printer_365_s1[deviceNo]" class="form-control" value="<?php  echo $printer_365_s1['deviceNo'];?>"/>
                        <span class='help-block'>打印机编号(ID)</span>
                    </div>
                    <?php  } else { ?>
                    <div class="col-sm-3">
                        <div class='form-control-static'><?php  echo $printer_365_s1['deviceNo'];?></div>
                    </div>
                    <?php  } ?>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" >打印机密钥</label>
                    <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                    <div class="col-sm-9 title" style='padding-right:0' >
                        <input type="text" name="printer_365_s1[key]" class="form-control" value="<?php  echo $printer_365_s1['key'];?>"/>
                        <span class='help-block'>打印机的KEY,打印机的密钥</span>
                    </div>
                    <?php  } else { ?>
                    <div class="col-sm-3">
                        <div class='form-control-static'><?php  echo $printer_365_s1['key'];?></div>
                    </div>
                    <?php  } ?>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" >打印联数</label>
                    <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                    <div class="col-sm-9 title" style='padding-right:0' >
                        <input type="text" name="printer_365_s1[times]" class="form-control" value="<?php  echo $printer_365_s1['times'];?>"/>
                        <span class='help-block'>同一订单，打印的次数</span>
                    </div>
                    <?php  } else { ?>
                    <div class="col-sm-3">
                        <div class='form-control-static'><?php  echo $printer_365_s1['times'];?></div>
                    </div>
                    <?php  } ?>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" >URL</label>
                    <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                    <div class="col-sm-9 title" style='padding-right:0' >
                        <input type="text" name="printer_365_s1[url]" class="form-control" value="<?php echo !empty($printer_365_s1['url']) ? $printer_365_s1['url'] : 'http://open.printcenter.cn:8080/addOrder'?>"/>
                        <span class='help-block'>打印机POST的地址,不填写的话,默认是这个!</span>
                    </div>
                    <?php  } else { ?>
                    <div class="col-sm-3">
                        <div class='form-control-static'><?php  echo $printer_365_s1['times'];?></div>
                    </div>
                    <?php  } ?>
                </div>
            </div>


                <!--飞鹅打印机-->
                <div id="printer_feie" class="printer" <?php  if($list['type']!='1') { ?>style="display: none"<?php  } ?>>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >打印机编号</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_feie[deviceNo]" class="form-control" value="<?php  echo $printer_feie['deviceNo'];?>"/>
                            <span class='help-block'>打印机编号9位,查看飞鹅打印机底部贴纸上面的打印机编号</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_feie['deviceNo'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >打印机密钥</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_feie[key]" class="form-control" value="<?php  echo $printer_feie['key'];?>"/>
                            <span class='help-block'>打印机的KEY,打印机的密钥</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_feie['key'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >打印联数</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_feie[times]" class="form-control" value="<?php  echo $printer_feie['times'];?>"/>
                            <span class='help-block'>同一订单，打印的次数</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_feie['times'];?></div>
                        </div>
                        <?php  } ?>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" >URL</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_feie[url]" class="form-control" value="<?php  echo $printer_feie['url'];?>"/>
                            <span class='help-block'>API接口地址 一般是 : http://api163.feieyun.com/FeieServer/printOrderAction<br>如果给你的API地址后面没有 /FeieServer/printOrderAction,请手动加上</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_feie['url'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                </div>

                <!--飞鹅打印机(新接口)-->
                <div id="printer_feie_new" class="printer" <?php  if($list['type']!='5') { ?>style="display: none"<?php  } ?>>
                <div class="form-group">
                    <label class="col-sm-2 control-label" >USER</label>
                    <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                    <div class="col-sm-9 title" style='padding-right:0' >
                        <input type="text" name="printer_feie_new[user]" class="form-control" value="<?php  echo $printer_feie_new['user'];?>"/>
                        <span class='help-block'>飞鹅云后台注册用户名</span>
                    </div>
                    <?php  } else { ?>
                    <div class="col-sm-3">
                        <div class='form-control-static'><?php  echo $printer_feie_new['user'];?></div>
                    </div>
                    <?php  } ?>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" >UKEY</label>
                    <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                    <div class="col-sm-9 title" style='padding-right:0' >
                        <input type="text" name="printer_feie_new[ukey]" class="form-control" value="<?php  echo $printer_feie_new['ukey'];?>"/>
                        <span class='help-block'>飞鹅云后台登录生成的UKEY</span>
                    </div>
                    <?php  } else { ?>
                    <div class="col-sm-3">
                        <div class='form-control-static'><?php  echo $printer_feie_new['ukey'];?></div>
                    </div>
                    <?php  } ?>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" >打印机编号</label>
                    <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                    <div class="col-sm-9 title" style='padding-right:0' >
                        <input type="text" name="printer_feie_new[sn]" class="form-control" value="<?php  echo $printer_feie_new['sn'];?>"/>
                        <span class='help-block'>打印机编号9位,查看飞鹅打印机底部贴纸上面的打印机编号</span>
                    </div>
                    <?php  } else { ?>
                    <div class="col-sm-3">
                        <div class='form-control-static'><?php  echo $printer_feie_new['sn'];?></div>
                    </div>
                    <?php  } ?>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" >打印联数</label>
                    <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                    <div class="col-sm-9 title" style='padding-right:0' >
                        <input type="text" name="printer_feie_new[times]" class="form-control" value="<?php  echo $printer_feie_new['times'];?>"/>
                        <span class='help-block'>同一订单，打印的次数</span>
                    </div>
                    <?php  } else { ?>
                    <div class="col-sm-3">
                        <div class='form-control-static'><?php  echo $printer_feie_new['times'];?></div>
                    </div>
                    <?php  } ?>
                </div>
                </div>

                <!--易联云打印机-->
                <div id="printer_yilianyun" class="printer" <?php  if($list['type']!='2') { ?>style="display: none"<?php  } ?>>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >终端号</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_yilianyun[machine_code]" class="form-control" value="<?php  echo $printer_yilianyun['machine_code'];?>"/>
                            <span class='help-block'>打印机终端号</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_yilianyun['machine_code'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >密钥</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_yilianyun[msign]" class="form-control" value="<?php  echo $printer_yilianyun['msign'];?>"/>
                            <span class='help-block'>打印机终端密钥</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_yilianyun['msign'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >用户ID</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_yilianyun[partner]" class="form-control" value="<?php  echo $printer_yilianyun['partner'];?>"/>
                            <span class='help-block'>用户id（管理中心系统集成里获取）</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_yilianyun['times'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >apiKey</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_yilianyun[apikey]" class="form-control" value="<?php  echo $printer_yilianyun['apikey'];?>"/>
                            <span class='help-block'>apiKey（管理中心系统集成里获取）</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_yilianyun['apikey'];?></div>
                        </div>
                        <?php  } ?>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" >URL</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_yilianyun[url]" class="form-control" value="<?php echo !empty($printer_yilianyun['url']) ? $printer_yilianyun['url'] : 'http://open.10ss.net:8888'?>"/>
                            <span class='help-block'>API接口地址</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_yilianyun['times'];?></div>
                        </div>
                        <?php  } ?>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" >打印联数</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_yilianyun[times]" class="form-control" value="<?php  echo $printer_yilianyun['times'];?>"/>
                            <span class='help-block'>同一订单，打印的次数</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_yilianyun['times'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                </div>

                <!--易联云新版接口打印机-->
                <div id="printer_yilianyun_new" class="printer" <?php  if($list['type']!='4') { ?>style="display: none"<?php  } ?>>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >终端号</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_yilianyun_new[machine_code]" class="form-control" value="<?php  echo $printer_yilianyun_new['machine_code'];?>"/>
                            <span class='help-block'>打印机终端号</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_yilianyun_new['machine_code'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >密钥</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_yilianyun_new[msign]" class="form-control" value="<?php  echo $printer_yilianyun_new['msign'];?>"/>
                            <span class='help-block'>打印机终端密钥</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_yilianyun_new['msign'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >用户ID</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_yilianyun_new[partner]" class="form-control" value="<?php  echo $printer_yilianyun_new['partner'];?>"/>
                            <span class='help-block'>用户id（管理中心系统集成里获取）</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_yilianyun_new['times'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >apiKey</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_yilianyun_new[apikey]" class="form-control" value="<?php  echo $printer_yilianyun_new['apikey'];?>"/>
                            <span class='help-block'>apiKey（管理中心系统集成里获取）</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_yilianyun_new['apikey'];?></div>
                        </div>
                        <?php  } ?>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" >URL</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_yilianyun_new[url]" class="form-control" value="<?php echo !empty($printer_yilianyun_new['url']) ? $printer_yilianyun_new['url'] : 'http://open.10ss.net:8888'?>"/>
                            <span class='help-block'>API接口地址</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_yilianyun_new['times'];?></div>
                        </div>
                        <?php  } ?>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" >打印联数</label>
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                        <div class="col-sm-9 title" style='padding-right:0' >
                            <input type="text" name="printer_yilianyun_new[times]" class="form-control" value="<?php  echo $printer_yilianyun_new['times'];?>"/>
                            <span class='help-block'>同一订单，打印的次数</span>
                        </div>
                        <?php  } else { ?>
                        <div class="col-sm-3">
                            <div class='form-control-static'><?php  echo $printer_yilianyun_new['times'];?></div>
                        </div>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group"></div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" ></label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('sysset.printer.printer_add'||'sysset.printer.printer_edit')) { ?>
                       <input type="submit"  value="提交" class="btn btn-primary"  />
	       
                        <?php  } ?>
                       <input type="button" name="back" onclick='history.back()' <?php if(cv('sysset.printer.add|sysset.printer.edit')) { ?>style='margin-left:10px;'<?php  } ?> value="返回列表" class="btn btn-default" />
                    </div>
                </div>
	 
</form>
	</div>
</div>

 
<script language='javascript'>
    $(function () {
        $('form').submit(function(){
            $('form').removeAttr('stop');
            return true;
        });
        $("#type").on('change',function () {
            var $this = $(this);
            $(".printer").hide();
            switch (this.value){
                case '0':$("#printer_365").show();break;
                case '1':$("#printer_feie").show();break;
                case '2':$("#printer_yilianyun").show();break;
                case '3':$("#printer_365_s1").show();break;
                case '4':$("#printer_yilianyun_new").show();break;
                case '5':$("#printer_feie_new").show();break;
            }
        });
        require(['jquery.caret'],function(){
            var jiaodian;
            $(document).on('focus', 'input,textarea',function () {
                jiaodian = this;
            });

            $("a[href='JavaScript:']").click(function () {
                if (jiaodian) {
                    $(jiaodian).insertAtCaret("["+this.innerText+"]" );
                }
            })

        })
    })
 
    </script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->