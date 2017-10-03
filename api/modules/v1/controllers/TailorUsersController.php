<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\TailorUsers;


class TailorUsersController extends ActiveController
{

	public $modelClass = 'common\models\TailorUsers';

	public function actionLogin()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			try {

				$email = $_POST['email'];
				$password = $_POST['password'];
				
				$model = TailorUsers::findOne(['email'=>$email,'password' => md5($password)]);
				if($model)
				{
					/*foreach ($model as $key => $value) {
						$data[$key] = $value;
					}*/

					return ['result'=>'success','data'=>$model];
				}
				else
					return ['result'=>'fail','reason'=> 'invalid username or password'];

			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}
		}
		else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}

	public function actionRegistration()
	{
			$_POST = json_decode(file_get_contents('php://input'), true);
			// print_r($_POST);exit;
		if (!empty($_POST)) {
    		try {
				$name = $_POST['name'];
				$email = $_POST['email'];
				$mobileno = $_POST['mobile'];
				$passwordplain = $_POST['password'];
				// $country_code = "IN";
				// if(isset($_POST['country_code']))
					// $country_code = $_POST['country_code'];
				$modelEmail = TailorUsers::findOne(['email' => $email]);
				if(!$modelEmail)
				{
					$fullname = $name;
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

					$tailorUserModel = new TailorUsers();
					$tailorUserModel->firstname = ucfirst(trim($firstname));
					$tailorUserModel->lastname = ucfirst(trim($lastname));
					$tailorUserModel->email = $email;
					$tailorUserModel->mobile = $mobileno;
					$tailorUserModel->password = md5(trim($passwordplain));
					$tailorUserModel->status = 10;
					$tailorUserModel->shop_name = "NA";
					$tailorUserModel->created = $tailorUserModel->updated= time();

					if ($tailorUserModel->save())
					{	
						return ['result' =>'success', 'data' => $tailorUserModel];
					}
					else
					{
						return ['result' =>'fail','reason'=>'Something went wrong' ,'reason_tech' => $tailorUserModel->getErrors()];
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
    	}
    	else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}

	public function actionFromAppRegister()
	{
			$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
    		try {
				$name = $_POST['name'];
				$email = $_POST['email'];
				$mobileno = $_POST['mobile'];
				$passwordplain = $_POST['password'];
				// $country_code = "IN";
				// if(isset($_POST['country_code']))
					// $country_code = $_POST['country_code'];
				$modelEmail = TailorUsers::findOne(['email' => $email]);
				if(!$modelEmail)
				{
					$fullname = $name;
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

					$tailorUserModel = new TailorUsers();
					$tailorUserModel->firstname = ucfirst(trim($firstname));
					$tailorUserModel->lastname = ucfirst(trim($lastname));
					$tailorUserModel->email = $email;
					$tailorUserModel->mobile = $mobileno;
					$tailorUserModel->password = md5(trim($passwordplain));
					$tailorUserModel->status = 10;
					$tailorUserModel->shop_name = "NA";
					$tailorUserModel->created = $tailorUserModel->updated= time();

					if ($tailorUserModel->save())
					{	
						return ['result' =>'success', 'data' => $tailorUserModel];
					}
					else
					{
						return ['result' =>'fail','reason'=>'Something went wrong' ,'reason_tech' => $tailorUserModel->getErrors()];
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
    	}
    	else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}

	public function actionForgotPassword(){
		if (!empty($_POST)) {
	        try {
				$email = $_POST['email'];
				$user = TailorUsers::findOne(['email' => $email]);
				if($user)
				{
					$randomstring = random_int(23999, 8999999);
					$user->password = md5($randomstring);
					if ($user->save())
					{	

						return ['result' =>'success','newpassword'=>$randomstring];
					}
					else
					{
						return ['result' =>'fail','reason'=>"user not found"];
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
				$model = TailorUsers::findOne($id);
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

	public function actionUpdateTailor()
	{
		if (!empty($_POST)) {
	        try {
        		$id = $_POST['id'];
        		$fullname = $_POST['name'];
        		$mobile = $_POST['mobile'];
        		$shop_name = $_POST['shop_name'];
        		$shop_address = $_POST['shop_address'];

				$fullnamearray = explode(" ", $fullname);

				$firstname="";
				$lastname="";
				if(count($fullnamearray) == 2)
				{
					$firstname = $fullnamearray[0];
					$lastname = $fullnamearray[1];
				}
				else if(count($fullnamearray) == 1)
				{
					$firstname = $fullnamearray[0];
				}

				$userModel = TailorUsers::findOne($id);
				if($firstname !="")
					$userModel->firstname = ucfirst(trim($firstname));
				if($lastname !="")
					$userModel->lastname = ucfirst(trim($lastname));
				$userModel->mobile = $mobileno;
				$userModel->shop_name = $shop_name;
				$userModel->shop_address = $shop_address;
				if($userModel->beforeSave(false) && $userModel->save())
				{
					// echo "<pre>"; print_r($userModel);exit;
					return ['result'=>'success','data'=>$userModel];
				}
				else
				{
					return ['result'=>'fail','reason'=> 'unable to save profile', 'techreason'=>$userModel->getErrors()];
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

	public function actionGetUserById()
	{
		if (!empty($_POST)) {
			try {

				$id = $_POST['id'];
				
				$model = TailorUsers::findOne(['id'=>$id]);
				//echo "<pre>"; print_r($model);exit;
				if($model)
				{
					//$data = $model;
					foreach ($model as $key => $value) {
						$data[$key] = $value;
					}

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

	public function actionUpdateUserById()
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