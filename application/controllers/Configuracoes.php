<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracoes extends MY_Controller {
  public function __construct() {
    parent:: __construct();
  }

  public function index() {
    $this->loadHead();
    $this->loadHeaderMenu();
    $this->load->view('home');
    $this->loadFoot();
    $this->loadScripts();
  }
}