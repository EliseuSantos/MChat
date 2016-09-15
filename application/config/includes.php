<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| DEFAULT INCLUDES
| -------------------------------------------------------------------------
| This file lists the css and javascript files that should be included by
| default in your views' header. Scripts in here will be loaded at your
| pages'header, not at the end of the body. Only put scripts in here if
| they are safe and essential.
|
*/
$config['cssIncludes'] = array(
  'reset',
  'style',
  'font-awesome/font-awesome.min',
  'waitMe',
  'select2.min',
);
$config['cssIncludesPrint'] = array(

);
$config['jsIncludes'] = array(
  'jquery-2.2.0.min',
  'class/lStorage',
  'hammer.min',
  'velocity.min',
  'waitMe',
  'mustache',
  'moment',
  'pt-br',
  'modernizr-2.6.2.min',
  'cryptography',
  'class/notificacao',
  'class/client-websocket',
  'triggersWebsocket',
  'select2.full',
  'i18n/pt-BR',
  'global',
  'customEvents'
);
?>
