<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meta extends CI_Controller {

  public function __construct(){  

    parent::__construct();

      $this->load->model("Message_Model");
      $this->load->model("Meta_Model");

    // SE NÃO HOUVER SESSÃO OU O USUARIO FOR DIFERENTE DE ADMINISTRADOR
    // ELE SERÁ REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario") || $this->session->userdata("idperfil") != 1)
      redirect("/");
  }
     
  public function index(){
  
    // RETORNA TODOS OS DADOS CADASTRADOS
    $metas = $this->Meta_Model->all();

    $dados = array(
      "main" => array("name" => "Metas de Controle","icon" => "fa fa-arrows-v"),
      "metas" => $metas,
    );

    // CARREGA A VIEW
    $this->load->view('meta/index',$dados);
  
  }

  public function update(){
    
    $this->validar_formulario();

    $dados = $this->montar_dados();

    $this->Meta_Model->update($dados);
    
    $this->Message_Model->message('success','Dados atualizados com sucesso');
    
    $this->redireciona();
    
  }

  public function validar_formulario(){
    
    $this->check_post();

    $this->form_validation->set_rules('idmeta','Id da Meta','required');    
    $this->form_validation->set_rules('valor_meta','Valor Meta','required|min_length[1]|max_length[99]');

    if(!$this->form_validation->run()){

      $this->Message_Model->message('danger','Ocorreum erro na validação dos dados.<br/>'.validation_errors());

      $this->redireciona();
    }

  }

  public function montar_dados(){

    $dados = array(
      "idmeta" => $this->input->post("idmeta"),
      "valor_meta" => $this->input->post("valor_meta"),
      "criado_em" => date("Y-m-d")
    );
    
    return $dados;
  }

  public function check_post(){

    if(!$this->input->post()){
      $this->Message_Model->message('danger','Nenhum formulário foi recebido!'); 
      $this->redireciona();
    }

  }

  public function redireciona(){

    redirect("meta/");
  }

}
