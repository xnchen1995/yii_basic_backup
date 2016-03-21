<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 2016/3/19 0019
 * Time: 23:09
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '验证手机';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <p>Please fill out the following fields to reset:</p>
    <?php $form = ActiveForm::begin([
        'id' => 'reset-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <?=Html::label($displayphone)?>
    <?= Html::button('发送验证码',['id'=> 'smsbutton'])?>
    <?= $form->field($model ,'resetSmsVerify') ?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('确认', ['class' => 'btn btn-primary', 'name' => 'reset-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS
    var count = 60;
    var myCountDown;
    $(function(){
       $("#smsbutton").click(function(){
                postmsm();
                myCountDown = setInterval(countDown,1000);
       });

    });
    function postmsm(){
            $.post("/basic/web/index.php?r=backup/resetpawsms",null
                ,
                function(data){
                    $("#merchantuser-resetsmsverify").val(data);
                }
            );
    }
    function countDown(){
       count--;
       $("#smsbutton").attr("disabled",true);
       $("#smsbutton").text("请稍等 "+ count +" 秒！");
       if(count==0){
           $("#smsbutton").text("发送到手机").removeAttr("disabled");
           clearInterval(myCountDown);
           count = 60;
            }
    }

JS;
$this->registerJs($js);
?>