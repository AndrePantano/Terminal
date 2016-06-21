<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operacao extends CI_Controller {

  public function __construct(){  

    parent::__construct();  
    $this->load->model("Trem_Model");
    $this->load->model("Operacao_Model");
    
  }
  
  public function trem($id){
    
    $dados = array();
    // CARREGA O TREM
    $trem = $this->Trem_Model->trem($id);
    
    if($trem){
      
      // CARREGA AS OPERAÇÕES
      $this->load->model("Operacao_Model");
      $operacoes = $this->Operacao_Model->query("SELECT * FROM tb_operacao WHERE idtrem = ".$trem["idtrem"]);

      // CARREGA OS TIPOS DE PARADAS
      $this->load->model("TipoParada_Model");
      $tipos_paradas = $this->TipoParada_Model->all();

      // CARREGA AS PARADAS DAS OPERAÇÕES
      $this->load->model("Parada_Model");
      foreach ($operacoes as $k => $operacao) {
        $str_query = "SELECT *, DATE_FORMAT(TIMEDIFF(fim_parada,inicio_parada),'%H:%i') as duracao FROM tb_parada JOIN tb_tipo_parada USING(idtipo_parada) WHERE idoperacao = ".$operacao["idoperacao"];
        $operacoes[$k]["paradas"] = $this->Parada_Model->query($str_query);
      }

      $dados = array(
        "main" => array("name" => "Trem ".$trem["prefixo_trem"],"icon" => "fa fa-train"),
        "trem" => $trem,
        "operacoes" => $operacoes,
        "tipos_paradas" => $tipos_paradas
      );

      $this->load->view('operacao/trem',$dados);

    }else{
      $dados["heading"] = "Registro Inexistente.";
      $dados["message"] = "Este registro não se encontra em nossa base de dados!";
      $this->load->view('errors/cli/error_404',$dados);
    }   
    
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
          'content' => 'Operação adicionada com sucesso'
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

  public function delete(){
    
    $idtrem = $this->input->post("idtrem");
    
    if($this->input->post()){

      // VALIDA O FORMULÁRIO
      if($this->validar_formulario_delete()){
        
        // INSERE A PREVISAO COM A DATA PASSADA
        $idoperacao = $this->input->post("idoperacao");

        
        $this->load->model("Parada_Model");
        $this->Parada_Model->delete('idoperacao',$idoperacao);
        
        $this->load->model("Operacao_Model");
        $dados = array("idoperacao" => $idoperacao);
        $this->Operacao_Model->delete($dados);

        // RETORNA A MENSAGEM
        $this->session->set_flashdata([
          'class' => 'success',
          'content' => 'Operação excluída com sucesso'
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

  public function validar_formulario(){
    $this->form_validation->set_rules('idtrem','Id do Trem','required');    
    $this->form_validation->set_rules('quantidade','Quantidade de Vagões','required');    
    return $this->form_validation->run();
  }

  public function validar_formulario_update(){
    $this->form_validation->set_rules('idoperacao','Id da Operacao','required');    
    $this->form_validation->set_rules('idtrem','Id do Trem','required');    
    $this->form_validation->set_rules('quantidade','Quantidade de Vagões','required');    
    return $this->form_validation->run();
  }

  public function validar_formulario_delete(){
    $this->form_validation->set_rules('idoperacao','Id da Operacao','required');    
    $this->form_validation->set_rules('idtrem','Id do Trem','required');    
    return $this->form_validation->run();
  }

}

