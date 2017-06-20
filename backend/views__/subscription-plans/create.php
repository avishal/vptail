<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SubscriptionPlans */

$this->title = 'Create Subscription Plans';
$this->params['breadcrumbs'][] = ['label' => 'Subscription Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-plans-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
