<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'smsgateway' => [
            'class' => 'common\components\helpers\SmsHelper',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'urlManagerFrontend' => [
                'class' => 'yii\web\urlManager',
                'baseUrl' => 'http://192.168.0.100/elearn/frontend/web/',
                //'baseUrl' => 'http://www.vpacetech.com/elearn/frontend/web/',
                'enablePrettyUrl' => false,
                'showScriptName' => true,
        ],
        'urlManagerBackend' => [
                'class' => 'yii\web\urlManager',
                'baseUrl' => 'http://192.168.0.100/elearn/backend/web/',
                //'baseUrl' => 'http://www.vpacetech.com/elearn/backend/web/',
                'enablePrettyUrl' => true,
                'showScriptName' => false,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/tailor-users',
                    'extraPatterns' => [
                        'POST registration' => 'registration', 
                        'POST forgot-password' => 'forgot-password', 
                        'POST login' => 'login', 
                        'POST get-order-by-order-id' => 'get-order-by-order-id', 
                        'POST get-orders-by-customer-id' => 'get-orders-by-customer-id', 
                        'POST get-orders-by-tailor-id' => 'get-orders-by-tailor-id', 
                        'POST delete-customer' => 'delete-customer', 
                        'POST delete-worker' => 'delete-worker', 
                        'POST update-tailor' => 'update-tailor', 
                        'POST forgot-password' => 'forgot-password', 
                        'POST change-password' => 'update-password', 
                        'POST get-tailor-details' => 'get-user-by-id', 
                        'POST update-measurement-unit' => 'update-measurement-unit', 
                        'POST worker-customers' => 'worker-customers', 
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/customers',
                    'extraPatterns' => [
                        'POST registration' => 'registration', 
                        'POST forgot-password' => 'forgot-password', 
                        'POST login' => 'login', 
                        'POST search' => 'search-customers', 
                        'POST get-my-customers' => 'get-tailor-customers', 
                        'POST get-customer-measurement' => 'get-customer-measurements',
                        'POST save-measurement' => 'save-customer-measurements',
                        'POST get-customer' => 'get-user-by-id',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/workers',
                    'extraPatterns' => [
                        'POST registration' => 'registration', 
                        'POST forgot-password' => 'forgot-password', 
                        'POST login' => 'login', 
                        'POST search' => 'search-customers', 
                        'POST get-my-worker' => 'get-tailor-workers', 
                        'POST get-worker-measurement' => 'get-worker-measurements',
                        'POST save-measurement' => 'save-worker-measurements',
                        'POST get-worker' => 'get-user-by-id',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/orders',
                    'extraPatterns' => [
                        'POST save-order' => 'new-order', 
                        'POST update-order' => 'update-order-status', 
                        'POST all-orders' => 'all-orders', 
                        'POST get-order-by-id' => 'get-order-by-id', 
                    ]
                ],
            ],
        ]
    ],
    'params' => $params,
];