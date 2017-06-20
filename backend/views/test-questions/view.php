<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TestQuestions */
$classlogo_uploadpath = 'uploads/images/testquestionsimages/';
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Test Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-questions-view">

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
            'testid',
            "attribute"=>'question:ntext',
            [
              'attribute' => 'image_url',
              'format' =>'raw',
              'value'=>function($data) { return 
                Html::img("uploads/images/testquestionsimages/".$data->image_url,['alt'=>'myImage','width'=>'70']); },
            ],
            'first_option',
            'second_option',
            'third_option',
            'fourth_option',
            'fifth_option',
            'sixth_option',
            'answer',
            'solution:ntext',
            'status',
            'created',
            'updated',
        ],
    ]) ?>

</div>
