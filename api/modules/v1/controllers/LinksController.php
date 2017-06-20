<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

/**
 * Constituency Controller API
 */
class LinksController extends ActiveController
{
    //public $modelClass = 'api\modules\v1\models\Country';
    public $modelClass = 'common\models\Usefullinks';
}