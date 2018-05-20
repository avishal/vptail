<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\Customers;
use common\models\TailorCustomers;
use common\models\TailorUsers;
use common\models\Measurements;


class CustomersController extends ActiveController
{

	public $modelClass = 'common\models\Customers';

	public function actionLogin()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			try {

				$email = $_POST['email'];
				$password = $_POST['password'];
				
				// $model = Customers::findOne(['email'=>$email,'password' => md5($password),'status'=>Customers::ACTIVE_STATUS]);
				$model = Customers::find()->orWhere(['or',['email'=>$email],['mobile'=>$email]])->andWhere(['password' => md5($password),'status'=>Customers::ACTIVE_STATUS])->one();
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
				$passwordplain = "123456";
				$model = Customers::findOne(['email' => $email,'status'=>Customers::ACTIVE_STATUS]);
				$modelMobile = Customers::findOne(['mobile' => $mobile,'status'=>Customers::ACTIVE_STATUS]);
				if($modelMobile)
				{
					return ['result' =>'fail', 'reason' => "Mobile number is already registered"];
				}
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

					$userModel = new Customers();
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
						$tailorCustomersModel = new TailorCustomers();
						$tailorCustomersModel->customerid = $userModel->id;
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
				$user = Customers::findOne(['email' => $email,'status'=>Customers::ACTIVE_STATUS]);
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
				$model = Customers::findOne(['id'=>$id,'status'=>Customers::ACTIVE_STATUS]);
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

	public function actionUpdateCustomer()
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

				$userModel = Customers::findOne(['id'=>$id,'status'=>Customers::ACTIVE_STATUS]);
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
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			try {

				$id = $_POST['id'];
				
				$model = Customers::findOne(['id'=>$id,'status'=>Customers::ACTIVE_STATUS]);
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


	public function actionSearchCustomers()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			try {

				$searchterm = $_POST['searchterm'];
				$tailorid = $_POST['tailorid'];
				
				$model = TailorCustomers::find()->innerJoinWith("customer c")->where(['tailorid' => $tailorid])->andWhere(['like','firstname', $searchterm])->andWhere(['status', Customers::ACTIVE_STATUS])->orWhere(['like','lastname', $searchterm])->all();
				// $custmodel = Customers::find()->innerJoinWith("customer c")->where(['tailorid' => $tailorid])->andWhere(['like','firstname', $searchterm])->orWhere(['like','lastname', $searchterm])->all();
				// $model = Customers::find()->where(['like','firstname','%'.$searchterm])->orWhere(['like','lastname','%'.$searchterm])->orWhere(['like','email','%'.$searchterm])->orWhere(['like','mobile',$searchterm])->all();
				// echo "<pre>"; print_r($model[0]->customer);exit;
				if($model)
				{
					foreach ($model as $cst) {
						$data[] = $cst->customer;
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

	public function actionGetTailorCustomers()
	{
		
		if (!empty($_POST)) {
			try {

				$tailorid = $_POST['tailorid'];
				
				$model = TailorCustomers::find()->where(['tailorid'=>$tailorid])->all();
				// echo "<pre>"; print_r($model);exit;
				if($model)
				{
					//$data = $model;
					$data=array();
					// foreach ($model as $key => $value) {
					foreach ($model as $m) {
						$customermodel = $m->customer;
						if($customermodel && $customermodel->status == Customers::ACTIVE_STATUS)
							{
								
						$d = [];

						$d['id'] = $m->customer->id;
						$d['firstname'] = $m->customer->firstname;
						$d['lastname'] = $m->customer->lastname;
						$d['email'] = $m->customer->email;
						$d['mobile'] = $m->customer->mobile;
						$d['address'] = $m->customer->address;
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
	public function actionGetCustomerMeasurements()
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
			$length = isset($_POST["length"])?$_POST["length"]:"";
			$chest = isset($_POST["chest"])?$_POST["chest"]:"";
			$stomach = isset($_POST["stomach"])?$_POST["stomach"]:"";
			$sleeve_length = isset($_POST["sleeve_length"])?$_POST["sleeve_length"]:"";
			$shoulder = isset($_POST["shoulder"])?$_POST["shoulder"]:"";
			$neck = isset($_POST["neck"])?$_POST["neck"]:"";
			$cuff_length = isset($_POST["cuff_length"])?$_POST["cuff_length"]:"";
			$pant_height = isset($_POST["pant_height"])?$_POST["pant_height"]:"";
			$pant_waist = isset($_POST["pant_waist"])?$_POST["pant_waist"]:"";
			$pant_thigh = isset($_POST["pant_thigh"])?$_POST["pant_thigh"]:"";
			$pant_knee = isset($_POST["pant_knee"])?$_POST["pant_knee"]:"";
			$pant_bottom = isset($_POST["pant_bottom"])?$_POST["pant_bottom"]:"";
			$pant_inner = isset($_POST["pant_inner"])?$_POST["pant_inner"]:"";
			$pant_butt = isset($_POST["pant_butt"])?$_POST["pant_butt"]:"";

			$customerModel = Customers::findOne(['id'=>$customerid, "status"=>Customers::ACTIVE_STATUS]);
			$tailorModel = TailorUsers::findOne(['id'=>$tailorid]);
			if($customerModel && $tailorModel)
			{
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
					if($model->beforeSave(false) && $model->update())
						return ['result'=>'success','data'=>$model];
					else
						return ['result'=>'fail2','reason'=>"unable to save",'reason_tech' =>  $model->getErrors()];
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
					// echo "<pre>"; print_r($model); exit;
					if($model->beforeSave(true) && $model->save())
						return ['result'=>'success','data'=>$model];
					else
						return ['result'=>'fail2','reason'=>"unable to save",'reason_tech' =>  $model->getErrors()];
					
				}

			}
			else
			{
				return ['result'=>'fail','reason'=>"invalid customer or tailor"];
			}
		}
		else
		{
			return ['result'=>'fail','reason'=>"invalid request"];
		}
	}
}
?>