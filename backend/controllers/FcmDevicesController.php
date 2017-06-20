<?php

namespace backend\controllers;

use Yii;
use backend\models\Push;
use common\models\Fcmdevices;
use common\models\FcmdevicesSearch;
use common\components\helpers\FirebaseHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FcmDevicesController implements the CRUD actions for Fcmdevices model.
 */
class FcmDevicesController extends Controller
{

    public $notificationlogo_uploadpath = 'uploads/images/notif/';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Fcmdevices models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FcmdevicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Fcmdevices model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Fcmdevices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Fcmdevices();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Fcmdevices model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Fcmdevices model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Fcmdevices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fcmdevices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fcmdevices::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSendMessage()
    {
        Yii::setAlias('backendimages', 'http://www.vpacetech.com/elearn/backend/web/');
        $searchModel = new FcmdevicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //echo "<pre>"; print_r($dataProvider->getModels()); exit;
        if($_POST)
        {
            $logoname = "";
            $title  = $_POST['title'];
            $message = $_POST['message'];
            $modelimageFile = UploadedFile::getInstanceByName('imageFile');
            if($modelimageFile)
            {
                $logoname = $modelimageFile->baseName . '.' . $modelimageFile->extension;
                $modelimageFile->saveAs($this->notificationlogo_uploadpath. $logoname);
            }
            if($dataProvider->getModels())
            {
                $device_tokens = [];
                foreach ($dataProvider->getModels() as $model) {
                    $push = new Push();
                    $regId = $model->device_token;
                    $push->setTitle($title);
                    $push->setMessage($message);
                    //$push->setImage('https://s3-ap-southeast-1.amazonaws.com/tv-prod/seoSearchImages/48-exam-prep-web.jpg');
                    $push->setImage('');
                    if(!empty($logoname))
                        $push->setImage(Yii::getAlias('@backendimages')."/".$this->notificationlogo_uploadpath.$logoname);
                    $push->setIsBackground(FALSE);
                    $json = $push->getPush();
                    $service = new FirebaseHelper();
                    $response = $service->send($regId, $json);
                    //print_r($logoname);
                    print_r(Yii::getAlias('@backendimages')."/".$this->notificationlogo_uploadpath.$logoname);
                    print_r($response);
                }
                /*echo "<pre>"; //print_r($device_tokens); exit;
                $message["title"] = $_POST['title'];
                $message["body"] = $_POST['message'];

                $data["title"] = $_POST['title'];
                $data["body"] = $_POST['message'];
                $data["image_url"] = null;
                $data["timestamp"] = date("Y-m-d H:i:s",time());
                $data["is_background"] = FALSE;
                
                print_r($service->sendMultiple($device_tokens,$message,$data));
                //print_r($service->send("durQTYzS-F4:APA91bEcRwfWyESSCXcN4-fsD_KBhjIV9dy4xDwB1q4D3JIB5qhyYgdqStz9ARW55F8SQyH5r81p-q2q2GTGcdF0lLDzgxIWF5nc52X_Npi494xZi3r1dY41uUap7SoyQT4-BPmO1lao",$message));*/
                exit;
            }
        }
        return $this->render('send-message', []);
    }
}
