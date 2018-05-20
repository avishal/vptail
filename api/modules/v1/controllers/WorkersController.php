<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\Customers;
use common\models\Worker;
use common\models\TailorCustomers;
use common\models\TailorWorkers;
use common\models\Measurements;


class WorkersController extends ActiveController
{

	public $modelClass = 'common\models\Worker';

	public function actionLogin()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			try {

				$email = $_POST['email'];
				$password = $_POST['password'];
				
				// $model = Worker::find()->where(['email'=>$email,'password' => md5($password),'status'=>Worker::ACTIVE_STATUS])->one();
				$model = Worker::find()->orWhere(['or',['email'=>$email],['mobile'=>$email]])->andWhere(['password' => md5($password),'status'=>Worker::ACTIVE_STATUS])->one();
				// echo "<pre>"; print_r($_POST);exit;
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
		if (!empty($_POST)) {
    		try {
				$tailorid = $_POST['tailorid'];
				$name = $_POST['name'];
				$email = $_POST['email'];
				$mobileno = $_POST['mobile'];
				$address = $_POST['address'];
				$passwordplain = $_POST['password'];
				$model = Worker::findOne(['mobile' => $mobile,'status'=>Worker::ACTIVE_STATUS]);
				if(!$model)
				{
					$fullname = $name;
					$fullnamearray = explode(" ", $fullname);

					$firstname="";
					$middlename="";
					$lastname=".";
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

					$userModel = new Worker();
					$userModel->firstname = ucfirst(trim($firstname));
					$userModel->lastname = ucfirst(trim($lastname));
					$userModel->email = $email;
					$userModel->mobile = $mobileno;
					$userModel->password = md5(trim($passwordplain));
					$userModel->status = 10;
					$userModel->address = ucfirst(trim($address));
					$userModel->created = $userModel->updated= date("Y-m-d H:i:s",time());

					if ($userModel->save())
					{	
						$tailorCustomersModel = new TailorWorkers();
						$tailorCustomersModel->workerid = $userModel->id;
						$tailorCustomersModel->tailorid = $tailorid;
						$tailorCustomersModel->created = $tailorCustomersModel->updated= date("Y-m-d H:i:s",time());
						if($tailorCustomersModel->save())
							return ['result' =>'success', 'data' => $userModel];
						else
							return ['result' =>'fail', 'reason' => "unable to save"];
					}
					else
					{
						return ['result' =>'fail','reason'=>'Something went wrong' ,'reason_tech' => $userModel->getErrors()];
					}
					
				}
				else
				{
					return ['result' =>'fail', 'reason' => "Mobile number already registered"];
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
	
	function random_password( $length = 8 ) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
	    $password = substr( str_shuffle( $chars ), 0, $length );
	    return $password;
	}

    private function sendResetPasswordEmail($email, $newpassword)
	{
        $user = TailorUsers::findOne([
            // 'status' => Users::STATUS_ACTIVE,
            'email' => $email,
        ]);

        
        // echo "<Pre>"; print_r($user);exit;
        if (!$user) {
            return false;
        }
        
        /*if (!Users::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save(false)) {
                return false;
            }
        }*/

        // $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activate', 'token' => $user->password_reset_token]);
        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activate', 'token' => "asdkljasdkljalkdsj"]);

	    $from = Yii::$app->params['supportEmail']; // this is your Email address
	    $to = $email; // this is the sender's Email address

	    $headers = 'MIME-Version: 1.0' . "\ r\n";
	    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\ r\n";
	    $headers .= "From:" . $from;
	    $subject = "Verification Email";

    	$body ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<!-- If you delete this tag, the sky will fall on your head -->
		<meta name="viewport" content="width=device-width" />

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Welcome to Rent Pro</title>
		    
		<link rel="stylesheet" type="text/css" href="http://rentpro.vpacetech.com/frontend/web/css/email.css" />
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">



		</head>
		<body bgcolor="#FFFFFF">

		<!-- HEADER -->
		<table class="head-wrap head" bgcolor="#ffffff" align="center">
		    <tr>
		        <td></td>
		        <td class="header container">
		            <div class="content">
		                <table bgcolor="#ffffff">
		                    <tr>
		                        <td><img alt="Brand" src="http://www.vpacetech.com/tailor/logo.png"></td>
		                    </tr>
		                </table>
		            </div>
		        </td>
		        <td></td>
		    </tr>
		</table><!-- /HEADER -->


		<!-- BODY -->
		<table class="body-wrap" style="margin-top:20px;">
		    <tr>
		        
		        <td class="container" bgcolor="#FFFFFF">
		            <div class="content" >
		            <table>
		                <tr>
		                    <td>
		                        <h4><b>Hello,</b> '.$user->firstname.' '.$user->lastname.'</h4>
		                        <div class="message-box">
		                            <p class="lead">Your Password is reset</p>
		                        </div>
		                        <hr class="style3">
		                        <br/>
		                        <p>Your new password is: '.$newpassword.'</p>
		                        <br/>
		                        <br/>
		                        <p class="gray">Thank you
		                        <br><br>
		                        <Address></p>         
		                    </td>
		                </tr>
		            </table>
		            </div>
		                                    
		        </td>
		        <td></td>
		    </tr>
		</table><!-- /BODY -->

		<!-- FOOTER -->
		<table class="footer-wrap">
		    <tr>
		        <td></td>
		        <td class="container">
		            
		                <!-- content -->
		                <div class="content">
		                <table>
		                <tr>
		                    
		                </tr>
		            </table>
		                </div><!-- /content -->
		                
		        </td>
		        <td></td>
		    </tr>
		</table><!-- /FOOTER -->

		</body>
		</html>';

    	return mail($to,$subject,$body,$headers);
    }


	public function actionForgotPassword(){
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
	        try {
				$email = $_POST['email'];
				$user = Worker::findOne(['mobile' => $email,'status'=>Worker::ACTIVE_STATUS]);
				if($user)
				{
					//$randomstring = random_int(23999, 8999999);
					$randomstring = $this->random_password(8);
					$user->password = md5($randomstring);
					if ($user->save())
					{	
						$this->sendResetPasswordEmail($email, $randomstring );
						return ['result' =>'success','newpassword'=>$randomstring];
					}
					else
					{
						return ['result' =>'fail','reason'=>"something went wrong"];
					}
				}
				else
				{
					return ['result' =>'fail', 'reason' => "user with email not registered"];
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
		$_POST = json_decode(file_get_contents('php://input'), true);
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
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
	        try {
				$id = $_POST['id'];
				$oldpassword = $_POST['oldpassword'];
				$password = $_POST['password'];
				$model = Worker::findOne(['id'=>$id,'status'=>Worker::ACTIVE_STATUS]);
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

	public function actionUpdateWorker()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
	        try {
        		$id = $_POST['id'];
        		$fullname = $_POST['name'];
        		$mobile = $_POST['mobile'];
        		$shop_address = $_POST['address'];

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

				$userModel = Worker::findOne(['id'=>$id,'status'=>Worker::ACTIVE_STATUS]);
				if($firstname !="")
					$userModel->firstname = ucfirst(trim($firstname));
				if($lastname !="")
					$userModel->lastname = ucfirst(trim($lastname));
				$userModel->mobile = $mobileno;
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
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			try {

				$id = $_POST['id'];
				
				$model = Worker::findOne(['id'=>$id,'status'=>Worker::ACTIVE_STATUS]);
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


	public function actionSearchWorker()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			try {

				$searchterm = $_POST['searchterm'];
				$tailorid = $_POST['tailorid'];
				
				$model = TailorWorker::find()->innerJoinWith("worker c")->where(['tailorid' => $tailorid])->andWhere(['like','firstname', $searchterm])->orWhere(['like','lastname', $searchterm])->all();
				// $custmodel = Customers::find()->innerJoinWith("customer c")->where(['tailorid' => $tailorid])->andWhere(['like','firstname', $searchterm])->orWhere(['like','lastname', $searchterm])->all();
				// $model = Customers::find()->where(['like','firstname','%'.$searchterm])->orWhere(['like','lastname','%'.$searchterm])->orWhere(['like','email','%'.$searchterm])->orWhere(['like','mobile',$searchterm])->all();
				// echo "<pre>"; print_r($model[0]->customer);exit;
				if($model)
				{
					foreach ($model as $cst) {
						$data[] = $cst->worker;
					}

					return ['result'=>'success','data'=>$data];
				}
				else
					return ['result'=>'success','data'=>[]];

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


	//get existing customers measurements
	public function actionGetWorkerMeasurements()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			$id = $_POST['id'];
			$model = Measurements::findOne(['customerid'=>$id]);
			if($model)
			{
				return ['result'=>'success','data'=>$model];
			}
			else
			{
				return ['result'=>'fail2'];
			}
		}
		else
		{
			return ['result'=>'fail1'];
		}
	}


	public function actionSaveCustomerMeasurements()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			$customerid = $_POST['customerid'];
			$tailorid = $_POST["tailorid"];
			$length = $_POST["length"];
			$chest = $_POST["chest"];
			$stomach = $_POST["stomach"];
			$sleeve_length = $_POST["sleeve_length"];
			$shoulder = $_POST["shoulder"];
			$neck = $_POST["neck"];
			$cuff_length = $_POST["cuff_length"];
			$pant_height = $_POST["pant_height"];
			$pant_waist = $_POST["pant_waist"];
			$pant_thigh = $_POST["pant_thigh"];
			$pant_knee = $_POST["pant_knee"];
			$pant_bottom = $_POST["pant_bottom"];
			$pant_inner = $_POST["pant_inner"];
			$pant_butt = $_POST["pant_butt"];

			$model = Measurements::findOne(['customerid'=>$customerid]);
			if($model)
			{
				// $model->tailorid = $tailorid;
				// $model->id = $id;
				$model->length = $length;
				$model->chest = $chest;
				$model->stomach = $stomach;
				$model->sleeve_length = $sleeve_length;
				$model->shoulder = $shoulder;
				$model->neck = $neck;
				$model->cuff_length = $cuff_length;
				$model->pant_height = $pant_height;
				$model->pant_waist = $pant_waist;
				$model->pant_thigh = $pant_thigh;
				$model->pant_knee = $pant_knee;
				$model->pant_bottom = $pant_bottom;
				$model->pant_inner = $pant_inner;
				$model->pant_butt = $pant_butt;
				$model->updated = date("Y-m-d H:i:s", time());
			}
			else
			{
				$model = new Measurements();
				$model->tailorid = $tailorid;
				$model->customerid = $customerid;
				$model->length = $length;
				$model->chest = $chest;
				$model->stomach = $stomach;
				$model->sleeve_length = $sleeve_length;
				$model->shoulder = $shoulder;
				$model->neck = $neck;
				$model->cuff_length = $cuff_length;
				$model->pant_height = $pant_height;
				$model->pant_waist = $pant_waist;
				$model->pant_thigh = $pant_thigh;
				$model->pant_knee = $pant_knee;
				$model->pant_bottom = $pant_bottom;
				$model->pant_inner = $pant_inner;
				$model->pant_butt = $pant_butt;
				$model->created = $model->updated = date("Y-m-d H:i:s", time());
			}
			if($model->save())
				return ['result'=>'success','data'=>$model];
			else
				return ['result'=>'fail2','data'=>$model,'reason_tech' =>  $model->getErrors()];

		}
		else
		{
			return ['result'=>'fail1'];
		}
	}

	public function actionGetTailorWorkers()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			try {

				$tailorid = $_POST['tailorid'];
				
				$model = TailorWorkers::find()->where(['tailorid'=>$tailorid])->all();
				// echo "<pre>"; print_r($model);exit;
				if($model)
				{
					//$data = $model;
					// foreach ($model as $key => $value) {
					foreach ($model as $m) {
						$worker = $m->worker;
						if($worker && $worker->status==Worker::ACTIVE_STATUS)
							{
						$d = [];
						$d['id'] = $m->worker->id;
						$d['firstname'] = $m->worker->firstname;
						$d['lastname'] = $m->worker->lastname;
						$d['email'] = $m->worker->email;
						$d['mobile'] = $m->worker->mobile;
						$d['address'] = $m->worker->address;
						$data[]=$d;
							}
					}


					return ['result'=>'success','data'=>$data];
				}
				else
					return ['result'=>'success','data'=>[]];

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