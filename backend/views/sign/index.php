<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Signs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-container">

    <p>
        <?= Html::a('签到', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'uid',
            'sign_count',
            'last_sign_time:datetime',
            'sign_history:ntext',

        ],
    ]); ?>
</div>
