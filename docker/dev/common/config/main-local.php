<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=db;dbname=dbname',
            'username' => 'dbuser',
            'password' => 'dbuser',
            'charset' => 'utf8',
        ],
    ],
];
?>