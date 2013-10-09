<?php
$commonConfigDir = dirname(__FILE__);
$root = realpath($commonConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');

define('TMP_PATH','/tmp');
define('PIX_PATH',$root . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'www' . DIRECTORY_SEPARATOR . 'pix');
define('VIDEO_PATH',$root . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'www' . DIRECTORY_SEPARATOR . 'video');

define('PIX_URI','/pix');
define('VIDEO_URI','/video');


$config = array(

    'import' => array(
        'common.components.interfaces.*',
        'application.controllers.*',
        'application.models.*',
        'application.models._base.*',
        'application.models.enum.*',
        'ext.mail.YiiMailMessage',
        'ext.jquery-gmap.*',
        'ext.image.*',
        'ext.jcrop.*',
        'application.modules.user.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.user.controllers.*',
        'application.modules.rights.*',
        'application.modules.rights.models.*',
        'application.modules.rights.components.*',
        'application.modules.rights.controllers.*',
        'ext.jwplayer.*',
        'ext.ffmpeg-php.*',
        'ext.ffmpeg-php.adapter.*',
        'ext.ffmpeg-php.provider.*',
    ),
    'modules'=>array(
        'user'=>array(
            'tableUsers' => 'user',
            # encrypting method (php hash function)
            'hash' => 'md5',

            # send activation email
            'sendActivationMail' => true,

            # allow access for non-activated users
            'loginNotActiv' => false,

            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,

            # automatically login from registration
            'autoLogin' => true,

            # registration path
            'registrationUrl' => '/user/registration',

            # recovery password path
            'recoveryUrl' => '/user/recovery',

            # login form path
            'loginUrl' => '/user/login',

            # page after login
            'returnUrl' => '/user/profile',

            # page after logout
            'returnLogoutUrl' => '/user/login',
        ),
        'rights'=>array(
            'appLayout' => '//main',
//            'install'=>true,
        ),
    ),
    'components' => array(
        'user'=>array(
            'class'=>'RWebUser',
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
            'loginUrl' => '/user/login',
        ),
        'authManager'=>array(
            'class'=>'RDbAuthManager',
            'defaultRoles' => array('Guest')
        ),
        'db' => array(
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
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=> array(
                array(
                    'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters'=>array('127.0.0.1'),
                ),
                //array(
                //   'class'=>'CWebLogRoute',
                //   'levels'=>'info',
                //   'showInFireBug'=>true,
                //),
            ),
        ),
        'file'=>array(
            'class'=>'application.extensions.file.CFile',
        ),
        'mail' => array(
            'class' => 'ext.mail.YiiMail',
            'transportType' => 'php',
            /*
                        'transportType' => 'smtp',
                        'transportOptions' => array(
                            'host' => 'smtp.gmail.com',
                            'username' => 'xxx@gmail.com',
                            'password' => 'xxx',
                            'port' => '465',
                            'encryption'=>'tls',
                        ),
            */
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false
        ),
        'curl' =>array(
            'class' => 'ext.Curl',
            'options'=>array(
                CURLOPT_TIMEOUT => 90,
            ),
        ),
        'image'=>array(
            'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            //'params'=>array('directory'=>'D:/Program Files/ImageMagick-6.4.8-Q16'),
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