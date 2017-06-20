<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Classes;
/* @var $this yii\web\View */
/* @var $model common\models\SubscriptionPlans */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subscription-plans-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<?php
$classlist = Classes::findAll(['status' => 10]);
?>
    <?= $form->field($subscriptionCourseModel, 'classid')->dropDownList(ArrayHelper::map($classlist, 'id','title')) ?>
    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'special_price')->textInput() ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
