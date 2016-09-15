<?php
  class MY_Controller extends CI_Controller {

    protected $usuarioSuper = false;
    protected $ano          = false;
    protected $st_menu      = false;


    public function __construct() {
      parent::__construct();
      require_once APPPATH.'third_party/Mustache/Autoloader.php';
      Mustache_Autoloader::register();
      $options =  array('extension' => '.php');
      $this->mustache = new Mustache_Engine(
        array(
          'loader' => new Mustache_Loader_FilesystemLoader(FCPATH . 'application/views/partials/templates', $options),
          'escape' => function($value) {
            if(is_string($value) && !is_numeric($value)) {
              return $this->utf8($value);
            } else {
              return $value;
            }
          },
        )
      );
      $this->load->helper('formatacao_data_helper');
      $this->load->helper('formatacao_string_helper');
      $this->load->helper('pass_crypt_helper');
      date_default_timezone_set('America/Maceio');
    }

    protected function decrypt(&$item,$key) {
      if($item) {
        if(is_array($item)) {
          array_walk_recursive($item, array($this, 'decrypt'));
        } else {
          $item = $this->encryption->decrypt($item);
          return $item;
        }
      } else {
        return false;
      }
    }

    protected function encryption(&$item,$key) {
      if($item) {
        if(is_array($item)) {
          array_walk_recursive($item, array($this, 'encryption'));
        } else {
          $item = $this->encryption->encrypt($item);
          return $item;
        }
      } else {
        return false;
      }
    }

    protected function loadHead() {
      $data['cssIncludes'] = func_get_args();
      $this->load->view('partials/head',$data);
    }

    protected function loadScripts() {
      $data['jsIncludes'] = func_get_args();
      $this->load->view('partials/scripts',$data);
    }

    protected function loadFoot() {
      $this->load->view('partials/foot');
    }

    protected function verificaPastaUpload() {
      if(!is_dir('assets/uploads')) {
        mkdir('assets/uploads');
        chmod('assets/uploads', 0777);
      }
    }

    protected function loadHeaderMenu($descricao = false) {
      $data = array();
      $this->load->view('partials/nav_top', $data);
    }

    public function multiexplode ($delimiters,$string) {
      $ready = str_replace($delimiters, $delimiters[0], $string);
      $launch = explode($delimiters[0], $ready);
      $launch = array_map("trim", $launch);
      $launch = array_map("strtoupper", $launch);
      $launch = array_filter($launch);
      return  array_unique($launch);
    }

    public function writeJsonFile($arr_data) {
      $myFile = FCPATH. "data/data.json";
      array_walk_recursive($arr_data, array($this, 'encryption'));
      $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);
      if(file_put_contents($myFile, $jsondata)) {
        return $jsondata;
      } else {
        return false;
      }
    }

    public function getCookie($key = false) {
      if($key) {
        return json_decode($_COOKIE[$key], true);
      } else {
        return json_decode($_COOKIE["json_cookie"], true);
      }
    }

    public function readJsonFile() {
      $myFile = FCPATH. "data/data.json";
      try {
        $jsondata = file_get_contents($myFile);
        setcookie("json_cookie", $jsondata);
        $arr_data = json_decode($jsondata, true);
        array_walk_recursive($arr_data, array($this, 'decrypt'));
        return $arr_data;
      } catch (Exception $e) {
        echo 'Erro: ' . $e->getMessage(), "\n";
      }
    }

    public function getArquivos($path) {
      $result = array();
      $times = array();
      if(is_dir($path)) {
        $files = scandir($path);
        foreach ($files as $file) {
          $arquivo = $path.'/'.$file;
          $images = array('jpg', 'png', 'gif', 'jpeg');
          $extensao = strtolower(pathinfo($file, PATHINFO_EXTENSION));
          if($file != '.' && $file != '..' && !is_dir($path.'/'.$file)) {
            $result[] = array(
              'desc_arquivo' => $file,
              'dt_criacao'   => date('d/m/Y H:i', filemtime($path.'/'.$file)),
              'path'   => $arquivo,
              'icon' => $this->iconFile($extensao),
              'image' => (in_array($extensao, $images)) ? 'style="background-image: url(\''.base_url($arquivo).'\')"'  : ''
            );
            $times[] = filemtime($path.'/'.$file);
          }
        }
        array_multisort($times,$result);
      }
      return $result;
    }

    protected function excluirArquivo($path) {
      if(file_exists($path)) {
        unlink($path);
        return true;
      } else {
        return false;
      }
    }

    public function iconFile($extensao) {
      $extensoes = array(
        'png'  => 'fa-file-image-o',
        'jpg'  => 'fa-file-image-o',
        'jpeg' => 'fa-file-image-o',
        'gif'  => 'fa-file-image-o',
        'zip'  => 'fa-file-archive-o',
        'ppt'  => 'fa-file-powerpoint-o',
        'pptx' => 'fa fa-file-powerpoint-o',
        'rar'  => 'fa-file-archive-o',
        'pdf'  => 'fa-file-pdf-o',
        'doc'  => 'fa-file-word-o',
        'docx' => 'fa-file-word-o',
        'xlsx' => 'fa-file-excel-o',
        'xlsm' => 'fa-file-excel-o',
        'xls'  => 'fa-file-excel-o',
        'txt'  => 'fa-file-text-o',
        'csv'  => 'fa-file-excel-o',
        'bmp'  => 'fa-file-image-o',
        'csv'  => 'fa-file-excel-o',
        'avi'  => 'fa-file-video-o',
        'flv'  => 'fa-file-video-o',
        'mp4'  => 'fa-file-video-o',
        'mp3'  => 'fa-file-audio-o',
        'ogg'  => 'fa-file-audio-o',
        'wav'  => 'fa-file-audio-o',
        'wmv'  => 'fa-file-video-o',
      );
      if(isset($extensoes[$extensao])) {
        return $extensoes[$extensao];
      } else {
        return 'fa-file-o';
      }
    }

    protected function calculaPercentual($feito, $total) {
      if($total > 0) {
        $count1 = $feito / $total;
        $count2 = $count1 * 100;
        $count = number_format($count2, 0);
        return $count;
      } else {
        return 0;
      }
    }

    function removeItensSimilares($array) {
      for ($i = 0; $i < count($array); $i++) {
        for ($j = $i; $j < count($array); $j++) {
          if ((isset($array[$i]) && isset($array[$j]))) {
            $similar = levenshtein($array[$i],$array[$j]);
            if($similar <= 1 || $array[$i] == $array[$j]) {
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

    public function useTemplate($template, $dados = array()) {
      if($template) {
        echo $this->mustache->render($template, $dados);
      } else {
        return false;
      }
    }

    function utf8($string) {
      $cur_encoding = mb_detect_encoding($string) ;
      if($cur_encoding == "UTF-8" && mb_check_encoding($string,"UTF-8")) {
        return $string;
      } else {
        return utf8_encode($string);
      }
    }
  }
?>