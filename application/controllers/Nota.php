<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nota extends CI_Controller {

  public function __construct(){  

    parent::__construct();  

    $this->load->model("Trem_Model");
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
          'content' => 'Nota adicionada com sucesso'
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
        'content' => 'É preciso preencher o formulário para criar uma nota'
      ]); 

    }

    redirect("nota/trem/".$idtrem);
    
  }

  public function update(){
    
    $idtrem = $this->input->post("idtrem");
    
    if($this->input->post()){

      // VALIDA O FORMULÁRIO
      if($this->validar_formulario_update()){
        

        // INSERE A PREVISAO COM A DATA PASSADA
        $nota = array(
          "idnota" => $this->input->post("idnota"),
          "criacao_nota" => date("Y-m-d H:i:s"),
          "texto_nota" => $this->input->post("texto")
        );
        
        $this->Nota_Model->update($nota);

        // RETORNA A MENSAGEM
        $this->session->set_flashdata([
          'class' => 'success',
          'content' => 'Nota editada com sucesso'
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
        'content' => 'É preciso preencher o formulário para criar uma nota'
      ]); 

    }

    redirect("nota/trem/".$idtrem);
    
  }

  public function delete(){
    
    $idtrem = $this->input->post("idtrem");
    
    if($this->input->post()){

      if($this->validar_formulario_delete()){
        
        $dados = array("idnota" => $this->input->post("idnota"));
        
        $this->Nota_Model->delete($dados);

        // RETORNA A MENSAGEM
        $this->session->set_flashdata([
          'class' => 'success',
          'content' => 'Nota excluída com sucesso'
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
        'content' => 'É preciso preencher o formulário para criar uma nota'
      ]); 

    }

    redirect("nota/trem/".$idtrem);
    
  }

  public function validar_formulario(){
    $this->form_validation->set_rules('idtrem','Trem','required');    
    $this->form_validation->set_rules('texto','Texto','required');       
    return $this->form_validation->run();
  }

  public function validar_formulario_update(){
    $this->form_validation->set_rules('idtrem','Trem','required');    
    $this->form_validation->set_rules('idnota','Nota','required');    
    $this->form_validation->set_rules('texto','Texto','required');       
    return $this->form_validation->run();
  }
 
  public function validar_formulario_delete(){
    $this->form_validation->set_rules('idtrem','Trem','required');    
    $this->form_validation->set_rules('idnota','Nota','required');    
    return $this->form_validation->run();
  }

  public function trem($id){
    
    $dados = array();
    // CARREGA O TREM
    $trem = $this->Trem_Model->trem($id);
    
    if($trem){

      // CARREGA AS NOTAS
      $this->load->model("Nota_Model");
      $notas = $this->Nota_Model->all("idtrem = ".$trem["idtrem"],null);

      $dados = array(
        "main" => array("name" => "Trem ".$trem["prefixo_trem"],"icon" => "fa fa-train"),
        "trem" => $trem,
        "notas" => $notas,
      );
      $this->load->view('nota/trem',$dados);
    }else{
      $dados["heading"] = "Registro Inexistente.";
      $dados["message"] = "Este registro não se encontra em nossa base de dados!";
      $this->load->view('errors/cli/error_404',$dados);
    }   
    
  }

}

