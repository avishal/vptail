<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

/**
 * Suggestions Controller API
 */
class PaperCuttingsController extends ActiveController
{
    //public $modelClass = 'api\modules\v1\models\Country';
    public $modelClass = 'common\models\PaperCuttings';
}