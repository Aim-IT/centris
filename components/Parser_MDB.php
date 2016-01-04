<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.12.2015
 * Time: 15:47
 */

namespace app\components;

use PDO;

class Parser_MDB {

    public function readMdb($dbName = 'D:\OpenServer\domains\yii-basic\uploads\unpack_files\V2.3-SIIQ ENG.mdb') {

        if (!file_exists($dbName)) {
            die("Could not find database file.");
        }
        $db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=;");
        $sql  = "SELECT * FROM REGIONS";

        $result = $db->query($sql);


        $result = $db->query($sql);
        $row = $result->fetch();
        echo '<pre>'; var_dump($row); echo '</pre>'; exit();
        while ($row = $result->fetch()) {
            echo $row["DESCRIPTION_FRANCAISE"] . 'zzzzz' . $row["DESCRIPTION_ANGLAISE"]. '<br/>';
        }
        exit();
    }
}

/*insert into [МояТаблица] (Поле1, Поле2)
select * from
(select top 1 "абвгд" as Поле1, 123 as Поле2 from msysobjects
union all
select top 1 "еёжзикл", 987 from msysobjects
union all
select top 1 "мнопрст", 3500 from msysobjects)*/