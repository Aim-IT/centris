<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22.12.2015
 * Time: 15:46
 */

namespace app\components;

use yii;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class InsertData {

    private  $list_tables = array();
    private  $table_columns = array();

    public function __construct() {

        $this->list_tables = Yii::$app->params['list_tables'];
    }

    public function insertTxtData($insert_data){

        if (empty($this->list_tables) || empty($insert_data)) {

            return false;
        }
        $insert_log = '';
        foreach($this->list_tables as $table) {
            if(!array_key_exists($table, $insert_data)) {
                continue;
            }

            $arr_column_table = $this->getColumn($table);
            $all_files_ar = $this->prepareInsertData($insert_data[$table], count($arr_column_table));
            $insert_log .= $this->tableNameLog($table);
            if($all_files_ar['insert']){
                $count_insert_str = Yii::$app->db->createCommand()->batchInsert($table, $arr_column_table, $all_files_ar['insert'])->execute();
                if($count_insert_str) {
                    $insert_log .= $this->saveSuccessLog($count_insert_str);
                }
            }
            if($all_files_ar['problem_str']){
                $insert_log .= $this->saveErrorLog($all_files_ar['problem_str']);
            }
        }

        return $insert_log;
    }


    private function prepareInsertData($all_files_ar, $count_col) {

        $problem_str = [];
        foreach($all_files_ar as $str => $ar_str) {
            if(count($ar_str) != $count_col) {
                unset($all_files_ar[$str]);
                $problem_str[] = $str;
            }
        }

        return ['insert' => $all_files_ar, 'problem_str' => $problem_str];
    }

    private function getColumn($table) {

        if(array_key_exists($table, $this->table_columns)) {

            return $this->table_columns[$table];
        }
        $columns = Yii::$app->db->createCommand('SELECT COLUMN_NAME
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
            AND COLUMN_NAME != "id"
            AND `TABLE_NAME` = "'. $table .'"')
            ->queryColumn();
        $this->table_columns[$table] = $columns;

        return $columns;
    }

    private function tableNameLog($table){

        $insert_log = '<h4>' . $table . '</h4>';

        return $insert_log;
    }

    private function saveSuccessLog($count_insert_str){

        $insert_log = '<p style="color: #008000">'. $count_insert_str . ' lines was added </p>';

        return $insert_log;
    }

    private function saveErrorLog($ar_error_str){

        $insert_log = '<p style="color: red">Lines with errors not inserted: "' . implode(', ', $ar_error_str)  .'</p>';

        return $insert_log;
    }

    public function clearDB(){

        if (empty($this->list_tables)) {

            return false;
        }

        foreach($this->list_tables as $table) {
            Yii::$app->db->createCommand('truncate table `'. $table. '`')->execute();
        }

        return true;
    }
}