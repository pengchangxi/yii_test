<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-container">


    <div class="cl pd-5 bg-1 bk-gray mt-20" style="margin-bottom: 6px">
        <span class="l">
            <a href="javascript:;" onclick="show('添加','create','800','600')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加
            </a>
        </span>
        <!--<span class="r">共有数据：<strong>54</strong> 条</span>-->
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' =>'',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'url:url',
            'title',
            'icon',
            'status',
            // 'remark',
            // 'sort',
            // 'pid',
            // 'level',
            // 'ismenu',
            // 'islog',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' =>'操作',
                'template' =>'{update} {delete}',
                'buttons' =>[
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="Hui-iconfont">&#xe6df;</i>编辑', 'javascript:;', [
                            'title'=>'编辑',
                            'onclick'=>"show('编辑','".Url::toRoute(['menu/update', 'id' => $model["id"]])."','800','600')",
                            'data-method' => 'post',
                            'data-pjax'=>'0']);
                    },
                    'delete'=> function ($url, $model, $key){
                        return  Html::a('<i class="Hui-iconfont">&#xe6e2;</i>删除', 'javascript:;',[
                            'title'=>'删除',
                            'onclick'=>"del(this,'".Url::toRoute(['menu/delete', 'id' => $model["id"]])."')" ,
                            'data-method'=>'post',              //POST传值
                        ] ) ;
                    },
                ],
            ],
        ],
    ]); ?>
</div>
<script type="text/javascript">

    function show(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*删除*/
    function del(obj,url){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                success: function(data){
                    if (data.code == true){
                        layer.msg(data.message, {icon: 1,time:1000});
                        $(obj).parents("tr").remove();
                    }else {
                        layer.alert(data.message, {icon: 2});
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                }
            });
        });
    }

</script>
