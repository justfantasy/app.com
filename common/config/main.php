<?php

return [
    'timeZone' => 'PRC',
    'bootstrap' => [
        'queue'
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:4*',
                    ],
                ],
            ],
        ],
        'queue' => [
            'class' => yii\queue\redis\Queue::class,
            'channel' => 'queue'
        ],
        'wechat' => [
            'class' => 'common\components\WechatComponent',
        ],
    ],
];
