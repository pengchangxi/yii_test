<?php

namespace backend\assets;

use yii\web\AssetBundle;

class PopupAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'static/h-ui/css/H-ui.min.css',
        'static/h-ui.admin/css/H-ui.admin.css',
        'lib/Hui-iconfont/1.0.8/iconfont.css',
        'static/h-ui.admin/skin/default/skin.css',
        'static/h-ui.admin/css/style.css',

    ];

    public $js = [
        'lib/html5shiv.js',
        'lib/respond.min.js',
        //'lib/jquery/1.9.1/jquery.min.js',
        'lib/layer/2.4/layer.js',
        'static/h-ui/js/H-ui.min.js',
        'static/h-ui.admin/js/H-ui.admin.js',
        'lib/jquery.validation/1.14.0/jquery.validate.js',
        'lib/jquery.validation/1.14.0/validate-methods.js',
        'lib/jquery.validation/1.14.0/messages_zh.js',

    ];


}

