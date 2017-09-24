<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\Students;
use common\models\Subjects;
use common\models\Classes;
use common\models\Videos;
use common\models\SubscriptionVideos;
use common\models\SubscriptionCourses;
use common\models\StudentSubscription;
use common\models\SubscriptionPlans;

class StudentSubscriptionsController extends ActiveController
{

	public $modelClass = 'common\models\StudentSubscription';

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

	public function actionPayuHash()
	{
		if (!empty($_POST)) {
			
			$key=$_POST["key"];

			$salt="s6j2r8XAaX";
			// $salt="UTX1I0nGyt";
			/*$txnId=$_POST["txnid"];
			$amount=$_POST["amount"];
			$productName=$_POST["productInfo"];
			$firstName=$_POST["firstName"];
			$email=$_POST["email"];
			$udf1=$_POST["udf1"];
			$udf2=$_POST["udf2"];
			$udf3=$_POST["udf3"];
			$udf4=$_POST["udf4"];
			$udf5=$_POST["udf5"];*/

			// $payhash_str = $key . '|' . checkNull($txnId) . '|' .checkNull($amount)  . '|' .checkNull($productName)  . '|' . checkNull($firstName) . '|' . checkNull($email) . '|' . checkNull($udf1) . '|' . checkNull($udf2) . '|' . checkNull($udf3) . '|' . checkNull($udf4) . '|' . checkNull($udf5) . '|' . $salt;
			$payhash_str = $key . $salt;

			$hash = strtolower(hash('sha512', $payhash_str));
			$arr['result'] = $hash;
			$arr['status']=0;
			$arr['errorCode']=null;
			$arr['responseCode']=null;
			$output=$arr;

			return $output;
		}
		else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}

	private function checkNull($value) {
            if ($value == null) {
                  return '';
            } else {
                  return $value;
            }
      }

	public function actionCreateNewStudentSubscription()
	{
		//$today = date('Y-m-d H:i:s',time());
		//print_r(date('Y-m-d', strtotime("+30 days")));exit;
		if (!empty($_POST)) {
    		
	        try {
	        	$paymentid = $_POST['paymentid'];
	        	$subscriptionid = $_POST['subscriptionid'];
				$studentid = $_POST['studentid'];

				$subscrptionModel = SubscriptionPlans::findOne($subscriptionid);
				$studentModel = Students::findOne(['id'=>$studentid]);
				if($subscrptionModel && $studentModel)
				{
					$noofdaysofsubscription = $subscrptionModel->duration;
					$today = date('Y-m-d H:i:s',time());

					$exp = date('Y-m-d H:i:s',strtotime("+".$noofdaysofsubscription." days"));
					$studentSubscriptionModel = new StudentSubscription();
					$studentSubscriptionModel->studentid = $studentid;
					$studentSubscriptionModel->subscriptionid = $subscriptionid;
					$studentSubscriptionModel->starttime = $today;
					$studentSubscriptionModel->endtime = $exp;
					$studentSubscriptionModel->isexpired = 0;
					$studentSubscriptionModel->paymentid = $paymentid;
					if($studentSubscriptionModel->save())
					{
						return ['result' =>'success', 'reason-data' => $studentSubscriptionModel];
					}
					else
					{
						return ['result' =>'fail', 'reason' => "something went wrong","error"=>$studentSubscriptionModel->getErrors()];
					}
				}
				else
				{
					return ['result' =>'fail', 'reason' =>"invalid student or subscription plan"];
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

	private function isSubscriptionExpired($endtime)
	{
		$today = date('Y-m-d H:i:s',time()); 
		$exp = date('Y-m-d H:i:s',strtotime($endtime)); //query result form database
		$expDate =  date_create($exp);
		$todayDate = date_create($today);
		$diff =  date_diff($todayDate, $expDate);
		if($diff->format("%R%a")>0 || $diff->format("%R%h")>0 || $diff->format("%R%i")>0){
		     return false; // subscription is not expired
		}else{
		   return true; // subscription is expired
		}
	}

	public function actionGetChapterVideos()
	{
		if (!empty($_POST)) {
    		
	        try {
				$chapterid = $_POST['chapterid'];
				$studentid = $_POST['studentid'];
				$alldata =[];

				$studentModel = Students::findOne(['id'=>$studentid]);

				$videoModel = Videos::findAll(['chapterid' => $chapterid]);
				$isSubscribed = false;
				$isSubscriptionExpired = false;


				if($videoModel && count($videoModel)>0)
				{
					$subscriptionCoursesModel = SubscriptionCourses::findAll(['classid' => $videoModel[0]->classid]);
					//echo "<pre>"; print_r($subscriptionCoursesModel);exit;
					if($subscriptionCoursesModel)
					{
						foreach ($subscriptionCoursesModel as $scModel) {
							$studentSubscriptionModel = StudentSubscription::findAll(['studentid'=>$studentid, 'subscriptionid' => $scModel->subscriptionid, 'isexpired' => 0]);
							
							//echo "<pre>"; print_r($studentSubscriptionModel);exit;
							if($studentSubscriptionModel)
							{
								// student is subscribed to any of the plans. Check if the plan is valid or expired.
								/*foreach ($videoModel as $video) {
									$data = $video;
								}
								$alldata[] = $data;*/
								$isSubscribed = true;
								$isSubscriptionExpired = false;
								foreach ($studentSubscriptionModel as $ssModel) {

									if($this->isSubscriptionExpired($ssModel->endtime))
									{
										//echo "student is subscribed for class ".$studentModel->class->title." is expired<br>";
										//break;
										$isSubscriptionExpired = true;
										//echo "1.1. isSubscribed: ".$isSubscribed." isSubscriptionExpired: ".$isSubscriptionExpired."<br>";
									}
									else
									{
										//echo "student is subscribed to class ".$studentModel->class->title."<br>";
										//echo "Show videos<br>";
										
										$isSubscriptionExpired = false;
										//echo "1.2. isSubscribed: ".$isSubscribed." isSubscriptionExpired: ".$isSubscriptionExpired."<br>";
									}
								}
								//echo "1. isSubscribed: ".$isSubscribed." isSubscriptionExpired: ".$isSubscriptionExpired."<br>";
								//break;
							}
							else
							{
								$isSubscribed = false;
								$isSubscriptionExpired = false;
								//echo "2. isSubscribed: ".$isSubscribed." isSubscriptionExpired: ".$isSubscriptionExpired."<br>";
								//echo "student is not subscribed to class ".$studentModel->class->title;
								/*foreach ($videoModel as $video) {
									$data = $video;
								}
								$alldata[] = $data;*/
							}
						}
					}
					else
					{
						$isSubscribed = true;
						$isSubscriptionExpired = true;
						//echo "3. isSubscribed: ".$isSubscribed." isSubscriptionExpired: ".$isSubscriptionExpired."<br>";
						//echo "class is not in subscription list ".$studentModel->class->title;
						//print_r($studentModel);
					}
				}
				else
				{
					$isSubscribed = false;
					$isSubscriptionExpired = true;	
					//echo "4. isSubscribed: ".$isSubscribed." isSubscriptionExpired: ".$isSubscriptionExpired."<br>";
					//echo "no videos for this chapter ".$chapterid;
				}
				//echo "5. isSubscribed: ".$isSubscribed." isSubscriptionExpired: ".$isSubscriptionExpired."<br>";
				//exit;
				if (count($videoModel) <= 0) {
					return ['result' =>'fail', 'reason' => "No entries found"];
				} else {
					$alldata = [];
					if($isSubscribed=== true && $isSubscriptionExpired === false)
					{
						
						foreach ($videoModel as $vmodel) {
							$d = [];
							foreach ($vmodel as $key => $value) {
								if($key == 'isfree' && $value == 10)
								{
									$d[$key] = 0;
								}
								else
									$d[$key] = $value;
							}
							$alldata[] = $d;
						}
					}
					else if(($isSubscribed=== true && $isSubscriptionExpired === true) || ($isSubscribed === false || $isSubscriptionExpired === false))
					{
						
						foreach ($videoModel as $vmodel) {
							$d = [];
							foreach ($vmodel as $key => $value) {

								$d[$key] = $value;
							}
							$alldata[] = $d;
						}
					}

					/*else if($isSubscribed === false || $isSubscriptionExpired === false)
					{
						foreach ($videoModel as $vmodel) {
								$d = [];
							foreach ($vmodel as $key => $value) {
								$d[$key] = $value;
							}
							$alldata[] = $d;
						}
					}*/
					return ['result' =>'success', 'data' => $alldata];
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