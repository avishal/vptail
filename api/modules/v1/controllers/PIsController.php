<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

/**
 * Personal Info Controller API
 */
class PIsController extends ActiveController
{
    //public $modelClass = 'api\modules\v1\models\Country';
    public $modelClass = 'common\models\Personalinfo';
}


