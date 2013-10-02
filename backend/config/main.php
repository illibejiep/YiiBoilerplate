<?php

$backendConfigDir = dirname(__FILE__);
$root = $backendConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
$commonFile = $root . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php';
$config = require($commonFile);

Yii::setPathOfAlias('www', $root. DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'www');

$config = CMap::mergeArray(
    $config,
    array(
        'name' => 'Clevertech Backend Boilerplate',
        // @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
        'basePath' => 'backend',
        // preload components required before running applications
        // @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
        'preload' => array('bootstrap', 'log'),
        // @see http://www.yiiframework.com/doc/api/1.1/CApplication#language-detail
        'language' => 'en',
        // using bootstrap theme ? not needed with extension
//		'theme' => 'bootstrap',
        // setup import paths aliases
        // @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
        'import' => array(
            // uncomment if behaviors are required
            // you can also import a specific one
            /* 'common.extensions.behaviors.*', */
            // uncomment if validators on common folder are required
            /* 'common.extensions.validators.*', */
            'application.components.*',
            'application.controllers.*',
            'application.models.*'
        ),
        /* uncomment and set if required */
        // @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
        /* 'modules' => array(
            'gii' => array(
                'class' => 'system.gii.GiiModule',
                'password' => 'clevertech',
                'generatorPaths' => array(
                    'bootstrap.gii'
                )
            )
        ), */
        'components' => array(
            'user' => array(
                'allowAutoLogin'=>true,
            ),
            /* load bootstrap components */
            'bootstrap' => array(
                'class' => 'common.extensions.bootstrap.components.Bootstrap',
                'responsiveCss' => true,
            ),
            'errorHandler' => array(
                // @see http://www.yiiframework.com/doc/api/1.1/CErrorHandler#errorAction-detail
                'errorAction'=>'site/error'
            ),
            'urlManager' => array(
                'rules' => array(
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                )
            ),
        ),
    )
);

require($backendConfigDir . DIRECTORY_SEPARATOR . 'main-env.php');

require($backendConfigDir . DIRECTORY_SEPARATOR . 'main-local.php');

return $config;