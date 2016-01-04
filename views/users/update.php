<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ApiUsers */

$this->title = 'Update Users: ' . ' ' . $model->login;
$this->params['breadcrumbs'][] = ['label' => 'Api Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="api-users-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'pass' => false,
    ]) ?>

</div>
