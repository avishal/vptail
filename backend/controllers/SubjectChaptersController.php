<?php

namespace backend\controllers;

use Yii;
use common\models\SubjectChapters;
use common\models\SubjectChaptersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * SubjectChaptersController implements the CRUD actions for SubjectChapters model.
 */
class SubjectChaptersController extends Controller
{
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
                        'roles' => ['@']
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
     * Lists all SubjectChapters models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubjectChaptersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SubjectChapters model.
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
     * Creates a new SubjectChapters model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SubjectChapters();

        if ($model->load(Yii::$app->request->post()) && $model->beforeSave(true) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SubjectChapters model.
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
     * Deletes an existing SubjectChapters model.
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
     * Finds the SubjectChapters model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SubjectChapters the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SubjectChapters::findOne($id)) !== null) {
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

    public function actionGetChapters($subjid)
    {
        $model = new SubjectChapters();
        $data = SubjectChapters::find()->where(['subjid' => $subjid])->all();
        $this->layout=false;
        //echo Html::activeDropDownList($model, 'id', ArrayHelper::map($data, 'id', 'title'), ['prompt' => 'Select Chapter', 'empty' => 'No chapters found',"class"=>"form-control",'id'=>'videos-chapterid']);
        //return json_encode(ArrayHelper::toArray($model));

        $subjdata = ArrayHelper::map($data, 'id', 'title');
        echo Html::tag('option', "Select Chapter", ['value'=>""]);
        foreach ($subjdata as $key => $value) {
            echo Html::tag('option', $value, ['value'=>$key]);
        }
    }
}
