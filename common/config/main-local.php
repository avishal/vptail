<?php
return [
    'components' => [
        'smsgateway' => [
            'class' => 'common\components\helpers\SmsHelper',
            'authkey' => '5aed8020cbb65d241eefc2bf355f223',
        ],
        'fcmgateway' => [
            'class' => 'common\components\helpers\FirebaseHelper',
            //'authkey' => 'AIzaSyCdYy2MCx0wmQI78jUtnSZehZQTumGiUjU',
            'authkey' => 'AAAAJHw-LAs:APA91bGGNFJ7okolC4wR4mo-v8n4gee-6I80RDVb6IIPIdT0hdb6fW6J4tFpnBNSgR81A1eC7soVq7O83wKHeNygeBDgPLZ7KpJ7gxxqPCgWh7LzSu5HzPcMC1u0lTGl21MlgZTw4IJM_7yURi56Xr5ggpHD-AN3-A',
        ],

        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=tailor',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],

        // Live DB Details

        /*'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=vptech_elearn',
            'username' => 'vpyoga',
            'password' => '^4)M}]nesQPp',
            'charset' => 'utf8',
        ],*/

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        /*'view' => [
         'theme' => [
             'pathMap' => [
                '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-red',
                ],
            ],
        ],*/
    ],
];
