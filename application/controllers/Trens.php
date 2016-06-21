<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trens extends CI_Controller {

  private $main = array();

  public function __construct(){  

    parent::__construct();  

    $this->load->model("Trem_Model");    
  }
  
  public function em_transito(){
    
    // RETORNA TODOS OS DADOS CADASTRADOS
    $trens = null;
    $query = $this->Trem_Model->em_transito();
    
    if($query)
      $trens = $query;
    
    $dados = array(
      "main" => array("name" => "Trens em Trânsito","icon" => "fa fa-train"),
      "trens" => $trens
    );

    // CARREGA A VIEW
    $this->load->view('trens/em_transito',$dados);
  }

  public function em_operacao(){
    
    // RETORNA TODOS OS DADOS CADASTRADOS
    $trens = null;
    $query = $this->Trem_Model->em_operacao();
    
    if($query)
      $trens = $query;
    
    $dados = array(      
      "main" => array("name" => "Trens em Operação","icon" => "fa fa-train"),
      "trens" => $trens
    );
    
    // CARREGA A VIEW
    $this->load->view('trens/em_operacao',$dados);

  }
  public function operados(){
    
    // RETORNA TODOS OS DADOS CADASTRADOS
    $trens = null;
    $query = $this->Trem_Model->operados();
    
    if($query)
      $trens = $query;
    
    $dados = array(
      "main" => array("name" => "Trens Operados","icon" => "fa fa-train"),
      "trens" => $trens
    );
    
    // CARREGA A VIEW
    $this->load->view('trens/operados',$dados);
  }
  
  public function insert(){
        
    $dados = array(
      "main" => array("name" => "Adicionar Trem","icon" => "fa fa-train"),
    );
    
    // CARREGA A VIEW
    $this->load->view('trem/insert',$dados);
  }
  
  public function create(){
    
    // SE NÃO HOUVER POST REDIRECIONA PARA O INSERT
    if($this->input->post()){

      // VALIDA O FORMULÁRIO
      if($this->validar_formulario('create')){
        
        // INSERE O TREM E PEGA O SEU ID
        $trem = array("prefixo_trem" => strtoupper($this->input->post("trem")));
        $this->load->model("Trem_Model");
        $this->Trem_Model->create($trem);
        $idtrem = $this->db->insert_id();

        // INSERE A OPERAÇÃO COM AS QUANTIDADES DE VAGÕES
        $operacao = array(
          "idtrem" => $idtrem,
          "qtd_vagoes" => $this->input->post("quantidade")
        );

        $this->load->model("Operacao_Model");
        $this->Operacao_Model->create($operacao);
        
        // INSERE A PREVISAO COM A DATA PASSADA
        $previsao = array(
          "idtrem" => $idtrem,
          "criacao_previsao" => date("Y-m-d H:i"),
          "data_previsao" => $this->input->post("previsao"),
          "motivo_previsao" => "Primeiro Lançamento"
        );
        $this->load->model("Previsao_Model");
        $this->Previsao_Model->create($previsao);

        // RETORNA A MENSAGEM
        $this->session->set_flashdata([
          'class' => 'success',
          'content' => 'Trem cadastrado com sucesso'
        ]);
          
        redirect("trens/trem/".$idtrem);
     
      }else{
        
        // RETORNA O ERRO
        $this->session->set_flashdata([
          'class' => 'danger',
          'content' => 'Ocorreum erro na validação dos dados.<br/>'.validation_errors()
        ]);
        
        return redirect("/");
      }
    
    }else{
      // RETORNA O ERRO
      $this->session->set_flashdata([
        'class' => 'danger',
        'content' => 'É preciso preencher o formulário para criar um anúncio'
      ]); 

      return redirect("/");
    }
  }

  public function trem($id){
    
    $dados = array();
    // CARREGA O TREM
    $trem = $this->Trem_Model->trem($id);
    
    if($trem){
      // CARREGA AS PREVISOES
      $this->load->model("Previsao_Model");
      $previsoes = $this->Previsao_Model->query("SELECT * FROM tb_previsao WHERE idtrem = ".$trem["idtrem"]);

      $dados = array(
        "main" => array("name" => "Trem ".$trem["prefixo_trem"],"icon" => "fa fa-train"),
        "trem" => $trem,
        "previsoes" => $previsoes
      );

      return $this->load->view('trens/trem',$dados);

    }else{
      $dados["heading"] = "Registro Inexistente.";
      $dados["message"] = "Este registro não se encontra em nossa base de dados!";
      $this->load->view('errors/cli/error_404',$dados);
    }    
  }

  public function update(){

    // SE NÃO HOUVER POST REDIRECIONA PARA O INSERT

    if($this->input->post()){
      

      // VALIDA O FORMULÁRIO
      if($this->validar_formulario('update')){
        
        $chegada = $partida = null;

        if($this->input->post("chegada") != "") $chegada = date("Y-m-d H:i:s", strtotime($this->input->post("chegada")));
        if($this->input->post("partida") != "") $partida = date("Y-m-d H:i:s", strtotime($this->input->post("partida")));

        // INSERE O TREM E PEGA O SEU ID
        $dados = array(
          "idtrem" => $this->input->post("idtrem"),
          "prefixo_trem" => strtoupper($this->input->post("trem")),
          "chegada_trem" => $chegada,
          "partida_trem" => $partida,
        );

        $this->load->model("Trem_Model");
        $this->Trem_Model->update($dados);
      
        // RETORNA A MENSAGEM
        $this->session->set_flashdata([
          'class' => 'success',
          'content' => 'Dados atualizados com sucesso'
        ]);
          
        redirect("trens/trem/".$dados["idtrem"]);
     
      }else{
        
        // RETORNA O ERRO
        $this->session->set_flashdata([
          'class' => 'danger',
          'content' => 'Ocorreum erro na validação dos dados.<br/>'.validation_errors()
        ]);
        
        redirect("/");
      }
    
    }else{
      // RETORNA O ERRO
      $this->session->set_flashdata([
        'class' => 'danger',
        'content' => 'Nenhum formulário foi recebido!'
      ]); 

      redirect("/");
    }
  }

  public function delete(){

    if($this->input->post()){

      if($this->validar_formulario('delete')){
        
        $idtrem = $this->input->post("idtrem");

        // EXCLUI AS NOTAS DE ATIVIDADES
        $this->load->model("Nota_Model");
        $dados = array("idtrem" => $idtrem);
        $this->Nota_Model->delete($dados);

        // EXCLUI AS PREVISOES DE CHEGADA
        $this->load->model("Previsao_Model");
        $dados = array("idtrem" => $idtrem);
        $this->Previsao_Model->delete($dados);

        // SELECIONA TODAS AS OPERAÇÕES
        $this->load->model("Operacao_Model");        
        $operacoes = $this->Operacao_Model->query("SELECT * FROM tb_operacao WHERE idtrem =".$idtrem);
        
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
        $this->session->set_flashdata([
          'class' => 'success',
          'content' => 'Trem excluído com sucesso'
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
        'content' => 'Nenhum formulário foi recebido!'
      ]); 

    }
    
    redirect("/");

  }

  public function validar_formulario($tipo){
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
    return $this->form_validation->run();
  }

}

