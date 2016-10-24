<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operacao extends CI_Controller {

  public function __construct(){  

    parent::__construct();

    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario")){
      redirect("auth/entrar");
    }
    
    $this->load->model("Trem_Model");
    $this->load->model("Operacao_Model");
    $this->load->model("Message_Model");
    
  }
  
  public function trem($id){
    
    $dados = array();
    
    $trem = $this->Trem_Model->trem($id);
    
    if($trem){
      
      // CARREGA AS OPERAÇÕES
      $operacoes = $this->Operacao_Model->operacoes("idtrem",$trem["idtrem"]);

      // CARREGA OS TIPOS DE PARADAS
      $this->load->model("TipoParada_Model");
      $tipos_paradas = $this->TipoParada_Model->all();

      // CARREGA AS PARADAS DAS OPERAÇÕES
      $this->load->model("Parada_Model");
      $qtd_vagoes = 0;
      foreach ($operacoes as $k => $operacao) {
        $operacoes[$k]["paradas"] = $this->Parada_Model->paradas("idoperacao",$operacao["idoperacao"]);
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
     $this->Message_Model->trem_inexistente();
    }   
    
  }

  public function create(){
    
    $this->validar_formulario('create');

    $this->atualizar_quantidade_vagoes();
          
    $dados = $this->montar_dados();

    $this->Operacao_Model->create($dados);

    $this->Message_Model->message('success','Operação adicionada com sucesso');
    
    $this->redireciona();
    
  }

  public function update(){
    
    $this->validar_formulario('update');
        
    $dados = $this->montar_dados();

    $this->Operacao_Model->update($dados);

    $this->Message_Model->message('success','Operação atualizada com sucesso');
           
    $this->redireciona();
    
  }

  public function delete(){
    
    $this->validar_formulario('delete');
        
    $idoperacao = $this->input->post("idoperacao");
    
    $this->load->model("Parada_Model");
    $this->Parada_Model->delete('idoperacao',$idoperacao);
    
    $dados = array("idoperacao" => $idoperacao);
    $this->Operacao_Model->delete($dados);

    $this->Message_Model->message('success','Operação excluída com sucesso');
    
    $this->redireciona();
    
  }

  public function checar_post(){
    
    if(!$this->input->post()){
      $this->Message_Model->message('danger','É preciso preencher o formulário para criar uma previsão'); 
      $this->redireciona();
    }

  }

  public function validar_formulario($tipo){

    $this->checar_post();

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

    if(!$this->form_validation->run()){
      // RETORNA O ERRO
      $this->Message_Model->message('danger','Ocorreum erro na validação dos dados.<br/>'.validation_errors());
      $this->redireciona();
    }
  }  


  public function atualizar_quantidade_vagoes(){

    // VERIFICA A QUANTIDADE DE OPERAÇOES
    $operacoes = $this->Operacao_Model->operacoes("idtrem",$this->input->post("idtrem"));

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
        $this->Message_Model->message('danger','A quantidade de vagões da linha 2 é superior a capacidade inicial.');
         $this->redireciona();
      }  
    }else{
      $this->Message_Model->message('danger','A quantidade máxima de operações por trem já foi atingida.');
      $this->redireciona();
    }
  }

  public function montar_dados(){

    $dados = array(
      "idtrem" => $this->input->post("idtrem"),
      "qtd_vagoes" => $this->input->post("quantidade"),
      "encoste_linha" => null,
      "inicio_operacao" => null,
      "termino_operacao" => null,
      "envio_manifesto" => null,
      "faturamento_all" => null,
      "idusuario" => $this->session->userdata("idusuario")
    );

    if($this->input->post("encoste")!=""){ $dados["encoste_linha"] = $this->input->post("encoste");}
    if($this->input->post("inicio")!=""){ $dados["inicio_operacao"] = $this->input->post("inicio");}
    if($this->input->post("termino")!=""){ $dados["termino_operacao"] = $this->input->post("termino");}
    if($this->input->post("manifesto")!=""){ $dados["envio_manifesto"] = $this->input->post("manifesto");}
    if($this->input->post("all")!=""){ $dados["faturamento_all"] = $this->input->post("all");}
    
    if($this->input->post("idoperacao")){
      $dados["idoperacao"] = $this->input->post("idoperacao");
      $dados["atualizado_em"] = date("Y-m-d H:i:s");
    }else{
      $dados["criado_em"] = date("Y-m-d H:i:s");
    }

    return $dados;
  }

  public function redireciona(){
    
    redirect("operacao/trem/".$this->input->post("idtrem"));
  }
}

