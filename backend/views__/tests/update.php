<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TblTest */

$this->title = 'Update Tbl Test: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-test-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
