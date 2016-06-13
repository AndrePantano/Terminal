<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nota extends CI_Controller {

  public function __construct(){  

    parent::__construct();  

    $this->load->model("Nota_Model");
    
  }
     
  public function create(){
    
    $idtrem = $this->input->post("idtrem");
    
    if($this->input->post()){

      // VALIDA O FORMULÁRIO
      if($this->validar_formulario()){
        

        // INSERE A PREVISAO COM A DATA PASSADA
        $nota = array(
          "idtrem" => $idtrem,
          "criacao_nota" => date("Y-m-d H:i"),
          "texto_nota" => $this->input->post("texto")
        );
        
        $this->Nota_Model->create($nota);

        // RETORNA A MENSAGEM
        $this->session->set_flashdata([
          'class' => 'success',
          'title' => 'Parabéns!',
          'content' => 'Nota adicionada com sucesso'
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
        'content' => 'É preciso preencher o formulário para criar uma nota'
      ]); 

    }

    redirect("trens/trem/".$idtrem);
    
  }

  public function validar_formulario(){
    $this->form_validation->set_rules('idtrem','Trem','required');    
    $this->form_validation->set_rules('texto','Texto','required');       
    return $this->form_validation->run();
  }

}

