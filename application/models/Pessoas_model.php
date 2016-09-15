<?php
class Pessoas_model extends MY_Model {
  function __construct() {
    parent::__construct();
  }

  function buscarPessoas($busca) {
    $pessoas = $this->db
                    ->select('cd_pessoa, razao_social, foto')
                    ->join('segusuar', 'cd_pessoa')
                    ->where('segusuar.st_ativo', 'S')
                    ->like('LOWER(razao_social)', strtolower($busca))
                    ->get('cadpessoa')
                    ->result();
    foreach ($pessoas as $pessoa) {
      $pessoa->razao_social = $this->utf8($pessoa->razao_social);
    }
    return $pessoas;
  }

  function buscarUsuarios($busca) {
    $usuarios = $this->db
                ->select('cd_usuario, trim(razao_social) as razao_social, trim(foto) as foto')
                ->join('segusuar', 'cd_pessoa')
                ->where('segusuar.st_ativo', 'S')
                ->like('LOWER(razao_social)', strtolower($busca))
                ->get('cadpessoa')
                ->result();
    foreach ($usuarios as $usuario) {
      $usuario->razao_social = $this->utf8($usuario->razao_social);
    }
    return $usuarios;
  }

  function buscarPessoasPorId($busca) {
    $pessoa = $this->db
                ->select('cd_usuario, trim(cadpessoa.razao_social) as razao_social')
                ->join('segusuar', 'cd_pessoa')
                ->where('segusuar.cd_usuario', $busca)
                ->get('cadpessoa')
                ->row();
    if($pessoa) {
      $pessoa->razao_social = $this->utf8($pessoa->razao_social);
    }
    return $pessoa;
  }

  function getPessoas() {
    $pessoas = $this->db->select('cd_pessoa, razao_social')
                        ->get('cadpessoa')
                        ->result();
    foreach ($pessoas as $pessoa) {
      $pessoa->razao_social = $this->utf8($pessoa->razao_social);
    }
    return $pessoas;
  }

  public function getPessoaPorCdPessoa($cd_pessoa) {
    $pessoa = $this->db
                ->select('cd_pessoa, trim(razao_social) as razao_social')
                ->where('cd_pessoa', $cd_pessoa)
                ->get('cadpessoa')
                ->row();
    if($pessoa) {
      $pessoa->razao_social = $this->utf8($pessoa->razao_social);
    }
    return $pessoa;
  }

  public function getUsuarioPorCdUsuario($cd_usuario) {
    $usuario = $this->db
                    ->select('cd_usuario, trim(razao_social) as razao_social, foto')
                    ->where('cd_usuario', $cd_usuario)
                    ->join('cadpessoa', 'cd_pessoa')
                    ->get('segusuar')
                    ->row();
    if($usuario) {
      $usuario->razao_social = $this->utf8($usuario->razao_social);
    }
    return $usuario;
  }

  public function getPessoaPorId($cd_pessoa) {
    $dados = $this->db
                ->select("cd_pessoa, trim(cadpessoa.razao_social) as razao_social, foto, email, to_char(dt_nasc, 'DD/MM/YYYY') as dt_nasc")
                ->where('cd_pessoa', $cd_pessoa)
                ->get('cadpessoa')
                ->row();
    if($dados) {
      $dados->razao_social = $this->utf8($dados->razao_social);
    }
    return $dados;
  }

  public function getPessoaPorLogin($login) {
    $dados = $this->db
                ->select("cd_pessoa, trim(cadpessoa.razao_social) as razao_social, foto, cadpessoa.email, to_char(dt_nasc, 'DD/MM/YYYY') as dt_nasc")
                ->join('segusuar', 'cd_pessoa')
                ->where('login', $login)
                ->get('cadpessoa')
                ->row();
    if($dados) {
      $dados->razao_social = $this->utf8($dados->razao_social);
    }
    return $dados;
  }

  public function getNomePessoaPorCdUsuario($cd_usuario) {
    $pessoa = $this->db
                ->select('trim(razao_social) as razao_social')
                ->join('segusuar', 'cd_pessoa')
                ->where('cd_usuario', $cd_usuario)
                ->get('cadpessoa')
                ->row('razao_social');
    if($pessoa) {
      $pessoa = $this->utf8($pessoa);
    }
    return $pessoa;
  }

  public function atualizarFoto($cd_pessoa, $foto) {
    $this->db
         ->where('cd_pessoa', $cd_pessoa)
         ->update('cadpessoa', array(
          'foto' => $foto
         ));
  }

}
?>
