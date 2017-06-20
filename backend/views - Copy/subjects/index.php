<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SubjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subjects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <span class="label label-primary"></span>
      <?= Html::a('Create New Subjects', ['create'], ['class' => 'btn btn-success']) ?>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'classid',
            [
                'attribute' => 'classid',
                'value'=>function($data)
                {
                    return $data->class->title;
                }

            ],
            'title',
            [
              'attribute' => 'image',
              'format' =>'raw',
              'value'=>function($data) { return Html::img($data->imageurl,['alt'=>'myImage','width'=>'70']); },
            ],
            [
                'attribute'=>'status',
                'format' => 'raw',
                //'filter'=>array(0=>"Inactive",1=>"Active"),
                'filter'=>Html::activeDropDownList($searchModel, 'status', ['Inactive', 'Active'],['class'=>'form-control','prompt' => 'Both']),
                'value'=>function($model)
                {
                    //return $model->status?"<a href='#'><span class='label label-primary'>Active</span></a>":"<a href='#'><span class='label label-danger'>Inactive</span></a>";
                  if($model->status)
                      return Html::a("<span class='label label-primary'>Active</span>", ["subjects/changestatus","status"=>0,"id"=>$model->id],["class"=>"activestatus"]);
                    else
                      return Html::a("<span class='label label-danger'>Inctive</span>",["subjects/changestatus","status"=>10,"id"=>$model->id],["class"=>"activestatus"]);
                },
            ],
            // 'created',
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