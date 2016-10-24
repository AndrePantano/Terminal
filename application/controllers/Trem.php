<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trem extends CI_Controller {

  private $main = array();

  public function __construct(){  

    parent::__construct(); 

    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario")){
      redirect("auth/entrar");
    } 

    $this->load->model("Trem_Model");
    $this->load->model("Message_Model");    
  }
    
  public function insert(){
        
    $dados = array(
      "main" => array("name" => "Adicionar Trem","icon" => "fa fa-train"),
    );
    
    // CARREGA A VIEW
    $this->load->view('trem/insert',$dados);
  }
  
  public function trem($id){
    
    $dados = array();
    // CARREGA O TREM
    $trem = $this->Trem_Model->trem($id);
    
    if($trem){
      // CARREGA AS PREVISOES
      $this->load->model("Previsao_Chegada_Model");
      $previsoes = $this->Previsao_Chegada_Model->previsoes_chegada("idtrem",$trem["idtrem"]);

      $dados = array(
        "main" => array("name" => "Trem ".$trem["prefixo_trem"],"icon" => "fa fa-train"),
        "trem" => $trem,
        "previsoes" => $previsoes
      );

      return $this->load->view('trem/trem',$dados);

    }else{
      $this->Message_Model->trem_inexistente();      
    }    
  }

  public function create(){
    
    $this->validar_formulario('create');
    
    // PREPARA OS ARRAY DE DADOS
    $dados = $this->montar_dados();

    // CRIA O REGISTRO
    $this->Trem_Model->create($dados);

    // RETORNA O ID DO REGISTRO CRIADO
    $idtrem = $this->db->insert_id();

    // INSERE A OPERAÇÃO
    $operacao = array(
      "idtrem" => $idtrem,
      "qtd_vagoes" => $this->input->post("quantidade"),
      "idusuario" => $this->session->userdata("idusuario"),
      "criado_em" => date("Y-m-d H:i:s"),
    );
    $this->load->model("Operacao_Model");
    $this->Operacao_Model->create($operacao);
    
    // INSERE A PREVISAO
    $previsao_chegada = array(
      "idtrem" => $idtrem,
      "data_previsao" => $this->input->post("previsao"),
      "motivo_previsao" => "Primeiro Lançamento",
      "idusuario" => $this->session->userdata("idusuario"),
      "criado_em" => date("Y-m-d H:i:s"),
    );
    $this->load->model("Previsao_Chegada_Model");
    $this->Previsao_Chegada_Model->create($previsao_chegada);

    // RETORNA A MENSAGEM
    $this->Message_Model->message('success','Trem cadastrado com sucesso');
    
    $this->redireciona($idtrem);
  }

  public function update(){

    $this->validar_formulario('update');

    $dados = $this->montar_dados();

    $this->Trem_Model->update($dados);
    
    $this->Message_Model->message('success','Dados atualizados com sucesso');
          
    $this->redireciona($this->input->post("idtrem"));
  }

  public function montar_dados(){

    $chegada = $partida = null;

    if($this->input->post("chegada") != "") $chegada = date("Y-m-d H:i:s", strtotime($this->input->post("chegada")));
    if($this->input->post("partida") != "") $partida = date("Y-m-d H:i:s", strtotime($this->input->post("partida")));

    $dados = array(
      "prefixo_trem" => strtoupper($this->input->post("trem")),
      "chegada_trem" => $chegada,
      "partida_trem" => $partida,
      "idusuario" => $this->session->userdata("idusuario"),
      "idterminal" => $this->session->userdata("idterminal")
    );
    
    if($this->input->post("idtrem")){
      $dados["idtrem"] = $this->input->post("idtrem");
      $dados["atualizado_em"] = date("Y-m-d H:i:s");
    }else{
      $dados["criado_em"] = date("Y-m-d H:i:s");
    }

    return $dados;
  }

  public function delete(){

    $this->validar_formulario('delete');
        
    $idtrem = $this->input->post("idtrem");

    // EXCLUI AS AVARIAS DE CONTEINERS
    $this->load->model("Avaria_Conteiner_Model");
    $dados = array("idtrem" => $idtrem);
    $this->Avaria_Conteiner_Model->delete($dados);

    // EXCLUI AS AVARIAS DE VAGAO
    $this->load->model("Avaria_Vagao_Model");
    $dados = array("idtrem" => $idtrem);
    $this->Avaria_Vagao_Model->delete($dados);

    // EXCLUI AS NOTAS DE ATIVIDADES
    $this->load->model("Nota_Model");
    $dados = array("idtrem" => $idtrem);
    $this->Nota_Model->delete($dados);

    // EXCLUI AS PREVISOES DE CHEGADA
    $this->load->model("Previsao_Chegada_Model");
    $dados = array("idtrem" => $idtrem);
    $this->Previsao_Chegada_Model->delete($dados);

    // SELECIONA TODAS AS OPERAÇÕES
    $this->load->model("Operacao_Model");        
    $operacoes = $this->Operacao_Model->operacoes("idtrem ",$idtrem);
    
    // EXCLUI AS PARADAS DAS OPERAÇÕES
    $this->load->model("Parada_Model");
    foreach($operacoes as $operacao){
      $dados = array("idoperacao" => $operacao["idoperacao"]);
      $this->Parada_Model->delete($dados);
    }

    // EXCLUI AS OPERAÇÕES
    $dados = array("idtrem" => $idtrem);
    $this->Operacao_Model->delete($dados);

    // EXCLUI O TREM
    $this->Trem_Model->delete($dados);
         
    // RETORNA A MENSAGEM
    $this->Message_Model->message('success','Trem excluído com sucesso');

    redirect("/");
  }

  public function redireciona($idtrem){
    
    redirect("trem/trem/".$idtrem);
  }

  public function check_post(){
    if(!$this->input->post()){
      $this->Message_Model->message('danger','Nenhum formulário foi recebido!'); 
      redirect("/");
    }
  }

  public function validar_formulario($tipo){

    // VERIFICA SE HOUVE UM POST
    $this->check_post();

    switch ($tipo) {
      case 'create':
        $this->form_validation->set_rules('trem','Trem','required|min_length[3]|max_length[3]');    
        $this->form_validation->set_rules('quantidade','Quantidade de Vagões','required|min_length[1]|max_length[3]|greater_than[0]|less_than[999]');   
        $this->form_validation->set_rules('previsao','Previsão de Chegada','required');       
        break;
      case 'update':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        break;
      case 'delete':
        $this->form_validation->set_rules('idtrem','Trem','required|min_length[3]|max_length[3]');    
        break;
    }

    if(!$this->form_validation->run()){

      $this->Message_Model->message('danger','Ocorreum erro na validação dos dados.<br/>'.validation_errors());

      redirect("/");
    }
  }

}

