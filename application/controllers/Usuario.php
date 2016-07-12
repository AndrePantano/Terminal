<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

  public function __construct(){  

    parent::__construct();

      $this->load->model("Usuario_Model");
      $this->load->model("Message_Model");
      $this->load->model("Perfil_Model");

    // SE NÃO HOUVER SESSÃO OU O USUARIO FOR DIFERENTE DE ADMINISTRADOR
    // ELE SERÁ REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario") || $this->session->userdata("idperfil") != 1)
      redirect("/");
  }
     
  public function index(){
  
    // RETORNA TODOS OS DADOS CADASTRADOS
    $usuarios = $this->Usuario_Model->all();
    $perfis = $this->Perfil_Model->all();

    $dados = array(
      "main" => array("name" => "Usuários","icon" => "fa fa-users"),
      "usuarios" => $usuarios,
      "perfis" => $perfis
    );

    // CARREGA A VIEW
    $this->load->view('usuario/index',$dados);
  
  }

  public function create(){
    
    $this->validar_formulario('create');

    $dados = $this->montar_dados();
    
    $this->Usuario_Model->create($dados);
    
    $this->Message_Model->message('success','Usuário adicionado com sucesso');
           
    $this->redireciona();
    
  }

  public function update(){
    
    $this->validar_formulario('update');

    $dados = $this->montar_dados();

    $this->Nota_Model->update($dados);
    
    $this->Message_Model->message('success','Dados atualizados com sucesso');
    
    $this->redireciona();
    
  }

  public function validar_formulario($tipo){
    
    $this->check_post();

    switch ($tipo) {
      case 'create':
        $this->form_validation->set_rules('nome','Nome','required');    
        $this->form_validation->set_rules('email','Email','valid_email|required');       
        $this->form_validation->set_rules('idperfil','Perfil','required');       
        break;
      case 'update':
        $this->form_validation->set_rules('idusuario','Id do Usuario','required');    
        $this->form_validation->set_rules('nome','Nome','required');    
        $this->form_validation->set_rules('email','Email','valid_email|required');       
        $this->form_validation->set_rules('ativo','Ativo','required');       
        $this->form_validation->set_rules('idperfil','Perfil','required');       
        break;
      case 'delete':
        $this->form_validation->set_rules('idusuario','Id do Usuario','required');    
        break;
    }

    if(!$this->form_validation->run()){

      $this->Message_Model->message('danger','Ocorreum erro na validação dos dados.<br/>'.validation_errors());

      $this->redireciona();
    }

  }

  public function montar_dados(){

    $dados = array(
      "nome" => $this->input->post("nome"),
      "email" => $this->input->post("email"),
      "idperfil" => $this->input->post("idperfil"),
      "ativo" => 1
    );
    
    if($this->input->post("idusuario")){
      $dados["idusuario"] = $this->input->post("idusuario");
    }else{
      $dados["senha"] = md5("brado");
    }

    if($this->input->post("ativo")) $dados["ativo"] = $this->input->post("ativo");

    return $dados;
  }

  public function check_post(){

    if(!$this->input->post()){
      $this->Message_Model->message('danger','Nenhum formulário foi recebido!'); 
      $this->redireciona();
    }

  }

  public function redireciona(){

    redirect("usuario/");
  }

}
