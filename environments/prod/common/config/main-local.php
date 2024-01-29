<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'common\components\log\WechatWorkRobotTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => [], // '_GET', '_POST', '_SERVER' 考虑长度限制，只发送主要报错信息
                    'except' => [
                        'yii\web\HttpException:4*',
                    ],
                    'robotKey' => '735b501f-0614-411a-a01e-b58af4cd0af7',
                ],
            ],
        ],
    ],
];
