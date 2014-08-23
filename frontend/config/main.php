<?php

$frontendConfigDir = dirname(__FILE__);
$root = $frontendConfigDir . '/../' . '..';
$commonFile = $root . '/common/config/main.php';

$config = require($commonFile);
$eauthServices = require('eauth.php');

$config = CMap::mergeArray(
    $config,
    array(
        // @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
        'basePath' => 'frontend',
        // set parameters
        // preload components required before running applications
        // @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
        'preload' => array('log'),
        // @see http://www.yiiframework.com/doc/api/1.1/CApplication#language-detail
        'language' => 'en',
        // uncomment if a theme is used
        'theme' => 'default',
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
            'ext.eoauth.*',
            'ext.eoauth.lib.*',
            'ext.lightopenid.*',
            'ext.eauth.*',
            'ext.eauth.services.*',
        ),
        /* uncomment and set if required */
        // @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
        /* 'modules' => array(), */
        'components' => array(
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
            'themeManager' => array(
                'basePath' => Yii::getPathOfAlias('root.frontend.themes'),
            ),
            'loid' => array(
                'class' => 'ext.lightopenid.loid',
            ),
            'eauth' => array(
                'class' => 'ext.eauth.EAuth',
                'popup' => false, // Use the popup window instead of redirecting.
                'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache'.
                'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
                'services' => $eauthServices,
            ),
        ),
    )
);

require($frontendConfigDir . '/main-env.php');

require($frontendConfigDir . '/main-local.php');

return $config;