<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-sm-2 control-label">股东等级</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('globonus.partner.edit')) { ?>
        <select name='gdata[partnerlevel]' class='form-control'>
            <option value='0'><?php echo empty($plugin_globonus_set['levelname'])?'默认等级':$plugin_globonus_set['levelname']?> </option>
            <?php  if(is_array($partnerlevels)) { foreach($partnerlevels as $level) { ?>
            <option value='<?php  echo $level['id'];?>' <?php  if($member['partnerlevel']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
            <?php  } } ?>
        </select>
        <?php  } else { ?>
        <input type="hidden" name="gdata[partnerlevel]" class="form-control" value="<?php  echo $member['partnerlevel'];?>"  />

        <?php  if(empty($member['partnerlevel'])) { ?>
        <?php echo empty($plugin_globonus_set['levelname'])?'默认等级':$plugin_globonus_set['levelname']?>
        <?php  } else { ?>
        <?php  echo pdo_fetchcolumn('select levelname from '.tablename('ewei_shop_globonus_level').' where id=:id limit 1',array(':id'=>$member['partnerlevel']))?>
        <?php  } ?>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">累计分红</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'> <?php  echo $member['bonusmoney']?></div>
    </div>
</div>
 
<?php  if(!empty($member['partnertime'])) { ?>
<div class="form-group">
    <label class="col-sm-2 control-label">成为股东时间</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'><?php  echo date('Y-m-d H:i:s',$member['partnertime'])?></div>
    </div>
</div>
<?php  } ?>
<div class="form-group">
    <label class="col-sm-2 control-label">股东权限</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('globonus.partner.check')) { ?>
        <label class="radio-inline"><input type="radio" name="gdata[ispartner]" value="1" <?php  if($member['ispartner']==1) { ?>checked<?php  } ?>>是</label>
        <label class="radio-inline" ><input type="radio" name="gdata[ispartner]" value="0" <?php  if($member['ispartner']==0) { ?>checked<?php  } ?>>否</label>
        <?php  } else { ?>
        <input type='hidden' name='gdata[ispartner]' value='<?php  echo $member['ispartner'];?>' />
        <div class='form-control-static'><?php  if($member['ispartner']==1) { ?>是<?php  } else { ?>否<?php  } ?></div>
        <?php  } ?>

    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">审核通过</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('globonus.partner.check')) { ?>
        <label class="radio-inline"><input type="radio" name="gdata[partnerstatus]" value="1" <?php  if($member['partnerstatus']==1) { ?>checked<?php  } ?>>是</label>
        <label class="radio-inline" ><input type="radio" name="gdata[partnerstatus]" value="0" <?php  if($member['partnerstatus']==0) { ?>checked<?php  } ?>>否</label>
        <input type='hidden' name='oldpartnerstatus' value="<?php  echo $member['partnerstatus'];?>" />
        <?php  } else { ?>
        <input type='hidden' name='gdata[partnerstatus]' value='<?php  echo $member['partnerstatus'];?>' />
        <div class='form-control-static'><?php  if($member['partnerstatus']==1) { ?>是<?php  } else { ?>否<?php  } ?></div>
        <?php  } ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">强制不自动升级</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('globonus.partner.edit')) { ?>
        <label class="radio-inline" ><input type="radio" name="gdata[partnernotupgrade]" value="0" <?php  if($member['partnernotupgrade']==0) { ?>checked<?php  } ?>>允许自动升级</label>
        <label class="radio-inline"><input type="radio" name="gdata[partnernotupgrade]" value="1" <?php  if($member['partnernotupgrade']==1) { ?>checked<?php  } ?>>强制不自动升级</label>
        <span class="help-block">如果强制不自动升级，满足任何条件，此股东的级别也不会改变</span>
        <?php  } else { ?>
        <input type="hidden" name="gdata[partnernotupgrade]" class="form-control" value="<?php  echo $member['partnernotupgrade'];?>"  />
        <div class='form-control-static'><?php  if($member['partnernotupgrade']==1) { ?>强制不自动升级<?php  } else { ?>允许自动升级<?php  } ?></div>
        <?php  } ?>
    </div>
</div>


<?php  if($diyform_flag_globonus == 1) { ?>

    <div class='form-group-title'>自定义表单信息</div>

    <?php  $datas = iunserializer($member['diyglobonusdata'])?>
    <?php  if(is_array($gfields)) { foreach($gfields as $key => $value) { ?>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?php  echo $value['tp_name']?></label>
        <div class="col-sm-9 col-xs-12">
            <div class="form-control-static">
                <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('diyform/diyform', TEMPLATE_INCLUDEPATH)) : (include template('diyform/diyform', TEMPLATE_INCLUDEPATH));?>
            </div>
        </div>
    </div>
    <?php  } } ?>
<?php  } ?>
<!--4000097827-->