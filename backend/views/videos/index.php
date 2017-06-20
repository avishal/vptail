<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use common\models\Classes;
use common\models\Subjects;
use common\models\SubjectChapters;

/* @var $this yii\web\View */
/* @var $searchModel common\models\VideosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Videos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <span class="label label-primary"></span>
      <?= Html::a('Add New Videos', ['videoupload'], ['class' => 'btn btn-success']) ?>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'classid',
            //'subjid',
            //'chapterid',
            [
                'attribute'=>'classid',
                'filter'=>Html::activeDropDownList($searchModel, 'classid', ArrayHelper::map(Classes::find()->all(),'id','title'),['class'=>'form-control','prompt' => 'All']),
                'value'=> function($model)
                {
                    return $model->class ? $model->class->title : 'not set';
                }
            ],
            [
                'attribute'=>'subjid',
                'filter'=>Html::activeDropDownList($searchModel, 'subjid', ArrayHelper::map(Subjects::find()->all(),'id','title'),['class'=>'form-control','prompt' => 'All']),
                'value'=> function($model)
                {
                    return $model->subj ? $model->subj->title : 'not set';
                }
            ],
            [
                'attribute'=>'chapterid',
                'filter'=>Html::activeDropDownList($searchModel, 'chapterid', ArrayHelper::map(SubjectChapters::find()->all(),'id','title'),['class'=>'form-control','prompt' => 'All']),
                'value'=> function($model)
                {
                    return $model->chapter->title;
                }
            ],
            
            'title',
            'url',
            //'isfree',
            //'status',
            [
                'attribute'=>'isfree',
                'format' => 'raw',
                //'filter'=>array(0=>"Inactive",1=>"Active"),
                'filter'=>Html::activeDropDownList($searchModel, 'isfree', [0=>'Free', 10=>'Paid'],['class'=>'form-control','prompt' => 'Both']),
                'value'=>function($model)
                {
                    //return $model->status?"<a href='#' class='deactivateitem' data-item='".$model->id."'><span class='label label-primary'>Active</span></a>":"<a href='#' class='activateitem' data-item='".$model->id."'><span class='label label-danger'>Inactive</span></a>";
                    if($model->isfree)
                      return Html::a("<span class='label label-primary'>Paid</span>", ["videos/changeisfreestatus","status"=>0,"id"=>$model->id],["class"=>"activestatus"]);
                    else
                      return Html::a("<span class='label label-danger'>Free</span>",["videos/changeisfreestatus","status"=>10,"id"=>$model->id],["class"=>"activestatus"]);
                },
            ],
            [
                'attribute'=>'status',
                'format' => 'raw',
                //'filter'=>array(0=>"Inactive",1=>"Active"),
                'filter'=>Html::activeDropDownList($searchModel, 'status', ['Inactive', 'Active'],['class'=>'form-control','prompt' => 'Both']),
                'value'=>function($model)
                {
                    //return $model->status?"<a href='#' class='deactivateitem' data-item='".$model->id."'><span class='label label-primary'>Active</span></a>":"<a href='#' class='activateitem' data-item='".$model->id."'><span class='label label-danger'>Inactive</span></a>";
                    if($model->status)
                      return Html::a("<span class='label label-primary'>Active</span>", ["videos/changestatus","status"=>0,"id"=>$model->id],["class"=>"activestatus"]);
                    else
                      return Html::a("<span class='label label-danger'>Inctive</span>",["classes/changestatus","status"=>10,"id"=>$model->id],["class"=>"activestatus"]);
                },
            ],
            // 'created',
            // 'updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
</div>
