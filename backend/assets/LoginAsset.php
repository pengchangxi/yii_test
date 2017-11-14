<?php

namespace backend\assets;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'static/h-ui/css/H-ui.min.css',
        'static/h-ui.admin/css/H-ui.login.css',
        'static/h-ui.admin/css/style.css',
        'lib/Hui-iconfont/1.0.8/iconfont.css',

    ];

    public $js = [
        'lib/html5shiv.js',
        'lib/respond.min.js',
        'lib/layer/2.4/layer.js',
        'static/h-ui/js/H-ui.min.js'

    ];


}

