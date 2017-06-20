<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StudentTests */

$this->title = 'Create Student Tests';
$this->params['breadcrumbs'][] = ['label' => 'Student Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-tests-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
