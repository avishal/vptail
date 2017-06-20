<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StudentSubscription */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-subscription-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'studentid')->textInput() ?>

    <?= $form->field($model, 'subscriptionid')->textInput() ?>

    <?= $form->field($model, 'starttime')->textInput() ?>

    <?= $form->field($model, 'endtime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
