<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SmsCodes */

$this->title = 'Create Sms Codes';
$this->params['breadcrumbs'][] = ['label' => 'Sms Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-codes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
