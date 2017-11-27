<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Signs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-container">

    <div class="cl pd-5 bg-1 bk-gray mt-20" style="margin-bottom: 6px">
        <span class="l">
            <a href="javascript:;" onclick="sign()" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 签到</a>
        </span>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary'=>'',
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
<script type="text/javascript">

    function sign(){
        $.ajax({
            type: 'post',
            url: '/sign/create',
            dataType: 'json',
            success: function(data){
                if (data.code == true){
                    layer.msg(data.message, {icon: 1,time:1000});
                    window.location.reload();
                }else {
                    layer.alert(data.message, {icon: 2});
                }
            },
            error:function(data) {
                console.log(data.msg);
            }
        });
    }


</script>
