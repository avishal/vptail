<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TestQuestionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Questions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-questions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Test Questions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'testid',
            'question:ntext',
            'first_option',
            'second_option',
            // 'third_option',
            // 'fourth_option',
            // 'fifth_option',
            // 'sixth_option',
            // 'answer',
            // 'solution:ntext',
            // 'status',
            [
                'attribute'=>'status',
                'format' => 'raw',
                //'filter'=>array(0=>"Inactive",1=>"Active"),
                'filter'=>Html::activeDropDownList($searchModel, 'status', ['Inactive', 'Active'],['class'=>'form-control','prompt' => 'Both']),
                'value'=>function($model)
                {
                    //return $model->status?"<a href='#' class='deactivateitem' data-item='".$model->id."'><span class='label label-primary'>Active</span></a>":"<a href='#' class='activateitem' data-item='".$model->id."'><span class='label label-danger'>Inactive</span></a>";
                    if($model->status)
                      return Html::a("<span class='label label-primary'>Active</span>", ["test-questions/changestatus","status"=>0,"id"=>$model->id],["class"=>"activestatus"]);
                    else
                      return Html::a("<span class='label label-danger'>Inctive</span>",["test-questions/changestatus","status"=>10,"id"=>$model->id],["class"=>"activestatus"]);
                },
            ],
            // 'created',
            // 'updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
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