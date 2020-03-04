<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => array(
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
        'sftp' => [
            "class" => 'Apolon\sftp\SFtpManager',
                "settings" => [
                    'port'=> 22,
                    'timeout'=> 120,
                ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'esthdfYRUGJHFYN1346455235YMNHTBGRVFEDtehnrfgdbsv567463562!!!!',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'name' => 'TOONY_MAKES_THESE_THINGS_UP_LOL',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => '',
                'password' => '',
                'port' => '587',
                'encryption' => 'tls',
                'streamOptions' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'modules' => [
        'customer' => [
            'class' => 'app\modules\customer\Module',
            'defaultRoute' => 'dashboard'
        ],
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'config' => [
            'class' => 'app\modules\config\Module',
        ],
        'door' => [
            'class' => 'app\modules\door\Module',
        ],
        'reports' => [
            'class' => 'app\modules\reports\Module',
            'defaultRoute' => 'dashboard'
        ],
        'marketing' => [
            'class' => 'app\modules\marketing\Module',
        ],
    ],
    'params' => $params,
    'timeZone' => 'Europe/London',
];

if ($params['environment'] == "dev") {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
