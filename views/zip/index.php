<?php
/* @var $this yii\web\View */
use yii\helpers\html;
use yii\helpers\Url;
?>
<h1>Data Base</h1>
<p>
    <a href="<?= Url::toRoute('zip/get-zip') ?>">
        <?= HTML::button('Update data base'); ?>
    </a>
</p>
