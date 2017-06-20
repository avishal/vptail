<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\Students;
use common\models\SmsCodes;
use common\models\SubjectChapters;
use common\models\TblTest;
use common\models\Videos;


class SubjectChaptersController extends ActiveController
{

	public $modelClass = 'common\models\SubjectChapters';

	/*public function actionGetCourseSubjects()
	{
		if (!empty($_POST)) {
			try {
				$subjid = $_POST['subjectid'];
				$query = SubjectChapters::find();
				$query->where(['=','subjid', $subjid]);

				$provider = new ActiveDataProvider([
				    'query' => $query,
				    'sort' => [
				        'defaultOrder' => [
				            'id'=> SORT_ASC
				        ]
				    ],
				    'pagination' => [
				    	'defaultPageSize' => 50,
					],
				]);

				$testquery = TblTest::find();
				$testquery->where(['=','subjid', $subjid]);

				$providertest = new ActiveDataProvider([
				    'query' => $testquery,
				]);

				$videoquery = Videos::find();
				$videoquery->where(['=','subjid', $subjid]);

				$providervid = new ActiveDataProvider([
				    'query' => $videoquery,
				]);

				if ($provider->getCount() <= 0) {
					return ['result' =>'fail', 'reason' => "No chapters found"];
					//throw new \yii\web\HttpException(404, 'No entries found with this query string');
				} else {
					return ['result' =>'success', 'data' => $provider->getModels(),'testcount'=>$providertest->getCount(),'videocount'=>$providervid->getCount()];
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

	public function actionGetCourseSubjects()
	{
		if (!empty($_POST)) {
			try {
				$subjid = $_POST['subjectid'];
				$scmodels = SubjectChapters::find()->where(['subjid'=>$subjid])->all();
				$data = [];
				if($scmodels)
				{
					
					foreach ($scmodels as $model) {
						$d = [];
						$videoquery = Videos::find()->where(['chapterid'=>$model->id])->one();
						//print_r($videoquery);exit;
						$hasvideos = false;
						if($videoquery)
							$hasvideos = true;

						$testquery = TblTest::find()->where(['chapterid'=>$model->id])->one();
						$hastests = false;
						if($testquery)
							$hastests = true;

						$d['hasvideos'] = $hasvideos;
						$d['hastests'] = $hastests;
						foreach ($model as $key => $value) {
							$d[$key] = $value;
						}
						$data[] = $d;
					}
				}

				// $provider = new ActiveDataProvider([
				//     'query' => $query,
				//     'sort' => [
				//         'defaultOrder' => [
				//             'id'=> SORT_ASC
				//         ]
				//     ],
				//     'pagination' => [
				//     	'defaultPageSize' => 50,
				// 	],
				// ]);

				$testquery = TblTest::find();
				$testquery->where(['=','subjid', $subjid]);

				$providertest = new ActiveDataProvider([
				    'query' => $testquery,
				]);

				$videoquery = Videos::find();
				$videoquery->where(['=','subjid', $subjid]);

				$providervid = new ActiveDataProvider([
				    'query' => $videoquery,
				]);

				if (count($data) <= 0) {
					return ['result' =>'fail', 'reason' => "No chapters found"];
				} else {
					return ['result' =>'success', 'data' => $data,'testcount'=>$providertest->getTotalCount(),'videocount'=>$providervid->getTotalCount()];
				}
			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}
		}
		else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}


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

	public function actionLogin()
	{
		if (!empty($_POST)) {
			try {

				$mobile = $_POST['username'];
				$password = $_POST['password'];

				$model = Students::find()->where(['mobile'=>$mobile,'password' => md5($password)])->one();

				if($model)
					return ['result'=>'success','data'=>$model];
				else
					return ['result'=>'fail','data'=>$model,'reason'=> 'invalid username or password'];

			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}
		}
		else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}

	public function actionStudentRegistration()
	{
		if (!empty($_POST)) {
    		/*$model = new $this->modelClass;
	        foreach ($_POST as $key => $value) {
	            if (!$model->hasAttribute($key)) {
	                throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
	            }
	        }*/
	        try {

				$email = $_POST['email'];
				$mobileno = $_POST['mobile'];
				$modelEmail = Students::find()->where(['email' => $email])->one();
				if(!$modelEmail)
				{
					$modelPhone = Students::findOne(['mobile' => $mobileno]);
					if(!$modelPhone)
					{
						$fullname = $_POST['firstname'];
						$password = $_POST['password'];
						$country_code = "IN";
						if(isset($_POST['country_code']))
							$country_code = $_POST['country_code'];

						$fullnamearray = explode(" ", $fullname);

						$firstname="";
						$middlename="";
						$lastname="";
						if(count($fullnamearray) == 3 || count($fullnamearray) > 3 )
						{
							$firstname = $fullnamearray[0];
							$middlename = $fullnamearray[1];
							$lastname = $fullnamearray[2];
						}
						else if(count($fullnamearray) == 2)
						{
							$firstname = $fullnamearray[0];
							$lastname = $fullnamearray[1];
						}
						else if(count($fullnamearray) == 1)
						{
							$firstname = $fullnamearray[0];
						}

						$studentModel = new Students();
						$studentModel->firstname = ucfirst(trim($firstname));
						$studentModel->middlename = ucfirst(trim($middlename));
						$studentModel->lastname = ucfirst(trim($lastname));
						$studentModel->email = $email;
						$studentModel->mobile = $mobileno;
						//$studentModel->city = ucfirst(trim($city));
						$studentModel->password = md5(trim($password));

						$course = "";
						if(isset($_POST['course']))
							$course = $_POST['course'];

						$smsmodel = new SmsCodes();
						$smsmodel->mobileno = $mobileno;
						$smsmodel->country_code = $country_code;
						$smsmodel->code = Yii::$app->smsgateway->generateOTP();
						
						if ($smsmodel->save() && $studentModel->save())
						{	
							$smsresp="";
							$smsresp = Yii::$app->smsgateway->sendSMS($studentModel->mobile, "Your elearn otp is ".$smsmodel->code);
							// json_decode($smsresp); // can be used for logging sms
							return ['result' =>'success', 'smsresp'=>json_decode($smsresp), 'studentdata' => $studentModel,'smsdata' => $smsmodel];
						}
						else
						{
							return ['result' =>'fail', 'reason_student' => $studentModel->getErrors(), 'reason_sms' => $smsmodel->getErrors()];
						}
					}
					else
					{
						return ['result' =>'fail', 'reason' => "Mobile number already registered"];
					}
				}
				else
				{
					return ['result' =>'fail', 'reason' => "Email already registered"];
				}
			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}

			/*if (!$smsmodel) {
				throw new \yii\web\HttpException(404, 'No entries found');
			} else {
				$smsmodel->status = 1;
				$smsmodel->update();
				return $smsmodel;
			}*/
    	}
    	else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}

	public function actionForgotPassword(){
		if (!empty($_POST)) {
	        try {
				$mobileno = $_POST['mobile'];
				$country_code = "IN";
				if(isset($_POST['country_code']))
					$country_code = $_POST['country_code'];
				$modelPhone = Students::findOne(['mobile' => $mobileno]);
				if($modelPhone)
				{
					$smsmodel = new SmsCodes();
					$smsmodel->mobileno = $mobileno;
					$smsmodel->country_code = $country_code;
					$smsmodel->code = Yii::$app->smsgateway->generateOTP();
					
					if ($smsmodel->save())
					{	
						$smsresp="";
						$smsresp = Yii::$app->smsgateway->sendSMS($mobileno, "Your elearn otp is ".$smsmodel->code);
						return ['result' =>'success', 'smsresp'=>json_decode($smsresp),'smsdata' => $smsmodel];
					}
					else
					{
						return ['result' =>'fail', 'reason_sms' => $smsmodel->getErrors()];
					}
				}
				else
				{
					return ['result' =>'fail', 'reason' => "Mobile number not registered"];
				}
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