<?php

namespace backend\controllers;

use Yii;
use common\models\Videos;
use common\models\VideosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VideosController implements the CRUD actions for Videos model.
 */
class VideosController extends Controller
{
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
     * Lists all Videos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VideosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Videos model.
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
     * Creates a new Videos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Videos();

        if ($model->load(Yii::$app->request->post()) && $model->beforeSave(false) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Videos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->beforeSave(false) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Videos model.
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
     * Finds the Videos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Videos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Videos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionVideoupload()
    {
        $model = new Videos(['scenario' => 'upload']);

        //if ($model->load(Yii::$app->request->post())) {
        if(Yii::$app->request->isPost){
            $videodata = Yii::$app->request->post();
        //echo "<pre>"; 
            //echo count($videodata['Videos']['title'])." <pre>"; print_r($videodata['Videos']); exit;
            for ($i=0; $i < count($videodata['Videos']['title']); $i++) {
                $videoitem = $videodata['Videos'];
                $modelvid = new Videos();
                $modelvid->chapterid = $videoitem['chapterid'];
                $modelvid->title = $videoitem['title'][$i];
                $modelvid->url = $videoitem['url'][$i];
                //$modelvid->isfree = $videoitem['isfree'][$i];
                //$modelvid->status = $videoitem['status'][$i];
                if($i==0)
                    $modelvid->isfree = 10;
                else
                    $modelvid->isfree = 0;
                $modelvid->status = 10;
                if ($modelvid->beforeSave(true) && $modelvid->save()) {
                    
                }
                else
                {
                    echo "<pre>"; print_r($modelvid->getErrors()); exit;
                }
            }
            return $this->redirect('videos/index');
            
        }

        return $this->render('videoupload', [
            'model' => $model,
        ]);
    }
}
