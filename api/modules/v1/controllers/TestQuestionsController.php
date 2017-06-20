<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\TblTest;
use common\models\TestQuestions;


class TestQuestionsController extends ActiveController
{
	public $modelClass = 'common\models\TestQuestions';

	public function actionGetTestQuestions()
	{
		if (!empty($_POST)) {
			try {

				$testid = $_POST['testid'];
				
				//$models = TestQuestions::findAll(['testid'=>$testid]);
				$models = TestQuestions::find()->where(['testid'=>$testid])->orderBy(['rand()' => SORT_ASC])->limit(10)->all();
				
				if($models)
				{
					return ['result'=>'success','data'=>$models];
				}
				else
					return ['result'=>'fail','reason'=> 'no test questions found'];

			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}
		}
		else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}
}
?>