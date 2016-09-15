<?php
class MY_Model extends CI_Model {
  public function __construct(){
  	parent::__construct();
    $this->load->helper('formatacao_data_helper');
    $this->load->helper('formatacao_string_helper');
//    $CI = &get_instance();
//    $this->websystem = $CI->load->database('websystem', TRUE);
  }
  function utf8($string) {
    $cur_encoding = mb_detect_encoding($string) ;
    if($cur_encoding == "UTF-8" && mb_check_encoding($string,"UTF-8")) {
      return $string;
    } else {
      return utf8_encode($string);
    }
  }

  function multiexplode ($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    $launch = array_map("trim", $launch);
    $launch = array_map("strtoupper", $launch);
    $launch = array_filter($launch);
    return  array_unique($launch);
  }

  function removeItensSimilares($array) {
    for ($i = 0; $i < count($array); $i++) {
      for ($j = $i; $j < count($array); $j++) {
        if ($j > $i && (isset($array[$i]) && isset($array[$j]))) {
          $similar = levenshtein($array[$i],$array[$j]);
          if($similar <= 1) {
            unset($array[$j]);
          }
        }
      }
    }
    $array = array_filter($array);
    $array = array_unique($array);
    sort($array);
    array_multisort($array);
    return $array;
  }
}
?>
