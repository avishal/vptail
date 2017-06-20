<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Classes;
use common\models\Subjects;

/* @var $this yii\web\View */
/* @var $model common\models\Videos */
/* @var $form ActiveForm */
?>
<div class="videos-videoupload">

    <?php $form = ActiveForm::begin(['options' =>['name'=>'uploadvdos']]); ?>

    <div class="row">
    <div class="col-md-4">
    	<?php
    	$classlist = Classes::findAll(['status' => 10]);
    	 echo Html::label("Class");
    	echo Html::dropDownList('classid', null, ArrayHelper::map($classlist, 'id', 'title'),['prompt'=>"Select class", 'class'=>'classchange form-control']);

    	$subjlist = Subjects::findAll(['status' => 10]);
    	?>
    	</div>
    	<div class="col-md-4">
    	<?php
    	echo Html::label("Subjects");
    	echo Html::dropDownList('subjid', null, [],['id'=>'videos-subjid','prompt'=>"Select Subject",'class'=>'form-control subjchange']); ?>

    	<?php // Html::dropDownList('subjid', null, ArrayHelper::map($subjlist, 'id', 'title'),['prompt'=>"Select Subject"]) ?>
    </div>
    <div class="col-md-4">
    	<?php
    	//echo $form->dropDownList($model, 'chapterid', null, [],['id'=>'videos-chapterid','prompt'=>"Select Chapter",'class'=>'form-control']);

    	echo $form->field($model, 'chapterid')->dropDownList([],['prompt'=>"Select Chapter",'class'=>'form-control']); ?>
    	 
    </div>
    </div>
    <div class="row">
    <div class="col-md-4">
    <?= $form->field($model, 'title[]')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'url[]')->textInput(['maxlength' => true])?>
    </div>
	    <!-- <div class="col-md-1">
		<?php // $form->field($model, 'isfree[]')->checkbox(['value' => 10])?>
	    </div>
      <div class="col-md-1">
    <?php // $form->field($model, 'status[]')->checkbox(['value' => 10])?>
      </div> -->
      <div class="col-md-2">
    <?= Html::button('<span>+</span>', ['class' => 'btn btn-warning addmore']) ?>
      </div>
    </div>
    <div class="multvid">
    </div>

        <div class="form-group">
        	
            <?= Html::button('Submit', ['class' => 'btn btn-primary savedata']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- videos-videoupload -->
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