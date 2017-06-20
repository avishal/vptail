<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\Students;
use common\models\Subjects;
use common\models\Classes;
use common\models\Videos;
use common\models\SubscriptionPlans;
use common\models\SubscriptionVideos;
use common\models\StudentSubscription;


class SubscriptionPlansController extends ActiveController
{
	public $modelClass = 'common\models\SubscriptionPlans';

	public function actionClassSubscriptions()
	{
		if (!empty($_POST)) {
			$classid = $_POST['classid'];
			$subscrptionModel = SubscriptionPlans::find()->all();
			$data=[];
			foreach ($subscrptionModel as $model) {

				$d=[];
				if($model->subscriptionCourses[0]->classid == $classid)
				{
					foreach ($model as $key => $value) {
						$d[$key] =$value;
					}
					//$d['subscriptionCourses'] = $model->subscriptionCourses;

					//$d['classid'] = $model->subscriptionCourses[0]->classid;
					$data[] = $d;
				}
			}

			return ['result' =>'success', 'data' => $data];
		}
		else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}
}