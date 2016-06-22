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
      $operacoes = $this->Operacao_Model->operacoes("idtrem",$trem["idtrem"]);

      // CARREGA OS TIPOS DE PARADAS
      $this->load->model("TipoParada_Model");
      $tipos_paradas = $this->TipoParada_Model->all();

      // CARREGA AS PARADAS DAS OPERAÇÕES
      $this->load->model("Parada_Model");
      $qtd_vagoes = 0;
      foreach ($operacoes as $k => $operacao) {
        $str_query = "SELECT *, DATE_FORMAT(TIMEDIFF(fim_parada,inicio_parada),'%H:%i') as duracao FROM tb_parada JOIN tb_tipo_parada USING(idtipo_parada) WHERE idoperacao = ".$operacao["idoperacao"];
        $operacoes[$k]["paradas"] = $this->Parada_Model->query($str_query);
        $qtd_vagoes += $operacao["qtd_vagoes"];
      }

      $dados = array(
        "main" => array("name" => "Trem ".$trem["prefixo_trem"],"icon" => "fa fa-train"),
        "trem" => $trem,
        "operacoes" => $operacoes,
        "tipos_paradas" => $tipos_paradas,
        "qtd_vagoes" => $qtd_vagoes
      );

      $this->load->view('operacao/trem',$dados);

    }else{
      $dados["heading"] = "Registro Inexistente.";
      $dados["message"] = "Este registro não se encontra em nossa base de dados!";
      $this->load->view('errors/cli/error_404',$dados);
    }   
    
  }

  public function create(){
    
    if($this->checar_post()){

      $idtrem = $this->input->post("idtrem");

      if($this->validar_formulario('create')){

        if ($this->atualizar_quantidade_vagoes($idtrem)) {
          
          // MONTA O ARRAY DE DADOS
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

          $this->Operacao_Model->create($operacao);

          // RETORNA A MENSAGEM
          $this->session->set_flashdata(['class' => 'success','content' => 'Operação adicionada com sucesso']);
        }
      }
      redirect("operacao/trem/".$idtrem);
    }
    
  }

  public function update(){
    
    if($this->checar_post()){

      $idtrem = $this->input->post("idtrem");
      
      if($this->validar_formulario('update')){
        
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

        $this->Operacao_Model->update($operacao);

        // RETORNA A MENSAGEM
        $this->session->set_flashdata([
          'class' => 'success',
          'content' => 'Operação atualizada com sucesso'
        ]);        
           
      }
      
      redirect("operacao/trem/".$idtrem);

    }
    
  }

  public function delete(){
    
    if($this->checar_post()){
    
      $idtrem = $this->input->post("idtrem");

      if($this->validar_formulario('delete')){
        
        $idoperacao = $this->input->post("idoperacao");
        
        $this->load->model("Parada_Model");
        $this->Parada_Model->delete('idoperacao',$idoperacao);
        
        $dados = array("idoperacao" => $idoperacao);
        $this->Operacao_Model->delete($dados);

        // RETORNA A MENSAGEM
        $this->session->set_flashdata(['class' => 'success','content' => 'Operação excluída com sucesso']);        
           
      }
    
      redirect("operacao/trem/".$idtrem);

    }
    
  }

  public function checar_post(){
    
    if($this->input->post()){
      return true;
    }else{
      $this->session->set_flashdata([
        'class' => 'danger',
        'content' => 'É preciso preencher o formulário para criar uma previsão'
      ]); 
      return false;
    }

  }

  public function validar_formulario($tipo){
    switch ($tipo) {
      case 'create':
        $this->form_validation->set_rules('idtrem','Id do Trem','required');    
        $this->form_validation->set_rules('quantidade','Quantidade de Vagões','required');    
        break;
      case 'update':
        $this->form_validation->set_rules('idoperacao','Id da Operacao','required');    
        $this->form_validation->set_rules('idtrem','Id do Trem','required');    
        $this->form_validation->set_rules('quantidade','Quantidade de Vagões','required');    
        break;
      case 'delete':
        $this->form_validation->set_rules('idoperacao','Id da Operacao','required');    
        $this->form_validation->set_rules('idtrem','Id do Trem','required');    
        break;
    }

    if($this->form_validation->run()){

      return true;

    }else{
        
      // RETORNA O ERRO
      $this->session->set_flashdata([
        'class' => 'danger',
        'content' => 'Ocorreum erro na validação dos dados.<br/>'.validation_errors()
      ]);

      return false;
    }
  }  


  public function atualizar_quantidade_vagoes($idtrem){

    // VERIFICA A QUANTIDADE DE OPERAÇOES
    $operacoes = $this->Operacao_Model->operacoes("idtrem",$idtrem);

    if ($operacoes && count($operacoes) < 2) {
      
      // VERIFICA SE O QUANTIDADE DE VAGÕES É MAIOR QUE O ATUAL
      if($this->input->post("quantidade") <= $operacoes[0]["qtd_vagoes"]){
        
        $operacao_anterior = array(
          "idoperacao" =>  $operacoes[0]["idoperacao"],
          "qtd_vagoes" => $operacoes[0]["qtd_vagoes"] - $this->input->post("quantidade")
        );
        
        // ATUALIZA A QUANTIDADE DE VAGOES DA OPERAÇÃO ANTERIOR
        $this->Operacao_Model->update($operacao_anterior);
        
        return true;

      }else{

        $this->session->set_flashdata([
          'class' => 'danger',
          'content' => 'A quantidade de vagões da linha 2 é superior a capacidade inicial.'
        ]);

        return false;

      }  

    }else{

      $this->session->set_flashdata([
        'class' => 'danger',
        'content' => 'A quantidade máxima de operações por trem já foi atingida.'
      ]);

      return false;

    }
  }

}

