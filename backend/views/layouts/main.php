<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use backend\assets\CommonAsset;

CommonAsset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src='//at.alicdn.com/t/font_528644_gccuayx5nqp.js'></script>
</head>
<body>
    <?php $this->beginBody() ?>
<?php if (!Yii::$app->user->isGuest) { ?>
    <div class="wrap wrapper">
        <div class='navbarDocker'>
            <?php
                echo $this->render('top');
            ?>
        </div>
        <div class='sidebarDocker'>
            <?php
                echo $this->render('left');
            ?>
        </div>
        <div class='mainDocker'>
            <?= $content ?>
        </div>
    </div>
<?php }  else {?>
    <?= $content ?>
<?php } ?>
</body>
</html>
<?php $this->endBody() ?>
<?php $this->endPage() ?>
