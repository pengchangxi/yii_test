<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\JsBlock;


/* @var $this yii\web\View */
/* @var $model backend\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'options'=>['class' => 'form form-horizontal'],
    'fieldConfig' => [
        'template' => "<label class=\"form-label col-xs-4 col-sm-3\">{label}</label><div class=\"formControls col-xs-8 col-sm-9\">{input}</div>",
        'inputOptions' => ['class'=>'input-text'],
    ],
]); ?>

<?= $form->field($model, 'name',[
    'options'=>['class'=>'row cl'],
])->textInput(['placeholder'=>'角色名称'])->label('角色名称：') ?>

<?php if ($model->isNewRecord)$model->status = 1 ?> <!--当为新增时默认选中1-->
<?= $form->field($model, 'status',[
    'options'=>['class'=>'row cl'],
])->radioList(['1'=>'启用','0'=>'禁用'])->label('状态：') ?>

<?= $form->field($model, 'desc',[
    'options'=>['class'=>'row cl'],
    'inputOptions'=>['class'=>'textarea'],
])->textarea(['rows'=>'3'])->label('备注：') ?>

<div class="row cl">
    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => 'btn btn-primary radius']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<?php JsBlock::begin() ?>
<script>
    $(function () {

    })
</script>
<script>
    $(function () {
        $('form#w0').on('beforeSubmit', function (e) {
            var $form = $(this);
            $.ajax({
                url: $form.attr('action'),
                type: 'post',
                data: $form.serialize(),
                success: function (data) {
                    if(data.code==false){
                        layer.msg(data.message,{icon:2,time:1000});
                        return false;
                    }
                    layer.msg(data.message,{icon:1,time:1000});
                    setTimeout(function(){
                        parent.window.location.href=data.url;
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    }, 1000);
                }
            });
        }).on('submit', function (e) {
            e.preventDefault();
        });
    });
</script>
<?php JsBlock::end() ?>





