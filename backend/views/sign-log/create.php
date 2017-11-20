<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SignLog */

$this->title = 'Create Sign Log';
$this->params['breadcrumbs'][] = ['label' => 'Sign Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sign-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
