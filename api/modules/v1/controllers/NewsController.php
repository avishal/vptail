<?php

namespace api\modules\v1\controllers;
use Yii;
use yii\rest\ActiveController;
use common\models\News;
/**
 * Constituency Controller API
 */
class NewsController extends ActiveController
{
    //public $modelClass = 'api\modules\v1\models\Country';
    public $modelClass = 'common\models\News';

    public function actionGetlatestnews()
    {
    	$data = News::find()->orderby(['created'=>SORT_DESC])->all();
    	$newsdata = [];
    	foreach ($data as $d) {
			$nd['id'] = $d['id'];
    	 	$nd['title'] = $d['title'];
    	 	$nd['description'] = $d['description'];
    	 	$nd['image_url'] = Yii::$app->urlManagerBackend->baseUrl."/img/news/".$d['image_url'];
    	 	$nd['created'] = $d['created'];
    	 	$nd['updated'] = $d['updated'];
    	 	$newsdata[] =$nd;
    	}
    	
    	echo json_encode($newsdata);
    }
}