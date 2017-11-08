<?php
use backend\assets\PopupAsset;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;


/* @var $this \yii\web\View */
/* @var $content string */
PopupAsset::register($this);

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body >
    <?php $this->beginBody() ?>
    <article class="page-container">
        <?= $content?>
    </article>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>