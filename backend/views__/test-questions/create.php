<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TestQuestions */

$this->title = 'Create Test Questions';
$this->params['breadcrumbs'][] = ['label' => 'Test Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-questions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
