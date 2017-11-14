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
        $("form#w0").validate({
            rules:{
                name:{
                    required:true,
                    minlength:2,
                    maxlength:16
                }
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit({
                    type: 'post', // 提交方式 get/post
                    url: $(this).attr('action'), // 需要提交的 url
                    success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                        if(data.code==false){
                            layer.msg(data.message,{icon:2,time:2000});
                            return false;
                        }else {
                            layer.msg(data.message,{icon:1,time:1000});
                            setTimeout(function(){
                                parent.window.location.href=data.url;
                                var index = parent.layer.getFrameIndex(window.name);
                                parent.layer.close(index);
                            }, 1000);
                        }
                    }
                });
            }
        });
    });
</script>
<?php JsBlock::end() ?>





