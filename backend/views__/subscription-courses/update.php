<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SubscriptionCourses */

$this->title = 'Update Subscription Courses: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Subscription Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subscription-courses-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
