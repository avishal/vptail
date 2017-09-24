<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\Students;
use common\models\SmsCodes;


class StudentsController extends ActiveController
{

	public $modelClass = 'common\models\Students';

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

				$mobile = $_POST['mobile'];
				$password = $_POST['password'];
				
				$model = Students::findOne(['mobile'=>$mobile,'password' => md5($password)]);
				//echo "<pre>"; print_r($model);exit;
				if($model)
				{
					//$data = $model;
					foreach ($model as $key => $value) {
						$data[$key] = $value;
					}
					$data['classname'] = $model->class->title;

					return ['result'=>'success','data'=>$data];
					/*
					//uncomment if you want to users to login to only verified phone numbers 

					if($model->phoneverified=='yes')
						return ['result'=>'success','data'=>$model];
					else
						return ['result'=>'fail','reason'=>'Please verify your mobileno'];
					*/
				}
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
				$country_code = "IN";
				if(isset($_POST['country_code']))
					$country_code = $_POST['country_code'];
				$modelEmail = Students::findOne(['email' => $email]);
				if(!$modelEmail)
				{
					$modelPhone = Students::findOne(['mobile' => $mobileno]);
					if(!$modelPhone)
					{
						$password = $_POST['password'];
						$course = $_POST['course'];

						$fullname = $_POST['firstname'];
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
						$studentModel->classid = $course;

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
							//echo "<pre>"; print_r($studentModel); exit;
							// json_decode($smsresp); // can be used for logging sms
							return ['result' =>'success', 'smsresp'=>json_decode($smsresp), 'studentdata' => $studentModel,'subjData'=>$studentModel->class,'smsdata' => $smsmodel];
						}
						else
						{
							return ['result' =>'fail', 'reason_student' => $studentModel->getErrors(), 'reason_sms' => $smsmodel->getErrors()];
						}
					}
					else
					{
						if($modelPhone->phoneverified == 'no')
						{
							$smsmodel = new SmsCodes();
							$smsmodel->mobileno = $mobileno;
							$smsmodel->country_code = $country_code;
							$smsmodel->code = Yii::$app->smsgateway->generateOTP();
							
							if ($smsmodel->save())
							{	
								$smsresp="";
								$smsresp = Yii::$app->smsgateway->sendSMS($modelPhone->mobile, "Your elearn otp is ".$smsmodel->code);
								// json_decode($smsresp); // can be used for logging sms
								return ['result' =>'success', 'smsresp'=>json_decode($smsresp), 'studentdata' => $modelPhone,'subjData'=>$modelPhone->class,'smsdata' => $smsmodel];
							}
							else
							{
								return ['result' =>'fail', 'reason_student' => $modelPhone->getErrors(), 'reason_sms' => $smsmodel->getErrors()];
							}
						}
						else
						{

							return ['result' =>'fail', 'reason' => "Mobile number already registered"];
						}
					}
				}
				else
				{
					$modelPhone = Students::findOne(['mobile' => $mobileno]);
					if($modelPhone && $modelPhone->phoneverified == 'no')
					{
						$smsmodel = new SmsCodes();
						$smsmodel->mobileno = $mobileno;
						$smsmodel->country_code = $country_code;
						$smsmodel->code = Yii::$app->smsgateway->generateOTP();
						
						if ($smsmodel->save())
						{
							$smsresp="";
							$smsresp = Yii::$app->smsgateway->sendSMS($modelPhone->mobile, "Your elearn otp is ".$smsmodel->code);
							
							return ['result' =>'success', 'smsresp'=>json_decode($smsresp), 'studentdata' => $modelPhone,'subjData'=>$modelPhone->class,'smsdata' => $smsmodel];
						}
						else
						{
							return ['result' =>'fail', 'reason_student' => $modelPhone->getErrors(), 'reason_sms' => $smsmodel->getErrors()];
						}
					}
					else
					{
						return ['result' =>'fail', 'reason' => "Email already registered"];
					}
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

	public function actionSetPassword(){
		if (!empty($_POST)) {
    		/*$model = new $this->modelClass;
	        foreach ($_POST as $key => $value) {
	            if (!$model->hasAttribute($key)) {
	                throw new \yii\web\HttpException(404, 'Invalid attribute:' . $key);
	            }
	        }*/
	        try {

				$id = $_POST['id'];
				$password = $_POST['password'];
				$model = Students::findOne($id);
				if($model)
				{
					$model->password = md5($password);
					if($model->update())
					{
						return ['result' =>'success'];
					}
					else
					{
						return ['result' =>'fail'];
					}
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


	public function actionUpdatePassword(){
		if (!empty($_POST)) {
	        try {

				$id = $_POST['id'];
				$oldpassword = $_POST['oldpassword'];
				$password = $_POST['password'];
				$model = Students::findOne($id);
				if($model && $model->password == md5($oldpassword))
				{
					$model->password = md5($password);
					if($model->update())
					{
						return ['result' =>'success'];
					}
					else
					{
						return ['result' =>'fail'];
					}
				}
				else
					{
						return ['result' =>'fail'];
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

	public function actionUpdateStudent()
	{
		if (!empty($_POST)) {
	        try {
        		$id = $_POST['studentid'];
        		$fullname = $_POST['firstname'];
				$gender = $_POST['gender'];
				$dob = $_POST['dob'];
				$city = $_POST['city'];
				$course = $_POST['classid'];

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

				$studentModel = Students::findOne($id);
				if($firstname !="")
					$studentModel->firstname = ucfirst(trim($firstname));
				if($middlename !="")
					$studentModel->middlename = ucfirst(trim($middlename));
				if($lastname !="")
					$studentModel->lastname = ucfirst(trim($lastname));
				//$studentModel->email = $email;
				//$studentModel->mobile = $mobileno;
				$studentModel->gender = $gender;
				$studentModel->classid = $course;
				$studentModel->city = ucfirst(trim($city));

				$studentModel->dateofbirth = date("Y-m-d",strtotime($dob));
				if($studentModel->beforeSave(false) && $studentModel->save())
				{
					// echo "<pre>"; print_r($studentModel);exit;
					return ['result'=>'success','data'=>$studentModel];
				}
				else
				{
					return ['result'=>'fail','reason'=> 'unable to save profile', 'techreason'=>$studentModel->getErrors()];
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

	public function actionGetStudentById()
	{
		if (!empty($_POST)) {
			try {

				$id = $_POST['id'];
				
				$model = Students::findOne(['id'=>$id]);
				//echo "<pre>"; print_r($model);exit;
				if($model)
				{
					//$data = $model;
					foreach ($model as $key => $value) {
						$data[$key] = $value;
					}
					$data['classname'] = $model->class->title;

					return ['result'=>'success','data'=>$data];
				}
				else
					return ['result'=>'fail','reason'=> 'invalid username'];

			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}
		}
		else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}

	public function actionUpdateStudentById()
	{
		if (!empty($_POST)) {
			try {

				$id = $_POST['id'];
				$mobileno = $_POST['mobileno'];
				$gender = $_POST['gender'];
				$city = $_POST['city'];
				$dob = $_POST['dob'];
				
				$fullname = $_POST['name'];
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

				$studentModel = Students::findOne(['id'=>$id]);
				//echo "<pre>"; print_r($studentModel);exit;
				if($studentModel)
				{
					$studentModel->firstname = ucfirst(trim($firstname));
					$studentModel->middlename = ucfirst(trim($middlename));
					$studentModel->lastname = ucfirst(trim($lastname));
					$studentModel->mobile = $mobileno;
					$studentModel->gender = $gender;
					$studentModel->city = $city;
					//$originalDate = "2010-03-21";

					$newDate = date("d-M-Y", strtotime($dob));
					$studentModel->dateofbirth = $newDate->format("Y-m-d");


					if ($studentModel->beforeSave(false) && $studentModel->save())
					{	
						return ['result'=>'success','data'=>$data];
					}
					else
					{
						return ['result'=>'fail','reason'=> 'unable to update', 'techreas'=>$studentModel->getErrors()];
					}
				}
				else
					return ['result'=>'fail','reason'=> 'invalid student'];

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