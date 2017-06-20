<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\Students;
use common\models\Subjects;
use common\models\Classes;


class SubjectsController extends ActiveController
{

	public $subjlogo_uploadpath = 'uploads/images/subjlogos/';
	public $modelClass = 'common\models\Subjects';

	/*public function actionStudentLogin()
	{
		if (!empty($_POST)) {
			try {
			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}
		}
		else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}*/



	public function actionGetStudentClassSubjects()
	{

		if (!empty($_POST)) {
			try {
				//$studentid = $_POST['studentid'];
				$classid = $_POST['classid'];
				$models = Subjects::findAll(['classid'=>$classid]);
				$data=[];
				//for ($i=0; $i < count($models) ; $i++) { 
				foreach ($models as $model) {
						$d = [];
					foreach ($model as $key => $value) {
						if($key == 'image')
							$d[$key] = Yii::$app->urlManagerBackend->baseUrl.'/'.$this->subjlogo_uploadpath.$value;
						else
							$d[$key] = $value;
					}
					$data[] = $d;
				}
				/*echo "<pre>";
				print_r($data);
				exit;*/

				
				return ['result' =>'success', 'data' => $data];

			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}
    	}
    	else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}
	/*public function actionGetStudentClassSubjects()
	{
		if (!empty($_POST)) {
    		
	        try {
				//$studentid = $_POST['studentid'];
				$classid = $_POST['classid'];
				$model = new $this->modelClass;
				$query = $model->find();
				$query->where('classid=:id', [":id"=>$classid]);
				$provider = new ActiveDataProvider([
				    'query' => $query,
				    'sort' => [
				        'defaultOrder' => [
				            'title'=> SORT_ASC
				        ]
				    ],
				    'pagination' => [
				    	'defaultPageSize' => 10,
					],
				]);


				if ($provider->getCount() <= 0) {
					return ['result' =>'fail', 'reason' => "No entries found"];
					//throw new \yii\web\HttpException(404, 'No entries found with this query string');
				} else {
					
					return ['result' =>'success', 'data' => $provider->getModels()];
				}

				
			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}
    	}
    	else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}*/
}
?>