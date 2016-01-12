<?php
/* @var $this yii\web\View */
?>
<h1>Results!</h1>
<?php
if($result_upload['already']){
    foreach ($result_upload['already'] as $file){
        echo "<p>Already exists file: $file</p>";
    }
}
if($result_upload['download']){
    foreach ($result_upload['download'] as $file){
        echo "<p>file $file has been uploaded</p>";
    }
}
if($count_unpack){
    echo "<p>$count_unpack file(s) has been unpacked</p>";
}
if($insert_log){
    echo $insert_log;
}
?>
<p>
    The database was updated!
</p>
