<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

/**
 * Feedback Controller API
 */
class FeedbacksController extends ActiveController
{
    //public $modelClass = 'api\modules\v1\models\Country';
    public $modelClass = 'common\models\Feedback';
}