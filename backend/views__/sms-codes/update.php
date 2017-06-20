<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SmsCodes */

$this->title = 'Update Sms Codes: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sms Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sms-codes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
