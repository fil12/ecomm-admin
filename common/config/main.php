<?php

use backend\components\AuthDbManager;


return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'dbConnection' => 'db1',
            'enableRegistration' => false,
            'enablePasswordRecovery' => false,
            'admins' => ['admin'],
            'controllerMap' => [
                'security' => [
                    'class' => dektrium\user\controllers\SecurityController::class,
                    'on '.dektrium\user\controllers\SecurityController::EVENT_AFTER_LOGIN  => function ($e) {

                        Yii::$app->response->redirect(array('/'))->send();
                        Yii::$app->end();
                    }
                ],
            ],
        ],
        'rbac' => [
            'class'=>'dektrium\rbac\RbacWebModule',
            'admins' => ['admin'],
        ],
        'categories' => [
            'class' => 'app\modules\Categories\module',
        ],
        'products' => [
            'class' => 'app\modules\Products\module',
        ],
    ],

    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<action:(login|logout)>' => 'user/security/<action>',
            ],
        ],
        'authManager' => [
            'class' => AuthDbManager::class,
            'db' => 'db1'
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy, HH:mm',
            'timeFormat' => 'HH:mm',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
