<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StudentTests */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-tests-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'studentid')->textInput() ?>

    <?= $form->field($model, 'testid')->textInput() ?>

    <?= $form->field($model, 'questionid')->textInput() ?>

    <?= $form->field($model, 'selectedoption')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correctanswer')->dropDownList([ 'yes' => 'Yes', 'no' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'updated')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
