<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TailorUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tailor Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tailor-users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tailor Users', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'firstname',
            'lastname',
            'email:email',
            'mobile',
            // 'address',
            // 'shop_name',
            // 'shop_address',
            // 'status',
            // 'created',
            // 'updated',
            // 'password:ntext',
            [
                "attribute"=>"Customers",
                "format"=>"html",
                "value" => function($data)
                {
                    return Html::a("View Customers",Url::toRoute(["tailors/customers","id"=>$data->id]));
                }
            ],
            [
                "attribute"=>"Workers",
                "format"=>"html",
                "value" => function($data)
                {
                    return Html::a("View Workers",Url::toRoute(["tailors/workers","id"=>$data->id]));
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
