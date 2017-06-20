<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\SubjectChapters;

/* @var $this yii\web\View */
/* @var $model common\models\Videos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="videos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $chapterlist = SubjectChapters::findAll(['status' => 10]);?>
        <?= $form->field($model, 'chapterid')->dropDownList(ArrayHelper::map($chapterlist,'id','title')) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isfree')->checkbox(['value'=>10]) ?>

    <?= $form->field($model, 'status')->checkbox(['value'=>10]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
