<?php

namespace backend\controllers;

use Yii;
use common\models\SubscriptionPlans;
use common\models\SubscriptionCourses;
use common\models\SubscriptionPlansSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SubscriptionPlansController implements the CRUD actions for SubscriptionPlans model.
 */
class SubscriptionPlansController extends Controller
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
     * Lists all SubscriptionPlans models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubscriptionPlansSearch();
        $subscriptionCourseModel = new SubscriptionCourses();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'subscriptionCourseModel' => $subscriptionCourseModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SubscriptionPlans model.
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
     * Creates a new SubscriptionPlans model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SubscriptionPlans();
        $subscriptionCourseModel = new SubscriptionCourses();

        if ($model->load(Yii::$app->request->post()) && $model->beforeSave(true) && $model->save()) {
            //echo "<pre>"; print_r($subscriptionCourseModel->load(Yii::$app->request->post()));exit;
            $subscriptionCourseModel->load(Yii::$app->request->post());
            $subscriptionCourseModel->subscriptionid = $model->id;
            if($subscriptionCourseModel->beforeSave(true) && $subscriptionCourseModel->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'subscriptionCourseModel' => $subscriptionCourseModel,
            ]);
        }
    }

    /**
     * Updates an existing SubscriptionPlans model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $subscriptionCourseModel = SubscriptionCourses::findOne(['subscriptionid' => $model->id]);
        
        if ($model->load(Yii::$app->request->post()) && $model->beforeSave(false) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);

            $subscriptionCourseModel->load(Yii::$app->request->post());
            //$subscriptionCourseModel->subscriptionid = $model->id;
            if($subscriptionCourseModel->beforeSave(true) && $subscriptionCourseModel->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
                'subscriptionCourseModel'=>$subscriptionCourseModel,
            ]);
        }
    }

    /**
     * Deletes an existing SubscriptionPlans model.
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
     * Finds the SubscriptionPlans model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SubscriptionPlans the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SubscriptionPlans::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}