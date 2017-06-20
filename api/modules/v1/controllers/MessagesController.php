<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use common\models\Messages;
/**
 * Constituency Controller API
 */
class MessagesController extends ActiveController
{
    //public $modelClass = 'api\modules\v1\models\Country';
    public $modelClass = 'common\models\Messages';
    public function actionGetlatestmessages()
    {
    	$data = Messages::find()->orderby(['created'=>SORT_DESC])->all();
    	$msgdata = [];
    	foreach ($data as $d) {
			$nd['id'] = $d['id'];
    	 	$nd['userid'] = $d['userid'];
    	 	$nd['message'] = $d['message'];
    	 	$nd['created'] = $d['created'];
    	 	$nd['updated'] = $d['updated'];
    	 	$msgdata[] =$nd;
    	}
    	
    	echo json_encode($msgdata);
    }
}