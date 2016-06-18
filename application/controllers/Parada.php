<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parada extends CI_Controller {

  public function __construct(){  

    parent::__construct();  

    $this->load->model("Parada_Model");
    
  }
     
  public function create(){
    
    $idtrem = $this->input->post("idtrem");
    
    if($this->input->post()){

      // VALIDA O FORMULÁRIO
      if($this->validar_formulario(false)){
        
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
          'content' => 'Operação atualizada com sucesso'
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
    if($tipo)
      $this->form_validation->set_rules('idparada','Id da Parada','required');    

    $this->form_validation->set_rules('idtrem','Id do Trem','required');    
    $this->form_validation->set_rules('idoperacao','Id da Operação','required');    
    $this->form_validation->set_rules('idtipo_parada','Tipo de Parada','required');    
    $this->form_validation->set_rules('inicio','Início da Parada','required');    
    $this->form_validation->set_rules('fim','Fim da Parada','required'); 
    return $this->form_validation->run();
  }

}

