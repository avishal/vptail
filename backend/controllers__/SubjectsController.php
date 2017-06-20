<?php

namespace backend\controllers;

use Yii;
use common\models\Subjects;
use common\models\SubjectsSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * SubjectsController implements the CRUD actions for Subjects model.
 */
class SubjectsController extends Controller
{

    public $subjlogo_uploadpath = 'uploads/images/subjlogos/';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            
        ];
    }

    /**
     * Lists all Subjects models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subjects model.
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
     * Creates a new Subjects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Subjects();

        if ($model->load(Yii::$app->request->post())) {
            $modelimageFile = UploadedFile::getInstance($model, 'imageFile');
            if($modelimageFile)
            {
                $logoname = $modelimageFile->baseName . '.' . $modelimageFile->extension;
                $model->image = $logoname;
                $modelimageFile->saveAs($this->subjlogo_uploadpath. $logoname);    
            }
            if($model->beforeSave(true) && $model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Subjects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $modelimageFile = UploadedFile::getInstance($model, 'imageFile');
            //echo "<pre>"; print_r($modelimageFile);exit;
            if($modelimageFile)
            {
                $logoname = $modelimageFile->baseName . '.' . $modelimageFile->extension;
                $model->image = $logoname;
                $modelimageFile->saveAs($this->subjlogo_uploadpath. $logoname);    
            }
            if($model->beforeSave(true) && $model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Subjects model.
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
     * Finds the Subjects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subjects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subjects::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionChangestatus($status, $id)
    {
        $model = $this->findModel($id);
        $model->status=$status;
        //if(true)
        if($model->update())
        {
            echo "1";
        }
        else
        {
            echo "0";
        }
    }

    public function actionGetSubjects($classid)
    {
        $model = new Subjects();
        $data = Subjects::find()->where(['classid' => $classid])->all();
        //echo "<pre> $gid"; 
        //print_r($gid); 
        //exit;
        $this->layout=false;
        //echo Html::activeDropDownList($model, 'id', ArrayHelper::map($data, 'id', 'title'), ['prompt' => 'Select Subjects', 'empty' => 'No subjects found',"class"=>"form-control"]);
        //return json_encode(ArrayHelper::toArray($model));

        $subjdata = ArrayHelper::map($data, 'id', 'title');
        echo Html::tag('option', "Select Subject", ['value'=>""]);
        foreach ($subjdata as $key => $value) {
            echo Html::tag('option', $value, ['value'=>$key]);
        }

    }
}
