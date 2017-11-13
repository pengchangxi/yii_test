<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="text-c">

    <?php $form = ActiveForm::begin([
        'options'=>['class' => 'form-inline'],
        'fieldConfig' => [
            'template' => "{label}\n{input}",
            'inputOptions' =>['class' =>'form-control input-width-medium'],
            'labelOptions' => ['class' => 'control-label' ],
        ],
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'username')->label('用户名：') ?>


    <?= $form->field($model, 'created_start')->widget(DatePicker::className(), [
        'dateFormat' => 'yyyy-MM-dd',
        //'language' => 'ru',
        'options' => ['class' => 'form-control input-width-small'],
    ])->label('申请时间:') ?>

    <?= $form->field($model,'created_end')->widget(DatePicker::className(),[
        'dateFormat' => 'yyyy-MM-dd',
        'options'=>['class'=>'form-control input-width-small'],
    ])->label('-')?>


    <div class="form-group">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
