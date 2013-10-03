<?php

chdir(dirname(__FILE__) . '/../..');
$config = require('frontend/config/main.php');

require_once('common/components/WebApplication.php');
require_once('common/lib/global.php');

$app = Yii::createApplication('WebApplication', $config);

/* please, uncomment the following if you are using ZF library */
/*
Yii::import('common.extensions.EZendAutoloader', true);

EZendAutoloader::$prefixes = array('Zend');
EZendAutoloader::$basePath = Yii::getPathOfAlias('common.lib') . DIRECTORY_SEPARATOR;

Yii::registerAutoloader(array("EZendAutoloader", "loadClass"), true);
*/

$app->run();

/* uncomment if you wish to debug your resulting config */
/* echo '<pre>' . dump($config) . '</pre>'; */
