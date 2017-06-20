<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StudentTestsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-tests-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'studentid') ?>

    <?= $form->field($model, 'testid') ?>

    <?= $form->field($model, 'questionid') ?>

    <?= $form->field($model, 'selectedoption') ?>

    <?php // echo $form->field($model, 'correctanswer') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
