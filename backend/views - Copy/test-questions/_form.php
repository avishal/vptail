<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TestQuestions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-questions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'testid')->textInput() ?>

    <?= $form->field($model, 'question')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'first_option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'second_option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'third_option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fourth_option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fifth_option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sixth_option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'answer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'solution')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'updated')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
