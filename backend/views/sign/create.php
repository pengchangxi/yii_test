<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Sign */

$this->title = 'Create Sign';
$this->params['breadcrumbs'][] = ['label' => 'Signs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sign-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
