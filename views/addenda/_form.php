<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Addenda */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="addenda-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'NO_INSCRIPTION')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'NO_ADDENDA')->textInput() ?>

    <?= $form->field($model, 'CODE_LANGUE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ORDRE_AFFICHAGE')->textInput() ?>

    <?= $form->field($model, 'CHAMP_INUTILISE_1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CHAMP_INUTILISE_2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'TEXTE')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
