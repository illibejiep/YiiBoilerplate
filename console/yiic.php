<?php
/* change dir to root */
chdir(dirname(__FILE__) . '/..');

$config =  require_once('console/config/main.php');

require_once('common/lib/Yii/yii.php');
require_once('common/lib/global.php');
require_once('common/lib/Yii/yiic.php');