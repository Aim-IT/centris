<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Addenda */

$this->title = 'Create Addenda';
$this->params['breadcrumbs'][] = ['label' => 'Addendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="addenda-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
