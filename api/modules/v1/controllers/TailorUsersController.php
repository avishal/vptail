<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\TailorUsers;
use common\models\Orders;
use common\models\Worker;
use common\models\Customers;
use common\models\TailorWorkers;
use common\models\TailorCustomers;


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
				
				$model = TailorUsers::find()->orWhere(['or',['email'=>$email],['mobile'=>$email]])->andWhere(['password' => md5($password)])->one();
				// echo "<pre>"; print_r($model->createCommand()->getRawSql());exit;
				// echo "<pre>"; print_r($model);exit;
				if($model)
				{
					if($model->status == TailorUsers::ACTIVE_STATUS)
						return ['result'=>'success','data'=>$model];
					else
						return ['result'=>'fail','reason'=>"Account not activated"];
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
				$countrycode = $_POST['countrycode'];
				$passwordplain = $_POST['password'];
				// $country_code = "IN";
				// if(isset($_POST['country_code']))
					// $country_code = $_POST['country_code'];
				$modelEmail = TailorUsers::findOne(['email' => $email]);
				$modelMobile = TailorUsers::findOne(['mobile' => $mobileno]);
				if($modelMobile)
				{
					return ['result' =>'fail', 'reason' => "Mobile number is already registered"];
				}
				// echo "<Pre>"; print_r($modelEmail);exit;
				if(!$modelEmail)
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

					$tailorUserModel = new TailorUsers();
					$tailorUserModel->firstname = ucfirst(trim($firstname));
					$tailorUserModel->lastname = ucfirst(trim($lastname));
					$tailorUserModel->email = $email;
					$tailorUserModel->mobile = $mobileno;
					$tailorUserModel->countrycode = $countrycode;
					$tailorUserModel->password = md5(trim($passwordplain));
					$tailorUserModel->status = TailorUsers::ACTIVE_STATUS;
					$tailorUserModel->shop_name = "NA";
					$tailorUserModel->created = $tailorUserModel->updated = date('Y-m-d H:i:s',time());

					if ($tailorUserModel->save())
					{	
						$this->sendVerificationEmail($email);
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

	private function sendVerificationEmail($email)
	{
        $user = TailorUsers::findOne([
            //'status' => Users::STATUS_DELETED,
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
		                        <h4><b>Welcome,</b> '.$user->firstname.' '.$user->lastname.'</h4>
		                        <div class="message-box">
		                            <p class="lead">Thank you for signing up. We are happy you’re here!</p>
		                        </div>
		                        <hr class="style3">
		                        <br/>
		                        <p class="gray">Please click on following link to confirm your email.</p>
		                        <p><a href="'.$resetLink.'">Click Me!</a></p>
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


	public function actionFromAppRegister()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
    		try {
				$name = $_POST['name'];
				$email = $_POST['email'];
				$mobileno = $_POST['mobile'];
				$countrycode = $_POST['countrycode'];
				$passwordplain = $_POST['password'];
				// $country_code = "IN";
				// if(isset($_POST['country_code']))
					// $country_code = $_POST['country_code'];
				$modelEmail = TailorUsers::findOne(['email' => $email]);
				$modelMobile = TailorUsers::findOne(['mobile' => $mobileno]);
				if($modelMobile)
				{
					return ['result' =>'fail', 'reason' => "Mobile number is already registered"];
				}
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
					$tailorUserModel->countrycode = $countrycode;
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
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
	        try {
				$email = $_POST['email'];
				$user = TailorUsers::findOne(['email' => $email]);
				if($user)
				{
					// $randomstring = random_int(23999, 8999999);
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
		$_POST = json_decode(file_get_contents('php://input'), true);
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
				$userModel->mobile = $mobile;
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
				
				$model = TailorUsers::findOne(['id'=>$id]);
				//echo "<pre>"; print_r($model);exit;
				if($model)
				{
					return ['result'=>'success','data'=>$model];
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

	public function actionGetOrderByOrderId()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			$id = $_POST['id'];
			$model = Orders::find()->where(['id'=>$id])->one();
			if($model)
			{
				return ['result'=>'success','data'=>$model];
			}
			else
			{
				return ['result'=>'success','data'=>[]];

			}

		}
	}

	public function actionGetOrdersByCustomerId()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			$id = $_POST['customerid'];
			$model = Orders::find()->where(['customerid'=>$id])->all();
			if($model)
			{
				return ['result'=>'success','data'=>$model];
			}
			else
			{
				return ['result'=>'success','data'=>[]];
			}

		}
	}

	public function actionUpdateMeasurementUnit()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			$id = $_POST['tailorid'];
			$unit = $_POST['unit'];
			$model = TailorUsers::find()->where(['id'=>$id])->one();
			if($model)
			{
				$model->measurement_unit = ucwords($unit);
				if($model->beforeSave(false) && $model->save())
					return ['result'=>'success','data'=>$model];
				else
					return ['result'=>'fail','reason'=>"unable to save"];
			}
			else
			{
				return ['result'=>'fail','reason'=>"invalid tailor"];
			}

		}
	}

	public function actionGetOrdersByTailorId()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			$id = $_POST['tailorid'];
			$model = Orders::find()->where(['tailorid'=>$id])->all();
			if($model)
			{
				$mOrdProg = [];
				for ($i=0; $i <count($model) ; $i++) { 
					$temp = $model[$i];
					$mOrdProgtemp = [];
					foreach ($temp as $key => $value) {
						$mOrdProgtemp[$key] = $value;
					}
					$mOrdProgtemp['customer_details'] = $temp->customer;
					$mOrdProg[] = $mOrdProgtemp;
				}
				
				return ['result'=>'success','data'=>$mOrdProg];
			}
			else
			{
				return ['result'=>'success','data'=>[]];
			}

		}
	}

	public function actionDeleteCustomer()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			$tailorid = $_POST['tailorid'];
			$customerid = $_POST['customerid'];
			$tailorcustomermodel = TailorCustomers::find()->where(['tailorid'=>$tailorid, "customerid" => $customerid])->one();
			if($tailorcustomermodel)
			{
				$model = Customers::find()->where(['id'=>$customerid])->one();
				$model->status=Customers::DELETED_STATUS;
				if($model->beforeSave(false) && $model->update())
				{
					return ['result'=>'success','data'=>[]];
				}
				else
				{
					return ['result'=>'fail',"reason" => "unable to delete customer"];
				}
			}
			else
			{
				return ['result'=>'fail',"reason" => "invalid tailor customer"];
			}
		}
	}

	public function actionDeleteWorker()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			$tailorid = $_POST['tailorid'];
			$workerid = $_POST['workerid'];
			$tailorworkermodel = TailorWorkers::find()->where(['tailorid'=>$tailorid, "workerid" => $workerid])->one();
			if($tailorworkermodel)
			{
				$model = Worker::find()->where(['id'=>$workerid])->one();
				$model->status= Worker::DELETED_STATUS;
				if($model->beforeSave(false) && $model->update())
				{
					return ['result'=>'success','data'=>[]];
				}
				else
				{
					return ['result'=>'fail',"reason" => "unable to delete worker"];
				}
			}
			else
			{
				return ['result'=>'fail',"reason" => "invalid tailor worker"];
			}
		}

	}

	public function actionWorkerCustomers()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			$workerid = $_POST['workerid'];
			// $tailorworkermodel = TailorWorkers::find()->where(['workerid'=>$workerid])->all();

			//SELECT * FROM customers c join `tailor_customers` as tc on tc.customerid = c.id join tailor_workers as tw on tw.tailorid = tc.tailorid WHERE workerid =2

			// $customerModel = Customers::find()->where(['workerid'=>$workerid])->joinWith("tailorWorker")->all();
$rows = (new \yii\db\Query())
    ->select("customers.*")
    ->from('customers')
    ->leftJoin('tailor_customers', 'tailor_customers.customerid = customers.id')
    ->leftJoin('tailor_workers', 'tailor_workers.tailorid = tailor_customers.tailorid')
    ->where(['workerid'=>$workerid])
    ->andWhere(['status'=>Customers::ACTIVE_STATUS])
    ->all();
				/*echo "<pre>";
				print_r($rows);
				exit;*/
			if($rows)
			{
				return ['result'=>'success','data'=>$rows];
			}
			else
			{
				return ['result'=>'fail',"reason" => "invalid worker"];
			}
		}

	}
}
?>