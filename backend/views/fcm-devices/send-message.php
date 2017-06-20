<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Fcmdevices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fcmdevices-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <input type="text" name="title" value="SmarTG Prep" />
    <textarea name="message" col="60" row="60">1) this is a test message. 2) this is a test message. 3) this is a test message. 4) this is a test message. 5) this is a test message. </textarea>
    <input type = "file" name="imageFile" />

    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
