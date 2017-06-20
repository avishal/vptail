<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SubscriptionCourses */

$this->title = 'Create Subscription Courses';
$this->params['breadcrumbs'][] = ['label' => 'Subscription Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-courses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
