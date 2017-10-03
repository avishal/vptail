<?php

namespace api\modules\v1\controllers;

use Yii;
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

	public function actionGetAllClasses()
	{

		try {
			$models = Classes::find()->where(['status'=>10])->all();
			$data=[];
			foreach ($models as $model) {
					$d = [];
				foreach ($model as $key => $value) {
					$d[$key] = $value;
				}
				$data[] = $d;
			}
			return ['result' =>'success', 'data' => $data];

		}
		catch (Exception $ex) {
			throw new \yii\web\HttpException(500, 'Internal server error');
		}
	}

}
?>