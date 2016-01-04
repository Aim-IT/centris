<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AddendaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="addenda-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'NO_INSCRIPTION') ?>

    <?= $form->field($model, 'NO_ADDENDA') ?>

    <?= $form->field($model, 'CODE_LANGUE') ?>

    <?= $form->field($model, 'ORDRE_AFFICHAGE') ?>

    <?php // echo $form->field($model, 'CHAMP_INUTILISE_1') ?>

    <?php // echo $form->field($model, 'CHAMP_INUTILISE_2') ?>

    <?php // echo $form->field($model, 'TEXTE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
