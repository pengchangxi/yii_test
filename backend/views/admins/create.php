<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Admins */

$this->title = 'Create Admins';
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admins-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
