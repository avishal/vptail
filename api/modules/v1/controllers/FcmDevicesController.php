<?php

namespace api\modules\v1\controllers;
use common\models\Students;
use common\models\Fcmdevices;

class FcmDevicesController extends \yii\rest\ActiveController
{
	public $modelClass = 'common\models\Fcmdevices';
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreateNewDeviceRegistration()
    {
    	if (!empty($_POST)) {
    		
	        try {
				$deviceid = $_POST['deviceid'];
				$studentid = $_POST['studentid'];

				$studentModel = Students::findOne(['id'=>$studentid]);

				if($studentModel)
				{
					$fcmModel = new Fcmdevices();
					$fcmModel->userid = $studentid;
					$fcmModel->device_token = $deviceid;
					if($fcmModel->save())
						return ['result' =>'success', 'data' =>$fcmModel];
					else
						return ['result' =>'fail', 'reason' =>'Unable to save'];
				}
				else
				{
					return ['result' =>'fail', 'reason' => "Invalid student"];
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
