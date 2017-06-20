<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Fcmdevices */

$this->title = 'Create Fcmdevices';
$this->params['breadcrumbs'][] = ['label' => 'Fcmdevices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fcmdevices-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
