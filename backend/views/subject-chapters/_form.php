<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Subjects;
use common\models\Classes;

/* @var $this yii\web\View */
/* @var $model common\models\SubjectChapters */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subject-chapters-form">

    <?php $form = ActiveForm::begin();
    $subjlist = Subjects::findAll(['status' => 10]);
    $classlist = Classes::findAll(['status' => 10]);
    ?>

    <?php // $form->field($model, 'classid')->dropDownList(ArrayHelper::map($classlist, 'id', 'title'),['prompt'=>"Select class"]) ?>

    
    <div class="row">
        <div class="col-md-4">
        <?= $form->field($model, 'classid')->dropDownList(ArrayHelper::map($classlist, 'id', 'title'),['prompt'=>"Select Class",'class'=>'form-control classchange']) ?>
        </div>
        <div class="col-md-4">
        <?php if($model->isNewRecord):?>
            <?= $form->field($model, 'subjid')->dropDownList([],['prompt'=>"Select Subject"]) ?>
        <?php else:?>
            <?= $form->field($model, 'subjid')->dropDownList(ArrayHelper::map($subjlist, 'id', 'title'),['prompt'=>"Select Subject"]) ?>
        <?php endif;?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'status')->checkbox(['value'=>10])->label(""); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs("

    $('.savedata').on('click', function(e)
    {
        e.preventDefault();
        
        if($('#videos-chapterid').val()=='')
        {
            alert('Chapter is blank');

            return false;

        }
        else
        {
            $('form[name=\'uploadvdos\']').submit();
        }

    });

    $('.classchange').on('change', function (e) {
        var clsid = $(this).val();
        var url = '".Yii::$app->urlManager->createUrl(['subjects/get-subjects']). "&classid='+clsid;
      $.get(url, function(data){
        //console.log(data);
        //$('#subjectchapters-subjid').replaceWith(data);
        $('#subjectchapters-subjid').find('option').remove().end().append(data);
       
      }).done(function(){
        //alert('done');
      }).fail(function(){
        alert('fail');
      });
      });

      $('.subjchange').on('change', function (e) {
        //var clsid = $(this).val();
        var subjid = $(this).val();
        var url = '".Yii::$app->urlManager->createUrl(['subject-chapters/get-chapters']). "&subjid='+subjid;
      $.get(url, function(data){
        //console.log(data);
        //$('#videos-chapterid').replaceWith(data);
        $('#videos-chapterid').find('option').remove().end().append(data);
       
      }).done(function(){
        //alert('done');
      }).fail(function(){
        alert('fail');
      });
      });

      $('.addmore').on('click', function(){
        var titleinp = '".Html::tag('input',null, ['value'=>'', 'name'=>'Videos[title][]','class'=>'form-control'])."';

        var urlinp = '".Html::tag('input',null, ['value'=>'', 'name'=>'Videos[url][]','class'=>'form-control'])."';

        var isfreeinp = '".Html::tag('input',null, ['type'=>'checkbox','value'=>'10', 'name'=>'Videos[isfree][]'])."';

        var statusinp = '".Html::tag('input',null, ['type'=>'checkbox','value'=>'10', 'name'=>'Videos[status][]'])."';


        /*$('.multvid').append('<div class=\'row\'><div class=\'col-md-4\'>'+titleinp+'</div><div class=\'col-md-4\'>'+urlinp+'</div><div class=\'col-md-1\'>'+isfreeinp+'</div><div class=\'col-md-2\'>'+statusinp+'</div></div>');*/

        $('.multvid').append('<div class=\'row\'><div class=\'col-md-4\'>'+titleinp+'</div><div class=\'col-md-4\'>'+urlinp+'</div></div>');

      });
      ");
      
      ?> 