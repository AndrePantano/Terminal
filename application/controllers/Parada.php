<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parada extends CI_Controller {

  private $main = array();
  
  public function __construct(){  

    parent::__construct();  
    
    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario")){
      redirect("auth/entrar");
    }

    $this->load->model("Parada_Model");
    $this->load->model("Message_Model");
    
  }
     
  public function create(){
    
    $this->validar_formulario('create');
        
    $this->checar_datas();

    $dados = $this->montar_dados();

    $this->Parada_Model->create($dados);

    $this->Message_Model->message('success','Parada adicionada com sucesso');
    
    $this->redireciona();
    
  }

  public function update(){
    
    $this->validar_formulario('update');
        
    $this->checar_datas();

    $dados = $this->montar_dados();

    $this->Parada_Model->update($dados);

    // RETORNA A MENSAGEM
    $this->Message_Model->message('success','Dados da Parada atualizados com sucesso');
          
    $this->redireciona();
    
  }

  public function delete(){
    
    $this->validar_formulario("delete");
        
    $dados = array("idparada" => $this->input->post("idparada"));

    $this->Parada_Model->delete($dados);

    // RETORNA A MENSAGEM
    $this->Message_Model->message('success','Dados excluídos com sucesso');

    $this->redireciona();
    
  }

  public function checar_datas(){

    if($this->input->post("inicio") >= $this->input->post("fim")){

      $this->Message_Model->message('warning','Data início da parada é maior ou igual a data final.<br>Informe um período válido.');

      $this->redireciona();
    }

  }

  public function validar_formulario($tipo){

    $this->check_post();

    switch ($tipo) {
      case 'create':
        $this->form_validation->set_rules('idtrem','Id do Trem','required');    
        $this->form_validation->set_rules('idtipo_parada','Tipo de Parada','required');    
        $this->form_validation->set_rules('inicio','Início da Parada','required');    
        $this->form_validation->set_rules('fim','Fim da Parada','required'); 
        break;
      case 'update':
        $this->form_validation->set_rules('idparada','Id da Parada','required');
        $this->form_validation->set_rules('idtrem','Id do Trem','required');    
        $this->form_validation->set_rules('idtipo_parada','Tipo de Parada','required');    
        $this->form_validation->set_rules('inicio','Início da Parada','required');    
        $this->form_validation->set_rules('fim','Fim da Parada','required'); 
        break;
      case 'delete':
        $this->form_validation->set_rules('idparada','Id da Parada','required');
        break;
    }

    if(!$this->form_validation->run()){

      $this->Message_Model->message('danger','Ocorreum erro na validação dos dados.<br/>'.validation_errors());

      $this->redireciona();
    }

  }

  public function check_post(){
    if(!$this->input->post()){
      $this->Message_Model->message('danger','Nenhum formulário foi recebido!');
      $this->redireciona();
    }
  }

  public function montar_dados(){

    $dados = array(
      "idoperacao" => $this->input->post("idoperacao"),
      "idtipo_parada" => $this->input->post("idtipo_parada"),
      "inicio_parada" => $this->input->post("inicio"),
      "fim_parada" => $this->input->post("fim"),
      "idusuario" => $this->session->userdata("idusuario")
    );
    
    if($this->input->post("idparada")){
      $dados["idparada"] = $this->input->post("idparada");
      $dados["atualizado_em"] = date("Y-m-d H:i:s");
    }else{
      $dados["criado_em"] = date("Y-m-d H:i:s");
    }

    return $dados;
  }

  public function redireciona(){
    
    redirect("operacao/trem/".$this->input->post("idtrem"));
  }

}

