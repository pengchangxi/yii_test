<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\RoleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="text-c">

    <?php $form = ActiveForm::begin([
        'options'=>['class' => 'form-inline','style'=>'margin-top:50px'],
        'fieldConfig' => [
            'template' => "{label}\n{input}",
            'inputOptions' =>['class' =>'form-control input-width-medium'],
            'labelOptions' => ['class' => 'control-label' ],
        ],
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'name')->label('角色名称：') ?>

    <?= $form->field($model, 'status')->dropDownList(
        ['1'=>'启用','0'=>'禁用'],
        ['prompt' => '请选择...']
    )->label('状态：') ?>


    <div class="form-group">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
