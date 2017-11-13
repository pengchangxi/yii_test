<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Menu;
use common\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin([
        'options'=>['class' => 'form form-horizontal'],
        'fieldConfig' => [
            'template' => "<label class=\"form-label col-xs-4 col-sm-3\">{label}</label><div class=\"formControls col-xs-8 col-sm-9\">{input}</div>",
            'inputOptions' => ['class'=>'input-text'],
        ],
    ]); ?>

    <?= $form->field($model, 'title',[
        'options'=>['class'=>'row cl'],
    ])->textInput(['maxlength' => true])->label('节点名称：') ?>

    <?= $form->field($model, 'pid',[
        'options'=>['class'=>'row cl'],
    ])->dropDownList(
        ArrayHelper::merge(['0'=>'顶级节点'],ArrayHelper::listDataLevel( \backend\models\Menu::find()->asArray()->all(), 'id', 'title','id','pid'))
        )->label('上级节点：') ?>

    <?= $form->field($model, 'url',[
        'options'=>['class'=>'row cl'],
    ])->textInput(['maxlength' => true,'placeholder'=>'请输入URL...类似于/controller/action'])->label('Url：') ?>

    <?= $form->field($model, 'remark',[
        'options'=>['class'=>'row cl'],
        'inputOptions'=>['class'=>'textarea'],
    ])->textarea(['rows'=>'3'])->label('备注：') ?>

    <?= $form->field($model, 'sort',[
        'options'=>['class'=>'row cl'],
        'inputOptions'=>['type'=>'number','min'=>"1"],
    ])->textInput() ?>

    <?php if ($model->isNewRecord)$model->status = 1 ?> <!--当为新增时默认选中1-->
    <?= $form->field($model, 'status',[
        'options'=>['class'=>'row cl'],
    ])->radioList(['1'=>'启用','0'=>'禁用'])->label('状态：') ?>

    <?php if ($model->isNewRecord)$model->ismenu = 1 ?>
    <?= $form->field($model, 'ismenu',[
        'options'=>['class'=>'row cl'],
    ])->radioList(['1'=>'是','0'=>'否'])->label('是否菜单：') ?>

    <?php if ($model->isNewRecord)$model->islog = 1 ?>
    <?= $form->field($model, 'islog',[
        'options'=>['class'=>'row cl'],
    ])->radioList(['1'=>'是','0'=>'否'])->label('是否日志：') ?>

    <div class="row cl">
        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => 'btn btn-primary radius']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
