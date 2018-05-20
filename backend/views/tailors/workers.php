<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TailorUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tailor Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tailor-users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Tailor Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'worker.firstname',
            'worker.lastname',
            'worker.email:email',
            'worker.mobile',
            // 'address',
            // 'shop_name',
            // 'shop_address',
            // 'status',
            // 'created',
            // 'updated',
            // 'password:ntext',
            
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
