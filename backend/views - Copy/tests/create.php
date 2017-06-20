<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TblTest */

$this->title = 'Create Tbl Test';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-test-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
