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


class VideosController extends ActiveController
{

	public $modelClass = 'common\models\Videos';

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
										//echo "1:: isSubscribed: ".$isSubscribed." isSubscriptionExpired: ".$isSubscriptionExpired."<br>";
									}
									else
									{
										//echo "student is subscribed to class ".$studentModel->class->title."<br>";
										//echo "Show videos<br>";
										
										$isSubscriptionExpired = false;
										//echo "2:: isSubscribed: ".$isSubscribed." isSubscriptionExpired: ".$isSubscriptionExpired."<br>";
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
				//echo "5:: isSubscribed: ".$isSubscribed." isSubscriptionExpired: ".$isSubscriptionExpired."<br>";
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
								if($key == 'isfree' && $value == 0)
								{
									$d[$key] = 10;
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
							$locked = false;
							foreach ($vmodel as $key => $value) {
								if($key == 'isfree' && $value == 0)
								{
									
									//$d[$key] = $value;
									$locked = true;
								}
								$d[$key] = $value;
							}
							if(!$locked)
								$alldata[0] = $d;
							else
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