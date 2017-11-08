<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Role */

$this->title = 'Update Role: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="role-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
