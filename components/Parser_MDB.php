<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.12.2015
 * Time: 15:47
 */

namespace app\components;

use PDO;
use yii;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class Parser_MDB {

    public $list_tables = array();
    public $unpack_folder;

    public function __construct() {

        $this->list_tables = Yii::$app->params['list_tables'];
        $this->unpack_folder = Yii::$app->params['upload_unpack'];
    }

    public function getMdbData() {

        if (empty($this->list_tables)) {
            return [];
        }
        $data_txt = [];
        $data_files = $this->getFiles();
        foreach($this->list_tables as $table) {

            if(empty($data_files)) {
                continue;
            }
            $data_txt[$table] = [];
            foreach ($data_files as $file) {
                $access_data = $this->readMdb($file, $table);
                if($access_data) {
                    $data_txt[$table] = $data_txt[$table] + $access_data;
                }
            }
            if(empty($data_txt[$table])) {
                unset($data_txt[$table]);
            }
        }

        return $data_txt;
    }

    public function readMdb($dbName, $table) {

        if (!file_exists($dbName)) {
            die("Could not find database file.");
        }
        $db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=;");
        $sql  = "SELECT * FROM $table";
        $result = $db->query($sql);
        $row_ar = [];
        if($result){
            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $row_ar[] = $row;
            }
        }

        return $row_ar;
    }

    private function getFiles() {

        $Directory = new RecursiveDirectoryIterator($this->unpack_folder);
        $Iterator = new RecursiveIteratorIterator($Directory);
        $filter = new RegexIterator($Iterator, "/[^,]+\.mdb$/i");

        $data_files = [];
        foreach ($filter as $filename) {
            $data_files[] = $filename;
        }

        return $data_files;
    }
}