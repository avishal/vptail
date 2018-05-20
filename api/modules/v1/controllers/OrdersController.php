<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\Orders;
use common\models\Customers;
use common\models\TailorCustomers;
use common\models\TailorUsers;
use common\models\Measurements;


class OrdersController extends ActiveController
{

	public $modelClass = 'common\models\Orders';

	
	public function actionNewOrder()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			try {
				$tailorid = $_POST['tailorid'];
				$customerid = $_POST['customerid'];
				$pant_count = $_POST['pant_count'];
				$shirt_count = $_POST['shirt_count'];
				$delivery_date = $_POST['delivery_date'];
				$per_pant_price = $_POST['per_pant_price'];
				$per_shirt_price =  $_POST['per_shirt_price'];
				$status = Orders::STATUS_PROGRESS;
				$model = Customers::findOne(['id' => $customerid]);
				if($model)
				{
					$orderModel = new Orders();
					$orderModel->tailorid = $tailorid;
					$orderModel->customerid = $customerid;
					$orderModel->pant_count = $pant_count;
					$orderModel->shirt_count = $shirt_count;
					$orderModel->delivery_date = $delivery_date;
					$orderModel->per_pant_price = $per_pant_price;
					$orderModel->per_shirt_price = $per_shirt_price;
					$orderModel->status = $status;
					if ($orderModel->beforeSave(true) && $orderModel->save())
					{	
						$this->sendThankyouEmail($customerid, $tailorid);
						return ['result' =>'success', 'data' => $orderModel];
					}
					else
					{
						return ['result' =>'fail','reason'=>'Something went wrong' ,'reason_tech' => $orderModel->getErrors()];
					}
				}
				else
				{
					return ['result' =>'fail', 'reason' => "Invalid Customer"];
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

	public function actionAllOrders()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			try {
				$tailorid = $_POST['tailorid'];
				$modelOrderProgress = Orders::find()->where(['tailorid' => $tailorid, 'status'=>1])->limit(3)->all();
				$modelOrderReady = Orders::find()->where(['tailorid' => $tailorid, 'status'=>2])->limit(3)->all();
				$modelOrderDelivered = Orders::find()->where(['tailorid' => $tailorid, 'status'=>3])->limit(3)->all();
				$data = [];
				$mOrdProg = [];
				for ($i=0; $i <count($modelOrderProgress) ; $i++) { 
					$temp = $modelOrderProgress[$i];
					$mOrdProgtemp = [];
					foreach ($temp as $key => $value) {
						$mOrdProgtemp[$key] = $value;
					}
					$mOrdProgtemp['customer_details'] = $temp->customer;
					$mOrdProg[] = $mOrdProgtemp;
				}
				$mOrdReady = [];
				for ($i=0; $i <count($modelOrderReady) ; $i++) { 
					$temp = $modelOrderReady[$i];
					$mOrdReadytemp = [];
					foreach ($temp as $key => $value) {
						$mOrdReadytemp[$key] = $value;
					}
					$mOrdReadytemp['customer_details'] = $temp->customer;
					$mOrdReady[] = $mOrdReadytemp;
				}
				$mOrdDelivery = [];
				for ($i=0; $i <count($modelOrderDelivered) ; $i++) { 
					$temp = $modelOrderDelivered[$i];
					$mOrdDeliverytemp = [];
					foreach ($temp as $key => $value) {
						$mOrdDeliverytemp[$key] = $value;
					}
					$mOrdDeliverytemp['customer_details'] = $temp->customer;
					$mOrdDelivery[] = $mOrdDeliverytemp;
				}

				$data['inprogress'] = $mOrdProg;
				$data['ready'] = $mOrdReady;
				$data['delivered'] = $mOrdDelivery;
				return ['result' =>'success',$data];
			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}
		}
	}

	public function actionUpdateOrderStatus()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			try {
				$id = $_POST['orderid'];
				$status = $_POST['status'];
				$model = Orders::findOne(['id' => $id]);
				if($model)
				{
					$model->status = $status;
					if ($model->beforeSave(false) && $model->save())
					{	
						// $this->sendThankyouEmail($customerid, $tailorid);
						return ['result' =>'success', 'data' => $model];
					}
					else
					{
						return ['result' =>'fail','reason'=>'Something went wrong' ,'reason_tech' => $orderModel->getErrors()];
					}
				}
				else
				{
					return ['result' =>'fail', 'reason' => "Invalid Order"];
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

	public function actionGetOrderById()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if (!empty($_POST)) {
			try {
				$orderid = $_POST['orderid'];
				$orderModel = Orders::findOne(['id' => $orderid]);
				if($orderModel)
				{
					return ['result' =>'success', 'data' => $orderModel];
				}
				else
				{
					return ['result' =>'fail', 'reason' => "Invalid order"];
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

	private function sendThankyouEmail($email)
	{
        
	    $from = Yii::$app->params['supportEmail']; // this is your Email address
	    $to = $email; // this is the sender's Email address

	    $headers = 'MIME-Version: 1.0' . "\ r\n";
	    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\ r\n";
	    $headers .= "From:" . $from;
	    $subject = "Thank you for visiting tailor";

    	$body ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
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
		                        <h4><b>Thank you for visiting the tailor shop. Your cloths will be delivered by date</b> </h4>
		                        <div class="message-box">
		                            <p class="lead">We are happy you’re here!</p>
		                        </div>
		                        <hr class="style3">
		                        <br/>
		                        <p class="gray">Thank you</p>
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
}
?>