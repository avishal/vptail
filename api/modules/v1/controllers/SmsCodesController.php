<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\SmsCodes;
use common\models\Students;


class SmsCodesController extends ActiveController
{

	public $modelClass = 'common\models\SmsCodes';
    /*public function actionIndex()
    {
        return $this->render('index');
    }*/

    // Add New Mobile function is used to register new user/student.
    // When new user wants to register for the first time he enters phone number and country code. This function will accept both phone number and country code and verifies and sends OTP to the same phone number. 

    public function actionAddNewMobile()
    {
    	if(!empty($_POST))
    	{
    		$model = new $this->modelClass;
	        foreach ($_POST as $key => $value) {
	            if (!$model->hasAttribute($key)) {
	                throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
	            }
	        }
	        try {
	    		if ($_POST['mobile']) {
	    			$model = new SmsCodes();
					$mobileno = $_POST['mobile'];
					$country_code = $_POST['country_code'];
					//$model->mobileno = trim($mobileno);
					//$model->country_code = trim($country_code);
					
					$model->mobileno = $mobileno;
					$model->country_code = $country_code;
					

					$model->code = Yii::$app->smsgateway->generateOTP();
					Yii::$app->smsgateway->sendSMS($model->mobileno, "Your elearn otp is ".$model->code);
					//Yii::$app->smsgateway->sendSMS($model->mobileno, "I'm in office. i forget my phone at home. call on girish mobile 9561074665");

					if ($model->save())
					{	
						return ['result' =>'success', 'data' => $model];
					}
					else
					{
						return ['result' =>'fail', 'reason' => $model->getErrors()];
					}
					
				}
			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}

			/*if ($provider->getCount() <= 0) {
				throw new \yii\web\HttpException(404, 'No entries found with this query string');
			} else {
				return $provider;
			}*/
    	}
    	else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
    }

    // Verify mobile no and code

    public function actionVerifyCode()
    {
    	//echo "<pre>"; print_r($_GET);exit;
    	if (!empty($_POST)) {
    		$model = new $this->modelClass;
	        /*foreach ($_POST as $key => $value) {
	            if (!$model->hasAttribute($key)) {
	                throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
	            }
	        }*/
	        try {

				$mobileno = $_POST['mobile'];
				$country_code = "IN";
				if(isset($_POST['country_code']))
					$country_code = $_POST['country_code'];
				$code = $_POST['code'];

				$model = new SmsCodes();
				$model->mobileno = $mobileno;
				$model->country_code = $country_code;
				$model->code = $code;
				$model->validate();
	        	$smsmodel = SmsCodes::find()->where(['mobileno'=>$model->mobileno,'country_code'=>$model->country_code,'code'=>$model->code,'status'=>0])->one();
			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}

			if (!$smsmodel) {
				//throw new \yii\web\HttpException(404, 'No entries found');
				return ['result'=>"fail",'reason' => 'No enties found'];
			} else {

				$smsmodel->status = 1;
				$smsmodel->update();

				$student = Students::findOne(['mobile' => $mobileno]);

				if($student)
				{
					$student->phoneverified = "yes";
					$student->status = 10;
					$student->update();
					return ['result'=>"success",'studentdata'=>$student,'smsdata'=>$smsmodel];
				}
				else
				{
					return ['result'=>"fail",'student_reason'=>$student->getErrors(),'reason_smsmodel'=>$smsmodel->getErrors()];
				}
			}
    	}
    	else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
    }

    public function actionGetStudentCode()
    {
    	//echo "<pre>"; print_r($_GET);exit;
    	if (!empty($_GET)) {
    		$model = new $this->modelClass;
	        foreach ($_GET as $key => $value) {
	            if (!$model->hasAttribute($key)) {
	                throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
	            }
	        }
	        try {

				$query = $model->find();
				/*foreach ($_GET as $key => $value) {
					if ($key != 'age') {
						$query->andWhere(['like', $key, $value]);
					}
					if ($key == 'age') {
						$agevalue = explode('-',$value);
						$query->andWhere(['between', $key,$agevalue[0],$agevalue[1]]);
					}
				}*/

				if ($_GET['mobileno']) {
					$mobileno = $_GET['mobileno'];
					$query->andWhere(['=', 'mobileno' ,$mobileno]);
					$query->andWhere(['=', 'country_code' ,$mobileno]);
					$query->andWhere(['=', 'code' ,$mobileno]);
				}

				$provider = new ActiveDataProvider([
				    'query' => $query,
				    /*'sort' => [
				        'defaultOrder' => [
				            'updated_by'=> SORT_DESC
				        ]
				    ],
				    'pagination' => [
				    	'defaultPageSize' => 20,
					],*/
				]);
			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}

			if ($provider->getCount() <= 0) {
				throw new \yii\web\HttpException(404, 'No entries found with this query string');
			} else {
				return $provider;
			}
    	}
    	else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
    }
}