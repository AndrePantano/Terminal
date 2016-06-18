<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operacao extends CI_Controller {

  public function __construct(){  

    parent::__construct();  

    $this->load->model("Operacao_Model");
    
  }
     
  public function create(){
    
    $idtrem = $this->input->post("idtrem");
    
    if($this->input->post()){

      // VALIDA O FORMULÁRIO
      if($this->validar_formulario()){
        
        // INSERE A PREVISAO COM A DATA PASSADA
        $operacao = array(
          "idtrem" => $idtrem,
          "qtd_vagoes" => $this->input->post("quantidade"),
          "numero_linha" => 2,
          "encoste_linha" => null,
          "inicio_operacao" => null,
          "termino_operacao" => null,
          "envio_manifesto" => null,
          "faturamento_all" => null
        );

        if(!empty($this->input->post("encoste"))){ $operacao["encoste_linha"] = $this->input->post("encoste");}
        if(!empty($this->input->post("inicio"))){ $operacao["inicio_operacao"] = $this->input->post("inicio");}
        if(!empty($this->input->post("termino"))){ $operacao["termino_operacao"] = $this->input->post("termino");}
        if(!empty($this->input->post("manifesto"))){ $operacao["envio_manifesto"] = $this->input->post("manifesto");}
        if(!empty($this->input->post("all"))){ $operacao["faturamento_all"] = $this->input->post("all");}

        //echo"<pre>".print_r($operacao,1)."</pre>";

        $this->load->model("Operacao_Model");
        $this->Operacao_Model->create($operacao);

        // RETORNA A MENSAGEM
        $this->session->set_flashdata([
          'class' => 'success',
          'title' => 'Parabéns!',
          'content' => 'Operação adicionada com sucesso'
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

   public function update(){
    
    $idtrem = $this->input->post("idtrem");
    
    if($this->input->post()){

      // VALIDA O FORMULÁRIO
      if($this->validar_formulario_update()){
        
        // INSERE A PREVISAO COM A DATA PASSADA
        $operacao = array(
          "idoperacao" =>  $this->input->post("idoperacao"),
          "idtrem" => $idtrem,
          "qtd_vagoes" => $this->input->post("quantidade"),
          "numero_linha" =>  $this->input->post("linha"),
          "encoste_linha" => null,
          "inicio_operacao" => null,
          "termino_operacao" => null,
          "envio_manifesto" => null,
          "faturamento_all" => null
        );

        if(!empty($this->input->post("encoste"))){ $operacao["encoste_linha"] = $this->input->post("encoste");}
        if(!empty($this->input->post("inicio"))){ $operacao["inicio_operacao"] = $this->input->post("inicio");}
        if(!empty($this->input->post("termino"))){ $operacao["termino_operacao"] = $this->input->post("termino");}
        if(!empty($this->input->post("manifesto"))){ $operacao["envio_manifesto"] = $this->input->post("manifesto");}
        if(!empty($this->input->post("all"))){ $operacao["faturamento_all"] = $this->input->post("all");}

        //echo"<pre>".print_r($operacao,1)."</pre>";

        $this->load->model("Operacao_Model");
        $this->Operacao_Model->update($operacao);

        // RETORNA A MENSAGEM
        $this->session->set_flashdata([
          'class' => 'success',
          'title' => 'Parabéns!',
          'content' => 'Operação atualizada com sucesso'
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
    $this->form_validation->set_rules('idtrem','Id do Trem','required');    
    $this->form_validation->set_rules('linha','Número da Linha','required');    
    $this->form_validation->set_rules('quantidade','Quantidade de Vagões','required');    
    return $this->form_validation->run();
  }

  public function validar_formulario_update(){
    $this->form_validation->set_rules('idoperacao','Id da Operacao','required');    
    $this->form_validation->set_rules('idtrem','Id do Trem','required');    
    $this->form_validation->set_rules('linha','Número da Linha','required');    
    $this->form_validation->set_rules('quantidade','Quantidade de Vagões','required');    
    return $this->form_validation->run();
  }

}

