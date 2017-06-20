<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Subjects */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subjects-view">

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
            [
              'attribute' => 'classid',
              'value' => function($data){
                return $data->class->title;
              }
            ],

            'title',
            //'image',
            [
              'attribute' => 'image',
              'format' =>'raw',
              'value'=>function($data) { return Html::img($data->imageurl,['alt'=>'myImage','width'=>'70']); },
            ],
            [
                'attribute'=>'status',
                'format' => 'raw',
                'value'=>function($model)
                {
                    return $model->status?"<a href='#'><span class='label label-primary'>Active</span></a>":"<a href='#'><span class='label label-danger'>Inactive</span></a>";
                },
            ],
            'created:date',
            'updated:date',
        ],
    ]) ?>

</div>
