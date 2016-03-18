<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 2016/3/13 0013
 * Time: 20:41
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <p>Please fill out the following fields to register:</p>
    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'phone') ?>
    <?= Html::button('发送验证码',['id'=> 'smsbutton'])?>
    <?= $form->field($model ,'smsVerifyCode') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'verifyPassword')->passwordInput() ?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('register', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    $js = <<<JS
    var count = 10;
    var myCountDown;
    $(function(){
       $("#smsbutton").click(function(){
            if($("#merchantuser-phone").val().match(/^1[0-9]{10}$/))
            {
                postmsm();
                myCountDown = setInterval(countDown,1000);
            }


       });

    });
    function postmsm(){
            //alert($("#merchantuser-phone").val());
            $.post("/basic/web/index.php?r=backup/sms",
                {num:$("#merchantuser-phone").val()},
                function(data){
                    $("#merchantuser-smsverifycode").val(data);
                }
            );
            //alert();
    }
    function countDown(){
       count--;
       $("#smsbutton").attr("disabled",true);
       $("#smsbutton").text("请稍等 "+ count +" 秒！");
       if(count==0){
           $("#smsbutton").text("发送到手机").removeAttr("disabled");
           clearInterval(myCountDown);
           count = 10;
            }
    }

JS;
    $this->registerJs($js);
?>



