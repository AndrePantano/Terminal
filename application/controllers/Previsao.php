<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Previsao extends CI_Controller {

  private $main = array();

  public function __construct(){  

    parent::__construct();  

    $this->load->model("Previsao_Model");
    $this->load->model("Trem_Model");
    
  }
  
  public function delete(){
    
    $idtrem = $this->input->post("idtrem");
    
    if($this->input->post()){

      // VALIDA O FORMULÁRIO
      if($this->validar_formulario_delete()){
        
        // INSERE A PREVISAO COM A DATA PASSADA
        $idprevisao = $this->input->post("idprevisao");
        
        $this->Previsao_Model->delete($idprevisao);

        // RETORNA A MENSAGEM
        $this->session->set_flashdata([
          'class' => 'success',
          'content' => 'Previsão excluída com sucesso'
        ]);        
           
      }else{
        
        // RETORNA O ERRO
        $this->session->set_flashdata([
          'class' => 'danger',
          'content' => 'Ocorreum erro na validação dos dados.<br/>'.validation_errors()
        ]);
        
      }
    
    }else{
      // RETORNA O ERRO
      $this->session->set_flashdata([
        'class' => 'danger',
        'content' => 'É preciso preencher o formulário para criar uma previsão'
      ]); 

    }

    redirect("previsao/trem/".$idtrem);
    
  }

  public function update(){
    
    $idtrem = $this->input->post("idtrem");
    
    if($this->input->post()){

      // VALIDA O FORMULÁRIO
      if($this->validar_formulario()){
        

        // INSERE A PREVISAO COM A DATA PASSADA
        $previsao = array(
          "idtrem" => $idtrem,
          "idprevisao" => $this->input->post("idprevisao"),
          "data_previsao" => $this->input->post("previsao"),
          "motivo_previsao" => $this->input->post("motivo")
        );
        
        $this->Previsao_Model->update($previsao);

        // RETORNA A MENSAGEM
        $this->session->set_flashdata([
          'class' => 'success',
          'content' => 'Previsão atualizada com sucesso'
        ]);        
           
      }else{
        
        // RETORNA O ERRO
        $this->session->set_flashdata([
          'class' => 'danger',
          'content' => 'Ocorreum erro na validação dos dados.<br/>'.validation_errors()
        ]);
        
      }
    
    }else{
      // RETORNA O ERRO
      $this->session->set_flashdata([
        'class' => 'danger',
        'content' => 'É preciso preencher o formulário para criar uma previsão'
      ]); 

    }

    redirect("previsao/trem/".$idtrem);
    
  }
  public function create(){
    
    $idtrem = $this->input->post("idtrem");
    
    if($this->input->post()){

      // VALIDA O FORMULÁRIO
      if($this->validar_formulario()){
        

        // INSERE A PREVISAO COM A DATA PASSADA
        $previsao = array(
          "idtrem" => $idtrem,
          "criacao_previsao" => date("Y-m-d H:i"),
          "data_previsao" => $this->input->post("previsao"),
          "motivo_previsao" => $this->input->post("motivo")
        );
        
        $this->Previsao_Model->create($previsao);

        // RETORNA A MENSAGEM
        $this->session->set_flashdata([
          'class' => 'success',
          'content' => 'Previsão adicionada com sucesso'
        ]);        
           
      }else{
        
        // RETORNA O ERRO
        $this->session->set_flashdata([
          'class' => 'danger',
          'content' => 'Ocorreum erro na validação dos dados.<br/>'.validation_errors()
        ]);
        
      }
    
    }else{
      // RETORNA O ERRO
      $this->session->set_flashdata([
        'class' => 'danger',
        'content' => 'É preciso preencher o formulário para criar uma previsão'
      ]); 

    }

    redirect("previsao/trem/".$idtrem);
    
  }

  public function validar_formulario(){
    $this->form_validation->set_rules('idtrem','Trem','required');    
    $this->form_validation->set_rules('previsao','Previsão','required');   
    $this->form_validation->set_rules('motivo','Motivo','required');       
    return $this->form_validation->run();
  }
  
  public function validar_formulario_update(){
    $this->form_validation->set_rules('idtrem','Trem','required');    
    $this->form_validation->set_rules('idoperacao','Operacao','required');    
    $this->form_validation->set_rules('previsao','Previsão','required');   
    $this->form_validation->set_rules('motivo','Motivo','required');       
    return $this->form_validation->run();
  }

  public function validar_formulario_delete(){
    $this->form_validation->set_rules('idtrem','Trem','required');    
    $this->form_validation->set_rules('idprevisao','previsao','required'); 
    return $this->form_validation->run();
  }

  public function trem($id){
    
    $dados = array();
    // CARREGA O TREM
    $trem = $this->Trem_Model->trem($id);
    
    if($trem){

      // CARREGA AS PREVISOES
      $this->load->model("Previsao_Model");
      $previsoes = $this->Previsao_Model->all("idtrem = ".$trem["idtrem"],null);
     
      $dados = array(
        "main" => array("name" => "Trem ".$trem["prefixo_trem"],"icon" => "fa fa-train"),
        "trem" => $trem,
        "previsoes" => $previsoes,
      );
      $this->load->view('previsao/trem',$dados);
    }else{
      $dados["heading"] = "Registro Inexistente.";
      $dados["message"] = "Este registro não se encontra em nossa base de dados!";
      $this->load->view('errors/cli/error_404',$dados);
    }   
    
  }

}

