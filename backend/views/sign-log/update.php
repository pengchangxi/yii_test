<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SignLog */

$this->title = 'Update Sign Log: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sign Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sign-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
