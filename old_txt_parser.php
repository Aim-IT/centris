<?php
class aaa{
    private function processTxtFields($arr_str, $txt_fields = []) {
        $str_array_a = [];
        foreach ($arr_str as $str) {
            if($txt_fields) {
                foreach ($txt_fields as $field) {
                    $str = $this->elementReplaceSymbol($str, $field);
                }
            }
            $str_array_a[] = $str;
        }

        return $str_array_a;
    }

    private function elementReplaceSymbol($str, $element){
        $i = 2;
        $pos = strpos($str, ',');
        while($element > $i){
            $pos = strpos($str, ',', $pos+1);
            $i++;
        }
        if(!$pos){

            return $str;
        }
        $arr_string = str_split($str, $pos+1);
        $substring_1 = array_shift($arr_string);
        $substring_2 = implode('', $arr_string);
        if(empty($substring_2)){
            return $str;
        }
        if($substring_2[0] != '"'){
            return $str;
        }
        $pos_close_q = strpos($substring_2, '"', 1);
        $arr_string = str_split($substring_2, $pos_close_q+1);
        $text_element = array_shift($arr_string);
        $text_element = str_replace(',', '#$#', $text_element);
        $substring_2 = implode('', $arr_string);
        $str = $substring_1 . $text_element . $substring_2;

        return $str;
    }
}