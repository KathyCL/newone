<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Hb_EweiShopV2Page extends PluginMobilePage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		try 
		{
			$uniacid = $_W['uniacid'];
			$openid = $_W['openid'];
			$id = intval($_GPC['id']);
			$set = m('common')->getSysset('shop');
			$hb_log = pdo_fetch('select * from ' . tablename('ewei_shop_hb_log') . ' where status=0 and id=:id and uniacid=:uniacid and openid=:openid', array('id'=>$id,':uniacid' => $uniacid, ':openid'=>$_W['openid']));
			if(!empty($hb_log)){
				m('member')->setCredit($hb_log['openid'], 'credit2', $hb_log['money'], array($_W['uid'], '后台红包充值' . ' ' . $hb_log['remark']));

				
				$logno = m('common')->createNO('member_log', 'logno', 'RC');
				$data = array('openid' => $hb_log['openid'], 'logno' => $logno, 'uniacid' => $_W['uniacid'], 'type' => '0', 'createtime' => TIMESTAMP, 'status' => '1', 'title' => $set['name'] . '红包充值', 'money' => $hb_log['money'], 'remark' => $remark, 'rechargetype' => 'hb');
				pdo_insert('ewei_shop_member_log', $data);
				$logid = pdo_insertid();
				m('notice')->sendMemberHbLogMessage($logid, 0, true);
				
				//更新红包已领取
				$record['status'] = 1;
				pdo_update('ewei_shop_hb_log', $record, array('id' => $id));				
			}

			
			include $this->template();
			return;
		}
		catch (Exception $e) 
		{
			$content = $e->getMessage();
			include $this->template('hb/error');
		}
		$content = $e->getMessage();
		include $this->template('hb/error');
	}
}
?>