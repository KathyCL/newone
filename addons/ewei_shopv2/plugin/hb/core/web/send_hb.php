<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Send_hb_EweiShopV2Page extends WebPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;

		$id = !empty($_GPC['id']) ? str_replace("_",",",$_GPC['id']) : 0;		
		if(!empty($id)){
			$members = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member') . ' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid']);
		}else{
			$members = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid=' . $_W['uniacid']);
		}
		
		//print_r($members);
		
		//$profile = m('member')->getMember($id, true);
		if ($_W['ispost']) 
		{
			$num = floatval($_GPC['num']);
			$remark = trim($_GPC['remark']);
			if ($num <= 0) 
			{
				show_json(0, array('message' => '请填写大于0的数字!'));
			}

			//m('member')->setCredit($profile['openid'], $type, $num, array($_W['uid'], '后台会员充值' . $typestr . ' ' . $remark));
			$changetype = 0;
			$changenum = 0;
			if (0 <= $num) 
			{
				$changetype = 0;
				$changenum = $num;
			}
			else 
			{
				$changetype = 1;
				$changenum = -$num;
			}

			foreach($members as $m){
				$data = array('openid' => $m['openid'], 'uniacid' => $_W['uniacid'],'end_time'=>strtotime($_GPC['end_time']),  'status' => '0', 'money' => $num, 'remark' => $remark);
				pdo_insert('ewei_shop_hb_log', $data);
				$logid = pdo_insertid();
				m('notice')->sendMemberHbMessage($logid, 0, true);
			}
			
			show_json(1, array('url' => referer()));
		}
		include $this->template();
	}
}
?>