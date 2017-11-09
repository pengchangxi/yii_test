<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Admins */

$this->title = 'Update Admins: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admins-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
