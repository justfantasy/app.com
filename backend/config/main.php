<?php

use yii\web\Response;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'system' => [
            'class' => 'backend\modules\system\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'response' => [
            'format' => Response::FORMAT_JSON,
        ],
        'user' => [
            'identityClass' => 'common\models\admin\AdminUser',
            'enableAutoLogin' => false,
        ],
        'jwt' => [
            'class' => sizeg\jwt\Jwt::class,
            'key' => 'WstOpBBatR23A$s#ya%snYTEdB', // 请在main-local中重载该配置
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
    'params' => $params,
];
