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
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/fcm-devices',
                    'extraPatterns' => [
                        'POST register-device' => 'create-new-device-registration', 
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/tests',
                    'extraPatterns' => [
                        'POST get-chapters-test' => 'get-chapters-test', 
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/student-tests',
                    /*'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],*/
                    'extraPatterns' => [
                        'POST add-student-test' => 'save-test-results', 
                        'POST get-student-test-analysis' => 'get-test-results-analysis',
                        'POST get-student-test-result' => 'test-results', 
                    ]
                ],[
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/test-questions',
                    /*'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],*/
                    'extraPatterns' => [
                        'POST get-questions' => 'get-test-questions',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/student-subscriptions',
                    /*'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],*/
                    'extraPatterns' => [
                        'POST add-new-stud-sub' => 'create-new-student-subscription', 
                        'POST payu-hash' => 'payu-hash', 
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/classes',
                    /*'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],*/
                    'extraPatterns' => [
                        'GET get-all-classes' => '', 
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/subscription-plans',
                    /*'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],*/
                    'extraPatterns' => [
                        'POST class-subscriptions'=>'class-subscriptions'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/sms-codes',
                    /*'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],*/
                    'extraPatterns' => [
                        'GET get-code' => 'get-student-code', 
                        'POST add-new-mobile' => 'add-new-mobile', 
                        'POST verify' => 'verify-code', 
                        
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/videos',
                    /*'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],*/
                    'extraPatterns' => [
                        'POST get-chapter-videos' => 'get-chapter-videos', 
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/subject-chapters',
                    /*'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],*/
                    'extraPatterns' => [
                        'POST get-subjects' => 'get-course-subjects', 
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/students',
                    'extraPatterns' => [
                        'POST student-registration' => 'student-registration', 
                        'POST student-login' => 'login', 
                        'POST forgot-password' => 'forgot-password', 
                        'POST new-password' => 'set-password', 
                        'POST get-student' => 'get-student-by-id', 
                        'POST update-student-profile' => 'update-student', 
                        'POST update-student-password' => 'update-password', 
                    ]
                    
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/subjects',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'POST get-student-class-subjects' => 'get-student-class-subjects',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/p-is',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/links',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/complaints',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'POST addcomp' => 'addcomplaint',
                        'POST create-new' => 'create-new',
                    ]
                    
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/suggestions',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'POST create-new' => 'create-new',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/feedbacks',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/dev-works',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET latest' => 'getlatestnews',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/constituencies',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/messages',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET latest' => 'getlatestmessages',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/paper-cuttings',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/img-gals',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET images' => 'getimages',
                    ]
                ],
            ],
        ]
    ],
    'params' => $params,
];