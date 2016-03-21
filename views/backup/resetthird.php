<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 2016/3/20 0020
 * Time: 13:27
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '重置密码';
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
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'verifyPassword')->passwordInput() ?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('确认', ['class' => 'btn btn-primary', 'name' => 'reset-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>