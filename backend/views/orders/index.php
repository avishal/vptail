<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Orders', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            // 'tailorid',
            // 'customerid',
            [
                "attribute"=>"tailorid",
                "label"=>"Tailor Name",
                "format"=>"html",
                "value" => 'tailor.firstname'
            ],
            [
                "attribute"=>"customerid",
                "label"=>"Customer Name",
                "format"=>"html",
                "value" => 'customer.firstname'
            ],
            // 'per_pant_price',
            // 'per_shirt_price',
            'pant_count',
            'shirt_count',
            'delivery_date',
            [
                "attribute"=>"Status",
                "format"=>"text",
                "value" => function($data)
                {
                    if($data->status == 1)
                        return "In Progress";
                    if($data->status == 2)
                        return "Ready";
                    if($data->status == 3)
                        return "Delivered";

                }
            ],
            // 'status',
            // 'created',
            // 'updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
