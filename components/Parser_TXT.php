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
        if($data_txt){
            $all_files_ar = [];
            foreach($data_txt  as $table => $files) {
                foreach($files as $ar_str) {
                    foreach($ar_str as $str) {
                        $all_files_ar[$table][] = $str;
                    }
                }
            }
        }

        return $all_files_ar;
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
}