<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\TblTest;
use common\models\SubjectChapter;
use common\models\StudentTests;


class TestsController extends ActiveController
{
	public $modelClass = 'common\models\TblTest';

	public function actionGetChaptersTest()
	{
		if (!empty($_POST)) {
			try {

				$chapterid = $_POST['chapterid'];
				$studentid = $_POST['studentid'];
				
				$models = TblTest::findAll(['chapterid'=>$chapterid]);
				//echo "<pre>"; print_r($model);exit;
				if($models)
				{
					$data = [];
					foreach ($models as $model) {
						$d = [];
						foreach ($model as $key => $value) {
							$d[$key] = $value;
						}
						$studenttestmodel = StudentTests::findOne(['testid'=>$model->id, 'studentid'=>$studentid]);
						if($studenttestmodel)
							$d["testappeared"] = true;
						else
							$d["testappeared"] = false;

						$data[] = $d;

					}
					return ['result'=>'success','data'=>$data];
				}
				else
					return ['result'=>'fail','reason'=> 'no test found for the chapter'];

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