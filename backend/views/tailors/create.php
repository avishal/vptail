<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TailorUsers */

$this->title = 'Create Tailor Users';
$this->params['breadcrumbs'][] = ['label' => 'Tailor Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tailor-users-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
