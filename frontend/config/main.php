<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'v1' => [
            'class' => 'frontend\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'response' => [
            'format' => 'json',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            //'enableAutoLogin' => true,
            //'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'jwt' => [
            'class' => sizeg\jwt\Jwt::class,
            'key' => 'WstB1tR23$s#ya%snYT',
            //'jwtValidationData' => sizeg\jwt\JwtValidationData::class,
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',  // 使用redis存储前端缓存
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
            'class' => 'yii\redis\Session'   // 使用redis存储前端会话
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'as authenticator' => [
        'class' => sizeg\jwt\JwtHttpBearerAuth::class,
        'optional' => [// 排除不需要验证
            'v1/jwt/login',
            'gii/*',
            'debug/*'
        ]
    ],
    'params' => $params,
];
