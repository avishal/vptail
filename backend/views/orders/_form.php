<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Customers;
use common\models\TailorUsers;
/* @var $this yii\web\View */
/* @var $model common\models\Orders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php 
    $tailors=TailorUsers::find()->all();
    $listData=ArrayHelper::map($tailors,'id',
    function($model) {
        return $model['firstname'].' '.$model['lastname'];
    });
    echo $form->field($model, 'tailorid')->dropDownList(
            $listData,
            ['prompt'=>'Select Tailor...']
            );
    ?>

<?php ;
    $customers=Customers::find()->all();
    $listData=ArrayHelper::map($customers,'id',
    function($model) {
        return $model['firstname'].' '.$model['lastname'];
    });
    echo $form->field($model, 'customerid')->dropDownList(
            $listData,
            ['prompt'=>'Select Customer...']
            );
    ?>

    <?= $form->field($model, 'per_pant_price')->textInput() ?>

    <?= $form->field($model, 'per_shirt_price')->textInput() ?>

    <?= $form->field($model, 'pant_count')->textInput() ?>

    <?= $form->field($model, 'shirt_count')->textInput() ?>

    <?= $form->field($model, 'delivery_date')->textInput(['type'=>'date']) ?>

    <?= $form->field($model, 'status')->dropDownList(['1'=>'In Progress','2'=>'Ready','3'=>'Delivered']);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
