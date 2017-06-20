<?php

namespace backend\controllers;

use Yii;
use common\models\Classes;
use common\models\ClassesSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClassesController implements the CRUD actions for Classes model.
 */
class ClassesController extends Controller
{
    public $classlogo_uploadpath = 'uploads/images/classlogos/';
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
     * Lists all Classes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClassesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Classes model.
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
     * Creates a new Classes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Classes();

        if ($model->load(Yii::$app->request->post())) {
            $modelimageFile = UploadedFile::getInstance($model, 'imageFile');
            if($modelimageFile)
            {
                $logoname = $modelimageFile->baseName . '.' . $modelimageFile->extension;
                $model->logo = $logoname;
                $modelimageFile->saveAs($this->classlogo_uploadpath. $logoname);
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
     * Updates an existing Classes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $modelimageFile = UploadedFile::getInstance($model, 'imageFile');

            if($modelimageFile)
            {
                $logoname = $modelimageFile->baseName . '.' . $modelimageFile->extension;
                $model->logo = $logoname;
                $fileuploaded = $modelimageFile->saveAs($this->classlogo_uploadpath. $logoname);
            }

            if($model->beforeSave(false) && $model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Classes model.
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
     * Finds the Classes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Classes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Classes::findOne($id)) !== null) {
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
}
