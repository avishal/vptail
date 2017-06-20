<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\Students;
use common\models\Subjects;
use common\models\Classes;


class ClassesController extends ActiveController
{

	public $subjlogo_uploadpath = 'uploads/images/classlogos/';
	public $modelClass = 'common\models\Classes';
}
?>