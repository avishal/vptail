<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use common\models\Suggestions;
/**
 * Suggestions Controller API
 */
class SuggestionsController extends ActiveController
{
    //public $modelClass = 'api\modules\v1\models\Country';
    public $modelClass = 'common\models\Suggestions';

    public function actionCreateNew() {
        $this->enableCsrfValidation = false;
        $model = new Suggestions();
        $postdata = Yii::$app->request->post();
        $model->name = $postdata['name'];
        $model->phone = $postdata['phone'];
        $model->email = $postdata['email'];
        $model->address = $postdata['address'];
        $model->subject = $postdata['subject'];
        $model->description = $postdata['description'];
       
        if($model->beforeSave(true) && $model->save()) {
            echo json_encode(array('status'=>"Success",
                     'data'=>$model->attributes),JSON_PRETTY_PRINT);
        } else {
            echo json_encode(array('status'=>"Failure",
                     'error_code'=>400,
                     'errors'=>$model->errors),JSON_PRETTY_PRINT);
        }
    }
}