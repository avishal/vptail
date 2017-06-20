<?php

namespace api\modules\v1\controllers;
use Yii;
use yii\rest\ActiveController;
use common\models\Developmentwork;
/**
 * Constituency Controller API
 */
class DevWorksController extends ActiveController
{
    //public $modelClass = 'api\modules\v1\models\Country';
    public $modelClass = 'common\models\Developmentwork';

    public function actionGetlatestnews()
    {
    	$data = Developmentwork::find()->orderby(['created'=>SORT_DESC])->all();
    	$newsdata = [];
    	foreach ($data as $d) {
			$nd['id'] = $d['id'];
    	 	$nd['title'] = $d['title'];
    	 	$nd['description'] = $d['description'];
    	 	$nd['image_url'] = Yii::$app->urlManagerBackend->baseUrl."/img/devworks/".$d['image_url'];
    	 	$nd['created'] = $d['created'];
    	 	$nd['updated'] = $d['updated'];
    	 	$newsdata[] =$nd;
    	}
    	
    	echo json_encode($newsdata);
    }
}