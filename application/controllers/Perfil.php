<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends MY_Controller {
  public function __construct() {
    parent:: __construct();
  }

  public function index() {
    $this->loadHead();
    $this->loadHeaderMenu();
    $this->load->view('perfil');
    $this->loadFoot();
    $this->loadScripts();
  }
}