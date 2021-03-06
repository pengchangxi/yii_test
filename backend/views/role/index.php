<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-container">
    <div id="iframe_box" class="Hui-article" style="margin-top: 20px">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


    <div class="cl pd-5 bg-1 bk-gray mt-20" style="margin-bottom: 6px">
        <span class="l">
            <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius">
                <i class="Hui-iconfont">&#xe6e2;</i> 批量删除
            </a>
            <a href="javascript:;" onclick="show('添加','create','800','500')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加
            </a>
        </span>
        <!--<span class="r">共有数据：<strong>54</strong> 条</span>-->
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,//搜索框
        'summary'=>'',
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],//序号
            [
                'class' => 'yii\grid\CheckboxColumn',
                'contentOptions' => ['width' => '40px'],
                'checkboxOptions' => function($model, $key, $index, $column) {
                    return ['value' => $model->id];
                }
            ],//checkbox

            'id',
            'name',
            [
                'attribute' => 'status',
                'label' => '状态',
                'content' => function($model) {
                    return $model['status'] == 1 ?
                        Html::tag('span','启用',['class'=>'label label-success radius']) :
                        Html::tag('span','停用',['class'=>'label label-warning radius']);
                },
            ],
            'desc',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{authorize} {update} {delete}',
                'buttons'=>[
                    'authorize' =>function($url,$model,$key){
                    if ($model['id']==1){
                        return Html::a('<font color="gray"><i class="Hui-iconfont">&#xe63f;</i>权限设置</font>', 'javascript:;', [
                            'title'=>'权限设置',]);
                    }else{
                        return Html::a('<i class="Hui-iconfont">&#xe63f;</i>权限设置', 'javascript:;', [
                            'title'=>'权限设置',
                            'onclick'=>"show('权限设置','".Url::toRoute(['role/authorize', 'id' => $model["id"]])."','','680')",
                            'data-method' => 'post',
                            'data-pjax'=>'0']);

                        }
                    },
                    'update' => function ($url, $model, $key) {
                        if ($model['id']==1){
                            return Html::a('<font color="gray"><i class="Hui-iconfont">&#xe6df;</i>编辑</font>', 'javascript:;', [
                                'title'=>'编辑',]);
                        }else{
                            return Html::a('<i class="Hui-iconfont">&#xe6df;</i>编辑', 'javascript:;', [
                                'title'=>'编辑',
                                'onclick'=>"show('编辑','".Url::toRoute(['role/update', 'id' => $model["id"]])."','','510')",
                                'data-method' => 'post',
                                'data-pjax'=>'0']);
                        }
                    },
                    'delete'=> function ($url, $model, $key){
                        if ($model['id']==1){
                            return  Html::a('<font color="gray"><i class="Hui-iconfont">&#xe6e2;</i>删除</font>', 'javascript:;',[
                                'title'=>'删除',] ) ;
                        }else{
                            return  Html::a('<i class="Hui-iconfont">&#xe6e2;</i>删除', 'javascript:;',[
                                'title'=>'删除',
                                'onclick'=>"del(this,'".Url::toRoute(['role/delete', 'id' => $model["id"]])."')" ,
                                'data-method'=>'post',              //POST传值
                            ] ) ;
                        }
                    },
                ],

            ],
        ],
    ]); ?>
    </div>
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
