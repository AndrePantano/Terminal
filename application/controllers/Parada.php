<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parada extends CI_Controller {

  public function __construct(){  

    parent::__construct();  
    
    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario")){
      redirect("auth/entrar");
    }

    $this->load->model("Parada_Model");
    
  }
     
  public function create(){
    
    $idtrem = $this->input->post("idtrem");
    
    if($this->input->post()){

      // VALIDA O FORMULÁRIO
      if($this->validar_formulario('create')){
        
        if($this->checar_datas()){
          // INSERE A PREVISAO COM A DATA PASSADA
          $dados = array(
            "idoperacao" => $this->input->post("idoperacao"),
            "idtipo_parada" => $this->input->post("idtipo_parada"),
            "inicio_parada" => $this->input->post("inicio"),
            "fim_parada" => $this->input->post("fim")
          );

          $this->Parada_Model->create($dados);

          // RETORNA A MENSAGEM
          $this->session->set_flashdata([
            'class' => 'success',
            'content' => 'Parada adicionada com sucesso'
          ]);
        }else{
          // RETORNA A MENSAGEM
          $this->session->set_flashdata([
            'class' => 'warning',
            'content' => 'Data início da parada é maior ou igual a data final.<br>Informe um período válido.'
          ]);        
           
        }      
           
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

    redirect("operacao/trem/".$idtrem);
    
  }

  public function update(){
    
    $idtrem = $this->input->post("idtrem");
    
    if($this->input->post()){

      // VALIDA O FORMULÁRIO
      if($this->validar_formulario('update')){
        
        if($this->checar_datas()){
          // INSERE A PREVISAO COM A DATA PASSADA
          $dados = array(
            "idparada" => $this->input->post("idparada"),
            "idtipo_parada" => $this->input->post("idtipo_parada"),
            "inicio_parada" => $this->input->post("inicio"),
            "fim_parada" => $this->input->post("fim")
          );

          $this->Parada_Model->update($dados);

          // RETORNA A MENSAGEM
          $this->session->set_flashdata([
            'class' => 'success',
            'content' => 'Dados da Parada atualizados com sucesso'
          ]);
        }else{
          // RETORNA A MENSAGEM
          $this->session->set_flashdata([
            'class' => 'warning',
            'content' => 'Data início da parada é maior ou igual a data final.<br>Informe um período válido.'
          ]);        
           
        }      
           
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

    redirect("operacao/trem/".$idtrem);
    
  }

  public function delete(){
    
    $idtrem = $this->input->post("idtrem");
    
    if($this->input->post()){

      if($this->validar_formulario("delete")){
        
          $dados = array("idparada" => $this->input->post("idparada"));

          $this->Parada_Model->delete($dados);

          // RETORNA A MENSAGEM
          $this->session->set_flashdata([
            'class' => 'success',
            'content' => 'Dados excluídos com sucesso'
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

    redirect("operacao/trem/".$idtrem);
    
  }

  public function checar_datas(){
    if($this->input->post("inicio") >= $this->input->post("fim")){
      return false;
    }else{
      return true;
    }
  }

  public function validar_formulario($tipo){
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

    return $this->form_validation->run();
  }

}

