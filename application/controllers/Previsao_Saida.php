<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Previsao_Saida extends CI_Controller {

  private $main = array();

  public function __construct(){  

    parent::__construct();  

    $this->load->model("Previsao_Saida_Model");
    $this->load->model("Trem_Model");
    
  }
  
  public function delete(){
    
    $this->validar_formulario('delete');

    $idtrem = $this->input->post("idtrem");
        
    $dados = array("idprevisao" => $this->input->post("idprevisao"));

    $this->Previsao_Saida_Model->delete($dados);

    $this->session->set_flashdata([
      'class' => 'success',
      'content' => 'Previsão excluída com sucesso'
    ]);        
           
    $this->redireciona($idtrem);
    
  }

  public function update(){
    
    $this->validar_formulario('update');
    
    $idtrem = $this->input->post("idtrem");

    $previsao = array(
      "idtrem" => $idtrem,
      "idprevisao" => $this->input->post("idprevisao"),
      "data_previsao" => $this->input->post("previsao"),
      "motivo_previsao" => $this->input->post("motivo")
    );
    
    $this->Previsao_Saida_Model->update($previsao);

    $this->session->set_flashdata([
      'class' => 'success',
      'content' => 'Previsão atualizada com sucesso'
    ]);        
  
    $this->redireciona($idtrem);
    
  }
  public function create(){
    
    $this->validar_formulario('create');
    
    $idtrem = $this->input->post("idtrem");

    $previsao = array(
      "idtrem" => $idtrem,
      "criacao_previsao" => date("Y-m-d H:i"),
      "data_previsao" => $this->input->post("previsao"),
      "motivo_previsao" => $this->input->post("motivo")
    );
    
    $this->Previsao_Saida_Model->create($previsao);

    // RETORNA A MENSAGEM
    $this->session->set_flashdata([
      'class' => 'success',
      'content' => 'Previsão adicionada com sucesso'
    ]);        
       
    $this->redireciona($idtrem);
    
  }

  public function trem($id){
    
    $trem = $this->Trem_Model->trem($id);
    
    if($trem){

      $previsoes_saida = $this->Previsao_Saida_Model->previsoes_saida("idtrem",$trem["idtrem"]);
     
      $dados = array(
        "main" => array("name" => "Trem ".$trem["prefixo_trem"],"icon" => "fa fa-train"),
        "trem" => $trem,
        "previsoes_saida" => $previsoes_saida
      );

      $this->load->view('previsao_saida/trem',$dados);

    }else{

      $dados["heading"] = "Registro Inexistente.";
      $dados["message"] = "Este registro não se encontra em nossa base de dados!";
      $this->load->view('errors/cli/error_404',$dados);
      redirect("/");
    }

  }

  public function check_post(){
    if(!$this->input->post()){
      $this->session->set_flashdata([
        'class' => 'danger',
        'content' => 'Nenhum formulário foi recebido!'
      ]); 
      $this->redireciona($idtrem);
    }
  }

  public function validar_formulario($tipo){

    // VERIFICA SE HOUVE UM POST
    $this->check_post();

    switch ($tipo) {
      case 'create':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('previsao','Previsão','required');   
        $this->form_validation->set_rules('motivo','Motivo','required');   
        break;
      case 'update':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('previsao','Previsão','required');   
        $this->form_validation->set_rules('motivo','Motivo','required'); 
        break;
      case 'delete':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('idprevisao','previsao','required'); 
        break;
    }

    if(!$this->form_validation->run()){

      $this->session->set_flashdata([
        'class' => 'danger',
        'content' => 'Ocorreum erro na validação dos dados.<br/>'.validation_errors()
      ]);

      $this->redireciona($this->input->post("idtrem"));
    }
  }

  public function redireciona($idtrem){
    redirect("previsao_saida/trem/".$idtrem);
  }
}

