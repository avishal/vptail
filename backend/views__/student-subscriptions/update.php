<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StudentSubscription */

$this->title = 'Update Student Subscription: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Subscriptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <span class="label label-primary"></span>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

  </div>
</div>