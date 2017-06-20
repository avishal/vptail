<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SubscriptionPlansSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subscription Plans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <span class="label label-primary"></span>
      <?= Html::a('Create New Subscription Plan', ['create'], ['class' => 'btn btn-success']) ?>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'price',
            'special_price',
            
            [
                'attribute' => 'duration',
                'value' => function($model){
                    if($model->duration)
                        return $model->duration." days";
                    else
                        return "0 days";
                }
            ],
            // 'description:ntext',
            // 'created',
            // 'updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
</div>
