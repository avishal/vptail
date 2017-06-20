<?php

namespace api\modules\v1\controllers;
use Yii;
use yii\rest\ActiveController;
use common\models\Complaints;
use yii\web\UploadedFile;
/**
 * Personal Info Controller API
 */
class ComplaintsController extends ActiveController
{
	public $modelClass = 'common\models\Complaints';

	public function actionAddcomplaint()
	{
		$model = new Complaints();
		$image_url="";
        if (Yii::$app->request->isPost) {
        //$model->file = UploadedFile::getInstance($model, 'file');
		//echo "<pre>"; print_r($_FILES);exit;
            if ($_FILES) {
                $image_url = $_FILES['file']['name'];
                move_uploaded_file($_FILES['file']['tmp_name'], Yii::getAlias('@backend').'/web/img/complaints/'. $image_url);
                //$model->file->saveAs(Yii::$app->basePath.'/web/img/complaints/' . $model->file->baseName . '.' . $model->file->extension);
                //echo "saved image"; exit;
                //echo "<pre>"; print_r($model->errors);exit;
            }
        $model->load(Yii::$app->request->post());
        $model->image_url = $image_url;
        if ($model->beforeSave(false) && $model->save(false)) {
            echo json_encode(["status"=>"success"]);
        } else {
            //echo "<pre>"; print_r($model->errors);exit;
            echo json_encode(["status"=>"fail"]);
        }
    }
    else
    	echo json_encode(["status"=>"fail"]);
	}

    public function actionCreateNew() {
        $this->enableCsrfValidation = false;
        $model = new Complaints();
        $postdata = Yii::$app->request->post();
        $model->name = $postdata['name'];
        $model->phone = $postdata['phone'];
        $model->email = $postdata['email'];
        $model->address = $postdata['address'];
        $model->subject = $postdata['subject'];
        $model->description = $postdata['description'];
        $mfile = UploadedFile::getInstanceByName('file');
        if($mfile) {
            
            $imageTmpName = $mfile->tempName;
            $pathinfo = pathinfo($mfile->name);
            $imageName = uniqid() . '.' . $pathinfo['extension'];
            $model->image_url = $imageName;
            //$model->image_url = Yii::$app->getSecurity()->generateRandomString(6).$model->file->name;
            $mfile->saveAs(Yii::getAlias('@complaints').$imageName);
        }

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