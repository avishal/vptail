<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use onmotion\gallery\models\GalleryPhoto;
use Yii;
/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class ImgGalsController extends ActiveController
{
    //public $modelClass = 'common\models\GalleryImage';
    public $modelClass = 'onmotion\gallery\models\GalleryPhoto';

    public function actionGetimages()
    {
    	$data = GalleryPhoto::find()->all();
		$images = [];
    	foreach ($data as $d) {
    	 	//$images[] = "http://localhost".Yii::getAlias('@web')." ".$d['name'];
    	 	//$images[] = "http://localhost".Yii::$app->homeUrl."img/".$d['name'];
    	 	$images[] = Yii::$app->urlManagerBackend->baseUrl."/img/gallery/dada/".$d['name'];
    	}
    	echo json_encode($images);
    }
}


