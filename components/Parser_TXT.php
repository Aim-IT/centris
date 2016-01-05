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

class Parser_TXT {

    public $list_tables = array();
    public $unpack_folder;

    public function __construct() {

        $this->list_tables = Yii::$app->params['list_tables'];
        $this->unpack_folder = Yii::$app->params['upload_unpack'];
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
            $all_files_ar = [];
            foreach($insert_data[$table] as $file) {
                foreach($file as $ar_str) {
                    $all_files_ar[] = $ar_str;
                }
            }
            $arr_column_table = $this->getColumn($table);
            $all_files_ar = $this->prepareInsertData($all_files_ar, count($arr_column_table));
            if($all_files_ar['insert']){
                Yii::$app->db->createCommand()->batchInsert($table, $arr_column_table, $all_files_ar['insert'])->execute();
                $insert_log .= '<h4>' . $table . '</h4>';
                $insert_log .= '<p style="color: #008000">'. count($all_files_ar['insert']) . ' lines was added </p>';
            }
            if($all_files_ar['problem_str']){
                Yii::$app->db->createCommand()->batchInsert($table, $arr_column_table, $all_files_ar['insert'])->execute();
                $insert_log .= '<p style="color: red">Lines with errors not inserted: "' . implode(', ', $all_files_ar['problem_str'])  .'</p>';
            }
        }

        return $insert_log;
    }

    public function getTxtData() {

        if (empty($this->list_tables)) {
            return [];
        }
        $data_txt = [];
        foreach($this->list_tables as $table) {
            $data_files = $this->getFiles($table);
            if(empty($data_files)) {
                continue;
            }

            foreach ($data_files as $file) {

                $data_txt[$table][] = $this->parserFile($file);
            }
        }
        return $data_txt;
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
        $columns = Yii::$app->db->createCommand('SELECT COLUMN_NAME
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
            AND COLUMN_NAME != "id"
            AND `TABLE_NAME` = "'. $table .'"')
            ->queryColumn();

        return $columns;
    }

    private function getFiles($table_name) {

        $Directory = new RecursiveDirectoryIterator($this->unpack_folder);
        $Iterator = new RecursiveIteratorIterator($Directory);
        $filter = new RegexIterator($Iterator, "/$table_name\.txt$/i");

        $data_files = [];
        foreach ($filter as $filename) {
            $data_files[] = $filename;
        }

        return $data_files;
    }

    private function parserFile($file = '') {

        $ar_data = [];
        $file_str = file_get_contents($file);
        $arr_str = explode("\n", $file_str);

        if($arr_str) {
            $str_array_a = [];
            foreach ($arr_str as $str) {
                if($str) {
                    $str_array_a[] = trim($str);
                }
            }
            if($str_array_a) {
                $ar_element = [];
                foreach($str_array_a as $str) {
                    $str =$this->parseStr($str);
                    $ar_sub_str = explode(',', $str);
                    foreach($ar_sub_str as $element) {

                        $element = str_replace('#$#', ',', $element);
                        $element = trim($element);
                        $ar_element[] = $element;
                    }
                    $ar_data[] = $ar_element;
                    $ar_element = [];
                }
            }
        }

        return $ar_data;
    }

    private function parseStr($input)
    {
        $pattern = '/"([^"]+)"/i';
        if (is_array($input)) {
            $input = str_replace(',', '#$#', $input[1]);
            $input = iconv('windows-1252', 'utf-8', $input);
        }

        return preg_replace_callback($pattern, array($this, 'parseStr'), $input);
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