<?php
$commonConfigDir = dirname(__FILE__);
$root = realpath($commonConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');

$config = array(
    'import' => array(
        'common.components.*',
        'common.models.*',
    ),
    'components' => array(
        'db' => array(
            'schemaCachingDuration' => YII_DEBUG ? 0 : 86400000, // 1000 days
            'enableParamLogging' => YII_DEBUG,
            'charset' => 'utf8'
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '/',
        ),
        'cache' => extension_loaded('apc') ?
            array(
                'class' => 'CApcCache',
            ) :
            array(
                'class' => 'CDbCache',
                'connectionID' => 'db',
                'autoCreateCacheTable' => true,
                'cacheTableName' => 'cache',
            ),
    )
);

require($commonConfigDir . DIRECTORY_SEPARATOR . 'main-env.php');

require($commonConfigDir . DIRECTORY_SEPARATOR . 'main-local.php');

require_once($root. DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Yii' . DIRECTORY_SEPARATOR . 'yii.php');

Yii::setPathOfAlias('root', $root);
Yii::setPathOfAlias('common', $root. DIRECTORY_SEPARATOR . 'common');
Yii::setPathOfAlias('console', $root. DIRECTORY_SEPARATOR . 'console');
Yii::setPathOfAlias('backend', $root. DIRECTORY_SEPARATOR . 'backend');
Yii::setPathOfAlias('frontend', $root. DIRECTORY_SEPARATOR . 'frontend');

return $config;