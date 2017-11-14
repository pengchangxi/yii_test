<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


$this->title = '登录';
?>
<?php

$form = ActiveForm::begin([
    'options'=>['class' => 'form form-horizontal'],
    'action' => ['site/login'], 'method'=>'post',]);
?>

<?= $form->field($model,'username',[
    'options'=>['class'=>'row cl'],
    'template'=>'<label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label><div class="formControls col-xs-4">{input}</div><div class="formControls col-xs-4">{error}</div>',
    'inputOptions' => ['class'=>'input-text size-L'],
])->textInput(['placeholder'=>'用户名'])->label(false)?>

<?= $form->field($model,'password',[
    'options'=>['class'=>'row cl'],
    'template'=>'<label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label><div class="formControls col-xs-4">{input}</div><div class="formControls col-xs-4">{error}</div>',
    'inputOptions' => ['class'=>'input-text size-L']
])->passwordInput(['placeholder'=>'密码'])->label(false)?>

<?= $form->field($model,'verifyCode',[
    'options'=>['class'=>'row cl'],
])->widget(Captcha::className(), [
    'options'=>['class'=>'input-text size-L','style'=>'width:100px'],
    'template' => '<div class="formControls col-xs-5 col-xs-offset-3">{input}{image}</div>',
])->label(false) ?>

<?= $form->field($model,'rememberMe',[
    'options'=>['class'=>'row cl'],
    'template'=>'<div class="formControls col-xs-8 col-xs-offset-3"><label for="online"><input type="checkbox" name="online" id="online" value="">使我保持登录状态</label></div>'
])?>

<div class="row cl">
    <div class="formControls col-xs-8 col-xs-offset-3">
        <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
        <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
    </div>
</div>

<?php ActiveForm::end() ?>
