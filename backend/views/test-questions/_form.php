<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\TblTest;
/* @var $this yii\web\View */
/* @var $model common\models\TestQuestions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-questions-form">

    <?php $form = ActiveForm::begin(); 

    $tests = TblTest::findAll(['status'=>10]);
    ?>

    <?= $form->field($model, 'testid')->dropDownList(ArrayHelper::map($tests, 'id', 'title')) ?>

    <?= $form->field($model, 'question')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'first_option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'second_option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'third_option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fourth_option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fifth_option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sixth_option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'answer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'solution')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->checkbox(['value'=>10]) ?>

    <?php // $form->field($model, 'created')->textInput() ?>

    <?php // $form->field($model, 'updated')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
