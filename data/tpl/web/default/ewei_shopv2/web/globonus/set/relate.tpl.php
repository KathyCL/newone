<?php defined('IN_IA') or exit('Access Denied');?>

            <div class="form-group">
                <label class="col-sm-2 control-label">成为股东条件</label>
                <div class="col-sm-9 col-xs-12">
                	<?php if(cv('globonus.set.edit')) { ?>
                        <label class="radio-inline"><input type="radio"  name="data[become]" value="0" <?php  if($data['become'] ==0) { ?> checked="checked"<?php  } ?> data-needcheck="0" onclick="showBecome(this)"/> 后台指定</label>
	                    <label class="radio-inline"><input type="radio"  name="data[become]" value="1" <?php  if($data['become'] ==1) { ?> checked="checked"<?php  } ?> data-needcheck="1" onclick="showBecome(this)"/> 申请</label>
	                    <label class="radio-inline"><input type="radio"  name="data[become]" value="2" <?php  if($data['become'] ==2) { ?> checked="checked"<?php  } ?> data-needcheck="1" onclick="showBecome(this)"/> 消费次数</label>
						<label class="radio-inline"><input type="radio"  name="data[become]" value="3" <?php  if($data['become'] ==3) { ?> checked="checked"<?php  } ?> data-needcheck="1" onclick="showBecome(this)"/> 消费金额</label>
						<label class="radio-inline"><input type="radio"  name="data[become]" value="4" <?php  if($data['become'] ==4) { ?> checked="checked"<?php  } ?> data-needcheck="1" onclick="showBecome(this)"/> 购买商品</label>
					<?php  } else { ?>
                        <?php  if($data['become'] ==0) { ?>后台指定<?php  } ?>
						<?php  if($data['become'] ==1) { ?>申请<?php  } ?>
						<?php  if($data['become'] ==2) { ?>消费次数<?php  } ?>
						<?php  if($data['become'] ==3) { ?>消费金额<?php  } ?>
						<?php  if($data['become'] ==4) { ?>购买商品<?php  } ?>
					<?php  } ?>
                </div>
            </div>
           <div class="form-group become become2"  <?php  if($data['become']!='2' ) { ?>style="display:none"<?php  } ?>>
                    <label class="col-sm-2 control-label "></label>
                    <div class="col-sm-9 col-xs-12">
                    	<?php if(cv('globonus.set.edit')) { ?>
                           <div class='input-group' >
	                            <div class='input-group-addon'>消费达到</div>
	                            <input type='text' class='form-control' name='data[become_ordercount]' value="<?php  echo $data['become_ordercount'];?>" />
	                            <div class='input-group-addon'>次</div>
                        	</div>
                        <?php  } else { ?>
                        	消费达到 <?php  echo $data['become_ordercount'];?>次
                        <?php  } ?>
                    </div>
           </div>
          <div class="form-group  become become3" <?php  if($data['become']!='3' ) { ?>style="display:none"<?php  } ?>>
                    <label class="col-sm-2 control-label" ></label>
                    <div class="col-sm-9 col-xs-12">
                    	<?php if(cv('globonus.set.edit')) { ?>
                           <div class='input-group' >
	                            <div class='input-group-addon'>消费达到</div>
	                            <input type='text' class='form-control' name='data[become_moneycount]' value="<?php  echo $data['become_moneycount'];?>" />
	                            <div class='input-group-addon'>元</div>
	                        </div>
	                    <?php  } else { ?>
	                    	消费达到 <?php  echo $data['become_moneycount'];?>元
	                    <?php  } ?>
                    </div>
           </div>
         <div class="form-group  become become4" <?php  if($data['become']!='4' ) { ?>style="display:none"<?php  } ?>>
                    <label class="col-sm-2 control-label" ></label>
                    <div class="col-sm-9 col-xs-12">
                    	<?php if(cv('globonus.set.edit')) { ?>
                              <?php  echo tpl_selector('become_goodsid',array('url'=>webUrl('goods/query'), 'items'=>$goods,'buttontext'=>'选择商品','placeholder'=>'请输入商品标题','preview'=>false))?>
                        <?php  } else { ?>
                        	<?php  if(!empty($goods)) { ?>
                        		<a href="<?php  echo webUrl('goods/edit',array('id'=>$goods['id']))?>" target="_blank"><?php  echo $goods['title'];?>(ID: <?php  echo $goods['id'];?>)</a>
                        	<?php  } else { ?>
                        		未选择商品
                        	<?php  } ?>
                        <?php  } ?>
                    </div>
           </div>


          <div class="form-group becomecon">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-5 becomecheck" <?php  if(empty($data['become'])) { ?>style="display:none"<?php  } ?>>
                	<?php if(cv('globonus.set.edit')) { ?>
                    <label class="radio-inline"><input type="radio"  name="data[become_check]" value="0" <?php  if($data['become_check'] ==0) { ?> checked="checked"<?php  } ?> /> 需要</label>
                    <label class="radio-inline"><input type="radio"  name="data[become_check]" value="1" <?php  if($data['become_check'] ==1) { ?> checked="checked"<?php  } ?> /> 不需要</label>
                    <span class="help-block">是否需要审核</span>
                    <?php  } else { ?>
                    	<?php  if($data['become_check']==0) { ?>需要审核<?php  } else { ?>不需要审核<?php  } ?>
                    <?php  } ?>
                </div>
                <div class="col-sm-4 becomeconsume"  <?php  if(empty($data['become']) || $data['become']=='1') { ?>style="display:none"<?php  } ?>>
                	<?php if(cv('globonus.set.edit')) { ?>
                    <label class="radio-inline"><input type="radio"  name="data[become_order]" value="0" <?php  if($data['become_order'] ==0) { ?> checked="checked"<?php  } ?> /> 付款后</label>
                    <label class="radio-inline"><input type="radio"  name="data[become_order]" value="1" <?php  if($data['become_order'] ==1) { ?> checked="checked"<?php  } ?> /> 完成后</label>
                    <span class="help-block">消费条件统计的方式</span>
                    <?php  } else { ?>
                    	消费条件统计的方式: <?php  if($data['become_order'] ==0) { ?>付款后<?php  } else { ?>完成后<?php  } ?>
                    <?php  } ?>
                </div>
           </div>

            <div class="form-group protocol-group" <?php  if($data['become'] !=1) { ?>style="display: none;"<?php  } ?>>
                <label class="col-sm-2 control-label">显示申请协议</label>
                <div class="col-sm-8">
                    <?php if(cv('commission.set.edit')) { ?>
                    <label class="radio-inline"><input type="radio"  name="data[open_protocol]" value="0" <?php  if($data['open_protocol'] ==0) { ?> checked="checked"<?php  } ?> /> 隐藏</label>
                    <label class="radio-inline"><input type="radio"  name="data[open_protocol]" value="1" <?php  if($data['open_protocol'] ==1) { ?> checked="checked"<?php  } ?> /> 显示</label>
                    <?php  } else { ?>
                    <?php  if($data['open_protocol'] ==0) { ?>隐藏<?php  } else { ?>显示<?php  } ?>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">指定股东说明</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('globonus.set.edit')) { ?>
                    <textarea class="form-control" name="data[noregdesc]" rows="5"><?php  echo $data['noregdesc'];?></textarea>
                    <span class="help-block">当“成为股东条件”选择指定条件时，非股东人员的提示文字, 默认显示为：想成为股东吗？请立即联系我们！</span>
                    <?php  } else { ?>
                    <?php  echo $data['centerdesc'];?>
                    <?php  } ?>
                </div>
            </div>
<!--青岛易联互动网络科技有限公司-->