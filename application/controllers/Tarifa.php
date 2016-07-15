<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarifa extends CI_Controller {

  public function __construct(){  

    parent::__construct();

      $this->load->model("Message_Model");
      $this->load->model("Tarifa_Model");

    // SE NÃO HOUVER SESSÃO OU O USUARIO FOR DIFERENTE DE ADMINISTRADOR
    // ELE SERÁ REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario") || $this->session->userdata("idperfil") != 1)
      redirect("/");
  }
     
  public function index(){
  
    // RETORNA TODOS OS DADOS CADASTRADOS
    $tarifa = $this->Tarifa_Model->tarifa_atual();

    $dados = array(
      "main" => array("name" => "Tarifa","icon" => "fa fa-usd"),
      "tarifa" => $tarifa,
    );

    // CARREGA A VIEW
    $this->load->view('tarifa/index',$dados);
  
  }

  public function update(){
    
    $this->validar_formulario();

    $dados = $this->montar_dados();

    $this->Tarifa_Model->update($dados);
    
    $this->Message_Model->message('success','Dados atualizados com sucesso');
    
    $this->redireciona();
    
  }

  public function validar_formulario(){
    
    $this->check_post();

    $this->form_validation->set_rules('idtarifa','Id da Tarifa','required');    
    $this->form_validation->set_rules('valor_tarifa','Valor Tarifa','required');

    if(!$this->form_validation->run()){

      $this->Message_Model->message('danger','Ocorreum erro na validação dos dados.<br/>'.validation_errors());

      $this->redireciona();
    }

  }

  public function montar_dados(){

    $dados = array(
      "idtarifa" => $this->input->post("idtarifa"),
      "valor_tarifa" => str_replace(",", ".", $this->input->post("valor_tarifa")),
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

    redirect("tarifa/");
  }

}
