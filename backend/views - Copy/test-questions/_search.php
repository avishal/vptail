<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TestQuestionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-questions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'testid') ?>

    <?= $form->field($model, 'question') ?>

    <?= $form->field($model, 'first_option') ?>

    <?= $form->field($model, 'second_option') ?>

    <?php // echo $form->field($model, 'third_option') ?>

    <?php // echo $form->field($model, 'fourth_option') ?>

    <?php // echo $form->field($model, 'fifth_option') ?>

    <?php // echo $form->field($model, 'sixth_option') ?>

    <?php // echo $form->field($model, 'answer') ?>

    <?php // echo $form->field($model, 'solution') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
