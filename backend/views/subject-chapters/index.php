<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Subjects;
use common\models\Classes;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SubjectChaptersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subject Chapters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <span class="label label-primary"></span>
      <?= Html::a('Create New Chapters', ['create'], ['class' => 'btn btn-success']) ?>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'classid',
                'filter'=>Html::activeDropDownList($searchModel, 'classid', ArrayHelper::map(Classes::find()->all(),'id','title'),['class'=>'form-control','prompt' => 'All']),
                'value'=> function($model)
                {
                    return $model->class->title;
                }
            ],
            [
                'attribute'=>'subjid',
                'filter'=>Html::activeDropDownList($searchModel, 'subjid', ArrayHelper::map(Subjects::find()->all(),'id','title'),['class'=>'form-control','prompt' => 'All']),
                'value'=> function($model)
                {
                    return $model->subj->title;
                }
            ],
            'title',
            [
                'attribute'=>'status',
                'format' => 'raw',
                //'filter'=>array(0=>"Inactive",1=>"Active"),
                'filter'=>Html::activeDropDownList($searchModel, 'status', ['Inactive', 'Active'],['class'=>'form-control','prompt' => 'Both']),
                'value'=>function($model)
                {
                    //return $model->status?"<a href='#'><span class='label label-primary'>Active</span></a>":"<a href='#'><span class='label label-danger'>Inactive</span></a>";
                    if($model->status)
                      return Html::a("<span class='label label-primary'>Active</span>", ["subject-chapters/changestatus","status"=>0,"id"=>$model->id],["class"=>"activestatus"]);
                    else
                      return Html::a("<span class='label label-danger'>Inctive</span>",["subject-chapters/changestatus","status"=>10,"id"=>$model->id],["class"=>"activestatus"]);
                },
            ],
            //'created',
            // 'updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
<?php
$this->registerJs("

    $('.activestatus').click(function (e) {
      e.preventDefault();
      var url = $(this).attr('href');
      
      $.get(url, function(data){
        //alert('success');
        if(data==1)
        {
          location.reload();
        }
      }).done(function(){
        //alert('done');
      }).fail(function(){
        alert('fail');
      });
      });"
      );
      ?> 