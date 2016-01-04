<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AddendaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Addendas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="addenda-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Addenda', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'NO_INSCRIPTION:ntext',
            'NO_ADDENDA',
            'CODE_LANGUE:ntext',
            'ORDRE_AFFICHAGE',
            // 'CHAMP_INUTILISE_1:ntext',
            // 'CHAMP_INUTILISE_2:ntext',
            // 'TEXTE:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
