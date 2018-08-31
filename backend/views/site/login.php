<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='check_language'>
        <a id='en_us' href="<?php echo Yii::$app->urlManager->createUrl(['/base/language','lang'=>'en']);?>">English</a>
        <span>|</span>
        <a id='ja' href="<?php echo Yii::$app->urlManager->createUrl(['/base/language','lang'=>'ja-JP']);?>">日本語</a>
        <span>|</span>
        <a id='zh_cn' href="<?php echo Yii::$app->urlManager->createUrl(['/base/language','lang'=>'zh-CN']);?>">中文</a>
    </div>
    <div class='full flex'>
        <div class="site-login">
            <a href='index' class='w100 imgBox flex mb-20'>
                <img src="/images/new_login_logo.png" alt="">
            </a>
            <p>Effectively improve your revenue</p>

            <div class="col-auto-24 pb-40">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'w100 btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

