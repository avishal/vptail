<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StudentSubscriptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Subscriptions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <span class="label label-primary"></span>
      <?= Html::a('Create New Student Subscription', ['create'], ['class' => 'btn btn-success']) ?>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'studentid',
            [
                'attribute' => 'studentid',
                'value' => function($model) {
                    if($model->studentid)
                        return $model->student->firstname." ". $model->student->lastname;
                    else
                        return "-";
                }
            ],
            //'subscriptionid',
            [
                'attribute' => 'subscriptionid',
                'value' => function($model) {
                    if($model->subscriptionid)
                        return $model->subscription->title;
                    else
                        return "-";
                }
            ],
            'starttime',
            'endtime',
            [
                'attribute'=>'isexpired',
                'filter'=>Html::activeDropDownList($searchModel, 'isexpired', ['Yes','No'],['class'=>'form-control','prompt' => 'All']),
                'format' => 'raw',
                'value'=> function($model)
                {
                    if($model->isexpired)
                        return Html::a("<span class='label label-danger'>Yes</span>", ["videos/#","status"=>0,"id"=>$model->id],["class"=>"activestatus"]);
                    else
                        return Html::a("<span class='label label-primary'>No</span>", ["videos/#","status"=>0,"id"=>$model->id],["class"=>"activestatus"]);
                }
            ],
            'paymentid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
</div>
