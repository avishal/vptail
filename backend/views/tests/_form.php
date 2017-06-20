<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Classes;
use common\models\Subjects;
use common\models\SubjectChapters;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\TblTest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-test-form">

    <?php $form = ActiveForm::begin(); 

    $classlist = Classes::findAll(['status' => 10]);
    $subjlist = Subjects::findAll(['status' => 10]);

    $chapterlist = SubjectChapters::findAll(['status' => 10]);
    ?>

    <div class="row">
    <div class="col-md-4">
        <?php
        $classlist = Classes::findAll(['status' => 10]);
         //echo Html::label("Class");
        echo $form->field($model, 'classid')->dropDownList(ArrayHelper::map($classlist, 'id', 'title'),['prompt'=>"Select class", 'class'=>'classchange form-control']);

        $subjlist = Subjects::findAll(['status' => 10]);
        ?>
        </div>
        <div class="col-md-4">
        <?php
        //echo Html::label("Subjects");
        echo  $form->field($model, 'subjid')->dropDownList( [],['id'=>'videos-subjid','prompt'=>"Select Subject",'class'=>'form-control subjchange']); ?>

        <?php // Html::dropDownList('subjid', null, ArrayHelper::map($subjlist, 'id', 'title'),['prompt'=>"Select Subject"]) ?>
    </div>
    <div class="col-md-4">
        <?php
        //echo $form->dropDownList($model, 'chapterid', null, [],['id'=>'videos-chapterid','prompt'=>"Select Chapter",'class'=>'form-control']);

        echo $form->field($model, 'chapterid')->dropDownList([],['prompt'=>"Select Chapter",'class'=>'form-control']); ?>
         
    </div>
    </div>
<div class="row">
<div class="col-md-12">
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
</div>
</div>
    <?php // $form->field($model, 'classid')->textInput() ?>

    <?php // $form->field($model, 'subjid')->textInput() ?>

    <?php // $form->field($model, 'chapterid')->textInput() ?>

<div class="row">
<div class="col-md-12">
    <?= $form->field($model, 'allotedtime')->textInput()->label("Alloted Time (in Minutes)") ?>
</div>
</div>
<div class="row">
<div class="col-md-12">
    <?= $form->field($model, 'status')->checkbox(['value'=>10]) ?>
</div>
</div>
    <?php // $form->field($model, 'created')->textInput() ?>

    <?php // $form->field($model, 'updated')->textInput() ?>

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
        //$('#videos-subjid').replaceWith(data);
        $('#videos-subjid').find('option').remove().end().append(data);
       
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
        $('#tbltest-chapterid').find('option').remove().end().append(data);
       
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