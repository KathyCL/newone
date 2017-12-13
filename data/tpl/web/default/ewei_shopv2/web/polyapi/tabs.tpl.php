<?php defined('IN_IA') or exit('Access Denied');?><style type='text/css'>
    .mc-list a {
        position: relative;
    }
    .mc-list span  {

        float:right;margin-right:20px;
    }
</style>

<div class='menu-header'>设置</div>
<ul>
    <?php if(cv('polyapi.set')) { ?><li <?php  if($_W['routes']=='polyapi.set') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('polyapi/set')?>">基础设置</a></li><?php  } ?>
</ul>

<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->