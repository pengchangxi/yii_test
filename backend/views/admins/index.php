<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdminsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-container">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="cl pd-5 bg-1 bk-gray mt-20" style="margin-bottom: 6px"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="show('添加','create','800','700')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加</a></span> <!--<span class="r">共有数据：<strong>54</strong> 条</span>--> </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary'=>'',
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],//序号
            [
                'class' => 'yii\grid\CheckboxColumn',
                'contentOptions'=>['width'=>'34px'],
            ],//checkbox

            'id',
            'username',
            [
                'attribute'=>'role_id',
                'value'=>'role.name',
            ],
            'realname',
            'mobile',
            'email:email',
            //'created_at',
            [
                'attribute' => 'created_at',
                'label'=>'添加时间',
                'value'=> function($model){
                        return  date('Y-m-d H:i:s',$model->created_at);   //主要通过此种方式实现
                    },
            ],
            [
                'attribute' => 'status',
                'label' => '状态',
                'value' =>function($model){
                    return $model['status'] == 1 ? '启用' : '停用';
                },
            ],

            // 'updated_at',
            // 'last_login_ip',
            // 'last_login_time',
            // 'errornum',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template'=>'{update} {delete}',
                'buttons'=>[
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="Hui-iconfont">&#xe6df;</i>编辑', 'javascript:;', [
                            'title'=>'编辑',
                            'onclick'=>"show('编辑','".Url::toRoute(['admins/update', 'id' => $model["id"]])."','','510')",
                            'data-method' => 'post',
                            'data-pjax'=>'0']);
                    },
                    'delete'=> function ($url, $model, $key){
                        return  Html::a('<i class="Hui-iconfont">&#xe6e2;</i>删除', 'javascript:;',[
                            'title'=>'删除',
                            'onclick'=>"del(this,'".Url::toRoute(['admins/delete', 'id' => $model["id"]])."')" ,
                            'data-method'=>'post',              //POST传值
                        ] ) ;
                    },
                ]
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
