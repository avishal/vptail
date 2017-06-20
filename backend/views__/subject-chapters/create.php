<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SubjectChapters */

$this->title = 'Create Subject Chapters';
$this->params['breadcrumbs'][] = ['label' => 'Subject Chapters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-chapters-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
