<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}




if (!(class_exists('HbModel'))) {
	class HbModel extends PluginModel
	{
		public function checkMember()
		{
			global $_W;
			global $_GPC;

			if (!(empty($_W['openid']))) {
				$member = pdo_fetch('select * from ' . tablename('ewei_shop_sns_member') . ' where uniacid=:uniacid and openid=:openid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

				if (empty($member)) {
					$member = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'createtime' => time());
					pdo_insert('ewei_shop_sns_member', $member);
				}
				 else if (!(empty($member['isblack']))) {
					show_message('禁止访问，请联系客服!');
				}

			}

		}

		public function getMember($openid)
		{
			global $_W;
			global $_GPC;
			$member = m('member')->getMember($openid);
			$sns_member = pdo_fetch('select * from ' . tablename('ewei_shop_sns_member') . ' where uniacid=:uniacid and openid=:openid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $member['openid']));

			if (empty($sns_member)) {
				$member['sns_credit'] = 0;
				$member['sns_level'] = 0;
				$member['notupgrade'] = 0;
			}
			 else {
				$member['sns_id'] = $sns_member['id'];
				$member['sns_credit'] = $sns_member['credit'];
				$member['sns_level'] = $sns_member['level'];
				$member['sns_sign'] = $sns_member['sign'];
				$member['sns_notupgrade'] = $sns_member['notupgrade'];
			}

			return $member;
		}


		/**
         * 获取所有会员等级
         * @global type $_W
         * @return type
         */
		public function getLevels($all = true)
		{
			global $_W;
			$condition = '';

			if (!($all)) {
				$condition = ' and enabled=1';
			}


			return pdo_fetchall('select * from ' . tablename('ewei_shop_sns_level') . ' where uniacid=:uniacid' . $condition . ' order by id asc', array(':uniacid' => $_W['uniacid']));
		}

	}

}


?>