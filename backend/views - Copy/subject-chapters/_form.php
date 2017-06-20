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

            <?= $form->field($model, 'subjid')->dropDownList(ArrayHelper::map($subjlist, 'id', 'title'),['prompt'=>"Select Subject"]) ?>
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
