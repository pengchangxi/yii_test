<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Role;

/* @var $this yii\web\View */
/* @var $model backend\models\Admins */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'options'=>['class' => 'form form-horizontal'],
    'fieldConfig' => [
        'template' => "<label class=\"form-label col-xs-4 col-sm-3\">{label}</label><div class=\"formControls col-xs-8 col-sm-9\">{input}</div>",
        'inputOptions' => ['class'=>'input-text'],
    ],
]); ?>

<?= $form->field($model, 'username',[
    'options'=>['class'=>'row cl'],
])->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'email',[
    'options'=>['class'=>'row cl'],
])->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'mobile',[
    'options'=>['class'=>'row cl'],
])->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'realname',[
    'options'=>['class'=>'row cl'],
])->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'nickname',[
    'options'=>['class'=>'row cl'],
])->textInput(['maxlength' => true]) ?>

<?php if ($model->isNewRecord){
    echo $form->field($model,'password_hash',[
        'options'=>['class'=>'row cl'],
    ])->passwordInput(['placeholder'=>'请输入密码'])->label('密码:');
}?>

<?= $form->field($model, 'role_id',[
    'options'=>['class'=>'row cl'],
    //'inputOptions'=>['class'=>'select']
])->dropDownList(
    Role::find()
        ->select(['name'])
        ->orderBy('id')
        ->indexBy('id')
        ->column(),
    ['prompt'=>'请选择...'])->label('角色:')?>

<?= $form->field($model, 'status',[
    'options'=>['class'=>'row cl'],
])->textInput() ?>


<div class="row cl">
    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => 'btn btn-primary radius']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
