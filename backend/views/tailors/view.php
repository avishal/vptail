<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TailorUsers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tailor Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tailor-users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'firstname',
            'lastname',
            'email:email',
            'mobile',
            'address',
            'shop_name',
            'shop_address',
            'status',
            'created',
            'updated',
            // 'password:ntext',
        ],
    ]) ?>

</div>
