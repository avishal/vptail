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

	public function actionGetChapterVideos()
	{
		if (!empty($_POST)) {
    		
	        try {
				//$studentid = $_POST['studentid'];
				$chapterid = $_POST['chapterid'];
				$studentid = $_POST['studentid'];
				//$model = new $this->modelClass;
				$model = Videos::find()->where('chapterid=:id', [":id"=>$chapterid])->all();

				$videos=[];
				$subVideos=[];
				$studSubs=[];
				$alldata =[];
				foreach ($model as $video) {
					$data = [];
					$data['locked'] = false;
					$data['video'] = $video;
					$data['subvideo'] = $video->subscriptionVideos;
					if($video->subscriptionVideos)
					{
						$studSub = StudentSubscription::findOne(['studentid'=>$studentid,'subscriptionid' => $video->subscriptionVideos[0]->subscriptionid]);
						$data['stusub'] = $studSub;
						if($studSub)
							$data['locked'] = false;
						else
							$data['locked'] = true;
					}
					/*$data['video'] = $video;
					$subscribedVideos = $video->subscriptionVideos;
					if($subscribedVideos)
					{
						foreach ($subscribedVideos as $subVideo) {
							$subVideos[] = $subVideo;
							if($subVideo)
							{
								$studSub = StudentSubscription::findOne(['studentid'=>$studentid,'subscriptionid' => $subVideo->subscriptionid]);
								if($studSub)
								{
									$studSubs[] = $studSub;
								}
							}
						}
					}*/
						
					$alldata[] = $data;
				}

				if (count($alldata) <= 0) {
					return ['result' =>'fail', 'reason' => "No entries found"];
					//throw new \yii\web\HttpException(404, 'No entries found with this query string');
				} else {
					return ['result' =>'success', 'data' => $alldata];
				}

				/*if(!$model)
				{
					return ['result' =>'fail', 'data' => $model->all()];
				}
				else
				{
					return ['result' =>'fail', 'reason' => "Invalid class",'cl'=>$classid];
				}*/
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