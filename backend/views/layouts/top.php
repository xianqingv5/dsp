<?php
use yii\helpers\Url;
?>
<input name="dsp_security_param" id="spp_security" type="hidden"  value="<?= Yii::$app->request->csrfToken ?>">
<div class='flex jc-btween h100'>
  <a href='index' class='navLeft flex'>
    <img src="/images/new_login_logo.png" alt="">
  </a>
  <div class='flex'>
    <a class='flex' href="">
      <span><?php echo Yii::$app->user->identity->email?></span>
      <span class='userIcon'>
        <svg class="icon" aria-hidden="true">
          <use xlink:href="#icon-yonghu"></use>
        </svg>
      </span>
    </a>
    <a class='signOut' id="login_out" href="javascript:;" data-url="<?= Url::to('/site/logout') ?>">Sign Out</a>
  </div>
</div>
<?php
$js = <<<JS
    $('#login_out').click(function(){
        var url = $(this).attr('data-url');
        var _csrf = $('#spp_security').val();
      
        $.ajax({
              type        : 'POST',
              url         : url,
              async       : false,
              data        : {dsp_security_param:_csrf},
              dataType    : 'json',
              success     : function (data){
                  if (data.state == 1){
                      window.location.href= url;
                  }
              }
        });
    });
JS;
$this->registerJs($js);
?>