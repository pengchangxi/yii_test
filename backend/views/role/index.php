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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="text-c"> 日期范围：
        <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
        -
        <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
        <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="">
        <button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20" style="margin-bottom: 6px"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="show('添加管理员','create','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> <!--<span class="r">共有数据：<strong>54</strong> 条</span>--> </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,//搜索框
        'summary'=>'',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'status',
            'desc',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{update} {delete}',
                'buttons'=>[
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="Hui-iconfont">&#xe6df;</i>编辑', 'javascript:;', [
                            'title'=>'编辑',
                            'onclick'=>"show('菜单编辑','".Url::toRoute(['role/update', 'id' => $model["id"]])."','','510')",
                            'data-method' => 'post',
                            'data-pjax'=>'0']);
                    },
                    'delete'=> function ($url, $model, $key){
                        return  Html::a('<i class="Hui-iconfont">&#xe6e2;</i>删除', 'javascript:;',[
                            'title'=>'删除',
                            'onclick'=>"del(this,'".Url::toRoute(['role/delete', 'id' => $model["id"]])."')" ,
                            'data-method'=>'post',              //POST传值
                        ] ) ;
                    },
                ],

            ],
        ],
    ]); ?>
</div>

<script type="text/javascript">
    /*
     参数解释：
     title	标题
     url		请求的url
     w		弹出层宽度（缺省调默认值）
     h		弹出层高度（缺省调默认值）
     */
    /*增加-编辑*/
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
                    if (data.code == 1){
                        layer.msg(data.msg, {icon: 1,time:1000});
                        $(obj).parents("tr").remove();
                    }else {
                        layer.alert(data.msg, {icon: 2});
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }

    /*管理员-编辑*/
    function admin_edit(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
    /*管理员-停用*/
    function admin_stop(obj,id){
        layer.confirm('确认要停用吗？',function(index){
            //此处请求后台程序，下方是成功后的前台处理……

            $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,id)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
            $(obj).remove();
            layer.msg('已停用!',{icon: 5,time:1000});
        });
    }

    /*管理员-启用*/
    function admin_start(obj,id){
        layer.confirm('确认要启用吗？',function(index){
            //此处请求后台程序，下方是成功后的前台处理……


            $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,id)" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
            $(obj).remove();
            layer.msg('已启用!', {icon: 6,time:1000});
        });
    }
</script>
