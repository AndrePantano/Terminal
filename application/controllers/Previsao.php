<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Previsao extends CI_Controller {

  private $main = array();

  public function __construct(){  

    parent::__construct();  

    $this->load->model("Previsao_Model");
    
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
          'title' => 'Parabéns!',
          'content' => 'Previsão adicionada com sucesso'
        ]);        
           
      }else{
        
        // RETORNA O ERRO
        $this->session->set_flashdata([
          'class' => 'danger',
          'title' => 'Atenção!',
          'content' => 'Ocorreum erro na validação dos dados.<br/>'.validation_errors()
        ]);
        
      }
    
    }else{
      // RETORNA O ERRO
      $this->session->set_flashdata([
        'class' => 'danger',
        'title' => 'Atenção!',
        'content' => 'É preciso preencher o formulário para criar uma previsão'
      ]); 

    }

    redirect("trens/trem/".$idtrem);
    
  }

  public function validar_formulario(){
    $this->form_validation->set_rules('idtrem','Trem','required');    
    $this->form_validation->set_rules('previsao','Previsão','required');   
    $this->form_validation->set_rules('motivo','Motivo','required');       
    return $this->form_validation->run();
  }

}

