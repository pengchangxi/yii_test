<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\JsBlock;


/* @var $this yii\web\View */
/* @var $model backend\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'id' => 'role_authorize',
    'options'=>['class' => 'form form-horizontal'],

]); ?>
    <article class="cl pd-20">
        <form class="form form-horizontal pd-20" id="form-role_allocation" method="post">
            <input type="hidden" name="roleId" value="{$roleId ? $roleId : ''}"/>
            <table class="table table-border table-bordered table-bg" id="dnd-example">
                <tbody>
                <?= $category?>
                </tbody>
            </table>
            <div class="row cl">
                <div class="col-10 ">
                    <button type="submit" class="btn btn-success radius" id="admin-role-save" name="dosubmit"><i class="icon-ok"></i> 确定</button>
                </div>
            </div>
        </form>
    </article>
<?php ActiveForm::end(); ?>

<?php JsBlock::begin() ?>
<script>
    $(document).ready(function() {
        $("#dnd-example").treeTable({
            indent: 20
        });
        $('.expanded').trigger('click');
    });
    function checknode(obj) {
        var chk = $("input[type='checkbox']");
        var count = chk.length;

        var num = chk.index(obj);
        var level_top = level_bottom = chk.eq(num).attr('level');
        for (var i = num; i >= 0; i--) {
            var le = chk.eq(i).attr('level');
            if (le <level_top) {
                chk.eq(i).prop("checked", true);
                var level_top = level_top - 1;
            }
        }
        for (var j = num + 1; j < count; j++) {
            var le = chk.eq(j).attr('level');
            if (chk.eq(num).prop("checked")) {

                if (le > level_bottom){
                    chk.eq(j).prop("checked", true);
                }
                else if (le == level_bottom){
                    break;
                }
            } else {
                if (le >level_bottom){
                    chk.eq(j).prop("checked", false);
                }else if(le == level_bottom){
                    break;
                }
            }
        }
    }

    $("#role_authorize").validate({
        onkeyup:false,
        focusCleanup:true,
        success:"valid",
        submitHandler:function(form){
            $(form).ajaxSubmit({
                type: 'post', // 提交方式 get/post
                url: $(this).attr('action'), // 需要提交的 url
                success: function(data) { // data 保存提交后返回的数据
                    if(data.code==false){
                        layer.msg(data.message,{icon:2,time:1000});
                        return false;
                    }
                    parent.layer.msg(data.message,{icon:1,time:1000});
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                }
            });
        }
    });
</script>
<?php JsBlock::end() ?>
