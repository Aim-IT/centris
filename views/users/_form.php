<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ApiUsers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="api-users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

    <?= $pass ? $form->field($model, 'password')->passwordInput(['maxlength' => true]) : '' ?>

    <?= $form->field($model, 'status')->dropDownList(['1' => 'active', '0' => 'not active']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
