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
            'application.models.*',
            'application.widgets.*',
            'ext.jformvalidate.EHtml',
        ),
        /* uncomment and set if required */
        // @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
        'modules'=>array(
            // uncomment the following to enable the Gii tool
            'gii'=>array(
                'class'=>'system.gii.GiiModule',
                'password'=>'asdf',
                'generatorPaths'=>array(
                    'giiy.generators'
                ),
                // If removed, Gii defaults to localhost only. Edit carefully to taste.
                'ipFilters'=>array('127.0.0.1','::1'),
                'newFileMode'=>0666,
                'newDirMode'=>0777,
            ),
            'giiy' => array(
                'modelsPaths' => array(
                    'common.models',
                    'backend.models',
                    'frontend.models',
                )
            )
        ),
        'components' => array(
            /* load bootstrap components */
            'bootstrap' => array(
                'class' => 'ext.bootstrap.components.Bootstrap',
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
            'phpmessages' => array (
                // Pending on core: http://code.google.com/p/yii/issues/detail?id=2624
                'extensionBasePaths' => array(
                    'giix' => 'ext.giix.messages', // giix messages directory.
                ),
            ),
            'jformvalidate' => array (
                'class' => 'ext.jformvalidate.EJFValidate',
                'enable' => true,            ),
        ),
    )
);

require($backendConfigDir . DIRECTORY_SEPARATOR . 'main-env.php');

require($backendConfigDir . DIRECTORY_SEPARATOR . 'main-local.php');

return $config;