<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensagens extends MY_Controller {
  public function __construct() {
    parent:: __construct();
  }

  public function index() {
    $this->loadHead();
    $this->loadHeaderMenu();
    // $this->writeJsonFile(array(
    //   'teste' => array(
    //     'primeiro' => 1,
    //     'segundo' => 2,
    //   ),
    //   '3' => 'sfsf',
    //   '5t' => 'sfsf',
    //   't' => 'sfsf'
    // ));
    // echo '<pre>';
    // print_r($this->readJsonFile());
    // print_r($this->getCookie());
    // echo '</pre>';
    // die();
    $this->load->view('home');
    $this->loadFoot();
    $this->loadScripts();
  }
}