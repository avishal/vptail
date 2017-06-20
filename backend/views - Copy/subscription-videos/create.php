<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SubscriptionVideos */

$this->title = 'Create Subscription Videos';
$this->params['breadcrumbs'][] = ['label' => 'Subscription Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-videos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
