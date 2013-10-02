<?php

$consoleConfigDir = dirname(__FILE__);
$root = $consoleConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
$commonFile = $root . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php';
$config = require($commonFile);

$config = CMap::mergeArray(
    $config,
    array(
        // @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
        'basePath' => 'console',
        // preload components required before running applications
        // @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
        'preload' => array('log'),

        // setup import paths aliases
        // @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
        'import' => array(
            'application.components.*',
            'application.models.*',
            /* uncomment to use frontend models */
            /*'root.frontend.models.*',*/
            /* uncomment to use frontend components */
            /*'root.frontend.components.*',*/
            /* uncomment to use backend components */
            /*'root.backend.components.*',*/
        ),
        /* locate migrations folder if necessary */
        'commandMap' => array(
            'migrate' => array(
                'class' => 'system.cli.commands.MigrateCommand',
                /* change if required */
                'migrationPath' => 'root.console.migrations'
            )
        ),
        'components' => array(
            'log' => array(
                'class' => 'CLogRouter',
                'routes' => array(
                    'main' => array(
                        'class' => 'CFileLogRoute',
                        'levels' => 'error, warning',
                        'filter' => 'CLogFilter'
                    )
                )
            ),
            /* uncomment and configure to suit your needs */
            /*
             'request' => array(
                'hostInfo' => 'http://localhost',
                'baseUrl' => '/bp'
            ),
            */
        ),
    )
);

require($consoleConfigDir . DIRECTORY_SEPARATOR . 'main-env.php');

require($consoleConfigDir . DIRECTORY_SEPARATOR . 'main-local.php');

return $config;