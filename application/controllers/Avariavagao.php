<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avariavagao extends CI_Controller {

  public function __construct(){  

    parent::__construct();
    
    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario")){
      redirect("auth/entrar");
    }

    $this->load->model("Trem_Model");
    $this->load->model("Avaria_Vagao_Model");
    $this->load->model("Message_Model");
    
  }
     
  public function create(){

    $this->validar_formulario('create');

    $avaria = $this->montar_dados();

    $this->Avaria_Vagao_Model->create($avaria);

    $this->Message_Model->message('success','Avaria adicionada com sucesso');        
           
    $this->redireciona();
    
  }

  public function montar_dados(){

    $dados = array(
      "idtrem" => $this->input->post("idtrem"),
      "vagao" => strtoupper($this->input->post("vagao")),
      "idusuario" => $this->session->userdata("idusuario"),
      "descricao" => $this->input->post("descricao")
    );
    
    if($this->input->post("idavaria")){ 
      $dados["idavaria"] = $this->input->post("idavaria");
      $dados["atualizado_em"] = date("Y-m-d H:i:s");
    }else{
      $dados["criado_em"] = date("Y-m-d H:i:s");
    }

    
    return $dados;    
  }

  public function update(){
    
    $this->validar_formulario('update');

    $avaria = $this->montar_dados();
    
    $this->Avaria_Vagao_Model->update($avaria);

    $this->Message_Model->message('success','Avaria atualizada com sucesso');        
           
    $this->redireciona();

  }

  public function delete(){
    
    $this->validar_formulario('delete');

    $dados = array("idavaria" => $this->input->post("idavaria"));
    
    $this->Avaria_Vagao_Model->delete($dados);

    $this->Message_Model->message( 'success','Avaria excluída com sucesso');        
           
    $this->redireciona();
    
  }

  public function trem($id){
    
    $dados = array();
    $trem = $this->Trem_Model->trem($id);
    
    if($trem){

      $this->load->model("Avaria_Vagao_Model");
      $avarias = $this->Avaria_Vagao_Model->avarias("idtrem",$trem["idtrem"]);
      
      $dados = array(
        "main" => array("name" => "Trem ".$trem["prefixo_trem"],"icon" => "fa fa-train"),
        "trem" => $trem,
        "avarias" => $avarias
        //"grupos" => $grupos
      );
      $this->load->view('avariavagao/trem',$dados);
    }else{
      $this->Message_Model->trem_inexistente();
    }   
    
  }

  public function check_post(){
    if(!$this->input->post()){
      $this->Message_Model->message('danger','Nenhum formulário foi recebido!'); 
      $this->redireciona();
    }
  }

  public function validar_formulario($tipo){

    $this->check_post();

    switch ($tipo) {
      case 'create':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('vagao','Vagão','required');   
        $this->form_validation->set_rules('descricao','Descrição','required');   
        break;
      case 'update':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('idavaria','Avaria','required');    
        $this->form_validation->set_rules('vagao','Vagão','required');   
        $this->form_validation->set_rules('descricao','Descrição','required');   
        break;
      case 'delete':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('idavaria','Avaria','required');
        break;
    }

    if(!$this->form_validation->run()){

      $this->Message_Model->message( 'danger','Ocorreum erro na validação dos dados.<br/>'.validation_errors());

      $this->redireciona();
    }
  }

  public function redireciona(){

    redirect("avariavagao/trem/".$this->input->post("idtrem"));
  }

}

