<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SubscriptionCourses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subscription-courses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'classid')->textInput() ?>

    <?= $form->field($model, 'subscriptionid')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'updated')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
