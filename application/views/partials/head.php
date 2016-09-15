<?php header('Content-Type: text/html; charset=utf-8; X-UA-Compatible: IE=Edge'); ?>
<!DOCTYPE HTML>
<html>
  <head>
    <title><?= $this->config->item('nome_sistema'); ?></title>
    <?php foreach($this->config->item('cssIncludes') as $css) { ?>
    <link rel="stylesheet" href="<?=base_url('assets/css/'.$css.'.css');?>">
    <?php }
      foreach($this->config->item('cssIncludesPrint') as $css) {
    ?>
    <link rel="stylesheet" media="print" href="<?=base_url('assets/css/'.$css.'.css');?>">
    <?php }
      if(isset($cssIncludes)) foreach($cssIncludes as $css) {
    ?>
    <link rel="stylesheet" href="<?=base_url('assets/css/'.$css.'.css');?>">
    <?php } ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width, user-scalable=no">
  </head>
  <body>
  <nav class="cd-side-navigation left">
    <ul>
      <li>
        <a href="#0" data-menu="mensagens">
          <i class="fa fa-comment-o" aria-hidden="true"></i>
          Mensagens
        </a>
      </li>

      <li>
        <a href="#0" data-menu="perfil">
         <i class="fa fa-user" aria-hidden="true"></i>
         Perfil
        </a>
      </li>

      <li>
        <a href="#0" data-menu="grupos">
          <i class="fa fa-users" aria-hidden="true"></i>
          Grupos
        </a>
      </li>

      <li>
        <a href="#0" data-menu="historico">
            <i class="fa fa-history" aria-hidden="true"></i>
            Histórico
        </a>
      </li>

      <li>
        <a href="#0" data-menu="configuracoes">
          <i class="fa fa-cogs" aria-hidden="true"></i>
          Configurações
        </a>
      </li>
    </ul>
  </nav>
  <nav class="cd-side-navigation right">
    <div class="status-bar-chat">
    <ul class="list"><li class="clearfix">
          <img src="<?= base_url('assets/imagens/eliseu.jpg'); ?>" width="50" alt="avatar">
          <div class="about">
            <div class="name">Eliseu dos Santos</div>
            <div class="status">
              <i class="fa fa-circle online"></i> online
            </div>
          </div>
        </li></ul>
    <h5>Eliseu dos Santos</h5>
    </div>
    <div class="contatos-bar">

    </div>
  </nav>