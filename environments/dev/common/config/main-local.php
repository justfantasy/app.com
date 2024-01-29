<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.103.66:6033;dbname=yii2advanceddb',
            'username' => 'root',
            'password' => 'devdbmysql',
            'charset' => 'utf8mb4',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '192.168.103.64',
            'port' => 6379,
            'database' => 0,
        ],
    ],
];
